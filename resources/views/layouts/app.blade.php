<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name') . ' | ' . 'Admin Panel' . (isset($title) ? $title : '') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="" name="description" />
    <meta name="author" content="shicosoft">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('styles')

    <!-- App css -->
    {{ Html::style('assets/css/bootstrap.min.css') }}
    {{ Html::style('assets/css/icons.css') }}
    {{ Html::style('assets/css/style.css') }}

    {{ Html::script('assets/js/modernizr.min.js') }}

</head>


<body>


<!-- Navigation Bar-->
@include('partials.header')
<!-- End Navigation Bar-->


<!-- Wrapper -->
@yield('content')
<!-- end wrapper -->


<!-- Footer -->
@include('partials.footer')
<!-- End Footer -->


</body>
</html>