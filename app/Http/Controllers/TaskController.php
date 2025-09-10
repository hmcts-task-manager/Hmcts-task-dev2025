<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::orderBy('due_date')->get();
        
        if ($request->wantsJson()) {
            return response()->json($tasks);
        }
        
        return view('index', compact('tasks'));
    }

    public function create()
    {
        return view('create');
    }

    public function show($id, Request $request)
    {
        $task = Task::findOrFail($id);
        
        if ($request->wantsJson()) {
            return response()->json($task);
        }
        
        return view('show', compact('task'));
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        return view('edit', compact('task'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'status' => 'nullable|in:pending,in_progress,done',
            'due_date' => 'nullable|date',
        ]);

        try {
            $task = Task::create($request->all());
            
            if ($request->wantsJson()) {
                return response()->json($task, 201);
            }
            
            return redirect('/')->with('success', 'Task created!');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Failed to create task'], 500);
            }
            
            return back()->with('error', 'Something went wrong')->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $task = Task::findOrFail($id);
            
            if ($request->wantsJson()) {
                $request->validate(['status' => 'required|in:pending,in_progress,done']);
                $task->update(['status' => $request->status]);
            } else {
                $request->validate([
                    'title' => 'required|max:255',
                    'description' => 'nullable',
                    'status' => 'required|in:pending,in_progress,done',
                    'due_date' => 'nullable|date',
                ]);
                $task->update($request->all());
            }
            
            if ($request->wantsJson()) {
                return response()->json($task);
            }
            
            return redirect('/')->with('success', 'Task updated!');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Update failed'], 500);
            }
            
            return back()->with('error', 'Could not update task');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,in_progress,done'
        ]);
        
        $task->update(['status' => $request->status]);
        
        if ($request->wantsJson()) {
            return response()->json($task);
        }
        
        return back()->with('success', 'Status updated!');
    }

    public function destroy($id, Request $request)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        
        if ($request->wantsJson()) {
            return response()->json(['message' => 'deleted']);
        }
        
        return redirect('/')->with('success', 'Task deleted!');
    }
}
