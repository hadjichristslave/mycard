<?php


class Navigation extends Eloquent  {
	public $timestamps = false;
	
	
	public function subcategory()
    {
        return $this->hasOne('Navigationsub' , 'nav_id');
    }
	
	
	
	public static function getNavigationData(){
		$data = Navigation::orderBy('order')->get();
		foreach($data as $dat){
			$privil_id = Privilege::find($dat->privill_id)->r_privilege_lvl;
			$user_privil_id = Usergroup::find(Auth::user()->group_id)->r_privilege_lvl;
			if($privil_id<=$user_privil_id){
				if($dat->has_subcat==1){
					$fixed_begin_data = Navigation::getCorrectedContext($dat->begins_with);
					echo $fixed_begin_data;
					echo $dat->subcategory()->first()->context;
					echo $dat->ends_with;				}
				else{
					//perform regexes, get all the dta
					$fixed_begin_data = Navigation::getCorrectedContext($dat->begins_with);
					echo $fixed_begin_data;
					echo $dat->ends_with;
				}
			}
		}
	}
	
	
	public static function getCorrectedContext($context){
	   $patern = "/\{{2}\w+:{2}\w+\( *\" *\w+ *[,\s\w]*\" *\, *\w+ *\)\}{2}/";
		preg_match_all($patern, $context, $matches);
		
		$string = substr($matches[0][0] , 2 , -2);
		$data  = explode( '::' , $string);
		$model = $data[0];
		$function = explode('(' , $data[1]);
		$keyword = explode(',' , $function[1]);
		$function = $function[0];
		$is_strict = str_replace(array(')' , ' ' ), '' , $keyword[1]);
		$keyword = $keyword[0];
		$replacement =  $model::$function($keyword ,$is_strict);
		
		
		$fixed_data = preg_replace($patern ,$replacement, $context);
		return $fixed_data;
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	}