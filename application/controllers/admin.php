<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*  
 *  @author : Joyonto Roy
 *  date    : 1 August, 2014
 *  http://codecanyon.net/user/Creativeitem
 *  http://creativeitem.com
 */

class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();

        /* cache control */
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    /***default function, redirects to login page if no admin logged in yet** */

    public function index() {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($this->session->userdata('admin_login') == 1)
            redirect(base_url() . 'index.php?admin/dashboard', 'refresh');
    }

    /* * *ADMIN DASHBOARD** */

    function dashboard() {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name'] = 'dashboard';
        $page_data['page_title'] = get_phrase('admin_dashboard');
        $this->load->view('backend/index', $page_data);
    }

    /* report */

    function report_project($param1 = '') {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        if (isset($_POST['date_range'])) {
            $date_range = $this->input->post('date_range');
            $date_range = explode(" - ", $date_range);

            $page_data['timestamp_start'] = strtotime($date_range[0]);
            $page_data['timestamp_end'] = strtotime($date_range[1]);
        } else {
            $page_data['timestamp_start'] = strtotime('-29 days', time());
            $page_data['timestamp_end'] = strtotime(date("m/d/Y"));
        }
        $page_data['page_name'] = 'report_project';
        $page_data['page_title'] = get_phrase('project_report');
        $this->load->view('backend/index', $page_data);
    }

    function reload_report_project_body() {
        $date_range = $this->input->post('date_range');
        $date_range = explode(" - ", $date_range);

        $page_data['timestamp_start'] = strtotime($date_range[0]);
        $page_data['timestamp_end'] = strtotime($date_range[1]);
        $this->load->view('backend/admin/report_project_body', $page_data);
    }

    /* support ticket */

    function support_ticket($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'create')
            $this->crud_model->create_support_ticket();

        if ($param1 == 'delete')
            $this->crud_model->delete_support_ticket($param2);   //param2 = ticket_code

        if ($param1 == 'assign_staff')
            $this->crud_model->support_ticket_assign_staff($param2); //param2 = ticket_code

        if ($param1 == 'update_status')
            $this->crud_model->support_ticket_update_status($param2); //param2 = ticket_code

        $page_data['ticket_status'] = $param1;
        if ($param1 == 'opened')
            $page_data['page_title'] = get_phrase('opened_support_ticket');
        if ($param1 == 'closed')
            $page_data['page_title'] = get_phrase('closed_support_ticket');
        $page_data['page_name'] = 'support_ticket';
        $this->load->view('backend/index', $page_data);
    }

    function support_ticket_view($ticket_code = '') {
        if ($this->session->userdata('admin_login') != 1) {
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

    function reload_support_ticket_list( $ticket_status ) {
        $page_data['ticket_status']     =   $ticket_status;
        $this->load->view('backend/admin/support_ticket_list' , $page_data);
    }

    function reload_support_ticket_view_body($ticket_code = '') {
        $page_data['ticket_code'] = $ticket_code;
        $this->load->view('backend/admin/support_ticket_view_body', $page_data);
    }

    function support_ticket_create() {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $page_data['page_name'] = 'support_ticket_create';
        $page_data['page_title'] = get_phrase('create_new_ticket');
        $this->load->view('backend/index', $page_data);
    }

    /* invoice management */

    function invoice_add() {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name'] = 'invoice_add';
        $page_data['page_title'] = get_phrase('create_new_invoice');
        $this->load->view('backend/index', $page_data);
    }

    function invoice($param1 = '', $param2 = '') {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'create')
            $this->crud_model->create_invoice();

        if ($param1 == 'edit')
            $this->crud_model->update_invoice($param2);

        if ($param1 == 'delete')
            $this->crud_model->delete_invoice($param2);


        $page_data['page_name'] = 'invoice';
        $page_data['page_title'] = get_phrase('manage_invoice');
        $this->load->view('backend/index', $page_data);
    }

    function reload_invoice_list() {
        $this->load->view('backend/admin/invoice_list');
    }

    function email_invoice($invoice_id) {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $this->load->helper(array('dompdf', 'file'));
        
        $page_data['invoice_id']        =   $invoice_id;
        $html   =   $this->load->view('backend/admin/invoice_view_pdf' , $page_data , true);
        
        // generate pdf by dompdf
        $data = pdf_create($html, '', false);
        write_file('uploads/invoice.pdf', $data);
        $invoice_number =   $this->db->get_where('invoice' , array('invoice_id' => $invoice_id))->row()->invoice_number;
        $client_id      =   $this->db->get_where('invoice' , array('invoice_id' => $invoice_id))->row()->client_id;
        $client_email   =   $this->db->get_where('client' , array('client_id' => $client_id))->row()->email;
        
        // send the invoice to client email
        $this->email_model->do_email('' , 'invoice #'.$invoice_number , $client_email , NULL , 'uploads/invoice.pdf');
    }
    

    /* project management */
    function project($param1 = '', $param2 = '') {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'create')
            $this->crud_model->create_project();

        if ($param1 == 'edit') {
            $this->crud_model->update_project($param2);
            redirect(base_url() . 'index.php?admin/project_monitor/' . $param2, 'refresh');
        }

        if ($param1 == 'delete')
            $this->crud_model->delete_project($param2);


        $page_data['page_name'] = 'project';
        $page_data['page_title'] = get_phrase('manage_project');
        $this->load->view('backend/index', $page_data);
    }

    function project_add() {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name'] = 'project_add';
        $page_data['page_title'] = get_phrase('create_new_project');
        $this->load->view('backend/index', $page_data);
    }

    function project_edit($param = ''){
        if($this->session->userdata('admin_login') != 1 ){
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        $page_data['param'] = $param;
        $page_data['page_name'] = 'project_edit';
        $page_data['page_title'] = get_phrase('edit_project');
        $this->load->view('backend/index',$page_data);
    }

    function reload_project_list() {
        $this->load->view('backend/admin/project_list');
    }

    function project_monitor($project_id = '') {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        $page_data['project_id'] = $project_id;
        $page_data['page_name'] = 'project_monitor';
        $page_data['page_title'] = get_phrase('monitor_project');
        $this->load->view('backend/index', $page_data);
    }

    function reload_project_monitor_body($project_id = '') {
        $page_data['project_id'] = $project_id;
        $this->load->view('backend/admin/project_monitor_body', $page_data);
    }

    function project_task($param1 = '', $param2 = '', $param3 = '') 
    {
        if ($this->session->userdata('admin_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'create') 
        {
            $this->crud_model->create_project_task($param2);  // param2 = project_id
        } 
        else if ($param1 == 'edit') 
        {
            $this->crud_model->update_project_task($param2); // param2 = project_task_id
        } 
        else if ($param1 == 'delete') 
        {
            $this->crud_model->delete_project_task($param2); // param2 = project_task_id
        }
    }

    function project_message($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'add') {
            $this->crud_model->create_project_message($param2);  // param2 = project_id
        }
    }

    function project_file($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'upload')
            $this->crud_model->upload_project_file($param2); // param2 = project_id

        else if ($param1 == 'download')
            $this->crud_model->download_project_file($param2); // param2 = project_file_id

        else if ($param1 == 'delete')
            $this->crud_model->delete_project_file($param2); // param2 = project_file_id
    }

    function project_timer($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'edit') {
            $this->crud_model->update_project_timer($param2, $param3);  // param2 = timer_status 0stop 1start, param3 = project_id
        }
    }

    function project_task_timer($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'edit') {
            $this->crud_model->update_project_task_timer($param2, $param3);  // param2 = timer_status 0stop 1start, param3 = project_task_id
        }
    }

    /* Project category */
    function project_category($param1 = '', $param2 = '') {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'create')
            $this->crud_model->create_project_category();

        if ($param1 == 'edit')
            $this->crud_model->update_project_category($param2);

        if ($param1 == 'delete')
            $this->crud_model->delete_project_category($param2);

        $page_data['page_name'] = 'project_category';
        $page_data['page_title'] = get_phrase('manage_project_category');
        $this->load->view('backend/index', $page_data);
    }

    function reload_project_category_list() {
        $this->load->view('backend/admin/project_category_list');
    }
    
    function project_quote($param1 = '', $param2 = '') 
    {
        if ($this->session->userdata('admin_login') != 1) 
        {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }
        
        if ($param1 == "archive")
        {
            $this->crud_model->archive_project_quote($param2);
            $this->session->set_flashdata('flash_message' , get_phrase('data_archived_successfuly'));
            redirect('admin/project_quote');
        }
        
        if ($param1 == "unarchive")
        {
            $this->crud_model->unarchive_project_quote($param2);
            $this->session->set_flashdata('flash_message' , get_phrase('data_unarchived_successfuly'));
            redirect('admin/project_quote');
        }

        if ($param1 == 'delete')
            $this->crud_model->delete_project_quote($param2);

        $page_data['page_name']     = 'project_quote';
        $page_data['page_title']    = get_phrase('manage_project_quote');
        $this->load->view('backend/index', $page_data);
    }
    
    function reload_project_quote_list() 
    {
        $this->load->view('backend/admin/project_quote_list');
    }

    /*  Client management */
    function client($param1 = '', $param2 = '') {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'create')
            $this->crud_model->create_client();

        if ($param1 == 'edit')
            $this->crud_model->update_client($param2);

        if ($param1 == 'delete')
            $this->crud_model->delete_client($param2);

        $page_data['page_name'] = 'client';
        $page_data['page_title'] = get_phrase('manage_client');
        $this->load->view('backend/index', $page_data);
    }

    function reload_client_list() {
        $this->load->view('backend/admin/client_list');
    }
    
    function pending_client($task = "", $client_pending_id = "")
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            $this->session->set_userdata('last_page' , current_url());
            redirect(base_url(), 'refresh');
        }
        
        if ($task == "approve")
        {
            $this->crud_model->approve_pending_client_info($client_pending_id);
            $this->session->set_flashdata('flash_message' , get_phrase('data_approved_successfuly'));
            redirect('admin/pending_client');
        }
        
        if ($task == "delete")
        {
            $this->crud_model->delete_pending_client_info($client_pending_id);
        }
        
        $page_data['page_name']     = 'pending_client';
        $page_data['page_title']    = get_phrase('manage_pending_client');
        $this->load->view('backend/index', $page_data);
    }
    
    function reload_pending_client_list()
    {
        $this->load->view('backend/admin/pending_client_list');
    }

    /* Manual Time */
    /* Edited by Rob Go, 3Public */
    function time_list($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_login') != 1) {
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
            redirect('admin/time_list/'.$param2);
        }

        if( is_numeric($param1) ){
            $page_data['param'] = $param1;
        }


        $page_data['page_name'] = 'time_list';
        $page_data['page_title'] = get_phrase('time_log');
        $this->load->view('backend/index', $page_data);  
    }

    function add_time($param = ''){
        if ($this->session->userdata('admin_login') != 1) {
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
        $this->load->view('backend/admin/time_list', $page_data);
    }

    /* Lead management */ 
    /* Edited by Rob Go, 3Public */
    function lead($param1 = '', $param2 = '') {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'create')
            $this->crud_model->create_lead();

        if ($param1 == 'edit')
            $this->crud_model->update_lead($param2);

        if ($param1 == "approve")
        {
            $this->crud_model->approve_pending_lead_info($param2);
            $this->session->set_flashdata('flash_message' , get_phrase('data_approved_successfuly'));
            redirect('admin/client');
        }

        if ($param1 == 'delete')
            $this->crud_model->delete_lead($param2);

        $page_data['page_name'] = 'lead';
        $page_data['page_title'] = get_phrase('manage_lead');
        $this->load->view('backend/index', $page_data);
    }

    function reload_lead_list() {
        $this->load->view('backend/admin/lead_list');
    }

    /*  staff management */
    function staff($param1 = '', $param2 = '') {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'create')
            $this->crud_model->create_staff();

        if ($param1 == 'edit')
            $this->crud_model->update_staff($param2);

        if ($param1 == 'delete')
            $this->crud_model->delete_staff($param2);

        $page_data['page_name'] = 'staff';
        $page_data['page_title'] = get_phrase('manage_staff');
        $this->load->view('backend/index', $page_data);
    }

    function reload_staff_list() {
        $this->load->view('backend/admin/staff_list');
    }

    /*  account_role management */
    function account_role($param1 = '', $param2 = '') {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'create')
            $this->crud_model->create_account_role();

        if ($param1 == 'edit')
            $this->crud_model->update_account_role($param2);

        if ($param1 == 'delete')
            $this->crud_model->delete_account_role($param2);

        $page_data['page_name'] = 'account_role';
        $page_data['page_title'] = get_phrase('manage_account_role');
        $this->load->view('backend/index', $page_data);
    }

    function reload_account_role_list() {
        $this->load->view('backend/admin/account_role_list');
    }

    /* private messaging */
    function message($param1 = 'message_home', $param2 = '', $param3 = '') {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'send_new') {
            $message_thread_code = $this->crud_model->send_new_private_message();
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?admin/message/message_read/' . $message_thread_code, 'refresh');
        }

        if ($param1 == 'send_reply') {
            $this->crud_model->send_reply_message($param2);  //$param2 = message_thread_code
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?admin/message/message_read/' . $param2, 'refresh');
        }

        if ($param1 == 'message_read') {
            $page_data['current_message_thread_code'] = $param2;  // $param2 = message_thread_code
            $this->crud_model->mark_thread_messages_read($param2);
        }

        $page_data['message_inner_page_name'] = $param1;
        $page_data['page_name'] = 'message';
        $page_data['page_title'] = get_phrase('private_messaging');
        $this->load->view('backend/index', $page_data);
    }

    /* note */
    function note($param1 = '') {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'save')
            $this->crud_model->save_note();

        $page_data['page_name'] = 'note';
        $page_data['page_title'] = get_phrase('personal_notes');
        $this->load->view('backend/index', $page_data);
    }

    /* email template settings */
    function email_settings($param1 = 1, $param2 = '') {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'do_update') {
            $this->crud_model->save_email_template($param2);
            $this->session->set_flashdata('flash_message', get_phrase('email_template_updated'));
            redirect(base_url() . 'index.php?admin/email_settings/' . $param2, 'refresh');
        }

        $page_data['current_email_template_id'] = $param1;
        $page_data['page_name'] = 'email_settings';
        $page_data['page_title'] = get_phrase('email_template_settings');
        $this->load->view('backend/index', $page_data);
    }

    /*     * ***LANGUAGE SETTINGS******** */
    function manage_language($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        if ($param1 == 'edit_phrase') {
            $page_data['edit_profile'] = $param2;
        }
        if ($param1 == 'update_phrase') {
            $language = $param2;
            $total_phrase = $this->input->post('total_phrase');
            for ($i = 1; $i < $total_phrase; $i++) {
                //$data[$language]  =   $this->input->post('phrase').$i;
                $this->db->where('phrase_id', $i);
                $this->db->update('language', array($language => $this->input->post('phrase' . $i)));
            }
            redirect(base_url() . 'index.php?admin/manage_language/edit_phrase/' . $language, 'refresh');
        }
        if ($param1 == 'do_update') {
            $language = $this->input->post('language');
            $data[$language] = $this->input->post('phrase');
            $this->db->where('phrase_id', $param2);
            $this->db->update('language', $data);
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
        }
        if ($param1 == 'add_phrase') {
            $data['phrase'] = $this->input->post('phrase');
            $this->db->insert('language', $data);
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
        }
        if ($param1 == 'add_language') {
            $language = $this->input->post('language');
            $this->load->dbforge();
            $fields = array(
                $language => array(
                    'type' => 'LONGTEXT'
                )
            );
            $this->dbforge->add_column('language', $fields);

            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
        }
        if ($param1 == 'delete_language') {
            $language = $param2;
            $this->load->dbforge();
            $this->dbforge->drop_column('language', $language);
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));

            redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
        }
        $page_data['page_name'] = 'manage_language';
        $page_data['page_title'] = get_phrase('manage_language');
        //$page_data['language_phrases'] = $this->db->get('language')->result_array();
        $this->load->view('backend/index', $page_data);
    }

    /*     * ***SITE/SYSTEM SETTINGS******** */

    function system_settings($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        if ($param1 == 'do_update') {
            $this->crud_model->update_system_settings();
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?admin/system_settings/', 'refresh');
        }
        if ($param1 == 'upload_logo') {
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/logo.png');
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?admin/system_settings/', 'refresh');
        }
        $page_data['page_name'] = 'system_settings';
        $page_data['page_title'] = get_phrase('system_settings');
        $page_data['settings'] = $this->db->get('settings')->result_array();
        $this->load->view('backend/index', $page_data);
    }

    /*     * ****MANAGE OWN PROFILE AND CHANGE PASSWORD** */
    function manage_profile($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');

        if ($param1 == 'update_profile_info') {
            $data['name'] = $this->input->post('name');
            $data['email'] = $this->input->post('email');
            $admin_id = $this->session->userdata('login_user_id');

            $this->db->where('admin_id', $admin_id);
            $this->db->update('admin', $data);
            move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/admin_image/" . $admin_id . '.jpg');

            $this->session->set_flashdata('flash_message', get_phrase('account_updated'));
            redirect(base_url() . 'index.php?admin/manage_profile/', 'refresh');
        }
        if ($param1 == 'change_password') {
            $current_password_input = sha1($this->input->post('password'));
            $new_password = sha1($this->input->post('new_password'));
            $confirm_new_password = sha1($this->input->post('confirm_new_password'));

            $current_password_db = $this->db->get_where('admin', array('admin_id' =>
                        $this->session->userdata('login_user_id')))->row()->password;

            if ($current_password_db == $current_password_input && $new_password == $confirm_new_password) {
                $this->db->where('admin_id', $this->session->userdata('login_user_id'));
                $this->db->update('admin', array('password' => $new_password));
            }
            redirect(base_url() . 'index.php?admin/manage_profile/', 'refresh');
        }
        $page_data['page_name'] = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $page_data['edit_data'] = $this->db->get_where('admin', array(
                    'admin_id' => $this->session->userdata('login_user_id')))->result_array();
        $this->load->view('backend/index', $page_data);
    }

}