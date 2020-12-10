@extends('layouts.app',['title'=>' |  Edit Item: '.$item->name])

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
                                <li class="breadcrumb-item active">Edit Item </li>
                            </ol>
                        </div>
                        <h4 class="page-title">
                            <i class="fa fa-edit"></i>
                            <span>Edit Item:
                            <a href="{{ route('items.show',$item->id) }}" class="text-primary">{{ $item->name }}</a>
                            </span>
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

                                    {{ Form::model($item,['route'=>['items.update',$item->id],'method'=>'POST',
                                    'id'=>'form','enctype'=>'multipart/form-data']) }}

                                        {{ method_field('PATCH') }}
                                    <div class="row">

                                        <div class="form-group col-md-6 {{ $errors->has('name') ? 'has-error' :'' }}">
                                            {{ Form::label('name', 'Item Name') }}
                                            {{ Form::text('name',null,['class'=>'form-control','required']) }}
                                            @if($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6 {{ $errors->has('code') ? 'has-error' :'' }}">
                                            {{ Form::label('code', 'Item Code') }}
                                            {{ Form::text('code',null,['class'=>'form-control','required']) }}
                                            @if($errors->has('code'))
                                                <span class="text-danger">{{ $errors->first('code') }}</span>
                                            @endif
                                        </div>

                                    </div>

                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="notes">Notes</label>
                                            {{ Form::textarea('notes',null,['class'=>'form-control','id'=>'notes','rows'=>0,'cols'=>0, 'style'=>"min-height:5px;"]) }}

                                        </div>
                                        @if($errors->has('notes'))
                                            <span class="text-danger">{{ $errors->first('notes') }}</span>
                                        @endif

                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="attachments" class="control-label {{ $errors->has('attachments') ? 'has-error' :'' }}">Item Attachments</label>
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
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>Item Components: </h4></div>
                                        <br>
                                        <br>
                                        @foreach($item->components as $component)
                                            <div class="form-group col-md-12 {{ $errors->has($component->id) ? 'has-error' :'' }}">
                                                <label for="{{ $component->id }}">
                                                    {{ $component->allergen }} <span class="text-primary"> (CAS: {{  $component->cas }})</span>
                                                </label>
                                                {{ Form::text($component->id,$component->pivot->concentration,['class'=>'form-control','required']) }}
                                                @if($errors->has($component->id))
                                                    <span class="text-danger">{{ $errors->first($component->id) }}</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
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
