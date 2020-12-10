@extends('layouts.app',['title'=>' |  Import Item '])

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
                                <li class="breadcrumb-item"><a href="{{ route('items.index') }}">Items</a></li>
                                <li class="breadcrumb-item active">Import Items </li>
                            </ol>
                        </div>
                        <h4 class="page-title">
                            <i class="fa fa-cloud-upload"></i>
                            <span>Import Items </span>
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
                                    @if (count($errors) > 0)
                                        <div class="panel panel-danger ">
                                            <ul class="alert-danger">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    @include('flash::message')

                                    {{ Form::open(['route'=>'items.import.store','method'=>'POST',
                                    'id'=>'form','enctype'=>'multipart/form-data']) }}


                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="excel_file" class="control-label {{ $errors->has('excel_file') ? 'has-error' :'' }}">Import ExcelSheet</label>
                                            <input name="excel_file" required type="file" class="filestyle" data-iconname="fa fa-cloud-upload">
                                            <span style="font-size: 11px" class="text-danger">
                                                    <i class="fa fa-info-circle"></i>
                                                    <span>(EXCEL File Only)</span>
                                                    </span>
                                            <br>
                                            @if($errors->has('excel_file'))
                                                <span class="text-danger">{{ $errors->first('excel_file') }}</span>
                                            @endif
                                        </div>

                                    </div>
                                    <br>
                                    <br>
                                    <div class="form-group">
                                        <button id="form_submit" onclick="
                                                    $(this).prop('disabled', true);
                                                    $('#spinner-submit').toggleClass('d-none','show');
                                                    $('#form').submit();"
                                                class="btn btn-success btn-lg right">
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

            $(".select2").select2({
                //dir: "rtl"
            });

        });
    </script>
@endsection