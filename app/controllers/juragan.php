<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Juragan extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		
		
		
		$this->load->helper('html');
		$this->load->helper('form');
		
	}
	
	public function index() {
		
		if ($this->session->userdata('login')) {
			
			redirect('monitor');
			
		} else {
		
			$data['js']	= base_url() . 'resources/js/';		
			$this->load->view('juragan/login',$data);
		}
	}	
}