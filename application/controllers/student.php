<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends MY_Controller {

	function __construct(){
		parent::__construct();

		$this->output->enable_profiler(FALSE);
		$this->load->model("device_db");
		$this->load->model("school_db");
		$this->load->model("student_db");
	}

	public function move(){
		$data = array();
		$render["content"] = $this->load->view('student/move_tpl',$data, true);
		$this->load->view("layout/layout_tpl",$render,false);
	}

	public function lists($school_id=0)
	{

		$data = array();
		$table = array();
		$header = array();

		if(!($school_id >0))exit;
		if($post = $this->input->post()){
			$data = $this->process($post);
		}
		$data["school_id"] = $school_id;

		$result = $this->school_db->getById($school_id);

		if($result->num_rows() >0){
			$header["header"]  = $result->row();
		}else{
			exit;
		}
		$table["sc"] = $this->student_db->getAll( $school_id);
		$data["header"] = $this->load->view("student/header_tpl",$header, true);
		$data["data_table"] = $this->load->view("student/table_tpl",$table, true);
		$render["content"] = $this->load->view('student/index_tpl',$data, true);
		$this->load->view("layout/layout_tpl",$render,false);
	}

	function ajax_get_std_data($student_id){
		$row = $this->student_db->getById($student_id);
		echo json_encode($row->row());
	}

	function process($post){
		$data = array();
		extract($post);

		if(isset($delete_id)&&$delete_id >0 ){
			$this->student_db->deleteData($delete_id);
		}else if(isset($student_id)&&$student_id !=""){
			if($firstname !="" && $lastname !="" && $school_id !="" && $lat !="" && $lng!="" && $class !="" && $room!="" && $macaddr!=""){
				unset($post["student_id"]);
				$this->student_db->update($post,$student_id);
				//echo $this->db->last_query();
			}else{
				$data = $post;
			}
		}else{

			if($firstname !="" && $lastname !="" && $school_id !="" && $lat !="" && $lng!="" && $class !="" && $room!="" && $macaddr!=""){
				unset($post["student_id"]);
				$this->student_db->save($post);
			}else{
				$data = $post;
			}
		}
		return $data;
	}
}
