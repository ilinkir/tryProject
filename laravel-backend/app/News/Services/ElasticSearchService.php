<?php

namespace App\News\Services;

use App\Models\News;
use Elasticsearch\Client;
//use App\News\Contracts\Services\ElasticSearchService as ElasticSearchContract;
use Ilin\ElasticsearchQueryBuilder\Aggregations\StatsAggregation;
use Ilin\ElasticsearchQueryBuilder\Queries\RangeQuery;
use Ilin\ElasticsearchQueryBuilder\Queries\TermsQuery;
use Ilin\ElasticsearchQueryBuilder\Sorts\Sort;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Ilin\ElasticsearchQueryBuilder\Aggregations\TermsAggregation;
use Ilin\ElasticsearchQueryBuilder\Builder;
use Ilin\ElasticsearchQueryBuilder\Queries\MultiMatchQuery;
use Illuminate\Support\Collection;

class ElasticSearchService
{
    private Client $elasticsearch;
    private News $newsModel;

    private array $filtersMap = ['category_id', 'query', 'year_from', 'year_to'];
    private int $limitAggs = 100;

    public function __construct(Client $elasticsearch, News $news)
    {
        $this->elasticsearch = $elasticsearch;
        $this->newsModel = $news;
    }

    //http://localhost/news/search?brand_id[]=29f71670-4987-43b3-adb4-634eb399ee52&brand_id[]=c17a3365-d5d1-44bc-bce4-25409de4c9e9&category_id=40287f7d-8db2-4040-bb0e-cde308819c37&category_id[]=40287f7d-8db2-4040-bb0e-cde308819c37&category_id[]=40287f7d-8db2-4040-bb0e-cde308819c37&price_from=10&q=Seq
    public function search(Request $request): Collection
    {
        $builder = (new Builder($this->elasticsearch))
            ->index($this->newsModel->getSearchIndex())
            ->from($request->get('from', 1))
            ->size($request->get('limit', 10));

        $builder = $this->buildFilter($builder, $this->prepareFilters($request));
        $builder = $this->buildAggregation($builder);
        $builder = $this->buildSort($builder, $request->get('orderBy', 'sort'), $request->get('direction', 'desc'));

        $data = $builder->search();

        $documents = $this->getDocuments($data);
        $documentsCount = $this->getDocumentsCount($data);
        $aggregations = collect($data['aggregations'])->mapWithKeys(function ($value, $key) {
            return [$key => $value['buckets'] ?? $value];
        });

        return collect(compact('documents','documentsCount','aggregations'));
    }

    public function getAllAggregations()
    {
        $res = (new Builder($this->elasticsearch))
            ->index($this->newsModel->getSearchIndex())
            ->size(0);
        $res = $this->buildAggregation($res)->search();
        return collect($res['aggregations'])->mapWithKeys(function ($bucket, $bucketName) {
            return [$bucketName => $bucket['buckets'] ?? $bucket];
        });
    }

    private function prepareFilters(Request $request): array
    {
        return $request->only($this->filtersMap);
    }

    private function buildFilter(Builder $builder, array $filters): Builder
    {
        foreach ($filters as $key => $value) {
            switch ($key) {
                case 'year_from':
                    $builder->addQuery(RangeQuery::create('year')->gte($value));
                    break;
                case 'year_to':
                    $builder->addQuery(RangeQuery::create('year')->lte($value));
                    break;
                case 'query':
                    $builder->addQuery(MultiMatchQuery::create($value, ['title', 'preview_text', 'text'], 'AUTO'));
                    break;
                default: //brand_id, category_id
                    $builder->addQuery(TermsQuery::create($key, $value));
                    break;
            }
        }

        return $builder;
    }

    private function buildAggregation(Builder $builder): Builder
    {
        return $builder
            ->addAggregation(TermsAggregation::create('categories', 'category_id')->size($this->limitAggs))
            ->addAggregation(StatsAggregation::create('year', 'year'));
    }

    //gt is greater than
    //gte is greater than or equal to
    //lt is less than
    //lte is less than or equal to
    private function buildSort(Builder $builder, string $field, string $direction): ?Builder
    {
        return $builder
            ->addSort(Sort::create($field, $direction));
    }

    private function getDocuments(?array $data): Collection
    {
        if(empty($data['hits']['hits'])){
            return collect();
        }
        return collect($data['hits']['hits'])->map(function ($value) {
            return array_merge($value['_source'], ['id' => $value['_id']], ['_score' => $value['_score']]);
        });
    }

    private function getDocumentsCount(?array $data): ?int
    {
        return $data['hits']['total']['value'] ?? null;
    }

    public function aggs()
    {
        return (new Builder($this->elasticsearch))
            ->index($this->newsModel->getSearchIndex())
            ->size(0)
            ->addAggregation(TermsAggregation::create('categories', 'category_id')->size(2000))
            ->search();
    }

    private function searchOnElasticsearch(?string $query)
    {
        return (new Builder($this->elasticsearch))
            ->index($this->newsModel->getSearchIndex())
            ->size(2000)
            ->addQuery(MultiMatchQuery::create($query, ['name'], 'AUTO'))
            ->search();
    }

    private function filter()
    {
        $brandIds = ['24dec5cd-6aae-47d2-be42-337d2788a0e0', 'fa814b33-75b4-4e6d-a088-b68b30f646c9'];
        return (new Builder($this->elasticsearch))
            ->index($this->newsModel->getSearchIndex())
            ->size(0)
            ->addQuery(TermsQuery::create('brand_id', $brandIds))
            ->addAggregation(TermsAggregation::create('brands', 'brand_id')->size(100))
            ->search();
    }

    private function range()
    {
        return (new Builder($this->elasticsearch))
            ->index($this->newsModel->getSearchIndex())
            ->size(1000)
            ->addQuery(RangeQuery::create('price')->gte(18)->lte(100))
            ->addSort(Sort::create('price', 'asc'))
            ->search();
    }

    private function buildCollection(array $items)
    {
        $ids = Arr::pluck($items['hits']['hits'], '_id');
        $idsOrdered = implode(',', $ids);

        return News::whereIn('id', $ids)->orderByRaw("FIELD(id, $idsOrdered)");
    }
}
