<?php


class Cmstags extends Eloquent  {
	protected $table = 'cms_tags';
	public $rules = array(
		'name' =>array('required' , 'min:4')
		);


	public static function customDelete($id){
		Cmstags::where('id', '=', $id)->delete();
		$data= Cms::all();
		foreach($data as $dat){
			$str = '';
			$tags = explode(',' , $dat->tags);
			foreach($tags as $tag){
				if($tag!=$id) $str.= $tag. ',';
			}
			$str = substr($str , 0 ,-1);
			$object = Cms::find($dat->id);
			$object->tags = $str;
			
			$valid= Validatedata::validateoperation($object);
			if($valid!==true) 
				return $valid;
				
			$object->save();
			return 'Sucessful tag with id:'.$id.' delete!';
		}
	}
	public static function customCreate(){
		$data = new Cmstags();
		$data->name = Input::get('name');
		$valid= Validatedata::validateoperation($data);
		if($valid!==true) 
			return $valid;
		$data->save();
		return $data->id .'__________Sucessfull data insert!';
	}
	
	public static function csTagsToBadges($string){
		$data = explode(',' , $string);
		foreach($data as $dat){
			if($dat!='')
				echo '<span class="badge badge-success">'.Cmstags::find($dat)->name.'</span>';
		}
	}
	
	public static function getTagsFromCms($cms_id){
		$tags = Cms::find($cms_id)->tags;
		$tags = explode(',' , $tags);
		if(count($tags)<0) return '';
		
		$answer ='';
		foreach($tags as $tag){
			$answer .= Cmstags::find($tag)->name . ' ';
		}
		return $answer;
	
	
	}

}