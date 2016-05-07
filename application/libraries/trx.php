<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

	
	class TRX{
		
		public  $CI;
		
		function __construct(){
			 $this->CI =& get_instance();
			$this->CI->load->model("student_db");
			$this->CI->load->model("sms_db");
			$this->CI->load->model("trx_db");
		}
		
		//work fine.
		function nearByHome($blue_mac ,$device_lat ,$device_ln){
			//error_school_distanc
			$disnt = $this->CI->trx_db->getConfigValue('error_school_distanc');
			$r = $this->getHomeLoc($blue_mac);
			if(!isset($r->lat)) return false;
			$len = $this->distance($r->lat, $r->lng,  $device_lat, $device_ln,"K");
			//echo $len;
			if( $len <= $disnt/1000 ){
				return true;
			}
			return false;
		}
		
		function nearBySchool($blue_mac ,$device_lat ,$device_ln){
			//error_home_distanc
			$disnt =  $this->CI->trx_db->getConfigValue('error_school_distanc');
			$r =$this->getSchoolLoc($blue_mac);
			if(!$r){ return false;}
				
			$len = $this->distance($r->lat, $r->lng, $device_lat, $device_ln,"K");
			//echo $disnt;
			if( $len <= $disnt/1000 ){
				//echo "xxxxxx".$len."xxxxxx";
				return true;
			}
			return false;
		}
		
		function nearByCurrentLocation($bt ,$device_lat ,$device_ln){
			//error_home_distanc
			$disnt =  $this->CI->trx_db->getConfigValue('error_school_distanc');
			$loc = $this->CI->trx_db->getCurrentLocation($bt);
			$len = $this->distance($loc->lat , $loc->lng , $device_lat, $device_ln,"K");
			//echo $disnt;
			if( $len <= $disnt/1000 ){
				//echo "xxxxxx".$len."xxxxxx";
				return true;
			}
			return false;
		}
		
		function getHomeLoc($blue_mac){
			$result = $this->CI->db->get_where('student',array("macaddr"=>$blue_mac));
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
		
			$result =  $this->CI->db->query($sql);
			if( $result->num_rows() > 0 ){
			return $result->row();
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
		
		function getDiffDevice($bts, $device_id){
			$result = $this->CI->trx_db->getByDivcId($device_id);
			$diff = array();
			
			if($result->num_rows() > 0){
				$mac= array();
				foreach ($result->result() as $m){
					$mac[] = $m->client_mac_address;
				}
				$diff=array_diff($mac,$bts); //macaddress ที่ส่งมา  ต่างกับที่อยู่ใน trx หรือไม่
				return $diff;
			}
			return $diff;
		}
		
		//การแจ้งเตือนหายไปจากรถ
		function checkNumberOfSend($dvid, $bt,$type,$config=""){
			$times_lost = $this->CI->trx_db->getConfigValue($config);
			$time_count = (5* $times_lost)+120; //5 นาที * จำนวนครั้ง + /ชั่วโมง
			echo $times_lost;
			$time_send = $this->CI->trx_db->countSmsTransectionSend($type,$bt,$time_count);
			//echo "time_send ".$time_send;
			if($time_send==0) return true;
			if($time_send > $times_lost)
			{
				$this->CI->trx_db->unRegister($dvid, $bt ); //ถ้าส่งมากกว่า ครั้งที่กำหนดแล้ว ลบออกจาก reigister เลย เพราถ้าไม่ลบมันจะกลายเป็นว่าเด็กติดใตรถ
				return false;
			}
			$time_send = 5*$time_send;// 5 นาที * จำนวนครั้งที่ส่งไปแล้ว
			$sql = "select * from sms_trx where student_mac_addr = '$bt' 
						having  MAX(create_date)  < DATE_SUB(NOW(),INTERVAL 5 MINUTE)";
			
			$result = $this->CI->db->query($sql);
			if($result->num_rows() > 0){
				return true;
			}
			return false;
		}
		
		function hasSend($str_mac,$type,$minute_config)
		{
			$sql ="SELECT * FROM `sms_trx` WHERE student_mac_addr='$str_mac'  and type='$type' 
					having  MAX(create_date)  > DATE_SUB(NOW(),INTERVAL $minute_config MINUTE)";
			//echo $sql;
			$result = $this->CI->db->query($sql);
			if( $result->num_rows() >0){ //ถ้าไม่พบแสดงว่าเพิ่งส่งไป
				return true;
			}
			return false;
		}
		
		function isEnableConfig($type){
			$result = $this->CI->db->get_where("setting",array('field_name'=>$type));
			if($result->num_rows() > 0){
				return $result->row()->value == 1?true:false;
			}
			return false;
		}
		
		function getDeviceInfo($device_id){
			$sql = "select * from host_device where device_id = '$device_id' ";
			$result = $this->CI->db->query($sql);
			if($result->num_rows() > 0){
				return $result->row()->contact_number;
			}
			return "";
		}
		
		function saveLog($battery_status,$blue_toothdata,$gps_location,$battery_lev,$device_id,$distance,$bl_battery){
			$data = array(
					"battery_status"=>$battery_status
					,"blue_toothdata"=>$blue_toothdata
					,"gps_location"=>$gps_location
					,"battery_lev"=>$battery_lev
					,"device_id"=>$device_id
					,"distance"=>$distance
					,"bt_battery"=>$bl_battery
			);
			
			
			$this->CI->db->set('create_date', 'NOW()', FALSE);
			$this->CI->db->insert("receive_log",$data);
		}
		
		
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

	}
	
	

?>