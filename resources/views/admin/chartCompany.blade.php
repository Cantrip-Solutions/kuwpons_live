@extends('layouts.apps')
@section('content')

<div class="small-header transition animated fadeIn">
    <div class="hpanel">
        <div class="panel-body">
            <div class="pull-right" id="hbreadcrumb">
                <ol class="hbreadcrumb breadcrumb">
                    <li> User Management </li>
                    <li class="active">
                        <span> Company </span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs"> Company </h2>
        </div>
    </div>
</div>
<div class="content animate-panel">
    <div class="row">
        <div class="col-lg-12">

            <div class="hpanel">

                <div class="panel-body">
                    <p align="right">
                        {{link_to_route('addCompany', $title = 'Add Company', $parameters = array(), $attributes = array('type'=>'button', 'class'=>'btn w-xs btn-info'))}}
                    </p>                
                    @if (Session::has('message'))
                       <div class="alert alert-info"><i class="pe-7s-gleam"></i>{{ Session::get('message') }}</div>
                    @endif
                    
                    <table id="example1" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Password</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td> {!!HTML::image(config('global.uploadPath').'/'.$user->image, 'alt', array('width'=>'30', 'height'=>'30'))!!}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->getdefaultUserInfo->phone}}</td>
                                <td>{{$user->showPassword}}</td>
                                <td>
                                    @if($user->status == 0)
                                       @php  $status='InActive';  @endphp 
                                    @elseif($user->status == 1)
                                        @php  $status='Active';  @endphp 
                                    @elseif($user->status == 2)
                                        @php  $status='Suspended';  @endphp 
                                    @endif
                                    {{ $status }}
                                </td>
                                <td>{{$user->created_at}}</td>
                                <td>
                                    <a style="font-size: medium;" class="fa fa-pencil-square-o" title="Edit" href="/tab/company/edit/{{$user->name}}/{{Crypt::encrypt($user->id)}}"></a>
                                    <a style="font-size: medium;" class="fa fa-trash-o" title="Delete" id="{{Crypt::encrypt($user->id)}}"></a>
                                    <a style="font-size: medium;" class="pe pe-7s-repeat" title="{{ $status }}" id="{{Crypt::encrypt($user->id)}}"></a>
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
            bootbox.confirm("Are you sure to delete this User?", function(result) {
                if (result) {
                    window.location.href = "/tab/company/delete/"+id;
                } else {
                }
            });
        });
    $('.pe-7s-repeat').on('click', function(){
            var id = $(this).attr('id');
            bootbox.confirm("Are you sure to change status this User?", function(result) {
                if (result) {
                    window.location.href = "/tab/company/changeStatus/"+id;
                } else {
                }
            });
        });
</script>
@endpush
@endsection