<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Product;
use App\Model\Category;
use Crypt;
use Cookie;
use App\User;
use App\Model\UserInfo;
use Illuminate\Support\Facades\Input;
use Auth;
use DB;
use Validator;
use Session;
use Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $newCouponsSorted = Product::where('isdelete', '=', '0')->where('expire_on','>=',DB::raw('NOW()'))->orderBy('created_at')->limit(6)->get();


        $newCoupons = $newCouponsSorted->shuffle();

        /*$popularProduct=DB::select('SELECT `product_images`.`image` as img , `product_images`.`default_image` , temp.*  FROM (SELECT `orders`.`pro_id_fk`, sum(`orders`.`quantity`) AS total,`products`.* FROM `orders` INNER JOIN `products` ON `products`.`id` = `orders`.`pro_id_fk` WHERE `status` = "1" AND `products`.`expire_on` > NOW()  GROUP BY `pro_id_fk` ORDER BY total DESC LIMIT 3) as temp INNER JOIN `product_images` ON `product_images`.`pro_id_fk` = temp.`id` WHERE  `product_images`.`default_image` = "1"');*/

        $featureProduct=Product::where('featured','=','1')->where('expire_on','>=',DB::raw('NOW()'))->get();

        $categories = Category::where('id','!=','1')->get();
        //echo "<pre>"; print_r($categories);die;
        return view('home.index', compact('newCoupons','featureProduct','categories'));
    }

    public function searchCategory($name, $id)
    {
        $catID = Crypt::decrypt($id);
        $categories = Category::where('id','!=','1')->get();
        $products = Product::where('cat_id_fk','=',$catID)->where('expire_on','>=',DB::raw('NOW()'))->where('isdelete','=','0')->get();
        return view('home.searchCategory',compact('name','catID','categories','products'));
    }
    public function couponDetails($name, $id)
    {
        $pdID = Crypt::decrypt($id);
        $productDetails = Product::find($pdID);
        $catID=$productDetails->cat_id_fk;
        $relatedProducts = Product::where('cat_id_fk','=',$catID)->where('expire_on','>=',DB::raw('NOW()'))->where('id','<>',$pdID)->where('isdelete','=','0')->limit(4)->inRandomOrder()->get();
        return view('home.couponDetails',compact('productDetails','relatedProducts'));
    }
    public function searchProduct(Request $req)
    {
        $reqSearch = $req->searchItem;
        $searchedProducts = Product::where('expire_on','>=',DB::raw('NOW()'))->where('name', 'like', '%' . $reqSearch . '%')
                ->orWhere('tag', 'like', '%' . $reqSearch . '%')
                ->get();
        $categories = Category::where('id','!=','1')->get();
        return view('home.searchProduct', compact('categories','reqSearch','searchedProducts'));
        
    }

    
    public function myAccount(Request $req)
    {   
        $uID=Auth::user()->id;
        $user      = User::find($uID);
        $userInfo  = UserInfo::where('u_id_fk','=',$uID)->first();

        return view('home.myAccount',compact('userInfo'));
    }

    
    public function updateProfile(Request $req)
    {   

        /*$data=Input::all();
        print_r($data);die;*/
        $id     = Auth::user()->id;
        $name   = $req->name;
        $email  = $req->email;
        $phone  = $req->phone;
        $dob    = $req->dob;
        $gender = $req->gender;
        $rules = array(
            // 'file' => 'required|mimes:png,gif,jpeg,jpg',
            'id'     => 'required',
            'name'   => 'required',
            'phone'  => 'required',
            'email'  => 'required',
            'dob'    => 'required',
            'gender' => 'required',
        );
        $validator = Validator::make(array(
            'id'     => $id,
            'name'   => $name,
            'phone'  => $phone,
            'email'  => $email,
            'dob'    => $dob,
            'gender' => $gender,
        ), $rules);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        } else{
            $uID       = $id;
            $userUpdate = User::where('id','=',$uID)->update([
                'name'  => $name,
                'email' => $email,
                ]);

            $userInfoUpdate = UserInfo::where('u_id_fk','=', $uID)->update([
                'name'  => $name,
                'email' => $email,
                'phone' => $phone,
                'dob' => $dob,
                'gender' => $gender,
                ]);
            Session::flash('message1', 'Profile update successfull.');
            return redirect()->back();
        }
        
    }

    public function emailcheck(){
        $email = Input::get('email');
        //print_r($email);exit;
        $checkEmail = User::where('email','=',$email)->first();
        if(count($checkEmail) == 1){
            echo json_encode(array('status'=>0,'message' => 'Mail already exist'),true);
        } else{
            echo json_encode(array('status'=>1),true);
        }
    }

    public function updateUserPassword(Request $request)
    {
        $newPassword = $request->newPassword;
        $currentPassword = Auth::User()->password;
        if(Hash::check($request->currentPassword, $currentPassword)){
            $user_id = Auth::User()->id;                       
            $obj_user = User::find($user_id);
            $obj_user->password = Hash::make($newPassword);
            $obj_user->save();

            $userUpdate = User::where('id','=',$user_id)->update(['showPassword'=>$newPassword]);
            Session::flash('message2', 'Password Changes Successfully');
        } else {
            Session::flash('message2', 'Current Password does not matched');
        }
        return back();        
    }

    /******************************** static pages ****************************/

    public function contact_us()
    {   
        return view('home.contact');
    }

    public function about_us()
    {   
        return view('home.about_us');
    }

    public function termsConditions()
    {   
        return view('home.termsConditions');
    }

    public function howItWorkes()
    {   
        return view('home.howItWorkes');
    }
    /**************************************************************************/

}
