@extends('layouts.app')
@inject('model', 'App\Models\Role')
@inject('perm', 'App\Models\Permission')
@section('content')
    @section('page_title')
       Create Role
    @endsection
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Form TO Create Role</h3>
                <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                    <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                @include('partials.validation_errors')                
                {!! Form::model($model,[
                        'action'=>'RoleController@store',
                        'method'=>'POST'
                    ]) !!}
                    <div class="form-group">
                        <label for="name">Name</label>
                        {!! Form::text('name',null,[
                            'class'=>'form-control',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        <label for="display_name">Display Name</label>
                        {!! Form::text('display_name',null,[
                            'class'=>'form-control',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        {!! Form::textarea('description',null,[
                            'class'=>'form-control',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        <label for="permission_list">Permission list</label>
                        <br>
                            <input id="select-all" type="checkbox"><label for='select-all'>Select All</label>
                        <br>
                        <div class="row">
                            @foreach($perm->all() as $permission)
                                <div class="col-sm-3">
                                    <div class="checkbox">
                                        <label>
                                            {{-- {!! Form::checkbox('permission_list[]',null,[
                                                'class'=>'form-control',
                                                ]) 
                                            !!} --}}
                                            <input type="checkbox" name="permission_list[]" value="{{$permission->id}}">
                                            {{ $permission->display_name}}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        $("#select-all").click(function(){
            $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
        });
    </script>
@endpush
