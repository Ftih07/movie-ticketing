<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
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

        // 3. Filter Category (BARU) -> Menggunakan whereHas karena relasi Many-to-Many
        if ($request->category) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        // 4. Filter Duration (BARU) -> Mencari film dengan durasi KURANG DARI input (Max Duration)
        if ($request->duration) {
            // Contoh: User pilih "Under 90 mins", query cari duration <= 90
            $query->where('duration', '<=', $request->duration);
        }

        // 5. Logika Sorting (Filter Urutan)
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

        $movies = $query->paginate(10);

        $categories = Category::all();

        return view('user.movies.index', compact('movies', 'categories'));
    }

    // DETAIL FILM (Tetap sama)
    public function show(Movie $movie)
    {
        return view('user.movies.show', compact('movie'));
    }
}
