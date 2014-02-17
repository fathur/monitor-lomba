<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * Custom class for Matagaruda
 * @author Fathur Rohman
 *
 */
class Snmp2
{
	private $hostname;
	private $community; 
	private $timeout	= 10000; // timeout in microsecond
	private $retries	= 3; // retry
	
	public function set_snmp($host, $community) {
		$this->hostname = $host;
		$this->community = $community;
	}
	
	public function set_empty_snmp() {
		$this->hostname = '';
		$this->community = '';
	}
	
	private function __val($string) {
		$x = explode(': ', $string);
		return $x[1];
	}
	
	function if_index_correlation($i) {
		$ifIndex = snmp2_walk($this->hostname, $this->community, '1.3.6.1.2.1.2.2.1.1',$timeout,$retries);
		foreach ($ifIndex as $key=>$val) {
			$return[$key] = $this->__val($val);
		}
	
		return $return[$i];
	}
	/**
	 * 
	 * Interface Entry 
	 * 1.3.6.1.2.1.2.2.1
	 * 
	 */
	function get_if_total() {
		$ifIndex = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.1',$timeout,$retries);
		return $this->__val($ifIndex[0]);
	}
	
	function get_if_desc($i = '') {
		
		if ($i != '') {
			$index = $this->if_index_correlation($i);
			$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.2.'.$index,$timeout,$retries);
			$return = $this->__val($if[0]);
		} else {
			$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.2',$timeout,$retries);
			foreach ($if as $k=>$v) {
				$return[$k] = $this->__val($v);
			}			
		}
		
		return $return;
	}
	
	function get_if_type($i = '') {
		
		$type_object = array('other',          
                          'regular1822',
                          'hdh1822(3)',
                          'ddn-x25(4)',
                          'rfc877-x25(5)',
                          'ethernet-csmacd',
                          'iso88023-csmacd',
                          'iso88024-tokenBus',
                          'iso88025-tokenRing',
                          'iso88026-man',
                          'starLan',
                          'proteon-10Mbit',
                          'proteon-80Mbit',
                          'hyperchannel',
                          'fddi',
                          'lapb',
                          'sdlc',
                          'ds1',           
                          'e1',            
                          'basicISDN(20)',
                          'primaryISDN(21)',   
                          'propPointToPointSerial',
                          'ppp',
                          'softwareLoopback',
                          'eon',            
                          'ethernet-3Mbit',
                          'nsip',           
                          'slip',           
                          'ultra',          
                          'ds3',            
                          'sip',            
                          'frame-relay');
		
		if ($i != '') {
			$index = $this->if_index_correlation($i);
			$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.3.'.$index,$timeout,$retries);
			$return = $this->__val($if[0]);
		} else {
			$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.3',$timeout,$retries);
			
			foreach ($if as $k=>$v) {
				$return[$k] = $this->__val($v);
				
			}
		}
		
		return $return;
	}
	
	
	/**
	 * The size of the largest datagram which can be
	 * sent/received on the interface, specified in
	 * octets.  For interfaces that are used for
	 * transmitting network datagrams, this is the size
	 * of the largest network datagram that can be sent
	 * on the interface. 
	 */
	function get_if_mtu($i = '') {
		if ($i != '') {
			$index = $this->if_index_correlation($i);
			$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.4.'.$index,$timeout,$retries);
			$return = $this->__val($if[0]);
		} else {
			$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.4',$timeout,$retries);
			foreach ($if as $k=>$v) {
				$return[$k] = $this->__val($v);
			}			
		}
		
		return $return;
	}
	
	/**
	 * An estimate of the interface's current bandwidth
	 * in bits per second.  For interfaces which do not
	 * vary in bandwidth or for those where no accurate
	 * estimation can be made, this object should contain
	 * the nominal bandwidth.
	 */
	function get_if_speed($i = '') {
		if ($i != '') {
			$index = $this->if_index_correlation($i);
			$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.5.'.$index,$timeout,$retries);
			$return = $this->__val($if[0]);
		} else {
			$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.5',$timeout,$retries);
			foreach ($if as $k=>$v) {
				$return[$k] = $this->__val($v);
			}			
		}
		
		return $return;
	}
	
