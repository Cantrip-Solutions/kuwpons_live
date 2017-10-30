@extends('layouts.apps')
@section('content')

<div class="small-header transition animated fadeIn">
    <div class="hpanel">
        <div class="panel-body">
            <div class="pull-right" id="hbreadcrumb">
                <ol class="hbreadcrumb breadcrumb">
                    <li> Coupon Management </li>
                    <li> Coupon </li>
                    <li class="active">
                        <span> Edit Coupon </span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs"> Edit Coupon: {{$productInfo->name}} </h2>
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

                    {{Form::open(array('files'=>true,'id'=>'formdata','class'=>'form-horizontal','action' => 'ProductController@updateProduct', 'method'=>'POST', 'enctype'=>"multipart/form-data"))}}

                        <input class="form-control" type="hidden" name="id" id="id" value="{{Crypt::encrypt($productInfo->id)}}">

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Product Name*:</label>
                            <div class="col-sm-10">
                                {!! Form::text('name', $productInfo->name,array('placeholder'=>'Product Name','class'=>'form-control')) !!}
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="u_id_fk" class="col-sm-2 control-label">Company User*:</label>
                            <div class="col-sm-10">
                                <select class="js-source-states" name="u_id_fk" style="width: 100%">
                                    @foreach ($companyUsers as $company)
                                    @if($company->id == $productInfo->u_id_fk)
                                        <option value="{{$company->id}}" selected="selected">{{$company->name}}</option>
                                    @else
                                        <option value="{{$company->id}}">{{$company->name}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('u_id_fk'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('u_id_fk') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cat_id_fk" class="col-sm-2 control-label">Category*:</label>
                            <div class="col-sm-10">
                                <select class="js-source-states" name="cat_id_fk" style="width: 100%">
                                    @foreach ($categories as $category)
                                    @if($category->id == $productInfo->cat_id_fk)
                                        <option value="{{$category->id}}" selected="selected">{{$category->cat_name}}</option>
                                    @else
                                        <option value="{{$category->id}}">{{$category->cat_name}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('cat_id_fk'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cat_id_fk') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="original_price" class="col-sm-2 control-label">Original Price*:</label>
                            <div class="col-sm-10">
                                <div class="input-group m-b">
                                <span class="input-group-addon">KD</span>
                                {!! Form::number('original_price', $productInfo->original_price,array('placeholder'=>'Original Price','class'=>'form-control')) !!}
                                </div>
                                @if ($errors->has('original_price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('original_price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="discounted_price" class="col-sm-2 control-label">Discounted Price*:</label>
                            <div class="col-sm-10">
                                <div class="input-group m-b">
                                <span class="input-group-addon">KD</span>
                                {!! Form::number('discounted_price', $productInfo->discounted_price,array('placeholder'=>'Selling Price','class'=>'form-control')) !!}
                                </div>
                                @if ($errors->has('discounted_price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('discounted_price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="saling_price" class="col-sm-2 control-label">Kuwpon Price*:</label>
                            <div class="col-sm-10">
                                <div class="input-group m-b">
                                <span class="input-group-addon">KD</span>
                                {!! Form::number('saling_price', $productInfo->saling_price,array('placeholder'=>'Kuwpon Price','class'=>'form-control')) !!}
                                </div>
                                @if ($errors->has('saling_price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('saling_price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="quantity" class="col-sm-2 control-label">Stock Adjustment*:</label>
                            <div class="col-sm-10">
                                {!! Form::number('quantity', $productInfo->quantity,array('placeholder'=>'Quantity','class'=>'form-control','min'=>1)) !!}
                                @if ($errors->has('quantity'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('quantity') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- <div class="form-group">
                            <label for="quantity" class="col-sm-2 control-label">Quantity*:</label>
                            <div class="col-sm-10">
                                {!! Form::number('quantity', $productInfo->quantity,array('placeholder'=>'Quantity','class'=>'form-control')) !!}
                                @if ($errors->has('quantity'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('quantity') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> --}}

                        <div class="form-group">
                            <label for="expire_on" class="col-sm-2 control-label">Expire Date*:</label>
                            <div class="col-sm-10">
                            
                                 <div class="input-group date">
                                    <input type="text" name="expire_on" value="{{ date('Y-m-d',strtotime($productInfo->expire_on)) }}" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                </div>
                                @if ($errors->has('expire_on'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('expire_on') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="image" class="col-sm-2 control-label">Product Image*:</label>
                            <div class="col-sm-10">
                                {!! Form::file('image',array('class'=>'btn-primary2')) !!}
                                @if ($errors->has('image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tag" class="col-sm-2 control-label">Tag *:</label>
                            <div class="col-sm-10">
                                {{ Form::text('tag',$productInfo->tag,array('placeholder'=>'Men, Women','class'=>'form-control','data-role'=>"tagsinput")) }}
                                @if ($errors->has('tag'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tag') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="shortDescription" class="col-sm-2 control-label">Short Description :</label>
                            <div class="col-sm-10">
                                {{ Form::textarea('shortDescription',$productInfo->shortDescription,array('class'=>'form-control shortDescription','size' => '30x4','maxlength'=>'330')) }}
                                <span style="color:red;">Note: You can enter maximum <span class="count">{{ strlen($productInfo->shortDescription) }} </span>/330 Characters</span>
                                @if ($errors->has('shortDescription'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('shortDescription') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">All you need to know :</label>
                            <div class="col-sm-10">
                                {{ Form::textarea('description',$productInfo->description,array('id'=>"description", 'name'=>"description",'class'=>'form-control summernote1','size' => '30x5')) }}
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
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
            </div>
        </div>
    </div>
</div>
@push('css')
    {!!HTML::style('public/admintheme/styles/static_custom.css')!!}
    {!!HTML::style('public/admintheme/vendor/select2-3.5.2/select2.css')!!}
    {!!HTML::style('public/admintheme/vendor/select2-bootstrap/select2-bootstrap.css')!!}
    {!!HTML::style('https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.7/summernote.css')!!}
    <!-- {!!HTML::style('public/admintheme/vendor/summernote/dist/summernote-bs3.css')!!} -->
    {!!HTML::style('public/admintheme/vendor/bootstrap-datepicker-master/dist/css/bootstrap-datepicker3.min.css')!!}
    {!!HTML::style('public/css/bootstrap-tagsinput.css')!!}
   
@endpush
@push('scripts')
{!! HTML::script('public/plugins/jquery-validation-1.15.0/dist/jquery.validate.min.js') !!}
{!! HTML::script('public/plugins/jquery-validation-1.15.0/dist/additional-methods.min.js') !!}
{!! HTML::script('public/admintheme/vendor/select2-3.5.2/select2.min.js') !!}
{!! HTML::script('https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.min.js') !!}
{!! HTML::script('public/admintheme/vendor/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js') !!}
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
        'name': {
            required: true
        },
        'u_id_fk': {
            required: true
        },
        'cat_id_fk': {
            required: true
        },
        'ammount': {
            required: true,
            number:true
        },
        'original_price': {
            required: true
        },
        'discounted_price': {
            required: true
        },
        'saling_price': {
            required: true
        },
        'quantity': {
            required: true,
            number:true
        },
        'tag': {
            required: true
        },
        'expire_on': {
            required: true
        },
        'image': {
            extension: "PNG|JPEG|JPG"
        },
        'description': {
            required: true
        },
        'shortDescription': {
            required: true
        },
      }
    });
    $(".js-source-states").select2();
    $('.input-group.date').datepicker({ 
        // setDate: new Date(),
        format: 'yyyy-mm-dd',
        startDate: new Date(),
    });

   $('#description').summernote({
       height: 150,
       fontNames: ["Roboto","Arial", "Arial Black", "Comic Sans MS", "Courier New",
                             "Helvetica Neue", "Helvetica", "Impact", "Lucida Grande",
                             "Tahoma", "Times New Roman", "Verdana"],
      toolbar: [
        // [groupName, [list of button]]
        ["fontname", ["fontname"]],
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']]
      ]
    });

   $(".shortDescription").on('keyup', function() {
        var count=$(this).val();
        $('.count').text(count.length);
    });


});
</script>
@endpush
@endsection