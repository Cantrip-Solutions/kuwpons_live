<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Product;
use \App\User;
use \App\Model\UserInfo;
use \App\Model\Category;
use \App\Model\ProductImage;
use \App\Model\Stock;
use Validator;
use Hash;
use File;
use Illuminate\Support\Facades\Input;
use Mail;
use Session;
use Image;
use Crypt;
use DB;

class ProductController extends Controller
{
    public function chartProduct()
    {
    	$live  = array('menu'=>'35','parent'=>'3');
    	$products = Product::where('isdelete','=','0')->get();
    	return view('admin.chartProduct', compact('live','products'));
    }

    /*************featured coupons **************/

    public function featuredCoupons()
    {
        $live  = array('menu'=>'35','parent'=>'3');
        $products = Product::where('featured','<>','1')->where('isdelete','=','0')->where('expire_on','>=',DB::raw('NOW()'))->get();
        $featuredProducts = Product::where('featured','=','1')->where('expire_on','>=',DB::raw('NOW()'))->get();

        /*echo "<pre>";
        print_r($featuredProducts);die;*/
        return view('admin.chartFeaturedProduct', compact('live','products','featuredProducts'));
    }


    public function addFeaturedCoupons(){

        $data=Input::except('_token','submit');
        $pro_id=$data['featured'];
        $featureCount=Product::where('featured','=','1')->count();
        
        if($featureCount < 3){

            $updatefeature=Product::where('id','=',$pro_id)->update(['featured'=>'1']);
            Session::flash('message', 'Featured Coupon Added.');

        }else{

            Session::flash('message', 'Featured Coupon Not Added .Maximum Featured Coupon already added.');

        }

        return redirect('/tab/featuredCoupons');
    }

    
    public function deletefeaturedProduct($pro_id){

        $pro_id=Crypt::decrypt($pro_id);
        $updatefeature=Product::where('id','=',$pro_id)->update(['featured'=>'0']);
        
        if($updatefeature){
            echo json_encode(array('status'=>1));
        }else{
            echo json_encode(array('status'=>0));
        } 
    }

    /*************featured coupons **************/

    public function addProduct()
    {
    	$live  = array('menu'=>'35','parent'=>'3');
    	$companyUsers = User::where('u_role','=','S')->where('status','!=','2')->get();
    	$categories=Category::where('id','<>',1)->get();
    	//echo "<pre>";print_r($categories);
    	return view('admin.addProduct', compact('live','companyUsers','categories'));
    }

    public function createProduct(){

    	$data=Input::except('_token','submit');
        /*echo "<pre>";
        print_r($data);
        exit;*/
        $name             = $data['name'];
        $u_id_fk          = $data['u_id_fk'];
        $cat_id_fk        = $data['cat_id_fk'];
        $original_price   = $data['original_price'];
        $discounted_price = $data['discounted_price'];
        $saling_price     = $data['saling_price'];
        $quantity         = $data['quantity'];
        $tag              = $data['tag'];
        $expire_on        = $data['expire_on'];
        $shortDescription = $data['shortDescription'];
        $description      = $data['description'];

		$rules = array(
			// 'file' => 'required|mimes:png,gif,jpeg,jpg',
            'name'             => 'required',
            'u_id_fk'          => 'required',
            'cat_id_fk'        => 'required',
            'original_price'   => 'required',
            'discounted_price'   => 'required',
            'saling_price'     => 'required',
            'quantity'         => 'required',
            'tag'              => 'required',
            'expire_on'        => 'required',
            'shortDescription' => 'required',
            'description'      => 'required'
        );
        $validator = Validator::make(array(
            'name'             => $name,
            'u_id_fk'          => $u_id_fk,
            'cat_id_fk'        => $cat_id_fk,
            'original_price'   => $original_price,
            'discounted_price' => $discounted_price,
            'saling_price'     => $saling_price,
            'quantity'         => $quantity,
            'tag'              => $tag,
            'expire_on'        => $expire_on,
            'shortDescription' => $shortDescription,
            'description'      => $description
        ), $rules);
        if ($validator->fails()) {

            return back()
                ->withErrors($validator)
                ->withInput();

        } else{

        	if (Input::hasfile('image')) {

                $image    = Input::file('image');
                $ext      = $image->getClientOriginalExtension();
                
                $filename = 'PRO'.time().'.'.$ext;
                $target   = config('global.productPath');
                $path     = $target.$filename;
                Image::make($image->getRealPath())->save($path);
                
                $product                   = new Product;
                $product->name             = $name;
                $product->u_id_fk          = $u_id_fk;
                $product->cat_id_fk        = $cat_id_fk;
                $product->original_price   = $original_price;
                $product->discounted_price   = $discounted_price;
                $product->saling_price     = $saling_price;
                $product->quantity         = $quantity;
                $product->expire_on        = date("Y-m-d", strtotime($expire_on));
                $product->description      = $description;
                $product->shortDescription = $shortDescription;
                $product->tag              = $tag;
                $product->save();
                
        		$last_insert_id = $product->id;

                $newProductImage = new ProductImage;
                $newProductImage->pro_id_fk = $last_insert_id;
                $newProductImage->image = $filename;
                $newProductImage->default_image = '1';
                $newProductImage->save();


                if(Input::hasfile('otherImage')){
                    $image_data=Input::file('otherImage');
                    
                    foreach ($image_data as $key => $value) {
                        
                        $otherimage    = $value;
                        $ext      = $otherimage->getClientOriginalExtension();
                        
                        $otherImagefilename = 'PRO'.time().rand(100,999).'.'.$ext;
                        $target   = config('global.productPath');
                        $path     = $target.$otherImagefilename;
                        Image::make($otherimage->getRealPath())->save($path);

                        $otherProductImage = new ProductImage;
                        $otherProductImage->pro_id_fk = $last_insert_id;
                        $otherProductImage->image = $otherImagefilename;
                        $otherProductImage->default_image = '0';
                        $otherProductImage->save();
                     }

                }


                $addQuantityToStock              = new Stock;
                $addQuantityToStock->pro_id_fk   = $last_insert_id;
                $addQuantityToStock->quantity    = $quantity;
                $addQuantityToStock->expire_on    = date("Y-m-d", strtotime($expire_on));
                $addQuantityToStock->description = '';
                $addQuantityToStock->save();

        		
				Session::flash('message', 'Coupon create successfull.');
		        
            }else{
               Session::flash('message', 'Coupon Not Created . Please insert Coupon Image.');

            }
            return redirect('/tab/product/add');
        }
    }

