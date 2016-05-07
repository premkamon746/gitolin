<?php
	class Student_Db extends CI_Model{

		private $table = "student";
		function __construct(){
			parent::__construct();
		}

		function save($post){
			$this->db->set('create_date', 'now()',false);
			$this->db->set('status', 'active',true);
			$this->db->insert($this->table,$post);
		}

		function update($post,$id){
			$this->db->where('id', $id);
			$this->db->update($this->table,$post);
		}

		function deleteData($id){
			$this->db->where('id', $id);
			$this->db->delete($this->table);
		}

		function getAll($school_id){
			//$query = $this->db->get_where($this->table,array('status' => "active"));

			$this->db->order_by("status", "asc");
			$query = $this->db->get_where($this->table,array("school_id"=>$school_id));
			return $query;
		}


		function getAllInClass($grade_id){
			$this->db->order_by("status", "asc");
			$query = $this->db->get_where($this->table,array("current_grade_id"=>$grade_id));
			return $query;
		}

		function getById($student_id){
			$query = $this->db->get_where($this->table,array("id"=>$student_id));
			return $query;
		}

		function getInfoByMacAdr($blue_mac){
			$bl = implode(",",$blue_mac);
			$bl = "'".str_replace(",","','",$bl)."'";
			$sql = "select * from $this->table where macaddr in ($bl)";
			return $this->db->query($sql);
		}

		function getInfoByMacAdrOne($blue_mac){
			$sql = "select * from $this->table where macaddr ='$blue_mac' ";
			return $this->db->query($sql);
		}

	}
