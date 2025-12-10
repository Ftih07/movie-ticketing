<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    // LIST FILM
    public function index(Request $request)
    {
        // 1. Mulai Query
        $query = Movie::query();

        // 2. Logika Search (Berdasarkan Judul)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('title', 'like', '%' . $search . '%');
        }

        // 3. Logika Sorting (Filter Urutan)
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'date_asc':
                    $query->orderBy('show_time', 'asc');
                    break;
                case 'date_desc':
                    $query->orderBy('show_time', 'desc');
                    break;
                default:
                    $query->orderBy('show_time', 'asc'); // Default
            }
        } else {
            // Default jika tidak ada filter: Paling baru tayang duluan
            $query->orderBy('show_time', 'asc');
        }

        $movies = $query->get();

        return view('user.movies.index', compact('movies'));
    }

    // DETAIL FILM (Tetap sama)
    public function show(Movie $movie)
    {
        return view('user.movies.show', compact('movie'));
    }
}