	/**
	 * The interface's address at the protocol layer
	 * immediately `below' the network layer in the
	 * protocol stack.  For interfaces which do not have
	 * such an address (e.g., a serial line), this object
	 * shuld contain an octet string of zero length.
	 */
	function get_if_physaddr($i = '') {
		if ($i != '') {
			$index = $this->if_index_correlation($i);
			$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.6.'.$index,$timeout,$retries);
			$return = $this->__val($if[0]);
		} else {
			$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.6',$timeout,$retries);
			foreach ($if as $k=>$v) {
				$return[$k] = $v;
			}			
		}
		
		return $return;
	}
	
	/**
	 * The desired state of the interface.  The
	 * testing(3) state indicates that no operational
	 * packets can be passed.
	 */
	function get_if_adminstatus($i = '') {
		
		$status = array( 'up','down','testing');
		
		if ($i != '') {
			$index = $this->if_index_correlation($i);
			$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.7.'.$index,$timeout,$retries);
			$return = $this->__val($if[0]);
		} else {
			$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.7',$timeout,$retries);
			
			foreach ($if as $k=>$v) {
				$return[$k] = $status[$this->__val($v)];
				
			}
		}
		
		return $return;
	}
	
	/**
	 * The current operational state of the interface.
	 * The testing(3) state indicates that no operational
	 * packets can be passed.
	 */
	function get_if_operstatus($i = '') {
		$status = array( 'up','down','testing');
		
		if ($i != '') {
			$index = $this->if_index_correlation($i);
			$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.8.'.$index,$timeout,$retries);
			$return = $this->__val($if[0]);
		} else {
			$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.8',$timeout,$retries);
			
			foreach ($if as $k=>$v) {
				$return[$k] = $this->__val($v);
				
			}
		}
		
		return $return;
	}
	
	/**
	 * The value of sysUpTime at the time the interface
	 * entered its current operational state.  If the
	 * current state was entered prior to the last re-
	 * initialization of the local network management
	 * subsystem, then this object contains a zero
	 * value.
	 */
	function get_if_lastchange($i = '') {
		if ($i != '') {
			$index = $this->if_index_correlation($i);
			$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.9.'.$index,$timeout,$retries);
			$return = $this->__val($if[0]);
		} else {
			$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.9',$timeout,$retries);
			foreach ($if as $k=>$v) {
				$return[$k] = $v;
			}			
		}
		
		return $return;
	}
	
	/**
	 * The total number of octets received on the
	 * interface, including framing characters.
	 * 
	 */
	function get_if_inoctets($i ='') {
		if ($i != '') {
			$index = $this->if_index_correlation($i);
			$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.10.'.$index,$timeout,$retries);
			$return = $this->__val($if[0]);
		} else {
			$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.10',$timeout,$retries);
			foreach ($if as $k=>$v) {
				$return[$k] = $this->__val($v);
			}			
		}
		
		return $return;
	}
	
	/**
	 * The number of subnetwork-unicast packets
                      delivered to a higher-layer protocol.
	 * Enter description here ...
	 * @param unknown_type $index
	 */
	function get_if_inucastpkts($index) {
		if ($i != '') {
			$index = $this->if_index_correlation($i);
			$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.11.'.$index,$timeout,$retries);
			$return = $this->__val($if[0]);
		} else {
			$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.11',$timeout,$retries);
			foreach ($if as $k=>$v) {
				$return[$k] = $this->__val($v);
			}			
		}
		
		return $return;
	}
	function get_if_innucastpkts($index) {
		$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.12.'.$index,$timeout,$retries);
		return $this->__val($if[0]);
	}
	function get_if_indiscards($index) {
		$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.13.'.$index,$timeout,$retries);
		return $this->__val($if[0]);
	}
	function get_if_inerror($index) {
		$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.14.'.$index,$timeout,$retries);
		return $this->__val($if[0]);
	}
	function get_if_inunknownproto($index) {
		$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.15.'.$index,$timeout,$retries);
		return $this->__val($if[0]);
	}

