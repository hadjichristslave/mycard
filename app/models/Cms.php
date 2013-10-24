<?php


class Cms extends Eloquent  {
	protected $table = 'cms';
	public $rules = array('name'=> array('required', 'min:3') , 
						  'content' =>array('required' , 'min:15'), 
						  'category_id' =>array('required' , 'integer'), 
						  'order' =>array('required' , 'integer'),
						  'lang_id'=>array('required' , 'integer'));




	/* Returns the related cms module ids ordered by order*/
	public static function validCmsCat($cms_cat_name){
		$answer = array('id' =>'0');
		$data = Cmscategory::where('name' , '=' , $cms_cat_name)->first();

		if(isset($data->id)){
			return $data;
		}else{
			return json_encode($answer);  /* Json encoded so that it is returned as an object*/
		}
	}

	/* Returns the translation of the related cms data */
	public static function validCmsData($langid , $cmsname){
		$validCms = Cms::where('category_id' , '=' ,$cmsname)->get();
	}

	public static function has_gallery($cms_cat_id){
		$data = Cmscategory::find($cms_cat_id);
		if(isset($data->has_gallery)){
			return $data->has_gallery>0;
		}
		return false;
		//asfasfsd
	}

				


	public static function cmsTrnslData($cms_cat_name , $lang_id){
	//  only to be used on contact forms with the {{"captcha"}} keyword
	
		$pubkey = "6Lep7-USAAAAAJVF_y4GBHeucyZ9VKGnF7FgGwP1"; // Public API Key
		$cms_cat = Cms::validCmsCat($cms_cat_name);
		$cms_cat = json_decode($cms_cat);

		if($cms_cat->id!='0'){
			echo Cmscategory::find($cms_cat->id)->begins_with;
			$data = CMS::where('category_id' , '=' , $cms_cat->id)->orderBy('order' , 'asc')->get();
			foreach($data as $dat){
				$content = $dat->content;
				$token   = Form::token();
				$content = str_replace('{{Form::token()}}' , $token , $content);
				
				$captcha = recaptcha_get_html($pubkey);
				$content = str_replace('{{"captcha"}}' , $captcha , $content);
				
				echo $content;
			}
			echo Cmscategory::find($cms_cat->id)->ends_with;
			return;
		}  
		return 'No data regarding this section of your site';
	}
	
	public static function customCreate(){
		$input = Input::except('_token');
		$obj   = new Cms();
		foreach($input as $key=>$val){
			$obj->$key  = $val;
		}
		
		$valid= Validatedata::validateoperation($obj);
		if($valid!==true) 
			return $valid;
		$obj->save();
		$id = $obj->id;
		
		$gal           = new Gallery();
		$gal->name     = $input['name'];
		$gal->cat_id = 1;
		$gal->save();
		
		$obj         = new Cmsgallery();
		$obj->cms_id = Cms::max('id');
		$obj->gal_id = Gallery::max('id');
		$obj->save();
			
		$structure  = 'gallery/gallery_'.Gallery::max('id');
		mkdir($structure);
	}
	public static function customDelete($id){
		$gal_id = Cmsgallery::where('cms_id' , '=' , $id)->first();
		@Cms::find($id)->delete();
		Cmsgallery::where('cms_id' , '=' , $id)->delete();
		Gallery::where('id' , '=' , $gal_id->gal_id)->delete();
		Galleryobj::where('gal_id' , '=' , $gal_id->gal_id)->delete();		
		$structure  = 'gallery/gallery_'.$gal_id->gal_id;
		
		//delete files contained, first
		$files = glob($structure . '/*'); // get all file names
		foreach($files as $file){ // iterate files
		  if(is_file($file))
			@unlink($file); // delete file
		}		
		//then kill the folder
		@rmdir($structure);
	}
	
