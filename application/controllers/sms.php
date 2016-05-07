<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class sms extends MY_Controller {
	
	function __construct(){
		parent::__construct();

		$this->output->enable_profiler(TRUE);
		$this->load->model("sms_db");
		$this->load->model("student_db");
		$this->load->library('pagination');
	}
	
	public function lists($offset=0)
	{
		
		$data = array();
		$table = array();
		$header = array();
		
		
		$config['base_url'] = base_url().'sms/list';
		$config['total_rows'] = $this->sms_db->countAll();
		$config['per_page'] = 100;
		
		$this->pagination->initialize($config);
		
		if($this->uri->segment(3)){
			$page = ($this->uri->segment(3)) ;
		}
		else{
			$page = 1;
		}
		
		$data["result"] = $this->sms_db->getLimit($config['per_page'] );
		
		$this->pagination->initialize($config);
		
		$data["pagelink"] =  $this->pagination->create_links();
		
		
		$render["content"] = $this->load->view("sms/table_tpl",$data, true);
		$this->load->view("layout/layout_tpl",$render,false);
	}
}
