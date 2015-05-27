<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*	
 *	@author : Joyonto Roy
 *	date	: 1 August, 2014
 *	http://codecanyon.net/user/Creativeitem
 *	http://creativeitem.com
 */

class Staff extends CI_Controller
{
    
    
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		
       /*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		
    }
    
    /***default function, redirects to login page if no staff logged in yet***/
    public function index()
    {
        if ($this->session->userdata('staff_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($this->session->userdata('staff_login') == 1)
            redirect(base_url() . 'index.php?staff/dashboard', 'refresh');
    }
    
    /***STAFF DASHBOARD***/
    function dashboard()
    {
        if ($this->session->userdata('staff_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		}
        $page_data['page_name']  = 'dashboard';
        $page_data['page_title'] = get_phrase('staff_dashboard');
        $this->load->view('backend/index', $page_data);
    }
	
	
    
	/* project management */


	function project_assigned($param1 = '' , $param2 = '')
	{
		if ($this->session->userdata('staff_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		}
		
		if (!$this->crud_model->staff_permission(1))	//checking permission for staff
			redirect(base_url(), 'refresh');
		
			
		
		$page_data['page_name']  = 'project_assigned';
		$page_data['page_title'] = get_phrase('manage_all_project');
		$this->load->view('backend/index', $page_data);
	}
	
	function project($param1 = '' , $param2 = '')
	{
		if ($this->session->userdata('staff_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		}
		
		//checking permission for staff
		if ($this->crud_model->staff_permission(1) == false && $this->crud_model->staff_permission(2) == false)	
			redirect(base_url(), 'refresh');
		
		if ($param1		==	'create') 
			$this->crud_model->create_project();
			
		if ($param1		==	'edit') 
		{
			$this->crud_model->update_project($param2);
			redirect(base_url().'index.php?staff/project_monitor/'.$param2 , 'refresh');
		}
		
		$page_data['page_name']  = 'project';
		$page_data['page_title'] = get_phrase('manage_all_project');
		$this->load->view('backend/index', $page_data);
	}
	
	function project_add()
	{
		if ($this->session->userdata('staff_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		}
		
		//checking permission for staff
		if ($this->crud_model->staff_permission(2) == false)	
			redirect(base_url(), 'refresh');
			
        $page_data['page_name']  = 'project_add';
        $page_data['page_title'] = get_phrase('create_new_project');
        $this->load->view('backend/index', $page_data);
	}
	
	function reload_project_list()
	{
		$this->load->view('backend/staff/project_list');
	}

	function project_monitor($project_id = '')
	{
		if ($this->session->userdata('staff_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		}
			
		$page_data['project_id']	= $project_id;
		$page_data['page_name']	= 'project_monitor';
		$page_data['page_title']	= get_phrase('monitor_project');
		$this->load->view('backend/index', $page_data);
	}
	
	function reload_project_monitor_body($project_id = '')
	{
		$page_data['project_id']		=		$project_id;
		$this->load->view('backend/staff/project_monitor_body' , $page_data);
	}
	
	function project_task($param1 = '' , $param2 = '' , $param3 = '')
	{
		if ($this->session->userdata('staff_login') != 1)
		{
			redirect(base_url(), 'refresh');
		}
		
		if ($param1 == 'add')
		{
			$this->crud_model->create_project_task($param2);		// param2 = project_id
		}
		else if ($param1 == 'edit')
		{
			$this->crud_model->update_project_task($param2 , $param3); // param2 = complete_status 0/1, param3 = project_task_id
		}
		else if ($param1 == 'delete')
		{
			$this->crud_model->delete_project_task($param2 ); // param2 = project_task_id
		}
	}
	
	function project_message($param1 = '' , $param2 = '' , $param3 = '')
	{
		if ($this->session->userdata('staff_login') != 1)
		{
			redirect(base_url(), 'refresh');
		}
		
		if ($param1 == 'add')
		{
			$this->crud_model->create_project_message($param2);		// param2 = project_id
		}
	}
	
	function project_file($param1 = '' , $param2 = '' , $param3 = '')
	{
		if ($this->session->userdata('staff_login') != 1)
		{
			redirect(base_url(), 'refresh');
		}
		
		if ($param1 == 'upload')
			$this->crud_model->upload_project_file($param2);	// param2 = project_id
		
		else if ($param1 == 'download')
			$this->crud_model->download_project_file($param2);	// param2 = project_file_id
			
		else if ($param1 == 'delete')
			$this->crud_model->delete_project_file($param2 ); // param2 = project_file_id
	}
	
	function project_timer($param1 = '' , $param2 = '' , $param3 = '')
	{
		if ($this->session->userdata('staff_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		}
		
		if ($param1 == 'edit')
		{
			$this->crud_model->update_project_timer($param2,$param3);		// param2 = timer_status 0stop 1start, param3 = project_id
		}
	}


    function project_task_timer($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('staff_login') != 1) {
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'edit') {
            $return = $this->crud_model->update_project_task_timer($param2, $param3);  // param2 = timer_status 0stop 1start, param3 = project_task_id
            echo json_encode( $return );
        }
    }
	
	
    /*	Client management*/
	function client($param1 = '' , $param2 = '')
	{
		if ($this->session->userdata('staff_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		}
		
		//checking permission for staff
		if ($this->crud_model->staff_permission(3) == false)	
			redirect(base_url(), 'refresh');
			
		if ($param1		==	'create') 
			$this->crud_model->create_client();
		
		if ($param1		==	'edit') 
			$this->crud_model->update_client($param2);
		
		if ($param1		==	'delete') 
			$this->crud_model->delete_client($param2);
		
		$page_data['page_name']  = 'client';
		$page_data['page_title'] = get_phrase('manage_client');
		$this->load->view('backend/index', $page_data);
	}
	
	function reload_client_list()
	{
		$this->load->view('backend/staff/client_list');
	}
	
    
    /*	staff management*/
	function staffs($param1 = '' , $param2 = '')
	{
		if ($this->session->userdata('staff_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		}
		
		//checking permission for staff
		if ($this->crud_model->staff_permission(4) == false)	
			redirect(base_url(), 'refresh');
			
		if ($param1		==	'create') 
			$this->crud_model->create_staff();
		
		if ($param1		==	'edit') 
			$this->crud_model->update_staff($param2);
		
		if ($param1		==	'delete') 
			$this->crud_model->delete_staff($param2);
		
		$page_data['page_name']  = 'staff';
		$page_data['page_title'] = get_phrase('manage_staff');
		$this->load->view('backend/index', $page_data);
	}
	
	function reload_staff_list()
	{
		$this->load->view('backend/staff/staff_list');
	}

    /*	Lead management*/
    /*  Edited by Rob Go, 3Public */
	function lead($param1 = '' , $param2 = '')
	{
		if ($this->session->userdata('staff_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		}
		
		//checking permission for staff
		if ($this->crud_model->staff_permission(8) == false)	
			redirect(base_url(), 'refresh');
			
		if ($param1		==	'create') 
			$this->crud_model->create_lead();
		
		if ($param1		==	'edit') 
			$this->crud_model->update_lead($param2);

        if ($param1 == "approve")
        {
            $this->crud_model->approve_pending_lead_info($param2);
            $this->session->set_flashdata('flash_message' , get_phrase('data_approved_successfuly'));
            redirect('staff/client');
        }
		
		if ($param1		==	'delete') 
			$this->crud_model->delete_lead($param2);
		
		$page_data['page_name']  = 'lead';
		$page_data['page_title'] = get_phrase('manage_lead');
		$this->load->view('backend/index', $page_data);
	}

	function reload_lead_list()
	{
		$this->load->view('backend/staff/lead_list');
	}

    /* Manual Time */
    /* Edited by Rob Go, 3Public */
    function time_list($param1 = '', $param2 = ''){
        if ($this->session->userdata('staff_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }        

        if( $param1 == 'add' ){
            $this->crud_model->add_time($param2);
        }

        if( $param1 == 'edit' ){
            $this->crud_model->update_time();
        }

        if( $param1 == 'delete' ){
            $this->crud_model->delete_time($param2);
            $this->session->set_flashdata('flash_message' , get_phrase('manual_log_deleted_successfuly'));
            redirect('staff/time_list/'.$param2);
        }

        if( is_numeric($param1) ){
            $page_data['param'] = $param1;
        }


        $page_data['page_name'] = 'time_list';
        $page_data['page_title'] = get_phrase('time_log');
        $this->load->view('backend/index', $page_data);  
    }

    function add_time($param = ''){
        if ($this->session->userdata('staff_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $page_data['param'] = $param;
        $page_data['page_name'] = 'add_time';
        $page_data['page_title'] = get_phrase('manual_time');
        $this->load->view('backend/index', $page_data);      

    }

    function reload_time_list($param) {
        $page_data['param'] = $param;
        $this->load->view('backend/staff/time_list', $page_data);
    }
	
	/* support ticket */
	function support_ticket($param1 = '' , $param2 = '' , $param3 = '')
	{
		if ($this->session->userdata('staff_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		}
		//checking permission for staff
		if ($this->crud_model->staff_permission(6) == false && $this->crud_model->staff_permission(7) == false)	
			redirect(base_url(), 'refresh');
		
		if ($param1 == 'create')
			$this->crud_model->create_support_ticket();
		
		if ($param1 == 'assign_staff')
			$this->crud_model->support_ticket_assign_staff($param2);	//param2 = ticket_code
		
		if ($param1 == 'update_status')
			$this->crud_model->support_ticket_update_status($param2);	//param2 = ticket_code
			
		$page_data['ticket_status']	= $param1;
		if ($param1 == 'opened')
			$page_data['page_title']	= get_phrase('opened_support_ticket');
		if ($param1 == 'closed')
			$page_data['page_title']	= get_phrase('closed_support_ticket');
		$page_data['page_name']		= 'support_ticket';
		$this->load->view('backend/index', $page_data);
	}
	
	function support_ticket_view($ticket_code = '')
	{
		if ($this->session->userdata('staff_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		}
		//checking permission for staff
		if ($this->crud_model->staff_permission(6) == false && $this->crud_model->staff_permission(7) == false)	
			redirect(base_url(), 'refresh');
			
		$page_data['ticket_code']	= $ticket_code;
		$page_data['page_name']	= 'support_ticket_view';
		$page_data['page_title']	= get_phrase('support_ticket');
		$this->load->view('backend/index', $page_data);
	}
	
	function support_ticket_post_reply($ticket_code = '')
	{
		$this->crud_model->post_ticket_reply($ticket_code);
	}
	
	function support_ticket_delete($ticket_code = '')
	{
		$this->crud_model->delete_support_ticket($ticket_code);
	}
	
	function reload_support_ticket_view_body($ticket_code = '')
	{
		$page_data['ticket_code']		=		$ticket_code;
		$this->load->view('backend/staff/support_ticket_view_body' , $page_data);
	}
	
	/* invoice management */
	
	function invoice_add()
	{
		if ($this->session->userdata('staff_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		}
		
		//checking permission for staff
		if ($this->crud_model->staff_permission(5) == false)	
			redirect(base_url(), 'refresh');
			
        $page_data['page_name']  = 'invoice_add';
        $page_data['page_title'] = get_phrase('create_new_invoice');
        $this->load->view('backend/index', $page_data);
	}
	
	function invoice($param1 = '' , $param2 = '')
	{
		if ($this->session->userdata('staff_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		}
		
		//checking permission for staff
		if ($this->crud_model->staff_permission(5) == false)	
			redirect(base_url(), 'refresh');
			
		if ($param1		==	'create') 
			$this->crud_model->create_invoice();
		
		if ($param1		==	'edit') 
			$this->crud_model->update_invoice($param2);
		
		if ($param1		==	'delete') 
			$this->crud_model->delete_invoice($param2);
			
		
		$page_data['page_name']  = 'invoice';
		$page_data['page_title'] = get_phrase('manage_invoice');
		$this->load->view('backend/index', $page_data);
	}
	
	function reload_invoice_list()
	{
		$this->load->view('backend/staff/invoice_list');
	}
	
	/* private messaging */
	function message($param1 = 'message_home' , $param2 = '' , $param3 = '')
	{
		if ($this->session->userdata('staff_login') != 1)
		{
			$this->session->set_userdata('last_page' , current_url());
			redirect(base_url(), 'refresh');
		}

		if ($param1 == 'send_new')
		{
			$message_thread_code 	=	$this->crud_model->send_new_private_message();
			$this->session->set_flashdata('flash_message' , get_phrase('message_sent!'));
			redirect(base_url().'index.php?staff/message/message_read/'.$message_thread_code, 'refresh');
		}

		if ($param1 == 'send_reply')
		{
			$this->crud_model->send_reply_message($param2);		//$param2 = message_thread_code
			$this->session->set_flashdata('flash_message' , get_phrase('message_sent!'));
			redirect(base_url().'index.php?staff/message/message_read/'.$param2, 'refresh');
		}

		if ($param1 == 'message_read')
		{
			$page_data['current_message_thread_code']  	= $param2;
			$this->crud_model->mark_thread_messages_read($param2);
		}
		
		$page_data['message_inner_page_name']  	= $param1;
		$page_data['page_name']  				= 'message';
		$page_data['page_title'] 				= get_phrase('private_messaging');
		$this->load->view('backend/index', $page_data);
	}
    /******MANAGE OWN PROFILE AND CHANGE PASSWORD***/
    function manage_profile($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('staff_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
			
        if ($param1 == 'update_profile_info') {
            $data['name']                   = $this->input->post('name');
            $data['email']                  = $this->input->post('email');
            $data['phone']                  = $this->input->post('phone');
            $data['skype_id']               = $this->input->post('skype_id');
            $data['facebook_profile_link']  = $this->input->post('facebook_profile_link');
            $data['linkedin_profile_link']  = $this->input->post('linkedin_profile_link');
            $data['twitter_profile_link']   = $this->input->post('twitter_profile_link');
            $staff_id                       = $this->session->userdata('login_user_id');
            
            $this->db->where('staff_id', $staff_id);
            $this->db->update('staff', $data);
            move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/staff_image/" . $staff_id . '.jpg');
            
            $this->session->set_flashdata('flash_message', get_phrase('account_updated'));
            redirect(base_url() . 'index.php?staff/manage_profile/', 'refresh');
        }
        if ($param1 == 'change_password') {
            $current_password_input			= sha1($this->input->post('password'));
            $new_password						= sha1($this->input->post('new_password'));
            $confirm_new_password			= sha1($this->input->post('confirm_new_password'));
            
            $current_password_db				= $this->db->get_where('staff', array( 'staff_id' => 
																	$this->session->userdata('login_user_id')))->row()->password;
																	
            if ($current_password_db == $current_password_input && $new_password == $confirm_new_password) {
                $this->db->where('staff_id', $this->session->userdata('login_user_id'));
                $this->db->update('staff', array('password' => $new_password));
            }
            redirect(base_url() . 'index.php?staff/manage_profile/', 'refresh');
        }
        $page_data['page_name']  = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $page_data['edit_data']  = $this->db->get_where('staff', array(
            								'staff_id' => $this->session->userdata('login_user_id')))->result_array();
        $this->load->view('backend/index', $page_data);
    }
    
}
