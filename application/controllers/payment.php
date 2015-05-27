<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends CI_Controller {

	
	function __construct()
    {
		parent::__construct();
		$this->load->database();
		/*cache control*/
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
    }
	
	/***default functin, redirects to login page if no admin logged in yet***/
	public function index()
	{
		
	}
	
	
	/*
	*	$method		=	paypal/skrill/2CO/mastercard
	*/
	function pay_invoice()
	{
		if ($this->session->userdata('client_login') != 1)
        	redirect(base_url() . 'index.php?login', 'refresh');
		
		$method				=	$this->input->post('method');
		
		if ($method == 'paypal')
			$this->paypal_payment();
		
		
	}
	
	function paypal_payment($param1 = '')
	{
		$invoice_number      	= $this->input->post('invoice_number');
		$paypal_email	 		= $this->db->get_where('settings', 	array('type' => 'paypal_email'))->row()->description;
		$invoice_details 		= $this->db->get_where('invoice', 		array('invoice_number' => $invoice_number))->row();
		$invoice_title			= $invoice_details->title;
		$total_amount			= $this->crud_model->calculate_invoice_total_amount($invoice_number);
		
		/****TRANSFERRING USER TO PAYPAL TERMINAL****/
		$this->paypal->add_field('rm', 2);
		$this->paypal->add_field('no_note', 0);
		$this->paypal->add_field('item_name', $invoice_title);
		$this->paypal->add_field('amount', $total_amount);
		$this->paypal->add_field('currency_code', 'GBP');
		$this->paypal->add_field('custom', $invoice_number);
		$this->paypal->add_field('business', $paypal_email);
		$this->paypal->add_field('notify_url', base_url() . 'index.php?payment/paypal_ipn');
		$this->paypal->add_field('cancel_return', base_url() . 'index.php?client/invoice/paypal_cancel');
		$this->paypal->add_field('return', base_url() . 'index.php?client/invoice/paypal_success');
		
		$this->paypal->submit_paypal_post();
	}
	
	// confirm paypal payment internally and preserve payment info into db via ipn call
	function paypal_ipn()
	{
		if ($this->paypal->validate_ipn() == true) 
		{
			$ipn_response = '';
			foreach ($_POST as $key => $value) {
				$value = urlencode(stripslashes($value));
				$ipn_response .= "\n$key=$value";
			}
			//update invoice status
			$data['status']            		=	'paid';
			$invoice_number					=	$_POST['custom'];
			$this->db->where('invoice_number', $invoice_number);
			$this->db->update('invoice', $data);
			
			//create new payment entry
			$data2['type']					=	'income';
			$data2['amount']				=	$this->crud_model->calculate_invoice_total_amount($invoice_number);
			$data2['title']					=	$this->db->get_where('invoice',array('invoice_number'=>$invoice_number))->row()->title;
			$data2['description']			=	$ipn_response;
			$data2['payment_method']		=	'paypal';
			$data2['invoice_number']		=	$invoice_number;
			$data2['project_id']			=	$this->db->get_where('invoice' , array('invoice_number'=>$invoice_number))->row()->project_id;
			$data2['timestamp']				=	strtotime(date("m/d/Y"));
			
			$this->db->insert('payment' , $data2);

			// notify client with payment confirmation
			$this->email_model->notify_email('payment_completion_notification' , $invoice_number);
		}
	}

	// admin can take payment of an invoice manually
	function take_payment_manually($invoice_number)
	{
		if ($this->session->userdata('admin_login') != 1)
			redirect(base_url(), 'refresh');

		$data2['type']					=	'income';
		$data2['amount']				=	$this->input->post('amount');
		$data2['title']					=	$this->db->get_where('invoice',array('invoice_number'=>$invoice_number))->row()->title;
		$data2['description']			=	$this->input->post('description');
		$data2['payment_method']		=	$this->input->post('payment_method');
		$data2['invoice_number']		=	$invoice_number;
		$data2['project_id']			=	$this->db->get_where('invoice' , array('invoice_number'=>$invoice_number))->row()->project_id;
		$data2['timestamp']				=	strtotime($this->input->post('timestamp'));

		$this->db->insert('payment' , $data2);
		// notify client with payment confirmation
		$this->email_model->notify_email('payment_completion_notification' , $invoice_number);

		$this->session->set_flashdata('flash_message' , get_phrase('payment_taken_successfully'));
		redirect(base_url().'index.php?admin/invoice', 'refresh');
	}
	
}

