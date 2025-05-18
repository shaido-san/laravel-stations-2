<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index()
    {
        $movies = Movie::whereHas('schedules')
          ->with('schedules')
          ->get();

        return view('admin.schedules.index', compact('movies'));
    }

public function show($id) 
{}
public function create($movieId)
{
    $movie = Movie::findOrFail($movieId);
    return view('admin.schedules.create', compact('movie'));
}
public function store(Request $request, $movieId) 
{
    // デバッグログ（開発環境・テスト環境のみ）
    if (app()->environment(['local', 'testing'])) {
        \Log::debug('STORE method: incoming request', $request->all());
        \Log::debug('STORE method: movieId from URL', ['movie_id' => $movieId]);
        \Log::debug('STORE method: checking raw request inputs', [
            'movie_id (hidden)' => $request->input('movie_id'),
            'start_time_date' => $request->input('start_time_date'),
            'start_time_time' => $request->input('start_time_time'),
            'end_time_date' => $request->input('end_time_date'),
            'end_time_time' => $request->input('end_time_time'),
        ]);
    }

    // バリデーション
    $validated = $request->validate([
        'movie_id' => ['required', 'integer', 'exists:movies,id'],
        'start_time_date' => ['required', 'date_format:Y-m-d'],
        'start_time_time' => ['required', 'date_format:H:i'],
        'end_time_date' => ['required', 'date_format:Y-m-d'],
        'end_time_time' => ['required', 'date_format:H:i'],
    ]);

    // Carbonで厳格な日付＋時間の合成（不正フォーマットを防止）
    $start_time = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $validated['start_time_date'] . ' ' . $validated['start_time_time']);
    $end_time = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $validated['end_time_date'] . ' ' . $validated['end_time_time']);

    // パース後の確認ログ
    \Log::debug('STORE method: parsed start_time', ['start_time' => $start_time->toDateTimeString()]);
    \Log::debug('STORE method: parsed end_time', ['end_time' => $end_time->toDateTimeString()]);

    // スケジュールを保存
    Schedule::create([
        'movie_id' => $movieId,
        'start_time' => $start_time,
        'end_time' => $end_time,
    ]);

    // 完了メッセージ付きでリダイレクト
    return redirect()->route('admin.movies.show', ['id' => $movieId])
                     ->with('success', 'スケジュールを作成しました');
}

public function update(Request $request, $scheduleId)
{
    // ログ出力（開発・テスト時のみ）
    if (app()->environment(['local', 'testing'])) {
        \Log::debug('UPDATE method: incoming request', $request->all());
        \Log::debug('UPDATE method: movieId from URL', ['movie_id' => $scheduleId]);
        \Log::debug('UPDATE method: checking raw request inputs', [
            'start_time_date' => $request->input('start_time_date'),
            'start_time_time' => $request->input('start_time_time'),
            'end_time_date' => $request->input('end_time_date'),
            'end_time_time' => $request->input('end_time_time'),
        ]);
    }

    // バリデーション（formatが正確でないと通さない）
    $validated = $request->validate([
        'movie_id' => ['required'],
        'start_time_date' => ['required', 'date_format:Y-m-d'],
        'start_time_time' => ['required', 'date_format:H:i'],
        'end_time_date' => ['required', 'date_format:Y-m-d'],
        'end_time_time' => ['required', 'date_format:H:i'],
    ]);

    // 安全にCarbon形式で日付＋時間を生成
    $start_time = \Carbon\Carbon::createFromFormat(
    'Y-m-d H:i',
    $validated['start_time_date'] . ' ' . $validated['start_time_time'],
    'Asia/Tokyo'
);

$end_time = \Carbon\Carbon::createFromFormat(
    'Y-m-d H:i',
    $validated['end_time_date'] . ' ' . $validated['end_time_time'],
    'Asia/Tokyo'
);

    // 該当スケジュールを取得して更新
    \Log::debug('Parsed times for update', [
    'start_time' => $start_time->toDateTimeString(),
    'end_time' => $end_time->toDateTimeString(),
]);

$schedule = Schedule::findOrFail($scheduleId);

$schedule->update([
    'start_time' => $start_time,
    'end_time' => $end_time,
]);

\Log::debug('Updated schedule', $schedule->toArray());
    // リダイレクト
    return redirect()->route('admin.movies.show', ['id' => $schedule->movie_id])
                     ->with('success', 'スケジュールを更新しました');
}

public function edit($scheduleId) 
{
    $schedule = Schedule::findOrFail(($scheduleId));
    $movie = $schedule->movie;
    return view('admin.schedules.edit', compact('schedule', 'movie'));
}

public function destroy($id) 
{
    $schedule = Schedule::findOrFail($id);
    $schedule->delete();

    return redirect()->route('admin.schedules.index');
}
}
