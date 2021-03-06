@extends('layouts.app')
@inject('resturant', 'App\Models\Resturant')
@section('content')
    @section('page_title')
       Edit Product
    @endsection
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Form TO Edit Product</h3>
                <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                    <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">                          
                {!! Form::model($model,[
                        'action'=>['ProductController@update',$model->id],
                        'method'=>'put',
                        'files'=>'true'
                    ]) !!}
                    <div class="form-group">
                        <label for="name">Name</label>
                        {!! Form::text('name',null,[
                            'class'=>'form-control',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        {!! Form::text('description',null,[
                            'class'=>'form-control',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        {!! Form::number('price',null,[
                            'class'=>'form-control',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        <label for="preparing_time">Preparing_Time</label>
                        {!! Form::time('preparing_time',null,[
                            'class'=>'form-control',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        {!! Form::file('image',null,[
                            'class'=>'form-control',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        <label for="resturant_id">Resturant Name</label>
                        {!! Form::select('resturant_id',$resturant->pluck('name','id'),null,[
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
