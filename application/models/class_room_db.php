<?php
	class Class_Room_Db extends CI_Model{

		private $table = "class_room";
		function __construct(){
			parent::__construct();
		}

		// function save($post){
		// 	$name = $post["name"];
		// 	$school_id = $post["school_id"];
		// 	$num_room = $post["num_room"];
		// 	$sql = "insert into $this->table (name,create_date,school_id,grade_id) values ('$name',now(),$school_id,grade_id)";
		//
		// 	$this->db->query($sql);
		// 	return $this->db->insert_id();
		// }
		// function save($school_id,$name){
		// 	$sql = "insert into";
		// 	return $this->db->query($sql);
		// }

		function getByGradeLev($grade_id){
			$sql = "select * from news where school_id = $school_id ";
			return $this->db->query($sql);
		}

		function getAll($grade_id){
			$sql = "select * from $this->table where grade_id = $grade_id ";
			return $this->db->query($sql);
		}

		function save($school_id,$grade_id, $name){
			$sql = "insert into $this->table (school_id,grade_id,name) values ($school_id,$grade_id,'$name')";
			return $this->db->query($sql);
		}

		function delete($id){
			$sql = "delete from $this->table where id = $id";
			return $this->db->query($sql);
		}

	}
