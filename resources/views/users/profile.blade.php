@extends('layouts.app')
@section('content')
@section('page_title')
    Edit Profile
@endsection
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Form TO Edit Profile</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                    <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
            @include('partials.validation_errors')
            {!! Form::model($model,[
                    'action'=>['UserController@update_profile',$model->id],
                    'method'=>'post'
                ]) !!}
            <div class="form-group">
                <label for="name">Name</label>
                {!! Form::text('name',null,[
                    'class'=>'form-control',
                ]) !!}
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                {!! Form::email('email',null,[
                    'class'=>'form-control',
                ]) !!}
            </div>
            <div class="form-group">
                <button class="btn btn-success" type="submit"><i class="fa fa-edit btn-xs"></i> Edit</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</section>
@endsection

