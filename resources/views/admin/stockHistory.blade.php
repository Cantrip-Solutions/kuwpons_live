@extends('layouts.apps')
@section('content')

<div class="small-header transition animated fadeIn">
    <div class="hpanel">
        <div class="panel-body">
            <div class="pull-right" id="hbreadcrumb">
                <ol class="hbreadcrumb breadcrumb">
                    <li> Product Management </li>
                    <li> Stock </li>
                    <li class="active">
                        <span> Stock History </span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs"> Product Name: {{$productInfo->name}}</h2>
        </div>
    </div>
</div>
<div class="content animate-panel">
    <div class="row">
        <div class="col-lg-12">

            <div class="hpanel">
                <div class="panel-body"> 
                    <h2 class="font-light m-b-xs"> In Stock: {{$productInfo->quantity}}</h2>
                    <p align="right">
                        
                        <a href="/tab/product/stockAdjust/{{urlencode($productInfo->name)}}/{{Crypt::encrypt($productInfo->id)}}" class="btn w-xs btn-info" > Stock Adjustment</a>
                    </p> 
                    @if (Session::has('message'))
                       <div class="alert alert-info"><i class="pe-7s-gleam"></i>{{ Session::get('message') }}</div>
                    @endif

                    <table id="example1" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Quantity</th>  
                            <th>Expire On</th>
                            <th>Valid</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($stockHistory as $stock)
                            <tr>

                                <td>{{$stock->id}}</td>
                                <td>{{$stock->quantity}}</td>
                                <td>{{ date('Y-m-d',strtotime($stock->expire_on)) }}</td>
                                <td>@if(strtotime($stock->expire_on) < strtotime(date('Y-m-d')) )
                                        Expired
                                    @else
                                        Valid
                                    @endif
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
    $('.fa-trash-o').on('click', function(){
            var id = $(this).attr('id');
            bootbox.confirm("Are you sure to delete this Product?", function(result) {
                if (result == true) {
                    window.location.href = "/tab/product/delete/"+id;
                } else {
                }
            });
        });
</script>
@endpush
@endsection