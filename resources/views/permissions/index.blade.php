@extends('layouts.app')
@inject('model', 'App\Models\Permission')
@section('content')
    @section('page_title')
        Permissions
    @endsection
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">List Of Permissions</h3>
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
                    @if(Auth::user()->can('create permission'))
                        <a href="{{url(route('permission.create'))}}" class="btn bg-primary"><i class="fa fa-plus"></i> New Permission</a>
                    @else
                        <a href="{{url(route('permission.create'))}}" class="btn bg-primary disabled"><i class="fa fa-plus"></i> New Permission</a>
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
                                    <th class="text-center">Routes</th>
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
                                    <td class="text-center">{{$record->routes}}</td>
                                    <td class="text-center">
                                        @if(Auth::user()->can('edit permission'))
                                            <a href="{{url(route('permission.edit',$record->id))}}" class="btn btn-success"><i class="fa fa-edit btn-xs"></i> Edit</a>
                                        @else
                                            <a href="{{url(route('permission.edit',$record->id))}}" class="btn btn-success disabled"><i class="fa fa-edit btn-xs"></i> Edit</a>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if(Auth::user()->can('delete permission'))
                                        {!! Form::model($model,[
                                                'action'=>['PermissionController@destroy',$record->id],
                                                'method'=>'delete'
                                            ]) !!}
                                            <button id="{{$record->id}}" data-token="{{ csrf_token() }}"
                                                data-route="{{URL::route('permission.destroy',$record->id)}}"
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
