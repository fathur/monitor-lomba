<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lomba extends CI_Model {
	
	var $table = 'lomba';
	
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
		$this->db->from($this->table);
		$this->db->limit($rows, $offset);
		$this->db->order_by('nama', 'asc');
		$query	= $this->db->get();
		$result	= $query->result_array();
		$count	= $this->db->count_all($this->table);
		
		return array(
			'rows'		=> $result,
			'count'		=> $count
		);
	}
	
	function save($table = 'lomba') {
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
	
	function delete($table = 'lomba') {
	
		$this->db->delete($table, array(
			'id' => $this->input->post('id'),
		));
	
		if ($this->db->affected_rows() > 0) {
			echo 1;				
		} else {
			echo 0;
		}
	}
	
	function cek_time() {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where("NOW() BETWEEN start AND end", NULL, FALSE);
				
		$query = $this->db->get();
		return $query->row();
	}
	
	function get_lomba() {
		$this->db->select('*');
		$this->db->from($this->table);
		
		$query = $this->db->get();
		return $query->result();
	}
}