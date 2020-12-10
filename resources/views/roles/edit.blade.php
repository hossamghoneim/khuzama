@extends('layouts.app',['title'=>' |  Edit Role: '.$role->name])

@section('styles')
    {{ Html::style('plugins/select2/css/select2.min.css') }}
    {{ Html::style('plugins/multiselect/css/multi-select.css') }}
    <style>
        .ms-container{
            width: 100%;
        }
    </style>
@endsection

@section('content')

    <div class="wrapper">
        <div class="container-fluid" >
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="btn-group pull-right">
                            <ol class="breadcrumb hide-phone p-0 m-0">
                                <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                                <li class="breadcrumb-item active"> Edit Role </li>
                            </ol>
                        </div>
                        <h4 class="page-title">
                            <i class="fa fa-plus-circle"></i>
                            <span>Edit Role: {{ $role->name }}</span>
                        </h4>
                    </div>
                </div>
            </div>
            <!-- end page title end breadcrumb -->
            <div class="row">

                <div class="col-md-12">
                    <div class="card card-box">

                        <div class="card-body">
                            {{-- dd(auth()->user()->favorite(\App\File::class)) --}}
                            <div class="row">
                                <div class="col-md-12">

                                    @include('flash::message')
                                    <form method="POST" id="form" action="{{ route('roles.update',$role->id) }}">
                                        {{ method_field('PATCH') }}
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="form-group col-md-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                                                <label for="name">اسم الصلاحية</label>
                                                <input type="text" value="{{ old('name') ? old('name') : $role->name }}" id="name" name="name" class="form-control" placeholder="اكتب اسم الصلاحية" required>
                                                @if ($errors->has('name'))
                                                    <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12 {{ $errors->has('role_permissions') ? ' has-error' : '' }}">
                                                <label for="role_permissions">اختر التصاريح للصلاحية</label>

                                                <select multiple="multiple" class="multi-select"  id="role_permissions" name="role_permissions[]" data-plugin="multiselect" data-selectable-optgroup="true">

                                                    @foreach($all_permissions as $key => $permission)
                                                        @foreach($permission as $id => $name)
                                                            @if(in_array($id,$expects))
                                                                <optgroup label="{{ $key }}">
                                                                    <option selected value="{{ $id }}"> {{ $name }}</option>
                                                                </optgroup>
                                                            @else
                                                                <optgroup label="{{ $key }}">
                                                                    <option value="{{ $id }}"> {{ $name }}</option>
                                                                </optgroup>
                                                        @endif
                                                    @endforeach
                                                @endforeach

                                                </select>

                                                @if ($errors->has('role_permissions'))
                                                    <span class="help-block">
                                            <strong>{{ $errors->first('role_permissions') }}</strong>
                                        </span>
                                                @endif
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button onclick="
                                                $(this).prop('disabled', true);
                                                $('#spinner-submit').toggleClass('d-none','show');
                                                $('#form').submit();"
                                                            class="btn btn-success right">
                                                        <i id="spinner-submit" class="fa fa-spinner fa-spin d-none"></i>
                                                        <span><i class="fa fa-check-circle"></i> Save </span>
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </form>

                                </div>

                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <hr>
@endsection

@section('scripts')
    {{ Html::script('plugins/select2/js/select2.min.js') }}

    {{ Html::script('plugins/multiselect/js/jquery.multi-select.js') }}
    {{ Html::script('plugins/jquery-quicksearch/jquery.quicksearch.js') }}
    <script>
        $(document).ready(function() {



            $("#role_permissions").multiSelect({
                selectableHeader: "<div class='text-primary'> All Permissions</div>",
                selectionHeader: "<div class='text-primary'> Selected Permissions</div>",
            });


        });
    </script>
@endsection