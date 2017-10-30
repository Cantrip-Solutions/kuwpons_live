@extends('layouts.apps')
@section('content')

<div class="small-header transition animated fadeIn">
    <div class="hpanel">
        <div class="panel-body">
            <div class="pull-right" id="hbreadcrumb">
                <ol class="hbreadcrumb breadcrumb">
                    <li> Settings </li>
                    <li class="active">
                        <span> Menu Management </span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs"> Menu Management </h2>
        </div>
    </div>
</div>
<div class="content animate-panel">
    <div class="row">
        <div class="col-lg-12">

            <div class="hpanel">
                <div class="panel-body">

                </div>
            </div>
        </div>
    </div>
</div>
@push('css')
{!!HTML::style('public/admintheme/styles/static_custom.css')!!}
@endpush
@push('scripts')
{!! HTML::script('public/plugins/jquery-validation-1.15.0/dist/jquery.validate.min.js') !!}
{!! HTML::script('public/plugins/jquery-validation-1.15.0/dist/additional-methods.min.js') !!}
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
    $('.addAttr').on('click', function () {
        var att = $(this).attr('att');
        $('this').
    })
});
</script>
@endpush
@endsection