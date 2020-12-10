@extends('layouts.app',['title' => ' | Show Mix: '. $mix->name])

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
                                <li class="breadcrumb-item"><a href="{{ route('mixes.index') }}">Mixes</a></li>
                                <li class="breadcrumb-item active">show Mix </li>
                            </ol>
                        </div>
                        <h4 class="page-title">
                            <i class="fa fa-eye"></i>
                            <span>show Mix: <span class="text-primary"> {{ $mix->name }}</span>
                            <button id="print" class="btn btn-primary btn-lg" style="margin-left: 100px;">
                                    <i class="fa fa-print"></i>
                                    Print Mix page
                                </button>
                                <!--<button id="pdf" class="btn btn-primary btn-lg" style="margin-left: 100px;">
                                    <i class="fa fa-file-pdf-o"></i>
                                    PDF Mix page
                                </button>-->

                                <button id="print_sticker" class="btn btn-success btn-lg" style="margin-left: 100px;">
                                    <i class="fa fa-print"></i>
                                    Print Mix Sticker
                                </button>
                                <!--<a href="{{-- route('mixes.sticker',$mix->id) --}}" class="btn btn-primary btn-lg" style="margin-left: 100px;">
                                    <i class="fa fa-print"></i>
                                    Sticker
                                </a>-->
                            </span>
                        </h4>
                    </div>
                </div>
            </div>
            <!-- end page title end breadcrumb -->


            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <div class="row d-print-none">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <strong>Mix Name: </strong>
                                                    {{ $mix->name }}
                                            </li>

                                            <li class="list-group-item">
                                                <strong>Mix BarCode: </strong>
                                                    {{ $mix->barcode }}
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col-md-6">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <strong>Mix Tag: </strong>
                                                    {{ $mix->tag }}
                                            </li>

                                            <li class="list-group-item">
                                                <strong>Mix created at: </strong>
                                                    {{ $mix->created_at->format('Y-m-d') }}
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4 d-print-none">

                                <div class="row">
                                    <h5><i class="fa fa-files-o"></i> Files:</h5>
                                </div>
                                <div class="row">

                                    @if(!$mix->attachment('attachments'))
                                        <span>No Attachments</span>
                                    @else
                                        <a target="_blank" href="{{ $mix->attachment('attachments')->url }}" class="btn btn-success">
                                            <i class="fa fa-cloud-download"></i>
                                            <span>Download Mix Attached File</span>
                                        </a>
                                        @endif

                                </div>
                                <br>

                            </div>
                        </div>

                        <div class="row d-none d-print-block" style="padding: 0 100px">
                            <div class="col-md-12">
                                <div class="row">
                                    <h4 class="col-md-3 text-center text-danger">Mix Name: {{ $mix->name }}</h4>
                                    <h4 class=" col-md-3 text-center ">Mix Barcode: {{ $mix->barcode }}</h4>
                                    <h4 class="col-md-4 text-center">Mix Created at: {{ $mix->created_at->format('Y-m-d') }}</h4>

                                </div>
                            </div>
                        </div>

                        <hr class="d-print-none">

                        <div class="row d-print-none" >
                            <div class="col-md-12">
                                <h4>Mix Items ({{ $mix->items->count() }})</h4>
                                <table width="100%" class="table  table-bordered">
                                    <thead>
                                    <tr>

                                        <td>Name</td>
                                        <td>Code</td>
                                        <td class="">Item Percentage</td>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @forelse($mix->items as $single_item)
                                        <tr>
                                            <td>
                                               {{ $single_item->name }}
                                            </td>
                                            <td>{{ $single_item->code }}</td>
                                            <td class="">%{{ $single_item->pivot->percentage }}</td>
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
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Mix Components (26)</h4>
                                <table width="100%" class="table table-bordered" style="font-size: 11px;">
                                    <thead>
                                    <tr>
                                        <td>allergen</td>
                                        @foreach($mix->items as $keys => $val)
                                            <?php $rr = 0 ?>
                                                <td class="d-print-none">{{ $val->name }}</td>
                                                <td class="d-print-none">{{ $val->name  }} (after percentage)</td>

                                        @endforeach
                                        <td>Cas (Final Sum)</td>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php $couna = 0; ?>

                                    @forelse($com as $comp_key => $comp_value)

                                        <tr>
                                            <td >
                                               {{ $comp_key }}
                                            </td>
                                            @foreach($mix->items as $ku => $one)
                                                <td class="d-print-none">{{ $one->components[$couna]->pivot->concentration }}</td>
                                                <td class="d-print-none">{{ number_format($one->components[$couna]->pivot->concentration/100*$one->pivot->percentage,5)  }}</td>
                                            @endforeach

                                            <td>{{ $comp_value }}</td>
                                        </tr>
                                        <?php $couna++; ?>

                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="7">Empty</td>
                                        </tr>
                                    @endforelse
                                    </tbody>

                                </table>

                            </div>
                        </div>

                        <div class="row" id="print_area_sticker">
                            <div class="col-md-12">
                                <h4>Mix ({{ $mix->name }})  Label: </h4>
                                <span>INGREDIENTS: ALCOHOL  DENAT, PARFUM (FRAGRANCE), AQUA (WATER)</span>
                                @foreach($more as $more_key => $more_value)
                                    @if(!$loop->last)
                                        ,
                                    @endif
                                    <span>{{ $more_value }}</span>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div> <!-- end container -->

            <div class="row d-none d-print-block" id="print_area" style="padding: 0 100px; margin: 0">
                <div class="col-12" style="padding: 0">
                    <div class="card-box" style="padding: 0">

                        <div class="row d-none d-print-block" style="padding: 0">
                            <div class="col-md-12">
                                <div class="row" style="padding: 0">
                                    <h4 class="col-md-3 text-center text-danger">Mix Name: {{ $mix->name }}</h4>

                                    <br>
                                    <span class="col-md-4 text-center">Mix Barcode:<strong> {{ $mix->barcode }}</strong></span>
                                    <br>
                                    <span class="col-md-4  text-center">Mix Created at: <strong>  {{ $mix->created_at->format('Y-m-d') }}</strong></span>


                                </div>
                            </div>
                        </div>

                        <hr class="d-print-none">

                        <div class="row d-print-none" >
                            <div class="col-md-12">
                                <h4>Mix Items ({{ $mix->items->count() }})</h4>
                                <table width="100%" class="table  table-bordered">
                                    <thead>
                                    <tr>

                                        <td>Name</td>
                                        <td>Code</td>
                                        <td class="">Item Percentage</td>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @forelse($mix->items as $single_item)
                                        <tr>
                                            <td>
                                               {{ $single_item->name }}
                                            </td>
                                            <td>{{ $single_item->code }}</td>
                                            <td class="">%{{ $single_item->pivot->percentage }}</td>
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
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Mix Components (26)</h4>
                                <table width="100%" class="table  table-bordered">
                                    <thead>
                                    <tr>
                                        <td>allergen</td>
                                        @foreach($mix->items as $keys => $val)
                                            <?php $rr = 0 ?>
                                                <td class="d-print-none">{{ $val->name }}</td>
                                                <td class="d-print-none">{{ $val->name  }} (after percentage)</td>

                                        @endforeach
                                        <td>Cas (Final Sum)</td>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php $couna = 0; ?>

                                    @forelse($com as $comp_key => $comp_value)

                                        <tr>
                                            <td>
                                               {{ $comp_key }}
                                            </td>
                                            @foreach($mix->items as $ku => $one)
                                                <td class="d-print-none">{{ $one->components[$couna]->pivot->concentration }}</td>
                                                <td class="d-print-none">{{ number_format($one->components[$couna]->pivot->concentration/100*$one->pivot->percentage,5)  }}</td>
                                            @endforeach

                                            <td>{{ $comp_value }}</td>
                                        </tr>
                                        <?php $couna++; ?>

                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="7">Empty</td>
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
    {{  Html::script('plugins/print/printarea.js')  }}
    <!--script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js" integrity="sha384-THVO/sM0mFD9h7dfSndI6TS0PgAGavwKvB5hAxRRvc0o9cPLohB0wb/PTA7LdUHs" crossorigin="anonymous">
    </script>-->

    <script>
        /*$('#pdf').on('click', function () {
            var doc = new jsPDF('p','pt','a4');

            doc.fromHTML($('#print_area').html(), 15, 15, {
            });

            doc.save('sample-file.pdf');

        });*/
        $(document).ready(function() {
            $('#print').on('click', function () {
                $("#print_area").printArea();

            });



            $('#print_sticker').on('click', function () {
                $("#print_area_sticker").printArea();

            });
        } );
    </script>
@endsection