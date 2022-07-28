<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OperationController extends Controller
{
    public function dashboard()
    {
        $data['tasks'] = Task::all();
        $data['tasks_user'] = Task::where("manager_id", Auth::user()->id)->get();
        return view('dashboard', $data);
    }

    public function about()
    {
        return view("about");
    }

    public function list($id)
    {
        $data['task'] = Task::find(intval($id));
        $data['tasks'] = Task::where("task_id", intval($id))->get();
        $data['title'] =  $data['task']->title.' of sub-lists';
        return view("pages.subtasks.index", $data)->layout('layouts.admin', $data);
    }
    public function status(Request $request)
    {
        list($status, $id) = explode('/', $request->values);
        $task = Task::find(intval($id));
        $task->status = intval($status);
        $task->save();
        session()->flash('success', 'List status updated successfully!');
        return redirect()->route("lists.index");
    }
    public function new($id)
    {
        $data['task'] = Task::find(intval($id));
        $data['title'] = "Add SUBLIST for ". $data['task']->title;
        return view("pages.subtasks.create", $data)->layout('layouts.admin', $data);
    }
    public function remove($id)
    {
        $task = Task::find(intval($id));
        $task->task_id = null;
        $task->status = 0;
        $task->save();
        session()->flash('success', 'Sublist updated to Main List!');
        return redirect()->route("lists.index");
    }
}
