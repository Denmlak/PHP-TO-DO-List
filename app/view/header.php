<?php 
	 require_once(dirname(__FILE__).'/../model/session.php');
	 require_once(dirname(__FILE__).'/../model/config.php');
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="<?php SCRIPT_ROOT ?>app/view/css/style.css">
	<title>To Do List</title>
</head>
<body>
	<?php?>
	<header class="clearfix">
		<div class="container">
			<?php if(isset($_SESSION['username'])) {?>
				<div class="logo"><img src="<?php SCRIPT_ROOT ?>app/view/img/logo.png" class="logo-pic" alt="To Do list"></div>
				<div class="user-form">
				<a href="<?php SCRIPT_ROOT ?>app/controller/logout.php" class="log">Log Out <?php echo $_SESSION['username'];?></a>
				<div>	
			<?php } else{?>
				<div class="logo"><img src="<?php SCRIPT_ROOT ?>app/view/img/logo.png" class="logo-pic" alt="To Do list"></div>
				<div class="user-form">
					<a href="<?php SCRIPT_ROOT ?>app/controller/login.php" class="log log-in">Log In</a>
					<a href="<?php SCRIPT_ROOT ?>app/controller/sign.php" class="log sign-in">Sign Up</a>
				<div>	
			<?php } ?>
		</div>
	</header>
