<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Templates {
		
	public function pusdatin($view, $site = '') {
		$CI	=& get_instance();
		
		$CI->load->helper('html');
		
		$data['css']		= base_url() . 'resources/css/';
		$data['js']			= base_url() . 'resources/js/';
		$data['img']		= base_url() . 'resources/img/';			
		
		$data['content']	= $CI->load->view($view, $site, TRUE);
		
		$CI->load->view('pusdatin',$data);
	}
	
	public function juragan($view, $site = '') {
		$CI	=& get_instance();
	
		$CI->load->helper('html');
	
		$data['css']		= base_url() . 'resources/css/';
		$data['js']			= base_url() . 'resources/js/';
		$data['img']		= base_url() . 'resources/img/';
		
		$site['js']	= $data['js'];
	
		$data['content']	= $CI->load->view($view, $site, TRUE);
	
		$CI->load->view('juragan',$data);
	}
}

/* End of file Someclass.php */