@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.sale.title_singular') }}
    </div>

    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success col-md-6 offset-md-3">
     {{ session('success') }}
         </div>
@endif
@if(session('error'))
        <div class="alert alert-danger col-md-6 offset-md-3">
     {{ session('error') }}
         </div>
       @endif
        <form action="{{ route("admin.sales.import.store") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('file') ? 'has-error' : '' }}">
                <label for="file">{{ trans('cruds.sale.fields.sale_file') }}*</label>
                <input type="file" id="file" name="file" class="form-control" value="{{ old('file') }}" required>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection
