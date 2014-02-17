<div class="row">
	<div class="col-md-8">
		<h1>Katagori Soal</h1>
		
		<div class="col-md-12" id="cat"></div>
			
	</div>
	
	<div class="col-md-4">
		<h1>Nilai Peserta</h1>
		
		<div class="col-md-12" id="scorstatus"></div>
		
	</div>
</div>

<script>
$(function(){
	$('#cat').datagrid({		
		rownumbers: true,
		pagination: true,
		singleSelect: true,
		pagePosition:'both',		
		url: '<?=base_url()?>soal/cat/json',
		columns:[[
		    {checkbox: true},
			{field:'nama',title:'Katagori',		    	
				editor:{
					type:'text',
					options:{									
						required:true
					}
				}
			},
			{field:'start',title:'Mulai',
				editor:{
					type:'text',
					options:{									
						required:true
					}
				}
			},
			{field:'end',title:'Selesai',
				editor:{
					type:'text',
					options:{									
						required:true
					}
				}
			},
		]],
		onAfterEdit: function(rindex,rdata,changes){			
			
			$.post('<?=base_url()?>soal/cat/save',{
				id: rdata.id,
				nama: rdata.nama,
				start: rdata.start,
				end: rdata.end
			},function(r){
				if(r == 1) {
					$('#cat').datagrid('reload');
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
				$('#cat').datagrid('insertRow', {
					index: index,
					row: {
						id: ''
					}
				});		
				$('#cat').datagrid('selectRow',index);
				$('#cat').datagrid('beginEdit',index);

			}
		},{
			iconCls: 'icon-edit',
			text: 'Edit',
			handler: function(){
				var row = $('#cat').datagrid('getSelected');
				var index = $('#cat').datagrid('getRowIndex', row);

				if(row) {
					$('#cat').datagrid('beginEdit', index);
				} else {
					$.messager.alert('Warning!','Pilih satu terlebih dahulu!');
				}

			}
		},{
			iconCls: 'icon-remove',
			text: 'Delete',
			handler: function(){
				var row = $('#cat').datagrid('getSelected');

				if(row) {

					$.messager.confirm('Confirm','Apakah Anda ingin menghapus data ini?',function(answer){
						if(answer) {
							$.post('<?=base_url()?>soal/cat/delete',{
								id: row.id,						
							},function(r){
								if(r == 1) {
									$('#cat').datagrid('reload');
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
				var row = $('#cat').datagrid('getSelected');
				var index = $('#cat').datagrid('getRowIndex', row);
				$('#cat').datagrid('endEdit', index);	
				$('#cat').datagrid('selectRow',index);			
			}
		}]
	});

	setInterval(function() {

		$.get('<?=base_url()?>race/score',function(resp){
			$('#scorstatus').removeClass('loading').height('auto');
			$('#scorstatus').html(resp);			
		});

	}, 1000);
});

</script>