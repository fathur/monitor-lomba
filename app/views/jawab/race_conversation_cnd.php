<?php 
$i = 1;
foreach ($conv as $item) : 
	if ($item['sender'] == 'client') : ?>
	
<div class="col-md-10 sender client">
	<div class="col-md-12 detail_timestamp"><i class="glyphicon glyphicon-time"></i> <?=$item['team_name']?> | <?=$item['timestamp']?></div>
	
	<div class="col-md-12 detail_messages">
		<h4><?=$item['subject']?></h4>
		<?=$item['message']?>
	</div>

		<?php if ($item['attachment'] != '') : ?>			
	<div class="col-md-12 detail_attach">
		<i class="glyphicon glyphicon-paperclip"></i> <?=anchor('jawab/unduh/'.$item['raw_name'],$item['client_name'])?>
	</div>
		<?php else: ?>
	<div class="col-md-12 detail_attach">
		<i class="glyphicon glyphicon-paperclip"></i> <?=anchor('#','Upload jawaban','class="upload" or="'.$i.'"')?>
	</div>
		<?php endif; ?>
</div>

	<?php elseif ($item['sender'] == 'admin'): ?>

<div class="col-md-10 col-md-offset-2 sender admin">
	<div class="col-md-12 detail_timestamp"><i class="glyphicon glyphicon-time"></i> Admin | <?=$item['timestamp']?></div>
	<div class="col-md-12 detail_messages">
		<h4><?=$item['subject']?></h4>
		<?=$item['message']?>
	</div>
		<?php if ($item['attachment'] != '') : ?>			
	<div class="col-md-12 detail_attach"><i class="glyphicon glyphicon-paperclip"></i> <?=anchor('',$item['client_name'])?></div>
		<?php endif; ?>
</div>	
	<?php endif;

$i++;
endforeach; ?>

<div id="uploaddialog"></div>

<script>
$('.upload').click(function(ev){
	ev.preventDefault();
	
	$('#uploaddialog').dialog({
	    title: 'Upload attachment',
	    width: 400,
	    height: 200,
	    closed: false,
	    cache: false,
	    
	    modal: true
	});
});
</script>