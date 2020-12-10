<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name') . ' | ' . 'Admin Panel' . (isset($title) ? $title : '') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="" name="description" />
    <meta name="author" content="shicosoft">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">

    {{ Html::style('assets/css/bootstrap.min.css') }}
    {{ Html::style('assets/css/icons.css') }}
    {{ Html::style('assets/css/style.css') }}
    {{ Html::script('assets/js/modernizr.min.js') }}


</head>
<body>

<div class="account-pages"></div>
<div class="clearfix"></div>

<div class="wrapper-page">
    <div class="ex-page-content text-center">
        <div class="text-error"><span class="text-primary">4</span><i class="ti-face-sad text-pink"></i><span class="text-info">4</span></div>
        <h2>Who0ps! Page not found</h2><br>
        <p class="text-muted">This page cannot found or is missing.</p>
        <p class="text-muted">Use the navigation above or the button below to get back and track.</p>
        <br>
        <a class="btn btn-default waves-effect waves-light" href="{{ route('home') }}"> Return Home</a>

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


</body>
</html>