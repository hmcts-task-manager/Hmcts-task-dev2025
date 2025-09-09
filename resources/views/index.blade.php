@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>My Tasks</h2>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">+ New Task</a>
</div>

@if($tasks->count())
    <div class="row">
        @foreach($tasks as $task)
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title mb-0">{{ $task->title }}</h5>
                        <span class="badge 
                            @if($task->status === 'pending') bg-warning text-dark
                            @elseif($task->status === 'in_progress') bg-info
                            @else bg-success
                            @endif">
                            {{ ucwords(str_replace('_', ' ', $task->status)) }}
                        </span>
                    </div>
                    
                    @if($task->description)
                        <p class="text-muted small">{{ Str::limit($task->description, 80) }}</p>
                    @endif
                    
                    @if($task->due_date)
                        <small class="text-muted">
                            <i>Due: {{ $task->due_date->format('M j, Y') }}</i>
                            @if($task->due_date->isPast() && $task->status !== 'done')
                                <span class="text-danger"> (Overdue)</span>
                            @endif
                        </small>
                    @endif
                </div>
                
                <div class="card-footer bg-light">
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-outline-primary">View</a>
                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                        </div>
                        
                        @if($task->status !== 'done')
                            <form method="POST" action="{{ route('tasks.status', $task) }}" class="d-inline">
                                @csrf @method('PATCH')
                                @if($task->status === 'pending')
                                    <input type="hidden" name="status" value="in_progress">
                                    <button class="btn btn-sm btn-info">Start</button>
                                @else
                                    <input type="hidden" name="status" value="done">
                                    <button class="btn btn-sm btn-success">Complete</button>
                                @endif
                            </form>
                        @endif
                    </div>
                    
                    <form class="mt-2" method="POST" action="{{ route('tasks.destroy', $task) }}" 
                          onsubmit="return confirm('Delete this task?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger w-100">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="text-center mt-5">
        <h4 class="text-muted">No tasks yet</h4>
        <p class="text-muted">Get started by creating your first task</p>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">Create First Task</a>
    </div>
@endif
@endsection