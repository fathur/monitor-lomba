<div class="row">
	<div class="col-md-8">
		<h1>Daftar User</h1>
		
		<p>Halaman berikut adalah halaman untuk mengatur daftar user yang 
		memiliki autoritas sebagai panitia. User yang terdapat disini dapat bertindak sebagai admin dan juri.</p>
		
		<table id="peserta"></table>
			
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

	$('#peserta').datagrid({		
		rownumbers: true,
		pagination: true,
		singleSelect: true,
		pagePosition:'both',		
		url: '<?=base_url()?>users/json',
		columns:[[
		    {checkbox: true},
			{field:'name',title:'Nama',		    	
				editor:{
					type:'text',
					options:{									
						required:true
					}
				}
			},
			{field:'username',title:'Username',
				editor:{
					type:'text',
					options:{									
						required:true
					}
				}
			},
			{field:'password',title:'Password',
				editor:{
					type:'text',
					options:{									
						required:true
					}					
				},
				formatter: function(value,row,index) {
					
					if(value){
						return '*******';
					}
				}
			},
			{field:'level',title:'Level',
				editor:{
					type:'combobox',
					options:{
						valueField:'value',
						textField:'label',
						data:[{
							label: 'Admin',
							value: 'admin'
							},
							{
							label: 'Juri',
							value: 'juri'
							}],
						required:true
					}
					
				},	
				formatter: function(row){
					return row;
				}						
			},
		]],
		onAfterEdit: function(rindex,rdata,changes){			
			
			$.post('<?=base_url()?>users/save',{
				id: rdata.id,
				name: rdata.name,
				username: rdata.username,
				password: rdata.password,
				level: rdata.level
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
							$.post('<?=base_url()?>users/delete',{
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
		},'-',{
			iconCls: 'icon-save',
			text: 'Save',
			handler: function(){
				var row = $('#peserta').datagrid('getSelected');
				var index = $('#peserta').datagrid('getRowIndex', row);
				$('#peserta').datagrid('endEdit', index);	
				$('#peserta').datagrid('selectRow',index);			
			}
		},'-',{
			
			text: 'Ganti Password',
			handler: function(){
				var row = $('#peserta').datagrid('getSelected');

				if(row) {
					
				} else {
					$.messager.alert('Warning!','Pilih satu terlebih dahulu!');
				}	
			}
		}]
	});
});

</script>