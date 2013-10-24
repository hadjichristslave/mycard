<?php


class Privilegemodel extends Eloquent  {
	public $rules = array(
		'privil_id' =>array('required' , 'integer'),
		'modelname' =>array('required' , 'min:3')
		);

	public static function customEdit(){
		$data = Input::except('_token');
		var_dump(Input::all());
		$obj = Privilegemodel::find(Input::get('id'));
		
		foreach($data as $key=>$dat){
			if($key!='id')
				$obj->$key = $dat;		
		}
		$obj->save();	
	}

	public static function customDelete($id){
		$obj = Privilegemodel::find($id)->delete();
	}
	public static function customCreate(){
		$obj = new Privilegemodel();
		
		$data = Input::except('_token');
		foreach($data as $key=>$val){
			$obj->$key = $val;
		}
		$obj->save();
	
	
	}








}