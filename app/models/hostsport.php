<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hostsport extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	function get_port($team_id) {
		$this->db->select('hosts.id, hosts.team_id, hosts.hostname, hosts.ipaddr, port.name, hosts_port.port_number,hosts_port.status');
		$this->db->from('port');
		$this->db->join('hosts_port','port.id = hosts_port.port_id','right');
		$this->db->join('hosts','hosts.id = hosts_port.hosts_id','right');
		$this->db->where('hosts.team_id', $team_id);
		$query	= $this->db->get();
		$result	= $query->result_array();
		return $result;
	}
	
	function get_allport() {
		$this->db->select('hosts.id, hosts.team_id, hosts.hostname, hosts.ipaddr, port.name, hosts_port.port_number,hosts_port.status, team.team_name');
		$this->db->from('hosts_port');
		$this->db->join('port','hosts_port.port_id = port.id','right');
		$this->db->join('hosts','hosts_port.hosts_id = hosts.id','right');
		$this->db->join('team','hosts.team_id = team.id','right');
		$query	= $this->db->get();
		$result	= $query->result_array();
		return $result;
	}
	
	function get_hostdetail($team_id) {
		$this->db->select('hosts.id, hosts.team_id, hosts.hostname, hosts.ipaddr, port.name, hosts_port.port_number,hosts_port.status, team.team_name');
		$this->db->from('hosts_port');
		$this->db->join('port','hosts_port.port_id = port.id','right');
		$this->db->join('hosts','hosts_port.hosts_id = hosts.id','right');
		$this->db->join('team','hosts.team_id = team.id','right');
		$this->db->where('hosts.team_id', $team_id);
		$query	= $this->db->get();
		$result	= $query->result_array();
		return $result;
	}
	
	function get_jsonhostport($host_id) {
		
		$page 	= isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows 	= isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort 	= isset($_POST['sort']) ? $_POST['sort'] : 'itemid';
		$order 	= isset($_POST['order']) ? $_POST['order'] : 'asc';
		$q		= isset($_POST['q']) ? strval($_POST['q']) : '';
		$offset = ($page-1) * $rows;
		
		$this->db->select('hosts_port.*, port.name');
		$this->db->from('hosts_port');
		$this->db->join('port','hosts_port.port_id = port.id','right');		
		$this->db->where('hosts_port.hosts_id', $host_id);
		$this->db->limit($rows, $offset);
		$query	= $this->db->get();
		$result	= $query->result_array();
		
		$count	= $this->db->count_all('team');
		
		return array(
					'rows'		=> $result,
					'count'		=> $count
		);		
	}
	
	function save($table = 'hosts_port') {
		$post		= array();
		$inputpost	= $this->input->post();
			
		foreach ($inputpost as $input => $value) {
			$post[$input]	= $this->input->post($input);
		}
		
		if (($post['hosts_id'] != '') AND ($post['port_id'] != '')) {
		
			$this->db->update($table, $post, array(
				'hosts_id' 	=> $post['hosts_id'],
				'port_id'	=> $post['port_id']
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
	
	function get_tim_port($idh) {
		$this->db->select('port.name, hosts_port.port_id, port_number');
		$this->db->from('hosts_port');
		$this->db->join('port','hosts_port.port_id = port.id','left');
		$this->db->where('hosts_id',$idh);
		$query = $this->db->get();
		$result	= $query->result();
		return $result;
	}
	
	function get_host_status($id) {
		$this->db->select('hosts_port.*,port.name');
		$this->db->from('hosts_port');
		$this->db->join('port','port.id = hosts_port.port_id','inner');
		$this->db->where('hosts_id',$id);
		$query = $this->db->get();
		$result	= $query->result();
		return $result;
	}
	
	function set_host_status($status,$condition) {
		$this->db->where('hosts_id',$condition['hosts_id']);
		$this->db->where('port_id',$condition['port_id']);
		$this->db->update('hosts_port', array(
			'status'	=> $status
		));
	}
}