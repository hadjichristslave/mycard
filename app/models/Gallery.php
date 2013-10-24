<?php
include('php/SimpleImage.php'); 


class Gallery extends Eloquent  {
	protected $table = 'gallery';
	public $rules = array(
		'name' =>array('required' , 'min:4'),
		'cat_id' =>array('required' , 'integer')
		);
	
	public static function uploadObject(){	
		$file       = Input::file('upl');		
		
		$objId      = Galleryobj::max('id')+1;
		$objName    = $objId . '.' . $file->getClientOriginalExtension();    
		$objUri     = 'gallery/gallery_'.Cmsgallery::where('cms_id' , '=' , Input::get('cms_id'))->first()->gal_id ;
		
		if (Input::hasFile('upl')){
			$upload = Input::file('upl')->move($objUri , $objName);
			if($upload){
				$obj               = new Galleryobj();
				$obj->uri          = '/'.$objUri .'/'. $objName;
				$obj->gal_id       = Cmsgallery::where('cms_id' , '=' , Input::get('cms_id'))->first()->gal_id;
				$obj->description  = Input::get('photo_description');
				$obj->save();
				
				$image = new SimpleImage(); 
				$image->load(substr($obj->uri ,1));
				$image->fit_to_width(768);
				$image->save();
				$image->fit_to_width(180);
				$image->save($objUri .'/'. $objId . '_thumb.' . $file->getClientOriginalExtension());				
				
				return 'all went well!';
			}
			return 'file uploaded, some errors!';
		}
		return 'no valid file uploaded';
	}
	
	public static function getGalleryObjects($gal_id){
		$objects = Galleryobj::where('gal_id' , '=' , $gal_id)->get();
		$data = '<li>
					<span class="thumbnail"><img src="/admin/example/cyan_hawk.jpg" alt=""></span>
					<span class="mws-gallery-overlay">
							<a href="/admin/example/cyan_hawk.jpg" rel="prettyPhoto[gallery1]" class="mws-gallery-btn"><i class="icon-search"></i></a>
							<a href="#" class="mws-gallery-btn"><i class="icon-trash"></i></a>
					</span>
				</li>';
		if(count($objects)>0){
			$data = '';
			foreach($objects as $obj){
				$thumb = explode('.', $obj->uri);
				$thumb = $thumb[0] . '_thumb.' . $thumb[1];
				$data .= '<li>
					<span class="thumbnail"><img src="'.$thumb.'" alt=""></span>
					<span class="mws-gallery-overlay">
							<a href="'.$obj->uri.'" rel="prettyPhoto[gallery1]" class="mws-gallery-btn"><i class="icon-search"></i></a>
							<a href="#" class="mws-gallery-btn"><i class="icon-trash del_gal_obj" picture_id="'.$obj->id.'" ></i></a>
					</span>
				</li>';
			}
			return $data;
		}
		return 'no images';		
	
	
		
	}
	
		
}