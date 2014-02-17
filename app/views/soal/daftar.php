<div class="row">
	<div class="col-md-8">
		<h1>Soal</h1>
		
		<div class="col-md-12" id="soal"></div>
			
	</div>
	
	<div class="col-md-4">
		<h1>Nilai Peserta</h1>
		
		<div class="col-md-12" id="scorstatus"></div>
		
	</div>
</div>

<script>
$(function(){
	$('#soal').datagrid({
		rownumbers: true,
		pagination: true,
		singleSelect: true,
		pagePosition:'both',		
		url: '<?=base_url()?>soal/daftar/json',
		frozenColumns:[[ {checkbox: true},
		     			{field:'nama_lomba',title:'Katagori',width:100,	    	
			editor:{
				type:'combobox',
				options:{									
					required:true,
					url:'<?=base_url()?>soal/cat/json/combobox',
					valueField:'id',
					textField:'text'
				}
			}
		},
		{field:'order',title:'No',
			editor:{
				type:'text',
				options:{									
					required:true
				}
			}
		}]],
		columns:[[
		   
			{field:'soal',title:'Soal',width:300,
				editor:{
					type:'text',
					
					options:{									
						required:true
						
					}
				}
			},
			{field:'jawaban',title:'Jawaban',width:300,
				editor:{
					type:'text',
					options:{									
						required:true
					}
				}
			},
			{field:'nilai',title:'Nilai',
				editor:{
					type:'text',
					options:{									
						required:true
					}
				}
			}
		]],
		onAfterEdit: function(rindex,rdata,changes){			
			console.log(rdata);
			$.post('<?=base_url()?>soal/daftar/save',{
				id: rdata.id,
				lomba_id: rdata.nama_lomba,
				order: rdata.order,
				soal: rdata.soal,
				jawaban: rdata.jawaban,
				nilai: rdata.nilai,
			},function(r){
				if(r == 1) {
					$('#soal').datagrid('reload');
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
				$('#soal').datagrid('insertRow', {
					index: index,
					row: {
						id: ''
					}
				});		
				$('#soal').datagrid('selectRow',index);
				$('#soal').datagrid('beginEdit',index);

			}
		},{
			iconCls: 'icon-edit',
			text: 'Edit',
			handler: function(){
				var row = $('#soal').datagrid('getSelected');
				var index = $('#soal').datagrid('getRowIndex', row);

				if(row) {
					$('#soal').datagrid('beginEdit', index);
				} else {
					$.messager.alert('Warning!','Pilih satu terlebih dahulu!');
				}

			}
		},{
			iconCls: 'icon-remove',
			text: 'Delete',
			handler: function(){
				var row = $('#soal').datagrid('getSelected');

				if(row) {

					$.messager.confirm('Confirm','Apakah Anda ingin menghapus data ini?',function(answer){
						if(answer) {
							$.post('<?=base_url()?>soal/daftar/delete',{
								id: row.id,						
							},function(r){
								if(r == 1) {
									$('#soal').datagrid('reload');
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
				var row = $('#soal').datagrid('getSelected');
				var index = $('#soal').datagrid('getRowIndex', row);
				$('#soal').datagrid('endEdit', index);	
				$('#soal').datagrid('selectRow',index);			
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