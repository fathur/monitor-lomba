<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Soal extends CI_Controller {
	
	function __construct() {
		parent::__construct();
	
		$this->load->model('credential','ct');
		$this->load->model('lomba');
		$this->load->model('msoal','sa');
	}
	
	function index() {
		$this->ct->auth('admin',urlencode(current_url()));
		
		$data = array();
		$this->templates->juragan('soal/daftar',$data);
	}
	
	function category() {
		$this->ct->auth('admin',urlencode(current_url()));
		
		$data = array();
		$this->templates->juragan('soal/category',$data);
	}
	
	function cat($opt) {
		$this->ct->auth('admin',urlencode(current_url()));
		
		switch ($opt) {
			case 'json':
				$format = $this->uri->segment(4);
				$return	= $this->lomba->json();
				
				if ($format == 'tree') {
					$rows	= $return['rows'];
					$json	= array();
					foreach ($rows as $row) {
						array_push($json, array(
							'id'	=> $row['id'],
							'text'	=> $row['nama']
						));
					}
				} elseif ($format == 'combobox') {
					$rows	= $return['rows'];
					$json	= array();
					foreach ($rows as $row) {
						array_push($json, array(
							'id'	=> $row['id'],
							'text'	=> $row['nama']
						));
					}
				} else {
					$json['total']	= $return['count'];
					$json['rows']	= $return['rows'];
				}
				
				echo json_encode($json);
			break;
			
			case "save":
				$this->lomba->save();
			break;
			
			case "delete":
				$this->lomba->delete();
			break;
		}
	}
	
	function daftar($opt) {
		$this->ct->auth('admin',urlencode(current_url()));
	
		switch ($opt) {
			case 'json':
				$format = $this->uri->segment(4);
				$return	= $this->sa->json();
	
				if ($format == 'tree') {
					$rows	= $return['rows'];
					$json	= array();
					foreach ($rows as $row) {
						array_push($json, array(
						'id'	=> $row['id'],
						'text'	=> $row['nama']
						));
					}
				} else {
					$json['total']	= $return['count'];
					$json['rows']	= $return['rows'];
				}
	
				echo json_encode($json);
				break;
					
			case "save":
				$this->sa->save();
				break;
					
			case "delete":
				$this->sa->delete();
				break;
		}
	}
}