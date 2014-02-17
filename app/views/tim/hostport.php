<table id="hostport<?=$random?>"></table>

&nbsp;&nbsp;<a id="closebtn<?=$random?>"></a>
<script>
$(function(){	
	
	$('#hostport<?=$random?>').datagrid({		
		rownumbers: true,
		// pagination: true,
		singleSelect: true,
				
		url: '<?=base_url()?>tim/serverJsonEditPort?idh=<?=$hosts_id?>',
		columns:[[		   
			{field:'name',title:'Service'},
			{field:'port_number',title:'Port',
				editor:{
					type:'text',
					options:{									
						required:true
					}
				}
			},
		]],
		onAfterEdit: function(rindex,rdata,changes){

			// console.log(rdata);
			
			$.post('<?=base_url()?>tim/serverPortSave',{
				
				hosts_id: '<?=$hosts_id?>',
				port_id: rdata.port_id,
				port_number: rdata.port_number
			},function(r){
				if(r == 1) {
					$('#hostport<?=$random?>').datagrid('reload');
				}
			});			
		},
		checkOnSelect: true,
		selectOnCheck: true,
		toolbar:[/*{
			iconCls: 'icon-add',
			text: 'Add',
			handler: function(){
				var index = 0;
				$('#hostport<?=$random?>').datagrid('insertRow', {
					index: index,
					row: {
						id: ''
					}
				});		
				$('#hostport<?=$random?>').datagrid('selectRow',index);
				$('#hostport<?=$random?>').datagrid('beginEdit',index);
			}
		},*/{
			iconCls: 'icon-edit',
			text: 'Edit',
			handler: function(){
				var row = $('#hostport<?=$random?>').datagrid('getSelected');
				var index = $('#hostport<?=$random?>').datagrid('getRowIndex', row);

				if(row) {
					$('#hostport<?=$random?>').datagrid('beginEdit', index);
				} else {
					$.messager.alert('Warning!','Pilih satu terlebih dahulu!');
				}

			}
		}/*,{
			iconCls: 'icon-remove',
			text: 'Delete',
			handler: function(){
				var row = $('#hostport<?=$random?>').datagrid('getSelected');

				if(row) {

					$.messager.confirm('Confirm','Apakah Anda ingin menghapus data ini?',function(answer){
						if(answer) {
							$.post('<?=base_url()?>juragan/peserta/delete',{
								id: row.id,						
							},function(r){
								if(r == 1) {
									$('#hostport<?=$random?>').datagrid('reload');
								}
							});
						}
					});
															
				} else {
					$.messager.alert('Warning!','Pilih satu terlebih dahulu!');
				}

			}
		}*/,'-',{
			iconCls: 'icon-save',
			text: 'Save',
			handler: function(){
				var row = $('#hostport<?=$random?>').datagrid('getSelected');
				var index = $('#hostport<?=$random?>').datagrid('getRowIndex', row);
				$('#hostport<?=$random?>').datagrid('endEdit', index);	
				$('#hostport<?=$random?>').datagrid('selectRow',index);			
			}
		}]
	});
});

$('#closebtn<?=$random?>').linkbutton({
	text: 'Close'
});

$('#closebtn<?=$random?>').click(function(){
	$('#dialog<?=$random?>').dialog('close');

	$('#ddv-<?=$index?>').panel({	         
        border:false,  
        cache:false,  
        href:'<?=base_url()?>tim/serverHasHost?teamid=<?=$teamid?>&idx=<?=$index?>',  
        onLoad:function(){  
            $('#peserta').datagrid('fixDetailRowHeight',<?=$index?>);  
        }  
    });  
    
    $('#peserta').datagrid('fixDetailRowHeight',<?=$index?>);
});
</script>