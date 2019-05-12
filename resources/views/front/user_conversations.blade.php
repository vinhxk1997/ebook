@extends('front.layouts.user')
@section('title', "Administrator (@admin)'s activity")

@section('tab_content')
<div class="user-activity row">
    @if (auth()->user() && auth()->user()->id == $user->id)
        {!! Form::open(['method' => 'POST', 'files' => true]) !!}
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif
            <div class="form-group row">
            {!! Form::label('name', trans('tran.name'), ['class' => 'col-md-4 col-form-label text-md-right']) !!}
            <div class="col-md-8">
                {!! Form::text('name', $user->full_name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'autofocus']) !!}
                @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
            </div>
            </div>
            <div class="form-group row">
                {!! Form::label('address', trans('tran.address'), ['class' => 'col-md-4 col-form-label text-md-right']) !!}
                <div class="col-md-8">
                    {!! Form::textarea('address', ($user->profile == null) ? '' : $user->profile->address, ['class' => 'form-control' . ($errors->has('address') ? ' is-invalid' : ''), 'rows' => '3']) !!}
                </div>
                @if ($errors->has('address'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('address') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group row"> 
                {!! Form::label('avatar', trans('tran.avatar'), ['class' => 'col-md-4 col-form-label text-md-right']) !!}
                <div class="col-md-2">
                    <img src="{{ get_avatar($user, 1) }}" alt="Image" class="img-thumbnail" id="avatar"/>
                </div>
            </div>
            <div class="form-group row">
                <div class="col offset-md-4">
                    {!! Form::file('avatar_file', ['id' => 'avatar_file']) !!}
                    @if ($errors->has('avatar_file'))
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $errors->first('avatar_file') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                {!! Form::label('cover-img', trans('tran.cover_img'), ['class' => 'col-md-4 col-form-label text-md-right']) !!}
                <div class="col-md-6">
                    <img src="{{ get_user_cover($user, 0) }}" alt="Image" class="img-thumbnail" id="cover_image">
                </div>
            </div>
            <div class="form-group row">
                <div class="col offset-md-4">
                    {!! Form::file('cover_image', ['id' => 'cover_image']) !!}
                    @if ($errors->has('cover_image'))
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $errors->first('cover_image') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                {!! Form::label('email', 'Email', ['class' => 'col-md-4 col-form-label text-md-right']) !!}
                <div class="col-md-8">
                    {!! Form::email('email', $user->email, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'disabled']) !!}
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                {!! Form::label('pasword', trans('tran.newpassword'), ['class' => 'col-md-4 col-form-label text-md-right']) !!}
                <div class="col-md-8">
                    {!! Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : '')]) !!}
                    @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                {!! Form::label('password-confirm', trans('tran.pass_confirm'), ['class' => 'col-md-4 col-form-label text-md-right']) !!}
                <div class="col-md-8">
                    {!! Form::password('password_confirmation', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : '')]) !!}
                </div>
            </div>
            <div class="form-group row">
                {!! Form::label('about', trans('tran.aboutme'), ['class' => 'col-md-4 col-form-label text-md-right']) !!}
                <div class="col-md-8">
                    {!! Form::textarea('about', ($user->profile == null) ? '' : $user->profile->about, ['class' => 'form-control' . ($errors->has('about') ? ' is-invalid' : ''), 'rows' => '3']) !!}
                </div>
                @if ($errors->has('about'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('about') }}</strong>
                </span>
                @endif
            </div>
            <div class="for-group row mb-0">
                <div class="col offset-md-4">
                    {!! Form::submit(trans('tran.update'), ['class' => 'btn btn-primary' ]) !!}
                    {!! Form::reset(trans('tran.cancel'), ['class' => 'btn btn-secondary' ]) !!}
                </div>
            </div>
        {!! Form::close() !!}
    @else
        {!! Form::open() !!}
        <div class="form-group row">
        {!! Form::label('name', trans('tran.name'), ['class' => 'col-md-4 col-form-label text-md-right']) !!}
        <div class="col-md-8">
            {!! Form::text('name', $user->full_name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'disabled', 'autofocus']) !!}
            @if ($errors->has('name'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
            @endif
        </div>
        </div>
        <div class="form-group row">
            {!! Form::label('address', trans('tran.address'), ['class' => 'col-md-4 col-form-label text-md-right']) !!}
            <div class="col-md-8">
                {!! Form::textarea('address', ($user->profile == null) ? '' : $user->profile->address, ['class' => 'form-control' . ($errors->has('address') ? ' is-invalid' : ''), 'disabled', 'rows' => '3']) !!}
            </div>
            @if ($errors->has('address'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('address') }}</strong>
            </span>
            @endif
        </div>
        <div class="form-group row">
            {!! Form::label('email', 'Email', ['class' => 'col-md-4 col-form-label text-md-right']) !!}
            <div class="col-md-8">
                {!! Form::email('email', $user->email, ['class' => 'form-control' . ($errors->has('email') ? 'is-invalid' : ''), 'disabled']) !!}
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            {!! Form::label('about', trans('tran.aboutme'), ['class' => 'col-md-4 col-form-label text-md-right']) !!}
            <div class="col-md-8">
                {!! Form::textarea('about', ($user->profile == null) ? '' : $user->profile->about, ['class' => 'form-control' . ($errors->has('about') ? ' is-invalid' : ''), 'disabled', 'rows' => '3']) !!}
            </div>
            @if ($errors->has('about'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('about') }}</strong>
            </span>
            @endif
        </div>
        {!! Form::close() !!}
    @endif
</div>
@endsection
