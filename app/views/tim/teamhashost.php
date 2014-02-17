<div class="row" style="margin-bottom: 10px;">
	<div class="col-md-12">
		<div class="btn-group">
		  <button type="button" class="btn btn-success" id="hostadd<?=$random?>">Add Host</button>
		  <button type="button" class="btn btn-warning" id="hostedit<?=$random?>">Edit Host</button>
		  <button type="button" class="btn btn-danger" id="hostdel<?=$random?>">Delete Host</button>
		</div>
	</div>
</div>

<div id="dialog<?=$random?>"></div>

<div class="row">
	<form id="sfkja">
		
		<?php
		$i = 1; 
		foreach ($hosts as $server): ?>
		
		<div class="col-md-3">
			<table class="table table-condensed table-hover table-bordered t-host">
				<tr>
					<td colspan="2">				
						<a class="editport" idh="<?=$server['id']?>">Edit Port</a>				
					</td>
				</tr>
				<tr>
					<td  colspan="2">				
						<input type="radio" value="<?=$server['id']?>" id="ip<?=$i?>" name="ipaddr"/>
						<label for="ip<?=$i?>"><?=$server['hostname'].' ['.$server['ipaddr'].']'?></label>							
					</td>			
				</tr>
				<?php foreach ($server['portnumber'] as $port): ?>
				<tr>			
					<td><?=$port['name']?></td>
					<td><?=$port['port']?></td>
				</tr>
				<?php endforeach;?>
				
			</table>
		</div>
		
		<?php
		$i++; 
		endforeach; ?>
		
	</form>
</div>

<script>

$('.editport').linkbutton({
	iconCls: 'icon-edit',
	plain: true
});

$('.editport').click(function(){
	var idh	= $(this).attr('idh');
	
	$('#dialog<?=$random?>').dialog({
		height: 300,
		width: 500,
		modal: true,
		title: 'Server xx',
		closable: false,
		href: '<?=base_url()?>tim/serverPort?teamid=<?=$teamid?>&idh='+idh+'&_rdm=<?=$random?>&idx=<?=$index?>'
	});
});

$('#hostadd<?=$random?>').click(function(){
	$('#dialog<?=$random?>').dialog({
		height: 250,
		width: 300,		
		modal: true,
		title: 'Tambah Host',
		href: '<?=base_url()?>tim/serverAddHost?teamid=<?=$teamid?>&rdm=<?=$random?>&idx=<?=$index?>'
	});
});

$('#hostedit<?=$random?>').click(function(){
	$('#dialog<?=$random?>').dialog({
		height: 200,
		width: 300,		
		modal: true,
		title: 'Tambah Host',
		href: '<?=base_url()?>tim/serverAddHost?teamid=<?=$teamid?>&rdm=<?=$random?>&idx=<?=$index?>'
	});
});

$('#hostdel<?=$random?>').click(function(){	

	$.messager.confirm('Confirm','Anda ingin menghapus host ini?',function(e){
		if(e) {
			$.post('<?=base_url()?>tim/serverDelete',{
				id: $("input[name='ipaddr']:checked").val()
			},function(r){
				if(r==1){
					$('#ddv-<?=$index?>').panel({	         
			            border:false,  
			            cache:false,  
			            href:'<?=base_url()?>tim/serverHasHost?teamid=<?=$teamid?>&idx=<?=$index?>',  
			            onLoad:function(){  
			                $('#peserta').datagrid('fixDetailRowHeight',<?=$index?>);  
			            }  
			        });  
			        
			        $('#peserta').datagrid('fixDetailRowHeight',<?=$index?>);
				}
			});
		}
	});
	
	
});
</script>