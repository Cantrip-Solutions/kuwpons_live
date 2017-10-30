@extends('layouts.apps')
@section('content')

<div class="small-header transition animated fadeIn">
    <div class="hpanel">
        <div class="panel-body">
            <div class="pull-right" id="hbreadcrumb">
                <ol class="hbreadcrumb breadcrumb">
                    <li> Offers Management </li>
                    <li> Coupons </li>
                    <li class="active">
                        <span> Add Coupons </span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs"> Add Coupons </h2>
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
                    {{Form::open(array('files'=>true,'id'=>'formdata','class'=>'form-horizontal','action' => 'OffersController@createCoupon', 'method'=>'POST', 'enctype'=>"multipart/form-data"))}}
                        <div class="form-group">
                            <label for="company_name" class="col-sm-2 control-label">Generate Code *:</label>
                            <div class="input-group col-sm-10">
                                {!! Form::text('code', '',array('placeholder'=>'AA12345', 'class'=>'form-control', 'id'=>'code')) !!}
                                {{-- <input type="text" class="form-control"> --}}
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary" id="getNumber">+</button>
                                </span>
                                @if ($errors->has('code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                                @endif
                            </div>
                            {{-- <div class="col-sm-10">
	                            @if ($errors->has('code'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('code') }}</strong>
	                                </span>
	                            @endif
                                <button id="getNumber">+</button>
	                        </div> --}}
                        </div>

                        <div class="form-group">
                            <label for="amount" class="col-sm-2 control-label">Amount *:</label>
                            <div class="col-sm-10">
                                {!! Form::number('code', '',array('placeholder'=>'AA12345', 'class'=>'form-control', 'id'=>'code')) !!}
                                {{-- <input type="text" class="form-control"> --}}
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary" id="getNumber">+</button>
                                </span>
                                @if ($errors->has('code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                                @endif
                            </div>
                            {{-- <div class="col-sm-10">
                                @if ($errors->has('code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                                @endif
                                <button id="getNumber">+</button>
                            </div> --}}
                        </div>

                        <div class="form-group">
                        	<div class="col-sm-8 col-sm-offset-2">
	                            <button type="submit" class="btn w-xs btn-success" name="submit">Submit</button>
	                            <a class="btn w-xs btn-info" href="{{url('/tab/company')}}">Back</a>
	                        </div>
                        </div>

                    {{Form::close()}}

                </div>
            </div>
        </div>
    </div>
</div>
@push('css')
{!! HTML::style('public/plugins/jquery-loadmask-master/jquery.loadmask.css') !!}
@endpush
@push('scripts')
{!! HTML::script('public/plugins/jquery-loadmask-master/jquery.loadmask.min.js') !!}
{!! HTML::script('public/plugins/jquery-validation-1.15.0/dist/jquery.validate.min.js') !!}
{!! HTML::script('public/plugins/jquery-validation-1.15.0/dist/additional-methods.min.js') !!}
<script type="text/javascript">
var link = document.getElementById('getNumber'); // Gets the link
link.onclick = getNumber; // Runs the function on click

function getNumber() {
    var minNumber = 10000; // The minimum number you want
    var maxNumber = 99999; // The maximum number you want
    var randomnumber = 'AA'+Math.floor(Math.random() * (maxNumber + 1) + minNumber); // Generates random number
    $('#code').val(randomnumber); // Sets content of <div> to number
    return false; // Returns false just to tidy everything up
}
jQuery.validator.setDefaults({ 
    debug: false 
    //success: "valid" 
});
$(document).ready(function(){
    $('div.alert').delay(5000).slideUp(300);
    $("#formdata").validate({
      rules: {
        'name': {
            required: true
        },
        'email': {
            required: true,
            email: true
        },
        'images': {
            required: true,
            extension: "jpg|jpeg|png"
        },
        'phone': {
            required: true,
            digits: true
        },
        'address1': {
            required: true
        },
        'country': {
            required: true
        },
        'state': {
            required: true
        },
        'postal_code': {
            required: true,
            digits: true
        },
        'notes': {
            required: true
        },

      }
    });
});
</script>
@endpush
@endsection