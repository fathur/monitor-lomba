

<div class="row">
	<div class="col-md-8">
		<h1>You are not authorized to view this page</h1>
			
	</div>
	
	<div class="col-md-4">
		<h1>Nilai Peserta</h1>
		
		<div class="col-md-12" id="scorstatus"></div>
		
	</div>
</div>

<div class="dialog"></div>

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