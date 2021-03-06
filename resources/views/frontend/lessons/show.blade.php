@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.lesson.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.lessons.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.lesson.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $lesson->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.lesson.fields.course') }}
                                    </th>
                                    <td>
                                        {{ $lesson->course->title ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.lesson.fields.title') }}
                                    </th>
                                    <td>
                                        {{ $lesson->title }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.lesson.fields.thumbnail') }}
                                    </th>
                                    <td>
                                        @foreach($lesson->thumbnail as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                                <img src="{{ $media->getUrl('thumb') }}">
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.lesson.fields.short_text') }}
                                    </th>
                                    <td>
                                        {{ $lesson->short_text }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.lesson.fields.long_text') }}
                                    </th>
                                    <td>
                                        {!! $lesson->long_text !!}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.lesson.fields.video') }}
                                    </th>
                                    <td>
                                        @if($lesson->video)
                                            <a href="{{ $lesson->video->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.lesson.fields.link_video') }}
                                    </th>
                                    <td>
                                        {{ $lesson->link_video }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.lesson.fields.position') }}
                                    </th>
                                    <td>
                                        {{ $lesson->position }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.lesson.fields.is_published') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $lesson->is_published ? 'checked' : '' }}>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.lessons.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection