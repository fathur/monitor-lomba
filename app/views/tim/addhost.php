<div class="col-md-12" style="margin-top: 15px;">
	
	<?=form_open('tim/serverSave',"role='form' id='formnewhost".$randomdialog."'")?>
	<?=form_hidden('id','')?>
	<?=form_hidden('team_id',$teamid)?>
	  <div class="form-group">
	    
	    <input class="form-control" name="hostname" placeholder="Enter Host Name">
	  </div>
	  <div class="form-group">
	 
	    <input class="form-control" name="ipaddr" placeholder="Enter Host Address">
	  </div> 
	  <div class="form-group">
	  
	    <input class="form-control" name="community" placeholder="Enter Community SNMP v2">
	  </div>    
	  <button type="button" class="btn btn-default form-control" id="buttonsavenewhost<?=$randomdialog?>">Save</button>
	</form>
</div>

<script>
$('#buttonsavenewhost<?=$randomdialog?>').click(function(){
	cmsSubmit('formnewhost<?=$randomdialog?>',function(r){

		console.log(r);
		
		if(r==1){
			$('#dialog<?=$randomdialog?>').dialog('close');

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
});
</script>