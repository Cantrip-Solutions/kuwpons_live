@extends('layouts.apps')
@section('content')

<div class="small-header transition animated fadeIn">
    <div class="hpanel">
        <div class="panel-body">
            <div class="pull-right" id="hbreadcrumb">
                <ol class="hbreadcrumb breadcrumb">
                    <li> Orders Management </li>
                    <li class="active">
                        <span> Transactions </span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs"> Transactions </h2>
        </div>
    </div>
</div>
<div class="content animate-panel">
    <div class="row">
        <div class="col-lg-12">

            <div class="hpanel">

                <div class="panel-body">
                    {{-- <p align="right">
                        {{link_to_route('addCompany', $title = 'Add Company', $parameters = array(), $attributes = array('type'=>'button', 'class'=>'btn w-xs btn-info'))}}
                    </p>  --}}               
                    @if (Session::has('message'))
                       <div class="alert alert-info"><i class="pe-7s-gleam"></i>{{ Session::get('message') }}</div>
                    @endif
                    <table id="example1" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Trans Code</th>
                            <th>Parent Trans Code ( Incase of Refund )</th>
                            {{-- <th>Product ( Incase of Refund ) </th> --}}
                            <th>Buyer</th>
                            <th>Amount</th>
                            <th>Coupon Code</th>
                            <th>Delivery Charges</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                            <tr>
                                <td>{{$transaction->id}}</td>
                                <td>{{$transaction->trans_code}}</td>
                                <td>{{$transaction->p_trans_code}}</td>
                                {{-- <td><a href="{{$transaction->getProductsInfo->id}}">{{$transaction->getProductsInfo->name}}</a></td> --}}
                                <td>{{$transaction->getUsersInfo->name}}</td>
                                <td>{{$transaction->amount}}</td>
                                <td>{{$transaction->coupon_code}}</td>
                                <td>{{$transaction->delivery_charges}}</td>
                                <td>{{$transaction->method}}</td>
                                <td>{{$transaction->status}}</td>
                                <td>{{$transaction->created_at}}</td>
                                <td>
                                    {{-- <a style="font-size: medium;" class="fa fa-pencil-square-o" href="/tab/company/edit/{{$user->name}}/{{Crypt::encrypt($user->id)}}"></a>
                                    <a style="font-size: medium;" class="fa fa-trash-o" id="{{Crypt::encrypt($user->id)}}"></a> --}}
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