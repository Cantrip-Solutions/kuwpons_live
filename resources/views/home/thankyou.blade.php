@extends('layouts.frontEnd')

@section('content')

  <div class="body_content">



 <section class="cart-details-sec">

      <div class="container">
      @if( $thankyou_msg['type'] == 'success' )
        <div class="alert alert-success">
      @else 
        <div class="alert alert-danger">
      @endif
          <h3>{{$thankyou_msg['message']}}</h3>
        </div>

        <div class="cart-main">

          <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12">

              <div class="cart-btn-box">

              </div>

              <div class="product-cart-item">

                <table id="cart">

                  <thead>

                    <tr>

                      <th class="">&nbsp;&nbsp;</th>

                      <th class="">Product</th>

                      <th class="">Quantity</th>

                      <th class="">Total</th>

                    </tr>

                  </thead>

                  <tbody>

                    @foreach($orderHistory as $order)

                    <tr>

                      <td>

                        {!!HTML::image(config('global.productPath').$order->getProductsInfo->defaultImage->image, 'Loading...',array('class'=>'thumb'))!!}

                      </td>

                      <td> 

                        {{$order->getProductsInfo->name}}

                      </td>

                      <td>{{$order->quantity}}</td>

                      <td >KD {{$order->total_price}}</td>

                    </tr>

                    @endforeach

                  </tbody>

                </table>

              </div>

            </div>

          </div>

        </div>

      </div>

    </section>

  </div>

@endsection

