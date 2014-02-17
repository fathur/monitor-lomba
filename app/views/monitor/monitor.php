<div class="row">
	<div class="col-md-8">
		<h1>Server Status</h1>
		
		<div class="col-md-12 loading" id="serverstatus"></div>
			
	</div>
	
	<div class="col-md-4">
		<h1>Nilai Peserta</h1>
		
		<div class="col-md-12 loading" id="scorstatus"></div>
		
	</div>
</div>

<script>
$(function(){
	$('#serverstatus').addClass('loading');

	setInterval(function() {
		
		$.get('<?=base_url()?>monitor/update',function(resp){
			$('#serverstatus').removeClass('loading').height('auto');
			$('#serverstatus').html(resp);
			
		});

		$.get('<?=base_url()?>race/score',{
			
		},function(resp){
			$('#scorstatus').removeClass('loading').height('auto');
			$('#scorstatus').html(resp);
			
		});

	}, 1000);
});

</script>