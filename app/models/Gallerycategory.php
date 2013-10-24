<?php


class Gallerycategory extends Eloquent  {
	protected $table = 'gallery_cat';
	public $rules = array('name'=> array('required', 'min:3')
						  );
	
	public static function customCreate(){
		$obj = new Gallerycategory();
		$obj->name= Input::get('name');
		$valid= Validatedata::validateoperation($obj);
		if($valid!==true) 
			return $valid;
		$obj->save();
		return $obj->id . '__________Sucessfull category creation!';
	}
	public static function customDelete($id){
		Gallerycategory::where('id', '=', $id)->delete();
		foreach(Gallery::all() as $dat){
			if($dat->cat_id==$id){
				$obj = Gallery::find($dat->id);
				$obj->cat_id=1;
				$obj->save();
			}
		}
		return 'Sucessfull category removal!';
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}