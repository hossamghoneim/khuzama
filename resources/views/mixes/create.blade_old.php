@extends('layouts.app',['title'=>' |  Add new Mix '])

@section('styles')
    {{ Html::style('plugins/select2/css/select2.min.css') }}
    {{ Html::style('plugins/multiselect/css/multi-select.css') }}
    <style>
        .ms-container{ width: 100%}
    </style>
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
                                <li class="breadcrumb-item"><a href="{{ route('mixes.index') }}">Mixes</a></li>
                                <li class="breadcrumb-item active">add new Mix </li>
                            </ol>
                        </div>
                        <h4 class="page-title">
                            <i class="fa fa-plus-circle"></i>
                            <span>add new Mix</span>
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
                                        @if (session()->exists('data_error'))
                                        <div class="panel panel-info">
                                            <ul class="alert-info">
                                              <li>Name must be unique & max length is 255 char</li>
                                              <li>barcode must be unique & max length is 255 char</li>
                                            </ul>
                                        </div>
                                    @endif
                                    @include('flash::message')

                                    {{ Form::open(['route'=>'mixes.store','method'=>'POST',
                                    'id'=>'form','enctype'=>'multipart/form-data']) }}

                                    <div class="row">

                                        <div class="form-group col-md-6 {{ $errors->has('name') ? 'has-error' :'' }}">
                                            {{ Form::label('name', 'Mix Name') }}
                                            {{ Form::text('name',null,['class'=>'form-control','required']) }}
                                            @if($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6 {{ $errors->has('barcode') ? 'has-error' :'' }}">
                                            {{ Form::label('barcode', 'Mix Barcode') }}
                                            {{ Form::text('barcode',null,['class'=>'form-control']) }}
                                            @if($errors->has('barcode'))
                                                <span class="text-danger">{{ $errors->first('barcode') }}</span>
                                            @endif
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="form-group col-md-6 {{ $errors->has('tag') ? 'has-error' :'' }}">
                                            {{ Form::label('tag', 'Mix Tag') }}
                                            {{ Form::text('tag',null,['class'=>'form-control']) }}
                                            @if($errors->has('tag'))
                                                <span class="text-danger">{{ $errors->first('tag') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6 {{ $errors->has('created_at') ? 'has-error' :'' }}">
                                            {{ Form::label('created_at', 'Mix Created at') }}
                                            {{ Form::date('created_at',null,['class'=>'form-control']) }}
                                            @if($errors->has('created_at'))
                                                <span class="text-danger">{{ $errors->first('created_at') }}</span>
                                            @endif
                                        </div>

                                    </div>

                                        <hr>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="attachments" class="control-label {{ $errors->has('attachments') ? 'has-error' :'' }}">Mix Attachment</label>
                                                <input name="attachments" required type="file" class="filestyle" data-iconname="fa fa-cloud-upload">
                                                <span style="font-size: 11px" class="text-warning">
                                                    <i class="fa fa-info-circle"></i>
                                                    <span>(EXCEL/PDF/RTF/DOCX ONLY)</span>
                                                    </span>
                                                <br>
                                                @if($errors->has('attachments'))
                                                    <span class="text-danger">{{ $errors->first('attachments') }}</span>
                                                @endif
                                            </div>

                                        </div>
                                        <br>
                                        <!--<div class="row">
                                            <div class="col-md-12">
                                                <label for="items"></label><h4>Mix Items: </h4>

                                            <br>

                                            <select name="items[]"  class="multi-select" multiple="multiple" id="items" >
                                                <?php /*@foreach($items as $single_item)*/?>
                                                <option value="{{-- $single_item->id --}}">{{-- $single_item->name --}}</option>
                                                <?php  /*@endforeach*/ ?>
                                            </select>
                                            </div>
                                        </div>-->

                                        @for($i=1;$i<=5;$i++)
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="item[]"> Select Item {{$i}}</label>
                                                {{ Form::select('items[]',$items,0,['class'=>'form-control select2']) }}

                                            </div>

                                            <div class="form-group col-md-6">
                                            <label for="per[]"> Insert Item {{ $i }} Percentage</label>
                                                <div class="input-group bootstrap-touchspin">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default bootstrap-touchspin-down" type="button">-</button>
                                                    </span>
                                                    <span class="input-group-addon bootstrap-touchspin-prefix" style="display: none;"></span>
                                                    <input id="per[]" type="text" value="0" name="per[]" class="form-control" style="display: block;">
                                                    <span class="input-group-addon bootstrap-touchspin-postfix">%</span>
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default bootstrap-touchspin-up" type="button">+</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        @endfor
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
    {{ Html::script('plugins/multiselect/js/jquery.multi-select.js') }}
    {{ Html::script('plugins/jquery-quicksearch/jquery.quicksearch.js') }}
    <script>
        $(document).ready(function() {

            $(".select2").select2({
                //dir: "rtl"
            });

            $('#items').multiSelect({
                selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
                selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
                afterInit: function (ms) {
                    var that = this,
                        $selectableSearch = that.$selectableUl.prev(),
                        $selectionSearch = that.$selectionUl.prev(),
                        selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
                        selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

                    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                        .on('keydown', function (e) {
                            if (e.which === 40) {
                                that.$selectableUl.focus();
                                return false;
                            }
                        });

                    that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                        .on('keydown', function (e) {
                            if (e.which == 40) {
                                that.$selectionUl.focus();
                                return false;
                            }
                        });
                },
                afterSelect: function () {
                    this.qs1.cache();
                    this.qs2.cache();
                },
                afterDeselect: function () {
                    this.qs1.cache();
                    this.qs2.cache();
                }
            });

        });
    </script>
@endsection