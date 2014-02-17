<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Port extends CI_Model {
	
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
		$this->db->from('port');
		$this->db->limit($rows, $offset);
		$this->db->order_by('name', 'asc');
		$query	= $this->db->get();
		$result	= $query->result_array();
		$count	= $this->db->count_all('port');
	
		return array(
			'rows'		=> $result,
			'count'		=> $count
		);	
	}
	
	function save($table = 'port') {
	
		$post		= array();
		$inputpost	= $this->input->post();
			
		foreach ($inputpost as $input => $value) {
			$post[$input]	= $this->input->post($input);
		}
	
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
	
	function delete($table = 'port') {
	
		$this->db->delete($table, array(
			'id' => $this->input->post('id'),
		));
	
		if ($this->db->affected_rows() > 0) {
			echo 1;
				
		} else {
			echo 0;
		}
	}
	
	function get_port() {
		$this->db->select('*');
		$this->db->from('port');
		$query = $this->db->get();
		return $query->result();
	}
}