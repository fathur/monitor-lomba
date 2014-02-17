<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tim extends CI_Controller {
	
	function __construct() {
		
		parent::__construct();
		
		$this->load->model('score','sc');
		$this->load->model('team');
		$this->load->model('hosts','hs');
		$this->load->model('hostsport','hp');
		$this->load->model('credential','ct');
		$this->load->model('port','pr');
		$this->load->model('configuration');
		
		$this->load->helper('form');
		
		$this->load->library('Snmp2');
	}
	
	function index() {
		$this->ct->auth('admin',urlencode(current_url()));
		
		$this->templates->juragan('tim/peserta');
	}
	
	function score() {
		// $data['score']	= $this->sc->totalperteam();
		//$this->load->view('tim/nilai',$data);
		
		$teamid	= $this->input->get('team');
		$data['teamid']	= $teamid;
		$data['myteam']	= $this->team->get_myteam($teamid);
		$data['scores']	= $this->sc->get_score($teamid);
		$data['total']	= $this->sc->get_total($teamid);
		
		$this->load->view('jawab/poinview',$data);
	}
	
	function json($format = '') {
		
		$this->ct->auth('admin',urlencode(current_url()));
		
		$return	= $this->team->json();
		
		if ($format == 'tree') {
			$rows	= $return['rows'];
			$json	= array();
			foreach ($rows as $row) {
				array_push($json, array(
					'id'	=> $row['id'],
					'text'	=> $row['team_name']
				));
			}
		} else {
			$json['total']	= $return['count'];
			$json['rows']	= $return['rows'];
		}
		
		echo json_encode($json);
	}
	
	function save() {
		
		$this->ct->auth('admin',urlencode(current_url()));
		
		$this->team->save();
	}
	
	function delete() {
		$this->ct->auth('admin',urlencode(current_url()));
		$this->team->delete();		
	}
	
	function server() {
		$this->ct->auth('admin',urlencode(current_url()));
		$data = array();
		$this->templates->juragan('tim/server',$data);
	}
	
	function serverPeserta() {
		$this->ct->auth('admin',urlencode(current_url()));
		$this->load->view('tim/portpeserta');
	}
	
	function serverHasHost() {
		$this->ct->auth('admin',urlencode(current_url()));
		$team_id	= $this->input->get('teamid');
		$servers	= $this->hp->get_hostdetail($team_id);
		
		$hosts	= array();
		$h 		= 0;
		
		foreach($servers as $inang) {
			$cnt	= count($hosts);
		
			if(($cnt != 0) AND ($inang['id'] == $hosts[$cnt-1]['id'])) {
					
				$services['name']		= $inang['name'];
				$services['port']		= $inang['port_number'];
				$services['status']		= $inang['status'];//$inang['status'];
				array_push($hosts[$cnt-1]['portnumber'], $services);
		
			} else {
		
				$inangbaru	= array(
					'id'			=> $inang['id'],
					'hostname'		=> $inang['hostname'],
					'ipaddr'		=> $inang['ipaddr'],
					'team_name'		=> $inang['team_name']					
				);
		
				$inangbaru['portnumber']	= array();
				$services['name']		= $inang['name'];
				$services['port']		= $inang['port_number'];
				$services['status']		= $inang['status'];
		
				array_push($inangbaru['portnumber'], $services);
				array_push($hosts, $inangbaru);
			}
		
			$h++;
		}
		
		
		$data['index']		= $this->input->get('idx');
		$data['teamid']		= $team_id;
		$data['random']		= rand();
		$data['hosts']		= $hosts;
		
		$this->load->view('tim/teamhashost',$data);
	}
	
	function serverPort() {
		$this->ct->auth('admin',urlencode(current_url()));
		$data['hosts_id']	= $this->input->get('idh');
		$data['index']	= $this->input->get('idx');
		$data['teamid']	= $this->input->get('teamid');
		$data['random']	= $this->input->get('_rdm');
		
		$this->load->view('tim/hostport',$data);
	}
	
	function serverJson() {
		$this->ct->auth('admin',urlencode(current_url()));
		$return	= $this->hp->get_jsonhostport($this->input->get('idh'));
		$json['total']	= $return['count'];
		$json['rows']	= $return['rows'];
		echo json_encode($json);
	}
	
	function serverAddHost() {
		$this->ct->auth('admin',urlencode(current_url()));
		$data['teamid']			= $this->input->get('teamid');
		$data['index']			= $this->input->get('idx');
		$data['randomdialog']	= $this->input->get('rdm');
		$this->load->view('tim/addhost',$data);
	}
	
	function serverSave() {
		$this->ct->auth('admin',urlencode(current_url()));
		$this->hs->save();
	}
	
	function serverDelete() {
		$this->ct->auth('admin',urlencode(current_url()));
		$this->hs->delete('hosts');
	}
	
	function port() {
		$this->ct->auth('admin',urlencode(current_url()));
		$this->templates->juragan('tim/port');
	}
	
	function portPeserta() {
		$this->ct->auth('admin',urlencode(current_url()));
		$this->load->view('tim/portpeserta');
	}
	
	function portJson() {
		$this->ct->auth('admin',urlencode(current_url()));
		$return	= $this->pr->json();
		$json['total']	= $return['count'];
		$json['rows']	= $return['rows'];
		echo json_encode($json);
	}
	
	function portSave() {
		$this->ct->auth('admin',urlencode(current_url()));
		$this->pr->save();
	}
	
	function portDelete() {
		$this->ct->auth('admin',urlencode(current_url()));
		$this->pr->delete();
	}
	
	function crontab() {
		
		$this->ct->auth('admin',urlencode(current_url()));
		
		$data['teams'] = $this->team->get_team();
		$this->templates->juragan('tim/crontab',$data);
	}
	
	function crontabGenerator() {
		
		$this->ct->auth('admin',urlencode(current_url()));
		
		$teamid = $this->input->get('id');
		$hosts	= $this->hs->get_host($teamid);
		
		$command = $this->configuration->get_val('cron_execute');
		
		
		/* foreach ($hosts as $host) {
			echo "* * * * * ". $command ." ". $teamid." ".$host['ipaddr']."\n";
			echo "* * * * * sleep 10; ". $command ." ". $teamid." ".$host['ipaddr']."\n";
			echo "* * * * * sleep 20; ". $command ." ". $teamid." ".$host['ipaddr']."\n";
			echo "* * * * * sleep 30; ". $command ." ". $teamid." ".$host['ipaddr']."\n";
			echo "* * * * * sleep 40; ". $command ." ". $teamid." ".$host['ipaddr']."\n";
			echo "* * * * * sleep 50; ". $command ." ". $teamid." ".$host['ipaddr']."\n";
		} */

		
		echo "* * * * * ". $command->value ." ". $teamid."\n";
		echo "* * * * * sleep 10; ". $command->value ." ". $teamid."\n";
		echo "* * * * * sleep 20; ". $command->value ." ". $teamid."\n";
		echo "* * * * * sleep 30; ". $command->value ." ". $teamid."\n";
		echo "* * * * * sleep 40; ". $command->value ." ". $teamid."\n";
		echo "* * * * * sleep 50; ". $command->value ." ". $teamid."\n";
	}
	
	function serverJsonEditPort() {
		$idh	= $this->input->get('idh');
		$result	= $this->hp->get_tim_port($idh);
		
		$json['rows']	= $result;
		$json['total']	= '5';
		echo json_encode($json);
	}
	
	function serverPortSave() {
		$this->ct->auth('admin',urlencode(current_url()));
		$this->hp->save();
		
	}
		
	function snmp() {
		
		$this->ct->auth('admin',urlencode(current_url()));
		$this->templates->juragan('tim/snmp');
	}
	
	function snmpXDetail() {
		$this->ct->auth('admin',urlencode(current_url()));
		
		$this->snmp2->set_snmp('172.16.6.206','public');
		
		// Tab system
		$data['sys_desc'] 		= $this->snmp2->get_sys_desc();
		$data['sys_uptime'] 	= $this->snmp2->get_sys_uptime();
		$data['sys_contact'] 	= $this->snmp2->get_sys_contact();
		$data['sys_name'] 		= $this->snmp2->get_sys_name();
		$data['sys_location'] 	= $this->snmp2->get_sys_location();
		
		// Tab interface
		$data['if_total'] 		= $this->snmp2->get_if_total();
		$data['if_desc'] 		= $this->snmp2->get_if_desc();
		$data['if_type'] 		= $this->snmp2->get_if_type();
		$data['if_mtu'] 		= $this->snmp2->get_if_mtu();
		$data['if_speed'] 		= $this->snmp2->get_if_speed();
		$data['if_physaddr'] 	= $this->snmp2->get_if_physaddr();
		
		$data['if_operstatus'] 	= $this->snmp2->get_if_operstatus();
		
		$data['if_inoctets'] 	= $this->snmp2->get_if_inoctets();
		$data['if_outoctets'] 	= $this->snmp2->get_if_outoctets();
		
		$data['sw_total'] 	= $this->snmp2->get_sw_total();
		$data['sw_name'] 	= $this->snmp2->get_sw_name();
		$data['sw_path'] 	= $this->snmp2->get_sw_path();
		
		$ports = $this->pr->get_port(); $services = '';		
		foreach ($ports as $port) $services .= $port->name.'|';
		$services = substr_replace($services ,"",-1);
		
		$data['storage_total'] 	= $this->snmp2->get_storage_total();
		$data['storage_type'] 	= $this->snmp2->get_storage_type();
		$data['storage_desc'] 	= $this->snmp2->get_storage_desc();
		$data['storage_alloc'] 	= $this->snmp2->get_storage_alloc();
		$data['storage_size'] 	= $this->snmp2->get_storage_size();
		$data['storage_used'] 	= $this->snmp2->get_storage_used();
		$data['sw_monitored'] = array_unique( preg_grep('/('.$services.')/', $data['sw_name']) );
		
		$this->load->view('tim/snmp_detail',$data);
	}
	
	function snmpDetail() {
		$this->ct->auth('admin',urlencode(current_url()));
		
		$id		= $this->input->get('id');		
		$hosts	= $this->hs->get_host($id);
		$data	= array(
			'monsrv'	=> array()
		);		
		
		foreach ($hosts as $host) {
			
			$this->snmp2->set_snmp($host['ipaddr'],$host['community']);
			
			$ports = $this->pr->get_port(); $services = '';
			foreach ($ports as $port) $services .= $port->name.'|';
			$services = substr_replace($services ,"",-1);
			
			$sw_name = $this->snmp2->get_sw_name();
			$services_bruto = array_unique( preg_grep('/('.$services.')/', $sw_name) );
			$services_netto = array();
			
			foreach ($services_bruto as $id => $services) {
				
				array_push($services_netto, preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($services, ENT_QUOTES)));
			}
			
			$portsaja = array();
			foreach ($this->pr->get_port()  as $portk) {
				array_push($portsaja, $portk->name);
			}
						
			$onport = array_intersect($services_netto, $portsaja);
			$offport = array_diff($portsaja, $services_netto);
		
			array_push($data['monsrv'], array(
				'on'	=> $onport,
				'off'	=> $offport,
				'host'	=> $host['hostname'],
				'ipaddr'	=> $host['ipaddr']
			));
		}

		$data['img']	= base_url() . 'resources/img/';
		
		$this->load->view('tim/snmp_detail2',$data);
	}
}