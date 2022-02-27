<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Http\Middleware\TrustHosts;
use App\Http\Resources\News\IndexResource;
use App\Models\Category;
use App\Models\News;
use App\News\Repositories\CategoriesRepository;
use App\News\Repositories\NewsRepository;
use App\News\Services\ElasticSearchService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    private $limit = 10;

    public function index(Request $request,NewsRepository $newsRepository, ElasticSearchService $elasticService)
    {
        $limit = $request->limit ?? $this->limit;

        $data = $newsRepository->paginate($limit);
        $aggs = $elasticService->getAllAggregations();

        $this->bindCategories($aggs);

        $data = [
            'news' => $data->items(),
            'last_page' => $data->lastPage(),
            'per_page' => $data->perPage(),
            'current_page' => $data->currentPage(),
            'has_more_pages' => $data->hasMorePages(),
            'has_pages' => $data->hasPages(),
            'total' => $data->total(),
            'filters' => $aggs,
        ];

        return response()->json($data);
    }

    public function filter(Request $request, ElasticSearchService $elasticService)
    {
        $news = $elasticService->search($request);

        $data = [
            'news' => $news['documents'] ?? '',
            'total' => $news['documentsCount'] ?? '',
            'filters' => $news['aggregations'] ?? '',
        ];

        return response()->json($data);
    }

    private function bindCategories($filters)
    {
        if(isset($filters['categories'])) {
            $categories = app(CategoriesRepository::class)->getAll()->keyBy('id')->toArray();

            $filters['categories'] = array_map(function ($val) use ($categories) {
                return array_merge($val, $categories[$val['key']]);
            }, $filters['categories']);
        }
    }
}
