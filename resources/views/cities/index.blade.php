@extends('layouts.app')
@inject('model', 'App\Models\City')
@section('content')
    @section('page_title')
        Cities
    @endsection
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">List Of Cities</h3>
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
                                'action'=>'CityController@index',
                                'id'=>'myForm',
                                'role'=>'form',
                                'method'=>'GET',
                                ])!!}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::text('name',request()->input('name'),[
                                    'class'=>'form-control',
                                    'placeholder' =>'City Name'
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-flat bg-navy"><i class="fa fa-search"></i></button>
                                @if(Auth::user()->can('create city'))
                                    <a href="{{url(route('city.create'))}}" class="btn btn-primary"><i class="fa fa-plus"></i> New City</a>
                                @else
                                    <a href="{{url(route('city.create'))}}" class="btn btn-primary disabled"><i class="fa fa-plus"></i> New City</a>
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
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Edit</th>
                                    <th class="text-center">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($records as $record)
                                 <tr id="removable{{$record->id}}">
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td class="text-center">{{$record->name}}</td>

                                     <td class="text-center">
                                         @if(Auth::user()->can('edit city'))
                                            <a href="{{url(route('city.edit',$record->id))}}" class="btn btn-success"><i class="fa fa-edit btn-xs"></i> Edit</a>
                                         @else
                                            <a href="{{url(route('city.edit',$record->id))}}" class="btn btn-success disabled"><i class="fa fa-edit btn-xs"></i> Edit</a>
                                         @endif
                                     </td>

                                     @if(Auth::user()->can('delete city'))
                                         <td class="text-center">
                                            {!! Form::model($model,[
                                                    'action'=>['CityController@destroy',$record->id],
                                                    'method'=>'delete'
                                                ]) !!}
                                                <button id="{{$record->id}}" data-token="{{ csrf_token() }}"
                                                    data-route="{{URL::route('city.destroy',$record->id)}}"
                                                    type="button" class="destroy btn btn-danger"><i
                                                    class="fa fa-trash-o"></i> Delete</button>
                                            {!! Form::close() !!}
                                        </td>
                                     @else
                                         <td class="text-center">
                                             <button type="button" class="destroy btn btn-danger disabled"><i class="fa fa-trash-o"></i> Delete</button>
                                         </td>
                                     @endif
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
