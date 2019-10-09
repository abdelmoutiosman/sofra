@extends('layouts.app')
@inject('resturant','App\Models\Resturant')
@section('content')
    @section('page_title')
        Offers
    @endsection
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">List Of Offers</h3>
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
                                'action'=>'OfferController@index',
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
                                <a href="{{url(route('offer.create'))}}" class="btn btn-flat bg-navy"><i class="fa fa-plus"></i> New offer</a>
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
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Starting At</th>
                                    <th class="text-center">Ending At</th>
                                    <th class="text-center">Image</th>
                                    <th class="text-center">Resturant Name</th>
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
                                    <td class="text-center">{{$record->starting_at}}</td>
                                    <td class="text-center">{{$record->ending_at}}</td>
                                    <td class="text-center"><img src="{{asset($record->image)}}" style="height:100px"></td>
                                    <td class="text-center">{{$record->resturant->name}}</td>
                                    <td class="text-center">
                                            <a href="{{url(route('offer.edit',$record->id))}}" class="btn btn-success"><i class="fa fa-edit btn-xs"></i>
                                        Edit</a>
                                    <td class="text-center">
                                        {!! Form::open([
                                                'action'=>['OfferController@destroy',$record->id],
                                                'method'=>'delete'
                                            ]) !!}                                          
                                            <button id="{{$record->id}}" data-token="{{ csrf_token() }}"
                                                data-route="{{URL::route('offer.destroy',$record->id)}}"
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
