<?php 
	require_once(dirname(__FILE__).'/../model/config.php');
	require_once(dirname(__FILE__).'/../model/session.php');
	$errors=array();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../view/css/style.css">
	<title>To Do List</title>
</head>
<?php  
	if (!isset($_SESSION['username'])) {
		if (isset($_POST['login'])) {
			$username=filter_input(INPUT_POST, 'username',FILTER_SANITIZE_STRING);
			$password=filter_input(INPUT_POST, 'password',FILTER_SANITIZE_STRING);
			if (!empty($_POST['username'] && !empty('password'))) {
				$mysqli= new mysqli($db_host,$db_user,$db_pass,$db_name);
				if ($mysqli->connect_errno) {
					printf("Connect failed: %s\n", $mysqli->connect_errno);
	          		exit();
				}
				$data=$mysqli->query("SELECT * FROM users WHERE username='$username'");
				if ($data->num_rows == 1) {
					$row=$data->fetch_array();
					if (password_verify($password, $row['password'])) {
						$_SESSION['username']=$row['username'];
						$_SESSION['id']=$row['id'];
						setcookie('username', $row['username'], time() + 86400); // one day
						setcookie('id', $row['id'], time() + 86400);
						header("location:../../index.php");
					}
					else{
						 $errors[]='Please enter valid password.';
					}
				}
				else{
					  $errors[]='Please check your username and password.';
				}
			}
			else{
				$errors[]='Please enter all required fields.';
			}
		}
	}
 ?>
 <div class="log-wrap">
	<h3>Log In</h3>
	<p><a href="sign.php">Or create account</a></p>
	<?php if(!empty($errors)){
				foreach($errors as $error){
					echo '<p class="error">'. $error . '</p>';
				}
			} ?>
	<form action="" method="POST">
		<label for="username" class="log-txt">Username</label><br>
		<input type="text" name="username" placeholder="Please enter your username" class="form-control"><br>
		<label for="password"class="log-txt">Password</label><br>
		<input type="password" name="password" placeholder="Please enter your password" class="form-control"><br>
		<button class="btn-log" name="login">Log In</button>
	</form>
</div>

