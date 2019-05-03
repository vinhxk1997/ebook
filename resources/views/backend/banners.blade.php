@extends('backend.master')
@section('title', __('tran.banner'))
@section('content')
<div class="card mb-3">
    <div class="card-header">
        <i class="fas fa-user"></i>
        {{ trans('tran.banner') }}</div>
    <hr>
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>{{ trans('tran.id') }}</th>
                        <th>{{ trans('tran.banner_name') }}</th>
                        <th>{{ trans('tran.place') }}</th>
                        <th>{{ trans('tran.url') }}</th>
                        <th>{{ trans('tran.image') }}</th>
                        <th>{{ trans('tran.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($banners as $banner)
                    <tr>
                        <td>{{ $banner->id }}</td>
                        <td>{{ $banner->name }}</td>
                        <td>{{ $banner->place }}</td>
                        <td>{{ $banner->url }}</td>
                        <td>{{ $banner->image }}</td>
                        <td>
                            <button href="#" class="btn btn-outline-primary btnEditBanner" data-id="{{ $banner->id }}" data-toggle="modal" data-target="#myModalBanner{{ $banner->id }}"><i class="fa fa-pen"></i>
                            @lang('tran.edit')</button>
                            <!-- Modal banner-->
                            <div class="modal fade" id="myModalBanner{{ $banner->id }}" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">{{ trans('tran.report') }}</h4>
                                        </div>
                                        {!! Form::open(['route' => ['update_banner', $banner->id], 'method' => 'POST', 'files' => true]) !!}
                                        <div class="modal-body">
                                            <div class="form-group">
                                                {!! Form::label(trans('tran.name'), '', ['class' => '']) !!}
                                                {!! Form::text('name', null, ['class' => 'form-control', 'autofocus', 'id' => 'banner-name', 'required']) !!}
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label(trans('tran.url'), '', ['class' => '']) !!}
                                                {!! Form::text('url', null, ['class' => 'form-control', 'id' => 'banner-url', 'required']) !!}
                                            </div>
                                            <div class="form-group row"> 
                                                {!! Form::label('image', trans('tran.image'), ['class' => 'col-md-2 col-form-label text-md-right']) !!}
                                                <div>
                                                    <img src="#" alt="Image" class="img-thumbnail" id="avatar"/>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    {!! Form::file('avatar_file', ['id' => 'avatar_file']) !!}
                                                    @if ($errors->has('avatar_file'))
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $errors->first('avatar_file') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            {!! Form::button(trans('tran.cancel'), ['class' => 'btn btn-dark pull-left', 'data-dismiss' => 'modal', 'type' => 'button']) !!}
                                            {!! Form::button(trans('tran.create'), ['class' => 'btn btn-info pull-right', 'type' => 'submit']) !!}
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                            <!-- end modal -->
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
