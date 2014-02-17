<div class="row">
	<div class="col-md-8 leftContent">
	
		<!-- Nav tabs -->
		<ul class="nav nav-tabs">
		  <li class="active"><a href="#home" data-toggle="tab">Tulis Jawaban</a></li>
		  <li><a href="#profile" data-toggle="tab">Jawaban Terkirim</a></li>
		
		</ul>
		
		<!-- Tab panes -->
		<div class="tab-content">
		  <div class="tab-pane active" id="home">
		  	<h1><i class="glyphicon glyphicon-folder-open"></i>Tulis <?=$lomba?></h1>
		  			  	
		  	<?=form_open_multipart('jawab/raceSaveCnd',"role='form'")?>
		  	<?=form_hidden('team_id',$this->session->userdata('userid'))?>
		  	<?=form_hidden('lomba_id',$lomba_id)?>
		  		<div class="form-group">
					<label for="answerSubjek">Tahap</label>
					<?=form_dropdown('subject',$no,'','class="form-control" id="answerSubjek" required="required" autofocus')?>
					
				</div>
				<!-- 
			  <div class="form-group">
			    <label for="answerSubjek">Subjek</label>
			    <input type="text" class="form-control" id="answerSubjek" placeholder="Subjek" name="subject" required="required" autofocus>
			  </div>
			  -->
			  <div class="form-group">
			    <label for="answerMessage">Pesan</label>
			    <textarea class="form-control" rows="3" placeholder="Pesan" id="answerMessage" name="message"></textarea>
			   
			  </div>
			  <div class="form-group">
			    <label for="answerAttach">Upload analisa jawaban</label>
			    <input type="file" id="answerAttach" name="attach" required="required" />
			    <p class="help-block">Tipe file yang didukung doc, docx, odt, pdf. Maksimum 10MB</p>
			  </div>
			 
			  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-send"></i>&nbsp;&nbsp;Kirim</button>
			</form>

		  
		  </div>
		  
		  <div class="tab-pane" id="profile">
			<h1>Jawaban Terkirim</h1>
			
			<div id="conversation" style="overflow: auto; height: 400px;"></div>
		  </div>
		
		</div>								
	</div>
	
	<div class="col-md-4">
		<h1>Nilai Peserta</h1>
		<div class="col-md-12" id="scorstatus"></div>
	</div>
</div>

<script>
$(function(){
	
	$('#serverstatus').addClass('loading');

	setInterval(function() {				

		$.get('<?=base_url()?>race/score',{
			
		},function(resp){
			$('#scorstatus').removeClass('loading');
			$('#scorstatus').html(resp);
			
		});

		$('#conversation').animate({
			scrollTop: $('#conversation')[0].scrollHeight
		},100);
	}, 5000);

	$.get('<?=base_url()?>jawab/raceConversation',function(resp){
		$('#conversation').html(resp);
		
	});

	
});

</script>