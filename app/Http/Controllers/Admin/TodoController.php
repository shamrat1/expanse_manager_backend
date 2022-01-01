<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Gate;
use App\Todo;

class TodoController extends Controller
{
    public function index()
    {
        if(!Gate::denies('admin_todo_list')){
            $todos = Todo::with('category','user')->latest()->paginate(35);
            return view('admin.todos.index',compact('todos'));
        }
        abort_if(Gate::denies('own_todo_list'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $todos = Todo::with('category')->where('created_by',auth()->id())->latest()->paginate(35);
        return view('admin.todos.index',compact('todos'));
    }
}
