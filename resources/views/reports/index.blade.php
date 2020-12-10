@extends('layouts.app',['title' => ' | Dashboard'])

@section('content')

    <div class="wrapper">
        <div class="container-fluid">

            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="btn-group pull-right">
                            <ol class="breadcrumb hide-phone p-0 m-0">
                                <li class="breadcrumb-item active"><a href="{{ route('reports') }}">Reports</a></li>
                            </ol>
                        </div>
                        <h4 class="page-title">Reports</h4>
                    </div>
                </div>
            </div>
            <!-- end page title end breadcrumb -->


            <div class="row">

                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="widget-panel widget-style-2 bg-white">
                        <i class="md md-account-circle text-primary"></i>
                        <h2 class="m-0 text-dark counter font-600">{{ \App\Models\Client::query()
                    ->count() }}</h2>
                        <div class="text-muted m-t-5">Clients</div>
                    </div>
                </div>


                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="widget-panel widget-style-2 bg-white">
                        <i class="fa fa-product-hunt text-warning"></i>
                        <h2 class="m-0 text-dark counter font-600">
                            {{ \App\Models\Product::query()->count()  }}
                        </h2>
                        <div class="text-muted m-t-5">Products</div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="widget-panel widget-style-2 bg-white">
                        <i class="fa fa-tasks text-info"></i>
                        <h2 class="m-0 text-dark counter font-600">
                            {{ \App\Models\Order::query()->count()  }}
                        </h2>
                        <div class="text-muted m-t-5">Orders</div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="widget-panel widget-style-2 bg-white">
                        <i class="fa fa-users text-custom"></i>
                        <h2 class="m-0 text-dark counter font-600">
                            {{ \App\User::query()->count() }}
                        </h2>
                        <div class="text-muted m-t-5">Users </div>
                    </div>
                </div>

            </div>

        </div> <!-- end container -->
    </div>
    <!-- end wrapper -->


@endsection

@section('scripts')

@endsection