@extends('layouts.app')
@inject('model', 'App\Models\Payment')
@inject('resturant','App\Models\Resturant')
@section('content')
    @section('page_title')
        Payments
    @endsection
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">List Payments</h3>
                <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                    <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                @include('flash::message')
                <div class="filter">
                    {!! Form::open([
                                'action'=>'PaymentController@index',
                                'id'=>'myForm',
                                'role'=>'form',
                                'method'=>'GET',
                                ])!!}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::select('resturant_id',$resturant->pluck('name','id'),null,[
                                        'class'=>'form-control',
                                        'placeholder' =>'Resturant Name'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-flat bg-navy"><i class="fa fa-search"></i></button>
                                    <a href="{{url(route('payment.create'))}}" class="btn btn-flat bg-navy"><i class="fa fa-plus"></i> New Payment</a>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
                @if(count($records))
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="bg-info">
                                    <th class="text-center">#</th>
                                    <th class="text-center">Amount</th>
                                    <th class="text-center">Note</th>
                                    <th class="text-center">Resturant Name</th>
                                    <th class="text-center">Edit</th>
                                    <th class="text-center">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($records as $record)                              
                                 <tr id="removable{{$record->id}}">
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td class="text-center">{{$record->amount}}</td>
                                    <td class="text-center">{{$record->note}}</td>
                                    <td class="text-center">{{$record->resturant->name}}</td>
                                    <td class="text-center">
                                        <a href="{{url(route('payment.edit',$record->id))}}" class="btn btn-success"><i class="fa fa-edit btn-xs"></i>
                                    Edit</a>
                                    </td>
                                    <td class="text-center">
                                        {!! Form::model($model,[
                                                'action'=>['PaymentController@destroy',$record->id],
                                                'method'=>'delete'
                                            ]) !!}                                          
                                            <button id="{{$record->id}}" data-token="{{ csrf_token() }}"
                                                data-route="{{URL::route('payment.destroy',$record->id)}}"
                                                type="button" class="destroy btn btn-danger"><i
                                                class="fa fa-trash-o"></i> Delete</button>                                          
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$records->appends(request()->query())->links()}}
                    </div>
                @else
                    <div class="alert alert-danger" role="alert">
                        NoData
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
