<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("news_db");
		$this->load->helper("thaidate");
	}
	
	
	public function index()
	{
		$data = array();
		
		$userdata = $this->session->userdata("user");
		$uid = $userdata["uid"];
		
		$this->load->library('pagination');
		
		
		$config['base_url'] = base_url()."news/index/";
		$config['total_rows'] = $this->news_db->totalRow($uid);
		$config['per_page'] = 5;
		$this->pagination->initialize($config);
		$data["offset"] =  $this->uri->segment(3);
		$data["news"] = $this->news_db->getNews( $uid, $config['per_page'], $this->uri->segment(3) );
		
		$data["page"] = $this->pagination->create_links();
		
		
		
		$render["content"] = $this->load->view('news/index_tpl',$data, true);
		$this->load->view("layout/sclayout_tpl",$render,false);
	}
	
	public function edit($news_id)
	{
		$data = array();
		$userdata = $this->session->userdata("user");
		$school_id = $userdata["uid"];
		
		
		if($post = $this->input->post()){
			$this->news_db->updateNews($post ,$school_id );
		}
		$data["news"] = $this->news_db->getNewsById($school_id,$news_id);
		$data["news_id"] = $news_id;
		
		$render["content"] = $this->load->view('news/edit_tpl',$data, true);
		$this->load->view("layout/sclayout_tpl",$render,false);
	}
	
	public function view()
	{
		$data = array();
		$render["content"] = $this->load->view('news/view_tpl',$data, true);
		$this->load->view("layout/sclayout_tpl",$render,false);
	}
	
	public function insert()
	{
		$data = array();
		$userdata = $this->session->userdata("user");
		$school_id = $userdata["uid"];
		
		if($post = $this->input->post()){
			$this->news_db->insertNews($post ,$school_id );
			redirect(site_url("news"));
		}
		
		$render["content"] = $this->load->view('news/insert_tpl',$data, true);
		$this->load->view("layout/sclayout_tpl",$render,false);
	}
	
	
	function get_new_service($school_id){
		$result = $this->news_db->getAllNews($school_id);
		echo json_encode($result->result());
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */




























