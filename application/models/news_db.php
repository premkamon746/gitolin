<?php
	class News_Db extends CI_Model{
		
		private $table = "news";
		function __construct(){
			parent::__construct();
		}
		
		function totalRow($school_id){
			$sql = "select count(*) c from $this->table where school_id = $school_id";
			$result = $this->db->query($sql);
			if($result->num_rows() > 0){
				return $result->row()->c;
			}
			return false;
		}
		
		function getNewsById($school_id,$news_id){
				
			$this->db->from($this->table);
			$this->db->where(array("school_id"=>$school_id,"id"=>$news_id));
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				return $query->row();
			}
			return false;
		}
		
		
		function getNews($school_id,$per_page,$offset){
			
			$this->db->from($this->table); 
			$this->db->limit($per_page, $offset); 
			$this->db->where(array("school_id"=>$school_id));
			$this->db->order_by("create_date", "desc");
			$query = $this->db->get(); 
			
			return $query;
		}
		
		function getAllNews($school_id){
				
			$sql = "SELECT * FROM news 
					WHERE school_id = 2   
					and create_date BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()";
			$query = $this->db->query($sql);
			
			return $query;
		}
		
		
		function insertNews($post ,$school_id ,$cat_id=1){
			extract($post);
			$data = array(
					"catagory_id" => $cat_id
					,"school_id" => $school_id
					,"title" => $title
					,"content" => $content 
					
			);
			
			$this->db->set('create_date', 'now()',false);
			$this->db->insert($this->table,$data);
		}
		
		function updateNews($post ,$school_id ){
			extract($post);
			
			$data = array(
					"title" => $title
					,"content" => $content
						
			);
			
			$where = array(
					"id" => $news_id
					,"school_id" => $school_id
						
			);
				
			$this->db->where($where);
			$this->db->update($this->table,$data);
		}
		
// 		function updateNews($post ,$school_id ,$cat_id=1){
// 			extract($post);
// 			$data = array(
// 					"catagory_id" => $cat_id
// 					,"school_id" => $school_id
// 					,"title" => $title
// 					,"content" => $content
						
// 			);
				
// 			$this->db->set('create_date', 'now()',false);
// 			$this->db->insert($this->table,$data);
// 		}
		
		
	}