	function get_if_outoctets($i = '') {
		if ($i != '') {
			$index = $this->if_index_correlation($i);
			$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.16.'.$index,$timeout,$retries);
			$return = $this->__val($if[0]);
		} else {
			$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.16',$timeout,$retries);
			foreach ($if as $k=>$v) {
				$return[$k] = $this->__val($v);
			}			
		}
		
		return $return;
	}
	function get_if_outucastpkts($index) {
		$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.17.'.$index,$timeout,$retries);
		return $this->__val($if[0]);
	}
	function get_if_outnucastpkts($index) {
		$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.18.'.$index,$timeout,$retries);
		return $this->__val($if[0]);
	}
	function get_if_outdiscards($index) {
		$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.19.'.$index,$timeout,$retries);
		return $this->__val($if[0]);
	}
	function get_if_outerror($index) {
		$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.20.'.$index,$timeout,$retries);
		return $this->__val($if[0]);
	}
	function get_if_outqlen($index) {
		$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.21.'.$index,$timeout,$retries);
		return $this->__val($if[0]);
	}
	function get_if_specific($index) {
		$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.2.2.1.22.'.$index,$timeout,$retries);
		return $this->__val($if[0]);
	}
	
	function get_sys_desc() {
		
		$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.1.1',$timeout,$retries);
		return $this->__val($if[0]);
	}
	
	function get_sys_oid() {
	
	}
	
	function get_sys_uptime() {
		$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.1.3',$timeout,$retries);
		return $this->__val($if[0]);
	}
	
	function get_sys_contact() {
		$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.1.4',$timeout,$retries);
		return $this->__val($if[0]);
	}
	
	function get_sys_name() {
		$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.1.5',$timeout,$retries);
		return $this->__val($if[0]);
	}
	
	function get_sys_location() {
		$if = snmp2_walk($this->hostname,$this->community,'1.3.6.1.2.1.1.6',$timeout,$retries);
		return $this->__val($if[0]);
	}
	
	function get_sys_services() {
	
	}
	
	function sw_index_correlation($i) {
		$ifIndex = snmp2_walk($this->hostname, $this->community, 'HOST-RESOURCES-MIB::hrSWRunIndex',$timeout,$retries);
		foreach ($ifIndex as $key=>$val) {
			$return[$key] = $this->__val($val);
		}
		
		return $return[$i];
	}
	
	function get_sw_total() {
		$ifIndex = snmp2_walk($this->hostname,$this->community,'HOST-RESOURCES-MIB::hrSWRunIndex',$timeout,$retries);
		return count($ifIndex);
	}
	
	function get_sw_name($i = '') {
		if ($i != '') {
			$index = $this->sw_index_correlation($i);
			$if = snmp2_walk($this->hostname,$this->community,'HOST-RESOURCES-MIB::hrSWRunName.'.$index,$timeout,$retries);
			$return = $this->__val($if[0]);
		} else {
			$if = snmp2_walk($this->hostname,$this->community,'HOST-RESOURCES-MIB::hrSWRunName',$timeout,$retries);
			foreach ($if as $k=>$v) {
				$return[$k] = $this->__val($v);
			}
		}
		
		return $return;
	}
	
