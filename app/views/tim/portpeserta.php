<table id="portpeserta"></table>

<script>
$('#portpeserta').datagrid({
	rownumbers: true,
	
	singleSelect: true,
	url: '<?=base_url()?>juragan/port/jsonpeserta',
	columns:[[
			    {checkbox: true},
				{field:'team_name',title:'Nama Tim',		    	
					editor:{
						type:'text',
						options:{									
							required:true
						}
					}
				},
				{field:'team_username',title:'Username',
					editor:{
						type:'text',
						options:{									
							required:true
						}
					}
				},
			]],
			onAfterEdit: function(rindex,rdata,changes){			
				
				$.post('<?=base_url()?>juragan/peserta/save',{
					id: rdata.id,
					team_name: rdata.team_name,
					team_username: rdata.team_username
				},function(r){
					if(r == 1) {
						$('#peserta').datagrid('reload');
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
					$('#peserta').datagrid('insertRow', {
						index: index,
						row: {
							id: ''
						}
					});		
					$('#peserta').datagrid('selectRow',index);
					$('#peserta').datagrid('beginEdit',index);

				}
			},{
				iconCls: 'icon-edit',
				text: 'Edit',
				handler: function(){
					var row = $('#peserta').datagrid('getSelected');
					var index = $('#peserta').datagrid('getRowIndex', row);

					if(row) {
						$('#peserta').datagrid('beginEdit', index);
					} else {
						$.messager.alert('Warning!','Pilih satu terlebih dahulu!');
					}

				}
			},{
				iconCls: 'icon-remove',
				text: 'Delete',
				handler: function(){
					var row = $('#peserta').datagrid('getSelected');

					if(row) {

						$.messager.confirm('Confirm','Apakah Anda ingin menghapus data ini?',function(answer){
							if(answer) {
								$.post('<?=base_url()?>juragan/peserta/delete',{
									id: row.id,						
								},function(r){
									if(r == 1) {
										$('#peserta').datagrid('reload');
									}
								});
							}
						});
																
					} else {
						$.messager.alert('Warning!','Pilih satu terlebih dahulu!');
					}

				}
			}]
});
</script>