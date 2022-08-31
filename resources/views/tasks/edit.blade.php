@extends('layouts.master')
@section('content')
    <div class="container">
        <h2 class="my-2">Edit Tasks</h2>
        <div class="shadow p-5">
            <form action="{{ route('tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                @include('partials.messages')
                <div class="mb-3">
                    <label for="task_title" class="form-label">Task Title</label>
                    <input type="text" name="title" class="form-control" id="task_title" aria-describedby="emailHelp"
                        value="{{ $task->title }}">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Descripton</label>
                    <textarea name="description" id="" cols="30" rows="5" class="form-control">{{ $task->description }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Task Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">Select</option>
                        <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="active" {{ $task->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="done" {{ $task->status === 'done' ? 'selected' : '' }}>Done</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Task Imagae</label>
                    @if ($task->image)
                        <p>Old Image</p>
                        <img src="{{ Storage::url($task->image) }}" alt="" width="50">
                    @endif
                    <input type="file" name="image" id="image" class="form-control">
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('tasks.index') }}" class="btn btn-secondary mx-2">Back</a>
                </div>
            </form>
        </div>
    </div>
@endsection
