 <?php 
 require_once('app/model/session.php');
 require_once('app/model/config.php');
 require_once('app/view/header.php');
 $error=false;
 $mysqli= new mysqli($db_host,$db_user,$db_pass,$db_name);
			if ($mysqli->connect_errno) {
				printf("Connect failed: %s\n", $mysqli->connect_errno);
          		exit();
			}
 if (isset($_POST['add'])) {
 	$date=$_POST['date'];
 	$tasks=$_POST['tasks'];
 	if (!empty($_POST['date']) && !empty($_POST['tasks'])) {
			$id=$mysqli->query("SELECT * FROM users WHERE id='" . $_SESSION['id'] . "'");
			$row=$id->fetch_array();
			$user_id=$row['id'];
			$mysqli->query("INSERT INTO task (user_id,task_date,tasks) VALUES('$user_id','$date','$tasks')");
			if (isset($_GET['page'])) {
 			header("location:index.php?page=".$_GET['page']."");
 			}
 	}
 	else{
 		$error=true;
 	}	
 }
 if (isset($_GET['delete'])) {
 	$id= $_GET['delete'];
 	$mysqli->query("DELETE FROM task WHERE id='$id'");
}
 if (isset($_GET['edit'])) {
 	$id=$_GET['edit'];
 	$result=$mysqli->query("SELECT * FROM task WHERE id='$id'");
 	$row= $result->fetch_array();
 	$date= $row['task_date'];
 	$task=$row['tasks'];
 }
if (isset($_POST['update'])) {
	$new_date= $_POST['date'];
	$new_task=$_POST['tasks'];
	$mysqli->query("UPDATE task SET task_date='$new_date', tasks='$new_task' WHERE id='$id'");
	header("location:index.php");
}
if(isset($_POST['cancel'])){
	$date='';
	$task='';
	header("location:index.php");
}
?>
<?php if(isset($_SESSION['username'])) {?>
<div class="content-wrapper">
	<div class="main-content">
		<h2 class="welcome">Welcome <?php echo $_SESSION['username']; ?></h2>
		<main>
			<table class="content-table">
				<thead>
					<tr>
						<th>Number</th>
						<th>Date</th>
						<th>Task</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				<?php 
				$mysqli= new mysqli($db_host,$db_user,$db_pass,$db_name);
				if ($mysqli->connect_errno) {
					printf("Connect failed: %s\n", $mysqli->connect_errno);
		      		exit();
				}
				$data=$mysqli->query("SELECT * FROM task WHERE user_id= '". $_SESSION['id'] . "'");
				 $i=1;
				 while ($row=$data->fetch_array()) {?>
					<tr>
						<td><?php echo $i++;?></td>
						<td><?php echo  htmlentities ($row['task_date'], ENT_QUOTES | ENT_HTML5); ?></td>
						<td><?php echo htmlentities ($row['tasks'], ENT_QUOTES | ENT_HTML5); ?></td>
						<td><a href="index.php?edit=<?php echo $row['id'];?>" class="btn-action">Edit</a><a href="index.php?delete=<?php echo $row['id'];?>" class="btn-action">Delete</a></td>
					</tr> <?php 
				} ?>
				</tbody>
			</table>
		</main>
		<form action="" method="POST">
			<?php if ($error == true){
			echo '<p class="error">Please enter your date and task.</p>';
		 	}?>
			<input type="hidden" name="id" value="$id">
			<div class="form-flex">
				<input type="date" class="date" name="date" value="<?php if(!empty($date)) echo $date; ?>" >
				<input type="text" class="tasks" name="tasks" value="<?php  if(!empty($task)) echo $task; ?>" placeholder="Please add your task..." maxlength="50">
				<?php if (isset($_GET['edit'])) : ?>
					<button name="update" class="btn-action-main btn-add">Update</button>
					<button name="cancel" class="btn-action-main">Cancel</button>
				<?php else : ?>
				<button name="add" class="btn-action-main btn-add">Add</button>
				<?php endif; ?>
			</div>
		</form>
	</div>
</div>
<?php } else{ ?>
<div class="front-page container">
	<div class="col-1">
		<h2>Make your life easier</h2>
		<a href="app/controller/sign.php">Get Started</a>
	</div>
	<div class="col-2">
		<img src="app/view/img/todo.jpg" alt="TO DO list">
	</div>
</div>	
<?php } ?>
<?php  require_once('app/view/footer.php'); ?>