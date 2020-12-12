@extends('layouts.app',['title' => ' | Show Item: '. $item->name])

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
                                <li class="breadcrumb-item"><a href="{{ route('items.index') }}">Items</a></li>
                                <li class="breadcrumb-item active">show Item </li>
                            </ol>
                        </div>
                        <h4 class="page-title">
                            <i class="fa fa-eye"></i>
                            <span>show Item: <span class="text-primary"> {{ $item->name }}</span>
                            <button id="print" class="btn btn-primary btn-lg" style="margin-left: 100px;">
                                    <i class="fa fa-print"></i>
                                    Print Item
                            </button>
                            <a id="duplicate" href="{{route('items.make_copy', $item->id)}}" class="btn btn-danger btn-lg" style="margin-left: 30px;">
                                    <i class="fa fa-copy"></i>
                                    Create Copy
                            </a>
                            </span>
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
                                                <strong>Item Name: </strong>
                                                    {{ $item->name }}
                                            </li>

                                            <li class="list-group-item">
                                                <strong>Item Code: </strong>
                                                    {{ $item->code }}
                                            </li>

                                            <li class="list-group-item">
                                                <strong>Item Print Code: </strong>
                                                    {{ $item->print_code }}
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Item Issue Date: </strong>
                                                    {{ $item->issue_date }}
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <div class="row">
                                    <div class="col-md-12">
                                    <h5>notes</h5>
                                    {{ $item->notes ? $item->notes : 'no notes'  }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                    <h5>Print Notes</h5>
                                    {{ $item->print_notes ? $item->print_notes : 'no notes'  }}
                                    </div>
                                </div>
                                <div class="row ">
                                    <h5><i class="fa fa-files-o"></i> Files:</h5>
                                </div>
                                <div class="row">

                                    @if(!$item->attachment('attachments'))
                                        <span>No Attachments</span>
                                    @else
                                        <a target="_blank" href="{{ $item->attachment('attachments')->url }}" class="btn btn-success">
                                            <i class="fa fa-cloud-download"></i>
                                            <span>Download Item Attached File</span>
                                        </a>
                                        @endif

                                </div>


                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <h4>Item Components ({{ $item->components->count() }})</h4>
                                <table width="100%" class="table  table-bordered">
                                    <thead>
                                    <tr>

                                        <td>Allergen</td>
                                        <td>CAS</td>
                                        <td>Concentration</td>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @forelse($item->components as $component)
                                        <tr>
                                            <td>
                                               {{ $component->allergen }}
                                            </td>
                                            <td>{{ $component->cas }}</td>
                                            <td>{{ $component->pivot->concentration }}</td>
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


            <div class="row card-box d-none d-print-block" style="padding: 0px 100px; margin: 0" id="print_area">
                <div class="col-md-12">
                    <h3 class="text-center text-danger">{{ strtoupper($item->name) }}</h3>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th> الكـــود </th>
                            <td>{{ $item->print_code }}</td>

                            <th>تاريح التسجيل الفعلي </th>
                            <td>{{ $item->created_at->format('Y-m-d') }}</td>

                        </tr>
                        </thead>

                    </table>
                        <h4 class="text-center text-danger">المكونات المسببة للحساسية</h4>
                    <table class="table table-bordered">
                       <thead>
                            <tr>
                                <th>أسم المكون</th>
                                <th>CAS</th>
                                <th>النسبة الموجودة </th>
                            </tr>
                       </thead>
                        <tbody>

                        @forelse($item->components as $component)
                            <tr>
                                <td>
                                    {{ $component->allergen }}
                                </td>
                                <td>{{ $component->cas }}</td>
                                <td>{{ $component->pivot->concentration }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="7">empty</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>

                    <table class="table table-bordered">

                        <thead>
                        <tr>

                            <td>{{ $item->print_notes }}</td>

                        </tr>
                        </thead>

                    </table>

                </div>

            </div>
        </div>
    </div>
    <!-- end wrapper -->


@endsection

@section('scripts')

    {{ Html::script('plugins/sweet-alert2/sweetalert2.min.js') }}
    {{  Html::script('plugins/print/printarea.js')  }}

    <script>
        $(document).ready(function() {
            $('#print').on('click', function () {
                $("#print_area").printArea();

            });
        } );
    </script>
@endsection
