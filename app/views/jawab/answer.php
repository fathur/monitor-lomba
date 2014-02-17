<div class="row">
	<div class="col-md-8 leftContent">
	
		<?php if ($warning) : ?>
			<h2 class="text-danger">Tidak terdapat tim</h2>
		<?php else :?>
		
		<div class="row">
			<div class="col-md-3">
				<h3>Team</h3>
				<ul id="team" ></ul>
			</div>
			
			<div class="col-md-9" id="conversation">
				
			</div>
		</div>
		
		<?php endif;?>
	</div>
	
	<div class="col-md-4 leftContent">
		<div class="row">
			
			<div class="col-md-12" id="poin"></div>
			
		</div>
	</div>
</div>

<script>
$(function(){
	$('#team').tree({
		url: '<?=base_url()?>jawab/treeteam',
		onClick: function(node) {

			$.get(node.attributes.url,{
				team: node.id
			},function(resp){
				$('#conversation').html(resp);
			});	

			$.get(node.attributes.poinview,{
				team: node.id
			},function(resp){
				$('#poin').html(resp);
			});						
		}
	});
});
</script>