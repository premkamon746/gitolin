<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('user_db');
		$this->load->model('school_db');
	}

	public function index()
	{
		$this->load->view('welcome_message');
	}

	function login()
	{
		$data = array();

		if($post = $this->input->post()){
			extract($post);

			if($row = $this->user_db->checkUser($username, $password)){
				$this->getSession($row);
				// if($row->role == 0)
				// 	redirect("/");
				// else if($row->role ==1){
				// 	redirect("news");
				// }
				if($row->school_id > 0){
					$sc_data = $this->school_db->getById($row->school_id);
					$this->session->set_userdata("sc_data",$sc_data->row());
					redirect("school/dashboard");
				}else{
					redirect("/");
				}
			}
		}

		$this->load->view("auth/login_tpl",$data);
	}

	function getSession($row){
		$data = array(
			"uid"=>$row->id,
			"username"=>$row->name,
			"role"=>$row->role,
			"school_id"=>$row->school_id
		);
		$this->session->set_userdata("user",$data);
		return $data;
	}

	function logout(){
		$this->session->unset_userdata("user");
		redirect(base_url()."auth/login");
	}



}
