<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $movie->title }} 詳細ページ</title>
</head>
<body>
    <h1>{{ $movie->title }}</h1>
    <img src="{{ $movie->image_url }}" alt="{{ $movie->title }}">
    <p>公開年: {{ $movie->published_year }}</p> <!-- 映画の公開年を表示 -->
    <p>説明: {{ $movie->description }}</p>

    <h2>上映スケジュール</h2>
    <table>
        <tr>
            <th>上映開始</th>
            <th>上映終了</th>
        </tr>
        @foreach ($schedules as $schedule)
        <tr>
            <td>{{ $schedule->start_time->format('H:i') }}</td>
            <td>{{ $schedule->end_time->format('H:i') }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>