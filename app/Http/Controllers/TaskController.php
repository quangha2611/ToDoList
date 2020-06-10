<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('layouts.home');
    }

    public function getIndex()
    {
        //
        $tasks = Task::all();
        sleep(0.5);
        return response()->json($tasks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        //validation
        $this->validate($request,[
            'content' => 'required|min:3|max:200',
            'due_date' => 'required',
        ]);
        //store
        $task = new Task;
        $task->content = $request->content;
        $task->complete = 0;
        $task->due_date = $request->due_date;
        $task->save();
        return redirect()->route('task.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function updateTask(Request $request)
    {
        //
        $task = Task::findOrFail($request->id);
        $task->content = $request->content;
        $task->complete = $request->complete;
        $task->due_date = $request->due_date;
        $task->save();
        return response()->json($task);
    }    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function deleteTask(Request $request)
    {   
        //
        $task = Task::findOrFail($request->id)->delete();
        return response()->json($task);
    }

}
