<h2>{{ $movie->title }}</h2>
<img src="{{ $movie->image_url }}" alt="{{ $movie->title }}">
<p>公開年: {{ $movie->published_year }}</p>
<p>概要: {{ $movie->description }}</p>
<p>上映: {{ $movie->is_showing ? 'はい' : 'いいえ' }}</p>
<p>上映ジャンル: {{ $movie->genre->name ?? 'ジャンルなし' }}</p>

<h3>上映予定</h3>
<ul>
    @foreach ($movie->schedules as $schedule)
        <li>
            {{ $schedule->start_time }} - {{ $schedule->end_time }}
            <a href="{{ route('admin.schedules.edit', ['scheduleId' => $schedule->id]) }}">スケジュールを編集する</a>
        </li>
    @endforeach
</ul>

<a href="{{ route('admin.schedules.index', ['movie_id' => $movie->id]) }}">スケジュール一覧</a>
<a href="{{ route('admin.schedules.create', ['movieId' => $movie->id]) }}">スケジュールを追加する</a>