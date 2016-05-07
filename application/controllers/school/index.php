<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model("school_db");
	}
	
	public function index()
	{
		$data = array();
		echo "test";
		$render["content"] = $this->load->view('school/dashboard_tpl.php',$data, true);
		$this->load->view("layout/layout_tpl",$render,false);
	}
}
