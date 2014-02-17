<div class="row">
	<div class="col-md-8">
		<h1>Daftar Host Server</h1>
		<p>Halaman ini digunakan untuk mendaftarkan host yang dimiliki peserta.
		Host yang dimiliki peserta boleh lebih dari satu. Saat mendaftarkan peserta maka port akan terdaftar secara 
		otomatis sesuai dengan <?=anchor('tim/port','port default yang telah didaftarkan')?>.
		Disini juga tempat untuk mengedit port peserta jika host portnya dirubah.</p>
		<table id="peserta"></table>
			
	</div>
	
	<div class="col-md-4">
		<h1>Nilai Peserta</h1>
		
		<div class="col-md-12" id="scorstatus"></div>
		
	</div>
</div>



<script type="text/javascript" src="<?=$js?>datagrid-detailview.js"></script>
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
		view: detailview,
		height: 500,
		rownumbers: true,
		pagination: true,
		fitColumns: true,
		singleSelect: true,
		pagePosition:'both',
		striped: true,
		url: '<?=base_url()?>tim/json',
		columns:[[
		    {checkbox: true},
			{field:'team_name',title:'Nama Tim',width:300},
			{field:'team_username',title:'Username',width:300},
		]],
		
		checkOnSelect: true,
		selectOnCheck: true,		
		detailFormatter: function(rowIndex, rowData){                 
			return '<div id="ddv-' + rowIndex + '" class="expandcontainer"></div>';
	    },
	    onExpandRow: function(index, row){
		   
	    	$('#ddv-'+index).panel({	         
	            border:false,  
	            cache:false,  
	            href:'<?=base_url()?>tim/serverHasHost?teamid='+row.id+'&idx='+index,  
	            onLoad:function(){  
	                $('#peserta').datagrid('fixDetailRowHeight',index);  
	            }  
	        });  
	        
	        $('#peserta').datagrid('fixDetailRowHeight',index);
	    }
	});
});

</script>