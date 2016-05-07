<?php
	class School_Db extends CI_Model{

		private $table = "school";
		function __construct(){
			parent::__construct();
		}

		function save($post){
			$this->db->set('create_date', 'now()',false);
			$this->db->set('status', 'active',true);
			$this->db->insert($this->table,$post);
		}

		function getAll(){
			//$query = $this->db->get_where($this->table,array('status' => "active"));

			$this->db->order_by("status", "asc");
			$query = $this->db->get_where($this->table);
			return $query;
		}

		function getById($id){
			$query = $this->db->get_where($this->table,array('id' => $id));
			return $query;
		}

		function deleteData($id){
			$this->db->where('id', $id);
			$this->db->delete($this->table);
		}

		function update($post,$id){
			$this->db->where('id', $id);
			$this->db->update($this->table,$post);
		}


	}
