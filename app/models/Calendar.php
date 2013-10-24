<?php


class Calendar extends Eloquent  {
	public $timestamps = false;
	public $rules = array('title'=> array('required', 'min:4') , 'start' =>array('date_format:Y-m-d H:i:s'), 'end' =>array('date_format:Y-m-d H:i:s'), 'allDay' =>array('integer'));
	
	
	
	public static function returnCal($model, $id=null){
	
		if($id!=null){
			$data   = $model::find($id);
			$events = array();
			foreach($data as $key=>$val){
				$event = array();
				$event->$key = $val;			
			}
			$events[] = $event;
		}
		else{
			$data   = $model::all();
			$events = array();
			
			foreach($data as $dat){
				$event = array();
				foreach($dat as $key=>$val){
					$event[$key] = $val;				
				}
				$events[] = $event['attributes'];
			}
		}
		 return $events;
	}

	public static function customCreate(){
		$calData = Input::except('_token' , 'id');
		$cal     = new Calendar();
		foreach($calData as $k=>$v){
			if($k=="allDay"){
				$cal->$k = $v=="true"?1:0;
			}			
			elseif(  ($k=='start' || $k=='end') && $v!="" ){
				$cal->$k = Calendar::getSqlDate($v);
			}
			else{
				$cal->$k = $v;
			}
		}
		$cal->user_id = Auth::user()->id;
		$cal->save();
		return $cal->id;
	}	

	public static function customEdit(){
		$calData = Input::except('_token' , 'id');
		$cal     = Calendar::find(Input::get('id'));
		foreach($calData as $k=>$v){
			if($k=="allDay"){
				$cal->$k = $v==("true"||1)?1:0;
			}			
			elseif(  ($k=='start' || $k=='end') && $v!="" ){
				$cal->$k = Calendar::getSqlDate($v);
			}
			else{
				$cal->$k = $v;
			}	
		}
		$cal->user_id = Auth::user()->id;
		$cal->save();
		return Input::get('id');
	
	}
	public static function customDelete($id){
		Calendar::find($id)->delete();
		return $id;
	}
	public static function getSqlDate($strofdater){
		//date format to convert
		//Mon Jul 29 2013 00:00:00 GMT+0300 (GTB Daylight Time)
	
		$strofdate = explode(' ' , $strofdater);
		$hours     = explode(':' , $strofdate[4]);
		$year      = $strofdate[3];
		$month     = date('m', strtotime($strofdate[1]));
		$day       = $strofdate[2];
		$hour      = $hours[0];
		$min       = $hours[1];
		$sec       = $hours[2];
		$data     = $year .'-' .$month . '-' .$day . ' '. $hour. ':' .$min. ':'.$sec;
		return $data;
	}
	public static function getForthComing(){
		$data = DB::select(DB::raw("SELECT count(id) FROM `calendars` WHERE `start` >= DATE_SUB(NOW(), INTERVAL 7 DAY) limit 1" ));
		foreach($data[0] as $key=>$val)	
			return  $val;

	}
	
	public static function retrievewebservicefeed($limit, $offset){
		return Calendar::skip($offset)->take($limit)->orderBy('start', 'desc')->get();
	}
}