<?php
	class Trx_Db extends CI_Model{
	
		private $table = "scan_transection";
		function __construct(){
			parent::__construct();
		}
	
		
		function getByTrxId($trx_id){
			$query = $this->db->get_where($this->table,array("transection_id"=>"$trx_id"));
			return $query;
		}
		
		function updateStatus($trx_id,$client_mac_address,$live_cout){
			
				$data = array(
	               'live_cout' => $live_cout-1
	            );
	
				$this->db->where('client_mac_address', $client_mac_address);
				$this->db->where('transection_id', $trx_id);
				$this->db->update($this->table, $data); 
			
		}
		
		function getLiveCount($trx_id,$client_mac_address){
			$query = $this->db->get_where($this->table,
								array("transection_id"=>$trx_id
										,"client_mac_address"=>$client_mac_address)
						);
			
			if($query->num_rows() > 0){
				
				return intval($query->row()->live_cout);
			}
			return false;
		}
		
		function countAll(){
			return $this->db->count_all($this->table);
		}
		
		function save($message,$type){
			$this->db->set('create_date', 'now()',false);
			$this->db->set('msg', $message);
			$this->db->set('type', $type);
			$this->db->insert($this->table);
		}
	
		
		function trxIdExist($trx_id){
			$sql = "select * from $this->table where transection_id = '$trx_id'";
			$result = $this->db->query($sql);
			if($result->num_rows() > 0){
				return true;
			}
			return false;
		}
		
		function register($trx_id, $device_id, $mac_list){
				$data = array();
				foreach ($mac_list as $m){
					
					$data [] = array(
									"device_id"=>$device_id,
									"client_mac_address"=>$m,
									"create_date"=>date("Y-m-d H:i:s"),
									"transection_id"=>$trx_id,
									"live_cout"=>3
							);
									
					}
			if(count($data)>0)
				$this->db->insert_batch($this->table, $data);
		}
		
		function returnTimeLive($trx_id){
			$data = array(
					'live_cout' => 3
			);
			$this->db->where('transection_id', $trx_id);
			$this->db->update($this->table, $data);
		}
		
		 function getConfigValue($type){
			$result = $this->db->get_where("setting",array('field_name'=>$type));
			if($result->num_rows() > 0){
				return $result->row()->value;
			}
			return false;
		}
		
		
		function getCurrentLocation($bt){
			$sql = "select * from scan_transection where client_mac_address = '$bt' ";
			
			$result = $this->db->query($sql);
			if($result->num_rows() > 0){
				return $result->row();
			}
			return false;
			
		}
		
		function inRegisTable($bt){
				$sql = "select * from scan_transection where client_mac_address = '$bt' ";
				
				$result = $this->db->query($sql);
				if($result->num_rows() > 0){
					return true;
				}
				return false;
		}
		
		function unRegister($dvid, $bt ){
			$this->db->delete("temp_".$this->table, array('client_mac_address' => $bt ,"device_id"=>$dvid));
			$this->db->delete($this->table, array('client_mac_address' => $bt,"device_id"=>$dvid));
		}
		
		function countSmsTransectionSend($type,$bt,$time_count){
			$sql = "select count(*) row_count from sms_trx where  student_mac_addr = '$bt'
			and type = '$type'
			and create_date > DATE_SUB(NOW(),INTERVAL $time_count MINUTE)";
			$result = $this->db->query($sql);
			$around = 0;
			if($result->num_rows() >0){
				return $result->row()->row_count;
			}
			return 0;
		}
		
	
		
		function register2($dvid, $bt ,$lat ,$lng){
			$data  = array(
					"device_id"=>$dvid,
					"client_mac_address"=>$bt,
					"transection_id"=>"",
					"live_cout"=>3,
					"lat"=>$lat,
					"lng"=>$lng
			);
			$this->db->set('create_date', 'NOW()', FALSE);
			$this->db->insert($this->table, $data);
			//echo $this->db->last_query();
		}
		
		function registerTemp($dvid, $bt ,$lat ,$lng){
			
			$data  = array(
					"device_id"=>$dvid,
					"client_mac_address"=>$bt,
					"transection_id"=>"",
					"live_cout"=>0,
					"lat"=>$lat,
					"lng"=>$lng
			);
			$this->db->set('create_date', 'NOW()', FALSE);
			$this->db->insert("temp_".$this->table, $data);
			//echo $this->db->last_query();
		}
		
		function updateStatusTemp($bt,$live_cout){
				
			$data = array(
					'live_cout' => $live_cout+1
			);
		
			$this->db->where('client_mac_address', $bt);
			$this->db->update("temp_".$this->table, $data);
				
		}
		
		function exitsFromTemp($bt){
			$query = $this->db->get_where("temp_scan_transection",array("client_mac_address"=>"$bt"));
			
			if($query->num_rows() > 0){
				return true;
			}
			return false;
		}
		
		function exitsFromTrx($bt){
			$query = $this->db->get_where("scan_transection",array("client_mac_address"=>"$bt"));
				//echo $this->db->last_query();
			if($query->num_rows() > 0){
				return true;
			}
			return false;
		}
		
		function getLiveCount2($bt){
			$query = $this->db->get_where($this->table,
					array("client_mac_address"=>$bt)
			);
				
			if($query->num_rows() > 0){
		
				return intval($query->row()->live_cout);
			}
			return false;
		}
		
		function getLiveCountFormTemp($bt){
			$query = $this->db->get_where("temp_scan_transection",
					array("client_mac_address"=>$bt)
			);
			
			//echo $this->db->last_query();;
			if($query->num_rows() > 0){
				return intval($query->row()->live_cout);
			}
			return false;
		}
		
		function removeFromTemp($bt){
			$this->db->delete("temp_".$this->table, array('client_mac_address' => $bt));
		}
		
		function decreseLiveCount($bt,$live_cout){
				
			$data = array(
					'live_cout' => $live_cout-1
			);
		
			$this->db->where('client_mac_address', $bt);
			$this->db->update($this->table, $data);
		}
		
		function getByDivcId($device_id){
			$query = $this->db->get_where($this->table,array("device_id"=>"$device_id"));
			return $query;
		}
		
	
	}