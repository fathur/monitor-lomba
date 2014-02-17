<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article extends CI_Model {
	
	var $table = 'article';
	
	function __construct() {
		parent::__construct();
		
	}
	
	function get_rule() {
		$this->db->select('*');
		$this->db->from('article');
		$this->db->where('id',1);
		$query = $this->db->get();
		$r = $query->row();
		return $r;
	}
	
	function save() {		
	
		$post		= array();
		
		$inputpost	= $this->input->post();
			
		foreach ($inputpost as $input => $value) {
			$post[$input]	= $this->input->post($input);
		}			
	
		if ($post['id'] != '') {
	
			$this->db->update($this->table, $post, array(
				'id' => $post['id']
			));
	
			if ($this->db->affected_rows() > 0) {
				return TRUE;
					
			} else {
				return FALSE;
					
			}
	
		} else {
	
			$this->db->insert($table, $post);
	
			if ($this->db->affected_rows() > 0) {
				return TRUE;
			} else {
				return FALSE;
	
			}
	
		}
	}
}