<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $task = Task::find($id);
        $task->task = $request->task;
        $task->save();
        return 200;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'task' => 'required|max:255'
        ]);

        $newTask = new Task;
        $newTask->task = $request->task;
        $newTask->save();
        return 200;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function getTasks(Task $task)
    {
        // return Task::latest()->get();
        return Task::orderBy('id', 'DESC')->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function showincompleted(Task $task)
    {
        // return Task::latest()->get();
        return Task::orderBy('id', 'DESC')->where('completed', false)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function showcompleted(Task $task)
    {
        return Task::orderBy('id', 'DESC')->where('completed', true)->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $task = Task::find($id);
        $task->completed = !$task->completed;
        $task->save();
        return 200;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $taskToDelete = Task::find($id)->delete();
        return 200;
    }
}
