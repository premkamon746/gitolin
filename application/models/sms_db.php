<?php
	class Sms_Db extends CI_Model{
	
		private $table = "sms_trx";
		function __construct(){
			parent::__construct();
		}
	
		
		function getLimit($limit){
			$this->db->limit($limit);
			$this->db->order_by("create_date", "desc");
			$query = $this->db->get($this->table);
			//$sql = "select * from sms_trx limit $start, $end";
			//$result = $this->db->query($sql);
			return $query;
		}
		
		function countAll(){
			return $this->db->count_all($this->table);
		}
		
		function save($blue_mac,$message,$type,$trx_id){
			$this->db->set('create_date', 'now()',false);
			$this->db->set('student_mac_addr', $blue_mac);
			$this->db->set('transection_id', $trx_id);
			$this->db->set('msg', $message);
			$this->db->set('type', $type);
			$this->db->insert($this->table);
		}
	
		
	
	}