@extends('layouts.apps')
@section('content')

<div class="small-header transition animated fadeIn">
    <div class="hpanel">
        <div class="panel-body">
            <div class="pull-right" id="hbreadcrumb">
                <ol class="hbreadcrumb breadcrumb">
                    <li> Product Management </li>
                    <li> Image Gallery </li>
                    <li class="active">
                        <span> Image Gallery  </span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs"> Image Gallery of {{ $productInfo->name }} </h2>
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

                    {{Form::open(array('files'=>true,'id'=>'formdata','class'=>'form-horizontal','action' => 'ProductController@addToImageGallery', 'method'=>'POST', 'enctype'=>"multipart/form-data"))}}
                        <input type="hidden" name="pro_id_fk" value="{{ $productInfo->id }}">
                        <div class="form-group">
                            <label for="cat_icon" class="col-sm-2 control-label">Product Images *:</label>
                            <div class="col-sm-10">
                            <input type="file" name="productImage[]" multiple />
                                @if ($errors->has('productImage'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('productImage') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-2">
                                <button type="submit" class="btn w-xs btn-success" name="submit">Submit</button>
                                <a class="btn w-xs btn-info" href="{{url('/tab/product')}}">Back</a>
                            </div>
                        </div>

                    {{Form::close()}}

                </div>

                <div class="panel-body">
                    <div class="lightBoxGallery">
                        @foreach ($producrtimages as $key => $value)
                        <div class="thum-img">                 
                            <a href="{{ URL::to('/').'/'.config('global.productPath').'/'.$value->image }}" title="Image from Unsplash" data-gallery="">{!!HTML::image(config('global.productPath').'/'.$value->image, 'alt', array('width'=>'180', 'height'=>'180'))!!}</a>
                            @if($value->default_image != 1 )
	                            <div class="thum-img-croce">
	                            	<a class="text delete_image"  image_id="{{ $value->id }}" ><i class="fa fa-times"></i></a>
	                            </div>
                             @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- The Gallery as lightbox dialog, should be a child element of the document body -->
<div id="blueimp-gallery" class="blueimp-gallery">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>
@push('css')
{!!HTML::style('public/admintheme/styles/static_custom.css')!!}
{!!HTML::style('public/admintheme/vendor/blueimp-gallery/css/blueimp-gallery.min.css')!!}
<style type="text/css">
 
    .lightBoxGallery {
        text-align: center;

    }
    .lightBoxGallery a {
        margin: 5px;
        display: inline-block;
    }
    .thum-img {
        position: relative;
        display: inline-block;
    }


    .thum-img-croce {
		  position: absolute;
		  top: 0;
		  right: 0;
		  opacity: 0;
		  transition: .5s ease;
 }

 .container:hover .overlay {
  opacity: 1;
}

.text {
  color: #ccc;
  font-size: 20px;
  position: absolute;
  top: 0;
  right: 5px !important;
}
.text:hover {
	color: #f00;
}

 .thum-img:hover .thum-img-croce {
  opacity: 1;
}

</style>
@endpush
@push('scripts')
{!! HTML::script('public/plugins/jquery-validation-1.15.0/dist/jquery.validate.min.js') !!}
{!! HTML::script('public/plugins/jquery-validation-1.15.0/dist/additional-methods.min.js') !!}
{!!HTML::script('public/admintheme/vendor/blueimp-gallery/js/jquery.blueimp-gallery.min.js')!!}

<script type="text/javascript">
jQuery.validator.setDefaults({ 
    debug: false 
    //success: "valid" 
});
$(document).ready(function(){
	var base_url="{{URL::to('/')}}";
	 var token ="{{ csrf_token() }}";
    $('div.alert').delay(5000).slideUp(300);
    $("#formdata").validate({
      rules: {
        'productImage': {
            required: true,
            extension: "PNG|JPG|JPEG"
            
        }
      }
    });
    $('.delete_image').on('click', function(){
        var id = $(this).attr('image_id');
        var obj=$(this);
        bootbox.confirm("Are you sure to delete this Image?", function(result) {

            if (result == true) {

	            $.ajax({

	                'type':'post',
	                'url':base_url+'/tab/image/delete',
	                'headers': {'X-CSRF-TOKEN': token},
	                'data':{'id':id},
	                'dataType':'json',
	                'success':function(resp){
	                    
	                    if(resp.status==1){
	                        obj.parent('.thum-img-croce').parent('.thum-img').remove();
	                    }
	                }

	            });
	        }

        });
    });
});
</script>
@endpush
@endsection