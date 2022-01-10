<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class TodoCategoryController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('todo_categories_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $categories = Category::where('type','todo')->latest()->paginate(35);
        return view('admin.todoCategories.index',compact('categories'));
    }

    public function create()
    {
        abort_if(Gate::denies('todo_categories_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.todoCategories.create');
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('todo_categories_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            "name" => "required|string",
            "color" => "required|string",
        ]);

        $data = $request->all();
        $data["type"] = "todo";
        Category::create($data);

        return redirect()->route('admin.todo-categories.index');
    }

    public function edit(Request $request,$id)
    {
        abort_if(Gate::denies('todo_categories_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $cat = Category::find($id);
        return view('admin.todoCategories.edit', compact('cat'));
    }

    public function update(Request $request, $id)
    {
        abort_if(Gate::denies('todo_categories_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            "name" => "required|string",
            "color" => "required|string",
        ]);
        $cat = Category::find($id);
        $cat->update($request->all());
        return redirect()->route('admin.todo-categories.index');
    }

    public function delete(Request $request, Category $cat)
    {
        abort_if(Gate::denies('todo_categories_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $cat->delete();
        return redirect()->route('admin.todo-categories.index');
    }
}
