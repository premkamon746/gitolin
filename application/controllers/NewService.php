<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class NewService extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("news_db");
		$this->load->helper("thaidate");
	}
	
	
	function all($school_id){
		$result = $this->news_db->getAllNews($school_id);
		echo json_encode($result->result());
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */




























