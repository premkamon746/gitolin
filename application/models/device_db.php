<?php
	class Device_Db extends CI_Model{
		
		private $table = "host_device";
		function __construct(){
			parent::__construct();
		}
		
		function save($post){
			$this->db->set('create_date', 'now()',false);
			$this->db->set('status', 'active',true);
			$this->db->insert($this->table,$post);
		}
		
		function findSchoolId($host_device_id){
			
		}
		
		function getDeviceInfo($host_device_id){
			$sql = "select s.name,s.address,s.lat,s.lng,h.name as hname, h.device_id from school s
					join host_device h
					on h.school_id = s.id 
					where h.id = $host_device_id";
			
			return $this->db->query($sql);
		}
		
		function getAll($school_id){
			//$query = $this->db->get_where($this->table,array('status' => "active"));

			$this->db->order_by("status", "asc");
			$query = $this->db->get_where($this->table,array('school_id' => " $school_id"));
			return $query;
		}
		
		function getById($device_id){
			$query = $this->db->get_where($this->table,array("id"=>$device_id));
			return $query;
		}
		
		function update($post,$id){
			$this->db->where('id', $id);
			$this->db->update($this->table,$post);
		}
		
		function deleteData($id){
			$this->db->where('id', $id);
			$this->db->delete($this->table);
		}
		
	}