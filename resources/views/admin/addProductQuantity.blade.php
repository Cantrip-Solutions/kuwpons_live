@extends('layouts.apps')
@section('content')

<div class="small-header transition animated fadeIn">
    <div class="hpanel">
        <div class="panel-body">
            <div class="pull-right" id="hbreadcrumb">
                <ol class="hbreadcrumb breadcrumb">
                    <li> Product Management </li>
                    <li> Product </li>
                    <li class="active">
                        <span> Add Product Quantity</span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs"> Product Name: {{$productInfo->name}} </h2>
        </div>
    </div>
</div>
<div class="content animate-panel">
    <div class="row">
        <div class="col-lg-12">

            <div class="hpanel">
                <div class="panel-body">               
                    @if (Session::has('message'))
                       <div class="alert alert-info"><i class="pe-7s-gleam"></i>{{ Session::get('message') }}</div>
                    @endif

                    {{Form::open(array('files'=>true,'id'=>'formdata','class'=>'form-horizontal','action' => 'ProductController@updateProductQuantity', 'method'=>'POST', 'enctype'=>"multipart/form-data"))}}

                        <input class="form-control" type="hidden" name="id" id="id" value="{{Crypt::encrypt($productInfo->id)}}">

                        <div class="form-group">
                            <label for="quantity" class="col-sm-2 control-label">Quantity*:</label>
                            <div class="col-sm-10">
                                {!! Form::number('quantity', '',array('placeholder'=>'Quantity','class'=>'form-control')) !!}
                                @if ($errors->has('quantity'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('quantity') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="expire_on" class="col-sm-2 control-label">Expire Date*:</label>
                            <div class="col-sm-10">
                                 <div class="input-group date">
                                    <input type="text" name="expire_on" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                </div>
                                @if ($errors->has('expire_on'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('expire_on') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">Description :</label>
                            <div class="col-sm-10">
                                {!! Form::textarea('description', '',array('placeholder'=>'Write some text...','class'=>'form-control')) !!}
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-2">
                                <button type="submit" class="btn w-xs btn-success" name="submit">Submit</button>
                                <a class="btn w-xs btn-info" href="{{url('tab/product/stockHistory/'.urlencode($productInfo->name).'/'.Crypt::encrypt($productInfo->id))}}">Back</a>
                            </div>
                        </div>

                    {{Form::close()}}

                </div>
            </div>
        </div>
    </div>
</div>
@push('css')
    {!!HTML::style('public/admintheme/styles/static_custom.css')!!}
    {!!HTML::style('public/admintheme/vendor/select2-3.5.2/select2.css')!!}
    {!!HTML::style('public/admintheme/vendor/select2-bootstrap/select2-bootstrap.css')!!}
    {!!HTML::style('public/admintheme/vendor/summernote/dist/summernote.css')!!}
    {!!HTML::style('public/admintheme/vendor/summernote/dist/summernote-bs3.css')!!}
    {!!HTML::style('public/admintheme/vendor/bootstrap-datepicker-master/dist/css/bootstrap-datepicker3.min.css')!!}
    {!!HTML::style('public/css/bootstrap-tagsinput.css')!!}
   
@endpush
@push('scripts')
{!! HTML::script('public/plugins/jquery-validation-1.15.0/dist/jquery.validate.min.js') !!}
{!! HTML::script('public/plugins/jquery-validation-1.15.0/dist/additional-methods.min.js') !!}
{!! HTML::script('public/admintheme/vendor/select2-3.5.2/select2.min.js') !!}
{!! HTML::script('public/admintheme/vendor/summernote/dist/summernote.min.js') !!}
{!! HTML::script('public/admintheme/vendor/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js') !!}
{!! HTML::script('public/js/bootstrap-tagsinput.min.js')!!}

<script type="text/javascript">
jQuery.validator.setDefaults({ 
    debug: false 
    //success: "valid" 
});
$(document).ready(function(){
    $('div.alert').delay(5000).slideUp(300);
    $("#formdata").validate({
      rules: {
        
        'quantity': {
            required: true
        },
        'expire_on': {
            required: true
        },
      }
    });
    $(".js-source-states").select2();
    $('.input-group.date').datepicker({ 
        // setDate: new Date(),
        format: 'yyyy-mm-dd',
        startDate: new Date(),
    });

});
</script>
@endpush
@endsection