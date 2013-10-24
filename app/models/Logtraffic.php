<?php


class Logtraffic extends Eloquent  {
	public $rules = array('ip'=> array('required', 'regex:/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z$/'));
	protected $table = 'log_traffic';
	
	public static function record(){
		$obj = new Logtraffic();
		$obj->ip = getenv("REMOTE_ADDR");
		$obj->save();
	}
	public static function getLiveUsers(){
		$data = DB::select(DB::raw("SELECT count(distinct(ip)) FROM `log_traffic` WHERE `created_at` >= DATE_SUB(NOW(), INTERVAL 10 minute) limit 1" ));
		foreach($data[0] as $key=>$val)	
			return  $val;
	}
	
	public static function monthlyOverTotalPercentage(){
		$total     = Logtraffic::all()->count();
		$date      = date('Y-m');
		$monthy    = Logtraffic::where('created_at' , 'LIKE' , "%$date%")->count();	
		$percent   = 	number_format($monthy/$total, 2, '.', '');
		return     $percent*100 . '%';
	}
	public static function totalTraffic(){
		$total     = Logtraffic::all()->count();		
		return     $total;
	}
	
	public static function getCountViewsForMonth($model , $row_counter){
		/*$data = $model::where($row_counter ,  '<=' , 'DATE_SUB(NOW(), INTERVAL 1 month)')->orderBy($row_counter , 'asc')->get();
		$dataArray = array();
		$counter = 0;
		
		$date = explode(' ' ,$data[0]->$row_counter);
		$date = $date[0];
		$dataArray[$counter] = 0;
		
		foreach($data as $dat){
			if(strpos($dat->$row_counter , $date)!==false)
				$dataArray[$counter]++;
			else{
				$date = explode(' ' ,$dat->$row_counter);
				$date = $date[0];
				$counter++;
				$dataArray[$counter] = 0;
			}
		}
		$answer = array();
		for($i=1;$i<=31;$i++){
			if(isset($dataArray[$i-1])){
				$answer[31 - $i] = array(0 => $i , 1=>$dataArray[$i-1]);
			}else{
				$answer[31 - $i] = array(0 => $i , 1=>0);
			}
		}
		$data = array();
		for($i=0;$i<count($answer);$i++){
			$data[] = $answer[count($answer)-$i-1];
		}
		sort($answer);
		var_dump($data);
		return json_encode($data);*/
	
		$array       = array();
		for($i=1;$i<32;$i++){
			$j = $i;
			if($i<10) $i= '0'.$i;
			$date = Date('Y-m-'.$i);
			$counter = $model::where($row_counter , 'Like', "%$date%")->count();
			$array[]   = array(0 => $j , 1=>$counter);
							
		}
		return json_encode($array);
	}
	
	public static function plotTraffic(){
		$answer = array();
		$answer[] = Logtraffic::getCountViewsForMonth('Logtraffic' , 'updated_at');
		$answer[] = Logtraffic::getCountViewsForMonth('Loglogin' , 'updated_at');
		$answer[] = Logtraffic::getCountViewsForMonth('Calendar' , 'start');
		return $answer;
	}
	public static function getForthcoming(){
		$number = Calendar::getForthComing();
		return $number;
	}
	
	}