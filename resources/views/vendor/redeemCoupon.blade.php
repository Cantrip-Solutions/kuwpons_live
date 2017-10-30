@extends('layouts.apps')
@section('content')

<div class="small-header transition animated fadeIn">
    <div class="hpanel">
        <div class="panel-body">
            <div class="pull-right" id="hbreadcrumb">
                <ol class="hbreadcrumb breadcrumb">
                    <li> Coupon Management </li>
                    <li class="active">
                        <span> Redeem Coupon</span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs"> Redeem Coupon </h2>
        </div>
    </div>
</div>
<div class="content animate-panel">
    <div class="row">
        <div class="col-lg-12">

            <div class="hpanel">

                <div class="panel-body">
                    <input type="text" name="couponCode" class="couponCode">
                    <button id="checkCouponCode"> Redeem</button>
                </div>
            </div>
        </div>
    </div>
    
</div>
@push('css')
{!!HTML::style('public/admintheme/vendor/sweetalert/lib/sweet-alert.css')!!}
{!! HTML::style('public/plugins/jquery-loadmask-master/jquery.loadmask.css') !!}
@endpush
@push('scripts')
{!! HTML::script('public/admintheme/vendor/sweetalert/lib/sweet-alert.min.js') !!}
{!! HTML::script('public/plugins/jquery-loadmask-master/jquery.loadmask.min.js') !!}

<script type="text/javascript">
    $('#checkCouponCode').on('click', function () {
        // swal({title: 'success', text: 'sadsaf', type: 'success'});
        var couponCode = $('.couponCode').val();
        if(couponCode == ''){
            swal({title: 'Error!', text: 'Please Enter Coupon Code', type: 'error'});
        } else{
            var token = $('input[name=_token]').val();
            $.ajax({
                'type':'post',
                'url':'{{URL::to('/vendor/updateCoupon')}}',
                'headers': {'X-CSRF-TOKEN': token},
                'data':{'couponCode':couponCode},
                'dataType':'json',
                'beforeSend':function(){ $('.row').mask('Please Wait...'); },
                'success':function(resp){
                  swal({title: resp.type, text: resp.message, type: resp.type});
                  $('.row').unmask();
                }
            }); 
        }
    });
</script>
@endpush
@endsection