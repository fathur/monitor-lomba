<?php foreach ($host as $server) : ?>

<table class="table table-bordered table-responsive table-condensed monserver">
	<tr>
		<th colspan="3"><?=$server['hostname'] . ' ['.$server['ipaddr'].']'?></th>
	</tr>
	
	<?php foreach ($server['portnumber'] as $services): ?>
		
	<tr>
		<td><?=$services['name']?></td>
		<td><?=$services['port']?></td>
		<?php if ($services['status'] == 'on'):  ?>		
		<td><img src="<?=$img?>g_green_on.gif"/></td>		
		<?php elseif ($services['status'] == 'off') : ?>
		<td><img src="<?=$img?>g_red_anim.gif"/></td>
		<?php endif;?>
	</tr>
	
	<?php endforeach; ?>
</table>

<?php endforeach; ?>