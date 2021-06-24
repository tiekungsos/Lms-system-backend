@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('lesson_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.lessons.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.lesson.title_singular') }}
                        </a>
                    </div>
                </div>
            @endcan
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.lesson.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Lesson">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.lesson.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.lesson.fields.course') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.lesson.fields.title') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.lesson.fields.thumbnail') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.lesson.fields.short_text') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.lesson.fields.video') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.lesson.fields.link_video') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.lesson.fields.position') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.lesson.fields.is_published') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lessons as $key => $lesson)
                                    <tr data-entry-id="{{ $lesson->id }}">
                                        <td>
                                            {{ $lesson->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $lesson->course->title ?? '' }}
                                        </td>
                                        <td>
                                            {{ $lesson->title ?? '' }}
                                        </td>
                                        <td>
                                            @foreach($lesson->thumbnail as $key => $media)
                                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                                    <img src="{{ $media->getUrl('thumb') }}">
                                                </a>
                                            @endforeach
                                        </td>
                                        <td>
                                            {{ $lesson->short_text ?? '' }}
                                        </td>
                                        <td>
                                            @if($lesson->video)
                                                <a href="{{ $lesson->video->getUrl() }}" target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $lesson->link_video ?? '' }}
                                        </td>
                                        <td>
                                            {{ $lesson->position ?? '' }}
                                        </td>
                                        <td>
                                            <span style="display:none">{{ $lesson->is_published ?? '' }}</span>
                                            <input type="checkbox" disabled="disabled" {{ $lesson->is_published ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            @can('lesson_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.lessons.show', $lesson->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('lesson_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.lessons.edit', $lesson->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('lesson_delete')
                                                <form action="{{ route('frontend.lessons.destroy', $lesson->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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

        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('lesson_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.lessons.massDestroy') }}",
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
    orderCellsTop: true,
    order: [[ 7, 'asc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Lesson:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection