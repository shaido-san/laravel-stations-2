<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規登録</title>
</head>
<body>
    @if (session('success'))
        <div style="color: green">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.movies.store') }}" method="POST">
    @csrf
    
    <label>タイトル:</label>
    <input type="text" name="title" value="{{ old('title') }}" required><br>

    <label>URL:</label>
    <input type="text" name="image_url" value="{{ old('image_url') }}" required><br>

    <label>公開年:</label>
    <input type="number" name="published_year" value="{{ old('published_year') }}" required><br>

    <label>概要:</label>
    <textarea name="description">{{ old('description') }}</textarea><br>

    <label>公開してるかどうか:</label>
    <input type="checkbox" name="is_showing" value="1" {{ old('is_showing') ? 'checked' : '' }}><br>

    <!-- ジャンル入力フォーム (自由入力) -->
    <label for="genre">ジャンル:</label>
    <input type="text" name="genre" id="genre" required value="{{ old('genre') }}" placeholder="ジャンルを入力"><br>

    <button type="submit">登録する</button>
    </form>
</body>
</html>