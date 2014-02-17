<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Configuration extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	function get_val($key) {
		$this->db->select('value');
		$this->db->from('configuration');
		$this->db->where('key',$key);
		$query	= $this->db->get();
		$result	= $query->row();
		return $result;
	}
}