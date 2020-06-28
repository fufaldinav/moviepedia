<?php

namespace App\Http\Controllers;

use App\Movie;
use App\Person;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('table');
    }

    /**
     * Show the application dashboard.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function list(Request $request)
    {
        $page = $request->input('page') ?? 0;
        $pageSize = $request->input('page_size') ?? 25;

        $movies = Movie::findOrFail(550);
        dump($movies);

        return response('')->header('Content-Type', ' text/plain');
    }
}
