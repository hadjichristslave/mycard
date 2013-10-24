<?php


class Languages extends Eloquent  {
	protected $table = 'language';
	public $timestamps = false;
	public $rules = array('name'=> array('required', 'min:3')
						  );
	
	public static function customCreate(){
		$data = Input::except('_token');
		$language = new Languages();
		foreach($data as $k=>$v){
			$language->$k = $v;
		}
		$valid= Validatedata::validateoperation($language);
		if($valid!==true) 
			return $valid;
		$language->save();
		return $language->id.'__________Successful language insert!';
	}
	
	public static function customEdit(){
		$data = Input::except('_token' , 'id');
		$language = Languages::find(Input::get('id'));
		foreach($data as $k=>$v){
			$language->$k = $v;
		}
		$valid= Validatedata::validateoperation($language);
		if($valid!==true) 
			return $valid;
		$language->save();
		return 'Successful language edit!';
	}
	public static function customDelete(){
		$language = Languages::find(Input::get('id'))->delete();
		$data = Cms::all();
		foreach($data as $key=>$val){
			if($val->lang_id == Input::get('id')){
					$val->lang_id = 1;
					//$val->save();
					$val->delete();
			}
		}
		return 'Successful delete of language and translations with id ' .Input::get('id').'!';
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}