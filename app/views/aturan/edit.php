
<div class="row">
	<div class="col-md-8">
		<h1>Aturan Permainan</h1>
		
		<?=form_open('aturan/save','class="form-horizontal" role="form"')?>
			<?=form_hidden('id',1)?>
			<?=form_hidden('slug','aturan')?>
			<div class="form-group">			 
			    <textarea id="rule" class="form-control" name="content" rows="3"><?=$aturan->content?></textarea>
			</div>
			<div class="form-group">
			    <button type="submit" class="btn btn-success" id="saverule">Save</button>
			</div>
			 
			
		
			
		</form>
	</div>
	
	<div class="col-md-4">
		<h1>Nilai Peserta</h1>
		
		<div class="col-md-12" id="scorstatus"></div>
		
	</div>
</div>

<script>

$(function(){
	$('#serverstatus').addClass('loading');

	setInterval(function() {				

		$.get('<?=base_url()?>race/score',{
			
		},function(resp){
			$('#scorstatus').removeClass('loading');
			$('#scorstatus').html(resp);
			
		});

	}, 5000);
});
</script>