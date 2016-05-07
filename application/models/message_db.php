<?php
	class Message_Db extends CI_Model{
		
		private $table = "school";
		function __construct(){
			parent::__construct();
		}
		
		
		function getStudentInfo($mac){
			$sql = "select id, firstname, lastname, school_id
			from student where macaddr = '$mac'";
			return $this->db->query($sql);
		}
		
		function getNews($school_id){
			$sql = "select * from news where school_id = $school_id";
			return $this->db->query($sql);
		}
		
	}