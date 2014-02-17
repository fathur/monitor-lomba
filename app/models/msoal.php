<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MSoal extends CI_Model {
	
	var $table = 'soal';
	
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
		
		$this->db->select($this->table.'.*, lomba.nama AS nama_lomba');
		$this->db->from($this->table);
		$this->db->limit($rows, $offset);
		$this->db->join('lomba','lomba.id='.$this->table.'.lomba_id','left');
		$this->db->order_by('lomba_id', 'asc');
		$this->db->order_by('order', 'asc');
		$query	= $this->db->get();
		$result	= $query->result_array();
		$count	= $this->db->count_all($this->table);
		
		return array(
			'rows'		=> $result,
			'count'		=> $count
		);
	}
	
	function save($table = 'soal') {
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
	
	function delete($table = 'soal') {
	
		$this->db->delete($table, array(
			'id' => $this->input->post('id'),
		));
	
		if ($this->db->affected_rows() > 0) {
			echo 1;				
		} else {
			echo 0;
		}
	}
	
	function soal($lomba_id) {
		$this->db->select('id,order,soal,nilai');
		$this->db->from($this->table);
		$this->db->where('lomba_id',$lomba_id);
		$this->db->order_by('order', 'asc');
		$query	= $this->db->get();
		$result	= $query->result_array();
		return $result;
	}
	
	function get_true_answer($id) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('id',$id);
	
		$query	= $this->db->get();
		$result	= $query->row();
		return $result;
	}
}