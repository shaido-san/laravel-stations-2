<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>映画編集</title>
</head>
<body>

    <h2>映画編集</h2>

    <!-- エラーメッセージ -->
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.movies.update', $movie->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <label for="title">映画タイトル:</label>
        <input type="text" name="title" value="{{ old('title', $movie->title) }}" required><br>

        <label for="image_url">画像URL:</label>
        <input type="text" name="image_url" value="{{ old('image_url', $movie->image_url) }}" required><br>

        <label for="published_year">公開年:</label>
        <input type="number" name="published_year" value="{{ old('published_year', $movie->published_year) }}" required><br>

        <label for="is_showing">公開中かどうか:</label>
        <input type="hidden" name="is_showing" value="0">
        <input type="checkbox" name="is_showing" value="1" {{ old('is_showing', $movie->is_showing) ? 'checked' : '' }}><br>

        <label for="description">概要:</label>
        <textarea name="description">{{ old('description', $movie->description) }}</textarea><br>

        <label for="genre">ジャンル:</label>
        <input type="text" name="genre" value="{{ old('genre', $movie->genre->name ?? '') }}" required><br>

        <button type="submit">更新</button>
    </form>

</body>
</html>