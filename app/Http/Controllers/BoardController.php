<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    public function add(Request $request){
        $user=Auth::guard("api")->user();
        $board=$user->boards()->create([
            "name"=>$request->name,
        ]);
        return response()->json([
            "board"=>$board
        ]);
    }
    public function boards(Request $request){
        $user=Auth::guard("api")->user();


        return response()->json([
            "data"=>$user->boards->load("tasks")
        ]);
    }

    public function task(Request $request){
        $tasks=$request->task;
        $descriptions=$request->description;
        foreach ($tasks as $key=>$task){
            if(!is_null($task)){
                Task::create([
                    "board_id"=>$key,
                    "name"=>$task,
                    "description"=>$descriptions[$key],
                ]);
            }
        }
        return response()->json([
            "message"=>"ok"
        ],200);
    }


    public function taskUpdate(Request $request){
        $board=Board::find($request->board_id);
        $task=Task::find($request->task_id);
        $task->board_id=$board->id;
        $task->save();
        return response()->json([
            "message"=>"ok"
        ],200);
    }
}
