<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta name="description" content="">
	    <meta name="author" content="akung">
	    
	    <title>Cyber Defense</title>
	    
	    <?php echo link_tag('resources/css/bootstrap.css'); ?>
	    <?php echo link_tag('resources/css/pusdatin.css'); ?>
	    <?=link_tag('resources/css/signin.css')?>
	    
	    <script type="text/javascript" src="<?=$js?>jquery-1.10.2.min.js"></script>
	    <script type="text/javascript" src="<?=$js?>bootstrap.js"></script>
	</head>
	
	<body>
		
    
		<div class="container">
			<?=form_open('race/verify',"class='form-signin'")?>
				<h2 class="form-signin-heading">Login Peserta</h2>
				<input type="text" name="username" class="form-control" placeholder="Email address" required autofocus>
				<input type="password" name="password" class="form-control" placeholder="Password" required>
				
				<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
			</form>
		</div>
	</body>
</html>



