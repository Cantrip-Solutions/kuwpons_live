@extends('layouts.frontEnd')
@section('content')
  <div class="body_content">
    <section class="new-coupons-sec">
      <div class="container">
<div class="row">
         <div class="col-lg-3 col-md-4 col-sm-12">
           <div class="category-list">
             <h3>Categories</h3>
            <ul>
            @foreach($categories as $category)
                <li><a href="/category/{{urlencode(str_replace('/', '&#47;',$category->cat_name))}}/{{Crypt::encrypt($category->id)}}"><i class="fa fa-chevron-right" aria-hidden="true"></i> {{$category->cat_name}} {!!HTML::image(config('global.categoryPath').$category->cat_icon, 'Loading...')!!}</a></li>
            @endforeach
            </ul>
            </div>
         </div>
         <div class="col-lg-9 col-md-8 col-sm-12">
         <div class="product-list-sec">
           <h1>NEW KUWPONS</h1>
        <div class="product-list">
          <div class="row">
          {{-- @if (Cookie::get('bucket') !== false) {
             <div class="alert alert-info"><i class="pe-7s-gleam"></i>{{Cookie::get('bucket')}}</div>
          @endif --}}
          {{-- {{$newCoupons}} --}}
            @foreach($newCoupons as $newCoupon)
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="product-list-border">
                  <div class="discount-product">
                   <figure>
                    <a href="/coupon/{{urlencode($newCoupon->name)}}/{{Crypt::encrypt($newCoupon->id)}}">
                      {!!HTML::image(config('global.productPath').$newCoupon->defaultImage->image, 'Loading...')!!}
                    </a>
                   </figure>
                   @php
                     $off = Helper::discountOff($newCoupon->original_price,$newCoupon->discounted_price);
                   @endphp
                   @if($off != '0')
                    <span>{{$off}}% </br>Off</span>
                   @endif
                  </div>
                  <div class="product-list-text">
                     <h3 style="color:#636161;">
                        <a href="/coupon/{{urlencode($newCoupon->name)}}/{{Crypt::encrypt($newCoupon->id)}}">
                          {{$newCoupon->name}}
                        </a>
                     </h3>
                     <h2>Deal  <span class="old-price"> {{ $newCoupon->original_price }} KD </span> to <span>  {{$newCoupon->discounted_price}} KD </span></h2>
                     <h2>Kuwpon Price <span class="kuwpon-price-color"> {{$newCoupon->saling_price}} KD</span></h2>
                     <div class="mid-deals">
                     <a href="/coupon/{{urlencode($newCoupon->name)}}/{{Crypt::encrypt($newCoupon->id)}}"><div class="defaultbtn btn-green coupons-price-btn" proID="{{Crypt::encrypt($newCoupon->id)}}" style="cursor: pointer;" > <span class="new-price">BUY KUWPON</span></div></a>
                     </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
</div>
</div>
         </div>

      
      </div>
    </section>
    {{-- <section class="discounts-sec">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-md-6">
            <div class="discount_img">
              <figure>

                  {!!HTML::image('kuwpons/images/coupons-img-1.jpg', 'Loading...')!!}
                <!-- <img src="images/coupons-img-2.jpg" alt="" class=""/>  -->
                </figure>
              <div class="discount_contant">
                <div class="discount-text">
                  <h1>20%</h1>
                  <span>Beauty / health</span>
                  <h3>Discounts</h3>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6">
            <div class="discount-right">
              <div class="row">
                <div class="col-lg-3 col-md-3 col-xs-3">
                  <div class="discount-right-img">
                  <figure>

                  {!!HTML::image('kuwpons/images/discount-icon-1.jpg', 'Loading...')!!}
                <!-- <img src="images/coupons-img-2.jpg" alt="" class=""/>  -->
                </figure>
                    <!-- <figure> <img src="images/discount-icon-1.jpg" alt="" class=""/> </figure> -->
                  </div>
                </div>
                <div class="discount-right-text">
                  <div class="col-lg-7 col-md-7 col-xs-7">
                    <p>It has roots in a piece of classical Latin literature making it over 2000 years old.</p>
                  </div>
                  <div class="col-lg-2 col-md-2 col-xs-2"> <span class="price-old">$150</span> <span class="price-new">$100</span> </div>
                </div>
              </div>
            </div>
            <div class="discount-right">
              <div class="row">
                <div class="col-lg-3 col-md-3 col-xs-3">
                  <div class="discount-right-img">
                    <figure>

                  {!!HTML::image('kuwpons/images/discount-icon-2.jpg', 'Loading...')!!}
                <!-- <img src="images/coupons-img-2.jpg" alt="" class=""/>  -->
                </figure>
                    <!-- <figure> <img src="images/discount-icon-2.jpg" alt="" class=""/> </figure> -->
                  </div>
                </div>
                <div class="discount-right-text">
                  <div class="col-lg-7 col-md-7 col-xs-7">
                    <p>It has roots in a piece of classical Latin literature making it over 2000 years old.</p>
                  </div>
                  <div class="col-lg-2 col-md-2 col-xs-2"> <span class="price-old">$150</span> <span class="price-new">$100</span> </div>
                </div>
              </div>
            </div>
            <div class="discount-right">
              <div class="row">
                <div class="col-lg-3 col-md-3 col-xs-3">
                  <div class="discount-right-img">
                    <figure>

                  {!!HTML::image('kuwpons/images/discount-icon-3.jpg', 'Loading...')!!}
                <!-- <img src="images/coupons-img-2.jpg" alt="" class=""/>  -->
                </figure>
                    <!-- <figure> <img src="images/discount-icon-3.jpg" alt="" class=""/> </figure> -->
                  </div>
                </div>
                <div class="discount-right-text">
                  <div class="col-lg-7 col-md-7 col-xs-7">
                    <p>It has roots in a piece of classical Latin literature making it over 2000 years old.</p>
                  </div>
                  <div class="col-lg-2 col-md-2 col-xs-2"> <span class="price-old">$150</span> <span class="price-new">$100</span> </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section> --}}
    <section class="popular-coupons-sec new-features-sec">
      <div class="container">
       <div class="product-list-sec new-features">
        <h1>FEATURED KUWPONS</h1>
        <div class="product-list feature-list">
          <div class="row">
            @foreach($featureProduct as $key => $product)

              <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="coupons-box-border product-lists feature-coupon">
                  {{-- <figure>
                    {!!HTML::image(config('global.productPath').$product->img, 'Loading...')!!}
                  </figure> --}}
                   <div class="discount-product">
                   <figure>
                    <a href="/coupon/{{urlencode($product->name)}}/{{Crypt::encrypt($product->id)}}">
                      {!!HTML::image(config('global.productPath').$product->defaultImage->image, 'Loading...')!!}
                    </a>
                   </figure>
                   @php
                     $off = Helper::discountOff($product->original_price,$product->discounted_price);
                   @endphp
                   @if($off != '0')
                    <span>{{$off}}% </br>Off</span>
                   @endif
                    <div class="feature blue">
                     <h3>new!</h3>
                    </div>
                  </div>
                  <div class="product-list-text">
                    <h3 ><a href="/coupon/{{urlencode($product->name)}}/{{Crypt::encrypt($product->id)}}">{{$product->name}}</a></h3>
                     <h2>Deal  <span class="old-price">   {{ $product->original_price }} KD </span> to <span>  {{$product->discounted_price}} KD </span></h2>
                     <h2>Kuwpon Price <span class="kuwpon-price-color"> {{$product->saling_price}} KD </span></h2>
                     <div class="mid-deals">
                     <a href="/coupon/{{urlencode($product->name)}}/{{Crypt::encrypt($product->id)}}"><div class="defaultbtn btn-green coupons-price-btn" proID="{{Crypt::encrypt($product->id)}}" style="cursor: pointer;" ><span class="new-price">BUY KUWPON</span></div></a>
                     </div>
                  </div>
                </div>
              </div>

            @endforeach
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

</script>
@endpush
@endsection

