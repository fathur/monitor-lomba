<script>

</script>

<?php 
$i = 1;
foreach ($conv as $item) : 
	if ($item['sender'] == 'client') : ?>
	
<div class="col-md-10 sender client">
	<div class="col-md-12 detail_timestamp"><i class="glyphicon glyphicon-time"></i> <?=$item['team_name']?> | <?=$item['timestamp']?></div>
	
	<div class="col-md-12 detail_messages">		
		<?=$item['message']?>
	</div>

		<?php if ($item['attachment'] != '') : ?>			
	<div class="col-md-12 detail_attach">
		<i class="glyphicon glyphicon-paperclip"></i> <?=anchor('jawab/unduh/'.$item['raw_name'],$item['client_name'])?>
	</div>
		<?php else: ?>
	<div class="col-md-12 detail_attach">
		
		
		<?=form_open_multipart('jawab/unggah','id="upform'.$i.'"')?>		
			<?=form_hidden('id',$item['id'])?>
			<input type="file" name="attach" style="display:none;" 
				id="up<?=$i?>" 
				onchange="$('#upselectedfile<?=$i?>').html($(this).val());
					$('#link<?=$i?>').hide();
					$('#upapprove<?=$i?>,#updelete<?=$i?>').show()"/> 
		<?=form_close()?>
		
		<i class="glyphicon glyphicon-paperclip"></i> 
		<a href="#" id="link<?=$i?>" onclick="document.getElementById('up<?=$i?>').click()">Upload jawaban</a>
		
		<span id="upselectedfile<?=$i?>"></span>
		
		<button type="button" class="btn btn-success btn-xs" style="display:none;" 
			id="upapprove<?=$i?>" 
			onclick="unggah('upform<?=$i?>','<?=$item['id']?>')">
			<i class="glyphicon glyphicon-ok"></i> Upload
		</button>
		
		<button 
			type="button" class="btn btn-danger btn-xs" style="display:none;" 
			id="updelete<?=$i?>"
			onclick="$('#link<?=$i?>').show();
				$('#upselectedfile<?=$i?>').html('');
				$('#upapprove<?=$i?>').hide();
				$(this).hide();">
				
			<i class="glyphicon glyphicon-remove"></i> Cancel
		</button>
	</div>
		<?php endif; ?>
	
</div>

	<?php elseif ($item['sender'] == 'admin'): ?>

<div class="col-md-10 col-md-offset-2 sender admin">
	<div class="col-md-12 detail_timestamp"><i class="glyphicon glyphicon-time"></i> Admin | <?=$item['timestamp']?></div>
	<div class="col-md-12 detail_messages">
		<h4><?=$item['subject']?></h4>
		<?=$item['message']?>
	</div>
		<?php if ($item['attachment'] != '') : ?>			
	<div class="col-md-12 detail_attach"><i class="glyphicon glyphicon-paperclip"></i> <?=anchor('jawab/unduh/'.$item['raw_name'], $item['client_name'])?></div>
		<?php endif; ?>
	
</div>	
	<?php endif;

$i++;
endforeach; ?>

<div id="uploaddialog"></div>

<script>
function unggah(formulir,idanswer) {

	jQuery.messager.progress();
	jQuery('#'+formulir).form('submit',{
    	url			: $('#'+formulir).attr("action"),
    	onSubmit	: function() {
    		var isValid = jQuery(this).form('validate');
    		if (!isValid){
    			jQuery.messager.progress('close');	// hide progress bar while the form is invalid
    		}
    		return isValid;
    	},
    	onLoadError: function() {
    		jQuery.messager.progress('close');
        },
    	success		:function(data){    		
    		jQuery.messager.progress('close');
			if(data == 1) {
				var ortu = $('#'+formulir).parent();

	    		$.get('<?=base_url()?>jawab/loadAttachmentLink',{id:idanswer},function(resp){
		    		ortu.html(resp);
	        	});
			}
    				
    	}
    });
}
</script>