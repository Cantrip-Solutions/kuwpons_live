<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use \App\Model\UserInfo;
use Crypt;
use DB;
use Validator;
use Auth;
use Session;
use Hash;
use URL;
use Mail;
use Helper;


class ConsumerController extends Controller
{
    //Display DataTables of Consumer List in Admin Panel
    public function chartConsumer()
    {
    	$live = array('menu'=>'31','parent'=>'2');
    	$users = User::where('u_role','=','U')->get();
    	return view('admin.chartConsumer', compact('live','users'));
    }
    
    public function viewConsumer($name, $id)
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

    public function userRegister(Request $req)
    {
        $fname     = $req->fname;
        $lname     = $req->lname;
        $email    = $req->email;
        $password = $req->password;
        $phone    = $req->phone;
        // $dob      = $req->dob;
        $gender   = $req->gender;

        $rules = array(
            'fname'    => 'required',
            'lname'    => 'required',
            'phone'    => 'required',
            'email'    => 'required',
            'password' => 'required',
            // 'dob'      => 'required',
            'gender'   => 'required',
        );
        $validator = Validator::make(array(
            'fname'    => $fname,
            'lname'    => $lname,
            'email'    => $email,
            'phone'    => $phone,
            'password' => $password,
            // 'dob'      => $dob,
            'gender'   => $gender,
            ), $rules);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        } else{
            if (User::where('email', '=', $email)->exists()) {
                Session::flash('message', json_encode(array('type'=>'error', 'message'=>'Email already exists. Please try another email ID')));
                return redirect()->back();
            } else{
                $rememberToken = rand(10000, 99999);
                $name = $fname.' '.$lname;
                $user                 = new User;
                $user->name           = $name;
                $user->email          = $email;
                $user->u_role         = 'U';
                $user->password       = Hash::make($password);
                $user->showPassword   = $password;
                $user->status         = '0';
                $user->deliveryType   = $req->deliveryType;
                $user->remember_token = $rememberToken;
                $user->save();

                $last_insert_id                 = $user->id;
                $userInfo                       = new UserInfo;
                $userInfo->u_id_fk              = $last_insert_id;
                $userInfo->email                = $email;
                $userInfo->name                 = $name;
                $userInfo->phone                = $phone;
                $userInfo->default_address_flag = 1;
                $userInfo->save();

                $data = [
                 'name'     => $name,
                 'view'     => 'emails.newUserRegistrationMail',
                 // 'to'       => 'sumita.cantripsolutions@gmail.com',
                 'to'       => $email,
                 'activationLink' => URL::to('/').'/activateuser/'.$name.'/'.base64_encode($last_insert_id).'/'.Crypt::encrypt($rememberToken),
                 'subject'  => 'Welcome to '.config('global.siteTitle'),
                ];

                // Mail::send($data['view'], $data, function($message) use ($data){
                //     $message->to($data['to'], $data['name'])->subject($data['subject']);
                // });

                $sendMail = Helper::sendMail($data);

                Session::flash('message',json_encode(array('type'=>'success', 'message'=>'Successfully Register. Please check email to active your account.')));

                // Session::flash('message', 'Successfully Register. Please check email to active your account.');
                return redirect()->back();

                // if (Auth::attempt(['email' => $email, 'password' => $password])) {
                //     // echo "ok";
                //     return redirect()->back();
                // } else{
                //     // echo "wrong";
                //     return redirect()->back();
                // }

            }

        }
    }

    public function activateUser($name, $id, $rememberToken)
    {
        $token = Crypt::decrypt($rememberToken);
        $uID = base64_decode($id);
        $user = User::find($uID);
        if ($user->status == '0' && $user->remember_token == $token) {
            $user->status = '1';
            $user->save();
            Auth::attempt(['email' => $user->email, 'password' => $user->showPassword]);
            Session::flash('message',json_encode(array('type'=>'success', 'message'=>'Your Account activated succesfully')));
            return redirect('/myAccount');



        } else{
            Session::flash('message',json_encode(array('type'=>'error', 'message'=>'This Activation Link is not Valid')));
            return redirect('/');
        }   
    }
}
