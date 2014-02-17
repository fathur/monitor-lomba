<div class="row">
	<div class="col-md-2">
		<ul id="tree-sensor"></ul>
	</div>
	
	<div class="col-md-10" id="status-tab" ></div>
</div>
<script>
$('#tree-sensor').tree({
	url:'<?=base_url()?>tim/json/tree',
	onClick: function(node){		
		$.get('<?=base_url()?>tim/snmpDetail',{
			id:node.id
		},function(resp){
			$('#status-tab').html(resp);
		});
	}
});

setInterval(function(){
	var node = $('#tree-sensor').tree('getSelected');
	
	$.get('<?=base_url()?>tim/snmpDetail',{
		id:node.id
	},function(resp){
		$('#status-tab').html(resp);
	});
},1000);

</script>