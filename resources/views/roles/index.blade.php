@extends('layouts.app')
@inject('model', 'App\Models\Role')
@section('content')
    @section('page_title')
        Roles
    @endsection
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">List Of Roles</h3>
                <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                    <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    @if(Auth::user()->can('create role'))
                        <a href="{{url(route('role.create'))}}" class="btn btn-primary"><i class="fa fa-plus"></i> New Role</a>
                    @else
                        <a href="{{url(route('role.create'))}}" class="btn btn-primary disabled"><i class="fa fa-plus"></i> New Role</a>
                    @endif
                </div>
                @include('flash::message')
                @if(count($records))
                    <div class="table-responsive">
                        <table class="table table-bordered" id="example1">
                            <thead>
                                <tr class="bg-info">
                                    <th class="text-center">#</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Display Name</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">Permissions</th>
                                    <th class="text-center">Edit</th>
                                    <th class="text-center">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($records as $record)
                                 <tr id="removable{{$record->id}}">
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td class="text-center">{{$record->name}}</td>
                                    <td class="text-center">{{$record->display_name}}</td>
                                    <td class="text-center">{{$record->description}}</td>
                                    <td>
                                        @foreach($record->permissions as $permission)
                                            <span class="label label-success">
                                                {{$permission->name}}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        @if(Auth::user()->can('edit role'))
                                            <a href="{{url(route('role.edit',$record->id))}}" class="btn btn-success"><i class="fa fa-edit btn-xs"></i> Edit</a>
                                        @else
                                            <a href="{{url(route('role.edit',$record->id))}}" class="btn btn-success disabled"><i class="fa fa-edit btn-xs"></i> Edit</a>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if(Auth::user()->can('delete role'))
                                            {!! Form::model($model,[
                                                    'action'=>['RoleController@destroy',$record->id],
                                                    'method'=>'delete'
                                                ]) !!}
                                                <button id="{{$record->id}}" data-token="{{ csrf_token() }}"
                                                    data-route="{{URL::route('role.destroy',$record->id)}}"
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
