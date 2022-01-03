<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Gate;
use App\Todo;
use App\TodoCategory;

class TodoController extends Controller
{
    public function index()
    {

        abort_if(Gate::denies('todo_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $todos = Todo::with('category')->latest()->paginate(35);
        return view('admin.todos.index',compact('todos'));
    }

    public function create()
    {
        abort_if(Gate::denies('todo_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $categories = TodoCategory::all()->pluck('name','id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.todos.create', compact('categories'));
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('todo_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            "task" => "required|string",
        ]);
        Todo::create($request->all());
        return redirect()->route('admin.todo.index');
    }

    public function edit(Request $request,Todo $todo)
    {
        abort_if(Gate::denies('todo_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $categories = TodoCategory::all()->pluck('name','id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.todos.edit', compact('categories','todo'));
    }

    public function update(Request $request, Todo $todo)
    {
        abort_if(Gate::denies('todo_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            "task" => "required|string",
        ]);
        $todo->update($request->all());
        return redirect()->route('admin.todo.index');

    }

    public function destroy(Request $request, Todo $todo)
    {
        abort_if(Gate::denies('todo_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $todo->delete();
        return redirect()->route('admin.todo.index');
    }
}
