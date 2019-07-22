@extends('layouts.app')
@inject('model', 'App\Models\PaymentMethod')
@section('content')
    @section('page_title')
       Create PaymentMethod
    @endsection
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Form TO Create PaymentMethods</h3>
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
                        'action'=>'PaymentMethodController@store',
                        'method'=>'POST'
                    ]) !!}
                    <div class="form-group">
                        <label for="name">Name</label>
                        {!! Form::text('name',null,[
                            'class'=>'form-control',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection
