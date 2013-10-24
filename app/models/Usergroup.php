<?php


class Usergroup extends Eloquent  {
	public $rules = array(
		'name'                   => array('required' , 'min:3'),
		'r_privilege_lvl'        => array('required' , 'integer' , 'between:0,100'),
		'w_privilege_lvl'        => array('required' , 'integer' , 'between:0,100'),
		'x_privilege_lvl'        => array('required' , 'integer' , 'between:0,100')
		);



	public static function customCreate(){	
		$obj = new Usergroup();
		$obj->name = Input::get('name');
		$obj->r_privilege_lvl = $obj->w_privilege_lvl = $obj->x_privilege_lvl = 0;
		$obj->save();
		$valid= Validatedata::validateoperation($obj);
		if($valid!==true) 
			return $valid;
		return $obj->id.'__________Successful group insert!';
		
	}
	public static function customEdit(){
		$obj = Usergroup::find(Input::get('id'));
		$obj->name = Input::get('name');
		$obj->save();
		$valid= Validatedata::validateoperation($obj);
		if($valid!==true) 
			return $valid;
		return 'Successful group edit!';
	}
	public static function customDelete($id){
		Usergroup::find($id)->delete();
		$users = User::where('group_id' , '='  , $id)->get();	
		foreach($users as $user){
			Blacklistuser::where('username' , '=' , $user->username)->delete();
			Loglogin::where('user_id'  , '=' , $user->id)->delete();
		}
		$users = User::where('group_id' , '='  , $id)->delete();	
		return 'Successful delete of group with id' .$id. "!";
	}















}