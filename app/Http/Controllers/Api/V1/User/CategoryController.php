<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::when($request->type,function($q) use($request){
            $q->where('type',$request->type);
        })->paginate(25);

        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|String",
            "type" => "required|string",
            "color" => "nullable|string",
        ]);
        $userId = auth('api')->id();
        $data = $request->all();
        $data['created_by_id'] = $userId;
        Category::create($data);

        return response()->json("Category Created Successfully");
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            "name" => "required|String",
            "type" => "required|string",
            "color" => "nullable|string",
        ]);
        $userId = auth('api')->id();
        $data = $request->all();
        Category::find($id)->update($data);

        return response()->json("Category Updated Successfully");
    }
}
