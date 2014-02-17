<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Race extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		

		$this->load->model('score','sc');
		$this->load->model('team');
		
		
		
		$this->load->library('form_validation');
	}
	
	function score() {
		$data['score']	= $this->sc->totalperteam();
		$this->load->view('race/nilai',$data);
	}
	
	function verify() {
		
	
		$this->form_validation->set_rules('username','username','trim|xss_clean');
		$this->form_validation->set_rules('password','password','trim|xss_clean');
	
		
		if ($this->form_validation->run() == FALSE){
	
			redirect('race');
		}
	
		else {
			extract($_POST);

			$user_id		= $this->team->check_login($username, $password);

			echo $user_id;
	
			if (! $user_id){

				$this->session->set_flashdata(array(
					'login_error' 	=> TRUE,					
				));
				
				redirect();
	
			}
			else{
	
			
				$this->session->set_userdata(array(
					'login'		=> TRUE,
					'userid'	=> $user_id,
					'username'	=> $username,
					'level'		=> 'team'
				));
	
				redirect('monitor/race');
			}
		}
	}
}
