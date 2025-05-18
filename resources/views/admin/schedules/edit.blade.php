<h2>スケジュール編集：{{ $schedule->movie->title }}</h2>

<form action="{{ route('admin.schedules.update', $schedule->id) }}" method="POST">
    @csrf
    @method('PATCH')

    {{-- movie_id を hidden で保持（バリデーション用に必要） --}}
    <input type="hidden" name="movie_id" value="{{ old('movie_id', $schedule->movie_id) }}">

    <div>
        <label for="start_time_date">開始日付</label>
        <input
            type="date"
            name="start_time_date"
            id="start_time_date"
            value="{{ old('start_time_date', $schedule->start_time->format('Y-m-d')) }}"
            required
        >
    </div>

    <div>
        <label for="start_time_time">開始時間</label>
        <input
            type="time"
            name="start_time_time"
            id="start_time_time"
            value="{{ old('start_time_time', $schedule->start_time->format('H:i')) }}"
            required
        >
    </div>

    <div>
        <label for="end_time_date">終了日付</label>
        <input
            type="date"
            name="end_time_date"
            id="end_time_date"
            value="{{ old('end_time_date', $schedule->end_time->format('Y-m-d')) }}"
            required
        >
    </div>

    <div>
        <label for="end_time_time">終了時間</label>
        <input
            type="time"
            name="end_time_time"
            id="end_time_time"
            value="{{ old('end_time_time', $schedule->end_time->format('H:i')) }}"
            required
        >
    </div>

    <button type="submit">上映スケジュールを変更する</button>
</form>

<form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
    @csrf
    @method('DELETE')
    <button type="submit">上映スケジュールを削除する</button>
</form>