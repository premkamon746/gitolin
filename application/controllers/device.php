<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Device extends MY_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model("device_db");
		$this->load->model("school_db");
	}
	
	public function lists($school_id=0)
	{
		$data = array();
		$table = array();
		$header = array();
		
		if(!($school_id >0))exit;
		$data["school_id"] = $school_id;
		
		if($post = $this->input->post()){
			$this->process($post);
		}
		
		$header["header"] = $this->school_db->getById($school_id);
		if($header["header"]->num_rows() >0){
			$header["header"] = $header["header"]->row();
		}else{
			exit;
		}
		
		$table["sc"] = $this->device_db->getAll( $school_id);
		
		$data["header"] = $this->load->view("device/header",$header, true);
		$data["data_table"] = $this->load->view("device/table_tpl",$table, true);
		$render["content"] = $this->load->view('device/index_tpl',$data, true);
		$this->load->view("layout/layout_tpl",$render,false);
	}
	
	function ajax_get_device_data($device_id){
		$row = $this->device_db->getById($device_id);
		echo json_encode($row->row());
	}
	

	function process($post){
		$data = array();
		extract($post);
			
		if(isset($delete_id)&&$delete_id >0 ){
			$this->device_db->deleteData($delete_id);
		}else if(isset($dv_id)&&$dv_id !=""){
			if($name !="" && $device_id!=""){
				unset($post["dv_id"]);
				$this->device_db->update($post,$dv_id);
			}else{
				$data = $post;
			}
		}else{
	
			if($name !="" && $device_id!=""){
				unset($post["dv_id"]);
				$this->device_db->save($post);
			}else{
				$data = $post;
			}
		}
		return $data;
	}
}
