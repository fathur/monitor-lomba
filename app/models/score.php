<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Score extends CI_Model {
	
	function __construct() {
		parent::__construct();
		
		$this->load->helper('date');
	}
	
	function totalperteam() {
		$this->db->select("team_name, SUM(score.score) AS jumlah, MAX(timestamp) AS timestamp");
		$this->db->from('score');
		$this->db->join('team','score.team_id = team.id','left');
		$this->db->group_by('team_id');
		$this->db->order_by('jumlah','desc');
		// $this->db->order_by('timestamp','desc');
		$query	= $this->db->get();
		$result	= $query->result_array();
		return $result;	
	}
	
	function get_score($teamid) {
		$this->db->select("*");
		$this->db->from('score');		
		$this->db->where('team_id',$teamid);
		$this->db->order_by('timestamp','asc');
		$query	= $this->db->get();
		$result	= $query->result_array();
		return $result;
	}
	
	function get_total($teamid) {
		$this->db->select("SUM(score.score) AS jumlah");
		$this->db->from('score');		
		$this->db->where('team_id',$teamid);
		$query	= $this->db->get();
		$result	= $query->row();
		return $result;
	}
	
	function save($table = 'port') {
	
		$post		= array();
		$inputpost	= $this->input->post();
			
		foreach ($inputpost as $input => $value) {
			$post[$input]	= $this->input->post($input);
		}
		
		$post['timestamp']	= mdate("%Y-%m-%d %H:%i:%s",now());
	
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
	
	function set_score($teamid, $score, $messages) {
		$this->db->insert('score',array(
			'team_id'	=> $teamid,
			'timestamp'	=> mdate('%Y-%m-%d %H:%i:%s',now()),
			'score'		=> $score,
			'messages'	=> $messages
		));
	}
}