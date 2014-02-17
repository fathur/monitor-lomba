<div class="row">
	<button type="button" class="btn btn-success" data-toggle="modal" data-target="#writepoin" id="btnwritepoin"><i class="glyphicon glyphicon-star-empty"></i>&nbsp;&nbsp;Add Poin</button>
</div>

<div id="writepoin" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			
			<?=form_open_multipart('jawab/raceScoreSave',"role='form' id='form-scoring'")?>
			<?=form_hidden('id','')?>		
			<?=form_hidden('team_id',$teamid)?>		
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Score Team <?=$myteam->team_name?></h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="answerSubjek">Score</label>
					<input type="number" class="form-control" id="answerSubjek" placeholder="Score" name="score" required="required" autofocus>
				</div>
				<div class="form-group">
					<label for="answerMessage">Pesan</label>
					<textarea class="form-control" rows="3" placeholder="Pesan" id="answerMessage" name="messages" required="required"></textarea>
				</div>				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="button-scoring"><i class="glyphicon glyphicon-send"></i>&nbsp;&nbsp;Kirim</button>
			</div>
			
			<?=form_close()?>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<div class="row leftContent">
	<table class="table table-condensed table-bordered table-striped">
		<tr>
			<th>Timestamp</th>
			<th>Poin</th>
			<th>Message</th>
			<th>Action</th>
		</tr>
		<?php 
		foreach ($scores as $score):
			if ($score['score'] < 0) {
				$rowclass = 'danger';
			} else {
				$rowclass = '';
			}
		
		?>
		<tr class="<?=$rowclass?>">
			<td><?=$score['timestamp']?></td>
			<td><?=$score['score']?></td>
			<td><?=$score['messages']?></td>
			<td>
				<!-- <button type="button" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp; Edit</button> -->
				<button type="button" class="btn btn-danger btn-xs deletescore" ids="<?=$score['id']?>"><i class="glyphicon glyphicon-minus"></i>&nbsp;&nbsp;Delete</button>
			</td>
		</tr>
		<?php endforeach; ?>
		
		<tr>
			<td>Total</td>
			<td colspan="3"><strong><?=$total->jumlah?></strong></td>
		</tr>
	</table>
</div>

<script>
$('.deletescore').click(function(){
	var ids = $(this).attr('ids');
	$.post('<?=base_url()?>jawab/raceScoreDelete',{
		id: ids
	},function(resp){
		if(resp == 1) {
			$.get('<?=base_url()?>tim/score?team=<?=$teamid?>',function(s){
				$('#poin').html(s);
			});
		}
	});
});

$('#button-scoring').click(function(){
	cmsSubmit('form-scoring',function(r){
		
		if(r==1) {
			$('#writepoin').modal('hide');			
		}
		
	});
	
});

$('#writepoin').on('hidden.bs.modal', function (e) {
	  // do something...
	$.get('<?=base_url()?>tim/score?team=<?=$teamid?>',function(s){
		$('#poin').html(s);
	});
})
</script>
