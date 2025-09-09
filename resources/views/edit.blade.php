@extends('layouts.app')

@section('content')
<h1>Edit Task</h1>

<form action="{{ route('tasks.update', $task) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="mb-3">
        <label for="title">Title*</label>
        <input type="text" name="title" class="form-control" value="{{ $task->title }}" required>
    </div>

    <div class="mb-3">
        <label for="description">Description</label>
        <textarea name="description" class="form-control" rows="3">{{ $task->description }}</textarea>
    </div>

    <div class="mb-3">
        <label for="status">Status</label>
        <select name="status" class="form-control" required>
            <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
            <option value="done" {{ $task->status == 'done' ? 'selected' : '' }}>Done</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="due_date">Due Date</label>
        <input type="datetime-local" name="due_date" class="form-control" 
               value="{{ $task->due_date ? $task->due_date->format('Y-m-d\TH:i') : '' }}">
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="/" class="btn btn-secondary">Cancel</a>
</form>
@endsection