<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="shicosoft">

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <title>{{ config('app.name') }}</title>

    {{ Html::style('assets/css/bootstrap.min.css') }}
    {{ Html::style('assets/css/icons.css') }}
    {{ Html::style('assets/css/style.css') }}

    {{ Html::script('assets/js/modernizr.min.js') }}


</head>
<body>

<div class="account-pages"></div>
<div class="clearfix"></div>
<div class="wrapper-page">
    <div class=" card-box">
        <div class="panel-heading">
            <h4 class="text-center"> Reset Password </h4>
        </div>

        <div class="p-20">
            <form method="post" action="{{ route('password.email') }}" role="form" class="text-center">
                @csrf
                @if (session('status'))

                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                        ×
                    </button>
                    {{ session('status') }}
                </div>
                @endif


                <div class="form-group m-b-0 {{ $errors->has('email') ? ' has-error' : '' }}">

                    <div class="input-group">
                        <input type="email" name="email" class="form-control" placeholder="Enter Email" value="{{ old('email') }}" required="">
                        <span class="input-group-append">
                            <button type="submit" class="btn btn-primary w-sm waves-effect waves-light">
                                Reset
                            </button>
                        </span>

                        @if ($errors->has('email'))
                            <br>
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>



            </form>
        </div>
    </div>


</div>



<!-- jQuery  -->
{{ Html::script('assets/js/jquery.min.js') }}
{{ Html::script('assets/js/popper.min.js') }}
{{ Html::script('assets/js/bootstrap.min.js') }}
{{ Html::script('assets/js/waves.js') }}
{{ Html::script('assets/js/jquery.slimscroll.js') }}
{{ Html::script('assets/js/jquery.scrollTo.min.js') }}
<!-- App js -->
{{ Html::script('assets/js/jquery.core.js') }}
{{ Html::script('assets/js/jquery.app.js') }}


</html>