@extends('layouts.app')

@section('content')
    @section('page_title')
        Contacts
    @endsection
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">List Of Contacts</h3>
                <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                    <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="filter">
                    {!! Form::open([
                                'action'=>'ContactController@index',
                                'id'=>'myForm',
                                'role'=>'form',
                                'method'=>'GET',
                                ])!!}
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::text('name',request()->input('name'),[
                                    'class'=>'form-control',
                                    'placeholder' =>'Contacts Name'
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
                                    <th class="text-center">#</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Phone</th>
                                    <th class="text-center">Content</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Contactable Name</th>
                                    <th class="text-center">Contactable Type</th>
                                    <th class="text-center">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($records as $record)
                                 <tr id="removable{{$record->id}}">
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td class="text-center">{{$record->name}}</td>
                                    <td class="text-center">{{$record->email}}</td>
                                    <td class="text-center">{{$record->phone}}</td>
                                    <td class="text-center">{{$record->content}}</td>
                                    <td class="text-center">{{$record->type}}</td>
                                    <td class="text-center">{{$record->contactable->name}}</td>
                                     <td class="text-center">{{$record->contactable_type}}</td>
                                    <td class="text-center">
                                        @if(Auth::user()->can('delete contact'))
                                        {!! Form::open([
                                                'action'=>['ContactController@destroy',$record->id],
                                                'method'=>'delete'
                                            ]) !!}
                                            <button id="{{$record->id}}" data-token="{{ csrf_token() }}"
                                                data-route="{{URL::route('contact.destroy',$record->id)}}"
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
