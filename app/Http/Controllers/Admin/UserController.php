<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Task, User};
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['users'] = User::all();
        return view("admin.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required'
        ]);

        $user = new User();

        $user->fill($request->only([
            'name', 'email'
        ]));
        $user->password = bcrypt($request->get('password'));
        $user->save();

        $role = config('roles.models.role')::where('id', '=', intval($request->role))->first();
        $user->attachRole($role);

        session()->flash('success', 'User successfully registered!');
        return redirect()->route('users.index');
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
        $data["user"] = User::find($id);
        return view("admin.create", $data);
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
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required'
        ]);
        $user = User::find($id);

        $user->fill($request->only([
            'name', 'email'
        ]));
        if ($request->password)
            $user->password = bcrypt($request->get('password'));

        $user->save();

        $user->detachAllRoles();
        $role = config('roles.models.role')::where('id', '=', intval($request->role))->first();
        $user->attachRole($role);

        session()->flash('success', 'User successfully updated!');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->id != $id) {
            $user = User::find($id);
            $tasks = Task::where("manager_id", $user->id)->get();
            foreach ($tasks as $task) {
                $task->manager_id = Auth::user()->id;
                $task->save();
            }
            $user->delete();
            session()->flash('success', 'User successfully deleted!');
        } else {
            session()->flash('warning', 'You cannot delete the user himself!');
        }
        return redirect()->route("users.index");
    }
}
