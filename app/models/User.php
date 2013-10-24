<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {
	public $rules = array(
		'username'          => array('required' , "min:4"),
		'group_id'          => array('required' , 'integer'),
		'is_banned'         => array('required', 'integer' ,"between:0,1")
		);
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}
	public static function getNumberOfNotifications(){
		$ips = Blacklistip::where('counter' , '>' , 8)->count();
		$bans = User::where('is_banned' , '=' , 1)->count();
		return $ips+$bans;
	}
	public static function customEdit(){
		$data = Input::except('_token' , 'id' , 'is_banned' , 'username');
		$obj  = User::find(Input::get('id'));
		
		if($obj->is_banned==1 && Input::has('is_banned')){
			$obj->is_banned=0;
			$obj->save();
			Blacklistuser::where('username' , '=' , $obj->username)->update(array('counter'=>0));
		}
		if($obj->is_banned==0 && !Input::has('is_banned')){
			$obj->is_banned=1;
			$obj->save();
			Blacklistuser::where('username' , '=' , $obj->username)->update(array('counter'=>16));
		}

		foreach($data as $key=>$dat){
			if($key=="password" && $dat!=""){
				$obj->password = Hash::make($dat);
			}
			else if($key!="username" && $key!='password'){
				$obj->$key = $dat;
			}
		}
		$valid= Validatedata::validateoperation($obj);
		if($valid!==true) 
			return $valid;
		$obj->save();
		
		return 'Succesful Edit!';
	
	}
	public static function customCreate(){
		$check = User::where('username' , '=' , Input::get('username'))->count();
		if($check>0) return 'Username allready taken';
		$data = Input::except('_token');
		$obj  = new User();
		foreach($data as $key=>$dat){
			if($key=="password" && $dat!="")
				$obj->password = Hash::make($dat);
			else if($key!="id")
				$obj->$key = $dat;
		}
		$obj->is_banned=0;
		$valid= Validatedata::validateoperation($obj);
		if($valid!==true) 
			return $valid;
		$obj->save();
		
		$data = new Blacklistuser();
		$data->username = $obj->username;
		$data->counter = 0;
		$data->save();
		return $obj->id.'__________Successful user insert!';
	}
	public static function customDelete($id){
		$user = User::find($id);
		Blacklistuser::where('username' , '=' , $user->username)->delete();
		Loglogin::where('user_id' , '=' , $id)->delete();
		$user->delete();
		return "Sucessful user with id: ".$id." Delete!";
	}
	public static function modifyLoggedPass($model){
		$pwd = Input::get('password');
		if(Hash::check(Input::get('ol_pass') , Auth::user()->password)){
			$usr = User::find(Auth::user()->id);
			$usr->password = Hash::make($pwd);
			
			$valid= Validatedata::validateoperation($usr);
			if($valid!==true) 
				return $valid;
			
			$usr->save();
			return 'successfull password change!';
		}
		return 'Ol password mismatch!';
			
	}

}