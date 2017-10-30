@extends('layouts.apps')
@section('content')

<div class="small-header transition animated fadeIn">
    <div class="hpanel">
        <div class="panel-body">
            <div class="pull-right" id="hbreadcrumb">
                <ol class="hbreadcrumb breadcrumb">
                    <li> User Management </li>
                     
                    @if($user->u_role == 'U')
                        <li>Consumer</li><li class="active"><span> View Consumer </span></li>
                    @elseif($user->u_role == 'S')
                        <li>Company</li><li class="active"><span> View Company</span></li>
                    @endif
                </ol>
            </div>
            <h2 class="font-light m-b-xs"> User Details : {{$user->name}} </h2>
        </div>
    </div>
</div>
<div class="content animate-panel">
    <div class="row">
        <div class="col-lg-12">
            <div class="hpanel">
                <div class="panel-body"> 
                    <div class="row">
                       <div class="profile-picture" style="float: left;">
                            {!! HTML::image(config('global.uploadPath').$user->image, 'alt', array('class'=>'img-circle m-b', 'width'=>'120', 'height'=>'120')) !!}
                        </div> 
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="col-sm-4 control-label"> Name :</label>
                            <div class="col-sm-8">{{$user->name}}</div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="" class="col-sm-4 control-label"> Email ID :</label>
                            <div class="col-sm-8">{{$user->email}}</div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="" class="col-sm-4 control-label">Contact Number :</label>
                            <div class="col-sm-8">{{$userInfo->phone}}</div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="" class="col-sm-4 control-label">Country :</label>
                            <div class="col-sm-8">{{$country->name}}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="col-sm-4 control-label">Address Line 1 :</label>
                            <div class="col-sm-8">{{$userInfo->address1}}</div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="" class="col-sm-4 control-label">Address Line 2 :</label>
                            <div class="col-sm-8">{{$userInfo->address2}}</div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="" class="col-sm-4 control-label">State :</label>
                            <div class="col-sm-8">{{$state->name}}</div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="" class="col-sm-4 control-label">City :</label>
                            <div class="col-sm-8">{{$city->name}}</div>
                        </div>
                        <br>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="_description" class="col-sm-2 control-label">Short Description :</label>
                            <div class="col-sm-10" style="float: left;">{{$user->notes}}</div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@push('css')
@endpush
@push('script')
@endpush
@endsection