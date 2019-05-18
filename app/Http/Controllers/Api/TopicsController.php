<?php

namespace App\Http\Controllers\Api;

use App\Repository\TopicsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TopicsController extends Controller
{
    protected $topicsRepository;

    public function __construct(TopicsRepository $topicsRepository)
    {
        $this->topicsRepository = $topicsRepository;
    }

    public function index(Request $request)
    {
        $topics = $this->topicsRepository->getTopics($request->get('query'));

        return response()->json([
            'topics' => $topics
        ]);
    }
}
