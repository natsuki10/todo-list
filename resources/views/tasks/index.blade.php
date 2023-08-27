<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDoリスト</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <h1>ToDoリスト</h1>
    <form method="GET" action="{{ route('tasks.index') }}">
        <input type="radio" name="status" value="all" id="all" checked>
        <label for="all">すべて</label>
        <input type="radio" name="status" value="作業中" id="working">
        <label for="working">作業中</label>
        <input type="radio" name="status" value="完了" id="completed">
        <label for="completed">完了</label>
    </form>
    <table>
        <tr>
            <th>ID</th>
            <th>コメント</th>
            <th>状態</th>
        </tr>
    @foreach($tasks->sortBy('id') as $task)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $task->comment }}</td>
            <td>
                <form method="POST" action="{{ route('tasks.update', $task->id) }}">
                    @csrf
                    @method('PUT')
                    @if ($task->status === '作業中')
                        <input type="hidden" name="status" value="完了">
                        <button type="submit">作業中</button>
                    @elseif ($task->status === '完了')
                        <input type="hidden" name="status" value="作業中">
                        <button type="submit">完了</button>
                    @endif
                </form>
            </td>
            <td> 
                <form method="POST" action="{{ route('tasks.destroy', $task->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">削除</button>
                </form>
            </td>
        </tr>
    @endforeach
    </table>
    <h2>新規タスクの追加</h2>
    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf
        <input type="text" name="comment">
        <button type="submit">追加</button>
    </form>
</body>
</html>