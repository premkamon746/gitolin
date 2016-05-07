<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GradeLevel extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("grade_db");
	}

	public function index()
	{
		$data = array();
		$table = array();

		$user = $this->session->userdata("user");
		$data["school_id"] = $user["school_id"];

		if($post = $this->input->post()){
			$this->grade_db->save($post);
		}

		$table["sc"] = $this->grade_db->getAll($user["school_id"]);
		$data["data_table"] = $this->load->view("school/grade/table_tpl",$table, true);
		$render["content"] = $this->load->view('school/grade/index_tpl.php',$data, true);
		$this->load->view("school/layout/layout_tpl",$render,false);
	}

	public function add(){
		$data = array();
		$render["content"] = $this->load->view('school/class_room/add_tpl.php',$data, true);
		$this->load->view("school/layout/layout_tpl",$render,false);
	}

	public function delete($id){
		$this->grade_db->delete($id);
		redirect("/school/GradeLevel/");
	}

	public function sort(){
		$json = $this->input->post("sort");
		$d = json_decode($json);

		foreach ($d as $j){
			$this->grade_db->sort($j[0],$j[1]);
		}
	}

	public function update_name(){
		$post = $this->input->post();
    $name = $post["value"];
    $id = $post["pk"];
		$this->grade_db->update_one("name", $id, $name);
	}



}
