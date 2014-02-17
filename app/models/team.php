<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Team extends CI_Model {
	
	var $table = 'team';
	
	function __construct() {
		parent::__construct();
		
	}
	
	function get_team() {
		$this->db->select('*');
		$this->db->from('team');
		$query	= $this->db->get();
		$result	= $query->result_array();
		return $result;
	}
	
	function get_myteam($teamid) {
		$this->db->select('*');
		$this->db->from('team');
		$this->db->where('id',$teamid);
		$query	= $this->db->get();
		$result	= $query->row();
		return $result;
	}
	
	function json() {
	
		$page 	= isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows 	= isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort 	= isset($_POST['sort']) ? $_POST['sort'] : 'itemid';
		$order 	= isset($_POST['order']) ? $_POST['order'] : 'asc';
		$q		= isset($_POST['q']) ? strval($_POST['q']) : '';
		$offset = ($page-1) * $rows;
	
		$this->db->select('*');
		$this->db->from('team');
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
	
	function save($table = 'team') {
		
		$post		= array();		
		$inputpost	= $this->input->post();
			
		foreach ($inputpost as $input => $value) {
			$post[$input]	= $this->input->post($input);
		}
		
		$post['team_password']	= sha1($post['team_password']);
		
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
	
	function delete($table = 'team') {
		
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
				'team_username'	=> $username,
				'team_password'	=> $password		
		));
	
		$result	= $this->db->get();
	
		if($result->num_rows() == 1){
			return $result->row()->id;
		}else{
			return FALSE;
		}
	}
}