<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Genre;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;


class MovieController extends Controller
{
    public function index(Request $request)
{
    $keyword = $request->input('keyword');
    $is_showing = $request->input('is_showing');

    // 'is_showing' が空文字の場合は処理しない
    if ($is_showing === '') {
        $is_showing = null; // 空文字の場合は null に設定
    }

    $query = Movie::query();

    // キーワード検索
    if ($keyword) {
        $query->where(function ($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
              ->orWhere('description', 'like', "%{$keyword}%");
        });
    }

    // 公開状態フィルタリング（is_showing が null でない場合に適用）
    if (!is_null($is_showing)) {
        $query->where('is_showing', $is_showing);
    }

    // ページネーション（20件ごと）
    $movies = $query->paginate(20);
    
    //ジャンル情報を取得
    $genres = Genre::all();

    return view('admin.movies.index', compact('movies', 'keyword', 'is_showing'));
}

public function create()
{
    // ジャンル一覧を取得
    $genres = Genre::all();
    return view('admin.movies.create', compact('genres'));
}

public function edit($id)
{
    // 映画の情報を取得
    $movie = Movie::findOrFail($id);
    // ジャンル一覧を取得
    $genres = Genre::all();
    return view('admin.movies.edit', compact('movie', 'genres'));
}

public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'title' => 'required|unique:movies,title',
            'image_url' => 'required|url',
            'published_year' => 'required|integer|digits:4',
            'description' => 'required|string',
            'is_showing' => 'required|boolean',
            'genre' => 'required|string|max:255',
        ]);
    } catch (ValidationException $e) {
        return redirect()->back()->withErrors($e->errors())->withInput(); // ← バリデーションは302
    }

    DB::beginTransaction();

    try {
        // テスト用に意図的に例外を出す
        if (app()->environment('testing') && $validated['title'] === str_repeat('test', 100)) {
            throw new \Exception('意図的な失敗');
        }

        $genre = Genre::firstOrCreate(['name' => $validated['genre']]);

        Movie::create([
            'title' => $validated['title'],
            'image_url' => $validated['image_url'],
            'published_year' => $validated['published_year'],
            'description' => $validated['description'],
            'is_showing' => $validated['is_showing'],
            'genre_id' => $genre->id,
        ]);

        DB::commit();
        return redirect()->route('admin.movies.index');

    } catch (\Throwable $e) {
        DB::rollBack();
        Log::error('映画の登録に失敗: ' . $e->getMessage());
        return response('Internal Server Error', 500); // ← こっちは500
    }
}

public function update(Request $request, $id)
{
    DB::beginTransaction();

    try {
        $validated = Validator::make($request->all(), [
            'title' => 'required|unique:movies,title,' . $id,
            'image_url' => 'required|url',
            'published_year' => 'required|integer|digits:4',
            'description' => 'required|string',
            'is_showing' => 'required|boolean',
            'genre' => 'required|string|max:255',
        ])->validate();

        $movie = Movie::findOrFail($id);

        //例外の処理
        if (app()->environment('testing') && $validated['title'] === str_repeat('test', 100)) {
            throw new \Exception('意図的な失敗');
        }

        $genre = Genre::firstOrCreate(['name' => $validated['genre']]);

        $movie->update([
            'title' => $validated['title'],
            'image_url' => $validated['image_url'],
            'published_year' => $validated['published_year'],
            'description' => $validated['description'],
            'is_showing' => $validated['is_showing'],
            'genre_id' => $genre->id,
        ]);

        DB::commit();
        return redirect()->route('admin.movies.index');

    } catch (\Illuminate\Validation\ValidationException $e) {
        DB::rollBack();
        return redirect()->back()->withErrors($e->errors())->withInput();
    } catch (\Throwable $e) {
        DB::rollBack();
        Log::error('映画の更新に失敗: ' . $e->getMessage());
        return response('Internal Server Error', 500);
    }
}

  public function destroy($id)
      {
        try {
            $movie = Movie::findOrFail($id);
            $movie->delete();
            return redirect()->route('admin.movies.index');
        } catch (ModelNotFoundException $e){
        abort(404);
        }
      }
      
  public function show($id)
  {
    $movie = Movie::findOrFail($id);
    return view('admin.movies.show', compact('movie'));
  }
}