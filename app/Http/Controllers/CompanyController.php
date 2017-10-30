<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use \App\Model\UserInfo;
use \App\Model\Product;
use \App\Model\Redeems;
use Validator;
use Hash;
use File;
use Illuminate\Support\Facades\Input;
use Mail;
use Session;
use DB;
use Crypt;
use Auth;

class CompanyController extends Controller
{
    //Display DataTables of Company List in Admin Panel
    public function chartCompany()
    {
		$live  = array('menu'=>'32','parent'=>'2');
		$users = User::where('u_role','=','S')->where('status','!=', '2')->get();
    	return view('admin.chartCompany', compact('live','users'));
    }
    // Add new company from Admin Panel
    public function addCompany(){
    	$live = array('menu'=>'32','parent'=>'2');
    	$countries = DB::table('countries')->get();
    	return view('admin.addCompany', compact('live','countries'));
    }

    public function createCompany(Request $req)
    {
		$name        = $req->name;
		$password    = $req->password;
		$notes       = $req->notes;
		$email       = $req->email;
		$phone       = $req->phone;
		$address1    = $req->address1;
		$country     = $req->country;
		$state       = $req->state;
		$postal_code = $req->postal_code;
		$rules = array(
			// 'file' => 'required|mimes:png,gif,jpeg,jpg',
			'name'        => 'required',
			'notes'       => 'required',
			'phone'       => 'required',
			'email'       => 'required',
			'address1'    => 'required',
			'country'     => 'required',
			'state'       => 'required',
			'postal_code' => 'required',
        );
        $validator = Validator::make(array(
			'name'        => $name,
			'notes'       => $notes,
			'email'       => $email,
			'phone'       => $phone,
			'address1'    => $address1,
			'country'     => $country,
			'state'       => $state,
			'postal_code' => $postal_code,
            ), $rules);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        } else{
        	if (User::where('email', '=', $email)->exists()) {
			   	Session::flash('message', 'Email already exists');
		        return redirect()->back();
		        exit;
			}
        	if (Input::hasfile('images')) {
        		// $password = rand (10000000,99999999);
        		$files   = Input::file('images');

				$user               = new User;
				$user->name         = $name;
				$user->notes        = $notes;
				$user->email        = $email;
				$user->u_role       = 'S';
				$user->password     = Hash::make($password);
				$user->showPassword = $password;
				$user->save();

				$last_insert_id = $user->id;
				$fileName       = 'COM'.$last_insert_id.rand().'.jpg';
				$target         = config('global.uploadPath');
				$uploadSuccess  = $files->move($target, $fileName);

				$userUpdate = User::where('id','=',$last_insert_id)->update(['image'=> $fileName]);

				$userInfo                       = new UserInfo;
				$userInfo->u_id_fk              = $last_insert_id;
				$userInfo->email                = $email;
				$userInfo->name                 = $name;
				$userInfo->phone                = $req->phone;
				$userInfo->address1             = $req->address1;
				$userInfo->address2             = $req->address2;
				$userInfo->postal_code          = $req->postal_code;
				$userInfo->city                 = $req->city;
				$userInfo->state                = $req->state;
				$userInfo->country              = $req->country;
				$userInfo->latitude             = '';
				$userInfo->longitude            = '';
				$userInfo->u_details            = '';
				$userInfo->default_address_flag = 1;
				$userInfo->save();


				// $data = [
				// 	'name'     => $name,
				// 	'view'     => 'emails.newCompanyRegistrationMail',
				// 	'to'       => $email,
				// 	'password' => $password,
				// 	'subject'  => 'Welcome to '.config('global.siteTitle'),
	   //          ];

				// Mail::send($data['view'], $data, function($message) use ($data){
		  //           $message->to($data['to'], $data['name'])->subject($data['subject']);
		  //       });

				Session::flash('message', 'Company Profile create successfull.');
		        return redirect('/tab/company/add');

        	}
        }
    }
    public function getState(Request $req)
    {
		$countryID = $req->country;
		$states    = DB::table('states')->where('country_id','=',$countryID)->get();
    	return response()->json($states);
    }
    public function getCity(Request $req)
    {
		$stateID = $req->state;
		$cities  = DB::table('cities')->where('state_id','=',$stateID)->get();
    	return response()->json($cities);
    }
    public function editCompany($name, $id)
    {
		$uID       = Crypt::decrypt($id);
		$live      = array('menu'=>'32','parent'=>'2');
		$countries = DB::table('countries')->get();
		$user      = User::find($uID);
		$userInfo  = UserInfo::where('u_id_fk','=',$uID)->first();
		$states    = DB::table('states')->where('country_id','=',$userInfo->country)->get();
		$cities    = DB::table('cities')->where('state_id','=',$userInfo->state)->get();
    	return view('admin.editCompany', compact('live','countries','user','userInfo','states','cities'));
    }
    public function updateCompany(Request $req)
    {
    	$id 		 = $req->id;
    	$name        = $req->name;
		$notes       = $req->notes;
		$email       = $req->email;
		$phone       = $req->phone;
		$address1    = $req->address1;
		$address2    = $req->address2;
		$country     = $req->country;
		$state       = $req->state;
		$city        = $req->city;
		$postal_code = $req->postal_code;
		$rules = array(
			// 'file' => 'required|mimes:png,gif,jpeg,jpg',
			'id'		  => 'required',
			'name'        => 'required',
			'notes'       => 'required',
			'phone'       => 'required',
			'email'       => 'required',
			'address1'    => 'required',
			'country'     => 'required',
			'state'       => 'required',
			'postal_code' => 'required',
        );
        $validator = Validator::make(array(
    		'id' 		  => $id,
			'name'        => $name,
			'notes'       => $notes,
			'email'       => $email,
			'phone'       => $phone,
			'address1'    => $address1,
			'country'     => $country,
			'state'       => $state,
			'postal_code' => $postal_code,
            ), $rules);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        } else{
			$uID       = Crypt::decrypt($id);
			$userUpdate = User::where('id','=',$uID)->update([
				'name'  => $name,
				'email' => $email,
				'notes' => $notes,
				]);

			// Password Change (optinal)
			$password = $req->password;
			if ($password != '') {
				$userUpdate = User::where('id','=',$uID)->update([
					'password' => Hash::make($password),
					'showPassword'=> $password,
				]);
			}

        	if (Input::hasfile('images')) {
        		$files   = Input::file('images');
				$fileName       = 'COM'.$uID.rand().'.jpg';
				$target         = config('global.uploadPath');
				$uploadSuccess  = $files->move($target, $fileName);
				$userUpdate = User::where('id','=',$uID)->update(['image'=> $fileName]);
			}

			$userInfoUpdate = UserInfo::where('u_id_fk','=', $uID)->update([
				'email'       => $email,
				'name'        => $name,
				'phone'       => $phone,
				'address1'    => $address1,
				'address2'    => $address2,
				'postal_code' => $postal_code,
				'city'        => $city,
				'state'       => $state,
				'country'     => $country,
				'latitude'    => '',
				'longitude'   => '',
				'u_details'   => '',
				]);
			Session::flash('message', 'Company Profile update successfull.');
		    return redirect()->back();
        }
    	
    }
    public function destroyCompany($id)
    {
		$uID = Crypt::decrypt($id);
		$userUpdate = User::where('id','=',$uID)->update(['status'=> '2']);
		$productUpdate = Product::where('u_id_fk','=',$uID)->update(['isdelete'=>'1']);
    	// $userDelete = User::find($uID);
    	// $userDelete->delete();
    	Session::flash('message', 'Company Profile suspended successfully.');
		return redirect()->back();
   //  	if (User::where('id', $uID)->exists()) {
			// Session::flash('message', 'Company Profile deleted successfully.');
		 //    return redirect()->back();

   //  		// return response()->json(array('status'=>'success', 'message'=>"<p style='color:green;'>User Id#".$uID." deleted Successfully</p>"));
   //      } else{
			// Session::flash('message', 'Error to delete Company Profile.');
		 //    return redirect()->back();
   //      }
    }
    public function changeStatus($id)
    {
		$uID = Crypt::decrypt($id);
    	$user = User::find($uID);
    	if ($user->status == '0') {
			$userUpdate = User::where('id','=',$uID)->update(['status'=> '1']);
			$productUpdate = Product::where('u_id_fk','=',$uID)->update(['isdelete'=>'0']);
    		Session::flash('message', 'Company Profile Activated successfully.');
    	} else{
			$userUpdate = User::where('id','=',$uID)->update(['status'=> '0']);
			$productUpdate = Product::where('u_id_fk','=',$uID)->update(['isdelete'=>'1']);
    		Session::flash('message', 'Company Profile De-Activated successfully.');
    	}
		return redirect()->back();
    }
    public function viewCompany($name, $id)
    {
		$uID      = Crypt::decrypt($id);
		$live     = array('menu'=>'32','parent'=>'2');
		$user     = User::find($uID);
		$userInfo = UserInfo::where('u_id_fk','=',$uID)->first();
		$country  = DB::table('countries')->find($userInfo->country);
		$state    = DB::table('states')->find($userInfo->state);
		$city     = DB::table('cities')->find($userInfo->city);
    	return view('admin.viewUser', compact('live','country','user','userInfo','state','city'));
    }

    public function redeemCoupons()
    {
		$live  = array('menu'=>'43','parent'=>'3');
		// $products = Product::where('isdelete','=','0')->where('u_id_fk','=',Auth::id())->get();
    	return view('vendor.redeemCoupon', compact('live'));
    	
    }

    public function updateCoupon(Request $req)
    {
    	$couponCode = $req->couponCode;
    	// echo $couponCode;
    	$couponFind = Redeems::where('coupon_code','=',$couponCode)->first();
    	if (count($couponFind) == 0) {
            $message = json_encode(array('type'=>'error','message'=>'Invalid Code'));
    	} else{
	    	if ($couponFind->status == '1') {
	            $message = json_encode(array('type'=>'error','message'=>'Already Redeemed by '.$couponFind->getUserInfo->name));
	    	} else{

	    		$userFind = Product::where('id','=',$couponFind->pro_id_fk)->select('u_id_fk')->first();
	    		$auth_u_id=Auth::id();
	    		if($userFind['u_id_fk'] == $auth_u_id){
		    		$couponUpdate = Redeems::where('coupon_code','=',$couponCode)->update([
		    			'status' => '1'
		    			]);
		            $message = json_encode(array('type'=>'success','message'=>'Redeemed by '.$couponFind->getUserInfo->name.' , '.$couponFind->getUserInfo->email.' , '.$couponFind->getUserInfo->phone));
		        }else{
		        	$message = json_encode(array('type'=>'error','message'=>'Invalid Code'));
		        }

	    	}
	    }
        return $message;
    }
}
