<?php


class Cmscategory extends Eloquent  {
	protected $table = 'cms_category';
	protected $fillable = array('category_id' , 'id');
	public $rules = array(
							'name' =>array('required' , 'min:3'),
							'has_gallery' =>array('required' , 'integer'),
							'has_tags' =>array('required' , 'integer')
							);
	
	public static function customCreate(){
		$cat  = Input::except('_token');
		$obj  = new Cmscategory();
		foreach($cat as $key=>$val){
			$obj->$key  = $val;
		}
		$obj->has_tags=='on'?$obj->has_tags=1:$obj->has_tags=0;
		$obj->has_gallery=='on'?$obj->has_gallery=1:$obj->has_gallery=0;
		
		$valid = Validatedata::validateoperation($obj);
		if($valid!==true) 
			return $valid;
		
		$obj->save();
		$id = $obj->id;
		
		$obj  = new Cmscatprivilages();
		$obj->cms_cat_id = Cmscategory::max('id');
		$obj->r_privilege_lvl = 15;
		$obj->w_privilege_lvl = 15;
		$obj->x_privilege_lvl = 15;
		$obj->save();
		return $id.'__________Successful category insert!';

	}
	public static function customEdit(){
		$cat  = Input::except('_token');
		$obj  = Cmscategory::find($cat['id']);
		foreach($cat as $key=>$val){
			$obj->$key  = $val;
		}
		$obj->has_tags=='on'?$obj->has_tags=1:$obj->has_tags=0;
		$obj->has_gallery=='on'?$obj->has_gallery=1:$obj->has_gallery=0;
		
		$valid = Validatedata::validateoperation($obj);
		if($valid!==true) 
			return $valid;
		$obj->save();
		return 'Successful category edit!';
	}
	public static function customDelete($id){
		Cmscategory::find($id)->delete();
		Cmscatprivilages::where('cms_cat_id' , '=' , $id)->delete();
		
		$data = Cms::all();
		
		foreach($data as $dat){
			if($dat->category_id==$id){
				$obj = Cms::find($dat->id);
				$obj->fillable(array('category_id'));
				$obj->category_id = '10';
				$obj->save();
			}
		}
		return 'Successful Data with id: ' .$id.' delete!';
	}





}