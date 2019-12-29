@extends('layouts.app')
@inject('model', 'App\Models\Order')
@section('content')
    @section('page_title')
        Orders
    @endsection
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">List Of Orders</h3>
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
                                'action'=>'OrderController@index',
                                'id'=>'myForm',
                                'role'=>'form',
                                'method'=>'GET',
                                ])!!}
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::number('id',request()->input('id'),[
                                    'class'=>'form-control',
                                    'placeholder' =>'Order Number'
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-flat bg-navy btn-block"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                @if(count($records))
                    <div class="table-responsive">
                        <table class="table table-bordered" id="example1">
                            <thead>
                                <tr class="bg-info">
                                    <th class="text-center">Order ID</th>
                                    <th class="text-center">State</th>
                                    <th class="text-center">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($records as $record)
                                 <tr id="removable{{$record->id}}">
                                    <td class="text-center">
                                        @if(Auth::user()->can('show order'))
                                            <a href="{{url(route('order.show',$record->id))}}" class="btn btn-sm btn-info">{{$record->id}}</a>
                                        @else
                                            <a href="{{url(route('order.show',$record->id))}}" class="btn btn-sm btn-info disabled">{{$record->id}}</a>
                                        @endif
                                    </td>
                                    <td class="text-center">{{$record->state}}</td>
                                    <td class="text-center">
                                        @if(Auth::user()->can('delete order'))
                                        {!! Form::model($model,[
                                                'action'=>['OrderController@destroy',$record->id],
                                                'method'=>'delete'
                                            ]) !!}
                                            <button id="{{$record->id}}" data-token="{{ csrf_token() }}"
                                                data-route="{{URL::route('order.destroy',$record->id)}}"
                                                type="button" class="destroy btn btn-danger"><i
                                                class="fa fa-trash-o"></i> Delete</button>
                                        {!! Form::close() !!}
                                        @else
                                            <button type="button" class="destroy btn btn-danger disabled"><i class="fa fa-trash-o"></i> Delete</button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$records->appends(request()->query())->links()}}
                    </div>
                @else
                    <div class="alert alert-danger" role="alert">
                        No Data
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
