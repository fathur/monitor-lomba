<div class="row">
	<div class="col-md-8">
		<h1>Crontab Generator</h1>
		
		<p>Hasil dari crontab ini diletakkan di host masing-masing peserta.</p>
		<div class="col-md-12">
			<form action="#" role="form">
				<div class="form-group">
				    <label for="team">Select Team</label>				    
				    <select class="form-control" id="team">
				    
				    <?php foreach ($teams as $team):?>
				    	<option value="<?=$team['id']?>"><?=$team['team_name']?></option>
				    <?php endforeach;?>
				    	
				    </select>
				</div>
				
				<div class="form-group">
					<button type="button" class="form-control btn btn-warning" id="generate">Generate</button>
				</div>	
				
				<div class="form-group">
					<textarea class="form-control" rows="5" id="tisi"></textarea>
				</div>
			</form>		
		</div>
			
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

$('#generate').click(function(){
	$.get('<?=base_url()?>tim/crontabGenerator',{
		id: $('#team').val()
	},function(r){
		$('#tisi').val(r);
	});
});

</script>