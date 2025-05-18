<?php

namespace App\Http\Controllers;
use App\Models\Movie;
use App\Models\Schedule;
use Illuminate\Http\Request;


class MovieController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $is_showing = $request->input('is_showing');
    
        $query = Movie::query();
    
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%");
            });
        }
    
        if (!is_null($is_showing)) {
            $query->where('is_showing', $is_showing);
        }
    
        $movies = $query->paginate(20);
    
        return view('movies.index', compact('movies', 'keyword', 'is_showing'));
    }

   

public function show($id)
{
    $movie = Movie::findOrFail($id);

    $schedules = Schedule::where('movie_id', $id)->orderBy('start_time')->get();

    return view('movies.show', compact('movie', 'schedules'));
}

} 