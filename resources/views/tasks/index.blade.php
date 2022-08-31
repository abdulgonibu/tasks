@extends('layouts.master')
@section('content')
    <div class="container">
        @include('partials.messages')

        <h2 class="my-2">
            My Tasks
            <a href="{{ route('tasks.create') }}" class="btn btn-primary mx-2 btn-sm">+ New Task</a>
        </h2>
        <div class="row">

            @foreach ($tasks as $task)
                <div class="col-md-4 my-3">
                    <div class="shadow p-3">
                        <h4>{{ $task->title }}
                            @include('tasks.partials.status', [
                                'task' => $task,
                            ])
                        </h4>
                        <p>
                            {!! $task->description !!}
                        </p>
                        <p>
                            <img src="{{  Storage::url($task->image)}}" alt="" width="50">
                        </p>

                        <div>
                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-success btn-sm">Edit</a>
                            <a href="{{ route('tasks.destroy', $task->id) }}" class="btn btn-danger ml-2 btn-sm">Delete</a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection
