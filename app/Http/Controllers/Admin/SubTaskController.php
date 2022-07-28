<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Task, User};
use Illuminate\Database\QueryException;

class SubTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        try {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
            ]);

            $task = new Task();
            $task->task_id = intval($request->task_id);
            $task->fill($request->only([
                'title', 'description'
            ]));
            $task->save();

            session()->flash('success', 'Sublist successfully registered!');
            return redirect()->route("sublists", ['id' => $task->task_id]);

        } catch (QueryException $exception) {
            session()->flash('warning', 'Incorrect information!');
            return redirect()->back();
        }
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
        $data['subtask'] = Task::find(intval($id));
        $data['task'] = Task::find($data['subtask']->task_id);
        $data['title'] = "Sublist change to ". $data['task']->title;
        return view("pages.subtasks.create", $data)->layout('layouts.admin', $data);
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
        try {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
            ]);

            $task = Task::find($id);
            $task->task_id = intval($request->task_id);
            $task->fill($request->only([
                'title', 'description'
            ]));
            $task->save();

            session()->flash('success', 'SubList successfully updated!');
            return redirect()->route("sublists", ['id' => $task->task_id]);

        } catch (QueryException $exception) {
            session()->flash('warning', 'Incorrect information!');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        $task_users = User::find($task->users()->get()->pluck('id'));
        for($i=0; $i<count($task_users); $i++){
            $task_users[$i]->tasks()->detach($task->id);
        }
        $task_id = $task->task_id;
        $task->delete();

        session()->flash('success', 'Sub-List successfully deleted!!');
        return redirect()->route("sublists", ['id' => $task_id]);
    }
}
