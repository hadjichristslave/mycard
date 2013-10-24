<?php


class Blacklistuser extends Eloquent  {
	public $rules = array('username'=> array('required', 'min:4') , 'counter' =>array('integer'));

	protected $table = 'blacklist_user';
	
	public static function updateLoginFail($user){
		$exists = Blacklistuser::where('username', '=' , $user)->count();
		if($exists==0){
			$bluser = new Blacklistuser();
			$bluser->username = $user;
			$bluser->counter  = 0;
			$bluser->save();
		}else{
			$bluser = Blacklistuser::where('username', '=' , $user)->first();
			$bluser->counter++;
			$bluser->save();
			if($bluser->counter>=3){
				$user = User::where('username', '=' , $user)->first();
				$user->is_banned=1;
				$user->save();
			}
		
		}
	}
	
	
	public static function validate(Blacklistuser $user){
		var_dump($user->rules);
		$rules = array('username'=> array('required', 'min:4') , 'counter' =>array('integer'));
		$data     = array();
		foreach($rules as $key=>$val){
			$data[$key]   = $user->$key;
		}
		$validator = Validator::make($data,$rules);
		return $validator->passes();
	}
	
	
	
	
	}