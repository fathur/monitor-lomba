<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/*
 * Library umum untuk memanggil fungsi-fungsi yang
 * dibutuhkan oleh controller lain
 */
class Main {
	
	function __construct() {
		
		$CI	=& get_instance();
		
		$CI->load->model('menu_level_model','ml');
	}
	
	/**
	 * 
	 * Otorisasi ini digunakan untuk mendaftarkan menu 
	 * agar dapat dilihat oleh user yang sudah di daftarkan menu
	 * 
	 */
	function otorisasi() {
		
		$CI	=& get_instance();
		
		$url	= $CI->uri->segment(1) . '/' . $CI->uri->segment(2);	//uri_string();
		$level	= $CI->session->userdata('level');
		
		$cek	= $CI->ml->cek_otorisasimenu($url,$level);
		
		if ($CI->session->userdata('login') AND ($cek->num_rows() == 0)) {
			
			redirect('backend/error404');
		} elseif (!$CI->session->userdata('login')) {
			redirect('backend?redirect='.urlencode($url));
		}
	}
	
	/**
	 * Agar fungsi fungsi tertentu dapat dilihat dan digunakan
	 * oleh beberapa level
	 */
	function otorisasi_umum() {
		$CI	=& get_instance();
		
		if ( ! $CI->session->userdata('login') ) {
			redirect('mimin');
		}
	}	
}