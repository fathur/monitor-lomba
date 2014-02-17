
<?php foreach ($monsrv as $srv) : ?>
	<table class="table table-bordered table-responsive table-condensed monserver">	
		<tr>
			<th colspan="2"><?=$srv['host']?> (<?=$srv['ipaddr']?>)</th>
		</tr>
		<?php foreach ($srv['on'] as $id => $service) : ?>
		<tr>
			<td><?=$service?></td>
			<td><img src="<?=$img?>g_green_on.gif"/></td>
			
		</tr>
		<?php 
		
		endforeach;
		
		foreach ($srv['off'] as $id => $service) : ?>
		<tr>
			<td><?=$service?></td>
			<td><img src="<?=$img?>g_red_anim.gif"/></td>
			
		</tr>
		<?php endforeach;?>
	</table>
<?php endforeach; ?>



