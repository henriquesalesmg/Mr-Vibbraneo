<?php

namespace App\Http\Classes;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskUsers
{
    public static function selected($task, $id)
    {
        if(count(User::find($task->users()->get()->pluck('id'))) > 0){
            for($i=0; $i<count(User::find($task->users()->get()->pluck('id'))); $i++){
                if(User::find($task->users()->get()->pluck('id'))[$i]->id == $id){
                    $selected = 'selected'; break;
                }else{
                    $selected = '';
                }
            }
        }else{
            $selected = "";
        }
        return $selected;
    }
    public static function contributor($task)
    {
        $task_users = User::find($task->users()->get()->pluck('id'));
        for($i=0; $i<count($task_users); $i++){
            if(($task_users[$i]->id == Auth::user()->id) || ($task->manager_id == Auth::user()->id)):
                $response = true; break;
            else:
                $response = false;
            endif;
        }
        return $response;
    }
}
