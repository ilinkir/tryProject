<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Http\Resources\News\IndexResource;
use App\News\Repositories\NewsRepository;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    private $limit = 10;

    public function index(Request $request,NewsRepository $newsRepository)
    {
        $limit = $request->limit ?? $this->limit;

        $data = $newsRepository->paginate($limit);

        $data = [
            'data' => $data->items(),
            'last_page' => $data->lastPage(),
            'per_page' => $data->perPage(),
            'has_more_pages' => $data->hasMorePages(),
            'has_pages' => $data->hasPages(),
            'total' => $data->total(),
        ];

        return response()->json($data);
    }
}
