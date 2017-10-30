<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use \App\Model\Product;

class DashboardController extends Controller
{
    public function gotoDashboard()
    {
    	$live = array('menu'=>'11','parent'=>'1');
    	if (Auth::user()->u_role == 'A') {
    		return view('admin.adminDashboard',compact('live'));	//Go to Super Admin Dashboard 
    	} else if(Auth::user()->u_role == 'S'){
			$products = Product::where('isdelete','=','0')->where('u_id_fk','=',Auth::id())->get();
    		return view('vendor.vendorDashboard',compact('live','products'));	//Go to Super Admin Dashboard 
    	}
    }
}
