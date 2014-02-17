
<div id="tt">
	<div title="System">
		<table class="table table-bordered table-condensed">
			<tr>
				<td>Description</td>
				<td><?=$sys_desc?></td>
			</tr>
			<tr>
				<td>Up Time</td>
				<td><?=$sys_uptime?></td>
			</tr>
			<tr>
				<td>Date</td>
				<td><?php ?></td>
			</tr>
			<tr>
				<td>Contact</td>
				<td><?=$sys_contact?></td>
			</tr>
			<tr>
				<td>Name</td>
				<td><?=$sys_name?></td>
			</tr>
			<tr>
				<td>Location</td>
				<td><?=$sys_location?></td>
			</tr> 
			<tr>
				<td>Initial Load</td>
				<td><?=$sys_location?></td>
			</tr> 
		</table>
		<h3>Memory</h3>
		<table class="table table-bordered table-condensed">
			<tr>
				<td>Storage</td>
				<td>Type</td>
				<td>Allocation Units</td>
				<td>Size</td>
				<td>Used</td>
				
			</tr>
			<?php for ($i=0;$i<$storage_total;$i++): ?>
			<tr>
				<td><?=$storage_desc[$i]?></td>
				<td><?=$storage_type[$i]?></td>
				<td><?=$storage_alloc[$i]?></td>
				<td><?=$storage_size[$i]?></td>
				<td><?=$storage_used[$i]?> (<?=intval($storage_used[$i]/$storage_size[$i]*100)?>%)</td>
			</tr>
			<?php endfor; ?>
		</table>
		<h3>Device</h3>
		<table class="table table-bordered table-condensed">
			<tr>
				<td>Device</td>
				<td>Type</td>
				<td>Status</td>
				
			</tr>
			<tr>
				<td>Memory Size</td>
				<td></td>
				<td></td>
				
			</tr>
		</table>
		<h3>Mount</h3>
		<table class="table table-bordered table-condensed">
			<tr>
				<td>Mount Point</td>
				<td>Access</td>
				<td>Bootable</td>
				
			</tr>
			<tr>
				<td>Memory Size</td>
				<td></td>
				<td></td>
				
			</tr>
		</table>
	</div>
	<div title="Interface">
		<table class="table table-bordered table-condensed">
			<tr>
				<th>Interface</th>
				<th>Type</th>
				<th>MTU</th>
				<th>Speed</th>
				
				
				<th>Status</th>
				
				<th>In Octets</th>
				<th>Out Octets</th>
				<th>Promicius Mode</th>
			</tr>
			<?php for ($i=0;$i<$if_total;$i++): ?>
			<tr>
				<td><?=$if_desc[$i]?></td>
				<td><?=$if_type[$i]?></td>
				<td><?=$if_mtu[$i]?></td>
				<td><?=$if_speed[$i]?> bit/s</td>
			
			
				<td><?=$if_operstatus[$i]?></td>
			
				<td><?=$if_inoctets[$i]?></td>
				<td><?=$if_outoctets[$i]?></td>
				<td></td>
			</tr>
			<?php endfor;?>
		</table>
	</div>
	
	<div title="Services Monitored" >
		<table class="table table-bordered table-condensed">
			<tr>
				<th>No</th>
				<th>Name</th>
				
			</tr>
			<?php $i=1;
			foreach ($sw_monitored as $num => $sw):
			?>
			<tr>
				<td><?=$i?></td>
				<td><?=$sw?></td>
				
			</tr>
			<?php $i++; endforeach;?>
		</table>
	</div>
	<div title="All Services" >
		<table class="table table-bordered table-condensed">
			<tr>
				<th>No</th>
				<th>Name</th>
				<th>Path</th>
				<th>Parameters </th>
				<th>Type</th>
				<th>Status</th>
			</tr>
			<?php for ($i=0;$i<$sw_total;$i++):?>
			<tr>
				<td><?=$i+1?></td>
				<td><?=$sw_name[$i]?></td>
				<td><?=$sw_path[$i]?></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<?php endfor;?>
		</table>
	</div>
</div>

<script>
$('#tt').tabs({
	border:false
});
</script>