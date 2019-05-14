<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trending;
use App\Thread;

class SearchController extends Controller
{
    public function show(Thread $thread, Trending $trending)
    {
        $search = request('q');

        if (empty($search)) {
            return redirect('/threads');
        }

        $threads = $thread->search($search);

        return view('threads.search',[
            'threads' => $threads,
            'trending' => $trending->get(),
            'search' => $search
        ]);
    }
}
