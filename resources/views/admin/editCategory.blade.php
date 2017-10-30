@extends('layouts.apps')
@section('content')

<div class="small-header transition animated fadeIn">
    <div class="hpanel">
        <div class="panel-body">
            <div class="pull-right" id="hbreadcrumb">
                <ol class="hbreadcrumb breadcrumb">
                    <li> Product Management </li>
                    <li> Category </li>
                    <li class="active">
                        <span> Edit Category </span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs"> Edit Category </h2>
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

                    {{Form::open(array('files'=>true,'id'=>'formdata','class'=>'form-horizontal','action' => 'CategoryController@updateCategory', 'method'=>'POST', 'enctype'=>"multipart/form-data"))}}
                        {{ Form::hidden('id', $category->id) }}
                    @if(isset($subcategory) && $subcategory == 1)
                        <div class="form-group">
                            <label class="col-lg-6 control-label">Sub Category Edit of : {{ $parentCategory->cat_name }}</label>
                        </div>
                        {{ Form::hidden('parent_cat_id', $parentCategory->id) }}
                        {{ Form::hidden('subcategory',1 ) }}
                    @else
                        {{ Form::hidden('subcategory',0 ) }}
                    @endif
                        <div class="form-group">
                            <label for="company_name" class="col-sm-2 control-label">Category Name *:</label>
                            <div class="col-sm-10">
                                {!! Form::text('cat_name', $category['cat_name'],array('placeholder'=>'Category Name','class'=>'form-control')) !!}
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
                                {{ Form::hidden('old_cat_icon', $category['cat_icon']) }}
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
                                {{ Form::textarea('cat_description',$category['cat_description'],array('size' => '50x3','class'=>'form-control')) }}
                                @if ($errors->has('cat_description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cat_description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                                              


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
            extension: "PNG"
            
        }
      }
    });

});
</script>
@endpush
@endsection