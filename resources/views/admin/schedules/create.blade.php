<h2>スケジュール作成：{{ $movie->title }}</h2>

<form action="{{ route('admin.schedules.store', ['movieId' => $movie->id]) }}" method="POST">
    @csrf

    <input type="hidden" name="movie_id" value="{{ $movie->id }}">

    <div>
        <label for="start_time_date">開始日付</label>
        <input type="date" name="start_time_date" id="start_time_date"
               value="{{ old('start_time_date') }}" required>
    </div>

    <div>
        <label for="start_time_time">開始時間</label>
        <input type="time" name="start_time_time" id="start_time_time"
               value="{{ old('start_time_time') }}" required>
    </div>

    <div>
        <label for="end_time_date">終了日付</label>
        <input type="date" name="end_time_date" id="end_time_date"
               value="{{ old('end_time_date') }}" required>
    </div>

    <div>
        <label for="end_time_time">終了時間</label>
        <input type="time" name="end_time_time" id="end_time_time"
               value="{{ old('end_time_time') }}" required>
    </div>

    <button type="submit">登録する</button>
</form>