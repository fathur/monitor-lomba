<?php
/**
 * Cara menuliskannya adalah php cekserver.php 1 203.34.119.55
 */

$config = array(
	'db_server'	=> '192.168.4.1',
	'db_user'	=> 'fathur',
	'db_pass'	=> 'plokijuh'
);

$teamid	= $argv[1];
$ipaddr	= $argv[2];
$con	= mysqli_connect($config['db_server'],$config['db_user'],$config['db_pass'],"cyberjawara");
if (mysqli_connect_errno($con)) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}



$getport = "SELECT hosts.id, hosts.ipaddr, port.name, hosts_port.port_number, hosts_port.status ".
	"FROM hosts_port ".
	"INNER JOIN hosts ON hosts.id = hosts_port.hosts_id ".
	"INNER JOIN port ON port.id = hosts_port.port_id ".
	"WHERE team_id = $teamid AND hosts.ipaddr = '$ipaddr';";
	
$query_getport	= @mysqli_query($con, $getport);

while($row = mysqli_fetch_assoc($query_getport)) {
	
	$tcpconn = @fsockopen($row['ipaddr'], $row['port_number'],$errno, $errstr, 3);
	$hid 	= getHostId($con, $row['ipaddr']);
	$sbef	= getStatusBefore($con, $hid, $row['port_number']);
	$tid	= getTeamId($con, $row['ipaddr']);
	
	// Jika terdapat koneksi alias port idup
	if(is_resource($tcpconn)) {				
		
		// Jika status sebelumnya mati, maka rubah status menjadi hidup dan beri skor 100
		if ($sbef == 'off') {
			
			$setstatus = "UPDATE hosts_port SET status='on' ".
				"WHERE hosts_id='$hid' and port_number='".$row['port_number']."';";
			
			$result = @mysqli_query($con, $setstatus);
						
			if ($result) {
				echo "Success!";
			} else {				
				die("Database query failed. " . mysqli_error($con));				
			}
			
			$setscore = "INSERT INTO score(team_id, timestamp, score, messages) ".
				"VALUES ($tid, '".date("Y-m-d H:i:s")."',".getScoreUp().",'port ".$row['port_number']." is up');";
			
			$result2 = @mysqli_query($con, $setscore);
			
			if ($result2) {
				echo "Success insert";
			} else {
				echo $setscore;
				die("Database query failed. " . mysqli_error($con));
			}
			
		}		
	}
	// Jika tidak ada koneksi 
	else {			
		
		// Jika status sebelumnya idup, maka rubah status menjadi mati dan beri skor -100
		if ($sbef == 'on') {
				
			$setstatus = "UPDATE hosts_port SET status='off' ".
					"WHERE hosts_id='$hid' and port_number='".$row['port_number']."';";
				
			$result = @mysqli_query($con, $setstatus);
		
			if ($result) {
				echo "Success!";
			} else {
		
				die("Database query failed. " . mysqli_error($con));		
			}
			
			$setscore = "INSERT INTO score(team_id, timestamp, score, messages) ".
							"VALUES ($tid, '".date("Y-m-d H:i:s")."',".getScoreDown().",'port ".$row['port_number']." is down');";
				
			$result2 = @mysqli_query($con, $setscore);
				
			if ($result2) {
				echo "Success insert";
			} else {
				echo $setscore;
				die("Database query failed. " . mysqli_error($con));
			}
		}
		
		
	}
}


function getStatusBefore($con, $hostid, $port) {
	$getstatus = "SELECT status FROM hosts_port WHERE hosts_id='$hostid' AND port_number='$port'";
	$query_getstatus = @mysqli_query($con, $getstatus);
	$row = mysqli_fetch_assoc($query_getstatus);
	return $row['status'];
}

function getHostId($con, $ip) {
	$gethid = "SELECT id FROM hosts WHERE ipaddr='$ip'";
	$query_gethid = @mysqli_query($con, $gethid);
	$row = mysqli_fetch_assoc($query_gethid);
	return $row['id'];
}

function getTeamId($con, $ip) {
	$gethid = "SELECT team_id FROM hosts WHERE ipaddr='$ip'";
	$query_gethid = @mysqli_query($con, $gethid);
	$row = mysqli_fetch_assoc($query_gethid);
	return $row['team_id'];
}

function getScoreUp() {
	$getstatus = "SELECT value FROM configuration WHERE key='score_up'";
	$query_getstatus = @mysqli_query($con, $getstatus);
	$row = mysqli_fetch_assoc($query_getstatus);
	return $row['value'];
}

function getScoreDown() {
	$getstatus = "SELECT value FROM configuration WHERE key='score_down'";
	$query_getstatus = @mysqli_query($con, $getstatus);
	$row = mysqli_fetch_assoc($query_getstatus);
	return $row['value'];
}
