<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::orderBy('id', 'desc')->get();
        return view('tasks.index',compact('tasks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $comment = $request->input('comment');
        $task = new Task();
        $task->comment = $comment;
        $task->status = '作業中'; 
        $task->save();
    
        return redirect()->route('tasks.index');
    }

    public function update(Request $request, Task $task)
    {
        $newStatus = $request->input('status');
    
        if ($newStatus === '作業中' || $newStatus === '完了') {
        $task->status = $newStatus;
        $task->save();
        }
    
        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index');
    }
}
