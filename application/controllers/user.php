<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model("user_db");
		$this->load->helper("thaidate");
	}
	
	function index(){
		$data = array();
		
		$userdata = $this->session->userdata("user");
		$uid = $userdata["uid"];
		$this->load->library('pagination');
		
		$config['base_url'] = base_url()."user/index/";
		$config['total_rows'] = $this->user_db->totalRow($uid);
		$config['per_page'] = 5;
		$this->pagination->initialize($config);
		$data["offset"] =  $this->uri->segment(3);
		$data["user"] = $this->user_db->getUser( $uid, $config['per_page'], $this->uri->segment(3) );
		
		$data["page"] = $this->pagination->create_links();
		
		$render["content"] = $this->load->view("user/index_tpl",$data, true);
		$this->load->view("layout/layout_tpl",$render,false);
		
	}
	
	function edit($user_id){
		$data = array();
		
		if($post = $this->input->post()){
			$this->user_db->updateUser($post);
		}
		
		$data["role"] = $this->user_db->getAllRole();
		$data["user"] = $this->user_db->getUserById($user_id);
	
		$render["content"] = $this->load->view("user/edit_tpl",$data, true);
		$this->load->view("layout/layout_tpl",$render,false);
	
	}
	
	function delete($id){
		$data = array();
	
		if($this->user_db->deleteUser($id)){
			redirect(site_url("user"));
		}
	
	}
	
	function insert(){
		$data = array();
		
		$userdata = $this->session->userdata("user");
		$school_id = $userdata["uid"];
		$role = $userdata["role"];
		
		$data["role"] = $this->user_db->getAllRole();
		
		if($post = $this->input->post() ){
			extract($post);
			if($name !=""&&$password !="" ){
				if(!$this->user_db->dupUsername($name)){
					$this->user_db->save($post);
					redirect(site_url("user"));
				}else{
					echo "duplicate username";
					exit;
				}
			}else{
				echo "empty username or password";
				exit;
				
			}
			
		}
	
		if($school_id > 0){
			$data["user"] = true;
		}
		$render["content"] = $this->load->view("user/insert_tpl",$data, true);
		$this->load->view("layout/layout_tpl",$render,false);
	
	}
	
	
	
	
	
}