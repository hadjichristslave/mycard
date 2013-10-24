<?php


class Galleryobj extends Eloquent  {
	protected $table = 'gallery_object';
	
	
	public static function customDelete($id){		
		$obj        = Galleryobj::find($id);
		$pic_uri    = $obj->uri;
		$thumb_uri  = explode('.', $pic_uri);
		$thumb_uri  = $thumb_uri[0] . '_thumb.' . $thumb_uri[1];
		
		unlink(substr($pic_uri,1));
		unlink(substr($thumb_uri,1));		
		$obj->delete();
		return 'Successful delete of picture with id: '. $id;
	}
	
}