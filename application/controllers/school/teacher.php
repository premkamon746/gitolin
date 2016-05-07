<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("teacher_db");
	}

	public function index()
	{
		$data = array();
		$table = array();
		$form = array();
		$grade_id = $this->session->userdata("grade_id");

		if($post = $this->input->post()){
			$this->teacher_db->save($post);
		}

		$user = $this->session->userdata("user");
		$table["school_id"] = $user["school_id"];

		$table["sc"] = $this->teacher_db->getAll($table["school_id"]);
		$data["data_table"] = $this->load->view("school/teacher/table_tpl",$table, true);


		$modal["modal_title"] = "Add Teacher";
		$modal["modal_body"] = $this->load->view("school/teacher/form_tpl",$form, true);
		$data["data_form"] = $this->load->view("school/layout/modal_tpl",$modal, true);

		$render["content"] = $this->load->view('school/teacher/index_tpl',$data, true);
		$this->load->view("school/layout/layout_tpl",$render,false);
	}


	function process($post){
		$data = array();
		extract($post);

		if(isset($delete_id)&&$delete_id >0 ){
			$this->teacher_db->deleteData($delete_id);
		}else if(isset($student_id)&&$student_id !=""){
			if($firstname !="" && $lastname !="" && $school_id !="" && $lat !="" && $lng!="" && $macaddr!=""){
				unset($post["student_id"]);
				$this->teacher_db->update($post,$student_id);
				//echo $this->db->last_query();
			}else{
				$data = $post;
			}
		}else{

			if($firstname !="" && $lastname !="" && $school_id !="" && $lat !="" && $lng!="" && $macaddr!=""){
				unset($post["student_id"]);
				$this->teacher_db->save($post);
			}else{
				$data = $post;
			}
		}
		return $data;
	}


}
