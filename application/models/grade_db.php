<?php
	class Grade_Db extends CI_Model{

		private $table = "grade_level";
		function __construct(){
			parent::__construct();
			$this->load->model('class_room_db');
		}


		function save($post){
			$name = $post["name"];
			$school_id = $post["school_id"];
			$num_room = $post["num_room"];
			$sql = "insert into $this->table (name,create_date,school_id) values ('$name',now(),$school_id)";

			$num_room = intval($num_room);
			$this->db->query($sql);
			$grade_lev_id = $this->db->insert_id();

			if($num_room > 0){
				for($i = 0; $i < $num_room; $i++){
					$name = $i+1;
					$this->class_room_db->save($school_id,$grade_lev_id, $name);
				}
			}
			return $grade_lev_id;
		}

		function getAll($school_id){
			$sql = "select *,(select count(*) from class_room where grade_id = s.id ) as room_num from $this->table s
							where s.school_id = $school_id order by s.sort,s.id";
			return $this->db->query($sql);
		}

		function getGradeName($grade_id){
			$sql = "select * from $this->table where id = $grade_id";
			$resutl =  $this->db->query($sql);
			if($resutl->num_rows() > 0){
					return $resutl->row()->name;
			}
			return "";
		}

		function delete($id){
			$sql = "delete from $this->table where id = $id";
			return $this->db->query($sql);
		}

		function sort($id,$sort_num){
			$sql = "update $this->table set sort = $sort_num where id = $id";
			return $this->db->query($sql);
		}

		function update_one($field, $id, $name){
				$sql = "update $this->table set $field = '$name' where id = $id";
				return $this->db->query($sql);
		}

	}
