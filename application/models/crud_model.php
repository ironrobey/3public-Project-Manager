<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function clear_cache() {
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    function get_type_name_by_id($type, $type_id = '', $field = 'name') {
        $this->db->where($type . '_id', $type_id);
        $query = $this->db->get($type);
        $result = $query->result_array();
        foreach ($result as $row)
            return $row[$field];
        //return    $this->db->get_where($type,array($type.'_id'=>$type_id))->row()->$field;    
    }

    ////////private message//////
    function send_new_private_message() {
        $message = $this->input->post('message');
        $timestamp = strtotime(date("Y-m-d H:i:s"));

        $reciever = $this->input->post('reciever');
        $sender = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');

        //check if the thread between those 2 users exists, if not create new thread
        $num1 = $this->db->get_where('message_thread', array('sender' => $sender, 'reciever' => $reciever))->num_rows();
        $num2 = $this->db->get_where('message_thread', array('sender' => $reciever, 'reciever' => $sender))->num_rows();

        if ($num1 == 0 && $num2 == 0) {
            $message_thread_code = substr(md5(rand(100000000, 20000000000)), 0, 15);
            $data_message_thread['message_thread_code'] = $message_thread_code;
            $data_message_thread['sender'] = $sender;
            $data_message_thread['reciever'] = $reciever;
            $this->db->insert('message_thread', $data_message_thread);
        }
        if ($num1 > 0)
            $message_thread_code = $this->db->get_where('message_thread', array('sender' => $sender, 'reciever' => $reciever))->row()->message_thread_code;
        if ($num2 > 0)
            $message_thread_code = $this->db->get_where('message_thread', array('sender' => $reciever, 'reciever' => $sender))->row()->message_thread_code;


        $data_message['message_thread_code'] = $message_thread_code;
        $data_message['message'] = $message;
        $data_message['sender'] = $sender;
        $data_message['timestamp'] = $timestamp;
        $this->db->insert('message', $data_message);

        // notify email to email reciever
        //$this->email_model->notify_email('new_message_notification', $this->db->insert_id());

        return $message_thread_code;
    }

    function send_reply_message($message_thread_code) {
        $message = $this->input->post('message');
        $timestamp = strtotime(date("Y-m-d H:i:s"));
        $sender = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');


        $data_message['message_thread_code'] = $message_thread_code;
        $data_message['message'] = $message;
        $data_message['sender'] = $sender;
        $data_message['timestamp'] = $timestamp;
        $this->db->insert('message', $data_message);

        // notify email to email reciever
        $this->email_model->notify_email('new_message_notification', $this->db->insert_id());
    }

    function mark_thread_messages_read($message_thread_code) {
        // mark read only the oponnent messages of this thread, not currently logged in user's sent messages
        $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $this->db->where('sender !=', $current_user);
        $this->db->where('message_thread_code', $message_thread_code);
        $this->db->update('message', array('read_status' => 1));
    }

    function count_unread_message_of_thread($message_thread_code) {
        $unread_message_counter = 0;
        $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $messages = $this->db->get_where('message', array('message_thread_code' => $message_thread_code))->result_array();
        foreach ($messages as $row) {
            if ($row['sender'] != $current_user && $row['read_status'] == '0')
                $unread_message_counter++;
        }
        return $unread_message_counter;
    }

    ////////support ticket/////
    function create_support_ticket() {
        $data['title']          = $this->input->post('title');
        $data['ticket_code']    = substr(md5(rand(100000000, 20000000000)), 0, 15);
        $data['status']         = 'opened';
        $data['priority']       = $this->input->post('priority');
        $data['project_id']     = $this->input->post('project_id');
        
        $login_type             = $this->session->userdata('login_type');
        if($login_type == 'client')
            $data['client_id']  = $this->session->userdata('login_user_id');
        else 
            $data['client_id']  = $this->input->post('client_id');
        
        $data['timestamp']      = date("d M,Y");

        $this->db->insert('ticket', $data);

        // email notification check
        $this->email_model->notify_email('new_support_ticket_notify_admin', $data['ticket_code']);

        //creating ticket message

        $data2['ticket_code']   = $data['ticket_code'];
        $data2['message']       = $this->input->post('description');
        $data2['timestamp']     = date("d M,Y");
        $data2['sender_type']   = $this->session->userdata('login_type');
        $data2['sender_id']     = $this->session->userdata('login_user_id');
        if(isset($_FILES['file']['name']))
            $data['file']          = $_FILES['file']['name'];

        $this->db->insert('ticket_message', $data2);
        move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/ticket_file/' . $_FILES['file']['name']);
    }

    function delete_support_ticket($ticket_code) {
        $this->db->where('ticket_code', $ticket_code);
        $this->db->delete('ticket');
    }

    function post_ticket_reply($ticket_code) {
        $data['ticket_code']    = $ticket_code;
        $data['message']        = $this->input->post('message');
        $data['timestamp']      = date("d M,Y");
        $data['sender_type']    = $this->session->userdata('login_type');
        $data['sender_id']      = $this->session->userdata('login_user_id');
        
        if(isset($_FILES['file']['name']))
            $data['file']          = $_FILES['file']['name'];

        $this->db->insert('ticket_message', $data);
        
        if(isset($_FILES['file']['name']))
            move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/ticket_file/' . $_FILES['file']['name']);
    }

    function support_ticket_assign_staff($ticket_code) {
        $data['assigned_staff_id'] = $this->input->post('staff_id');
        $this->db->where('ticket_code', $ticket_code);
        $this->db->update('ticket', $data);

        // email notification check
        if ($this->input->post('notify_check') == 'yes')
            $this->email_model->notify_email('support_ticket_assign_staff', $ticket_code, $data['assigned_staff_id']);
    }

    function support_ticket_update_status($ticket_code) {
        $data['status'] = $this->input->post('status');
        $this->db->where('ticket_code', $ticket_code);
        $this->db->update('ticket', $data);
    }

    ////////note/////////
    function save_note() {
        $data['note'] = $this->input->post('note');
        $this->db->where('note_id', '1');
        $this->db->update('note', $data);
    }

    ////////invoices/////////////
    function create_invoice() {
        $data['title'] = $this->input->post('title');
        $data['invoice_number'] = $this->input->post('invoice_number');
        $data['client_id'] = $this->input->post('client_id');
        $data['project_id'] = $this->input->post('project_id');
        $data['creation_timestamp'] = $this->input->post('creation_timestamp');
        $data['due_timestamp'] = $this->input->post('due_timestamp');
        $data['vat_percentage'] = $this->input->post('vat_percentage');
        $data['discount_amount'] = $this->input->post('discount_amount');
        $data['status'] = $this->input->post('status');

        $invoice_entries = array();
        $descriptions = $this->input->post('entry_description');
        $amounts = $this->input->post('entry_amount');
        $number_of_entries = sizeof($descriptions);
        for ($i = 0; $i < $number_of_entries; $i++) {
            if ($descriptions[$i] != "" && $amounts[$i] != "") {
                $new_entry = array('description' => $descriptions[$i], 'amount' => $amounts[$i]);
                array_push($invoice_entries, $new_entry);
            }
        }
        $data['invoice_entries'] = json_encode($invoice_entries);

        $this->db->insert('invoice', $data);
    }

    function update_invoice($invoice_id) {
        $data['title'] = $this->input->post('title');
        $data['invoice_number'] = $this->input->post('invoice_number');
        $data['client_id'] = $this->input->post('client_id');
        $data['project_id'] = $this->input->post('project_id');
        $data['creation_timestamp'] = $this->input->post('creation_timestamp');
        $data['due_timestamp'] = $this->input->post('due_timestamp');
        $data['vat_percentage'] = $this->input->post('vat_percentage');
        $data['discount_amount'] = $this->input->post('discount_amount');
        $data['status'] = $this->input->post('status');

        $invoice_entries = array();
        $descriptions = $this->input->post('entry_description');
        $amounts = $this->input->post('entry_amount');
        $number_of_entries = sizeof($descriptions);
        for ($i = 0; $i < $number_of_entries; $i++) {
            if ($descriptions[$i] != "" && $amounts[$i] != "") {
                $new_entry = array('description' => $descriptions[$i], 'amount' => $amounts[$i]);
                array_push($invoice_entries, $new_entry);
            }
        }
        $data['invoice_entries'] = json_encode($invoice_entries);

        $this->db->where('invoice_id', $invoice_id);
        $this->db->update('invoice', $data);
    }

    function delete_invoice($invoice_id) {
        $this->db->where('invoice_id', $invoice_id);
        $this->db->delete('invoice');
    }

    function calculate_invoice_total_amount($invoice_number) {
        $total_amount = 0;
        $invoice = $this->db->get_where('invoice', array('invoice_number' => $invoice_number))->result_array();
        foreach ($invoice as $row) {
            $invoice_entries = json_decode($row['invoice_entries']);
            foreach ($invoice_entries as $invoice_entry)
                $total_amount += $invoice_entry->amount;

            $vat_amount = $total_amount * $row['vat_percentage'] / 100;
            $grand_total = $total_amount + $vat_amount - $row['discount_amount'];
        }

        return $grand_total;
    }

    ////////time/////////////
    function add_time($project_id){

        $data['project_task_id'] = $this->input->post('project_task_id');
        $data['project_task_note'] = $this->input->post('short_note');
        $data['added_by']   = $this->get_user_account_name();
        $data['date_added']   = date('m/d/Y');

        $add_time = $this->input->post('time') * 3600;
        $data['project_task_timestamp'] = $add_time;

        $this->db->insert('project_task_note', $data);

        $this->db->set('total_time_spent', 'total_time_spent+' . $add_time, FALSE);

        $this->db->where('project_id', $project_id);
        $this->db->update('project');       

    }

    ////////time/////////////
    function update_time($project_id){

        $data['project_task_note'] = $this->input->post('short_note');

        $project_id = $this->input->post( 'project_id' );
        $add_time = $this->input->post('time') * 3600;

        $data['project_task_timestamp'] = $add_time;

        $this->db->where('project_task_note_id', $this->input->post('project_task_note_id') );
        $this->db->update('project_task_note', $data);

        $this->db->where( 'project_id', $project_id );
        $temporary_time_spent = $this->db->get( 'project' )->row()->total_time_spent;
        $current_time_spent = $temporary_time_spent - $this->input->post('original_time');
        $total_time_spent = $current_time_spent + $add_time;

        $this->db->set('total_time_spent', $total_time_spent, FALSE);
        
        $this->db->where('project_id', $this->input->post( 'project_id' ) );
        $this->db->update('project');       

    }

    function delete_time($project_task_note_id){

        $this->db->where('project_task_note_id', $project_task_note_id);
        $this->db->delete('project_task_note');     

    }

    ////////projects/////////////
    function create_project() {
        $data['title'] = $this->input->post('title');
        $data['description'] = $this->input->post('description');
        $data['project_category_id'] = $this->input->post('project_category_id');
        $data['budget'] = $this->input->post('budget');
        $data['timestamp_start'] = $this->input->post('timestamp_start');
        $data['timestamp_end'] = $this->input->post('timestamp_end');
        $data['demo_url'] = $this->input->post('demo_url');
        $data['progress_status'] = $this->input->post('progress_status');
        $data['client_id'] = $this->input->post('client_id');
        $data['staffs'] = '';
        if ($this->input->post('staffs') != "")
            foreach ($this->input->post('staffs') as $row)
                $data['staffs'] .= $row . ',';

        $this->db->insert('project', $data);

        // email notification check
        if ($this->input->post('notify_check') == 'yes')
            $this->email_model->notify_email('new_project_opening', $this->db->insert_id());
    }

    function update_project($project_id) {
        $data['title'] = $this->input->post('title');
        $data['description'] = $this->input->post('description');
        $data['project_category_id'] = $this->input->post('project_category_id');
        $data['budget'] = $this->input->post('budget');
        $data['timestamp_start'] = $this->input->post('timestamp_start');
        $data['timestamp_end'] = $this->input->post('timestamp_end');
        $data['demo_url'] = $this->input->post('demo_url');
        $data['progress_status'] = $this->input->post('progress_status');
        $data['client_id'] = $this->input->post('client_id');
        $data['staffs'] = '';
        if ($this->input->post('staffs') != "")
            foreach ($this->input->post('staffs') as $row)
                $data['staffs'] .= $row . ',';

        $this->db->where('project_id', $project_id);
        $this->db->update('project', $data);
    }

    function delete_project($project_id) {
        $this->db->where('project_id', $project_id);
        $this->db->delete('project');
    }

    function create_project_task($project_id = '') 
    {
        $data['title']              = $this->input->post('name');
        $data['complete_status']    = $this->input->post('complete_status');
        $data['timestamp_start']    = strtotime($this->input->post('timestamp_start'));
        $data['timestamp_end']      = strtotime($this->input->post('timestamp_end'));
        $data['time_allocated']     = $this->input->post('task_time_budget') * 3600;
        $data['time_remaining']     = $this->input->post('task_time_budget') * 3600;
        $data['project_id']         = $project_id;
        
        $this->db->insert('project_task', $data);
    }

    function create_project_message($project_id = '') {
        $data['message'] = $this->input->post('message');
        $data['project_id'] = $project_id;
        $data['date'] = date("d M");
        $data['user_type'] = $this->session->userdata('login_type');
        $data['user_id'] = $this->session->userdata('login_user_id');
        $this->db->insert('project_message', $data);
    }

    function update_project_task($project_task_id) 
    {

        $data['title']              = $this->input->post('name');
        $data['complete_status']    = $this->input->post('complete_status');
        $data['timestamp_start']    = strtotime($this->input->post('timestamp_start'));
        $data['timestamp_end']      = strtotime($this->input->post('timestamp_end'));
        $data['time_allocated']     = $this->input->post('task_time_budget') * 3600;

        if( $this->input->post('original_time_budget') > $this->input->post('task_time_budget') ){
            $new_time = $this->input->post('original_time_budget') - ( $this->input->post('task_time_budget') * 3600 );
            $this->db->set('time_remaining', 'time_remaining-' . $new_time, FALSE);
        } else if( $this->input->post('original_time_budget') < $this->input->post('task_time_budget') ){
            $new_time = ( $this->input->post('task_time_budget') * 3600 ) - $this->input->post('original_time_budget');
            $this->db->set('time_remaining', 'time_remaining+' . $new_time, FALSE);
        }
        
        $this->db->where('project_task_id', $project_task_id);
        $this->db->update('project_task', $data);
    }

    function delete_project_task($project_task_id = '') {
        $this->db->where('project_task_id', $project_task_id);
        $this->db->delete('project_task');
    }

    function upload_project_file($project_id = '') {
        $data['description'] = $this->input->post('description');
        $data['project_id'] = $project_id;
        $data['name'] = $_FILES['userfile']['name'];
        $this->db->insert('project_file', $data);
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/project_file/' . $_FILES['userfile']['name']);
    }

    function download_project_file($project_file_id = '') {
        $file_name = $this->db->get_where('project_file', array('project_file_id' => $project_file_id))->row()->name;
        $this->load->helper('download');
        $data = file_get_contents("uploads/project_file/" . $file_name);
        $name = $file_name;

        force_download($name, $data);
    }

    function delete_project_file($project_file_id = '') {

        $file_name = $this->db->get_where('project_file', array('project_file_id' => $project_file_id))->row()->name;
        $this->db->where('project_file_id', $project_file_id);
        $this->db->delete('project_file');

        unlink("uploads/project_file/" . $file_name);
    }

    function update_project_timer($timer_status, $project_id) {
        $data['timer_status'] = $timer_status;

        //timer starting, save the timer starting moment timestamp
        if ($timer_status == 1) {
            $data['timer_starting_timestamp'] = strtotime(date("d-m-y H:i:s"));
        }

        //timer stopping, append the total_time_spent with difference from current timestamp and timer starting timestamp 
        else if ($timer_status == 0) {
            $current_moment_timestamp = strtotime(date("d-m-y H:i:s"));
            $timer_starting_moment_timestamp = $this->db->get_where('project', array('project_id' => $project_id))->row()->timer_starting_timestamp;

            $second_to_append = $current_moment_timestamp - $timer_starting_moment_timestamp;
            $this->db->set('total_time_spent', 'total_time_spent+' . $second_to_append, FALSE);
        }

        $this->db->where('project_id', $project_id);
        $this->db->update('project', $data);
    }

    function update_project_task_timer($timer_status, $project_task_id) {

        $data['timer_status'] = $timer_status;

        //timer starting, save the timer starting moment timestamp
        if ($timer_status == 1) {

            if( !$this->check_timer_running($project_task_id) ){
                return 'Timer has already been started';
            }

            $data['timer_starting_timestamp'] = strtotime(date("d-m-y H:i:s"));
            $this->db->set('timer_starter_account_type', $this->session->userdata('login_type'));
            $this->db->set('timer_started_by', $this->session->userdata('login_user_id'));
        }

        //timer stopping, append the total_time_spent with difference from current timestamp and timer starting timestamp 
        else if ($timer_status == 0) {

            $current_moment_timestamp = strtotime(date("d-m-y H:i:s"));
            $project_task = $this->db->get_where('project_task', array('project_task_id' => $project_task_id))->row();
            $timer_starting_moment_timestamp = $project_task->timer_starting_timestamp;
            $project_id = $project_task->project_id;

            $second_to_append = $current_moment_timestamp - $timer_starting_moment_timestamp;

            $this->db->set('total_time_spent', 'total_time_spent+' . $second_to_append, FALSE);
            $this->db->where( 'project_id', $project_id );
            $this->db->update('project');

            $this->db->set('timer_starter_account_type', '');
            $this->db->set('timer_started_by', 0);
            $this->db->set('time_remaining', 'time_remaining-' . $second_to_append, FALSE);
        }

        $this->db->where('project_task_id', $project_task_id);
        $this->db->update('project_task', $data);
    }

    function check_timer_running( $project_task_id ){

        $timer_status = $this->db->get_where('project_task', array('project_task_id' => $project_task_id))->row()->timer_status;

        if( $timer_status == 0 ){
            return true;
        } else {
            return false;
        }

    }

    ////////project_categories/////////////
    function create_project_category() {
        $data['name'] = $this->input->post('name');
        $data['description'] = $this->input->post('description');
        $this->db->insert('project_category', $data);
    }

    function update_project_category($project_category_id) {
        $data['name'] = $this->input->post('name');
        $data['description'] = $this->input->post('description');

        $this->db->where('project_category_id', $project_category_id);
        $this->db->update('project_category', $data);
    }

    function delete_project_category($project_category_id) {
        $this->db->where('project_category_id', $project_category_id);
        $this->db->delete('project_category');
    }
    
    function create_project_quote() 
    {
        $data['title']          = $this->input->post('name');
        $data['description']    = $this->input->post('description');
        $data['user_id']        = $this->session->userdata('login_user_id');
        $data['timestamp']      = strtotime($this->input->post('timestamp'));
        $data['amount']         = $this->input->post('amount');

        $this->db->insert('quote', $data);
    }
    
    function update_project_quote($quote_id) 
    {
        $data['title']          = $this->input->post('name');
        $data['description']    = $this->input->post('description');
        $data['timestamp']      = strtotime($this->input->post('timestamp'));
        $data['amount']         = $this->input->post('amount');

        $this->db->where('quote_id', $quote_id);
        $this->db->update('quote', $data);
    }
    
    function delete_project_quote($quote_id) 
    {
        $this->db->where('quote_id', $quote_id);
        $this->db->delete('quote');
    }
    
    function archive_project_quote($quote_id)
    {
        $this->db->set('status', 1);
        $this->db->where('quote_id',$quote_id);
        $this->db->update('quote');
    }
    
    function unarchive_project_quote($quote_id)
    {
        $this->db->set('status', 0);
        $this->db->where('quote_id',$quote_id);
        $this->db->update('quote');
    }

    ////////CLIENTS/////////////
    function create_client() {
        $data['name'] = $this->input->post('name');
        $data['email'] = $this->input->post('email');
        $data['password'] = sha1($this->input->post('password'));
        $data['address'] = $this->input->post('address');
        $data['phone'] = $this->input->post('phone');
        $data['company'] = $this->input->post('company');
        $data['website'] = $this->input->post('website');
        $data['skype_id'] = $this->input->post('skype_id');
        $data['facebook_profile_link'] = $this->input->post('facebook_profile_link');
        $data['linkedin_profile_link'] = $this->input->post('linkedin_profile_link');
        $data['twitter_profile_link'] = $this->input->post('twitter_profile_link');
        $data['short_note'] = $this->input->post('short_note');

        $this->db->insert('client', $data);
        $client_id = mysql_insert_id();

        // email notification check
        if ($this->input->post('notify_check') == 'yes')
            $this->email_model->notify_email('new_client_account_opening', $client_id, $this->input->post('password'));

        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/client_image/' . $client_id . '.jpg');
    }

    function update_client($client_id) {
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
        $data['short_note'] = $this->input->post('short_note');

        $this->db->where('client_id', $client_id);
        $this->db->update('client', $data);
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/client_image/' . $client_id . '.jpg');
    }

    function delete_client($client_id) {
        $this->db->where('client_id', $client_id);
        $this->db->delete('client');
    }
    
    function approve_pending_client_info($client_pending_id)
    {
        $pending_client = $this->db->get_where('client_pending', array('client_pending_id' => $client_pending_id))->result_array();
        foreach ($pending_client as $row)
        {
            $data['name']       = $row['name'];
            $data['email']      = $row['email'];
            $data['password']   = $row['password'];
            $this->db->insert('client', $data);
            $client_id = mysql_insert_id();

            // sending email notification to client upon account confirmation
            $this->email_model->notify_email('new_client_account_confirm', $client_id);
        }
        
        $this->db->where('client_pending_id', $client_pending_id);
        $this->db->delete('client_pending');
    }
    
    function delete_pending_client_info($client_pending_id)
    {
        $this->db->where('client_pending_id', $client_pending_id);
        $this->db->delete('client_pending');
    }


    ////////LEADS/////////////
    function create_lead() {
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
        $data['short_note'] = $this->input->post('short_note');
        $data['lead_condition'] = $this->input->post('lead_condition');
        $data['added_by']   = $this->get_user_account_name();
        $data['date_added'] = date('m/d/Y');

        $this->db->insert('lead', $data);
        $lead_id = mysql_insert_id();

        // email notification check
        if ($this->input->post('notify_check') == 'yes')
            $this->email_model->notify_email('new_lead_account_opening', $lead_id, $this->input->post('password'));

    }

    function update_lead($lead_id) {
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
        $data['short_note'] = $this->input->post('short_note');
        $data['lead_condition'] = $this->input->post('lead_condition');

        $this->db->where('lead_id', $lead_id);
        $this->db->update('lead', $data);
    }

    function delete_lead($lead_id) {
        $this->db->where('lead_id', $lead_id);
        $this->db->delete('lead');
    }

    function approve_pending_lead_info($lead_id)
    {
        $lead = $this->db->get_where('lead', array('lead_id' => $lead_id))->result_array();
        foreach ($lead as $row)
        {
            $data['name']       = $row['name'];
            $data['email']      = $row['email'];
            $data['password']   = sha1( 'password1' );
            $this->db->insert('client', $data);
            $client_id = mysql_insert_id();

            // sending email notification to client upon account confirmation
            $this->email_model->notify_email('new_client_account_confirm', $client_id);
        }
        
        $this->db->where('lead_id', $lead_id);
        $this->db->delete('lead');
    }

    ////////staffS/////////////
    function create_staff() {
        $data['name'] = $this->input->post('name');
        $data['account_role_id'] = $this->input->post('account_role_id');
        $data['email'] = $this->input->post('email');
        $data['password'] = sha1($this->input->post('password'));
        $data['phone'] = $this->input->post('phone');
        $data['skype_id'] = $this->input->post('skype_id');
        $data['facebook_profile_link'] = $this->input->post('facebook_profile_link');
        $data['linkedin_profile_link'] = $this->input->post('linkedin_profile_link');
        $data['twitter_profile_link'] = $this->input->post('twitter_profile_link');

        $this->db->insert('staff', $data);
        $staff_id = mysql_insert_id();

        // email notification check
        if ($this->input->post('notify_check') == 'yes')
            $this->email_model->notify_email('new_staff_account_opening', $staff_id, $this->input->post('password'));

        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/staff_image/' . $staff_id . '.jpg');
    }

    function update_staff($staff_id) {
        $data['name'] = $this->input->post('name');
        $data['account_role_id'] = $this->input->post('account_role_id');
        $data['email'] = $this->input->post('email');
        $data['phone'] = $this->input->post('phone');
        $data['skype_id'] = $this->input->post('skype_id');
        $data['facebook_profile_link'] = $this->input->post('facebook_profile_link');
        $data['linkedin_profile_link'] = $this->input->post('linkedin_profile_link');
        $data['twitter_profile_link'] = $this->input->post('twitter_profile_link');

        $this->db->where('staff_id', $staff_id);
        $this->db->update('staff', $data);
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/staff_image/' . $staff_id . '.jpg');
    }

    function delete_staff($staff_id) {
        $this->db->where('staff_id', $staff_id);
        $this->db->delete('staff');
    }

    function staff_permission($account_permission_id = '') {
        $current_staff_account_role_id = $this->db->get_where('staff', array('staff_id' => $this->session->userdata('login_user_id')))
                        ->row()->account_role_id;

        $current_staff_account_permissions = $this->db->get_where('account_role', array('account_role_id' => $current_staff_account_role_id))
                        ->row()->account_permissions;

        if (in_array($account_permission_id, explode(',', $current_staff_account_permissions))) {
            return true;
        } else {
            return false;
        }
    }

    function get_account_role_id( $account_role_id = '' ){

        $current_account_role_id = $this->db->get_where( 'staff', array( 'staff_id' => $this->session->userdata('login_user_id') ) )->row()->account_role_id;

        if( $current_account_role_id != $account_role_id ){
            return true;
        } else {
            return false;
        }

    }

    function get_user_account_name(){

        $array =  array( 
            $this->session->userdata('login_type').'_id' => $this->session->userdata('login_user_id')
        );

        return $this->db->get_where($this->session->userdata('login_type'), $array )->row()->name;

    }

    ////////account_roles/////////////
    function create_account_role() {
        $checked_permissions = $this->input->post('permission');
        $total_checked_values = count($checked_permissions);
        $permissions = '';
        for ($i = 0; $i < $total_checked_values; $i++) {
            $permissions .= $checked_permissions[$i] . ",";
        }

        $data['account_permissions'] = $permissions;
        $data['name'] = $this->input->post('name');
        $this->db->insert('account_role', $data);
    }

    function update_account_role($account_role_id) {
        $checked_permissions = $this->input->post('permission');
        $total_checked_values = count($checked_permissions);
        $permissions = '';
        for ($i = 0; $i < $total_checked_values; $i++) {
            $permissions .= $checked_permissions[$i] . ",";
        }

        $data['account_permissions'] = $permissions;
        $data['name'] = $this->input->post('name');

        $this->db->where('account_role_id', $account_role_id);
        $this->db->update('account_role', $data);
    }

    function delete_account_role($account_role_id) {
        $this->db->where('account_role_id', $account_role_id);
        $this->db->delete('account_role');
    }

    //////system settings//////
    function update_system_settings() {
        $data['description'] = $this->input->post('system_name');
        $this->db->where('type', 'system_name');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('system_title');
        $this->db->where('type', 'system_title');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('address');
        $this->db->where('type', 'address');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('phone');
        $this->db->where('type', 'phone');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('paypal_email');
        $this->db->where('type', 'paypal_email');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('system_currency_id');
        $this->db->where('type', 'system_currency_id');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('system_email');
        $this->db->where('type', 'system_email');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('buyer');
        $this->db->where('type', 'buyer');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('system_name');
        $this->db->where('type', 'system_name');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('purchase_code');
        $this->db->where('type', 'purchase_code');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('language');
        $this->db->where('type', 'language');
        $this->db->update('settings', $data);
        $this->session->set_userdata('current_language', $this->input->post('language'));

        $data['description'] = $this->input->post('text_align');
        $this->db->where('type', 'text_align');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('theme');
        $this->db->where('type', 'theme');
        $this->db->update('settings', $data);
    }

    /////email template settings////
    function save_email_template($email_template_id) {
        $data['subject'] = $this->input->post('subject');
        $data['body'] = $this->input->post('body');

        $this->db->where('email_template_id', $email_template_id);
        $this->db->update('email_template', $data);
    }

    /////creates log/////
    function create_log($data) {
        $data['timestamp'] = strtotime(date('Y-m-d') . ' ' . date('H:i:s'));
        $data['ip'] = $_SERVER["REMOTE_ADDR"];
        $location = new SimpleXMLElement(file_get_contents('http://freegeoip.net/xml/' . $_SERVER["REMOTE_ADDR"]));
        $data['location'] = $location->City . ' , ' . $location->CountryName;
        $this->db->insert('log', $data);
    }

    ////////BACKUP RESTORE/////////
    function create_backup($type) {
        $this->load->dbutil();


        $options = array(
            'format' => 'txt', // gzip, zip, txt
            'add_drop' => TRUE, // Whether to add DROP TABLE statements to backup file
            'add_insert' => TRUE, // Whether to add INSERT data to backup file
            'newline' => "\n"               // Newline character used in backup file
        );


        if ($type == 'all') {
            $tables = array('');
            $file_name = 'system_backup';
        } else {
            $tables = array('tables' => array($type));
            $file_name = 'backup_' . $type;
        }

        $backup = & $this->dbutil->backup(array_merge($options, $tables));


        $this->load->helper('download');
        force_download($file_name . '.sql', $backup);
    }

    /////////RESTORE TOTAL DB/ DB TABLE FROM UPLOADED BACKUP SQL FILE//////////
    function restore_backup() {
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/backup.sql');
        $this->load->dbutil();


        $prefs = array(
            'filepath' => 'uploads/backup.sql',
            'delete_after_upload' => TRUE,
            'delimiter' => ';'
        );
        $restore = & $this->dbutil->restore($prefs);
        unlink($prefs['filepath']);
    }

    /////////DELETE DATA FROM TABLES///////////////
    function truncate($type) {
        if ($type == 'all') {
            $this->db->truncate('student');
            $this->db->truncate('mark');
            $this->db->truncate('teacher');
            $this->db->truncate('subject');
            $this->db->truncate('class');
            $this->db->truncate('exam');
            $this->db->truncate('grade');
        } else {
            $this->db->truncate($type);
        }
    }

    ////////IMAGE URL//////////
    function get_image_url($type = '', $id = '') {
        if (file_exists('uploads/' . $type . '_image/' . $id . '.jpg'))
            $image_url = base_url() . 'uploads/' . $type . '_image/' . $id . '.jpg';
        else
            $image_url = base_url() . 'uploads/user.jpg';

        return $image_url;
    }

}