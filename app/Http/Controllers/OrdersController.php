<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use \App\Model\UserInfo;
use \App\Model\Orders;
use \App\Model\Transactions;
use \App\Model\Bucket;
use \App\Model\Product;
use \App\Model\Redeems;
use Crypt;
use Session;
use Auth;
use Cookie;
use Mail;
use DB;
use Hash;
use Helper;
use Validator;

class OrdersController extends Controller
{
    //
    public function chartOrders()
    {
    	$live  = array('menu'=>'41','parent'=>'5');
    	$orders = Orders::all();
    	return view('admin.chartOrders', compact('live','orders'));
    	
    }

    public function chartTransactions()
    {
    	$live  = array('menu'=>'42','parent'=>'5');
    	$transactions = Transactions::all();
    	return view('admin.chartTransactions', compact('live','transactions'));
    }

    public function addToCart($id, $quantity=1)
    {
        $proID = Crypt::decrypt($id);
        $productDetails = Product::find($proID);

        if (Auth::check()) {
            $uID = Auth::id();
            $checkBucket = Bucket::where('u_id_fk','=',$uID)->where('pro_id_fk','=',$proID)->first();
            if (count($checkBucket) == 0) {
                $addBucket               = new Bucket;
                $addBucket->pro_id_fk    = $proID;
                $addBucket->u_id_fk      = Auth::id();
                $addBucket->quantity     = $quantity;
                $addBucket->buying_price = $productDetails->saling_price;
                $addBucket->save();

                $message = json_encode(array('type'=>'success','message'=>'Added to Cart'));
            }
            else{
                $updateBucket = Bucket::where('pro_id_fk','=',$proID)->where('u_id_fk','=',$uID)->update([
                'quantity' => $checkBucket->quantity + $quantity
                ]);
                $message = json_encode(array('type'=>'success','message'=>'Quantity upgraded to cart'));
            }
            
        } else{
            $bag = array();
            if (Cookie::get('bucket') !== null) {
                $cookieBag = json_decode(Cookie::get('bucket'));
                $bag = (array)$cookieBag;
                
            }
            if(!in_array($proID, array_keys($bag))){
                $bag[$proID] = $quantity;
                $bag = json_encode($bag);
                Cookie::queue('bucket', $bag, 1440);
                $message = json_encode(array('type'=>'success','message'=>'Added to Cart'));

            } else{
                $cookieBag = json_decode(Cookie::get('bucket'),true);
                $bucketProducts=(array)$cookieBag;
                $bucketProducts[$proID] = $bucketProducts[$proID] + $quantity;
                $bucketProducts = json_encode($bucketProducts);
                Cookie::queue('bucket', $bucketProducts, 1440);
                $message = json_encode(array('type'=>'success','message'=>'Quantity upgraded to cart'));
            }
        }
        return $message;
    }

    public function cartValue()
    {
        if (Auth::check()) {
            $uId = Auth::id();
            $checkBucket = Bucket::where('u_id_fk','=',$uId)->get();
            $countBucket = count($checkBucket);

        } else{
            if (Cookie::get('bucket') !== null) {
                $cookieBag = json_decode(Cookie::get('bucket'),true);
                $countBucket = count($cookieBag);
            } else{
                $countBucket = 0;
            }

        }
        return $countBucket;
    }
    public function cartSync()
    {
        if (Cookie::get('bucket') !== null) {
            $cookieBag = json_decode(Cookie::get('bucket'), true);
            $uID = Auth::id();
            foreach ($cookieBag as $key => $item) {
                $checkBucket = Bucket::where('u_id_fk','=',$uID)->where('pro_id_fk','=',$key)->get();
                if (count($checkBucket) == 0) {
                    $productDetails = Product::find($key);
                    $addBucket               = new Bucket;
                    $addBucket->pro_id_fk    = $key;
                    $addBucket->u_id_fk      = Auth::id();
                    $addBucket->quantity     = $item;
                    $addBucket->buying_price = $productDetails->saling_price;
                    $addBucket->save();
                }
            }
            Cookie::queue('bucket', null, 1440);
            $cookieBag = json_decode(Cookie::get('bucket'), true);
            return $cookieBag;
        }
    }
    public function myCart()
    {
        // if (Auth::check()) {
        //     $uId = Auth::id();
        //     $bucketItems = Bucket::where('u_id_fk','=',$uId)->get();
        //     if (count($bucketItems) != 0) {
        //         foreach ($bucketItems as $key => $value) {
        //            $bucketProducts[$value->pro_id_fk]=$value->quantity;
        //         }
        //        /* $bucketProducts = $bucketItems->pluck('pro_id_fk')->toArray();*/

        //         $productDetails = Product::whereIn('products.id',array_keys($bucketProducts))->join('buckets','products.id','=','buckets.pro_id_fk')->select('products.*','buckets.quantity as cartQuantity','buckets.id as bucketID')->get();
        //     } else{
        //         $bucketProducts = [];
        //         $bucketProducts=(array)$bucketProducts;
        //         $productDetails = Product::whereIn('id',$bucketProducts)->get();
        //     }
            
        // } else{
        //     if (Cookie::get('bucket') !== null) {
        //         $bucketProducts = (array)json_decode(Cookie::get('bucket'), true);
        //         $productDetails = Product::whereIn('id',array_keys($bucketProducts))->get();


        //     } else{
        //         $bucketProducts = [];
        //         $bucketProducts=(array)$bucketProducts;
        //         $productDetails = Product::whereIn('id',$bucketProducts)->get();

        //     }
        // }

        $cartInformations = self::cartInformation();
        $bucketProducts = $cartInformations['bucketProducts'];
        $productDetails = $cartInformations['productDetails'];

        // echo "<pre>";
        // print_r($bucketProducts);
        // exit;
        return view('home.myCart', compact('productDetails','bucketProducts'));
    }

