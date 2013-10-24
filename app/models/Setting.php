<?php


class Setting extends Eloquent  {
	public $timestamps = false;
	
	public $rules = array(
		'setting'          => array('required' , 'min:3'),
		'setting_group'    => array('required' , 'integer'),
		'is_activated'     => array('required', 'integer')
		);
		
	public static function getActiveClasses($uri , $is_strict){
		if(!$is_strict || $is_strict=="false"){
			$array = array('"' , "'" , " ");
			$uri   = str_replace($array, '' ,$uri);
			$uriz = explode(',' ,$uri);
			$uri_parts = $_SERVER['REQUEST_URI'];
			foreach($uriz as $u){
				if(stripos($uri_parts, $u)===false)continue;
				else return "active";
			}
		}else{
			$uriz = explode(',' ,$uri);			
			$uri_parts = $_SERVER['REQUEST_URI'];
			$uri_parts = explode('?', $uri_parts);
			$uri_parts = explode('/' , $uri_parts[0]);
			foreach($uriz as $u){
				foreach($uri_parts as $ur)					
					if($u==$ur)return "active";
			}
		}
	}	 
}