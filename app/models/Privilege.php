<?php


class Privilege extends Eloquent  {
	public $rules = array(
		'name'                   => array('required' , 'min:3'),
		'r_privilege_lvl'        => array('required' , 'integer' , 'between:0,100'),
		'w_privilege_lvl'        => array('required' , 'integer' , 'between:0,100'),
		'x_privilege_lvl'        => array('required' , 'integer' , 'between:0,100')
		);

	public static function customDelete($id){
		Privilege::find($id)->delete();
		Privilegemodel::where('privil_id' , '=' , $id)->delete();
			return "Successful delete of privilege with id: ".$id." !";
	}

	public static function customCreate(){
		$name                      = Input::get('name');
		$obj                       = new Privilege();
		$obj->name                 = $name;
		$obj->r_privilege_lvl      = 5;
		$obj->w_privilege_lvl      = 5;
		$obj->x_privilege_lvl      = 5;
		
		$valid= Validatedata::validateoperation($obj);
		if($valid!==true) 
			return $valid;
		
		$obj->save();
		return $obj->id."__________Successful object insert!";
	
	}
	public static function has_privilege($model , $typeOfPriv){	
		$counter = Privilegemodel::where('modelname' , '=' , $model)->count();
		if($counter==0) return false;
		$data    = Privilegemodel::where('modelname' , '=' , $model)->first();
		$privlvl = Privilege::find($data->privil_id)->$typeOfPriv;
		$userprivlvl = Usergroup::find(Auth::user()->group_id)->$typeOfPriv;

		return $userprivlvl>=$privlvl;
	
	}
}