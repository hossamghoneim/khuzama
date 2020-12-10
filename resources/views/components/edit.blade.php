@extends('layouts.app',['title'=>' |  Edit Product: '.$product->name])

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
                                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                                <li class="breadcrumb-item active">Edit Product </li>
                            </ol>
                        </div>
                        <h4 class="page-title">
                            <i class="fa fa-edit"></i>
                            <span>Edit Product: {{ $product->name }}</span>
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

                                    {{ Form::model($product,['route'=>['products.update',$product->id],'method'=>'POST',
                                    'id'=>'form','enctype'=>'multipart/form-data']) }}
                                        {{ method_field('PATCH') }}
                                    <div class="row">
                                        <div class="form-group col-md-4">

                                            <label for="client_id">Client</label>

                                            <select required name="client_id" id="client_id" class="form-control select2 {{ $errors->has('client_id') ? 'has-error' :'' }}">
                                                <option  {{ old('client_id') ?  '' : 'selected' }}  disabled value="1">
                                                    please select client
                                                </option>
                                                @foreach($clients as $id => $name)
                                                    <option {{ old('client_id') ? (old('client_id') === $id ? 'selected' : '')  : $product->client->id == $id ? 'selected' : ''  }} value="{{ $id }}">{{ $name }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('client_id'))
                                                <span class="text-danger">{{ $errors->first('client_id') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-4 {{ $errors->has('name') ? 'has-error' :'' }}">
                                            {{ Form::label('name', 'Product Name') }}
                                            {{ Form::text('name',null,['class'=>'form-control','required']) }}
                                            @if($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-4 {{ $errors->has('barcode') ? 'has-error' :'' }}">
                                            {{ Form::label('barcode', 'Barcode Number') }}
                                            {{ Form::number('barcode',null,['class'=>'form-control','required']) }}
                                            @if($errors->has('barcode'))
                                                <span class="text-danger">{{ $errors->first('barcode') }}</span>
                                            @endif
                                        </div>

                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="type">Product Type</label>
                                            <select name="type" id="type" class="form-control select2 {{ $errors->has('type') ? 'has-error' :'' }}">
                                                <option  {{ old('type') ?  '' : '' }}  disabled value="1">
                                                    please select product type
                                                </option>
                                                <option {{ old('type') ? old('type') == 'alcohol_perfume'  : $product->type == 'alcohol_perfume' ? 'selected' : '' }} value="alcohol_perfume">Alcohol Perfume</option>
                                                <option value="oil_perfume" {{ old('type') ? old('type') == 'oil_perfume'  : $product->type == 'oil_perfume' ? 'selected' : '' }}>Oil Perfume</option>
                                                <option {{ old('type') ? old('type') == 'mattresses_perfume'  : $product->type == 'mattresses_perfume' ? 'selected' : '' }} value="mattresses_perfume">Mattresses Perfume</option>
                                                <option {{ old('type') ? old('type') == 'incense'  : $product->type == 'incense' ? 'selected' : '' }} value="incense">Incense </option>

                                            </select>
                                            @if($errors->has('type'))
                                                <span class="text-danger">{{ $errors->first('type') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-4">

                                            <label for="size">Size</label>
                                            <div class="input-group {{ $errors->has('size') ? 'has-error' :'' }}">

                                                {{ Form::number('size',null,['id'=>'size','class'=>'form-control','required']) }}
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">mg</span>
                                                </div>

                                            </div>
                                            @if($errors->has('size'))
                                                <span class="text-danger">{{ $errors->first('size') }}</span>
                                            @endif

                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="number_of_refill">Number of Refill</label>
                                            <div class="input-group {{ $errors->has('number_of_refill') ? 'has-error' :'' }}">
                                                {{ Form::number('number_of_refill',null,['id'=>'number_of_refill','class'=>'form-control','required']) }}

                                            </div>
                                            @if($errors->has('number_of_refill'))
                                                <span class="text-danger">{{ $errors->first('number_of_refill') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">

                                        <div class="form-group col-md-4">

                                            <label for="concentration">Concentration</label>
                                            <div class="input-group {{ $errors->has('concentration') ? 'has-error' :'' }}">

                                                {{ Form::number('concentration',null,['id'=>'concentration','class'=>'form-control','required',$product->type != 'alcohol_perfume' ? 'disabled' :'' ]) }}

                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">%</span>
                                                </div>

                                            </div>
                                            @if($errors->has('concentration'))
                                                <span class="text-danger">{{ $errors->first('concentration') }}</span>
                                            @endif

                                        </div>

                                        <div class="form-group col-md-4 {{ $errors->has('alcohol_type') ? 'has-error' :'' }}">
                                            {{ Form::label('alcohol_type', 'Alcohol Type') }}
                                            {{ Form::text('alcohol_type',null,['class'=>'form-control','required','id'=>'alcohol_type',$product->type != 'alcohol_perfume' ? 'disabled' :'' ]) }}
                                            @if($errors->has('alcohol_type'))
                                                <span class="text-danger">{{ $errors->first('alcohol_type') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-md-6 {{ $errors->has('extras') ? 'has-error' :'' }}">
                                            {{ Form::label('extras', 'there is extras?') }}

                                            <select name="extras" id="extras" class="form-control">
                                                <option {{ old('extras') == '0' ? 'selected' : '' }} value="0"> NO</option>
                                                <option  {{old('extras') == '1' ? 'selected' : ''  }} value="1"> Yes</option>
                                            </select>

                                            @if($errors->has('extras'))
                                                <span class="text-danger">{{ $errors->first('extras') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="number_of_extras">Number of Extras</label>
                                            <div class="input-group {{ $errors->has('number_of_extras') ? 'has-error' :'' }}">
                                                <input {{ old('extras') != '1' ? 'disabled' : '' }}  value="{{ old('number_of_extras')  }}" id="number_of_extras" type="number" required class="form-control" name="number_of_extras" >

                                            </div>
                                            @if($errors->has('number_of_extras'))
                                                <span class="text-danger">{{ $errors->first('number_of_extras') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="notes">Notes</label>
                                            {{ Form::textarea('notes',null,['class'=>'form-control','required','id'=>'notes','rows'=>1]) }}

                                        </div>
                                        @if($errors->has('notes'))
                                            <span class="text-danger">{{ $errors->first('notes') }}</span>
                                        @endif

                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="design_file" class="control-label {{ $errors->has('design_file') ? 'has-error' :'' }}">Product Design</label>
                                            <input name="design_file" required type="file" class="filestyle" data-iconname="fa fa-cloud-upload">
                                            <span style="font-size: 11px" class="text-warning">
                                                <i class="fa fa-info-circle"></i>
                                                <span>(PDF/JPG ONLY)</span>
                                                </span>
                                            <br>
                                            @if($errors->has('design_file'))
                                                <span class="text-danger">{{ $errors->first('design_file') }}</span>
                                            @endif
                                        </div>

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

            $('#type').on('change', function (e) {
                if($(this).val() === 'alcohol_perfume'){
                    $('#concentration').attr('disabled',false);
                    $('#alcohol_type').attr('disabled',false);
                }

                if($(this).val() !== 'alcohol_perfume'){
                    $('#concentration').attr('disabled',true);
                    $('#alcohol_type').attr('disabled',true);
                }

            });

            $('#extras').on('change', function (e) {

                if($(this).val() === '1'){
                    $('#number_of_extras').attr('disabled',false);
                }

                if($(this).val() !== '1'){

                    $('#number_of_extras').attr('disabled',true);
                }

            })
            /*$('#form').parsley().on('form:validate', function (formInstance) {
                if(!formInstance.isValid()){
                    $('#form_submit').attr('disabled',false);
                    $('#spinner-submit').addClass('d-none');
                }
            });*/

        });
    </script>
@endsection