<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ClassRoom extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("class_room_db");
		$this->load->model("grade_db");
	}


	public function index($grade_id,$grade_name)
	{
		$data = array();

		$user = $this->session->userdata("user");
		$data["school_id"] = $user["school_id"];

		//use in next pages
		$this->session->set_userdata("grade_id",$grade_id);
		$this->session->set_userdata("grade_name",$grade_name);

		$table["sc"] = $this->class_room_db->getAll($grade_id);
		$table["grade_name"] = $this->grade_db->getGradeName($grade_id);
		$table["grade_id"] = $grade_id;
		$data["data_table"] = $this->load->view("school/class_room/table_tpl",$table, true);
		$render["content"] = $this->load->view('school/class_room/index_tpl.php',$data, true);
		$this->load->view("school/layout/layout_tpl",$render,false);
	}

	public function add(){
		$data = array();
		$render["content"] = $this->load->view('school/class_room/add_tpl.php',$data, true);
		$this->load->view("school/layout/layout_tpl",$render,false);
	}

	public function delete($grade_id,$id){
		$this->class_room_db->delete($id);
		redirect("/school/classroom/index/$grade_id");
	}



}
