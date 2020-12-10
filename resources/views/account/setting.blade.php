@extends('layouts.app',['title'=>' |  Account Settings'])

@section('content')

    <div class="wrapper">
            <div class="container-fluid" >
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                            <div class="btn-group pull-right">
                                <ol class="breadcrumb hide-phone p-0 m-0">
                                    <li class="breadcrumb-item"><a href="">Account</a></li>
                                    <li class="breadcrumb-item active">Settings </li>
                                </ol>
                            </div>
                            <h4 class="page-title">Account Settings</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title end breadcrumb -->
                <div class="row">

                    <div class="col-md-8">
                        <div class="card card-default">

                            <div class="card-header"><i class="fa fa-cogs"></i>
                                <span> Account Settings</span>
                            </div>

                            <div class="card-body">
                                {{-- dd(auth()->user()->favorite(\App\File::class)) --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        @if (count($errors) > 0)
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        @include('flash::message')

                                        {{ Form::model(auth()->user(),['route'=>'account.settings.update','method'=>'PATCH','id'=>'settings-form']) }}

                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                {{ Form::label('name', 'Name') }}
                                                {{ Form::text('name',null,['class'=>'form-control']) }}
                                            </div>
                                            <div class="form-group col-md-12">
                                                {{ Form::label('username', 'username') }}
                                                {{ Form::number('username',null,['class'=>'form-control']) }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">

                                            <!--<div class="form-group col-md-6">

                                                {{ Form::label('mobile', 'Mobile Number') }}

                                                <span style="font-size: 11px" class="text-warning">(Changing mobile number requires re-verification)</span>



                                                <div class="input-group {{ $errors->has('mobile') ? 'has-error' :'' }}">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">+966</span>
                                                    </div>
                                                    <input value="{{ old('mobile') ? old('mobile') : str_replace( '00966','', auth()->user()->mobile) }}" id="mobile" type="text" class="form-control" name="mobile" value="{{ old('mobile') }}" >

                                                </div>
                                                <span style="font-size: 11px" class="text-warning">
                                                <i class="fa fa-info-circle"></i>
                                                <span>(The mobile number should be written in this format "5xxxxxxxx")</span>
                                            </span>
                                            </div>-->
                                            <div class="form-group col-md-6">
                                                {{ Form::label('email','E-mail Addres') }}
                                                <span style="font-size: 11px" class="text-warning">(Changing email requires re - verification)</span>

                                                {{ Form::text('email',null,['class'=>'form-control']) }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                {{ Form::label('password', 'Password') }}
                                                <span style="font-size: 11px" class="text-warning">(Leave the fields blank for not changing your password)</span>
                                                {{ Form::password('password',['class'=>'form-control']) }}
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
                                                $('#settings-form').submit();"
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

                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-default">

                                    <div class="card-header"><i class="fa fa-info-circle"></i>
                                        <span>  Account Status</span>
                                    </div>

                                    <div class="card-body">
                                        <table class="table table-responsive table-bordered">
                                            <tr>
                                                <td style="vertical-align: middle;">
                                                    <i class="fa fa-user-plus"></i>
                                                    <span>Registration Date</span>
                                                </td>

                                                <td>{{ auth()->user()->created_at->diffForHumans() }}</td>
                                            </tr>
                                            <tr>
                                                <td> <i class="fa fa-inbox"></i>
                                                    <span>E-mail Address</span>
                                                </td>
                                                @if(auth()->user()->email_confirmed)
                                                    <td class="text-success"> <i class="fa fa-check-circle"></i> <span>Active</span></td>
                                                @else
                                                    <td  class="text-warning"> <i class="fa fa-info-circle"></i> <span> not confirmed</span></td>
                                                @endif
                                            </tr>
                                            <!--<tr>
                                                <td>
                                                    <i class="md md-phone-android"></i>
                                                    <span> Mobile Number</span>
                                                </td>

                                                <td id="mobile_is_verify" class="text-success {{ auth()->user()->mobile_confirmed ? 'show' : 'd-none' }}"> <i class="fa fa-check-circle"></i> <span>Active</span></td>

                                                <td id="mobile_not_verify" class="text-warning {{ auth()->user()->mobile_confirmed ? 'd-none' : 'show' }}"> <i class="fa fa-info-circle"></i> <span>not confirmed</span></td>

                                            </tr>-->
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(!auth()->user()->email_confirmed )
                            <div id="account_verify" class="row">
                                <div class="col-md-12">
                                    <div class="card card-default">

                                        <div class="card-header"><i class="fa fa-check-circle"></i>
                                            <span> account activation </span>
                                        </div>

                                        <div class="card-body">
                                            <table class="table table-responsive table-bordered">
                                                @if(!auth()->user()->email_confirmed)
                                                    <tr class="text-center">
                                                        <td style="vertical-align: middle;">E-mail Address</td>
                                                        <td>
                                                            <div id="resend_email_message" class="alert d-none"></div>

                                                            <form action="{{ route('account.settings.emailTokenResend') }}" id="email-resend-form"></form>
                                                            <button id="email-resend-button" class="btn btn-primary btn-sm" onclick="
                                                $(this).prop('disabled', true);
                                                $('#spinner-resend-email').toggleClass('d-none','show');
                                                $('#inbox').toggleClass('d-none','show');
                                                $('#email-resend-form').submit();">
                                                                <i id="spinner-resend-email" class="fa fa-spinner fa-spin d-none"></i>
                                                                <i id="inbox" class="fa fa-inbox"></i>
                                                                <span> Send Verify Email  </span>
                                                            </button>
                                                        </td>
                                                    </tr>


                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

    </div>
    <hr>
@endsection

@section('scripts')
    <script>

        var table = $('.table');

        table.on( 'submit', 'tr #email-resend-form', function(event) {
            event.preventDefault();
            var resend_email_message = $('#resend_email_message');

            $.ajax({
                url: $('#email-resend-form').attr('action'),
                type:"POST",
                data: {
                    type:'email'
                },

                beforeSend:function () {

                    resend_email_message.removeClass('alert-danger');
                    resend_email_message.removeClass('alert-success');
                    resend_email_message.removeClass('d-none');
                    resend_email_message.addClass('d-none');
                    resend_email_message.html('')
                },

                success:function(){
                    resend_email_message.addClass('alert-success');
                    resend_email_message.html('Your verification email has been sent!');

                },error:function(data){
                    resend_email_message.addClass('alert-danger');
                    resend_email_message.html(data.responseJSON.message);
                    console.log(data);
                }

                ,complete: function () {

                    resend_email_message.toggleClass('d-none','show');

                    $('#email-resend-button').attr('disabled',false);
                    $('#spinner-resend-email').toggleClass('d-none','show');
                    $('#inbox').toggleClass('d-none','show');
                },
            }); //end of ajax
        });

        table.on( 'submit', 'tr #code-resend-form', function(event) {
            $('#success_resend').addClass('d-none');
            $('#code_error').addClass('d-none');

            event.preventDefault();
            $.ajax({
                url: $('#code-resend-form').attr('action'),
                type:"POST",
                data: {
                    type:'mobile'
                },

                success:function(data){

                    if (data){
                        $('#success_resend').html('Message has been sent!');
                        $('#success_resend').removeClass('d-none');
                    }else{
                        $('#code_error').html('Failed to send message!');
                        $('#code_error').removeClass('d-none');
                    }

                    $('#code-resend-button').attr('disabled',false);
                    $('#spinner-resend-code').toggleClass('d-none','show');
                    $('#code').toggleClass('d-none','show');

                },error:function(data){

                    $('#code_error').html(data.responseJSON.message);
                    $('#code_error').removeClass('d-none');

                    $('#code-resend-button').attr('disabled',false);
                    $('#spinner-resend-code').toggleClass('d-none','show');
                    $('#code').toggleClass('d-none','show');

                }
            }); //end of ajax

        });

        table.on( 'submit', 'tr #code-submit-form', function(event) {

            event.preventDefault();

            var mobile_code = $('#mobile-code').val();
            if(mobile_code.length != 6){
                $('#code_error').html('Verification code must be 6 characters!');
                $('#code_error').removeClass('d-none');
                $('#code-submit-button').prop('disabled', false);
                $('#spinner-submit-code').toggleClass('d-none','show');
                return false;
            }

            $.ajax({
                url: $('#code-submit-form').attr('action'),
                type:"POST",
                data: {
                    type:'mobile',
                    code: mobile_code
                },

                success:function(data){

                    $('#mobile_verify').hide();
                    $('#mobile_not_verify').toggleClass('d-none','show');
                    $('#mobile_is_verify').toggleClass('d-none','show');
                    if("{{auth()->user()->email_confirmed}}" == '1'){
                        $('#account_verify').hide();
                    }

                },error:function(){
                    $('#code_error').html('Incorrect code!');
                    $('#code_error').removeClass('d-none');
                    $('#code-submit-button').prop('disabled', false);
                    $('#spinner-submit-code').toggleClass('d-none','show');

                }
            }); //end of ajax

        });

    </script>
@endsection