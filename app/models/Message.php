<?php
require_once('recaptchalib.php'); // reCAPTCHA Library

class Message extends Eloquent  {
	public $rules = array('name'=> array('required', 'min:3') , 
						  'email' =>array('required' , 'email'),
						  'message'=> array('required', 'min:10')
						  );
	


	public static function sendMail(){
		// the data that will be passed into the mail view blade template
		$data = array(
			'name'      => Input::get('name'),
			'email'     => Input::get('email'),
			'content'   => Input::get('message'),
			'ip'        => getenv("REMOTE_ADDR")
		);
		$email = 'apps@heuristic-web.com';
		Mail::send('emails.message', $data, function ($message) use ($email) {
			$message->subject('Message Subject');
			$message->from('apps@heuristic-web.com', 'Panos');
			$message->to($email); // Recipient address
		});
	}
	
	public static function setMailData(){
		$privkey = "6Lep7-USAAAAAEOQLp7PYp321fM8MBb2qv9ogPCX"; // Private API Key
		$verify = recaptcha_check_answer($privkey, $_SERVER['REMOTE_ADDR'], $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field']);		
		if ($verify->is_valid) {
		  # Enter Success Code
		}
		else {
		  # Enter Failure Code
		  return "You did not enter the correct words.  Please try again.";
		}
	
	
		$msg        = new Message();
		$data       = Input::except('_token' , 'recaptcha_challenge_field' , 'recaptcha_response_field');
		foreach($data as $key=>$val){
			$msg->$key = $val;
		}
		$msg->is_read = 0;
		$msg->save();
	}
	
	
	public static function customDelete($id){
		Message::find($id)->delete();
		return 'Successful delete of message with id '.$id .'!';
	}
	
	public static function setUnreadClass($msg_id , $input_id){
		if($input_id==$msg_id){	
			echo 'style="background-color:yellow!important"';
		}
	}
	public static function getUnreadMsgCount(){
		return Message::where('is_read' , '=' , 0)->count();
	}
	public static function getUnreadMsgs(){
		return Message::where('is_read' , '=' , 0)->get();
	}
	public static function viewedMessagePercentage(){
		$total    = Message::all()->count();
		$read     = Message::where('is_read' , '=' , 1)->count();
		
		return $read/$total*100;
	}

	public static function getMessageUpdates(){
		$msgCount = Message::getUnreadMsgCount();
		$messageFormat ='';
		foreach(Message::getUnreadMsgs() as $msg){
			$messageFormat .= '<li class="read"><a href="/administrator/view/Message?message_by_id='.$msg->id.'" ><span class="sender">'.$msg->name.'</span><span class="message">'.$msg->message.'</span><span class="time">'.$msg->created_at.'</span><span class="time">'.$msg->email.'</span></a></li>';
		}
		$data = array();
		$data[] = $msgCount;
		$data[] = $messageFormat;
		$data[] = number_format(Message::viewedMessagePercentage(), 2, '.', '');
		
		return $data;
	}
	public static function getNotificationUpdates(){
		$counter = 0;
		$notifcount = User::getNumberOfNotifications();
		$responseList = '';
		
		foreach(User::all() as $usr){
			if($usr->is_banned>0){
				$counter++;
				$responseList .= '<li class="unread"><a href="/administrator/view/Blacklistip?user_id='.$usr->id.'"><span class="message"><span class="badge badge-warning">Ban of User:</span>'.$usr->username.'</span><span class="time">Date of Ban : '.$usr->updated_at.'</span></a></li>';
			}
		}
		foreach(Blacklistip::all() as $ip){
			if($ip->counter>8){
				$counter++;
				$responseList .= '<li class="unread"><a href="/administrator/view/Blacklistip?ip_id='.$ip->id.'"><span class="message"><span class="badge badge-warning">Ban of I.P:</span> '.$ip->ip.'</span><span class="time">Date of Ban : '.$ip->updated_at.'</span></a></li>';
			}
		}
		if($counter==0){
			 $responseList .= '<div class="mws-dropdown-viewall"><a href="#">No notifications as of yet.</a></div>';
		}
		
		$data[0] = $notifcount;
		$data[1] = $responseList;
		return $data;
	}












}