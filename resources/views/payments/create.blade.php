@extends('layouts.app')
@inject('model', 'App\Models\Payment')
@section('content')
    @section('page_title')
       Create Payment
    @endsection
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Form TO Create Payment</h3>
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
                        'action'=>'PaymentController@store',
                        'method'=>'POST',
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
                        <label for="resturant_id">Resturant_name</label>
                        {!! Form::select('resturant_id',$resturants,[],[
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
