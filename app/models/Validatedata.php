<?php


class Validatedata extends Eloquent  {
	 protected $layout = '';
	 
	 public static function validateoperation(&$obj){
		$rules = $obj->rules;
		$data     = array();
		foreach($rules as $key=>$val){
			$data[$key] = $obj->$key;
		}
		$validator = Validator::make($data,$rules);
		if($validator->passes())
			return true;
		return $validator->errors();
	}	 
}