    public function deleteProduct($id)
    {
        $pID = Crypt::decrypt($id);
        $productDelete = Product::where('id','=',$pID)->update([
            'isdelete'=>'1',
        ]);

        // $productDelete->delete();
        Session::flash('message', 'Product deleted successfully.');
        return redirect()->back();
    }

    public function editProduct($name, $id)
    {
        $live  = array('menu'=>'35','parent'=>'3');
        $pdID = Crypt::decrypt($id);
        $productInfo = Product::find($pdID);
        $companyUsers = User::where('u_role','=','S')->where('status','!=','2')->get();
        $categories=Category::where('id','<>',1)->get();

        return view('admin.editProduct', compact('live','productInfo','companyUsers','categories'));
        
    }

    public function updateProduct()
    {
        $data=Input::except('_token','submit');
        // print_r($data);
        // exit;
        $pdID             = Crypt::decrypt($data['id']);
        $name             = $data['name'];
        $u_id_fk          = $data['u_id_fk'];
        $cat_id_fk        = $data['cat_id_fk'];
        $original_price   = $data['original_price'];
        $discounted_price = $data['discounted_price'];
        $saling_price     = $data['saling_price'];
        $quantity         = $data['quantity'];
        $tag              = $data['tag'];
        $expire_on        = $data['expire_on'];
        $description      = $data['description'];
        $shortDescription = $data['shortDescription'];
        

        $rules = array(
            // 'file' => 'required|mimes:png,gif,jpeg,jpg',
            'name'             => 'required',
            'u_id_fk'          => 'required',
            'cat_id_fk'        => 'required',
            'original_price'   => 'required',
            'discounted_price' => 'required',
            'saling_price'     => 'required',
            'quantity'         => 'required',
            'tag'              => 'required',
            'expire_on'        => 'required',
            'description'      => 'required',
            'shortDescription' => 'required'
            
        );
        $validator = Validator::make(array(
            'name'             => $name,
            'u_id_fk'          => $u_id_fk,
            'cat_id_fk'        => $cat_id_fk,
            'original_price'   => $original_price,
            'discounted_price' => $discounted_price,
            'saling_price'     => $saling_price,
            'quantity'         => $quantity,
            'tag'              => $tag,
            'expire_on'        => $expire_on,
            'description'      => $description,
            'shortDescription' => $shortDescription
        ), $rules);
        if ($validator->fails()) {

            return back()
                ->withErrors($validator)
                ->withInput();

        } else{
            $productUpdate = Product::where('id','=',$pdID)->update([
                'name'             => $name,
                'u_id_fk'          => $u_id_fk,
                'cat_id_fk'        => $cat_id_fk,
                'original_price'   => $original_price,
                'discounted_price' => $discounted_price,
                'saling_price'     => $saling_price,
                'quantity'         => $quantity,
                'tag'              => $tag,
                'expire_on'        => $expire_on,
                'description'      => $description,
                'shortDescription' => $shortDescription
            ]);

            if (Input::hasfile('image')) {

                $image    = Input::file('image');
                $ext      = $image->getClientOriginalExtension();
                
                $filename = 'PRO'.time().'.'.$ext;
                $target   = config('global.productPath');
                $path     = $target.$filename;
                Image::make($image->getRealPath())->save($path);

                $productImageUpdate = ProductImage::where('pro_id_fk','=',$pdID)->update([
                    'default_image'=>'0'
                    ]);

                $newProductImage = new ProductImage;
                $newProductImage->pro_id_fk = $pdID;
                $newProductImage->image = $filename;
                $newProductImage->default_image = '1';
                $newProductImage->save();
            }

            Session::flash('message', 'Coupon updated successfull.');
            return redirect('/tab/product');


        }
    }

