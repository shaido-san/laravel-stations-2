<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>映画作品一覧</title>
</head>
<body>
    <h1>映画作品一覧</h1>

    <!-- 検索フォーム -->
    <form method="GET" action="{{ url('/movies') }}">
        <!-- キーワード検索 -->
        <input type="text" name="keyword" placeholder="キーワードで検索" value="{{ request('keyword') }}">
        
        <!-- 公開状態フィルタリングのラジオボタン -->
        <label>
            <input type="radio" name="is_showing" value="" {{ request('is_showing') === null ? 'checked' : '' }}> すべて
        </label>
        <label>
            <input type="radio" name="is_showing" value="1" {{ request('is_showing') == '1' ? 'checked' : '' }}> 公開中
        </label>
        <label>
            <input type="radio" name="is_showing" value="0" {{ request('is_showing') == '0' ? 'checked' : '' }}> 公開予定
        </label>
        
        <button type="submit">検索</button>
    </form>

    <!-- 映画リスト -->
    @if ($movies->isNotEmpty())
    <div class="movies-list">
        @foreach ($movies as $movie)
            <div class="movie-item">
            <h2>
                <a href="{{ url('movies/' . $movie->id) }}">
                   {{ $movie->title }}
                </a>
            </h2>
            <img src="{{ $movie->image_url }}" alt="{{ $movie->title }}">
            <p>公開年: {{ $movie->published_year }}</p>
            <p>概要: {{ $movie->description }}</p>
            <p>上映状況: {{ $movie->is_showing ? '上映中' : '上映予定' }}</p>
            </div>
        @endforeach
    </div>

    <div class="pagination">
        {{ $movies->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
@else
    <p>登録されている映画はありません。</p>
@endif
</body>
</html>