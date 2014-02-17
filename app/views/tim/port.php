<div class="row">
	<div class="col-md-8">
		<h1>Daftar Port</h1>
		<p>Halaman ini digunakan untuk mendaftarkan port default yang akan 
		dipantau oleh sistem ke masing-masing peserta. Pastikan mendaftarkan service 
		dan portnya ke dalam halaman ini sebelum mendaftarkan peserta!</p>
		<table id="port"></table>
			
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

	$('#port').datagrid({		
		rownumbers: true,
		pagination: true,
		singleSelect: true,
		pagePosition:'both',		
		url: '<?=base_url()?>tim/portJson',
		columns:[[
		    {checkbox: true},
			{field:'name',title:'Service',		    	
				editor:{
					type:'text',
					options:{									
						required:true
					}
				}
			},
			{field:'port_default',title:'Port',
				editor:{
					type:'text',
					options:{									
						required:true
					}
				}
			},
			{field:'status',title:'Status'}
		]],
		onAfterEdit: function(rindex,rdata,changes){

			console.log(rdata);
			
			$.post('<?=base_url()?>tim/portSave',{
				id: rdata.id,
				name: rdata.name,
				port_default: rdata.port_default
			},function(r){
				if(r == 1) {
					$('#port').datagrid('reload');
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
				$('#port').datagrid('insertRow', {
					index: index,
					row: {
						id: ''
					}
				});		
				$('#port').datagrid('selectRow',index);
				$('#port').datagrid('beginEdit',index);

			}
		},{
			iconCls: 'icon-edit',
			text: 'Edit',
			handler: function(){
				var row = $('#port').datagrid('getSelected');
				var index = $('#port').datagrid('getRowIndex', row);

				if(row) {
					$('#port').datagrid('beginEdit', index);
				} else {
					$.messager.alert('Warning!','Pilih satu terlebih dahulu!');
				}

			}
		},{
			iconCls: 'icon-remove',
			text: 'Delete',
			handler: function(){
				var row = $('#port').datagrid('getSelected');

				if(row) {

					$.messager.confirm('Confirm','Apakah Anda ingin menghapus data ini?',function(answer){
						if(answer) {
							$.post('<?=base_url()?>tim/portDelete',{
								id: row.id,						
							},function(r){
								if(r == 1) {
									$('#port').datagrid('reload');
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
				var row = $('#port').datagrid('getSelected');
				var index = $('#port').datagrid('getRowIndex', row);
				$('#port').datagrid('endEdit', index);	
				$('#port').datagrid('selectRow',index);			
			}
		}]
	});
});

</script>