    public function updateCartQuantity(Request $req)
    {
        $qty = $req->quantity;
        $pdID = $req->proID;

        if (Auth::check()) {
            $uID = Auth::id();
            $updateBucket = Bucket::where('pro_id_fk','=',$pdID)->where('u_id_fk','=',$uID)->update([
                'quantity' => $qty
                ]);
            $message = json_encode(array('type'=>'success','message'=>'Cart Updated'));
            
        } else{
            $cookieBag = json_decode(Cookie::get('bucket'),true);
            $bucketProducts=(array)$cookieBag;
            $bucketProducts[$pdID] = $qty;
            $bucketProducts = json_encode($bucketProducts);
            // echo $bucketProducts;
            Cookie::queue('bucket', $bucketProducts, 1440);
            $message = json_encode(array('type'=>'success','message'=>'Cart Updated'));

        }
        return $message;

    }

    public function deleteProductFromCart(Request $req)
    {
        $pdID = Crypt::decrypt($req->proID);
        if (Auth::check()) {
            $uID = Auth::id();
            $updateBucket = Bucket::where('pro_id_fk','=',$pdID)->where('u_id_fk','=',$uID)->delete();
            $message = json_encode(array('type'=>'success','message'=>'Cart Updated'));

        } else{
            $cookieBag = json_decode(Cookie::get('bucket'),true);
            $bucketProducts=(array)$cookieBag;
            // print_r($bucketProducts);
            // exit;
            unset($bucketProducts[$pdID]);
            $bucketProducts = json_encode($bucketProducts);
            Cookie::queue('bucket', $bucketProducts, 1440);
            $message = json_encode(array('type'=>'success','message'=>'Cart Updated'));
        }
        return $message;
    }

    public function checkout()
    {
        if (Auth::check()) {
            $cartSync = self::cartSync();
            # code...
        }
        $cartInformations = self::cartInformation();
        $bucketProducts = $cartInformations['bucketProducts'];
        $productDetails = $cartInformations['productDetails'];
        
        $totalPrice = 0;
        foreach ($productDetails as $product) {
            $totalPrice += $product->saling_price * $bucketProducts[$product->id];
        } 

        $countries = DB::table('countries')->get();
        $itemQuantity = array_sum($bucketProducts);

        return view('home.checkout', compact('productDetails','bucketProducts','itemQuantity','totalPrice','countries'));
        
    }

    public function cartInformation()
    {
        if (Auth::check()) {
            $uId = Auth::id();
            $bucketItems = Bucket::where('u_id_fk','=',$uId)->get();
            // echo count($bucketItems);
            // exit;
            if (count($bucketItems) != 0) {
                foreach ($bucketItems as $key => $value) {
                   $bucketProducts[$value->pro_id_fk]=$value->quantity;
                }

                // print_r($bucketProducts);
                // exit;
               /* $bucketProducts = $bucketItems->pluck('pro_id_fk')->toArray();*/

                $productDetails = Product::whereIn('products.id',array_keys($bucketProducts))->join('buckets','products.id','=','buckets.pro_id_fk')->select('products.*','buckets.quantity as cartQuantity','buckets.id as bucketID')->where('buckets.u_id_fk','=',$uId)->get();
                // echo $productDetails;
                // print_r($productDetails);
                // exit;
            } else{
                $bucketProducts = [];
                $bucketProducts=(array)$bucketProducts;
                $productDetails = Product::whereIn('id',$bucketProducts)->get();
            }
            
        } else if (Cookie::get('bucket') !== null) {
                $bucketProducts = (array)json_decode(Cookie::get('bucket'), true);
                $productDetails = Product::whereIn('id',array_keys($bucketProducts))->get();


        } else {
                $bucketProducts = [];
                $bucketProducts=(array)$bucketProducts;
                $productDetails = Product::whereIn('id',$bucketProducts)->get();

        }

        $cartValues = ['productDetails'=> $productDetails, 'bucketProducts'=>$bucketProducts];

        return $cartValues;
    }

