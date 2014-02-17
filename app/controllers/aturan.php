<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aturan extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		
		$this->load->model('credential','ct');
		$this->load->model('article');
		
		$this->load->helper('form');
	}
	
	function index() {
		$this->ct->auth('admin,juri',urlencode(current_url()));
		
		$data['aturan']	= $this->article->get_rule();
		
		$this->templates->juragan('aturan/edit',$data);
	}
	
	function race() {
		
		$this->ct->auth('team',urlencode(current_url()));
		
		$data['aturan']	= $this->article->get_rule();
		$this->templates->pusdatin('aturan/peserta',$data);
	}
	
	function save() {
		
		$this->ct->auth('admin,juri',urlencode(current_url()));
		
		$result = $this->article->save();
		
		if ($result) {
			$this->templates->juragan('aturan/success');
		} else {
			$this->templates->juragan('aturan/failed');
		}
	}
	
	function tst() {
		$this->load->view('aturan/success');
		
		exit();
		
		$this->load->view('aturan/failed');
	}
}