@extends('layouts.app')
@inject('model', 'App\User')
@section('content')
    @section('page_title')
        Users
    @endsection
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">List Of Users</h3>
                <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                    <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <a href="{{url(route('user.create'))}}" class="btn btn-lg bg-primary"><i class="fa fa-plus"></i> New user</a>
                @include('flash::message')
                @if(count($records))                 
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="bg-info">
                                    <th class="text-center">#</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Roles list</th>
                                    <th class="text-center">Edit</th>
                                    <th class="text-center">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($records as $record)                              
                                 <tr id="removable{{$record->id}}">
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td class="text-center">{{$record->name}}</td>
                                    <td class="text-center">{{$record->email}}</td>
                                    <td>
                                        @foreach($record->roles as $role)
                                            <span class="label label-success">
                                                {{$role->name}}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        <a href="{{url(route('user.edit',$record->id))}}" class="btn btn-success"><i class="fa fa-edit btn-xs"></i>
                                    Edit</a>
                                    </td>
                                    <td class="text-center">
                                        {!! Form::model($model,[
                                                'action'=>['UserController@destroy',$record->id],
                                                'method'=>'delete'
                                            ]) !!}                                          
                                            <button id="{{$record->id}}" data-token="{{ csrf_token() }}"
                                                data-route="{{URL::route('user.destroy',$record->id)}}"
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
