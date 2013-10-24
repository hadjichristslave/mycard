<?php


class Cmsgallery extends Eloquent  {
	protected $table = 'cms_gallery';
	public $rules = array(
		'gal_id' =>array('required' , 'integer'),
		'cms_id' =>array('required' , 'integer')
		);





}