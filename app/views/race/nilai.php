
<table class="table table-striped table-bordered table-hover table-responsive">
	<tr>
		<th>No</th>
		<th>Nama Tim</th>
		<th>Score</th>
		<th>Waktu</th>
	</tr>
	
	<?php for ($i = 0; $i < count($score); $i++) : ?>
	
	<tr>
		<td><?=$i+1?></td>
		<td><?=$score[$i]['team_name']?></td>
		<td><?=$score[$i]['jumlah']?></td>
		<td><?=$score[$i]['timestamp']?></td>
	</tr>
	
	<?php endfor;?>

</table>