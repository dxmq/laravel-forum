<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trending;
use App\Thread;

class SearchController extends Controller
{
    public function show(Trending $trending)
    {
        $search = request('q');

        if (empty($search)) {
            return redirect('/threads');
        }

        $threads = Thread::where('title', 'like', "$search%")->paginate(20);

        return view('threads.search',[
            'threads' => $threads,
            'trending' => $trending->get(),
            'search' => $search
        ]);
    }
}
