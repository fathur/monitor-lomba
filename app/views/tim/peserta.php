<div class="row">
	<div class="col-md-8">
		<h1>Daftar Tim</h1>
		
		<p>Halaman ini adalah halaman untuk 
		mendaftarkan dan mengatur tim peserta yang akan melakukan perlombaan.</p>
		
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
		url: '<?=base_url()?>tim/json',
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
			{field:'team_password',title:'Password',
				editor:{
					type:'text',
					options:{									
						required:true
					}
				},
				formatter: function(value,row,index) {
					// console.log(value);
					if(value){
						return '*******';
					}
				}
			},
		]],
		onAfterEdit: function(rindex,rdata,changes){			
			
			$.post('<?=base_url()?>tim/save',{
				id: rdata.id,
				team_name: rdata.team_name,
				team_username: rdata.team_username,
				team_password: rdata.team_password
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
							$.post('<?=base_url()?>tim/delete',{
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