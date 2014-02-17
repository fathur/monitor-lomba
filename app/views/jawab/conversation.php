<div id="writemsg" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			
			<?=form_open_multipart('jawab/save',"role='form'")?>
			
			<input type="hidden" id="hid_li" value="" name="lomba_id" />
			<?=form_hidden('team_id',$teamid)?>
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Tulis pesan</h4>
			</div>
			<div class="modal-body">
			
				<div class="form-group">
					<label for="answerSubjek">Subjek</label>
					<input type="text" class="form-control" id="answerSubjek" placeholder="Subjek" name="subject" required="required" autofocus>
				</div>
				<div class="form-group">
					<label for="answerMessage">Pesan</label>
					<textarea class="form-control" rows="3" placeholder="Pesan" id="answerMessage" name="message"></textarea>
				</div>
				<div class="form-group">
					<label for="answerAttach">Upload analisa jawaban</label>
					<input type="file" id="answerAttach" name="attach" />
					<p class="help-block">Tipe file yang didukung doc, docx, odt, pdf. Maksimum 10MB</p>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-send"></i>&nbsp;&nbsp;Kirim</button>
			</div>
			
			<?=form_close()?>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<!-- End form reply  -->

<!-- Nav tabs -->
<ul class="nav nav-tabs">
	<?php foreach ($lomba as $lb): ?>
	<li><a href="#id<?=$lb->nama;?>" data-toggle="tab"><?=strtoupper($lb->nama);?></a></li>
	<?php endforeach;?>
</ul>

<!-- Tab panes -->
<div class="tab-content">

	<?php foreach ($lomba as $lb): ?>
	<div class="tab-pane" id="id<?=$lb->nama;?>">
		<br/>
		<!-- Begin form reply -->
		<div class="col-md-12">
			<button type="button" class="btn btn-success" data-toggle="modal" data-target="#writemsg" id="btnwrite" onclick="$('#hid_li').val(<?=$lb->id?>)"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;Kirim Pesan</button>
		</div>
		<br/>
		
		
	
		<!-- Begin Answer -->
		<?php foreach ($lom[$lb->id] as $jawab) : if ($jawab['sender'] == 'client') : ?>
		<div class="col-md-10 sender client">
			<div class="col-md-12 detail_timestamp"><i class="glyphicon glyphicon-time"></i> <?=$jawab['team_name']?> | <?=$jawab['timestamp']?></div>
			<div class="col-md-12 detail_messages">
				<h4><?=$jawab['subject']?></h4>
				<?=$jawab['message']?>
			</div>
			<?php if ($jawab['attachment'] != '') : ?>			
			<div class="col-md-12 detail_attach">
				<i class="glyphicon glyphicon-paperclip"></i> <?=anchor('jawab/unduh/'.$jawab['raw_name'], $jawab['client_name'])?>
			</div>
			<?php endif; ?>
		</div>		
		<?php elseif ($jawab['sender'] == 'admin') : ?>
		<div class="col-md-10 col-md-offset-2 sender admin">
			<div class="col-md-12 detail_timestamp"><i class="glyphicon glyphicon-time"></i> Admin | <?=$jawab['timestamp']?></div>
			<div class="col-md-12 detail_messages">
				<h4><?=$jawab['subject']?></h4>
				<?=$jawab['message']?>
			</div>
			<?php if ($jawab['attachment'] != '') : ?>			
			<div class="col-md-12 detail_attach"><i class="glyphicon glyphicon-paperclip"></i> <?=anchor('jawab/unduh/'.$jawab['raw_name'],$jawab['client_name'])?></div>
			<?php endif; ?>
		</div>	
		<?php endif; endforeach; ?>
		
	<!-- End Answer -->
	
	</div>
	<?php endforeach;?>

</div>

<script>
$('#btnwrite').click(function(){
	//var x=$(this).attr('ct');
	//console.log(x);
	// $('#hid_li').val();
});
</script>
