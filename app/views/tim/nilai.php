
<table class="table table-striped table-bordered table-hover table-responsive">
	<tr>
		<th>No</th>
		<th>Nama Tim</th>
		<th>Score</th>
	</tr>
	
	<?php for ($i = 0; $i < count($score); $i++) : ?>
	
	<tr>
		<td><?=$i+1?></td>
		<td><?=$score[$i]['team_name']?></td>
		<td><?=$score[$i]['jumlah']?></td>
	</tr>
	
	<?php endfor;?>

</table>