<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta name="description" content="">
	    <meta name="author" content="akung">
	    
	    <title>Monitor Lab Simulasi</title>
	    
	    <?php echo link_tag('resources/css/bootstrap.css'); ?>
	    <?php echo link_tag('resources/css/easyui/black/easyui.css'); ?>
	    <?php echo link_tag('resources/css/easyui/icon.css'); ?>
	    <?php echo link_tag('resources/css/pusdatin.css'); ?>
	    
	    <script type="text/javascript" src="<?=$js?>jquery-2.0.0.min.js"></script>
	    <script type="text/javascript" src="<?=$js?>jquery.easyui.min.js"></script>
	    <script type="text/javascript" src="<?=$js?>bootstrap.js"></script>
	    <script type="text/javascript" src="<?=$js?>monitoring.js"></script>
	</head>
	
	<body>
		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!-- a class="navbar-brand" href="#">Monitoring System</a -->
				</div>
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav" id="mg-main-menu">
						<li><?=anchor('monitor/mon','Home')?></li>
						<li><?=anchor('jawab','Jawaban')?></li>						
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Peserta <b class="caret"></b></a>
					        <ul class="dropdown-menu">
					          <li><?=anchor('tim','Team')?></li>
					          <li><?=anchor('users','Users')?></li>
					          <li class="divider"></li>
					          <li><?=anchor('tim/server','Hosts')?></li>
					          <li><?=anchor('tim/port','Port')?></li>
					          <li class="divider"></li>
					          <li><?=anchor('tim/crontab','Crontab Generator')?></li>					
					        </ul>
						</li>						
						<!--li><?=anchor('aturan','Peraturan')?></li -->
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Soal <b class="caret"></b></a>
					        <ul class="dropdown-menu">
					       	  <li><?=anchor('soal/category','Kategori Soal')?></li>
					          <li><?=anchor('soal/index','Daftar Soal')?></li>
					        				
					        </ul>
						</li>	
						<li><?=anchor('users/keluar/'.$this->session->userdata('level'),'Logout')?></li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>
    
		<div class="container">
		<?=$content; ?>
		</div>
	</body>
</html>