<div class="row">
	<div class="col-md-8">
		<h1>Server Status</h1>
		
		<div class="col-md-12" id="serverstatus"></div>
			
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
		
		$.get('<?=base_url()?>monitor/raceMonitorUpdate',{
			
		},function(resp){
			$('#serverstatus').removeClass('loading');
			$('#serverstatus').html(resp);
			
		});

		$.get('<?=base_url()?>race/score',{
			
		},function(resp){
			$('#scorstatus').removeClass('loading');
			$('#scorstatus').html(resp);
			
		});

	}, 1000);
});

</script>