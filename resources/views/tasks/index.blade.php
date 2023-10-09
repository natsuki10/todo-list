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
        <input type="radio" onclick="displayAll()" name="status" value="全て" class="radio-all-select">
        <label for="all">全て</label>
        <input type="radio" onclick="displayWorking()" name="status" value="作業中" class="radio-working-select">
        <label for="working">作業中</label>
        <input type="radio" onclick="displayDone()" name="status" value="完了" class="radio-done-select">
        <label for="completed">完了</label>
    </form>
    <table>
        <tr>
            <th>ID</th>
            <th>コメント</th>
            <th>状態</th>
        </tr>
    @foreach($tasks->sortBy('id') as $task)
        <tr class="task-list {{ $task->status === '作業中' ? 'working-task' : ($task->status === '完了' ? 'done-task' : '') }}">
            <td>{{ $loop->iteration }}</td>
            <td>{{ $task->comment }}</td>
            <td>
                <form method="POST" action="{{ route('tasks.update', $task->id) }}">
                    @csrf
                    @method('PUT')
                    @if ($task->status === '作業中')
                        <input type="hidden" name="status" value="完了" >
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
    
    <script type="text/javascript">
    function displayAll() {
        var taskLists = document.querySelectorAll('.task-list');
        taskLists.forEach(function(taskList) {
            taskList.style.display = "block";
        });
        }
    function displayWorking() {
        var taskLists = document.querySelectorAll('.task-list');
        taskLists.forEach(function(taskList) {
            if (taskList.classList.contains('working-task')) {
                taskList.style.display = "block";
            } else {
                taskList.style.display = "none";
            }
        });
    }
    function displayDone() {
        var taskLists = document.querySelectorAll('.task-list');
        taskLists.forEach(function(taskList) {
            if (taskList.classList.contains('done-task')) {
                taskList.style.display = "block";
            } else {
                taskList.style.display = "none";
            }
        });
    }
    </script>
</body>
</html>