<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends MY_Controller {
	
	function __construct(){
		parent::__construct();
	}
	
	function index(){
		$data = array();
		
		if($post = $this->input->post()){
			foreach ($post as $key=>$val){
				$data_update = array(
								'value'=> $val
				);

				$this->db->where('field_name',$key);
				$this->db->update('setting', $data_update);
			}
			//print_r($data_update);
			
		}
		
		$this->db->order_by('sort','ascs');
		$data["result"] = $this->db->get("setting");
		$render["content"] = $this->load->view("setting/index_tpl",$data, true);
		$this->load->view("layout/layout_tpl",$render,false);
	}
	
}
