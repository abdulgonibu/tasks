<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskCreateRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::orderBy('id', 'desc')->paginate(10);
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskCreateRequest $request)
    {
        // Validation

        // Create in DB 
        $task = new Task();
        $task->title = $request->title;
        $task->slug = Str::of($request->title)->slug();
        $task->description = $request->description;
        $task->status = $request->status;
        //Task image
        $file = $request->file('image');
        $image_name = Str::of($request->title)->slug() . '-' . time() . '.' . $file->extension();
        $task->image = $file->storePubliclyAs('public/tasks', $image_name);
        $task->save();

        //proceess the slug again and save
        $task->slug = $task->slug . '_' . $task->id;
        $task->save();
        session()->flash('success', 'task has been created successfully!');
        //redirect
        return redirect()->route('index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit($id_or_slug)
    {
        $task = $this->getTaskByIdOrSlug($id_or_slug);

        // if no task found, then session error message that task not found.
        if (!$task) {
            session()->flash('error', 'Sorry, Task not found !');
            return redirect()->route('index');
        }

        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(TaskCreateRequest $request, $id_or_slug)
    {
        $task = $this->getTaskByIdOrSlug($id_or_slug);

        // if no task found, then session error message that task not found.
        if (!$task) {
            session()->flash('error', 'Sorry, Task not found !');
            return redirect()->route('index');
        }

        $task->title = $request->title;
        $task->slug = Str::of($request->title)->slug();
        $task->description = $request->description;
        $task->status = $request->status;
        //Task image
        if ($request->image)
        {
            if ($task->image) {
                Storage::delete($task->image);
            }
      

            $file = $request->file('image');
            $image_name = Str::of($request->title)->slug() . '-' . time() . '.' . $file->extension();
            $task->image = $file->storePubliclyAs('public/tasks', $image_name);
        }
        $task->save();

        //proceess the slug again and save
        $task->slug = $task->slug . '_' . $task->id;
        $task->save();
        session()->flash('success', 'task has been created successfully!');
        //redirect
        return redirect()->route('index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }

    public function getTaskByIdOrSlug($id_or_slug)
    {
        if (is_numeric($id_or_slug)) {
            return Task::find($id_or_slug);
        } else {
            return Task::where('slug', $id_or_slug)->first();
        }
    }
}
