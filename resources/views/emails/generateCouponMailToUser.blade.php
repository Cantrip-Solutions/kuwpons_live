<br>
Kuwpons | Your purchased Kuwpons are <br>
@foreach($couponArray as $coupon)
	Coupon Name: {{$coupon['productName']}},<br>
	Company Name: {{$coupon['companyName']}},<br> 
	Coupon Code: {{$coupon['code']}},<br>
	Expire On: {{$coupon['expireOn']}},<br><br><br>
@endforeach
