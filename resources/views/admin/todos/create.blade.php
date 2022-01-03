@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.todo.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.todo.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                <label for="task">{{ trans('cruds.todo.fields.task') }}*</label>
                <input type="text" required id="task" name="task" class="form-control" value="{{ old('task', isset($todo) ? $todo->task : '') }}">
                @if($errors->has('task'))
                    <em class="invalid-feedback">
                        {{ $errors->first('task') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.todo.fields.task_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
                <label for="permissions">{{ trans('cruds.todo.fields.category') }}</label>
                <select name="category" id="category" class="form-control select2">
                    @foreach($categories as $id => $category)
                        <option value="{{ $id }}" {{ old('category', isset($todo) ? $todo->todo_category_id : '') == $id ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
                @if($errors->has('category'))
                    <em class="invalid-feedback">
                        {{ $errors->first('category') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.role.fields.permissions_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('note') ? 'has-error' : '' }}">
                <label for="note">{{ trans('cruds.todo.fields.note') }}</label>
                <textarea id="note" name="note" class="form-control" cols="30" rows="5">{{ old('note', isset($todo) ? $todo->note : '') }}</textarea>
                @if($errors->has('note'))
                    <em class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.todo.fields.note_helper') }}
                </p>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection