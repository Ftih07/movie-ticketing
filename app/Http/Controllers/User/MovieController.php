<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Movie;

class MovieController extends Controller
{
    // LIST FILM
    public function index()
    {
        $movies = Movie::orderBy('show_time', 'asc')->get();

        return view('user.movies.index', compact('movies'));
    }

    // DETAIL FILM
    public function show(Movie $movie)
    {
        return view('user.movies.show', compact('movie'));
    }
}
