<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Model\Specifications;
use \App\Model\Category;

class SpecificationController extends Controller
{
    //
    public function chartSpecification()
    {
    	$live = array('menu'=>'39','parent'=>'3');
    	$specifications = Specifications::all();
    	return view('admin.chartSpecification', compact('live','specifications'));
    	
    }
    // public function addSpecification()
    // {
    // 	$live = array('menu'=>'39','parent'=>'3');
    // 	$categories = Category::
    // 	return view('admin.addSpecification', compact('live'));
    // }
}
