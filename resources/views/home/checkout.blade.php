@extends('layouts.frontEnd')
@section('content')
  <div class="body_content">
   <section class="checkout-details-sec">
      <div class="container">
        	<div class="checkout-main">
          <div class="row">
          
          <div class="col-md-4 col-sm-4 col-sm-push-8 order-summary-respon">
              <div class="order-summary">
                <h1>Order Summary</h1>
                <div class="order-summary-table">
                	<table id="cart" style="border-collapse: separate;">
                		<thead>
		                    <tr>
		                      <th class=""> Product </th>
		                      <th class="" style="padding: 28px 4px 6px"> Price (KD) </th>
		                      <th class="" style="padding: 28px 4px 6px"> Quantity </th>
                      		  <th class="" style="padding: 28px 4px 6px">Total</th>
		                    </tr>

		                </thead>
		                <tbody>
                    		@foreach($productDetails as $product)
		                	<tr>
		                		<td>{{$product->name}}</td>
                      			<td class="proEachPrice" style="padding: 10px 7px;">{{$product->saling_price}}</td>
                      			<td style="padding: 10px 7px;">{{$bucketProducts[$product->id]}}</td>
                      			<td class="proTotalPrice" style="padding: 10px 7px;">{{ (float)$product->saling_price*(int)$bucketProducts[$product->id] }}</td>
		                	</tr>
                    		@endforeach
		                </tbody>
                	</table>
                  <table id="cart">
                    <thead>
                      <tr>
                        <th>{{$itemQuantity}} ITEMS</th>
                        {{-- <th>{{count($productDetails)}} ITEMS</th> --}}
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="total-payables">Order Total <span><a href="{{URL::to('/myCart')}}">View Details</a></span></td>
                        <td class="total-payables">{{$totalPrice}} KD</td>
                      </tr>
                    </tbody>
                    <thead>
                      <tr>
                        <td class="total-payable">Total Payable</td>
                        <td class="total-payable">{{$totalPrice}} KD</td>
                      </tr>
                    </thead>
                  </table>
                </div>
                {{-- <div class="delivery-address">
                  <h3>Delivery To</h3>
                  <name>Sourav Debnath</name>
                  <address>
                  Rampur Bhatpara Gaighata North 24 parganas - 743249 West Bengal
                  </address>
                  <phone>Mobile: 9933391148</phone>
                  <a href="">Change Address</a> </div>  --}}
              </div>
            </div>
            	<div class="col-md-8 col-sm-8 col-sm-pull-4 shipping-respon">
		            @if(!Auth::check())
		            <div class="payment-info complete">
		                {{-- <h1>Payment Information</h1> --}}
		                  <h2>To complete checkout please <a href="#login" class="fancybox"><i class="fa fa-user" aria-hidden="true"></i> Login</a> or <a href="javascript:void(0)" class="guestCheckOut">CheckOut As Guest</a> {{-- <a href="#register" class="fancybox">Register</a> --}}</h2>
		                
		              </div> 
		            @else
		            	@php
		            		$user = Auth::user();
		            		// print_r($user);
		            	@endphp
		            @endif
            		{{-- @else --}}
            		@if(!Auth::check())
            			<div class="payment-info form-data" style="display: none;">
            		@else
            			<div class="payment-info form-data">
            		@endif
            		{{Form::open(array('class'=>'clears','action' => 'OrdersController@placeOrder', 'method'=>'POST', 'enctype'=>"multipart/form-data"))}}

            			

              			<div class="payment-options">
            				<h1>Billing Address
            				@if(!Auth::check())
								<span>(Checkout as Guest)</span>
	            			@endif
	            			</h1>
	            				<div class="form-group">
	                         <label for="email" class="col-sm-2 control-label">Email ID*:</label>
	                         <div class="col-sm-10">
	                             <input type="text" class="form-control" name="email" value="{{$user->email or ''}}" required>
	                            <!--  <span style="color: green; font-size: 12px;"> Note : Coupon Code will be sent to your emial ID</span> -->
	                             @if ($errors->has('email'))
	                                 <span class="help-block">
	                                     <strong>{{ $errors->first('email') }}</strong>
	                                 </span>
	                             @endif
	                         </div>
	                     </div>

	                     @php
	                     if(isset($user->name)){
	                     	$result = explode(" ", $user->name, 2);
	                     }
	                     @endphp


	                     <div class="form-group">
	                         <label for="name" class="col-sm-2 control-label">First Name*:</label>
	                         <div class="col-sm-10">
	                             <input type="text" name="fname" class="form-control" value="{{$result[0] or ''}}" required>
	                             @if ($errors->has('fname'))
	                                 <span class="help-block">
	                                     <strong>{{ $errors->first('fname') }}</strong>
	                                 </span>
	                             @endif
	                         </div>
	                     </div>

	                     <div class="form-group">
	                         <label for="name" class="col-sm-2 control-label">Last Name*:</label>
	                         <div class="col-sm-10">
	                             <input type="text" name="lname" class="form-control" value="{{$result[1] or ''}}" required>
	                             @if ($errors->has('lname'))
	                                 <span class="help-block">
	                                     <strong>{{ $errors->first('lname') }}</strong>
	                                 </span>
	                             @endif
	                         </div>
	                     </div>

	                     <div class="form-group" style="display: none;">
	                         <label for="address1" class="col-sm-2 control-label">Address 1*:</label>
	                         <div class="col-sm-10">
	                             <input type="text" name="address1" class="form-control" value="{{$user->getdefaultUserInfo->address1 or 'Address1'}}">
	                             @if ($errors->has('address1'))
	                                 <span class="help-block">
	                                     <strong>{{ $errors->first('address1') }}</strong>
	                                 </span>
	                             @endif
	                         </div>
	                     </div>

	                     <div class="form-group" style="display: none;">
	                         <label for="address2" class="col-sm-2 control-label">Address 2:</label>
	                         <div class="col-sm-10">
	                             <input type="text" name="address2" class="form-control" value="{{$user->getdefaultUserInfo->address2 or 'Address2'}}">
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
	                             <select class='form-control country' name="country" required>
	                                 @foreach($countries as $country)
	                                     @if(isset($user->getdefaultUserInfo->country) &&  $user->getdefaultUserInfo->country == $country->id)
	                                         <option value="{{$country->id}}" ccode="{{$country->phonecode}}" selected>{{$country->name}}</option>
	                                     @else
	                                     	@if($country->id == 117)
	                                         	<option value="{{$country->id}}" ccode="{{$country->phonecode}}" selected="selected">{{$country->name}}</option>
	                                     	@else
	                                         	<option value="{{$country->id}}" ccode="{{$country->phonecode}}">{{$country->name}}</option>

	                                     	@endif
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
	            			
	                     <div class="form-group" style="display: none;">
	                         <label for="company_city" class="col-sm-2 control-label">City:</label>
	                         <div class="col-sm-10">
	                             <input list="cities" name="city" class="form-control cities" value="{{$user->getdefaultUserInfo->city or 'Kolkata'}}">
	                             @if ($errors->has('city'))
	                                 <span class="help-block">
	                                     <strong>{{ $errors->first('city') }}</strong>
	                                 </span>
	                             @endif
	                         </div>
	                     </div>

	            			<div class="form-group">
	                         <label for="company_phone" class="col-sm-2 control-label">Mobile *:</label>
	                         <div class="col-sm-10">
	                             <div class="input-group m-b">
	                             <span class="input-group-addon country_code"></span>
	                             <input type="text" name="phone" value="{{$user->getdefaultUserInfo->phone or ''}}" class="form-control" placeholder="0123456789" required>
	                             <input type="hidden" id="countryCode" name="countryCode">
	                             {{-- {!! Form::text('phone', $user->getdefaultUserInfo->phone or '',array('placeholder'=>'0123456789', 'class'=>'form-control')) !!} --}}
	                             </div>
	                             @if ($errors->has('phone'))
	                                 <span class="help-block">
	                                     <strong>{{ $errors->first('phone') }}</strong>
	                                 </span>
	                             @endif
	                         </div>
	                     </div>

	                     <div class="form-group" style="display: none;">
	                         <label for="company_postal_code" class="col-sm-2 control-label">Pin Code *:</label>
	                         <div class="col-sm-10">
	                         <input type="text" name="postal_code" value="{{$user->getdefaultUserInfo->postal_code or '111111'}}" class="form-control" placeholder="0123456789">

	                         {{-- {!! Form::text('postal_code', $user->getdefaultUserInfo->postal_code or '111111',array('placeholder'=>'', 'class'=>'form-control')) !!} --}}
	                         @if ($errors->has('postal_code'))
	                             <span class="help-block">
	                                 <strong>{{ $errors->first('postal_code') }}</strong>
	                             </span>
	                         @endif
	                         </div>
	                     </div>
	                     <!-- <div class="form-group"> -->
	                         <!-- <label for="sms_service" class="control-label">Do you like get coupon codes via SMS ?</label> -->
	                         	<!-- <input type="checkbox" name="sms_service" value="sms" class="form-control" checked> -->
	                     <!-- </div> -->
	                     @if(!Auth::check())
	                     <div class="form-group">
	                       	<label class="col-sm-2 control-label">Get coupon codes via</label>
	                         <div class="col-sm-10">
			                    <input type="radio" name="deliveryType" value="M" checked> Email or
			                    <input type="radio" name="deliveryType" value="S"> SMS
		                    </div>
	                     </div>
	                     @endif




	                        {{-- <div class="shipping-checkbox"> --}}
	                         	{{-- <input type="checkbox" name="sms_service" id="sms_service" value="sms" checked> --}}
	                          <!-- <input type="checkbox" value="None" id="shipping-checkbox" name="check" checked /> -->
	                          {{-- Do you like get coupon codes via SMS ? --}}
	                          {{-- <label for="sms_service"></label> --}}
	                        {{-- </div> --}}

                			<h1>Choose Payment Mode</h1>
                			<div id="parentVerticalTab" class="payment-mode-main">
				                  <div class="payment-type clears">
				                    <ul class="resp-tabs-list">
				                      <li class="active"> CREDIT / DEBIT CARD </li>
				                      <li>PAYPAL</li>
				                    </ul>
				                  </div>
			                    <div class="resp-tabs-container payment-form">
				                    	<div>

					                        <div class="form-group">
					                          <label for="">Card Number</label>
					                          <input class="form-control" type="text" name="cardNumber" placeholder="" >
					                          	@if ($errors->has('cardNumber'))
					                             <span class="help-block">
					                                 <strong>{{ $errors->first('cardNumber') }}</strong>
					                             </span>
					                        	@endif
					                        </div>
					                        <div class="form-group">
					                          <label>Expires On</label>
					                          <select class="form-control" name="expire_on_month">
					                            <option selected value=''>Month</option>
					                            <option value='1'>Janaury</option>
					                            <option value='2'>February</option>
					                            <option value='3'>March</option>
					                            <option value='4'>April</option>
					                            <option value='5'>May</option>
					                            <option value='6'>June</option>
					                            <option value='7'>July</option>
					                            <option value='8'>August</option>
					                            <option value='9'>September</option>
					                            <option value='10'>October</option>
					                            <option value='11'>November</option>
					                            <option value='12'>December</option>
					                          </select>
					                          @if ($errors->has('expire_on_month'))
					                             <span class="help-block">
					                                 <strong>{{ $errors->first('expire_on_month') }}</strong>
					                             </span>
					                        	@endif
					                          <select class="form-control" name="expire_on_year">
					                            <option selected value="">Year</option>
					                            <option value="1">2017</option>
					                            <option value="2">2018</option>
					                            <option value="3">2019</option>
					                            <option value="4">2020</option>
					                            <option value="5">2021</option>
					                            <option value="6">2022</option>
					                            <option value="7">2023</option>
					                            <option value="8">2024</option>
					                            <option value="9">2025</option>
					                          </select>
					                          @if ($errors->has('expire_on_year'))
					                             <span class="help-block">
					                                 <strong>{{ $errors->first('expire_on_year') }}</strong>
					                             </span>
					                        	@endif
					                        </div>
					                        <div class="form-group">{!!HTML::image('kuwpons/images/payment-icon.png','')!!}</div>
					                        <div class="form-group">
					                          <label for="">Name on Card</label>
					                          <input class="form-control" type="text" placeholder="" name="cardName">
					                          @if ($errors->has('cardName'))
					                             <span class="help-block">
					                                 <strong>{{ $errors->first('cardName') }}</strong>
					                             </span>
					                        	@endif
					                        </div>
					                        <div class="form-group">
					                          <label>Security Code </label>
					                          <input class="form-control" type="text" placeholder="" name="cvv">
					                          <p>What's this?</p>
					                          @if ($errors->has('cvv'))
					                             <span class="help-block">
					                                 <strong>{{ $errors->first('cvv') }}</strong>
					                             </span>
					                        	@endif
					                        </div>
					                        <div class="place-order">
					                        	<input type="submit" name="submit" value="Place Order" class="defaultbtn place-order-btn">
					                        </div>
				                    	</div>
				                    	<div>
					                        
					                        
				                     </div>
			                    </div>
			               </div>
			     			</div>
			   		{{Form::close()}}
			   		</div>
            	</div>
            
          </div>
          </div>
        	</div>
      </div>
   </section>
    
    @if(!\Auth::check())
     {{-- <section class="newslatter-sec">
      <div class="container">
      <div class="row">
       <div class="col-lg-5">
        <h1>NEWSLETTER SIGNUP</h1>
       </div>
       <div class="col-lg-7 no-padding">
         <div class="newslatter-name">
          <input class="form-control" type="text" placeholder="Name"/>
          <input class="form-control" type="text" placeholder="Email"/>
          <button class="defaultbtn btn-green">Subscribe!</button>
         </div>
       </div>
       </div>
      </div>
     </section> --}}
     @endif

    
  </div>
@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {

    	$('.guestCheckOut').on('click', function () {
    		$(".form-data").toggle();
    	})

        //Vertical Tab
        $('#parentVerticalTab').easyResponsiveTabs({
            type: 'vertical', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true, // 100% fit in a container
            closed: 'accordion', // Start closed if in accordion view
            tabidentify: 'hor_1', // The tab groups identifier
            activate: function(event) { // Callback function if tab is switched
                var $tab = $(this);
                var $info = $('#nested-tabInfo2');
                var $name = $('span', $info);
                $name.text($tab.text());
                $info.show();
            }
        });
    });

   $('.cities').on('click',function () {
    $('.cities').attr('autocomplete','on');
});

$('#countryCode').val($('.country').find('option:selected').attr('ccode'));
$('.country_code').text($('.country').find('option:selected').attr('ccode'));
$('.country').on('change',function () {
    var country = $('.country').val();
    var ccode = $(this).find('option:selected').attr('ccode');
    $('.country_code').text(ccode);
	 $('#countryCode').val(ccode);

})
</script>
@endpush
@endsection

