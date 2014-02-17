<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {		
	
	function __construct() {
		parent::__construct();
		
		$this->load->model('credential');
		$this->load->helper('html');
		
		$this->load->library('form_validation');
	}
	
	function index() {
		$this->templates->juragan('users/listusers');
	}
	
	function json() {
		$return	= $this->credential->json();
		$json['total']	= $return['count'];
		$json['rows']	= $return['rows'];
		echo json_encode($json);
	}
	
	function save() {
		$this->credential->save();
	}
	
	function delete() {
		$this->credential->delete();
	}
	
	function verify() {
		/*	Validasi form terlebih dahulu*/
		
		$this->form_validation->set_rules('username','username','trim|xss_clean');
		$this->form_validation->set_rules('password','password','trim|xss_clean');
		
		/*	Jika validasi salah,
		 maka akan diperlihatkan halaman login*/
		if ($this->form_validation->run() == FALSE){
		
			redirect('juragan');
		}
		
		/*	Jika validasi benar,
		 maka akan dilakukan pengecekan username dan password */
		else {
		
			extract($_POST);
		
			/*	Proses mencocokkan ke database */
			$user_id		= $this->credential->check_login($username, $password);
		
			/*	Set hak akses user */
			$user_level 	= $this->credential->check_level($username, $password);
		
			if (! $user_id){
		
				/*If user id doesn't exist, set temporary session
				 for annaouncement in login page.
				And redirect to this controller again.
				"See login_view.php,,,,"
				*/
		
				$this->session->set_flashdata(array(
					'login_error' 	=> TRUE,					
				));
					
				redirect('juragan');
				/*
				$xxx = $this->session->flashdata('login_error');
				print_r($xxx);
				*/
			}
			else{
		
				/*	If user id exist
				 set session, where contain
				status, user id, username, and access right.
				And redirect to it's access page*/
				$this->session->set_userdata(array(
					'login'		=> TRUE,
					'userid'	=> $user_id,
					'username'	=> $username,
					'level'		=> $user_level
				));

				redirect('monitor/mon');
			}
		}
	}
	
	function notAuthorized() {
		
		if ($this->session->userdata('level') == 'admin') {
			$this->templates->juragan('users/not_authorized');
		} elseif ($this->session->userdata('level') == 'juri') {
			$this->templates->juragan('users/not_authorized');
		} elseif ($this->session->userdata('level') == 'team') {
			$this->templates->pusdatin('users/not_authorized');
		} else {
			
			$data['js']	= base_url() . 'resources/css/';
			$this->load->view('users/not_authorized_keluar',$data);
		}
	}
	
	function cekSession() {
		print_r($this->session->userdata);
		
		$level	= "juri,admin";
		
		$levelx	= explode(",", $level);
		
		if (count($levelx) > 1) {
			
			if ($this->session->userdata('login')) {								
				
				if (($this->session->userdata('level') == $levelx[0]) || ($this->session->userdata('level') == $levelx[1])) {
					//return TRUE;;
					echo "TRUE";
				} else {
				//redirect('juragan?directto='.urlencode($urlredirect));
					echo "redirect";
				}
				// 
			} else {
				//redirect('juragan?directto='.urlencode($urlredirect));
				echo "redirect";
			}						
		} else {
			if ($this->session->userdata('login')) {
				if ($this->session->userdata('level') == $levelx[0]) {
					//return TRUE;;
					echo "TRUE";
				} else {
				//redirect('juragan?directto='.urlencode($urlredirect));
					echo "redirect";
				}
				//
			} else {
				//redirect('juragan?directto='.urlencode($urlredirect));
				echo "redirect";
			}		
		}
	}
	
	function keluar($level) {
		$this->session->sess_destroy();
		
		switch ($level) {
			case 'admin':
			case 'juri':
				redirect('juragan');
			break;
				
			default:
				redirect();
			break;
		}
		
	}
}