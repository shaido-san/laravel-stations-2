<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>座席</title>
</head>
<body>
    <table border="1">
        <!-- 行ごとに座席を表示 -->
        @foreach ($sheets as $row => $columns) <!-- $sheetsをグループ化した結果 -->
            <tr>
                <!-- 各列番号を表示 -->
                @foreach ($columns as $sheet)
                    <td>{{ $sheet->row }}-{{ $sheet->column }}</td> <!-- 行と列を表示 -->
                @endforeach
            </tr>
        @endforeach
    </table>
</body>
</html>