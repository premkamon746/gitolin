<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class MessageService extends CI_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( "student_db" );
		$this->load->model ( "sms_db" );
		$this->load->model ( "trx_db" );
		$this->load->model ( "message_db" );
		$this->load->library ( "sms" );
		$this->load->library ( "trx" );
	}
	
	function index() {
		if ($post = $this->input->post ()) 		// e1
		{
			$mac_addr = $post ["MacAddr"];
			$result = $this->message_db->getStudentInfo($mac_addr);
			echo json_encode($result->result());
		}else{
			echo "{}";
		}
	}
	
	function getnews(){
	if ($post = $this->input->post ()) 		// e1
		{
			$school_id = 2;//$post ["school_id"];
			$result = $this->message_db->getNews($school_id);
			echo json_encode($result->result());
		}
	}
}