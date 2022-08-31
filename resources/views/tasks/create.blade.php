@extends('layouts.master')
@section('content')
    <div class="container">
        <h2 class="my-2">New Tasks</h2>
        <div class="shadow p-5">
            <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('partials.messages')
                <div class="mb-3">
                    <label for="task_title" class="form-label">Task Title</label>
                    <input type="text" name="title" class="form-control" id="task_title" aria-describedby="emailHelp" value="{{ old('title') }}">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Descripton</label>
                    <textarea name="description" id="" cols="30" rows="5" class="form-control" >{{ old('description') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Task Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="done" {{ old('status') === 'done' ? 'selected' : '' }}>Done</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Task Imagae</label>
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
