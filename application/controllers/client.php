<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* 	
 * 	@author 	: Joyonto Roy
 * 	date		: 30 August, 2014
 * 	http://codecanyon.net/user/Creativeitem
 * 	http://creativeitem.com
 */

class Client extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();

        /* cache control */
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    /*     * *default function, redirects to login page if not logged in yet** */

    public function index() {
        if ($this->session->userdata('client_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($this->session->userdata('client_login') == 1)
            redirect(base_url() . 'index.php?client/dashboard', 'refresh');
    }

    /*     * * DASHBOARD** */

    function dashboard() {
        if ($this->session->userdata('client_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name'] = 'dashboard';
        $page_data['page_title'] = get_phrase('client_dashboard');
        $this->load->view('backend/index', $page_data);
    }

    /* support ticket */

    function support_ticket($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('client_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'create')
            $this->crud_model->create_support_ticket();

        $page_data['ticket_status'] = $param1;
        if ($param1 == 'opened')
            $page_data['page_title'] = get_phrase('opened_support_ticket');
        if ($param1 == 'closed')
            $page_data['page_title'] = get_phrase('closed_support_ticket');
        $page_data['page_name'] = 'support_ticket';
        $this->load->view('backend/index', $page_data);
    }

    function support_ticket_view($ticket_code = '') {
        if ($this->session->userdata('client_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $page_data['ticket_code'] = $ticket_code;
        $page_data['page_name'] = 'support_ticket_view';
        $page_data['page_title'] = get_phrase('support_ticket');
        $this->load->view('backend/index', $page_data);
    }

    function support_ticket_post_reply($ticket_code = '') {
        $this->crud_model->post_ticket_reply($ticket_code);
    }

    function reload_support_ticket_view_body($ticket_code = '') {
        $page_data['ticket_code'] = $ticket_code;
        $this->load->view('backend/client/support_ticket_view_body', $page_data);
    }

    function support_ticket_create() {
        if ($this->session->userdata('client_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $page_data['page_name'] = 'support_ticket_create';
        $page_data['page_title'] = get_phrase('create_new_ticket');
        $this->load->view('backend/index', $page_data);
    }

    /* invoice management */

    function invoice($param1 = '', $param2 = '') {
        if ($this->session->userdata('client_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'paypal_cancel') {
            $this->session->set_flashdata('paypal_cancel', 'true');
            redirect(base_url() . 'index.php?client/invoice', 'refresh');
        }
        if ($param1 == 'paypal_success') {
            $this->session->set_flashdata('paypal_success', 'true');
            redirect(base_url() . 'index.php?client/invoice', 'refresh');
        }

        $page_data['page_name'] = 'invoice';
        $page_data['page_title'] = get_phrase('manage_invoice');
        $this->load->view('backend/index', $page_data);
    }

    /* project management */

    function project($param1 = '', $param2 = '') {
        if ($this->session->userdata('client_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $page_data['page_name'] = 'project';
        $page_data['page_title'] = get_phrase('manage_project');
        $this->load->view('backend/index', $page_data);
    }

    function project_monitor($project_id = '') {
        if ($this->session->userdata('client_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $this->validate_client_project_permission($project_id);

        $page_data['project_id'] = $project_id;
        $page_data['page_name'] = 'project_monitor';
        $page_data['page_title'] = get_phrase('monitor_project');
        $this->load->view('backend/index', $page_data);
    }

    function validate_client_project_permission($project_id) { // checking whether loggedin client is associated with project_id
    }

    function reload_project_monitor_body($project_id = '') {
        $page_data['project_id'] = $project_id;
        $this->load->view('backend/client/project_monitor_body', $page_data);
    }

    function project_message($param1 = '', $param2 = '', $param3 = '') {
        if ($param1 == 'add') {
            $this->crud_model->create_project_message($param2);  // param2 = project_id
        }
    }

    function project_file($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('client_login') != 1) {
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'upload')
            $this->crud_model->upload_project_file($param2); // param2 = project_id

        else if ($param1 == 'download')
            $this->crud_model->download_project_file($param2); // param2 = project_file_id

        else if ($param1 == 'delete')
            $this->crud_model->delete_project_file($param2); // param2 = project_file_id
    }
    
    function project_quote($param1 = '', $param2 = '') 
    {
        if ($this->session->userdata('client_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'create')
            $this->crud_model->create_project_quote();

        if ($param1 == 'edit')
            $this->crud_model->update_project_quote($param2);

        if ($param1 == 'delete')
            $this->crud_model->delete_project_quote($param2);

        $page_data['page_name']     = 'project_quote';
        $page_data['page_title']    = get_phrase('manage_project_quote');
        $this->load->view('backend/index', $page_data);
    }
    
    function reload_project_quote_list() 
    {
        $this->load->view('backend/client/project_quote_list');
    }

    /* private messaging */

    function message($param1 = 'message_home', $param2 = '', $param3 = '') {
        if ($this->session->userdata('client_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'send_new') {
            $message_thread_code = $this->crud_model->send_new_private_message();
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?client/message/message_read/' . $message_thread_code, 'refresh');
        }

        if ($param1 == 'send_reply') {
            $this->crud_model->send_reply_message($param2);  //$param2 = message_thread_code
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?client/message/message_read/' . $param2, 'refresh');
        }

        if ($param1 == 'message_read') {
            $page_data['current_message_thread_code'] = $param2;
            $this->crud_model->mark_thread_messages_read($param2);
        }

        $page_data['message_inner_page_name'] = $param1;
        $page_data['page_name'] = 'message';
        $page_data['page_title'] = get_phrase('private_messaging');
        $this->load->view('backend/index', $page_data);
    }

    /*     * ****MANAGE OWN PROFILE AND CHANGE PASSWORD** */

    function manage_profile($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('client_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        if ($param1 == 'update_profile_info') {
            $data['name'] = $this->input->post('name');
            $data['email'] = $this->input->post('email');
            $data['address'] = $this->input->post('address');
            $data['phone'] = $this->input->post('phone');
            $data['company'] = $this->input->post('company');
            $data['website'] = $this->input->post('website');
            $data['skype_id'] = $this->input->post('skype_id');
            $data['facebook_profile_link'] = $this->input->post('facebook_profile_link');
            $data['linkedin_profile_link'] = $this->input->post('linkedin_profile_link');
            $data['twitter_profile_link'] = $this->input->post('twitter_profile_link');
            $client_id = $this->session->userdata('login_user_id');

            $this->db->where('client_id', $client_id);
            $this->db->update('client', $data);
            move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/client_image/" . $client_id . '.jpg');

            $this->session->set_flashdata('flash_message', get_phrase('account_updated'));
            redirect(base_url() . 'index.php?client/manage_profile/', 'refresh');
        }
        if ($param1 == 'change_password') {
            $current_password_input = sha1($this->input->post('password'));
            $new_password = sha1($this->input->post('new_password'));
            $confirm_new_password = sha1($this->input->post('confirm_new_password'));

            $current_password_db = $this->db->get_where('client', array('client_id' =>
                        $this->session->userdata('login_user_id')))->row()->password;

            if ($current_password_db == $current_password_input && $new_password == $confirm_new_password) {
                $this->db->where('client_id', $this->session->userdata('login_user_id'));
                $this->db->update('client', array('password' => $new_password));
            }
            redirect(base_url() . 'index.php?client/manage_profile/', 'refresh');
        }
        $page_data['page_name'] = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $page_data['edit_data'] = $this->db->get_where('client', array(
                    'client_id' => $this->session->userdata('login_user_id')))->result_array();
        $this->load->view('backend/index', $page_data);
    }

}