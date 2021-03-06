@extends('layouts.app')
@inject('model', 'App\Models\Product')
@inject('resturant','App\Models\Resturant')
@section('content')
    @section('page_title')
        Products
    @endsection
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">List Of Products</h3>
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
                                'action'=>'ProductController@index',
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
                                @if(Auth::user()->can('create role'))
                                <a href="{{url(route('product.create'))}}" class="btn btn-primary"><i class="fa fa-plus"></i> New Product</a>
                                @else
                                <a href="{{url(route('product.create'))}}" class="btn btn-primary disabled"><i class="fa fa-plus"></i> New Product</a>
                                @endif
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
                                    <th class="text-center">#</th>
                                    <th class="text-center">name</th>
                                    <th class="text-center">description</th>
                                    <th class="text-center">price</th>
                                    <th class="text-center">preparing_time</th>
                                    <th class="text-center">image</th>
                                    <th class="text-center">resturant_name</th>
                                    <th class="text-center">disabled</th>
                                    <th class="text-center">Edit</th>
                                    <th class="text-center">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($records as $record)
                                 <tr id="removable{{$record->id}}">
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td class="text-center">{{$record->name}}</td>
                                    <td class="text-center">{{$record->description}}</td>
                                    <td class="text-center">{{$record->price}}</td>
                                    <td class="text-center">{{$record->preparing_time}}</td>
                                    <td class="text-center"><img src="{{asset($record->image)}}" style="height:100px"></td>
                                    <td class="text-center">{{$record->resturant->name}}</td>
                                    <td class="text-center">{{$record->disabled}}</td>
                                    <td class="text-center">
                                        @if(Auth::user()->can('edit product'))
                                        <a href="{{url(route('product.edit',$record->id))}}" class="btn btn-success"><i class="fa fa-edit btn-xs"></i> Edit</a>
                                        @else
                                            <a href="{{url(route('product.edit',$record->id))}}" class="btn btn-success disabled"><i class="fa fa-edit btn-xs"></i> Edit</a>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if(Auth::user()->can('delete product'))
                                        {!! Form::model($model,[
                                                'action'=>['ProductController@destroy',$record->id],
                                                'method'=>'delete',
                                                'files'=>'true'
                                            ]) !!}
                                            <button id="{{$record->id}}" data-token="{{ csrf_token() }}"
                                                data-route="{{URL::route('product.destroy',$record->id)}}"
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
                        NoData
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
