<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Monitor extends CI_Controller {
	
	function __construct() {
		
		parent::__construct();
		$this->load->model('hosts','hs');
		$this->load->model('hostsport','hp');
		$this->load->model('credential','ct');
		$this->load->model('port','pr');
		$this->load->model('score');
		$this->load->model('configuration');
		
		$this->load->helper('html');
		$this->load->helper('form');
		
	}
	
	function index() {
		if ($this->session->userdata('login')) {
			
			redirect('monitor/race');
			
		} else {
		
			$data['js']	= base_url() . 'resources/js/';		
			$this->load->view('race/login',$data);
		}
							
	}
	
	/**
	 * 
	 * buat admin ajah ...
	 */
	function mon() {
		$this->ct->auth('admin,juri',urlencode(current_url()));
		$this->templates->juragan('monitor/monitor');
	}
	
	function update() {
		$this->ct->auth('admin,juri',urlencode(current_url()));
		$hosts	= $this->hp->get_allport();
		
		$host	= array();
		$h 		= 0;
		
		foreach($hosts as $inang) {
			$cnt	= count($host);
		
			if(($cnt != 0) AND ($inang['id'] == $host[$cnt-1]['id'])) {
					
				$services['name']		= $inang['name'];
				$services['port']		= $inang['port_number'];
				$services['status']		= $inang['status'];//$inang['status'];
				array_push($host[$cnt-1]['portnumber'], $services);
		
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
				array_push($host, $inangbaru);
			}
		
			$h++;
		}		
		$data['host']	= $host;
		$data['img'] = base_url() . 'resources/img/';
		
		$this->load->view('monitor/updatestatus',$data);
	}
	
	function race() {
		$this->ct->auth('team',urlencode(current_url()));
		$this->templates->pusdatin('monitor/race_monitor');
	}
	
	function raceMonitorUpdate() {
		$this->ct->auth('team',urlencode(current_url()));
		$team_id	= $this->session->userdata('userid');
		$hosts	= $this->hp->get_port($team_id);
		
		$host	= array();
		$h 		= 0;
		
		foreach($hosts as $inang) {
			$cnt	= count($host);
		
			if(($cnt != 0) AND ($inang['id'] == $host[$cnt-1]['id'])) {
					
				$services['name']		= $inang['name'];
				$services['port']		= $inang['port_number'];
				$services['status']		= $inang['status'];//$inang['status'];
				array_push($host[$cnt-1]['portnumber'], $services);
		
			} else {
		
				$inangbaru	= array(
									'id'			=> $inang['id'],
									'hostname'		=> $inang['hostname'],
									'ipaddr'		=> $inang['ipaddr']							
				);
		
				$inangbaru['portnumber']	= array();
				$services['name']		= $inang['name'];
				$services['port']		= $inang['port_number'];
				$services['status']		= $inang['status'];
		
				array_push($inangbaru['portnumber'], $services);
				array_push($host, $inangbaru);
			}
				
			$h++;
		}
		
		$data['host'] = $host;
		$data['img'] = base_url() . 'resources/img/';
		
		$this->load->view('monitor/race_update_status',$data);
	}
	
	/**
	 * Fungsi ini dijalankan di cronjob
	 * untuk melakukan pengecekan server menggunakan snmp
	 */
	function cronCekServer($teamid) {
		$this->load->library('Snmp2');
		$hosts = $this->hs->get_host($teamid);
		
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
			
			// Mendapatkan status terupdate dalam server
			$onport 	= array_intersect($services_netto, $portsaja);
			$offport 	= array_diff($portsaja, $services_netto);
			
			// Mendapatkan status sebelumnya dalam database
			// isinya adalah array 
			$curstatus = $this->hp->get_host_status($host['id']);
			foreach ($curstatus as $cs) {
				// menampilkan masing-masing status
				//print_r($cs);
				
				// jika SERVICE dalam database on:
				//		jika SERVICE server on, biarkan
				//		jika SERCICE server off, set ke off dan -100
				if ($cs->status == 'on') {
					
					//echo "ON: ".$cs->name.'-'.$cs->hosts_id.'-'.$cs->port_id.'<br/>';
					
					if (in_array($cs->name, $offport)) {
						//echo "Trun database off -100 <br/>";
						$this->hp->set_host_status('off',array(
							'hosts_id'	=> $cs->hosts_id,
							'port_id'	=> $cs->port_id
						));
						
						$scoredown = $this->configuration->get_val('score_down');
						
						$this->score->set_score($teamid,$scoredown->value,'port '.$cs->port_number.' is down');
						
					}
				} 
				
				// jika SERVICE dalam database off:
				//		jika SERVICE server on, set ke on dan +100
				//		jika SERCICE server off, biarkan
				elseif ($cs->status == 'off') {
					//echo "OFF: ".$cs->name.'-'.$cs->hosts_id.'-'.$cs->port_id.'<br/>';
					if (in_array($cs->name, $onport)) {
						//echo "Trun database on +100 <br/>";
						$this->hp->set_host_status('on',array(
							'hosts_id'	=> $cs->hosts_id,
							'port_id'	=> $cs->port_id
						));
						
						$scoreup = $this->configuration->get_val('score_up');
						
						$this->score->set_score($teamid,$scoreup->value,'port '.$cs->port_number.' is down');
					}
				}
			}
			// Tugas kita dalam kali ini adalah membandingkan antara keduanya
			
			
			/* foreach ($curstatus as $cs) {
				if(in_array($cs->name,$onport)) {
					echo $cs->name." On ";
				} elseif (in_array($cs->name,$offport)) {
					echo $cs->name." Off ";
				}
			} */
			//print_r($onport);
			//print_r($offport);
		}
	}
}