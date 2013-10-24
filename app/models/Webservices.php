<?php


class Webservices extends Eloquent  {
	public $timestamps = false;
	protected $table = 'webservice_models';
		public $rules = array('model'=> array('required' , 'min:3'));
	 
	 public static function returnFeed($model){
		//Uri parameters $id, $limit, $offset , $xml_json
		$enabled    = Setting::find(1)->is_activated;
		$id        = Input::get('id');
		$limit     = Input::get('limit');
		$offset    = Input::get('offset');
		$xml_json  = Input::get('xml_json');
		if(Webservices::where('model', '=' , $model)->count()==0)
			return 'Not A valid webservice model';
		
		if($enabled==1){
		
			if($id==null){
				$data = $model::retrievewebservicefeed($limit, $offset);
				
			}else{
				$data = $model::find($id)->first();
				
			}
			if($xml_json=='json')
				return Response::json($data);
			else{
					
			}

				
		}
			
			
	 }
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 }
	 
	 class XML {
 
        /**
         *    Encode an object as XML string
         *    @param        Object $obj
         *    @param        string $root_node
         *    @return        string $xml
         */
        public function encodeObj($obj, $root_node = 'response') {
            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= self::encode($obj, $root_node, $depth = 0);
            return $xml;
        }
 
 
        /**
         *    Encode an object as XML string
         *    @param        Object|array $data
         *    @param        string $root_node        
         *    @param        int $depth                Used for indentation
         *    @return        string $xml
         */
        private function encode($data, $node, $depth) {
            $xml .= str_repeat("\t", $depth);
            $xml .= "<$node>\n";
            foreach($data as $key => $val) {
                if(is_array($val) || is_object($val)) {
                    $xml .= self::encode($val, $key, ($depth + 1));
                } else {
                    $xml .= str_repeat("\t", ($depth + 1));
                    $xml .= "<$key>" . htmlspecialchars($val) . "</$key>\n";
                }
            }
            $xml .= str_repeat("\t", $depth);
            $xml .= "</$node>\n";
            return $xml;
        }
    }