<?php

class FrontController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'AdministratorController@showdashboard');
	|
	*/
	protected $layout = 'templates.interface';


	public function __construct()
    {
        $this->beforeFilter('csrf', array('on' => 'post'));
    }	
	
	public function postMessage(){
		Message::sendMail();
		Message::setMailData();
		return 'SEND';
	}
	
		
}