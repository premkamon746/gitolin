



<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class new extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model("student_db");
		$this->load->model("sms_db");
		$this->load->model("trx_db");
		$this->load->library("sms");
	}
	
	function saveLog($battery_status,$blue_toothdata,$gps_location,$battery_lev,$device_id,$distance){
		$data = array(
					"battery_status"=>$battery_status
					,"blue_toothdata"=>$blue_toothdata
					,"gps_location"=>$gps_location
					,"battery_lev"=>$battery_lev
					,"device_id"=>$device_id
					,"distance"=>$distance
				);
		$this->db->set('create_date', 'NOW()', FALSE);
		$this->db->insert("receive_log",$data);
	}
	
	public function index()
	{
		//log_message('debug', serialize($this->input->post()));

		
		
 		if($post = $this->input->post())
		{
			$battery_status = $post["battery_status"];
			$blue_toothdata = $post["blue_toothdata"];
			$gps_location = $post["gps_location"];
			$battery_lev = $post["battery_lev"];
			$device_id = $post["device_id"];
			$distance = $post["distance"];
			list($device_lat ,$device_ln) = explode(",",$gps_location);
			
			$this->saveLog($battery_status,$blue_toothdata,$gps_location,$battery_lev,$device_id,$distance);
			
// 			$gps_location = "13.8818059,100.416965";
// 			//$gps_location = "13.95656674543625,98.97366001230466";
// 			list($device_lat ,$device_ln) = explode(",",$gps_location);
// 			$battery_status = "2";
// 			$battery_lev = 10;
// 			$blue_toothdata = "";
// 			//$blue_toothdata = "DD:A1:3F:9A:EB:F9|CB:AD:2B:B0:D7:11|";
// 			$device_id = "fba7a8969b868032";

			$blue_mac_x = array_filter(explode("|",$blue_toothdata));
			$trx_id = $device_id.date("Y-m-d-A");
			$gps_location = "http://maps.google.co.th/maps?z=12&t=m&loc:".str_replace(",","+",$gps_location);
			//check battery low
			$lev = $this->getConfigValue("bat_low_level");
			
			if( $battery_lev <  $lev && !$this->hasSend("","bat_low_level",$trx_id)){
			//echo "ttttttt";
				if($this->getConfigValue("bat_low_level_enable") ==1  ){
					$message = "Message : batery low ({$battery_lev}%) : $gps_location";
					$this->sendSMS2($message,"bat_low_level",$device_id);
				}
			}
			
			
			
			
			foreach($blue_mac_x as $btmac){
				
				if($battery_status == "0" ){

					if($this->isEnableConfig('mprison') ==1
							&& $this->onTime($btmac,'freq_mprison','mprison',$trx_id) //ได้เวลาส่ง sms หรือยัง
							&& !$this->isLimitSend($btmac,'time_alarm_mprison',"mprison",$trx_id) //ครบจำนวนครั้งที่ต้องส่งหรือยัง
							&& !$this->nearByHome($btmac ,$device_lat ,$device_ln)){

						$contact_number = $this->getDeviceInfo($device_id);
						$message = "Warning : Your child still live in the car. Contact : $contact_number local : $gps_location";
						$this->sendSMS($btmac, $message,"mprison",$device_id);
					}
					
				}
				
				//out home in the morning
				//scan not found and near home
				//ออกจากบ้าน
				if($this->nearByHome($btmac ,$device_lat ,$device_ln)){
					echo "near";
				}
				
				if( $this->nearByHome($btmac ,$device_lat ,$device_ln)
						&& date("A") =="AM"
						&&!$this->hasSend($btmac,"outhome",$trx_id)
				){
					if($this->getConfigValue("outhome") ==1){
						$message = "Message : Your child out home. local : $gps_location";
						$this->sendSMS($btmac, $message,"outhome",$device_id);
					}
				}
				
				
				//out school send sms evining
				//scan found  && car start && near by school && evining
				//ออกจากโรงเรียน
				//echo "xxx";
				
				if(/*$this->distanceSchoolRegister($device_id ,$device_lat ,$device_ln)
				&&*/
				
				date("A") =="PM"
						&&!$this->hasSend($btmac,"outschool",$trx_id)
						){
				
					if($this->getConfigValue("outschool") ==1   ){
						$message = "Message : Your child out school local : $gps_location";
						$this->sendSMS($btmac, $message,"outschool",$device_id);
					}
				}
				
			}
			
		
			//if($battery_status != "0"){
				$trx_id = $device_id.date("Y-m-d-A");
				//$trx_id = $device_id.date("Y-m-d")."-AM";
				$result = $this->trx_db->getByTrxId($trx_id);
				
				
				
				
				log_message('debug', "numrow : ".$result->num_rows());
					
				if($result->num_rows() > 0){
					$mac= array();
					foreach ($result->result() as $m){
						$mac[] = $m->client_mac_address;
						$blue_mac = $m->client_mac_address;
						//count($blue_mac) > 0 ยัง scan เจออยู่ เครื่องดีบแต่ยังหาเจอ
						
							
						//arrive school send sms morning
						//near by school && car stop
						//ถึงโรงเรียน
						
						
						if($this->nearBySchool($blue_mac ,$device_lat ,$device_ln) 
								&& date("A") =="AM"
									&&!$this->hasSend($blue_mac,"arrive",$trx_id) ){
								
							if($this->getConfigValue("arrive") ==1  ){
								$message = "Message : Your child arrive school. local : $gps_location";
								$this->sendSMS($blue_mac, $message,"arrive",$device_id);
							}
						}
						
						
						
						
					
					}
					
					
					$diff=array_diff($mac,$blue_mac_x); //macaddress ที่ส่งมา  ต่างกับที่อยู่ใน trx หรือไม่
					
					
					
					if(count($diff) > 0 ){
						
						foreach ($diff as $d) {
							$live_cout = $this->trx_db->getLiveCount($trx_id,$d);
							if($live_cout > 0){ //ถ้าแสกนสามครั้งไม่เจอ
								$this->trx_db->updateStatus($trx_id,$d,$live_cout);
							}else{
								
								//วนส่งตามจำนวนนักเรียน
								foreach ($diff as $btmac){
									//หายจากร๔
									if($this->isLimitSend($btmac,'time_alarm_lose',"lose",$trx_id)){
										echo "not limit";
									}
									if($this->isEnableConfig('lose') ==1
											&& $this->onTime($btmac,'freq_lose','disappear',$trx_id) //ได้เวลาส่ง sms หรือยัง
											&& !$this->isLimitSend($btmac,'time_alarm_lose',"disappear",$trx_id) //ครบจำนวนครั้งที่ต้องส่งหรือยัง 
											&& !$this->nearByHome($btmac ,$device_lat ,$device_ln)){
												$contact_number = $this->getDeviceInfo($device_id);
												$message = "Warning : Your child disappear from the car. Contact : $contact_number local : $gps_location";
												$this->sendSMS($btmac, $message,"disappear",$device_id);
									}
									
									
									//arrive home
									//scan not found && near home && evining
									//กลับถึงบ้าน
									
									if($this->nearByHome($btmac ,$device_lat ,$device_ln) 
											&& date("A") =="PM" 
											&&!$this->hasSend($btmac,"backhome",$trx_id)){
											
										if($this->getConfigValue("backhome") ==1 ){
											$message = "Message : Your child arrive home. local : $gps_location";
											$this->sendSMS($btmac, $message,"backhome",$device_id);
										}
									}
								}
							}
						}
					}else{
						$this->trx_db->returnTimeLive($trx_id);
					}
				}else{
					
					if(date("A")=="AM"){
						if(isset($blue_mac_x[0])){
							if($this->distanceHomeRegister($blue_mac_x[0] ,$device_lat ,$device_ln)){
								$this->trx_db->register($trx_id,$device_id,$blue_mac_x);
							}
						}
					}else{
						//ขาลงทำเบียน เมื่อขับรถออกจากโรงเรียน
						if($this->distanceSchoolRegister($device_id ,$device_lat ,$device_ln)){
							$this->trx_db->register($trx_id,$device_id,$blue_mac_x);
						}
					}
					
				}
			//}
			
			
			//log_message('debug', "count : "+count($blue_mac));
			
			//battery_status = 0 รถดับเครื่อง
			
		}
		
	}
	
