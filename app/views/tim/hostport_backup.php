<table id="hostport"></table>
			
<script>
$(function(){	
	
	$('#hostport').datagrid({		
		rownumbers: true,
		pagination: true,
		singleSelect: true,
				
		url: '<?=base_url()?>tim/server/jsonhostport?idh=<?=$hosts_id?>',
		columns:[[		   
			{field:'name',title:'Service',		    	
				editor:{
					type:'text',
					options:{									
						required:true
					}
				}
			},
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
			
			$.post('<?=base_url()?>juragan/server/save',{
				
				hosts_id: rdata.hosts_id,
				port_id: rdata.port_id,
				port_number: rdata.port_number
			},function(r){
				if(r == 1) {
					$('#hostport').datagrid('reload');
				}
			});			
		},
		checkOnSelect: true,
		selectOnCheck: true,
		toolbar:[{
			iconCls: 'icon-add',
			text: 'Add',
			handler: function(){
				var index = 0;
				$('#hostport').datagrid('insertRow', {
					index: index,
					row: {
						id: ''
					}
				});		
				$('#hostport').datagrid('selectRow',index);
				$('#hostport').datagrid('beginEdit',index);
			}
		},{
			iconCls: 'icon-edit',
			text: 'Edit',
			handler: function(){
				var row = $('#hostport').datagrid('getSelected');
				var index = $('#hostport').datagrid('getRowIndex', row);

				if(row) {
					$('#hostport').datagrid('beginEdit', index);
				} else {
					$.messager.alert('Warning!','Pilih satu terlebih dahulu!');
				}

			}
		},{
			iconCls: 'icon-remove',
			text: 'Delete',
			handler: function(){
				var row = $('#hostport').datagrid('getSelected');

				if(row) {

					$.messager.confirm('Confirm','Apakah Anda ingin menghapus data ini?',function(answer){
						if(answer) {
							$.post('<?=base_url()?>juragan/peserta/delete',{
								id: row.id,						
							},function(r){
								if(r == 1) {
									$('#hostport').datagrid('reload');
								}
							});
						}
					});
															
				} else {
					$.messager.alert('Warning!','Pilih satu terlebih dahulu!');
				}

			}
		},'-',{
			iconCls: 'icon-save',
			text: 'Save',
			handler: function(){
				var row = $('#hostport').datagrid('getSelected');
				var index = $('#hostport').datagrid('getRowIndex', row);
				$('#hostport').datagrid('endEdit', index);	
				$('#hostport').datagrid('selectRow',index);			
			}
		}]
	});
});

</script>