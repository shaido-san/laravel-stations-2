@foreach ($movies as $movie)
    <h2>{{ $movie->id }}: {{ $movie->title }}</h2>
    <h3>{{ $movie->title }} の上映予定</h3>
    <ul>
        @foreach ($movie->schedules as $schedule)
            <li>
                開始: {{ $schedule->start_time }} / {{ $schedule->end_time }}
                <a href="{{ route('admin.schedules.edit', ['scheduleId' => $schedule->id]) }}">上映予定を変更する</a>
                <form action="{{ route('admin.schedules.destroy', ['id' => $schedule->id]) }}" method="POST" style="display:inline;" onsubmit="return confirm('本当に削除していいですか？')">
                    @csrf
                    @method('DELETE')
                    <button type="submit">上映スケジュールを削除する</button>
                </form>
            </li>
        @endforeach
    </ul>
    <a href="{{ route('admin.schedules.create',  ['movieId' => $movie->id]) }}">上映予定を追加する</a>
@endforeach