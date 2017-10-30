@extends('layouts.frontEnd')

@section('content')

  <div class="body_content">



 <section class="cart-details-sec">

      <div class="container">

        <h1>Order History</h1>

        <div class="cart-main">

          <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12">

              <div class="cart-btn-box">

                {{-- <cartstock> <i class="fa fa-check-circle" aria-hidden="true"></i> <span>"Sydney" has been added to your cart.</span> </cartstock> --}}

              </div>

              <div class="product-cart-item">

                <table id="cart">

                  <thead>

                    <tr>

                      {{-- <th class="">&nbsp;</th> --}}

                      <th class="">Transaction Code</th>

                      <th class="">Product</th>

                      <th class="">Quantity</th>

                      <th class="">Quantity Redeemed</th>

                      <th class="">Quantity Not Redeemed</th>

                      <th class="">Total</th>

                      

                    </tr>

                  </thead>

                  <tbody>

                    @foreach($orderHistory as $order)

                    <tr>

                      <td >{{$order->transactionscode}}</td>

                      <td>

                        {!!HTML::image(config('global.productPath').$order->getProductsInfo->defaultImage->image, 'Loading...',array('class'=>'thumb'))!!}

                        {{$order->getProductsInfo->name}}

                      </td>

                      <td>{{$order->quantity}}</td>

                      <td >{{ count($order->getRedeemedCoupons) }}</td>

                      <td >{{ count($order->getNotRedeemedCoupons) }}</td>

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

