@extends('layouts.app')

@section('content')
<h1>{{ $task->title }}</h1>

<div class="card">
    <div class="card-body">
        @if($task->description)
            <p>{{ $task->description }}</p>
        @endif
        
        <p><strong>Status:</strong> 
            <span class="badge 
                @if($task->status === 'pending') bg-secondary
                @elseif($task->status === 'in_progress') bg-primary
                @else bg-success
                @endif">
                {{ str_replace('_', ' ', $task->status) }}
            </span>
        </p>
        
        @if($task->due_date)
            <p><strong>Due:</strong> {{ $task->due_date->format('M j, Y g:i A') }}</p>
        @endif
        
        <p><small class="text-muted">Created: {{ $task->created_at->format('M j, Y') }}</small></p>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary">Edit</a>
    <a href="/" class="btn btn-secondary">Back</a>
    
    <form class="d-inline" method="POST" action="{{ route('tasks.destroy', $task) }}" 
          onsubmit="return confirm('Delete this task?')">
        @csrf @method('DELETE')
        <button class="btn btn-danger">Delete</button>
    </form>
</div>
@endsection