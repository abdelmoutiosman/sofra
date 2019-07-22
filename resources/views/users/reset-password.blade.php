@extends('layouts.app')
@section('page_title')
    Change Password
@endsection
@section('content')
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                            title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                {!! Form::open([
                    'action'=>'UserController@changePasswordSave',
                    'id'=>'myForm',
                    'role'=>'form',
                    'method'=>'POST'
                ])!!}
                @include('flash::message')
                @include('partials.validation_errors')              
                    <label>Password</label>
                    <div class="form-group">
                    <input class="form-control" type="password" name="old-password"/>
                    </div>
                    <label>New Password</label>
                    <div class="form-group">
                    <input class="form-control" type="password" name="password"/>
                    </div>
                    <label>Password Confirmation</label>
                    <div class="form-group">
                    <input class="form-control" type="password" name="password_confirmation"/>
                    </div>
                <!-- /.box -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                {!! Form::close()!!}
            </div>
        </div>
    </section>
@endsection