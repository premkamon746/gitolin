<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SchoolStudent extends MY_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model("school_db");
	}
	
	public function index()
	{
		$data = array();
		$table = array();
		
		if($post = $this->input->post()){
			extract($post);
			if($name !="" && $address!="" && $lat != "" && $lng !=""){
				$this->school_db->save($post);
			}else{
				$data = $post;
			}
		}
		$data["sc"] = $this->school_db->getAll();
		$render["content"] = $this->load->view('student/h_table_tpl.php',$data, true);
		$this->load->view("layout/layout_tpl",$render,false);
	}
	
// 	function test_send(){
// 		$this->load->library("sms");
// 		echo $this->sms->send("0955433238", "hello sms prem!!");
// 	}
}
