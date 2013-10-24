<?php


class Blacklistip extends Eloquent  {
	public $rules = array('ip'=> array('required', 'regex:/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z$/'));

	protected $table = 'blacklist_ip';	
	public static function updateLoginFail($user){		
		$ip      = getenv("REMOTE_ADDR");
		$exists = Blacklistip::where('ip', '=' , $ip)->count();
		if($exists==0){
			$bluser = new Blacklistip();
			$bluser->ip = $ip;
			$bluser->counter  = 0;
			if(Blacklistip::validate($bluser)){
				$bluser->save();
				return 'successful update!';
			}else{
				return 'invalid data!';
			}
		}else{
			$bluser = Blacklistip::where('ip', '=' , $ip)->first();
			$bluser->counter++;
			if(Blacklistip::validate($bluser)){
				$bluser->save();
				return 'successful update!';
			}else{
				return 'invalid data!';
			}
		}
	}
	
	public static function isIpBanned(){
		$ip      = getenv("REMOTE_ADDR");
		$data    = Blacklistip::where('ip' , '=' , $ip)->count();
		if($data>0){
			$data    = Blacklistip::where('ip' , '=' , $ip)->first();
			if($data->counter>7) return true;		
		}
		return false;
	
	}

	public static function setMarkClass($id1, $id2){
		if($id1==$id2){	
			echo 'style="background-color:yellow!important"';
		}
	
	}
	public static function validate(Blacklistip $test){
		var_dump($test->rules);
		$rules = array('ip'=> array('required', 'regex:/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z$/'));
		$data     = array();
		foreach($rules as $key=>$val){
			$data[$key]   = $test->$key;
		}
		$validator = Validator::make($data,$rules);
		return $validator->passes();
	}
	
	
	
	
}