	function get_sw_path($i = '') {
		if ($i != '') {
			$index = $this->sw_index_correlation($i);
			$if = snmp2_walk($this->hostname,$this->community,'HOST-RESOURCES-MIB::hrSWRunPath.'.$index,$timeout,$retries);
			$return = $this->__val($if[0]);
		} else {
			$if = snmp2_walk($this->hostname,$this->community,'HOST-RESOURCES-MIB::hrSWRunPath',$timeout,$retries);
			foreach ($if as $k=>$v) {
				$return[$k] = $this->__val($v);
			}
		}
	
		return $return;
	}
	
	function storage_index_correlation($i) {
		$ifIndex = snmp2_walk($this->hostname, $this->community, 'HOST-RESOURCES-MIB::hrStorageIndex',$timeout,$retries);
		foreach ($ifIndex as $key=>$val) {
			$return[$key] = $this->__val($val);
		}
	
		return $return[$i];
	}
	
	function get_storage_total() {
		$ifIndex = snmp2_walk($this->hostname,$this->community,'HOST-RESOURCES-MIB::hrStorageIndex',$timeout,$retries);
		return count($ifIndex);
	}
	
	function get_storage_type($i = '') {
		if ($i != '') {
			$index = $this->storage_index_correlation($i);
			$if = snmp2_walk($this->hostname,$this->community,'HOST-RESOURCES-MIB::hrStorageType.'.$index,$timeout,$retries);
			$return = $this->__val($if[0]);
		} else {
			$if = snmp2_walk($this->hostname,$this->community,'HOST-RESOURCES-MIB::hrStorageType',$timeout,$retries);
			foreach ($if as $k=>$v) {
				$return[$k] = $this->__val($v);
			}
		}
		
		return $return;
	}
	
	function get_storage_desc($i = '') {
		if ($i != '') {
			$index = $this->storage_index_correlation($i);
			$if = snmp2_walk($this->hostname,$this->community,'HOST-RESOURCES-MIB::hrStorageDescr.'.$index,$timeout,$retries);
			$return = $this->__val($if[0]);
		} else {
			$if = snmp2_walk($this->hostname,$this->community,'HOST-RESOURCES-MIB::hrStorageDescr',$timeout,$retries);
			foreach ($if as $k=>$v) {
				$return[$k] = $this->__val($v);
			}
		}
	
		return $return;
	}
	
	function get_storage_alloc($i = '') {
		if ($i != '') {
			$index = $this->storage_index_correlation($i);
			$if = snmp2_walk($this->hostname,$this->community,'HOST-RESOURCES-MIB::hrStorageAllocationUnits.'.$index,$timeout,$retries);
			$return = $this->__val($if[0]);
		} else {
			$if = snmp2_walk($this->hostname,$this->community,'HOST-RESOURCES-MIB::hrStorageAllocationUnits',$timeout,$retries);
			foreach ($if as $k=>$v) {
				$return[$k] = $this->__val($v);
			}
		}
	
		return $return;
	}
	
	function get_storage_size($i = '') {
		if ($i != '') {
			$index = $this->storage_index_correlation($i);
			$if = snmp2_walk($this->hostname,$this->community,'HOST-RESOURCES-MIB::hrStorageSize.'.$index,$timeout,$retries);
			$return = $this->__val($if[0]);
		} else {
			$if = snmp2_walk($this->hostname,$this->community,'HOST-RESOURCES-MIB::hrStorageSize',$timeout,$retries);
			foreach ($if as $k=>$v) {
				$return[$k] = $this->__val($v);
			}
		}
	
		return $return;
	}
	
	function get_storage_used($i = '') {
		if ($i != '') {
			$index = $this->storage_index_correlation($i);
			$if = snmp2_walk($this->hostname,$this->community,'HOST-RESOURCES-MIB::hrStorageUsed.'.$index,$timeout,$retries);
			$return = $this->__val($if[0]);
		} else {
			$if = snmp2_walk($this->hostname,$this->community,'HOST-RESOURCES-MIB::hrStorageUsed',$timeout,$retries);
			foreach ($if as $k=>$v) {
				$return[$k] = $this->__val($v);
			}
		}
	
		return $return;
	}
}