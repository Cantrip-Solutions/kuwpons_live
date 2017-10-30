@extends('layouts.frontEnd')
@section('content')

<div class="body_content">
  	<section class="product-dt-holder">
	    <div class="container">
	        <div class="prod-top-dt">
	        	<h1>Products Details</h1>
		        <div class="row">
		            <div class="col-lg-6 col-md-6 col-sm-12">
			            <div class="prod-top-dt-left">
			                <div class="zoom-wrap">
			                	<div class="zoom-small-image">
                          <a href='{{URL('/').'/'.config('global.productPath').$productDetails->defaultImage->image}}' class = 'cloud-zoom' id='zoom1' rel="adjustX:10, adjustY:-4">
                            {!!HTML::image(config('global.productPath').$productDetails->defaultImage->image)!!}
                          </a>
                        </div>
				                <div class="zoom-desc">
				                     <ul class="responsive-zoom slider">
                              @foreach($productDetails->getImages as $productImage)
                                <li class="thumbAc">
                                <a href='{{URL('/').'/'.config('global.productPath').$productImage->image}}' class='cloud-zoom-gallery' title='Red' rel="useZoom: 'zoom1', smallImage: '{{URL('/').'/'.config('global.productPath').$productImage->image}}' ">
                                  {!!HTML::image(config('global.productPath').$productImage->image, '', array('class'=>"zoom-tiny-image",'width'=>"", 'height'=>"" ))!!}
                                  {{-- <img class="zoom-tiny-image" src="images/Product-dtl-zoom.jpg" width="" height="" alt = "Thumbnail 1"/> --}}
                                </a> </li>
                              @endforeach
				                      {{-- <li class="thumbAc"> <a href='images/Product-dtl-zoom.jpg' class='cloud-zoom-gallery' title='Red' rel="useZoom: 'zoom1', smallImage: 'images/Product-dtl-zoom.jpg' "><img class="zoom-tiny-image" src="images/Product-dtl-zoom.jpg" width="" height="" alt = "Thumbnail 1"/></a> </li>

				                      <li class="thumbAc"> <a href='images/Product-dtl-zoom2.jpg' class='cloud-zoom-gallery' title='Red' rel="useZoom: 'zoom1', smallImage: 'images/Product-dtl-zoom2.jpg' "><img class="zoom-tiny-image" src="images/Product-dtl-zoom2.jpg" width="" height="" alt = "Thumbnail 1"/></a> </li>
                              
				                      <li class="thumbAc"> <a href='images/Product-dtl-zoom.jpg' class='cloud-zoom-gallery' title='Red' rel="useZoom: 'zoom1', smallImage: 'images/Product-dtl-zoom.jpg' "><img class="zoom-tiny-image" src="images/Product-dtl-zoom.jpg" width="" height="" alt = "Thumbnail 1"/></a> </li>
				                      <li class="thumbAc"> <a href='images/Product-dtl-zoom3.jpg' class='cloud-zoom-gallery' title='Red' rel="useZoom: 'zoom1', smallImage: 'images/Product-dtl-zoom3.jpg' "><img class="zoom-tiny-image" src="images/Product-dtl-zoom3.jpg" width="" height="" alt = "Thumbnail 1"/></a> </li> --}}
				                    </ul>
				                </div>
			                </div>
			            </div>
		            </div>
		            
		            <div class="col-lg-6 col-md-6 col-sm-12">
			            <div class="prod-top-dt-right">
			                <h3>{{ $productDetails->name }}</h3>
			                <p>{{ substr($productDetails->description,0,500) }}</p>
			                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>       
			                <div class="p-details-price">
			                   <h2>Price <span> $ 220.00 </span> </h2>
			                   <h2>Discount Price <span> $ 200.00 </span> </h2>
			                   <h3>Category | Product | Food</h3>
			                </div>
			                <div class="qty-wrap">
			                  <h3>Quantity</h3>
			                  <div class="qty-sec">
			                    <button id="minus"><i class="fa fa-chevron-down" aria-hidden="true"></i> </button>
			                    <input id="num" type="text" value="0">
			                    <button id="plus"><i class="fa fa-chevron-up" aria-hidden="true"></i> </button>
			                  </div>
			                  <a href="#" class="addcard">Add To Cart</a> </div>
			            </div>
		            </div>
		        </div>
	          
	          	<div class="tab-wrap">
		            <div class="tab-main">
		                <ul class="tabs">
		                  <li class="tablinks tab col s2" onclick="registrationtab(event, 'Description')" id="defaultOpen">Description</li>  |
		                  <li class="tablinks tab col s2" onclick="registrationtab(event, 'Enquiry')">Enquiry Now</li>
		                </ul>
		            </div>
		            <div class="tab-content-wrap">
		                <div id="Description" class="tabcontent">
		                  <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce luctus pulvinar efficitur. Duis eleifend nibh id leo pretium condimentum. Curabitur dignissim massa quis nisi dictum, in congue quam ultrices. Mauris sagittis mi vitae arcu fringilla, a congue lacus molestie. Quisque venenatis urna nisi, sit amet feugiat urna imperdiet nec. Nunc eros ante, dictum eget ornare at, elementum eget odio. Sed hendrerit turpis ut orci mattis dictum. Pellentesque eros lorem, tempor a pellentesque nec, dapibus sit amet felis. Mauris ut molestie risus, at laoreet urna. Curabitur porttitor pharetra sapien nec scelerisque. Nam in turpis tincidunt, cursus nibh eget, hendrerit orci. Suspendisse pharetra eleifend turpis, sit amet bibendum velit lacinia ac. Duis interdum eros velit, quis mattis sem lobortis et. Quisque consectetur risus velit, non vehicula arcu varius in.</p>

							<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Cras ornare augue eget diam elementum, sed egestas nibh vestibulum. Praesent tristique leo purus, vel efficitur lorem eleifend vel. Mauris tincidunt pharetra leo, in euismod dui auctor eu. Ut purus neque, rutrum quis lorem quis, dictum varius enim. Donec tempor sagittis tortor eget volutpat. </p>
		                </div>
		                <div id="Enquiry" class="tabcontent">
		                  <p> World is There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. </p>
		                </div>
		            </div>
	          	</div>
	        </div>
	    </div>
    </section>

    <section class="related-product-sec">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="product-list-sec">
              <h1>Related Products</h1>
              <div class="product-list">
                <div class="row">
                  <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="product-list-border">
                      <figure> <img src="images/product-list-1.jpg" alt="" class=""/> </figure>
                      <div class="product-list-text">
                        <h3>Lorem Ipsum</h3>
                        <p>Has been the industry's standard dummy text ever.</p>
                        <h2>Price <span> $ 220.00 </span> </h2>
                        <h2>Discount Price <span> $ 200.00 </span> </h2>
                        <div class="mid-deals">
                          <h2>Deals sold <span> 1 </span> </h2>
                          <span> Expiry Date 14.10.2017 </span> </div>
                        <div class="loc-cart">
                          <div class="map-loc"> <span><i class="fa fa-map-marker" aria-hidden="true"></i> Sydney </span> </div>
                          <div class="cart-icon"> <span class="btn-green"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span> </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="product-list-border">
                      <figure> <img src="images/product-list-7.jpg" alt="" class=""/> </figure>
                      <div class="product-list-text">
                        <h3>Lorem Ipsum</h3>
                        <p>Has been the industry's standard dummy text ever.</p>
                        <h2>Price <span> $ 220.00 </span> </h2>
                        <h2>Discount Price <span> $ 200.00 </span> </h2>
                        <div class="mid-deals">
                          <h2>Deals sold <span> 1 </span> </h2>
                          <span> Expiry Date 14.10.2017 </span> </div>
                        <div class="loc-cart">
                          <div class="map-loc"> <span><i class="fa fa-map-marker" aria-hidden="true"></i> Sydney </span> </div>
                          <div class="cart-icon"> <span class="btn-green"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span> </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="product-list-border">
                      <figure> <img src="images/product-list-8.jpg" alt="" class=""/> </figure>
                      <div class="product-list-text">
                        <h3>Lorem Ipsum</h3>
                        <p>Has been the industry's standard dummy text ever.</p>
                        <h2>Price <span> $ 220.00 </span> </h2>
                        <h2>Discount Price <span> $ 200.00 </span> </h2>
                        <div class="mid-deals">
                          <h2>Deals sold <span> 1 </span> </h2>
                          <span> Expiry Date 14.10.2017 </span> </div>
                        <div class="loc-cart">
                          <div class="map-loc"> <span><i class="fa fa-map-marker" aria-hidden="true"></i> Sydney </span> </div>
                          <div class="cart-icon"> <span class="btn-green"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span> </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="product-list-border">
                      <figure> <img src="images/product-list-9.jpg" alt="" class=""/> </figure>
                      <div class="product-list-text">
                        <h3>Lorem Ipsum</h3>
                        <p>Has been the industry's standard dummy text ever.</p>
                        <h2>Price <span> $ 220.00 </span> </h2>
                        <h2>Discount Price <span> $ 200.00 </span> </h2>
                        <div class="mid-deals">
                          <h2>Deals sold <span> 1 </span> </h2>
                          <span> Expiry Date 14.10.2017 </span> </div>
                        <div class="loc-cart">
                          <div class="map-loc"> <span><i class="fa fa-map-marker" aria-hidden="true"></i> Sydney </span> </div>
                          <div class="cart-icon"> <span class="btn-green"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span> </div>
                        </div>
                      </div>
                    </div>
                  </div>
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
@push('css')
{!!HTML::style('kuwpons/css/cloud-zoom.css')!!}
@endpush
@push('scripts')
{!!HTML::script('kuwpons/js/cloud-zoom.js')!!}

<script>
function registrationtab(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>
@endpush
@endsection
