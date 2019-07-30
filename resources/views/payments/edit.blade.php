@extends('layouts.app')
@inject('resturant', 'App\Models\Resturant')
@section('content')
    @section('page_title')
       Edit Payment
    @endsection
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Form TO Edit Payment</h3>
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
                        'action'=>['PaymentController@update',$model->id],
                        'method'=>'put'
                    ]) !!}
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        {!! Form::number('amount',null,[
                            'class'=>'form-control',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        <label for="note">Note</label>
                        {!! Form::text('note',null,[
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
