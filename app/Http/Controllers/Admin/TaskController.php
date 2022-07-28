<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Task, User};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvitationToListMail;
use Illuminate\Database\QueryException;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['tasks'] = Task::where("task_id", null)->get();
        $data['title'] = 'Lists';
        return view("pages.tasks.index", $data)->layout('layouts.admin', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = "List Create";
        $data['users'] = User::whereHas(
            'roles',
            function ($q) {
                $q->where('slug', 'user');
            }
        )->get();
        return view("pages.tasks.create", $data)->layout('layouts.admin', $data);
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
            $task->fill($request->only([
                'title', 'description'
            ]));
            $task->status = intval($request->status);
            $task->manager_id = Auth::user()->id;
            $task->save();

            $contributors = $request->contributors;
            for($i=0; $i<count($contributors); $i++){
                $user = User::find(intval($contributors[$i]));
                $user->tasks()->attach($task->id);
                Mail::to($user->email)->send(new InvitationToListMail($user, Auth::user()->name, url("lists")));
            }

            session()->flash('success', 'List successfully registered!');
            return redirect()->route('lists.index');

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
        $data['task'] = Task::find($id);
        $data['title'] = "Edit ".$data['task']->title;
        $data['users'] = User::whereHas(
            'roles',
            function ($q) {
                $q->where('slug', 'user');
            }
        )->get();
        return view("pages.tasks.create", $data)->layout('layouts.admin', $data);
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
            $task->fill($request->only([
                'title', 'description'
            ]));
            $task->status = intval($request->status);
            $task->save();

            $task_users = User::find($task->users()->get()->pluck('id'));
            for($i=0; $i<count($task_users); $i++){
                $task_users[$i]->tasks()->detach($task->id);
            }

            $contributors = $request->contributors;
            for($i=0; $i<count($contributors); $i++){
                $user = User::find(intval($contributors[$i]));
                $user->tasks()->attach($task->id);
                $user->save();
                Mail::to($user->email)->send(new InvitationToListMail($user, Auth::user()->name, url("lists")));
            }

            session()->flash('success', 'List updated successfully!');
            return redirect()->route('lists.index');

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
        if($task){
            $subtasks = Task::where("task_id", $id)->get();
            foreach($subtasks as $sub){
                $sub->delete();
            }
        }
        $task_users = User::find($task->users()->get()->pluck('id'));
        for($i=0; $i<count($task_users); $i++){
            $task_users[$i]->tasks()->detach($task->id);
        }
        $task->delete();

        session()->flash('success', 'List successfully deleted!!');
        return redirect()->route("lists.index");
    }

}
