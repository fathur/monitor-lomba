
<div class="row">
	<div class="col-md-8 leftContent">
		<div class="alert alert-success"><!-- Jawaban telah berhasil di upload -->
		Selamat! Anda menjawab dengan benar
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

</script>