	public static function customEdit(){
		$dat = Input::except('_token' , 'id');
		$obj = Cms::find(Input::get('id'));
		foreach($dat as $key=>$val){
			if($key!=NULL && $val!=NULL)
				$obj->$key = $val;
		}
		$obj->save();
	}
	public static function hasGallery($id){
		return Cmscategory::find(Cms::find($id)->category_id)->has_gallery>0;
	}
	public static function getTagsThatExist($cms_cat_id){
		if(Cmscategory::find($cms_cat_id)->has_tags=='0')
			return 'Category with tags disabled!';
		
		
		$data        = Cms::where('category_id' , '='  , $cms_cat_id)->get();
		$tagsArray   = array();
		foreach($data as $dat){
			$tags = explode(',' , $dat->tags);
			if(count($tags)>0){
				foreach($tags as $tag){
					if(!in_array($tag, $tagsArray))
						$tagsArray[] = $tag;	
				}
			}
		}
		return $tagsArray;
	}
	public static function getGalleryMockup($category_name){
		
		$category_id            = Cmscategory::where('name' , '=' , $category_name)->first()->id;
		
		
		$tags_that_work         = Cms::getTagsThatExist($category_id);
		$html                   = Cmscategory::where('name' , '=' , $category_name)->first()->begins_with;
		$html                   .= '<ul class="cats-filter" id="portfolio-filter"><li><a href="" class="current transition" data-filter="*">All</a></li>';
		foreach($tags_that_work as $tag){
			$html .= '<li><a href="" class="transition" data-filter=".'.Cmstags::find($tag)->name.'">'.Cmstags::find($tag)->name.'</a></li>';
		}
            $html .= '</ul>  <div class="extra-text">Some projects i\'m proud for:</div>';
			
            $html .= ' <ul id="portfolio-list">';
		
		$cms   = Cms::where('category_id', '=' , $category_id)->orderBy('order', 'asc')->get();
		foreach($cms as $key=>$gal){
		
			$cmsgal       = Cmsgallery::where('cms_id' , '=' , $gal->attributes['id'])->first();
			$gallerydata  = Galleryobj::where('gal_id' , '=' , $cmsgal->gal_id)->get();
			
			$html .= '<li class="'.Cmstags::getTagsFromCms($gal->id).'">';
			
			foreach($gallerydata as $galkey=>$dat){
				$thumb_uri = explode('.' , $dat->uri);
				$thumb_uri = $thumb_uri[0] . '_thumb.' . $thumb_uri[1];
				if($galkey==0){
					$html .= '<a href="'.$dat->uri.'" rel="portfolio['.$key.']" title="'.$dat->description.'" class="folio">';
					$html .= '<img src="'.$dat->uri.'" alt="'.$dat->description.'">';
					$html .= ' <h2 class="title">'.$gal->name.'</h2>';
					$html .= '<span class="categorie">'.Cmstags::getTagsFromCms($gal->id).'</span> </a>';
				}
				else{
					$html .= '<a href="'.$dat->uri.'" rel="portfolio['.$key.']" title="'.$dat->description.'" class="folio hidden"></a>';
				}
			
			 
			}
			$html  .= $gal->content;
            $html  .= "</li>";
			$html  .= Cmscategory::where('name' , '=' , $category_name)->first()->ends_with;
		}
		echo $html;
	}
	
	public static function 	retrievewebservicefeed($limit, $offset){
		$data = Cms::skip($offset)->take($limit)->orderBy('updated_at', 'desc')->get();
		$answer = array();
		
		foreach($data as $dat){
			$item_array = array();
			$gal_id  = Cmsgallery::where('cms_id' , '=' , $dat->id)->first()->gal_id;
			$objects  = Galleryobj::where('gal_id' , '=' , $gal_id)->get();
			foreach($objects as $obj){
				$item_array[] = $obj->attributes;
			
			
			}
			
			
			$answer[] = array(
				'cms'      => $dat->attributes,
				'gallery'  => $item_array
			);
		}
		return $answer;
	}
	public static function searchQuery($qry){

		$answer = array();
		$data = Cms::all();
		foreach($data as $dat){
			$item     =	new SearchItem($dat->attributes , 'Cms');
			$answer[] = $item;			
		}
		$data = Message::all();
		foreach($data as $dat){
			$item     =	new SearchItem($dat->attributes , 'Msg');
			$answer[] = $item;			
		}
		
		$answercount = Cms::all()->count() + Message::all()->count();
		
		
		
		$response = array('totalResultsCount' => $answercount , 'results'=>$answer);
		return  Input::get('callback'). '('. json_encode($response) . ')';
	}
	
}




Class SearchItem{
	public $is_visible = false;
	public $data_cat;
	public $data ='asdf';
	public $results = 'asdf';
	public $id = 'asdf';
	public $link = 'asdf';
	
	public function __construct($data , $string){
		$this->data = $data;
		$this->data_cat = $string;
	}
	
	public function setVisible(){
		$this->is_visible = true;
	}
	public function setInvisible(){
		$this->is_visible = false;
	}
}