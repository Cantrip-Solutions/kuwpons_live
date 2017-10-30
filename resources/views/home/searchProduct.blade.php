@extends('layouts.frontEnd')
@section('content')
  <div class="body_content">
    <section class="category-sec">
      <div class="container">
       <div class="row">
         <div class="col-lg-3 col-md-3 col-sm-12">
         <div class="category-list">
           <h3>Categories</h3>
          <ul>
          @foreach($categories as $category)
              <li><a href="/category/{{urlencode(str_replace('/', '&#47;',$category->cat_name))}}/{{Crypt::encrypt($category->id)}}"><i class="fa fa-chevron-right" aria-hidden="true"></i> {{$category->cat_name}}</a></li>
          @endforeach
          </ul>
          </div>
         </div>
         
         <div class="col-lg-9 col-md-9 col-sm-12">
         <div class="product-list-sec">
           <h1>Searched By "{{$reqSearch}}"</h1>
          <div class="product-list">
            <div class="row">
              {{-- {{$searchedProducts}} --}}
              @foreach($searchedProducts as $product)
              <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="product-list-border">
                  <div class="discount-product">
                  <figure> 
                  <a href="/coupon/{{urlencode($product->name)}}/{{Crypt::encrypt($product->id)}}">
                  {!!HTML::image(config('global.productPath').$product->defaultImage->image, 'Loading...')!!}
                  </a>
                  {{-- <img src="images/product-list-1.jpg" alt="" class=""/>  --}}
                  </figure>
                    @php
                      $off = Helper::discountOff($product->original_price,$product->discounted_price);
                    @endphp
                     @if($off != '0')
                      <span>{{$off}}% </br>Off</span>
                     @endif
                 </div>
                  <div class="product-list-text">
                      <h3 ><a href="/coupon/{{urlencode($product->name)}}/{{Crypt::encrypt($product->id)}}">{{$product->name}}</a></h3>
                      <h2>Deal  <span class="old-price"> {{ $product->original_price }} KD </span> to <span> {{$product->discounted_price}} KD </span></h2>
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
@endsection

