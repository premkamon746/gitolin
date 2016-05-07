<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("school_db");
		$info = $this->session->userdata("user");
		$school_id = $info["school_id"];


	}

	public function index()
	{
		$data = array();
		$sc_data = $this->session->userdata("sc_data");
		$data['sc_data'] = $sc_data;
		$render["content"] = $this->load->view('school/dashboard_tpl.php',$data, true);
		$this->load->view("school/layout/layout_tpl",$render,false);
	}
}
