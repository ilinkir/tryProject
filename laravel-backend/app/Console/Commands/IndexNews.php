<?php

namespace App\Console\Commands;

use App\Models\News;
use Elasticsearch\Client;
use Illuminate\Console\Command;

class IndexNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'index:news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexing (Create index, mapping, delete index if exist, indexing all news) News in ElasticSearch';

    private $news;
    private $elasticsearch;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Client $elasticsearch, News $news)
    {
        parent::__construct();

        $this->elasticsearch = $elasticsearch;
        $this->news = $news;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Indexing all news');

        try {
            $this->elasticsearch->indices()->delete(['index' => $this->news->getSearchIndex()]);
        } catch (\Exception $exception) {
            $this->info($exception);
        }

        $this->elasticsearch->indices()->create($this->settings($this->news));

        foreach (News::cursor() as $news) {
            $this->elasticsearch->index([
                'index' => $news->getSearchIndex(),
                'type' => $news->getSearchType(),
                'id' => $news->getKey(),
                'body' => $news->toSearchArray(),
            ]);

            $this->output->write('.');
        }
        $this->info('\nDone!');
    }

    private function settings(News $news)
    {
        return [
            'index' => $news->getSearchIndex(),
            'body' => [
                'settings' => [
                    'analysis' => [
                        'filter' => [
                            "russian_stop" => [
                                "type" => "stop",
                                "stopwords" => "_russian_"
                            ],
//                            "russian_keywords" => [
//                                "type" => "keyword_marker",
//                                "keywords" => ["пример"]
//                            ],
                            "shingle" => [
                                'type' => 'shingle',
                            ],
                            "mynGram" => [
                                'type' => 'edge_ngram',
                                'min_gram' => 3,
                                'max_gram' => 10,
                            ],
                            "russian_stemmer" => [
                                "type" => "stemmer",
                                "language" => "russian"
                            ],
                            'english_stemmer' => [
                                'type' => 'stemmer',
                                'language' => 'english',
                            ]
                        ],
                        'analyzer' => [
                            'rebuilt_russian' => [
                                'type' => 'custom',
                                'tokenizer' => 'standard',
                                'filter' => ['lowercase', 'russian_stop', 'russian_stemmer', 'mynGram', 'english_stemmer', 'trim']
                            ]
                        ]
                    ]
                ],
                'mappings' => [
                    'properties' => [
                        'is_active' => ['type' => 'boolean'],
                        'preview_text' => [
                            'type' => 'text',
                            'analyzer' => 'rebuilt_russian',
                        ],
                        'text' => [
                            'type' => 'text',
                            'analyzer' => 'rebuilt_russian',
                        ],
                        'title' => [
                            'type' => 'text',
                            'analyzer' => 'rebuilt_russian',
                        ],
                        'category_id' => ['type' => 'keyword'],
                        'sort' => ['type' => 'keyword'],
                        'code' => ['type' => 'keyword'],
                        'year' => ['type' => 'long'],
                        'created_at' => ['type' => 'date'],
                        'updated_at' => ['type' => 'date'],
                    ]
                ]
            ]
        ];
    }
}
