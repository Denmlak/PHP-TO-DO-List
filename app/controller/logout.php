<?php 
	session_start();
	if (isset($_SESSION['id'])) {
		//delete session variables
		$_SESSION=array();
		session_destroy();	
	}
	header("location:../../index.php");
 ?>