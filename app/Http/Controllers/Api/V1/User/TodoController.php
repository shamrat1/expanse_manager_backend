<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Todo;
use Carbon\Carbon;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::with('category')->latest()->paginate(25);

        return response()->json($todos);
    }

    public function store(Request $request)
    {
        $request->validate([
            "category_id" => "nullable|numeric|exists:categories,id",
            "task" => "required|string",
            "note" => "nullable|string",
            "reminder_at" => "nullable|string"
        ]);
        $userId = auth('api')->id();
        $data = $request->all();
        if($request->has('reminder_at')){
            $data['reminder_at'] = Carbon::parse($request->reminder_at);
        }
        $data['created_by_id'] = $userId;
        Todo::create($data);

        return response()->json("Task Created Successfully");
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            "category_id" => "nullable|numeric|exists:category,id",
            "task" => "required|string",
            "note" => "nullable|string",
            "reminder_at" => "nullable|string"
        ]);
        $userId = auth('api')->id();
        $data = $request->all();
        Todo::where('id',$id)->where('created_by_id',$userId)->first()->update($data);

        return response()->json("Task Updated Successfully");
    }

    public function toggleComplete($id)
    {
        $userId = auth('api')->id();
        $todo = Todo::where('id',$id)->where('created_by_id',$userId)->firstOrFail();
        $todo->complete = !$todo->complete;
        $todo->update();

        return response()->json("Task Updated Successfully");
    }



    public function destroy(Request $request, $id)
    {
        $cat = Todo::findOrFail($id);
        $user = auth('api')->id();

        if($cat->created_by_id == $user){
            $cat->delete();
            return response()->json("Todo Deleted successfully.",200);
        }else{
            return response()->json("Operation not allowed.",422);
        }
    }
}
