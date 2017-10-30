@extends('layouts.apps')
@section('content')

<div class="small-header transition animated fadeIn">
    <div class="hpanel">
        <div class="panel-body">
            <div class="pull-right" id="hbreadcrumb">
                <ol class="hbreadcrumb breadcrumb">
                    <li> Coupon Management </li>
                    <li class="active">
                        <span> Coupon Details</span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs"> Coupon Details </h2>
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

                    <table id="example1" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Image</th>  
                            <th>Name</th>
                            <th>Original Price (KD)</th>
                            <th>Selling Price (KD)</th>
                            <th>Quantity Remaining</th>
                            <th>Quantity Sold</th>
                            <th>Quantity Redeemed</th>
                            {{-- <th>Company</th> --}}
                            <th>Category</th>
                            <th>Expire on</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>

                                <td>{{$product->id}}</td>
                                <td>
                                {{-- {{$product->defaultImage}} --}}
                                {!!HTML::image(config('global.productPath').'/'.$product->defaultImage->image, 'alt', array('width'=>'30', 'height'=>'30'))!!}
                                </td>
                                <td>{{$product->name}}</td>
                                <td>{{$product->original_price}}</td>
                                <td>{{$product->saling_price}}</td>
                                <td>{{$product->quantity}}</td>
                                <td>@php
                                    $exp = explode(',',str_replace(']', '', str_replace('[', '', $product->soldCoupon->pluck('quantity'))));
                                    echo array_sum($exp);
                                @endphp</td>
                                <td>{{count($product->reedemedCoupon)}}</td>

                                {{-- <td> --}}
                                {{-- {{array_sum(empty($product->soldCoupon->pluck('quantity')) ? empty($product->soldCoupon->pluck('quantity')) : [0])}} --}}
                                {{-- </td> --}}
                                {{-- <td>{{$product->getUser->name}}</td> --}}
                                <td>{{$product->getCategory->cat_name}}</td>
                                <td>
                                    {{ date('Y-m-d',strtotime($product->expire_on)) }}
                                    @if(strtotime($product->expire_on) < strtotime(date('Y-m-d')) )
                                        ( Expired )
                                    @else
                                        ( Valid )
                                    @endif
                                </td>
                                {{-- <td> --}}
                                    {{-- <a style="font-size: medium;" title="Image Gallery" class="pe pe-7s-cloud-upload" href="/tab/product/imageGallery/{{urlencode($product->name)}}/{{Crypt::encrypt($product->id)}}"></a> --}}
                                    {{-- <a style="font-size: medium;" title="Stock History" class="pe pe-7s-server" href="/tab/product/stockHistory/{{urlencode($product->name)}}/{{Crypt::encrypt($product->id)}}"></a> --}}
                                    {{-- <a style="font-size: medium;" title="Edit Product" class="fa fa-pencil-square-o" href="/tab/product/edit/{{urlencode($product->name)}}/{{Crypt::encrypt($product->id)}}"></a> --}}
                                    {{-- <a style="font-size: medium;" title="Delete Product" class="fa fa-trash-o" id="{{Crypt::encrypt($product->id)}}"></a> --}}
                                {{-- </td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@push('css')
{!! HTML::style('public/admintheme/vendor/datatables_plugins_homer/integration/bootstrap/3/dataTables.bootstrap.css') !!}
@endpush
@push('scripts')

{!! HTML::script('public/admintheme/vendor/datatables_homer/media/js/jquery.dataTables.min.js') !!}
{!! HTML::script('public/admintheme/vendor/datatables_plugins_homer/integration/bootstrap/3/dataTables.bootstrap.min.js') !!}

<script type="text/javascript">
    var dataTable = $('#example1').dataTable();
    // $('.fa-trash-o').on('click', function(){
    //         var id = $(this).attr('id');
    //         bootbox.confirm("Are you sure to delete this User?", function(result) {
    //             if (result == true) {
    //                 window.location.href = "/tab/company/delete/"+id;
    //             } else {
    //             }
    //         });
    //     });
</script>
@endpush
@endsection