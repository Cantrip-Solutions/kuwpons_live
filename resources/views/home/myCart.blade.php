@extends('layouts.frontEnd')
@section('content')
  <div class="body_content">

 <section class="cart-details-sec">
      <div class="container">
        <h1>CART</h1>
        <div class="cart-main">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="cart-btn-box">
                {{-- <cartstock> <i class="fa fa-check-circle" aria-hidden="true"></i> <span>"Sydney" has been added to your cart.</span> </cartstock> --}}
                <continueshoop> <a class="defaultbtn" href="{{URL::to('/')}}" >Continue shopping</a> </continueshoop>
              </div>
              <div class="product-cart-item">
                <table id="cart">
                  <thead>
                    <tr>
                      {{-- <th class="">&nbsp;</th> --}}
                      <th class="">&nbsp;</th>
                      <th class="">Product</th>
                      <th class="">Price</th>
                      <th class="">Quantity</th>
                      <th class="">Total</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  {{-- {{var_dump($bucketProducts)}} --}}
                  {{-- @php
                   print_r($bucketProducts); 
                  @endphp --}}
                    @foreach($productDetails as $product)
                    <tr>
                      <td>
                        {!!HTML::image(config('global.productPath').$product->defaultImage->image, 'Loading...',array('class'=>'thumb'))!!}
                        {{-- <img src="images/product-list-6.jpg" class="thumb"> --}}
                      </td>
                      <td>{{$product->name}}</td>
                      <td class="proEachPrice">{{$product->saling_price}}</td>
                      <td><input type="number" value="{{$bucketProducts[$product->id]}}" proPrice="{{$product->saling_price}}" proID="{{$product->id}}" min="1" max="99" class="qtyinput"></td>
                      <td class="proTotalPrice">{{ (float)$product->saling_price*(int)$bucketProducts[$product->id] }}</td>
                      <td><a href="javascript:void(0)" class="deleteProductFromCart" proID="{{Crypt::encrypt($product->id)}}">
                      {{-- <img src="/kuwpons/images/remove.png"> --}}
                      Remove</a></td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              {{-- <div class="cart-btn-box"> --}}
                {{-- <applybtn> <a class="defaultbtn coupon-btn" href="" >Coupon Code</a> <a class="defaultbtn" href="" >Apply Coupon</a> </applybtn> --}}
                {{-- <continueshoop> <a class="defaultbtn" href="" >Update Cart</a> </continueshoop> --}}
              {{-- </div> --}}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-8 col-md-8"></div>
          <div class="col-lg-4 col-md-4">
            <div class="cart-total">
              <h3>Cart totals</h3>
              <div class="product-cart-total">
                <table id="cart">
                  <tbody>
                    <tr>
                      <td>Subtotal</td>
                      <td><span id="sub_total_price"></span> KD</td>
                    </tr>
                    <tr>
                      <td>Total</td>
                      <td><span id="total_price"></span> KD</td>
                    </tr>
                  </tbody>
                </table>
                <a href="/myAccount/checkout"><button class="defaultbtn checkout-btn">Proceed to checkout</button></a>
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
<script type="text/javascript">
  $('.qtyinput').on('click',function () {
    var quantity = $(this).val();
    var proID = $(this).attr('proID');
    var proPrice = $(this).attr('proPrice');
    var token = $('input[name=_token]').val();
    var obj=$(this);
    $.ajax({
      'type':'post',
      'url':'{{URL::to('updateCartQuantity')}}',
      'headers': {'X-CSRF-TOKEN': token},
      'data':{'proID':proID, 'quantity':quantity},
      // 'dataType':'json',
      'beforeSend':function(){  $('.cart-main').mask('Please Wait...'); },
      'success':function(resp){
        obj.parents('tr').find('.proTotalPrice').text(proPrice * quantity);
        totalPrice();
         $('.cart-main').unmask();
        // swal({title: resp.type, text: resp.message, type: resp.type});
        // cartValue();
      }
    }); 
  });
  $('.deleteProductFromCart').on('click',function () {
    var proID = $(this).attr('proID');
    var token = $('input[name=_token]').val();
    var obj=$(this);
    $.ajax({
      'type':'post',
      'url':'{{URL::to('deleteProductFromCart')}}',
      'headers': {'X-CSRF-TOKEN': token},
      'data':{'proID':proID},
      // 'dataType':'json',
      'beforeSend':function(){  $('.cart-main').mask('Please Wait...'); },
      'success':function(resp){
        obj.closest("tr").empty();
        totalPrice();
        $('.cart-main').unmask();
      }
    }); 
  })
  totalPrice();
  function totalPrice() {
    var sum = 0;
    $('.proTotalPrice').each(function (i) {
        sum += parseFloat($('.proTotalPrice').eq(i).html());
        // console.log($('.proTotalPrice').eq(i).html());
    });
    // console.log(sum);

    $('#sub_total_price').text(sum);
    $('#total_price').text(sum);
  }
</script>
@endpush

@endsection
