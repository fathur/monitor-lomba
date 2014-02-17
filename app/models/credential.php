<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Credential extends CI_Model {
	
	var $table	= 'credential';
	
	function __construct() {
		
		parent::__construct();		
	}
	
	function json() {
	
		$page 	= isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows 	= isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort 	= isset($_POST['sort']) ? $_POST['sort'] : 'itemid';
		$order 	= isset($_POST['order']) ? $_POST['order'] : 'asc';
		$q		= isset($_POST['q']) ? strval($_POST['q']) : '';
		$offset = ($page-1) * $rows;
	
		$this->db->select('*');
		$this->db->from('credential');
		$this->db->limit($rows, $offset);
		$this->db->order_by('id', 'desc');
		$query	= $this->db->get();
		$result	= $query->result_array();		
		$count	= $this->db->count_all('team');
		
		return array(
			'rows'		=> $result,
			'count'		=> $count
		);	
	}
	
	function save($table = 'credential') {
	
		$post		= array();
		$inputpost	= $this->input->post();
			
		foreach ($inputpost as $input => $value) {
			$post[$input]	= $this->input->post($input);
		}
		
		$post['password']	= sha1($post['password']); 
	
		if ($post['id'] != '') {
	
			$this->db->update($table, $post, array(
					'id' => $post['id']
			));
	
			if ($this->db->affected_rows() > 0) {
				echo 1;
					
			} else {
				echo 0;
					
			}
	
		} else {
	
			$this->db->insert($table, $post);
	
			if ($this->db->affected_rows() > 0) {
				echo 1;
			} else {
				echo 0;
	
			}
	
		}
	}
	
	function delete($table = 'credential') {
	
		$this->db->delete($table, array(
				'id' => $this->input->post('id'),
		));
	
		if ($this->db->affected_rows() > 0) {
			echo 1;
				
		} else {
			echo 0;
		}
	}
	
	function check_login($username, $password){
	
		$password	= hash('sha1', $password);
	
		$this->db->select('id');
		$this->db->from($this->table);
		$this->db->where(array(
			'username'	=> $username,
			'password'	=> $password		
		));
	
		$result	= $this->db->get();
	
		if($result->num_rows() == 1){
			return $result->row()->id;
		}else{
			return FALSE;
		}
	}
	
	function check_level($username, $password) {
	
		$password	= hash('sha1', $password);
	
		$this->db->select('level');
		$this->db->from($this->table);
		$this->db->where(array(
			'username'	=> $username,
			'password'	=> $password
		));
	
		$result	= $this->db->get();
	
		if($result->num_rows() == 1){
			return $result->row()->level;
		}else{
			return FALSE;
		}
	}
	
	function auth($level, $urlredirect = '') {
		
		$levelx	= explode(",", $level);			
		
		if (count($levelx) > 1) {
			
			if ($this->session->userdata('login')) {								
				
				if (($this->session->userdata('level') == $levelx[0]) || ($this->session->userdata('level') == $levelx[1])) {
					return TRUE;;
					
				} else {
					redirect('users/notAuthorized?directto='.urlencode($urlredirect));
					
				}
				 
			} else {
				redirect('users/notAuthorized?directto='.urlencode($urlredirect));
				
			}						
		} else {
			if ($this->session->userdata('login')) {
				if ($this->session->userdata('level') == $levelx[0]) {
					return TRUE;;
					
				} else {
					redirect('users/notAuthorized?directto='.urlencode($urlredirect));
					
				}
				
			} else {
				redirect('users/notAuthorized?directto='.urlencode($urlredirect));				
			}		
		}
	}
}