// 	function sendSMS($blue_mac, $message,$status,$device_id){
// 		$result = $this->student_db->getInfoByMacAdr($blue_mac);
// 		if($result->num_rows() > 0){
// 			foreach ($result->result() as $r){
// 				$name = $r->firstname;
// 				$tel = $r->contact_number;
// 				$msg = $message;
// 				$this->sms->send($tel, $msg);
// 				$trx_id= $device_id.date("Y-m-d-A");
// 				$this->sms_db->save($blue_mac, $msg,$status,$trx_id);
// 			}
// 		}
// 	}

	function sendSMS($blue_mac, $message,$status,$device_id){

		
		$result = $this->student_db->getInfoByMacAdrOne($blue_mac);
		
		if($result->num_rows() > 0){
			foreach ($result->result() as $r){
				$name = $r->firstname;
				$tel = $r->contact_number;
				$msg = $message;
				$this->sms->send($tel, $msg);
				$trx_id= $device_id.date("Y-m-d-A");
				$this->sms_db->save($blue_mac, $msg,$status,$trx_id);
			}
		}
	}
	
	

	
	
	
	//work 
	function distance($lat1, $lon1, $lat2, $lon2, $unit) {
		
		  $theta = $lon1 - $lon2;
		  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		  $dist = acos($dist);
		  $dist = rad2deg($dist);
		  $miles = $dist * 60 * 1.1515;
		  $unit = strtoupper($unit);
		
		  if ($unit == "K") {
		  		return ($miles * 1.609344);
		  } else if ($unit == "N") {
		 		return ($miles * 0.8684);
		  } else {
		   		return $miles;
		   }
		}
		
		
		//work
		function isEnableConfig($type){
			$result = $this->db->get_where("setting",array('field_name'=>$type));
			if($result->num_rows() > 0){
				return $result->row()->value == 1?true:false;
			}
			return false;
		}
				
		
		function testmodule(){
		
			$trx_id= "fba7a8969b868032".date("Y-m-d-A");
			$blue_mac = "DD:A1:3F:9A:EB:F9";
			$device_lat= "13.95656674543625";
			$device_ln = "98.97366001230466";
			if($this->hasSend($blue_mac,$type,$trx_id)){
				echo "ok";
			}
		
		}
		
		//เช็คว่าถึงรอบเวลาที่ต้องส่ง sms หรือยัง
		//ถ้าเโทรศัพม์ ส่งข้อมูลข้ามาแล้วไม่พบ record ใน trx send แปลว่า ถึงเวลาต้องส่ง
		function onTime($str_mac,$time_type,$type,$trx_id){ //freq_lose
			$time_munite = $this->getConfigValue($time_type);
			$sql ="SELECT * FROM `sms_trx` WHERE 
						 	now() < date_add(create_date, interval $time_munite MINUTE) 
							and student_mac_addr='$str_mac'  and type='$type' and transection_id = '$trx_id' ";
			//echo $sql;
			$result = $this->db->query($sql);
			if($result->num_rows() > 0){
				return false;
			}else{
				return true;
			}
			
		}
		
		
		//work เช็คว่า ส่งครบตามจำนวนรอบหรือยัง
		function isLimitSend($str_mac,$time_type,$type,$trx_id)
		{//'time_alarm_lose'
			
			$times= $this->getConfigValue($time_type);
			$time_munite = $this->getConfigValue($type);
			$total_time = $time_munite * $times;   //time = ครั้ง
			
			$sql ="SELECT * FROM `sms_trx` WHERE
						now() >= date_add(create_date, interval $times MINUTE)
						and student_mac_addr='$str_mac'  and type='$type' and transection_id = '$trx_id'";
			//echo $sql;
			$result = $this->db->query($sql);
			if( $result->num_rows() > $times ){
				return true;
			}else{
				return false;
			}
		}
		
		
		//เคยส่ง sms แล้วหรือยัง
		function hasSend($str_mac,$type,$trx_id)
		{
			$sql ="SELECT * FROM `sms_trx` WHERE student_mac_addr='$str_mac'  and type='$type' and transection_id = '$trx_id'";
		
			$result = $this->db->query($sql);
			if( $result->num_rows() ){
				return true;
			}else{
				return false;
			}
		}
		
		//work fine.
		function nearByHome($blue_mac ,$device_lat ,$device_ln){
			//error_school_distanc 
			$disnt = $this->getConfigValue('error_school_distanc');
			$r = $this->getHomeLoc($blue_mac);
			if(!isset($r->lat)) return false;
			$len = $this->distance($r->lat, $r->lng,  $device_lat, $device_ln,"K");
			//echo $len;
			if( $len <= $disnt/1000 ){
				return true;
			}
			return false;
		}
		
		//work
		function nearBySchool($blue_mac ,$device_lat ,$device_ln){
			//error_home_distanc
			$disnt = $this->getConfigValue('error_school_distanc');
			$r =$this->getSchoolLoc($blue_mac);
			if(!$r){ return false;}
			
			$len = $this->distance($r->lat, $r->lng, $device_lat, $device_ln,"K");
			echo $disnt;
			if( $len <= $disnt/1000 ){
				echo "xxxxxx".$len."xxxxxx";
				return true;
			}
			return false;
		}
		
		
		
		function getConfigValue($type){
			$result = $this->db->get_where("setting",array('field_name'=>$type));
			if($result->num_rows() > 0){
				return $result->row()->value;
			}
			return false;
		}
		
		function getHomeLoc($blue_mac){
			$result = $this->db->get_where('student',array("macaddr"=>$blue_mac));
			if( $result->num_rows() > 0 ){
				return $result->row();
			}
			return false;
		}
		
		function getSchoolLoc($blue_mac){
			
			$sql = "select sc.lat lat,sc.lng lng from school sc 
					   join student st
					   on st.school_id = sc.id
						where st.macaddr = '$blue_mac' ";
	
			$result = $this->db->query($sql);
			if( $result->num_rows() > 0 ){
				return $result->row();
			}
			return false;
		}
		
		
		//work
		function distanceSchoolRegister($device_id ,$device_lat ,$device_ln){
			//error_home_distanc
			
			$disnt = $this->getConfigValue('distance_out_school');
			//echo $device_id;
			$r =$this->getSchoolLocByDeviceId($device_id);
			//print_r($r);
			if(!$r){ return false;}
		
			$len = $this->distance($r->lat, $r->lng, $device_lat, $device_ln,"K");
			//echo $len;
			if( $len > $disnt/1000 ){
				return true;
			}
			return false;
		}
		
		
		
		
		function getSchoolLocByDeviceId($device_id){
				
			$sql = "select sc.lat lat,sc.lng lng from school sc
			join host_device hd
			on hd.school_id = sc.id
			where hd.device_id = '$device_id' ";
			//echo $sql;
			$result = $this->db->query($sql);
			if( $result->num_rows() > 0 ){
			return $result->row();
			}
			return false;
		}
		
		
		
		function distanceHomeRegister($blue_mac ,$device_lat ,$device_ln){
			//error_school_distanc
			$disnt = $this->getConfigValue('distance_out_home');
			$r = $this->getHomeLoc($blue_mac);
			if(!isset($r->lat)) return false;
			$len = $this->distance($r->lat, $r->lng,  $device_lat, $device_ln,"K");
				//echo $len;
			if( $len > $disnt/1000 ){
				return true;
			}
			return false;
		}
		
		function getDeviceInfo($device_id){
			$sql = "select * from host_device where device_id = '$device_id' ";
			$result = $this->db->query($sql);
			if($result->num_rows() > 0){
				return $result->row()->contact_number;
			}
			return "";
		}
		
		
			
		
// echo distance(32.9697, -96.80322, 29.46786, -98.53506, "M") . " Miles<br>";
// echo distance(32.9697, -96.80322, 29.46786, -98.53506, "K") . " Kilometers<br>";
// echo distance(32.9697, -96.80322, 29.46786, -98.53506, "N") . " Nautical Miles<br>";
	
}


