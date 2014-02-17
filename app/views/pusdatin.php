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
	    <?php echo link_tag('resources/css/pusdatin.css'); ?>
	    <?php echo link_tag('resources/css/easyui/black/easyui.css'); ?>
	    <?php echo link_tag('resources/css/easyui/icon.css'); ?>
	    
	     <script type="text/javascript" src="<?=$js?>jquery-1.10.2.min.js"></script>
	     <script type="text/javascript" src="<?=$js?>jquery.easyui.min.js"></script>
	    <script type="text/javascript" src="<?=$js?>bootstrap.js"></script>
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
					<!-- a class="navbar-brand" href="#">Pusdatin Monitoring System</a -->
				</div>
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav" id="mg-main-menu">
						<li><?=anchor('monitor/race','Home')?></li>
						<li><?=anchor('jawab/race','Kirim Jawaban')?></li>
						<!-- li><?=anchor('aturan/race','Peraturan')?></li -->
						<li><?=anchor('users/keluar','Logout')?></li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>
    
		<div class="container">
		<?=$content; ?>
		</div>
	</body>
</html>