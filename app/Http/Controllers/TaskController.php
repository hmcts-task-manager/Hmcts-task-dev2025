<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::orderBy('due_at')->get();
        return view('index', compact('tasks'));
    }

    public function show($id)
    {
        $task = Task::findOrFail($id);
        return view('show', compact('task'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:todo,in_progress,done',
            'due_at' => 'required|date',
        ]);

        Task::create($data);
        return redirect()->route('tasks.index')->with('ok', 'Task created');
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:todo,in_progress,done', 
            'due_at' => 'required|date',                    
        ]);

        $task->update($data);
        return redirect()->route('tasks.index')->with('ok', 'Task updated');
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return redirect()->route('tasks.index')->with('ok', 'Task deleted');
    }
}