    public function addQuantity($name, $id)
    {
        $pdID = Crypt::decrypt($id);
        $productInfo = Product::find($pdID);
        $live  = array('menu'=>'35','parent'=>'3');
        return view('admin.addProductQuantity', compact('live','productInfo'));

    }

    public function updateProductQuantity()
    {
        $data=Input::except('_token','submit');
        // print_r($data);
        // exit;
        $pdID        = Crypt::decrypt($data['id']);
        $quantity    = $data['quantity'];
        $description = $data['description'];
        $expire_on   = $data['expire_on'];

        $rules = array(
            // 'file' => 'required|mimes:png,gif,jpeg,jpg',
            'quantity'       => 'required',
            'expire_on'      => 'required'
        );
        $validator = Validator::make(array(
            'quantity'       => $quantity,
            'expire_on'      => $expire_on
        ), $rules);
        if ($validator->fails()) {

            return back()
                ->withErrors($validator)
                ->withInput();

        } else{
            $addQuantityToStock              = new Stock;
            $addQuantityToStock->pro_id_fk   = $pdID;
            $addQuantityToStock->quantity    = $quantity;
            $addQuantityToStock->expire_on    = date("Y-m-d", strtotime($expire_on));
            $addQuantityToStock->description = $description;
            $addQuantityToStock->save();

            $productInfo = Product::find($pdID);

            $productUpdate = Product::where('id','=',$pdID)->update([
                'quantity'  => $productInfo->quantity + $quantity,
                'expire_on' => date("Y-m-d", strtotime($expire_on)),
            ]);

            Session::flash('message', 'Coupon Stock Updated');
            return redirect()->back();

        }
    }

    public function stockHistory($name, $id)
    {
        $live         = array('menu'=>'35','parent'=>'3');
        $pdID         = Crypt::decrypt($id);
        $productInfo  = Product::find($pdID);
        $stockHistory = Stock::where('pro_id_fk','=',$pdID)->orderBy('id','DESC')->get();
        return view('admin.stockHistory', compact('live','productInfo','stockHistory'));      
    }

    public function imageGallery($name, $id)
    {
        $live           = array('menu'=>'35','parent'=>'3');
        $pdID           = Crypt::decrypt($id);
        $productInfo    = Product::find($pdID);
        $producrtimages = ProductImage::where('pro_id_fk','=',$pdID)->get();
        //echo "<pre>";print_r($productInfo->name);die;
        return view('admin.imageGallery', compact('live','productInfo','producrtimages')); 
    }  

       
    public function addToImageGallery()
    {
         $data=Input::except('_token','submit');
         //echo "<pre>";print_r($data);
         if (Input::hasfile('productImage')) {

                $image    = Input::file('productImage');
                foreach ($image as $key => $value) {
                
                $ext      = $value->getClientOriginalExtension();
                
                $filename = 'PRO'.time().rand(100,999).'.'.$ext;
                $target   = config('global.productPath');
                $path     = $target.$filename;
                Image::make($value->getRealPath())->save($path);
                
                $newProductImage = new ProductImage;
                $newProductImage->pro_id_fk = $data['pro_id_fk'];
                $newProductImage->image = $filename;
                $newProductImage->default_image = '0';
                $newProductImage->save();
            }
            return redirect()->back();
        }

    }  


    
    public function deleteImage()
    {
        $data=Input::except('_token','submit');
        $id=$data['id'];
        $ImageDelete = ProductImage::where('id','=',$id)->delete();
        if($ImageDelete){
            echo json_encode(array('status'=>1));
        }else{
            echo json_encode(array('status'=>0));
        }   
        
    }

        
}