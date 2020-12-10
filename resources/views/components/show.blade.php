@extends('layouts.app',['title' => ' | Show Product: '. $product->name])

@section('styles')
    {{ Html::style('plugins/sweet-alert2/sweetalert2.min.css') }}
@endsection


@section('content')

    <div class="wrapper">
        <div class="container-fluid">

            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="btn-group pull-right">
                            <ol class="breadcrumb hide-phone p-0 m-0">
                                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                                <li class="breadcrumb-item active">show Product </li>
                            </ol>
                        </div>
                        <h4 class="page-title">
                            <i class="fa fa-eye"></i>
                            <span>show Product: {{ $product->name }}</span>
                        </h4>
                    </div>
                </div>
            </div>
            <!-- end page title end breadcrumb -->


            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <strong>Product Name: </strong>
                                                    {{ $product->name }}
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Product Client Name: </strong>
                                                <a href="{{ route('clients.show',$product->client->id) }}">
                                                    {{ $product->client->name }}
                                                </a>

                                            </li>
                                            <li class="list-group-item">
                                                <strong>Product Barcode: </strong>
                                                    {{ $product->barcode }}
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Product Type: </strong>
                                                {{ $product->type }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-group">

                                            <li class="list-group-item">
                                                <strong>Product Size: </strong>
                                                    {{ $product->size }} MG

                                            </li>
                                            <li class="list-group-item">
                                                <strong>Product Number of Refill: </strong>
                                                    {{ $product->number_of_refill }}
                                            </li>

                                            <li class="list-group-item">
                                                <strong> concentration: </strong>
                                                    {{ $product->alchol_perfume ? $product->concentration : 'none' }}
                                            </li>
                                            <li class="list-group-item">
                                                <strong> Alcohol Type: </strong>
                                                    {{ $product->alchol_perfume ? $product->alcohol_type : 'none' }}
                                            </li>
                                            <li class="list-group-item">
                                                <strong> Number of Extras: </strong>
                                                    {{ $product->extras ? $product->number_of_extras : 'none' }}
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                    <h5>notes</h5>
                                    {{ $product->notes ?$product->notes : 'no notes'  }}
                                    </div>
                                </div>
                                <div class="row">
                                    <h5><i class="fa fa-files-o"></i> Files:</h5>
                                </div>
                                <div class="row">
                                    <a target="_blank" href="{{ $product->attachment('design_file')->url }}" class="btn btn-success">
                                        <i class="fa fa-cloud-download"></i>
                                        <span>Download Product Design File</span>
                                    </a>
                                </div>
                                <br>

                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <h4>Product Orders ({{ $product->orders->count() }})</h4>
                                <table width="100%" class="table  table-bordered">
                                    <thead>
                                    <tr>

                                        <td>Status</td>
                                        <td>Order Number</td>
                                        <td>Batch Number</td>
                                        <td>Product Name </td>
                                        <td>Quantity </td>
                                        <td>Type </td>
                                        <td>created at</td>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @forelse($product->orders->load(['product']) as $order)
                                        <tr>
                                            <td>
                                                @if($order->status === 'delivered')
                                                    <b class="text-success">{{ $order->status }}</b>
                                                @else
                                                    {{ $order->status }}
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('orders.show',$order->id) }}">
                                                    {{ $order->order_number }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('orders.show',$order->id) }}">
                                                    {{ $order->batch_number }}
                                                </a>
                                            </td>

                                            <td>{{ $order->product->name }}</td>
                                            <td>{{ $order->quantity }}</td>
                                            <td>{{ $order->type }}</td>
                                            <td>{{ $order->created_at }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="7">empty</td>
                                        </tr>
                                    @endforelse
                                    </tbody>

                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end container -->
        </div>
    </div>
    <!-- end wrapper -->


@endsection

@section('scripts')

    {{ Html::script('plugins/sweet-alert2/sweetalert2.min.js') }}

    <script>
        $(document).ready(function() {

        } );
    </script>
@endsection