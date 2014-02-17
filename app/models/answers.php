<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Answers extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->model('msoal','sa');
		$this->load->helper('date');
		
	}
	
	function set_answer($post) {
		
		$level = $this->session->userdata('level');
		// echo $level;
		
		if ($level == 'team') {
			$answer = $this->sa->get_true_answer($post['subject']);
			
			if ($post['message'] == $answer->jawaban) {
				$this->db->insert('answers',$post);
				$this->db->insert('score',array(
						'team_id'	=> $post['team_id'],
						'timestamp'	=> mdate('%Y-%m-%d %H:%i:%s',now()),
						'score'		=> $answer->nilai,
						'messages'	=> 'Jawaban soal '.$answer->order.' benar'
				));
			
				if ($this->db->affected_rows() > 0) {
					return TRUE;
				} else {
					return FALSE;
				}
			}
			return FALSE;
		} 
		
		// admin
		elseif ($level == 'admin') {

			$this->db->insert('answers',$post);
						
			if ($this->db->affected_rows() > 0) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
					
	}
	
	function set_answer_cnd($post) {
		$this->db->insert('answers',$post);
	
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function get_conversation($teamid, $lomba_id = '') {
		$this->db->select('answers.*, team.team_name');
		$this->db->from('answers');
		$this->db->where('team_id',$teamid);
		
		if ($lomba_id != '') {
			$this->db->where('lomba_id',$lomba_id);
		}
		
		$this->db->join('team','team.id = answers.team_id','left');
		$this->db->order_by('timestamp','asc');
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	
	function get_download($raw_name) {
		$this->db->select('*');
		$this->db->from('answers');
		$this->db->where('raw_name',$raw_name);		
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
	
	function get_answered($lomba_id,$team_id) {
		$this->db->select('subject');
		$this->db->from('answers');
		$this->db->where('lomba_id',$lomba_id);
		$this->db->where('team_id',$team_id);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
}