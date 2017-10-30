@extends('layouts.apps')

@section('content')



<div class="small-header transition animated fadeIn">

    <div class="hpanel">

        <div class="panel-body">

            <div class="pull-right" id="hbreadcrumb">

                <ol class="hbreadcrumb breadcrumb">

                    <li> Coupons Management </li>

                    <li class="active">

                        <span> Coupons </span>

                    </li>

                </ol>

            </div>

            <h2 class="font-light m-b-xs"> Coupons </h2>

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



                    {{Form::open(array('files'=>true,'id'=>'formdata','class'=>'form-horizontal','action' => 'ProductController@addFeaturedCoupons', 'method'=>'POST', 'enctype'=>"multipart/form-data"))}}

                        

                        <div class="form-group">

                            <label for="u_id_fk" class="col-sm-2 control-label">Select Coupon for featured*:</label>

                            <div class="col-sm-8">

                                <select class="js-source-states" name="featured" style="width: 100%">

                                    @foreach ($products as $key => $value)

                                        <option value="{{$value->id}}">{{$value->name}}</option>

                                    @endforeach

                                </select>

                                @if ($errors->has('featured'))

                                    <span class="help-block">

                                        <strong>{{ $errors->first('featured') }}</strong>

                                    </span>

                                @endif

                            </div>

                            <div class="col-sm-2">

                                <button type="submit" class="btn w-xs btn-success" name="submit">Submit</button>

                            </div>

                        </div>

                    {{Form::close()}}



                </div>

                <div class="panel-body">

                    <table id="example1" class="table table-striped table-bordered table-hover">

                        <thead>

                        <tr>

                            <th>Id</th>

                            <th>Image</th>  

                            <th>Name</th>

                            <th>Original Price (KD)</th>

                            <th>Discounted Price (KD)</th>

                            <th>Kuwpon Price (KD)</th>

                            {{-- <th>Quantity Remaining</th>

                            <th>Quantity Sold</th>

                            <th>Quantity Redeemed</th> --}}

                            <th>Company</th>

                            <th>Category</th>

                            <th>Expire on</th>

                            <th>Action</th>

                        </tr>

                        </thead>

                        <tbody>

                            @foreach($featuredProducts as $product)

                            <tr>



                                <td>{{$product->id}}</td>

                                <td>

                                {{-- {{$product->defaultImage}} --}}

                                {!!HTML::image(config('global.productPath').'/'.$product->defaultImage->image, 'alt', array('width'=>'30', 'height'=>'30'))!!}

                                </td>

                                <td>{{$product->name}}</td>

                                <td>{{$product->original_price}}</td>

                                <td>{{$product->discounted_price}}</td>

                                <td>{{$product->saling_price}}</td>

                                {{-- <td>{{$product->quantity}}</td>

                                <td>@php

                                    $exp = explode(',',str_replace(']', '', str_replace('[', '', $product->soldCoupon->pluck('quantity'))));

                                    echo array_sum($exp);

                                @endphp</td>

                                <td>{{count($product->reedemedCoupon)}}</td> --}}



                                {{-- <td> --}}

                                {{-- {{array_sum(empty($product->soldCoupon->pluck('quantity')) ? empty($product->soldCoupon->pluck('quantity')) : [0])}} --}}

                                {{-- </td> --}}

                                <td>{{$product->getUser->name}}</td>

                                <td>{{$product->getCategory->cat_name}}</td>

                                <td>

                                    {{ date('Y-m-d',strtotime($product->expire_on)) }}

                                    @if(strtotime($product->expire_on) < strtotime(date('Y-m-d')) )

                                        ( Expired )

                                    @else

                                        ( Valid )

                                    @endif

                                </td>

                                <td>

                                    <a style="font-size: medium;" title="Delete Product" class="fa fa-trash-o" id="{{Crypt::encrypt($product->id)}}"></a>

                                </td>

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

    {!!HTML::style('public/admintheme/vendor/select2-3.5.2/select2.css')!!}

    {!!HTML::style('public/admintheme/vendor/select2-bootstrap/select2-bootstrap.css')!!}

@endpush

@push('scripts')



    {!! HTML::script('public/admintheme/vendor/datatables_homer/media/js/jquery.dataTables.min.js') !!}

    {!! HTML::script('public/admintheme/vendor/datatables_plugins_homer/integration/bootstrap/3/dataTables.bootstrap.min.js') !!}

    {!! HTML::script('public/admintheme/vendor/select2-3.5.2/select2.min.js') !!}

    <script type="text/javascript">

        var dataTable = $('#example1').dataTable({

            responsive: true,

        });

        var base_url="{{URL::to('/')}}";

        var token ="{{ csrf_token() }}";

        $('.fa-trash-o').on('click', function(){

            var id = $(this).attr('id');

            var obj=$(this);

            bootbox.confirm("Are you sure to delete this Product From Featured List?", function(result) {

                if (result) {

                    $.ajax({

                        'type':'post',

                        'url':base_url+'/tab/featuredProduct/delete/'+id,

                        'headers': {'X-CSRF-TOKEN': token},

                        'data-type':'json',

                        'success':function(resp){

                            var result = jQuery.parseJSON(resp);

                            if(result.status==1){

                                obj.parent('td').parent('tr').remove();

                            }

                        }



                    });

                }

            });

        });





        

        $(".js-source-states").select2();

    </script>

@endpush

@endsection