<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model("school_db");
	}
	
	public function index()
	{
		$data = array();
		$table = array();
		
		if($post = $this->input->post()){
			$this->process($post);
		}
		$table["sc"] = $this->school_db->getAll();
		$data["data_table"] = $this->load->view("home/table_tpl",$table, true);
		$render["content"] = $this->load->view('home/index_tpl',$data, true);
		$this->load->view("layout/layout_tpl",$render,false);
	}
	
	function test_send(){
		$this->load->library("sms");
		echo $this->sms->send("0955433238", "hello sms prem!!");
	}
	
	function ajax_get_sch_data($school_id){
		$row = $this->school_db->getById($school_id);
		echo json_encode($row->row());
	}
	
	function process($post){
		$data = array();
		extract($post);
			
		if(isset($delete_id)&&$delete_id >0 ){
			$this->school_db->deleteData($delete_id);
		}else if(isset($school_id)&&$school_id !=""){
			if($name !="" && $address!="" && $lat != "" && $lng !=""){
				unset($post["school_id"]);
				$this->school_db->update($post,$school_id);
			}else{
				$data = $post;
			}
		}else{
	
		if($name !="" && $address!="" && $lat != "" && $lng !=""){
				unset($post["school_id"]);
				$this->school_db->save($post);
			}else{
				$data = $post;
			}
		}
		return $data;
	}
}
