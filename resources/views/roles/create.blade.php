@extends('layouts.app',['title'=>' |  Add new Role '])

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
                                <li class="breadcrumb-item active">add new Role </li>
                            </ol>
                        </div>
                        <h4 class="page-title">
                            <i class="fa fa-plus-circle"></i>
                            <span>add new Role</span>
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
                                    <form method="POST" action="{{ route('roles.store') }}" id="form">
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="form-group col-md-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                                                <label for="name">Rule Name</label>
                                                <input type="text" id="name" name="name" class="form-control" placeholder="" required>
                                                @if ($errors->has('name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-12 {{ $errors->has('role_permissions') ? ' has-error' : '' }}">
                                                <label for="role_permissions">Select the Rule Permissions</label>

                                                <select multiple="multiple" class="multi-select"  id="role_permissions" name="role_permissions[]" data-plugin="multiselect" data-selectable-optgroup="true">

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



            load_per();
            $("#role_permissions").multiSelect({
                selectableHeader: "<div class='text-primary'> All Permissions</div>",
                selectionHeader: "<div class='text-primary'> Selected Permissions</div>",
            });
            /*$("#role_permissions").multiSelect({
                selectableHeader: "<div class='text-primary'>كل التصاريح</div>",
                selectionHeader: "<div class='text-primary'>التصاريح المضافة</div>",
            });*/

            function  load_per() {

                var guard_name = 'web';
                var route = '{{ url('/roles/getGuardPermissions?guard_name=') }}'+guard_name;

                $('#role_permissions').html('');
                /* Load potions into postion <select> */
                $.getJSON(route, function(jsonData){

                    console.log(jsonData);
                    var options = '';
                    $.each(jsonData, function(group, element) {

                        options += '<optgroup label="'+group+'">';

                        Object.keys(element).forEach(function(key) {

                            var value = element[key];
                            options += '<option value="'+key+'">'+value+'</option>';

                        });
                        options += '</optgroup>'

                        /*Object.keys(element).forEach(function(key) {
                            var value = element[key];
                            // use "key" and "value" here...
                            $('#role_permissions').multiSelect('addOption',
                                { value: key, text: value, index: 0, nested: group  }
                            );
                        });*/

                    });

                    $('#role_permissions').html(options);
                    $('#role_permissions').multiSelect('refresh');


                });


            }

        });
    </script>
@endsection