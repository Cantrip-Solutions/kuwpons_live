<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use \App\Model\UserInfo;
use \App\Model\Category;
use Validator;
use Hash;
use File;
use Illuminate\Support\Facades\Input;
use Mail;
use Session;
use Image;
use App\Model\Product;


class CategoryController extends Controller
{
	//Display DataTables of Category List in Admin Panel
    public function chartCategory()
    {
		$live  = array('menu'=>'33','parent'=>'3');
		$categories=Category::get();
        $categories=$this->formate_category($categories,0);
        //echo "<pre>"; print_r($categories);echo "</pre>";
    	return view('admin.chartCategory', compact('live','categories'));
    }

    public function formate_category($categories,$parent_cat_id)
     {

        $formated_category_array=array();

        foreach ($categories as $key => $value) {

            if($value->parent_cat_id == $parent_cat_id ) {
                $formated_category_array[ $value->id ]=array('name'=> $value->cat_name,'child'=>0);
            }elseif( array_key_exists($value->parent_cat_id, $formated_category_array)){

                $formated_category_array[ $value->parent_cat_id ]['child']=1;
            }
        }
        //print_r($formated_category_array);die;
       return $formated_category_array;
     }

    // Add new Category from Admin Panel
    public function addCategory(){
    	$live = array('menu'=>'33','parent'=>'3');
       
    	return view('admin.addCategory', compact('live'));
    }

    public function createCategory(Request $req)
    {   
        
		$cat_name  = $req->cat_name;
		$cat_description = $req->cat_description;
        $att= $req->att;
		$rules = array(
			// 'file' => 'required|mimes:png,gif,jpeg,jpg',
			'cat_name'    => 'required'
        );
        $validator = Validator::make(array(
			'cat_name'  => $cat_name,
            ), $rules);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        } else{
        	if (Input::hasfile('cat_icon')) {

                $image   = Input::file('cat_icon');
                $filename  = 'CAT'.time().'.png';
                $target  = config('global.categoryPath');
                $path = $target.$filename;
                Image::make($image->getRealPath())->resize(30, 30)->save($path);



        		$ctaegory = new Category;
        		$ctaegory->cat_name = $cat_name;
        		$ctaegory->cat_description = $cat_description;
                $ctaegory->cat_icon = $filename;
                $ctaegory->specifications = serialize($att);
                if($req->subcategory){
                    $ctaegory->parent_cat_id=$req->parent_cat_id;
                }else{
                    $ctaegory->parent_cat_id=0;
                }
        		$ctaegory->save();
                
        		$last_insert_id = $ctaegory->id;
        		
				Session::flash('message', 'Cetagory create successfull.');
		        
            }else{
               Session::flash('message', 'Cetagory Not Created . Please insert Category Image.'); 

            }
            if($req->subcategory){
                //$parent_category=Category::where('id',$req->parent_cat_id)->first();
        	    return redirect('/tab/subcategory/add/'.$req->parent_cat_id);
            }else{
                return redirect('/tab/category/add');
            }
        }
    }

    public function getSubCategories(Request $req)
    {
        $parent_cat_id = $req->parent_cat_id;
        $sub_categories=Category::get();
        $sub_categories=$this->formate_category($sub_categories,$parent_cat_id);
        echo json_encode($sub_categories); 
    }
    
    public function addsubCategory($parent_cat_id){
        $live = array('menu'=>'33','parent'=>'3');
        $category=Category::where( 'id' , '=' , $parent_cat_id )->first();
        //echo "<pre>";print_r($category);
        $subcategory=1;
        return view('admin.addCategory', compact('live','category','subcategory'));
    }

    public function editCategory($cat_name,$cat_id){
        $live = array('menu'=>'33','parent'=>'3');
         $category=Category::where( 'id' , '=' , $cat_id )->first();
         if($category->parent_cat_id != 0){
            $subcategory=1;
            $parentCategory=Category::where( 'id' , '=' , $category->parent_cat_id )->first();
        }else{
            $subcategory=0;
            $parentCategory='';
        }
         return view('admin.editCategory', compact('live','category','subcategory','parentCategory'));
    }

    public function updateCategory(Request $req){

        //echo "edit";
        $cat_name  = $req->cat_name;
        $cat_description = $req->cat_description;
        $cat_id=$req->id;
        $att= $req->att;
        $rules = array(
            // 'file' => 'required|mimes:png,gif,jpeg,jpg',
            'cat_name'    => 'required'
        );
        $validator = Validator::make(array(
            'cat_name'  => $cat_name,
            ), $rules);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        } else{

            if (Input::hasfile('cat_icon')) {

                $image   = Input::file('cat_icon');
                $filename  = 'CAT'.time().'.png';
                $target  = config('global.categoryPath');
                $path = $target.$filename;
                Image::make($image->getRealPath())->resize(30, 30)->save($path);

            }else{
                $filename  = $req->old_cat_icon;
            }

            if($req->subcategory){
                $parent_cat_id=$req->parent_cat_id;
            }else{
                $parent_cat_id=0;
            }

            Category::where('id', $cat_id)->update([
                'cat_name' => $cat_name,
                'cat_icon'=>$filename,
                'cat_description'=>$cat_description,
                'specifications' => serialize($att),
            ]);
            
            Session::flash('message', 'Cetagory Edited successfull.');
            return redirect('/tab/category/edit/'.$cat_name.'/'.$cat_id);
        }

    }


    public function deleteAllCategory($cat_id){

       
        $product_res=Product::where('cat_id_fk','=',$cat_id)->update(['cat_id_fk'=>1]);
         $res=Category::where('id','=',$cat_id)->delete();
        $category=Category::where('parent_cat_id','=',$cat_id)->get();
        $categories=$this->formate_category($category,$cat_id);
        if(!empty($categories)){

            foreach ($categories as $key => $category) {

                $result=$this->deleteAllCategory($key);
            }

        }

        if($res){
            return 1;
        }else{
            return 0;
        }
    }

    public function deleteCategory(){

        $data=input::all();
        $result=$this->deleteAllCategory($data['cat_id']);
        //echo $result;die;
        if($result == 1){
            echo json_encode(array('status'=>1));
        }else{
            echo json_encode(array('status'=>0));
        }     
    }

}