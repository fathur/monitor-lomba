<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hosts extends CI_Model {
	
	function __construct() {
		parent::__construct();
		
	}
	
	function get_host($teamid) {
		$this->db->select('*');
		$this->db->from('hosts');
		$this->db->where('team_id',$teamid);
		//$this->db->join('team','team.id = answers.team_id','left');
		$this->db->order_by('hostname');
		$this->db->order_by('ipaddr');
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	
	function save($table = 'hosts') {
	
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
			
			$lastid	= $this->db->insert_id();
			
			if ($this->db->affected_rows() > 0) {
				$this->insertautoport($lastid);
				echo 1;
			} else {
				echo 0;
	
			}
	
		}
	}
	
	function delete($table = 'hosts') {
	
		$this->db->delete($table, array(
				'id' => $this->input->post('id'),
		));
	
		if ($this->db->affected_rows() > 0) {
			echo 1;
	
		} else {
			echo 0;
		}
	}
	
	private function insertautoport($lastid) {
		
		$this->db->select('*');
		$this->db->from('port');
		$this->db->where('status','on');
		$query1	= $this->db->get();
		$result1 = $query1->result_array();
		
		foreach ($result1 as $result) {
			$data['hosts_id']		= $lastid;
			$data['port_id']		= $result['id'];
			$data['port_number']	= $result['port_default'];
			
			$this->db->insert('hosts_port', $data);
		}
		
	}
}

