<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Model\ProductDiscount;
use \App\Model\Coupons;
use \App\Helpers\Helper;
use Mail;
use View;

class OffersController extends Controller
{
 	public function productDiscount(){
 		
 		$live  = array('menu'=>'36','parent'=>'4');
 		$discounts = ProductDiscount::where('status','=','0')->get();
 		// $discountproduct = 
 		// if($discountproduct->module == 'C'){
 		// 	$discountproduct=ProductDiscount::join('categories','product_discounts.mid','=','categories.id')->select('product_discounts.*','categories.*')->get();
 		// }else{
 		// 	$discountproduct=ProductDiscount::join('products','product_discounts.mid','=','products.id')->select('product_discounts.*','products.*')->get();
 		// }
   //      //echo "<pre>"; print_r($categories);echo "</pre>";
    	return view('admin.chartDiscount', compact('live','discounts'));

 	}

 	public function chartCoupons()
 	{
 		$live  = array('menu'=>'38','parent'=>'4');
 		$coupons = Coupons::all();
    	return view('admin.chartCoupons', compact('live','coupons'));
 		
 	}
 	public function addCoupons()
 	{
 		$live  = array('menu'=>'38','parent'=>'4');
    	return view('admin.addCoupons', compact('live'));
 	}
 	public function createCoupon(Request $req)
 	{
 		
 	}

 	public function testMail()
 	{
 		// Mail send to user of coupon code
        $data = [
         'name'     => 'Sumita Das',
         'view'     => 'emails.testMail',
         'to'       => 'dipankar.cantripsolutions@gmail.com',
         'subject'  => 'Mail Pathalam',
        ];

        // $sendMail = Helper::sendMail($data);

        Mail::send($data['view'], $data, function($message) use ($data){
            $message->to($data['to'], $data['name'])->subject($data['subject']);
        });
        // $message = View::make($data['view']);
        // $headers = "From: Kuwpons no-reply@kuwpons.com\r\n";
        // $headers .= "Reply-to: support@kuwpons.com";
        // $headers .= "MIME-Version: 1.0\r\n";
        // $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        // if (mail($data['to'], $data['subject'], $message, $headers)) {
        //     echo "true";;
        // } else {
        //     echo "false";;
        // }

        // Mail::send($data['view'], $data, function($message) use ($data){
        //     $message->to($data['to'], $data['name'])->subject($data['subject']);
        // });
 	}
}
