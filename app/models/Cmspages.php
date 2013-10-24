<?php


class Cmspages extends Eloquent  {
	protected $table = 'cms_pages';
	public $rules = array(
		'name' =>array('required' , 'min:4')
		);


	public static function customCreate(){
		$data = new Cmspages();
		$input= Input::except('_token' , 'id');
		foreach($input as $key=>$val){
			$data->$key = $val;
		}
		$data->save();
		return $data->id.'__________Sucessfull Page Creation!';
	}
	public static function customEdit(){
		$data = Cmspages::find(Input::get('id'));
		$input= Input::except('_token' , 'id');
		foreach($input as $key=>$val){
			$data->$key = $val;
		}
		$data->save();
		return 'Sucessfull Page Modification!';
	}

	public static function customDelete($id){
		Cmspages::where('id', '=', $id)->delete();
		$data= Cmscategory::all();
		foreach($data as $dat){
			$str = '';
			$tags = explode(',' , $dat->cs_pages);
			foreach($tags as $tag){
				if($tag!=$id) $str.= $tag. ',';
			}
			$str = substr($str , 0 ,-1);
			$object = Cmscategory::find($dat->id);
			$object->cs_pages = $str;
			$object->save();

		}
		return 'Sucessfull delete of page: '.$id. '!';
	}
	
	public static function csPageCategories($id){
		$exist = Cmspages::find($id)->cs_categories;
		$answer = array(
			'exist'       => array(),
			'dontexist'   => array(),
			'begins'      => Cmspages::find($id)->begins_with,
			'ends'        => Cmspages::find($id)->ends_with,
			'method'        => Cmspages::find($id)->method
		);
		$exist = explode(',' , $exist);
		
		if($exist[0]!=""){
			$dontexist = Cmscategory::whereNotIn('id' , $exist)->get();
		}
		else{
			$dontexist = Cmscategory::all();
		}
		if($exist[0]!=""){
			foreach($exist as $dat){
				$answer['exist'][] = array('id'=>$dat , 'name'=>Cmscategory::find($dat)->name);
			}
		}
		if(count($dontexist)>0){
			foreach($dontexist as $dat){
				$answer['dontexist'][] = array('id'=>$dat->id , 'name'=>Cmscategory::find($dat->id)->name);
			}
		}
		return  Response::json($answer);
		
		
	}
	public static function getPageData($str){
		$page = Cmspages::where('name' , '=' ,$str)->first();
		$cms_cats = explode(',' , $page->cs_categories);

		//--------------echo the page start tags-----------------------------------//
		echo $page->begins_with;
		
			foreach($cms_cats as $cat){
				if(Cmspages::where('name' , '=' ,$str)->first()->method=="default"){
					echo Cms::cmsTrnslData(Cmscategory::find($cat)->name , 1);
				}else{
					$method = Cmspages::where('name' , '=' ,$str)->first()->method;
					echo Cms::$method(Cmscategory::find($cat)->name);
				}
			}
		//--------------echo the page finish tags-----------------------------------//
		echo $page->ends_with;
		
	}

}