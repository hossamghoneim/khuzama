@extends('layouts.app',['title'=>' |  Edit User:' .$user->name])

@section('styles')
    {{ Html::style('plugins/select2/css/select2.min.css') }}
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
                                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                                <li class="breadcrumb-item active">Edit User </li>
                            </ol>
                        </div>
                        <h4 class="page-title">
                            <i class="fa fa-plus-circle"></i>
                            <span>Edit User: {{ $user->name }}</span>
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
                                    {{ Form::model($user,['route'=>['users.update',$user->id],'id'=>'users-form']) }}

                                    {{ method_field('PATCH') }}
                                    <div class="row">
                                        <div class="form-group col-md-6 {{ $errors->has('name') ?'has-error' : ''}}">
                                            {{ Form::label('name', 'Name') }}
                                            {{ Form::text('name',null,['class'=>'form-control']) }}
                                            @if ($errors->has('role'))
                                                <span class="text-danger">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6 {{ $errors->has('role') ? ' has-error' : '' }}">
                                            <label for="role">
                                                <span class="text-danger">*</span>
                                                <span>  Role</span>
                                            </label>
                                            <select name="role" id="role" class="form-control select2">
                                                <option value="" selected disabled>Please Select User Role</option>
                                                @foreach($roles as $id => $name)
                                                    <option {{ ( (old('role') ? old('role') : $user->roles->first()->id ) == $id  ? 'selected' : '')}} value="{{ $id }}">{{ $name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('role'))
                                                <span class="text-danger">
                                                        <strong>{{ $errors->first('role') }}</strong>
                                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">

                                        <div class="form-group col-md-6">

                                            {{ Form::label('mobile', 'Mobile Number') }}
                                            <span style="font-size: 11px" class="text-warning">(Changing mobile number requires re-verification)</span>

                                            <div class="input-group {{ $errors->has('mobile') ? 'has-error' :'' }}">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">+966</span>
                                                </div>

                                                {{ Form::number('mobile',null,['class'=>'form-control']) }}
                                            </div>
                                            <span style="font-size: 11px" class="text-warning">
                                                <i class="fa fa-info-circle"></i>
                                                <span>(The mobile number should be written in this format "5xxxxxxxx")</span>
                                                </span>
                                            <br>
                                            @if ($errors->has('mobile'))
                                                <span class="text-danger">
                                                        <strong>{{ $errors->first('mobile') }}</strong>
                                                    </span>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6 {{ $errors->has('email') ?'has-error' : ''}}">
                                            {{ Form::label('email','E-mail Addres') }}
                                            <span style="font-size: 11px" class="text-warning">(Changing email requires re - verification)</span>

                                            {{ Form::text('email',null,['class'=>'form-control']) }}
                                            @if ($errors->has('email'))
                                                <span class="text-danger">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-md-6 {{ $errors->has('password') ?'has-error' : ''}}">
                                            {{ Form::label('password', 'Password') }}
                                            <span style="font-size: 11px" class="text-warning">(Leave the fields blank for not changing your password)</span>
                                            {{ Form::password('password',['class'=>'form-control']) }}
                                            @if ($errors->has('password'))
                                                <span class="text-danger">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6">
                                            {{ Form::label('password_confirmation', 'Password Confirmation') }}
                                            {{ Form::password('password_confirmation',['class'=>'form-control']) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button onclick="
                                                $(this).prop('disabled', true);
                                                $('#spinner-submit').toggleClass('d-none','show');
                                                $('#users-form').submit();"
                                                class="btn btn-success right">
                                            <i id="spinner-submit" class="fa fa-spinner fa-spin d-none"></i>
                                            <span><i class="fa fa-check-circle"></i> Save </span>
                                        </button>
                                    </div>
                                    {{ Form::close() }}

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
    {{ Html::script('plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js')}}
    {{ Html::script('plugins/parsleyjs/parsley.min.js')}}
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection