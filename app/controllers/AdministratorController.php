<?php
require_once('recaptchalib.php'); // reCAPTCHA Library
class AdministratorController extends BaseController {

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

	public function __construct(){
        $this->beforeFilter('csrf', array('on' => 'post'));
        View::share('title' , 'Heuristic-web admin');
		View::share('notif_number' , User::getNumberOfNotifications());
        $this->beforeFilter('getprivilagefilter', array('on' => 'get'));
        $this->beforeFilter('postprivilagefilter', array('on' => 'post'));
		$this->checkIfBanned();
    }
	
	public function checkIfBanned(){
		if(!Auth::guest())
		{
			if (Auth::user()->is_banned==1){
				Auth::logout();
				echo 'the user is banned, contact sys admin for further details!';
				exit;
			}
			if(Blacklistip::isIpBanned()){
				Auth::logout();
				echo 'your IP is banned, contact sys admin for further details!';
					exit;
			}		
		}
	}


	public function getIndex(){
        if(Auth::check())
			return Redirect::to('administrator/dashboard');
		return View::make('admin.login');
    }

    public function postIndex(){
    	$user = array('username' => Input::get('username') , 'password' => Input::get('password'));
        if (Auth::attempt($user , true)){
        	$account  = Event::fire('user.login', $user);
			
			if($account=='banned') 
				return View::make('admin.login')->with('messager', 'Account or Ip Banned! Contact Sys-Admin!');
			
			return Redirect::to('administrator/dashboard');
        }else{
			Event::fire('login.fail' , $user);
			return View::make('admin.login')->with('messager', 'Login fail!');
		}
    }

    public function getDashboard(){
	 	$this->layout->content = View::make('admin.index');
	 	return $this->layout->content;
    }

    //extra url parameters that can be passed in a routed controller
	public function getCms($id , $action , $subaction=null ){
		if($subaction==null)
			$this->layout->content = View::make('admin.cms_'.$action)->with('data' , Cms::all());
		else
			$this->layout->content = View::make('admin.'.$subaction)->with('data' , $subaction::all());		
		return $this->layout;
	}
	public function getView($model){
			$this->layout->content = View::make('admin.'.$model)->with('data' , $model::all());		
	}
	

	public function postDelete($model , $id){
		return $model::customDelete($id);
	}
	public function postCreate($model){
		return $model::customCreate();
	}
	public function postEdit($model){
		return $model::customEdit();
	}

	public function postReturn($model, $id=null , $key_row=null ){
		if($id!=null && $key_row!=null)
			$data = $model::where($key_row , '=' , $id)->first();
		else if($id!=null)
			$data = $model::find($id);
		else
			$data = $model::all();
		return Response::json($data);
	}
	public function getCalreturn($model, $id=null){	
		return Calendar::returnCal($model, $id=null);
	}
	public function postOnlineusers($model , $action){
		return $model::$action();
	}
	
	public function postReturncscategories($model , $id){
		return $model::csPageCategories($id);
	}

	public function postSinglerowedit($model){
		$data  = $model::where(Input::get('key') , '=' , Input::get('id'))->update(array(Input::get('db_row')=>Input::get('value')));
		if($data)
			return "Succesful data edit";
		return 'OOps!! Something went the wrong way!';
	}
	public function postModifyuserpwd($model){
		return User::modifyLoggedPass($model);
	
	}
	public function getSearch($model){
		$qry  = Input::get('name_startsWith');
		return Cms::searchQuery($qry);
	}
	
	public function getWebservice($model){
		return Webservices::returnFeed($model);
	}
	
	public function postGalleryreturn($model , $id=null){
		
		if($id!=null){
			$gal_id = Cmsgallery::where('cms_id' , '=' , $id)->first()->gal_id;
			$data = Gallery::getGalleryObjects($gal_id);
		}else{	
			$data = '<li>
					<span class="thumbnail"><img src="/admin/example/cyan_hawk.jpg" alt=""></span>
					<span class="mws-gallery-overlay">
							<a href="/admin/example/cyan_hawk.jpg" rel="prettyPhoto[gallery1]" class="mws-gallery-btn"><i class="icon-search"></i></a>
							<a href="#" class="mws-gallery-btn"><i class="icon-trash"></i></a>
					</span>
				</li>';
			$count  = rand(2,4);
			for($i=0;$i<$count;$i++)
				$data .= $data;
		}
			return Response::make($data);
	}

	public function postFileupld($action){
		if($action=="upload"){	
			Gallery::uploadObject();
		}
	}
	
    public function missingMethod($parameters){
	    return 'Ooops!Something went wrong!!Be a dear and try that again';
	}
}