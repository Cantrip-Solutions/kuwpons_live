@extends('layouts.frontEnd')
@section('content')
  <div class="body_content">
   
    <section class="account-wrap" id="page">
      <div class="container">
        <div class="account-main clears">
          <div class="ac-main-left">
            <h2>My Account</h2>
            <span class="toggle-account"><i class="fa fa-bars" aria-hidden="true"></i></span>
            <ul class="order-menu">
              <li><a href="#account_detail"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Account Detail</a></li>
              <li><a href="#change-add"><i class="fa fa-lock" aria-hidden="true"></i>Change Password</a></li>
            </ul>
          </div>
          <div class="ac-main-right">
          
            <div class="wishlist-wrap" id="account_detail">
              <table class="wishlist-table" width="100%">
                
                <tbody>
                  <tr>
                    <td colspan="2"><a href="#" class="edit-add">Account Detail</a></td>
                    <td colspan="3"></td>
                  </tr>
                  <tr>
                    <td colspan="2"><div class="ord-address">
                      <div class="col-lg-6">
                        <div class="address-block">
                          <h3>{{ $userInfo->name }}</h3>
                          <a href="javascript:void(0);" class="btns edit_detail">Edit</a>
                          	<address-content> 
                          		<span>{{ $userInfo->email }}</span>
                          		<span>{{ $userInfo->phone ==  0 ? '' : $userInfo->phone }}</span>
                          		<span>{{ $userInfo->dob }}</span>
                          	</address-content>
                        </div>
                      </div>
                    </td>
                    <td colspan="3"></td>
                  </tr>
                </tbody>
              </table>
              <div class="address-wrap" style="display: none;">
              	@if (Session::has('message1'))
                    <div class="alert alert-info"><i class="pe-7s-gleam"></i>{{ Session::get('message1') }}</div>
                @endif
	              <div class="my-account-form">
	                
	                {{Form::open(array('files'=>true,'id'=>'formdata','action' => 'HomeController@updateProfile', 'method'=>'POST', 'enctype'=>"multipart/form-data",'accept-charset'=>"UTF-8"))}}
	                   <div class="row">
	                     <div class="col-lg-12">
	                       <div class="address-block">
	                           <div class="field-row">
	                           		{!! Form::text('name', $userInfo->name,array('placeholder'=>'Name','class'=>'form-control')) !!}
	                           		@if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
	                           </div>
	                           <div class="field-row">
	                           		{!! Form::email('email', $userInfo->email,array('placeholder'=>'Email','class'=>'form-control')) !!}
	                           		@if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
	                           </div>
	                           <div class="field-row">
	                           		{!! Form::text('phone', $userInfo->phone,array('placeholder'=>'Mobile Number','class'=>'form-control')) !!}
	                           		@if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
	                           </div>
	                           <div class="field-row input-group date">
	                           		{!! Form::text('dob', $userInfo->dob,array('placeholder'=>'Date of Birth','class'=>'form-control')) !!}
	                           		@if ($errors->has('dob'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dob') }}</strong>
                                    </span>
                                @endif
	                             <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
	                           <div class="field-row">
	                             <div class="gend"> <span>I am a </span>

                             			@if($userInfo->gender == 'M')
                             				{{ Form::radio('gender', 'M', true, ['class' => 'field']) }}
                             				<label for="test">Male</label>
                             				{{ Form::radio('gender', 'F', '', ['class' => 'field']) }}
                             				<label for="test1">Female</label>
                             			@else
																		{{ Form::radio('gender', 'M', '', ['class' => 'field']) }}
																		<label for="test">Male</label>
                             				{{ Form::radio('gender', 'F', true, ['class' => 'field']) }}
                             				<label for="test1">Female</label>
                             			@endif
                             			@if ($errors->has('gender'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
	                              </div>
	                           </div>
	                           <div class="field-row">
	                             <input name="" value="Save" type="submit">
	                           </div>
	                       </div>
	                     </div>
	                   </div>
	                {{Form::close()}}
	              </div>
          
              </div>
              <div class="change-add" id="change-add">
                <div class="row">
                  <div class="col-lg-8">
                    <h3>Change Password</h3>
                    @if (Session::has('message2'))
	                    <div class="alert alert-info"><i class="pe-7s-gleam"></i>{{ Session::get('message2') }}</div>
	                @endif
                    {{Form::open(array('id'=>'changePassword','action' => 'HomeController@updateUserPassword', 'method'=>'POST','accept-charset'=>"UTF-8"))}}
                    	{!! Form::password('currentPassword',array('placeholder'=>'Old Password')) !!}
                    	{!! Form::password('newPassword',array('placeholder'=>'New Password','id'=>'newPassword')) !!}
                    	{!! Form::password('corfirmPassword',array('placeholder'=>'Confirm password')) !!}
                      <input type="submit" name="" value="Submit">
                    {{Form::close()}}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </div>
@push('css')
{!! HTML::style('public/plugins/jquery-loadmask-master/jquery.loadmask.css') !!}
@endpush
@push('scripts')
{!! HTML::script('public/plugins/jquery-loadmask-master/jquery.loadmask.min.js') !!}
{!! HTML::script('public/plugins/jquery-validation-1.15.0/dist/jquery.validate.min.js') !!}
{!! HTML::script('public/plugins/jquery-validation-1.15.0/dist/additional-methods.min.js') !!}
<script type="text/javascript">
jQuery.validator.setDefaults({ 
    debug: false 
    //success: "valid" 
});
$(document).ready(function(){
    $("#formdata").validate({
      rules: {
        'name': {
            required: true
        },
        'email': {
            required: true,
            email: true
        },
        'phone': {
            required: true,
            digits: true
        },
        'dob': {
            required: true
        },
        'gender': {
            required: true
        },

      }
    });

    $("#changePassword").validate({
      rules: {
        'currentPassword': {
            required: true
        },
        'newPassword': {
            required: true
        },
        'corfirmPassword': {
            // required: true,
            equalTo: '#newPassword'
        }
      },
      messages: {
        'currentPassword': {
            required: "Please type Current Password"
        },
        'newPassword': {
            required: "Please type New Password"
        },
        'corfirmPassword': {
            equalTo: 'New Password not matched'
            // required: "Please re-type New Password Again"
        }
      }
    });

    $('.edit_detail').click(function(){
    		$('.address-wrap').toggle();
    });

	});
</script>
@endpush
@endsection
