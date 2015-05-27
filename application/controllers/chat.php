<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends CI_Controller {

	
	function __construct()
    {
        parent::__construct();
		$this->load->database();
		/*cache control*/
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
    }
	

	public function index()
	{
		
	}
	
	
	function update_chat_status($chat_status)
	{
		$account_type 			=	$this->session->userdata('login_type');
		$this->db->where($account_type.'_id' , $this->session->userdata('login_user_id'));
		$this->db->update($account_type , array('chat_status' => $chat_status));
	}

	function view_chat_area()
	{
		$this->load->view('backend/chat');
	}

	function view_chat_history()
	{
		$this->load->view('backend/chat_history');
	}
}

