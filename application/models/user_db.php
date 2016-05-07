<?php
	class User_Db extends CI_Model{
		
		private $table = "user";
		function __construct(){
			parent::__construct();
		}
		
// 		function save($post){
// 			$this->db->set('create_date', 'now()',false);
// 			$this->db->set('status', 'active',true);
// 			$this->db->insert($this->table,$post);
// 		}
		
		function getUser($school_id,$per_page,$offset){
				
			$this->db->from($this->table);
			$this->db->limit($per_page, $offset);
			$this->db->order_by("create_date", "asc");
			$query = $this->db->get();
				
			return $query;
		}
		
		function getUserById($user_id){
			$this->db->from($this->table);
			$this->db->where(array("id"=>$user_id));
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				return $query->row();
			}
			return  false;
			
		}
		
		
		function updatePassword($user_id,$password){
			$sql ="update $this->table set password = $password where id = $user_id";
			$this->db->query($sql);
		}
		
		function totalRow(){
			$sql ="select count(*) as user_row from $this->table";
			$result = $this->db->query($sql);
			if($result->num_rows() > 0){
				return $result->row()->user_row;
			}
			
			return false;
		}
		
		function checkUser($username, $password){
			$sql = "select * from user where name = '$username' and password = '$password' and status='active'";
			
			$result = $this->db->query($sql);
			
			if($result->num_rows() > 0){
				return $result->row();
			}
			return false;
			
		}
		
		
		function deleteUser($user_id){
			$sql = "update $this->table set status = 'inactive' where id= $user_id";
			return $this->db->query($sql);
		}
		
		function save($post){
			extract($post);
			$data = array(
					"name" => $name
					,"password" => $password
					,"role" => $role
					,"status" => "active"
						
			);
				
			$this->db->set('create_date', 'now()',false);
			$this->db->insert($this->table,$data);
		}
		
		function dupUsername($name){
			$this->db->where(array("name"=>$name));
			$query = $this->db->get($this->table);
			if($query->num_rows() > 0){
				return true;
			}
			return false;
		}
		
		function getAllRole(){
			return $this->db->get("user_role");
		}
		
		function updateUser($post){
			extract($post);
				
			$data = array(
					"name" => $name
					,"password" => $password
					,"status" => $status
					,"role" => $role
		
			);
				
			$where = array(
					"id" => $user_id
		
			);
		
			$this->db->where($where);
			$this->db->update($this->table,$data);
		}
		
		
		
	}