@extends('layouts.apps')
@section('content')

<div class="small-header transition animated fadeIn">
    <div class="hpanel">
        <div class="panel-body">
            <div class="pull-right" id="hbreadcrumb">
                <ol class="hbreadcrumb breadcrumb">
                    <li> Product Management </li>
                    <li class="active">
                        <span> Category </span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs"> Category </h2>
        </div>
    </div>
</div>
<div class="content animate-panel">
    <div class="row">
        <div class="col-lg-12">

            <div class="hpanel">

                <div class="panel-body">
                    <p align="right">
                        {{link_to_route('addCategory', $title = 'Add Category', $parameters = array(), $attributes = array('type'=>'button', 'class'=>'btn w-xs btn-info'))}}
                    </p>                
                    @if (Session::has('message'))
                       <div class="alert alert-info"><i class="pe-7s-gleam"></i>{{ Session::get('message') }}</div>
                    @endif
                    <div class="dd" id="nestable2">
                        <ol class="dd-list">

                        @foreach ($categories as $key => $category)
                            <li class="dd-item" data-id="{{ $key }}">
                                @if($category['child'] == 0)
                                    <button data-action="collapse" type="button" style="display: block;">Collapse</button>
                                @endif
                                <div class="dd-handle sb-wrap clears">
                                <span>{{ $category['name'] }}</span>
                                </div>
                                <div class="sub-ct">
                                @if($key != 1)
                                   <!--  <a href="{{URL::to('tab/subcategory/add/'.$key)}}" cat_id="{{ $key }}" class="btn btn-xs btn-outline btn-info" >Add sub category</a> -->
                                    <a href="{{URL::to('tab/category/edit/'.urlencode(str_replace('/', '&#47;',$category['name'])).'/'.$key)}}" cat_id="{{ $key }}" class="edit_category"> <i class="fa fa-pencil-square-o"></i></a>
                                    <a href="javascript:void(0)" cat_id="{{ $key }}"  cat_name="{{ $category['name'] }}" class="delete_category"><i class="fa fa-trash"></i></a>
                                @endif
                               </div>

                                @if($category['child'] == 1)
                                    <ol class="dd-list" id="parent_cat_<?php echo $key; ?>"></ol>
                                @endif
                                
                            </li>
                        @endforeach
                            
                        </ol>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@push('css')
    {!!HTML::style('public/admintheme/styles/static_custom.css')!!}
    {!! HTML::style('public/plugins/jquery-loadmask-master/jquery.loadmask.css') !!}
@endpush
@push('scripts')
{!! HTML::script('public/plugins/jquery-loadmask-master/jquery.loadmask.min.js') !!}
<script>

$(document).ready(function()
{

    var updateOutput = function(e)
    {
        var list   = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };
   
    // activate Nestable for list 1
    $('#nestable2').nestable({
        group: 1,
        collapsedClass:'dd-collapsed',
   }).nestable('collapseAll')
    .on('change', updateOutput);

    // output initial serialised data
    updateOutput($('#nestable2').data('output', $('#nestable-output')));

    $('#nestable-menu').on('click', function(e)
    {   
        var target = $(e.target),
            action = target.data('action');
        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });
    var token ="{{ csrf_token() }}";
    var base_url="{{URL::to('/')}}";
    $('body').on('click' , "button[data-action='expand']", function(e){

        parent_cat_id=$(this).parents('li').attr('data-id');
        //alert(parent_cat_id);
        $.ajax({
            'type':'post',
            'url':"{{URL::to('getSubCategories')}}",
            'headers': {'X-CSRF-TOKEN': token},
            'data':{'parent_cat_id':parent_cat_id},
            'dataType':'json',
            //'beforeSend':function(){ $('.row').mask('Please Wait...'); },
            'success':function(resp){
                //console.log(resp);
                var html="";
                $.each( resp, function( key, value ) {

                    html +='<li class="dd-item" data-id="'+key+'">';
                    if(value.child == 1){
                        html +='<button data-action="collapse" type="button" style="display: none;">Collapse</button><button data-action="expand" type="button" style="display: block;">Expand</button>';
                    }
                    html +='<div class="dd-handle sb-wrap clears"><span>'+value.name+'</span></div><div class="sub-ct"><a href="'+base_url+'/tab/subcategory/add/'+key+'" cat_id="'+key+'" class="btn btn-xs btn-outline btn-info" >Add sub category</a><a href="'+base_url+'/tab/category/edit/'+value.name+'/'+key+'" cat_id="'+key+'" class="edit_category"> <i class="fa fa-pencil-square-o"></i></a><a href="javascript:void(0)" cat_id="'+key+'" cat_name="'+value.name+'" class="delete_category"><i class="fa fa-trash"></i></a></div>';

                        if(value.child == 1){
                            html +='<ol class="dd-list" id="parent_cat_'+key+'"></ol>';
                        }
                                
                                
                        html +='</li>';
                });
                

                $('#parent_cat_'+parent_cat_id).html(html);

                $('.row').unmask();
            }
        });
    });


    $('body').on('click' , ".delete_category", function(){
        // alert();
        var cat_name=$(this).attr("cat_name");
        var cat_id=$(this).attr("cat_id");
        var obj=$(this);
        bootbox.confirm("Are you sure to delete this category?", function(result) {
            if(result){
                $.ajax({
                    'type':'post',
                    'url':base_url+'/category/delete',
                    'headers': {'X-CSRF-TOKEN': token},
                    'data':{'cat_name':cat_name,'cat_id':cat_id},
                    'dataType':'json',
                    'success':function(resp){
                        
                        if(resp.status==1){
                            obj.parent('.sub-ct').parent('.dd-item').remove();
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