    public function placeOrder(Request $req)
    {
        # code...
        $fetchCountry = DB::table('countries')->where('id','=',$req->country)->first();
        $email       = $req->email;
        $fname        = $req->fname;
        $lname        = $req->lname;
        $address1    = $req->address1;
        $address2    = $req->address2;
        $country     = $fetchCountry->id;
        $city        = $req->city;
        $countryCode = $req->countryCode;
        $phone       = $req->phone;
        $postal_code = $req->postal_code;
        $cardNumber      = $req->cardNumber;
        $expire_on_month = $req->expire_on_month;
        $expire_on_year  = $req->expire_on_year;
        $cardName        = $req->cardName;
        $cvv             = $req->cvv;

        $rules = array(
            'fname'        => 'required',
            'lname'        => 'required',
            'phone'       => 'required',
            'email'       => 'required',
            'address1'    => 'required',
            'country'     => 'required',
            'city'       => 'required',
            'countryCode' => 'required',
            'postal_code' => 'required',
            'cardNumber' => 'required',
            'expire_on_month' => 'required',
            'expire_on_year' => 'required',
            'cardName' => 'required',
            'cvv' => 'required',
        );
        $validator = Validator::make(array(
            'fname'        => $fname,
            'lname'        => $lname,
            'email'       => $email,
            'phone'       => $phone,
            'address1'    => $address1,
            'country'     => $country,
            'city'       => $city,
            'countryCode' => $countryCode,
            'postal_code' => $postal_code,
            'cardNumber' => $cardNumber,
            'expire_on_month' => $expire_on_month,
            'expire_on_year' => $expire_on_year,
            'cardName' => $cardName,
            'cvv' => $cvv,
            ), $rules);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        } else{

            $name = $fname.' '.$lname;


            if (!Auth::check()) {

            	$authcheck = 0;
                
                $deliveryType = $req->deliveryType;

                $users = User::where('email','=',$email)->first();
                if (count($users) != 0) {
                    if (Auth::attempt(['email' => $email, 'password' => $users->showPassword])) {
                        $userInfo = UserInfo::where('u_id_fk','=', Auth::id())->where('default_address_flag','=', 1)->first();

                        $userInfo->phone                = $phone;
                        $userInfo->address1             = $address1;
                        $userInfo->address2             = $address2;
                        $userInfo->postal_code          = $postal_code;
                        $userInfo->city                 = $city;
                        $userInfo->country              = $country;
                        $userInfo->save();


                    }
                    // Session::flash('message', 'Email already exists. Please try another email ID');
                    // return redirect()->back();
                    // exit;

                } else{
                    $password = rand(100000, 999999);
                    $user               = new User;
                    $user->name         = $name;
                    $user->email        = $email;
                    $user->u_role       = 'U';
                    $user->password     = Hash::make($password);
                    $user->showPassword = $password;
                    $user->save();

                    $last_insert_id                 = $user->id;
                    $userInfo                       = new UserInfo;
                    $userInfo->u_id_fk              = $last_insert_id;
                    $userInfo->email                = $email;
                    $userInfo->name                 = $name;
                    $userInfo->phone                = $phone;
                    $userInfo->address1             = $address1;
                    $userInfo->address2             = $address2;
                    $userInfo->postal_code          = $postal_code;
                    $userInfo->city                 = $city;
                    $userInfo->country              = $country;
                    $userInfo->default_address_flag = 1;
                    $userInfo->save();

                    if (Auth::attempt(['email' => $email, 'password' => $password])) {
                        // // Mail send to user of coupon code
                        // $data = [
                        //  'name'     => $name,
                        //  'view'     => 'emails.generateCouponMailToUser',
                        //  'to'       => $email,
                        //  'subject'  => 'Your New Purchased Coupon Code',
                        //  'password' => $password,
                        // ];

                        // Mail::send($data['view'], $data, function($message) use ($data){
                        //     $message->to($data['to'], $data['name'])->subject($data['subject']);
                        // });

                    } else{
                        // echo "wrong";
                        return redirect()->back();
                    }
                }
            } else{
            	$authcheck = 1;
                $user = User::find(Auth::id());
                $userInfo = UserInfo::where('u_id_fk','=', Auth::id())->where('default_address_flag','=', 1)->first();

                $userInfo->phone                = $phone;
                $userInfo->address1             = $address1;
                $userInfo->address2             = $address2;
                $userInfo->postal_code          = $postal_code;
                $userInfo->city                 = $city;
                $userInfo->country              = $country;
                $userInfo->save();
                $deliveryType = $user->deliveryType;
            }


            $uId              = Auth::id();
            $uBillingAddress  = $address1.', '.$address2.', '.$city.', '.$fetchCountry->name.', '.$postal_code.', '.$countryCode.$phone;;
            $uShippingAddress = $address1.', '.$address2.', '.$city.', '.$fetchCountry->name.', '.$postal_code.', '.$countryCode.$phone;;

            $cartSync = self::cartSync();

            // exit;
            
            $cartInformations = self::cartInformation();
            $bucketProducts   = $cartInformations['bucketProducts'];
            $productDetails   = $cartInformations['productDetails'];
            
            $totalPrice       = 0;
            foreach ($productDetails as $product) {
                $totalPrice += $product->saling_price * $bucketProducts[$product->id];
            } 

            $transactionCode                   = 'TRA'.rand(100000,999999);
            
            // Transaction generate
            $newTransactions                   = new Transactions;
            $newTransactions->trans_code       = $transactionCode;
            $newTransactions->u_id_fk          = $uId;
            $newTransactions->amount           = $totalPrice;
            $newTransactions->coupon_code      = '00000';
            $newTransactions->delivery_charges = 0;
            $newTransactions->method           = 'COD';
            $newTransactions->status           = 'COMPLETE';
            $newTransactions->save();
            
            $transactionsID                    = $newTransactions->id;

            $couponArray = array();
            $orderArray = array();
            if (Transactions::where('trans_code', '=', $transactionCode)->exists()) {
                foreach ($productDetails as $product) {
                    // $totalPrice += $product->saling_price * $bucketProducts[$product->id];
                    $invoicePath                 = rand(100000,999999).'.pdf';

                    // New Order Generate
                    $newOreder                   = new Orders;
                    $newOreder->pro_id_fk        = $product->id;
                    $newOreder->u_id_fk          = $uId;
                    $newOreder->trans_id_fk      = $transactionsID;
                    $newOreder->billing_address  = $uBillingAddress;
                    $newOreder->shipping_address = $uShippingAddress;
                    $newOreder->amount           = $product->saling_price;
                    $newOreder->quantity         = $bucketProducts[$product->id];
                    $newOreder->total_price      = $product->saling_price * $bucketProducts[$product->id];
                    $newOreder->invoice_path     = $invoicePath;
                    $newOreder->status           = 1; 
                    $newOreder->save();

                    $orderID = $newOreder->id;

                    $orderArray[]=$orderID;

                    if (Orders::where('id', '=', $orderID)->exists()) {
                        for ($i=0; $i < $bucketProducts[$product->id]; $i++) { 
                            $newCouponCode = 'COP'.rand(1000,9999).time();

                            // Coupon Record Generate
                            $newRedeem = new Redeems;
                            $newRedeem->pro_id_fk = $product->id;
                            $newRedeem->o_id_fk = $orderID;
                            $newRedeem->u_id_fk = $uId;
                            $newRedeem->coupon_code = $newCouponCode;
                            $newRedeem->save();

                            $productName = $product->name;
                            $expireOn = $product->expire_on;
                            $companyName = $product->getUser->name;
                            $phoneSMS = $countryCode.$phone;
                            $text = 'Your purchased KUWPON code '.$productName.' for '.$companyName.' is '.$newCouponCode.' valid till '.date('Y-m-d',strtotime($expireOn));
                            // $text = 'Special offer for you only, PUJA DHAMAKA '.$productName.' from '.$companyName.' use this coupon code '.$newCouponCode.' valid till '.$expireOn;


                            if ($deliveryType == 'S') {
                                $sendSMS = Helper::sendSMS($phoneSMS, $text);
                            }

                            $couponDetails = array(
                                'code'        =>$newCouponCode,
                                'expireOn'    =>date('Y-m-d',strtotime($expireOn)),
                                'productName' =>$productName,
                                'companyName' =>$companyName,
                                );

                            array_push($couponArray, $couponDetails);

                            $data = [
                             'name'     => $product->getUser->name,
                             'view'     => 'emails.generateCouponMailToVendor',
                             // 'to'       => 'sumita.cantripsolutions@gmail.com',
                             'to'       => $product->getUser->email,
                             'subject'  => 'Your one coupon sold',
                             'buyer' => Auth::user()->email,
                             'couponName' => $productName
                            ];
                            
                            $sendMail = Helper::sendMail($data); 
                        }

                        // Delete Record from Bucket
                        $updateBucket = Bucket::where('pro_id_fk','=',$product->id)->where('u_id_fk','=',$uId)->delete();

                        $productInfo = Product::find($product->id);

                        $updateProduct = Product::where('id','=',$product->id)->update([
                            'quantity' => $productInfo->quantity - $bucketProducts[$product->id],
                            ]);

                        
                    }

                    // // Mail to Vendor
                    // $vendorDetails = Product::with('getUser')->where()
                    // print_r($product->getUser);
                    // exit;
                    // $data = [
                    //  'name'     => $product->getUser->name,
                    //  'view'     => 'emails.generateCouponMailToUser',
                    //  // 'to'       => 'sumita.cantripsolutions@gmail.com',
                    //  'to'       => $product->getUser->email,
                    //  'subject'  => 'Order status of Kuwpon Code',
                    //  'couponArray' => $couponArray
                    // ];
                    
                    // $sendMail = Helper::sendMail($data);  

                }

                // Mail send to user of coupon code
                $data = [
                 'name'     => $name,
                 'view'     => 'emails.generateCouponMailToUser',
                 // 'to'       => 'sumita.cantripsolutions@gmail.com',
                 'to'       => $email,
                 'subject'  => 'Order status of Kuwpon Code',
                 'couponArray' => $couponArray
                ];
                
                if ($deliveryType == 'M') { 
                    $sendMail = Helper::sendMail($data);
                    // Mail::send($data['view'], $data, function($message) use ($data){
                    //     $message->to($data['to'], $data['name'])->subject($data['subject']);
                    // });                
                }


                
                // check for failures
                // if (Mail::failures()) {
                    // return response showing failed emails
                // } else{
                $orderupdate = Orders::where('trans_id_fk','=',$transactionsID)->update(['status'=>'1']);
                // }
                // if ($req->sms_service == 'sms') {
                //     # code...
                //     $couponsSMS = implode(',', $couponArray);
                //     $phoneSMS = $countryCode.$phone;
                //     $sendSMS = Helper::sendSMS($phoneSMS, $couponsSMS);
                // }

                if($orderupdate){
                    Session::flash('messageThankYou',array('type'=>'success','message'=>'Thank you for your purchase. Please check your phone or email for your kuwpon codes!',true));
                }else{
                    Session::flash('messageThankYou',array('type'=>'error','message'=>'Checkout proccess not successfull',true));
                }

            	Cookie::queue('bucket', null, 1440);

            	if ($authcheck == 0) {
            		Auth::logout();
            	}

                // if ($deliveryType == 'S') {
                // 	return redirect('/');
                // } else{
                // 	return redirect('orderHistory');
                // }
                Session::flash('orderArray',$orderArray);
                return redirect('thankyou');

            } else{
                // $message = json_encode(array('type'=>'success','message'=>'Quantity upgraded to cart'));
                return redirect()->back();
            }
        }
    }

    public function thankyou(){

        if(Session::has('orderArray')){
            $orderArray=Session::get('orderArray');
            $orderArray=array_values($orderArray);
            $orderHistory=Orders::whereIn('id',$orderArray)->get();
            Session::forget('orderArray');
            $thankyou_msg=Session::get('messageThankYou');

            return view('home.thankyou', compact('orderHistory','thankyou_msg'));
        }else{
            return redirect('/');
        }
    }

    public function orderHistory()
    {
        $uId=Auth::user()->id;
        $orderHistory=Orders::join('transactions','transactions.id','=','orders.trans_id_fk')
                            ->select('orders.*','transactions.trans_code as transactionscode')
                            ->with('getProductsInfo','getCoupons','getRedeemedCoupons','getNotRedeemedCoupons')
                            ->where('orders.u_id_fk' , '=',$uId)
                            ->where('orders.status','=','1')
                            ->get();

       /* echo "<pre>";print_r($orderHistory);echo "</pre>";*/
        return view('home.orderHistory', compact('orderHistory'));
    }

    
}
