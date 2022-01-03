@extends('layouts.admin')
@section('content')
@can('todo_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.todo.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.todo.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.todo.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Role">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.todo.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.todo.fields.task') }}
                        </th>
                        <th>
                            {{ trans('cruds.todo.fields.note') }}
                        </th>
                        <th>
                        {{ trans('cruds.todo.fields.category') }}

                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($todos as $key => $todo)
                        <tr data-entry-id="{{ $todo->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $todo->id ?? '' }}
                            </td>
                            <td>
                                {{ $todo->task ?? '' }}
                            </td>
                            <td>
                                {{ $todo->note ?? '' }}
                            </td>
                            <td>
                                {{ $todo->category->name ?? '' }}
                            </td>
                            <td>
                                @can('todo_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.todo.show', $todo->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('todo_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.todo.edit', $todo->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('todo_delete')
                                    <form action="{{ route('admin.todo.destroy', $todo->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('role_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.roles.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-Role:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection