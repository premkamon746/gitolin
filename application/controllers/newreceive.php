<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class NewReceive extends CI_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( "student_db" );
		$this->load->model ( "sms_db" );
		$this->load->model ( "trx_db" );
		$this->load->library ( "sms" );
		$this->load->library ( "trx" );
	}
	function index() {
		//if ($post = $this->input->post ()) 		// e1
		{
			// $battery_status = $post ["battery_status"];
			// $blue_toothdata = $post ["blue_toothdata"];
			// $gps_location = $post ["gps_location"];
			// $battery_lev = $post ["battery_lev"];
			// $dvid = $post ["device_id"];
			// $distance = $post ["distance"];
			// $bl_battery= $post ["bl_battery"];

			//log_message('debug', 'bl_battery  ' .$bl_battery);
			$gps_location = "13.809997052624956,100.68764973101804"; //school
			//$gps_location = "13.7698775,100.56820960000005"; //home
			
			list($device_lat ,$device_ln) = explode(",",$gps_location);
			$battery_status = "2";
			$battery_lev = 100;
			$blue_toothdata = "";
			$blue_toothdata = "DD:A1:3F:9A:EB:F9|DA:52:33:ED:50:CA|";
			//$blue_toothdata = "";
			$dvid = "fba7a8969b868032";
			$distance = "";
			$bl_battery ="90|90";
			
			
			list ( $div_lat, $div_lng ) = explode ( ",", $gps_location );
			$l = $this->trx;
			$l->saveLog ( $battery_status, $blue_toothdata, $gps_location, $battery_lev, $dvid, $distance,$bl_battery );
			$bts = array_filter ( explode ( "|", $blue_toothdata ) );
			$bt_bat_arr = array_filter ( explode ( "|", $bl_battery) );
			
			$goomap= "http://maps.google.co.th/maps?z=12&t=m&loc:".str_replace(",","+",$gps_location);
			//check battery low
			
			//โทรศัพอ่อน battery อ่อน
			$lev = $this->trx_db->getConfigValue("bat_low_level");
			if( $battery_lev <  $lev && !$l->hasSend("","bat_low_level",300)){ // 300 คือ เตือนทุก ๆ 5 ชั่วโมง
				//echo "ttttttt";
				if($this->trx_db->getConfigValue("bat_low_level_enable") ==1  ){
					
					$msg = $this->trx_db->getConfigValue("mob_low_battery");
					$message = "$msg ({$battery_lev}%) ";
					$this->sendSMSLowBatt($message,"bat_low_level",$dvid);
				}
			}
			
			
			// แบ็ต bluetooth อ่อน
			$i = 0;
			foreach($bts as $btx){
						$message ="mprison";
						$status="mprison";
						
						$bt_low_config = $this->trx_db->getConfigValue("bt_low_bat");
						if (intval($bt_bat_arr[$i]) < intval($bt_low_config)) {
							
							if(!$l->hasSend($btx,"low_bl_bat",1440)){ //1440 นาที = 1 วัน แจ้งเตือนครัง
								
								$contact_number = $l->getDeviceInfo($dvid);
								$msg = $this->trx_db->getConfigValue("bl_low_battery");
								$message = $msg;
								$status = "low_bl_bat";
								$this->sendSMS ( $btx, $message, $status );
							}
						}
						$i++;
			}
			
			
			// ติดในรถ
			foreach($bts as $btx){
				if($battery_status == "0" ){// ไม่ได้เสียบที่ชาร์ต
					if($l->isEnableConfig('mprison') ==1){
// 							&& $this->onTime($btmac,'freq_mprison','mprison',$trx_id) //ได้เวลาส่ง sms หรือยัง
// 							&& !$this->isLimitSend($btmac,'time_alarm_mprison',"mprison",$trx_id) //ครบจำนวนครั้งที่ต้องส่งหรือยัง
// 							&& !$this->nearByHome($btmac ,$device_lat ,$device_ln)){
						if($l->checkNumberOfSend($dvid, $btx,"mprison",'time_alarm_mprison')){ //ถึงเวลาส่ง และครบตามกำหนดหรือไม่
							
							if ($this->trx_db->exitsFromTrx ( $btx )) {
								$contact_number = $l->getDeviceInfo($dvid);
								
								$msg = $this->trx_db->getConfigValue("impress_msg");
								$message = "$msg Contact : $contact_number local : $goomap";
								$status = "mprison";
								
								$this->sendSMS ( $btx, $message, $status );
							}
							//$this->sendSMS ( $btx, $message, $status );
						}
					}	
				}
			}
			
			
			
			foreach ( $bts as $bt ) { // for ex1
				$nearHome = $l->nearByHome ( $bt, $div_lat, $div_lng );
				$nearSchool = $l->nearBySchool ( $bt, $div_lat, $div_lng );
				
				if ($nearHome || $nearSchool) { // home school
				                               // ออกจาก xxx
					$live_cout = $this->trx_db->getLiveCountFormTemp ( $bt );
					
					if ($live_cout >= 3) { //แสกนพบ 3 ครั้ง ถือว่าลงทะเบียน
						$exitsOnRegisTable = $this->trx_db->inRegisTable ( $bt );
						if (! $exitsOnRegisTable) { // has in transcetion table or stay in the car
						                         // register
						                         // send sms
						    if($battery_status !=0){ //เริ่ม register ตอนติดเครื่อง
								$this->trx_db->register2 ( $dvid, $bt, $div_lat, $div_lng );
								$this->trx_db->removeFromTemp ( $bt );
						    }
						    //คือลูกค้าอยากให้ส่ง sms ตอนนที่ scan เจอเลย
						    //แต่ที่ต้องรอให้รถติดก่อนถึงจะ register เพราะต้องการเช็ค event ติดในรถ
						   
						    if( !$l->hasSend($bt,"register",60)){ //เคยส่งไปในระยะเวลา 1 ชั่วโมง (60 = 60 นาที)
						    	$msg = $this->trx_db->getConfigValue("register_msg");
								$message = "$msg : $goomap";
								$status = "register";
								$this->sendSMS ( $bt, $message, $status );
						    }
						} else {
							// update live count = 3
						}
					} else {
						if (! $this->trx_db->exitsFromTemp ( $bt )) {
							echo "register $bt";
							$this->trx_db->registerTemp ( $dvid, $bt, $div_lat, $div_lng );
						} else {
							$this->trx_db->updateStatusTemp ( $bt, $live_cout ); //update live scount
						}
					}
					/* if($nearHome || $nearSchool ) */
				}
			} // for ex1
			
			$diff_bts = $l->getDiffDevice ( $bts, $dvid );
			foreach ( $diff_bts as $bt ) { // for ex1
				
				$live_cout = $this->trx_db->getLiveCount2 ( $bt );
				$this->trx_db->decreseLiveCount ($bt,$live_cout);
				if ($live_cout <= 0) {
					//$cnear = $l->nearByCurrentLocation($bt ,$device_lat ,$device_ln);
					//echo "cnear ==== $cnear";
					//if(!$cnear) { // ขึ้นลงที่เดิมไม่แจ้งเตือน
					$nearHome = $l->nearByHome ( $bt, $div_lat, $div_lng );
					$nearSchool = $l->nearBySchool ( $bt, $div_lat, $div_lng );
						if ($nearHome || $nearSchool) {
							
							$near_current = $l->nearByCurrentLocation($bt ,$device_lat ,$device_ln);
							$this->trx_db->unRegister ( $dvid, $bt );
							if(!$near_current){ // ถ้ามันหายไปที่เดียวกับมันขึ้น จะไม่แจ้งเตือน เพราะถือว่ามันอาจแค่ผ่านมาเฉย ๆ
								$msg = $this->trx_db->getConfigValue("out_msg");
								$message = "$msg : $goomap";
								$status="arrive";
								$this->sendSMS ( $bt, $message, $status );
							}
						} else {
							//echo "lose .....";
							
							if($l->checkNumberOfSend($dvid, $bt,"lose",'time_alarm_lose')){ //ถึงเวลาส่ง และครบตามกำหนดหรือไม่
								$msg = $this->trx_db->getConfigValue("lose_msg");
								$contact_number = $l->getDeviceInfo($dvid);
								$message = "$msg Contact : $contact_number local : $goomap";
								$status="lose";
								$this->sendSMS ( $bt, $message, $status );
							}
						}
// 					}else{
// 						$this->trx_db->unRegister ( $dvid, $bt );
// 					}// end cnear
				}
			}

		} // e1
	}
	function sendSMS($bt, $message, $status) {
		$result = $this->student_db->getInfoByMacAdrOne ( $bt );
		if ($result->num_rows () > 0) {
			if ($r = $result->row ()) {
				$name = $r->firstname;
				$tel = $r->contact_number;
				$msg = $message;
				$this->sms->send ( $tel, $msg );
				$this->sms_db->save ( $bt, $msg, $status, "" );
			}
		}
	}


	function notisms(){
		$num = $this->db->get_where("phone",array("id"=>1))->row()->phone;
		echo $this->sms->send ( $num, "to school" );
	}

	function setnumber($num){
		$this->db->where('id', 1);
		$this->db->update("phone",array("phone"=>"$num"));
	}
	
	//ใช้วส่งกรณีแบ็ตเตอรี่ต่ำ
	function sendSMSLowBatt($message,$status,$device_id){
		$result = $this->db->get_where("host_device",array("device_id"=>"$device_id"));
	
		if($result->num_rows() > 0){
			$res = $result->row();
			$tel = $res->contact_number;
			$this->sms->send($tel, $message);
			$trx_id= $device_id.date("Y-m-d-A");
			$this->sms_db->save("", $message,$status,$trx_id);
		}
	}
	
	function thaisms(){
		//$this->sms->send("0955433238", "ทดสอบ");
	}
}