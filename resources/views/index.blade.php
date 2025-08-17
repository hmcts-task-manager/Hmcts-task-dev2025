<!DOCTYPE html>
<html>
<head>
    <title>Task Manager</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Tasks</h1>

    <form action="{{ route('tasks.store') }}" method="POST" class="mb-4">
        @csrf
        <div class="row g-2">
            <div class="col-md-4">
                <input type="text" name="title" class="form-control" placeholder="Title" value="{{ old('title') }}" required>
            </div>
            <div class="col-md-4">
                <input type="datetime-local" name="due_at" class="form-control" value="{{ old('due_at') }}" required>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="todo" {{ old('status','todo')==='todo' ? 'selected' : '' }}>To do</option>
                    <option value="in_progress" {{ old('status')==='in_progress' ? 'selected' : '' }}>In progress</option>
                    <option value="done" {{ old('status')==='done' ? 'selected' : '' }}>Done</option>
                </select>
            </div>
            <div class="col-md-12">
                <textarea name="description" class="form-control" rows="2" placeholder="Description (optional)">{{ old('description') }}</textarea>
            </div>
            <div class="col-md-12">
                <button class="btn btn-primary">Add Task</button>
            </div>
        </div>
    </form>

    @isset($tasks)
    <table class="table table-bordered align-middle">
        <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th>Due</th>
            <th style="width:200px">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tasks as $task)
            <tr>
                <td>{{ $task->title }}</td>
                <td>{{ $task->description }}</td>
                <td>{{ ucfirst(str_replace('_',' ',$task->status)) }}</td>
                <td>{{ \Illuminate\Support\Carbon::parse($task->due_at)->format('d-m-Y H:i') }}</td>
                <td>
                    <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="d-inline">
                        @csrf @method('PUT')
                        <input type="hidden" name="title" value="{{ $task->title }}">
                        <input type="hidden" name="description" value="{{ $task->description }}">
                        <input type="hidden" name="due_at" value="{{ $task->due_at }}">
                        <input type="hidden" name="status" value="{{ $task->status === 'done' ? 'todo' : 'done' }}">
                        <button class="btn btn-sm btn-success">Complete</button>
                    </form>
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this task?');">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @endisset
</div>
</body>
</html>
