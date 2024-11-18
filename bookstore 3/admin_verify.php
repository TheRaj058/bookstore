<?php
	// Login system
	session_start();
	if(!isset($_POST['submit'])){
		echo "Something wrong! Check again!";
		exit;
	}
	require_once "./functions/database_functions.php";
	$conn = db_connect();

	$name = trim($_POST['name']);
	$pass = trim($_POST['pass']);

	if($name == "" || $pass == ""){
		echo "Name or Pass is empty!";
		exit;
	}

	$name = mysqli_real_escape_string($conn, $name);
	$pass1 = mysqli_real_escape_string($conn, $pass);
	$pass = sha1($pass1);
	
	// get from db
	/* This is a query that is selecting all the data from the admin table where the name and password are
	equal to the name and password that the user entered. */
	$query = "SELECT * FROM admin WHERE name = '$name' AND pass = '$pass'";
	$result = mysqli_query($conn, $query);
	$count = mysqli_num_rows($result);
	if( $count==1){
		
		// if the user is found in the database, then the session will be created
		if(isset($conn)) {
			mysqli_close($conn);
		}

		$_SESSION['logged_in'] = true;
		$row = mysqli_fetch_assoc($result);
		$role = $row['role'];
		$_SESSION['role'] = $role;
		$_SESSION['username'] = $row['name'];
		/* This is a conditional statement. If the role is admin, then it will redirect to admin_book.php. If
		not, it will redirect to index.php. */
		if($role == 'admin'){
			header("Location: admin_book.php");
		}else{
			header("Location: index.php");
		}
		
	}else{
		echo $count;
		echo "Empty data " . mysqli_error($conn);
		exit;
	}


?>