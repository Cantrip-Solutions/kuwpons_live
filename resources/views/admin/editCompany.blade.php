@extends('layouts.apps')
@section('content')

<div class="small-header transition animated fadeIn">
    <div class="hpanel">
        <div class="panel-body">
            <div class="pull-right" id="hbreadcrumb">
                <ol class="hbreadcrumb breadcrumb">
                    <li> User Management </li>
                    <li> Company </li>
                    <li class="active">
                        <span> Edit Company </span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs"> Edit Company : {{$user->name}} </h2>
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
                    {{Form::open(array('files'=>true,'id'=>'formdata','class'=>'form-horizontal','action' => 'CompanyController@updateCompany', 'method'=>'POST', 'enctype'=>"multipart/form-data"))}}
                        <input class="form-control" type="hidden" name="id" id="id" value="{{Crypt::encrypt($user->id)}}">
                        <div class="form-group">
                            <label for="company_name" class="col-sm-2 control-label">Company Name *:</label>
                                <div class="col-sm-10">
                                {!! Form::text('name', $user->name,array('placeholder'=>'Company Name', 'class'=>'form-control')) !!}
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                                </div>
                        </div>

                        <div class="form-group">
                            <label for="company_email" class="col-sm-2 control-label">Company Email ID *:</label>
                            <div class="col-sm-10">
                                {!! Form::text('email', $user->email,array('placeholder'=>'example@domain.com', 'class'=>'form-control')) !!}
                                    <span style="color: red;">Note: This email Id will be use as a username for future access</span>
                                
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-sm-2 control-label">Password :</label>
                            <div class="col-sm-10">
                                {!! Form::password('password', array('id'=>'password','placeholder'=>'********', 'class'=>'form-control password')) !!}
                                <span style="color: red;">Note: Leave blank if you don't want to change password</span>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="re_password" class="col-sm-2 control-label">Re-Enter Password :</label>
                            <div class="col-sm-10">
                                {!! Form::password('re_password', array('placeholder'=>'********', 'class'=>'form-control re_password')) !!}

                                @if ($errors->has('re_password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('re_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="company_logo" class="col-sm-2 control-label">Company Logo *:</label>
                            <div class="col-sm-10">
                                {!! HTML::image(config('global.uploadPath').$user->image, 'alt', array('class'=>'', 'width'=>'70', 'height'=>'70')) !!}
                                {!! Form::file('images') !!}
                                @if ($errors->has('images'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('images') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>



                        {{-- <div class="form-group">
                            <label for="company_phone" class="col-sm-2 control-label">Contact Number *:</label>
                            <div class="col-sm-10">
                                {!! Form::text('phone', $userInfo->phone,array('placeholder'=>'0123456789', 'class'=>'form-control')) !!}
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> --}}

                        <div class="form-group">
                            <label for="company_address1" class="col-sm-2 control-label">Address Line 1 *:</label>
                            <div class="col-sm-10">
                                {!! Form::text('address1', $userInfo->address1,array('placeholder'=>'', 'class'=>'form-control')) !!}
                                @if ($errors->has('address1'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address1') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="company_address2" class="col-sm-2 control-label">Address Line 2 :</label>
                            <div class="col-sm-10">
                                {!! Form::text('address2', $userInfo->address2,array('placeholder'=>'', 'class'=>'form-control')) !!}
                                @if ($errors->has('address2'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address2') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="company_country" class="col-sm-2 control-label">Country *:</label>
                            <div class="col-sm-10">
                                <select class='form-control country' name="country">
                                    @foreach($countries as $country)
                                        @if($userInfo->country == $country->id)
                                            <option value="{{$country->id}}" ccode="{{$country->phonecode}}" selected>{{$country->name}}</option>
                                        @else
                                            <option value="{{$country->id}}" ccode="{{$country->phonecode}}">{{$country->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('country'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('country') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <input type="hidden" name="state" value="0">
                        {{-- <div class="form-group">
                            <label for="company_State" class="col-sm-2 control-label">State *:</label>
                            <select class='form-control state' name="state">
                                @foreach($states as $state)
                                    @if($userInfo->state == $state->id)
                                        <option value="{{$state->id}}" selected>{{$state->name}}</option>
                                    @else
                                        <option value="{{$state->id}}">{{$state->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($errors->has('state'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('state') }}</strong>
                                </span>
                            @endif
                        </div> --}}

                        <div class="form-group">
                            <label for="company_city" class="col-sm-2 control-label">City:</label>
                            <div class="col-sm-10">
                                <input list="cities" name="city" class="form-control cities" value="{{$userInfo->city}}">
                                {{-- <datalist id="cities" class="city">
                                    @foreach($cities as $city)
                                        <option value="{{$city->name}}">
                                    @endforeach
                                </datalist> --}}

                                {{-- <select class='form-control city' name="city">
                                    @foreach($cities as $city)
                                        @if($userInfo->city == $city->id)
                                            <option value="{{$city->name}}" selected>{{$city->name}}</option>
                                        @else
                                            <option value="{{$city->name}}">{{$city->name}}</option>
                                        @endif
                                    @endforeach
                                </select> --}}
                                @if ($errors->has('city'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="company_phone" class="col-sm-2 control-label">Contact Number *:</label>
                            <div class="col-sm-10">
                                <div class="input-group m-b">
                                <span class="input-group-addon country_code"></span>
                                {!! Form::text('phone', $userInfo->phone,array('placeholder'=>'0123456789', 'class'=>'form-control')) !!}
                                </div>
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <input type="hidden" name="postal_code" value="0000000">

                        {{-- <div class="form-group">
                            <label for="company_postal_code" class="col-sm-2 control-label">Pin Code *:</label>
                            {!! Form::text('postal_code', $userInfo->postal_code,array('placeholder'=>'', 'class'=>'form-control')) !!}
                            @if ($errors->has('postal_code'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('postal_code') }}</strong>
                                </span>
                            @endif
                        </div> --}}

                        

                        <div class="form-group">
                            <label for="company_description" class="col-sm-2 control-label">Company Short Description *:</label>
                            <div class="col-sm-10">
                                {{ Form::textarea('notes',$user->notes,array('class'=>'form-control')) }}
                                @if ($errors->has('notes'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('notes') }}</strong>
                                    </span>
                                @endif
                            </div>
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
$('.cities').on('click',function () {
    $('.cities').attr('autocomplete','on');
});

$('.country_code').text($('.country').find('option:selected').attr('ccode'));
$('.country').on('change',function () {
    var country = $('.country').val();
    var ccode = $(this).find('option:selected').attr('ccode');
    $('.country_code').text(ccode);
    // var token = $('input[name=_token]').val();
    //   $.ajax({
    //     'type':'post',
    //     'url':'{{URL::to('getState')}}',
    //     'headers': {'X-CSRF-TOKEN': token},
    //     'data':{'country':country},
    //     'dataType':'json',
    //     'beforeSend':function(){ $('.row').mask('Please Wait...'); },
    //     'success':function(resp){
    //         $('.state').children('option').empty().remove();
    //         $('.city').children('option').empty().remove();
    //         $('<option value="">Select State</option>').appendTo('.state');
    //         $.each(resp,function(intex,info){
    //           $('<option value="'+ info.id +'">'+ info.name +'</option>').appendTo('.state');
    //         });
    //         $('.row').unmask();
    //     }
    //   });
})
// $('.state').on('change',function () {
//     var state = $('.state').val();
//     var token = $('input[name=_token]').val();
//       $.ajax({
//         'type':'post',
//         'url':'{{URL::to('getCity')}}',
//         'headers': {'X-CSRF-TOKEN': token},
//         'data':{'state':state},
//         'dataType':'json',
//         'beforeSend':function(){ $('.row').mask('Please Wait...'); },
//         'success':function(resp){
//             $('.city').children('option').empty().remove();
//             $.each(resp,function(intex,info){
//                 $('<option value="'+ info.name +'">').appendTo('.city');
//                 // $('<option value="'+ info.name +'">'+ info.name +'</option>').appendTo('.city');
//             });
//             $('.row').unmask();

//         }
//       });
// })
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
        'password': {
            minlength: 6,
            maxlength: 10
        },
        're_password': {
            equalTo: "#password"
        },
        'images': {
            // required: true,
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