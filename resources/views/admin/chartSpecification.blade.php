@extends('layouts.apps')
@section('content')

<div class="small-header transition animated fadeIn">
    <div class="hpanel">
        <div class="panel-body">
            <div class="pull-right" id="hbreadcrumb">
                <ol class="hbreadcrumb breadcrumb">
                    <li> Specification Management </li>
                    <li class="active">
                        <span> Specifications </span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs"> Specifications </h2>
        </div>
    </div>
</div>
<div class="content animate-panel">
    <div class="row">
        <div class="col-lg-12">

            <div class="hpanel">

                <div class="panel-body">
                    <p align="right">
                        {{link_to_route('addSpecification', $title = 'Add Specification', $parameters = array(), $attributes = array('type'=>'button', 'class'=>'btn w-xs btn-info'))}}
                    </p>                
                    @if (Session::has('message'))
                       <div class="alert alert-info"><i class="pe-7s-gleam"></i>{{ Session::get('message') }}</div>
                    @endif
                    <div class="table-responsive"> 
                        <table id="example1" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Cat ID</th>
                                <th>Attributes</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($specifications as $specification)
                                <tr>
                                    <td>{{$specification->id}}</td>
                                    <td>{{$specification->getCategoryInfo->name}}</td>
                                    <td>{{$specification->attributes}}</td>
                                    <td>{{$specification->created_at}}</td>
                                    <td></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
</script>
@endpush
@endsection