@extends('layouts.apps')
@section('content')

<div class="small-header transition animated fadeIn">
    <div class="hpanel">
        <div class="panel-body">
            <div class="pull-right" id="hbreadcrumb">
                <ol class="hbreadcrumb breadcrumb">
                    <li> Coupon Management </li>
                    <li> Category </li>
                    <li class="active">
                        <span> Add Category </span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs"> Add Category </h2>
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

                    {{Form::open(array('files'=>true,'id'=>'formdata','class'=>'form-horizontal','action' => 'CategoryController@createCategory', 'method'=>'POST', 'enctype'=>"multipart/form-data"))}}

                    @if(isset($subcategory))
                        <div class="form-group">
                            <label class="col-lg-6 control-label">Sub Category Add to : {{ $category->cat_name }}</label>
                        </div>
                        {{ Form::hidden('parent_cat_id', $category->id) }}
                        {{ Form::hidden('subcategory',1 ) }}
                    @else
                        {{ Form::hidden('subcategory',0 ) }}
                    @endif
                        <div class="form-group">
                            <label for="company_name" class="col-sm-2 control-label">Category Name *:</label>
                            <div class="col-sm-10">
                                {!! Form::text('cat_name', '',array('placeholder'=>'Category Name','class'=>'form-control')) !!}
                                @if ($errors->has('cat_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cat_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        
                        <div class="form-group">
                            <label for="cat_icon" class="col-sm-2 control-label">Category Image *:</label>
                            <div class="col-sm-10">
                                {!! Form::file('cat_icon') !!}
                                @if ($errors->has('cat_icon'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cat_icon') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>



                        <div class="form-group">
                            <label for="company_description" class="col-sm-2 control-label">Category Description :</label>
                            <div class="col-sm-10">
                                {{ Form::textarea('cat_description','',array('size' => '50x3','class'=>'form-control')) }}
                                @if ($errors->has('cat_description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cat_description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <label for="specifications" class="col-sm-2 control-label">Attributes :</label>
                            
                            <div class="col-sm-10">
                                <div class="other_attribute1 row" style="padding-bottom: 20px;" >
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="att[1][name]" placeholder="Name">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="att[1][value]" data-role="tagsinput" placeholder="Values"> 
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="javascript:void(0)" att='1' id="addAttr1" class="addAttr btn btn-info">Add</a>
                                    </div>
                                </div>

                            </div>
                        </div> -->
                       

                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-2">
                                <button type="submit" class="btn w-xs btn-success" name="submit">Submit</button>
                                <a class="btn w-xs btn-info" href="{{url('/tab/category')}}">Back</a>
                            </div>
                        </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
</div>
@push('css')
{!!HTML::style('public/admintheme/styles/static_custom.css')!!}
{!!HTML::style('public/css/bootstrap-tagsinput.css')!!}
<style type="text/css">

    .bootstrap-tagsinput{
        width: 100% !important;
    }

</style>
@endpush
@push('scripts')
{!! HTML::script('public/plugins/jquery-validation-1.15.0/dist/jquery.validate.min.js') !!}
{!! HTML::script('public/plugins/jquery-validation-1.15.0/dist/additional-methods.min.js') !!}
{!! HTML::script('public/js/bootstrap-tagsinput.min.js')!!}
<script type="text/javascript">
jQuery.validator.setDefaults({ 
    debug: false 
    //success: "valid" 
});
$(document).ready(function(){
    $('div.alert').delay(5000).slideUp(300);
    $("#formdata").validate({
      rules: {
        'cat_name': {
            required: true
        },
        'cat_icon': {
            required: true,
            extension: "PNG"
            
        }
      }
    });

   /* $('body').on('click','.addAttr',function(e){
        e.preventDefault()
        var attr=$(this).attr('att');
        var newattr=parseInt(attr)+1;

        var html='<div class="other_attribute'+newattr+' row" style="padding-bottom: 20px;" ><div class="col-sm-4"><input type="text" class="form-control" name="att['+newattr+'][name]" placeholder="Name"></div>'+
            '<div class="col-sm-4"><input type="text" class="form-control" name="att['+newattr+'][value]" data-role="tagsinput" placeholder="Values"></div><div class="col-sm-2"><a href="javascript:void(0)" id="addAttr'+newattr+'"  att="'+newattr+'" class="addAttr btn btn-info">Add</a></div></div>';
        $('.other_attribute'+attr).parent('div').append(html);
        $('input[data-role="tagsinput"]').tagsinput();
        $('#addAttr'+attr).parent('div').html('<a href="javascript:void(0)" att="'+newattr+'" class="removeAttr btn btn-info"><i class="fa fa-times"></i></a>');

    });

    $('body').on('click','.removeAttr',function(e){

        $(this).parent('div').parent('div').remove();
    });*/
});
</script>
@endpush
@endsection