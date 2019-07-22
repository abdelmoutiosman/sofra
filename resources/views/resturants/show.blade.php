@extends('layouts.app')

@section('content')
@section('page_title')
    Details of {{$record->name}}
@endsection
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">details of Resturant</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                    <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-info">
                            <th class="text-center">#</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">City Name</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Phone</th>
                            <th class="text-center">Minimum Order</th>
                            <th class="text-center">Delivery Cost</th>
                            <th class="text-center">WhattsApp</th>
                            <th class="text-center">image</th>
                            <th class="text-center">Availability</th>
                            <th class="text-center">Classifications</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">{{$record->id}}</td>
                            <td class="text-center">{{$record->name}}</td>
                            <td class="text-center">{{$record->city->name}}</td>
                            <td class="text-center">{{$record->email}}</td>
                            <td class="text-center">{{$record->phone}}</td>
                            <td class="text-center">{{$record->minimum_order}}</td>
                            <td class="text-center">{{$record->delivery_cost}}</td>
                            <td class="text-center">{{$record->whattsapp}}</td>
                            <td><img src="{{asset($record->image)}}" style="height:50px"></td>
                            <td class="text-center">{{$record->availability}}</td>
                            <td>
                                @foreach($record->classifications as $classification)
                                    <span class="label label-success">
                                        {{$classification->name}}
                                    </span>
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table>
                <a href="{{url(route('resturant.index'))}}" class="btn btn-sm btn-primary">Back <<</a>
            </div>
        </div>
    </div>
</section>
@endsection
