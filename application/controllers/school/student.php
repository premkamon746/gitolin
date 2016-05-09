<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("student_db");
		$this->load->model("grade_db");
	}

	public function index($classroom_id,$class_room_name)
	{
		$data = array();
		$table = array();
		$form = array();
		$grade_id = $this->session->userdata("grade_id");

		if($post = $this->input->post()){

			extract($post);
			print_r($post);
				$user = $this->session->userdata("user");
				$school_id = $user["school_id"];


				$class = $this->session->userdata("grade_name");
				$room = $class_room_name;

				if($firstname !=""
						&& $lastname !=""
						&& $school_id !=""
						&& $grade_id!=""
						&& $classroom_id!=""){
							$post["school_id"] = $school_id;
							$post["current_grade_id"] = $grade_id;
							$post["current_class_id"] = $classroom_id;

							$post["class"] = $class;
							$post["room"] = $room;
							//print_r($post);
							$this->student_db->save($post);
				}else{
					$data = $post;
				}
		}

		$user = $this->session->userdata("user");
		$table["school_id"] = $user["school_id"];

		$table["sc"] = $this->student_db->getAllInClass($grade_id);
		$data["data_table"] = $this->load->view("school/student/table_tpl",$table, true);


		$modal["modal_title"] = "Add Student";
		$modal["modal_body"] = $this->load->view("school/student/form_tpl",$form, true);
		$data["data_form"] = $this->load->view("school/layout/modal_tpl",$modal, true);

		$render["content"] = $this->load->view('school/student/index_tpl',$data, true);
		$this->load->view("school/layout/layout_tpl",$render,false);
	}


	function process($post){
		$data = array();
		extract($post);

		if(isset($delete_id)&&$delete_id >0 ){
			$this->student_db->deleteData($delete_id);
		}else if(isset($student_id)&&$student_id !=""){
			if($firstname !="" && $lastname !="" && $school_id !="" && $lat !="" && $lng!="" && $macaddr!=""){
				unset($post["student_id"]);
				$this->student_db->update($post,$student_id);
				//echo $this->db->last_query();
			}else{
				$data = $post;
			}
		}else{

			if($firstname !="" && $lastname !="" && $school_id !="" && $lat !="" && $lng!="" && $macaddr!=""){
				unset($post["student_id"]);
				$this->student_db->save($post);
			}else{
				$data = $post;
			}
		}
		return $data;
	}

	function move(){
		$data = array();

		$data["grade"] = $this->grade_db->getAll(2);
		$render["content"] = $this->load->view('school/student/move_tpl',$data, true);
		$this->load->view("school/layout/layout_tpl",$render,false);
	}

	function getroom($id){
		$result = $this->db->get_where("class_room",array("grade_id"=>$id));
		echo json_encode($result->result());
	}

	function getstd(){
		if($query = $this->input->get('query')){
			$this->db->like("firstname",$query);
			$this->db->select("id, CONCAT(firstname,' ',lastname) as fullname", FALSE);
			$query = $this->db->get('student');
			if($query->num_rows() > 0) echo json_encode($query->result());
		}
	}


}
