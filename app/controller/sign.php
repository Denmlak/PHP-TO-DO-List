<?php 
require_once(dirname(__FILE__).'/../model/config.php');
$errors=array();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../view/css/style.css">
	<title>To Do List</title>
</head>
<?php  
	if (isset($_POST['sign'])) {
		$username=filter_input(INPUT_POST, 'username',FILTER_SANITIZE_STRING);
		$email=filter_input(INPUT_POST, 'email',FILTER_VALIDATE_EMAIL);
		$password=filter_input(INPUT_POST, 'password',FILTER_SANITIZE_STRING);
		$password_hash=password_hash($password, PASSWORD_DEFAULT);
		if (!empty($username) && !empty($email) && !empty($password_hash)) {
			$mysqli= new mysqli($db_host,$db_user,$db_pass,$db_name);
			if ($mysqli->connect_errno) {
				printf("Connect failed: %s\n", $mysqli->connect_errno);
          		exit();
			}
			$data=$mysqli->query("SELECT email FROM users WHERE email='$email'");
			if($data->num_rows == 0){
				$stmt=$mysqli->prepare("INSERT INTO users(username,email,password) VALUES(?, ?, ?)");
				$stmt->bind_param("sss", $username,$email,$password_hash);
				$insert=$stmt->execute();
				$stmt->close();
				$mysqli->close();
				header("location:login.php");
			}
			else{
				$errors[]= 'Email already in use by another account.';
			}	
		}
		else{
			$errors[]='Please enter all required fields and valid email.';
		}
	}
 ?>
<div class="log-wrap">
<h3>Sign Up</h3>
<p><a href="login.php">Or log in to your account</a></p>
<?php if(!empty($errors)){
				foreach($errors as $error){
					echo '<p class="error">'. $error . '</p>';
				}
			} ?>
<form action="" method="POST">
	<label for="username" class="log-txt">Username</label><br>
	<input type="name" name="username" placeholder="Enter your username" class="form-control"><br>
	<label for="email" class="log-txt">Email</label><br>
	<input type="email" name="email" placeholder="Enter youre email" class="form-control"><br>
	<label for="password" class="log-txt">Password</label><br>
	<input type="password" name="password" placeholder="Enter youre email" class="form-control"><br>
	<button class="btn-log" name="sign">Sign Up</button>
</form>
</div>
