<?php


class Loglogin extends Eloquent  {

	protected $table = 'log_login';
	public $rules = array('user_id'=> array('required', 'integer') , 
						  'action' =>array('required' , 'in:login,logout'),
						  'ip'=> array('required', 'regex:/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z$/')
						  );
	

	public static function record($action){
		$browser = get_browser(null, true);
		$log   = new Loglogin();
		$log->user_id    =  Auth::user()->id;
		$log->action     =  $action;
		$log->ip         =  getenv("REMOTE_ADDR");
		$log->browser    =  $browser['browser'];
		$log->platform   =  $browser['platform'];
		$log->save();
	}
	public static function resetBlacklists(){
		$username = Auth::user()->username;
		$ip       = getenv('REMOTE_ADDR');		
		Blacklistip::where('ip' , '=' , $ip)->update(array('counter'=>0));
		Blacklistuser::where('username' , '=' , $username)->update(array('counter'=>0));	
	}
	
	
	
	
	
	
	}