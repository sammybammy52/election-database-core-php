<?php 
session_start();

$username = "";
$email	  = "";
$errors   = array();

$db = mysqli_connect('localhost', 'root', '', 'register');

if (isset($_POST['reg_user'])) {

	$username   = mysqli_real_escape_string($db, $_POST['username']);
	$name	    = mysqli_real_escape_string($db, $_POST['name']);
	$birthdate	    = mysqli_real_escape_string($db, $_POST['birthdate']);
	$address    = mysqli_real_escape_string($db, $_POST['address']);
	
	$card_number	    = mysqli_real_escape_string($db, $_POST['card_number']);
	$exp_date	    = mysqli_real_escape_string($db, $_POST['exp_date']);
	$cvv	    = mysqli_real_escape_string($db, $_POST['cvv']);

	$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
	$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

	$filename = $_FILES["picture"]["name"];
	$tempname = $_FILES["picture"]["tmp_name"];
	$folder = "./image/" . $filename;

	// checking filled
	if (empty($username)) { 
		array_push($errors, "-Username is required");
	}

	if (empty($name)) {
		array_push($errors, "-Name is required");
	}

	if (empty($birthdate)) {
		array_push($errors, "-birthdate is required");
	}

	if (empty($address)) {
		array_push($errors, "-address is required");
	}

	if (empty($card_number)) {
		array_push($errors, "-card no. is required");
	}

	if (empty($exp_date)) {
		array_push($errors, "-exp date is required");
	}

	if (empty($cvv)) {
		array_push($errors, "-Cvv is required");
	}

	if ($password_1 != $password_2) {
		array_push ($errors, "-Password you typed doesn't match");
	} 

	if (empty($password_1)) {
		array_push($errors, "-Password is required");
	}

	$user_check_query = "SELECT * FROM users WHERE username='$username' LIMIT 1";
	$result = mysqli_query($db, $user_check_query);
	$user = mysqli_fetch_assoc($result);

	// Checking user in database
	if ($user) {
		if ($user['username'] === $username) {
			array_push($errors, "Username already exists");
		}

		if ($user['email'] === $email) {
			array_push($errors, "Email already exists");
		}
	}

	//echo "Total error: " . count($errors);

	// Insert New Data
	if (count($errors) == 0) {
		$password = md5($password_1);

		$query = "INSERT INTO users (username, name, birthdate, address, picture, card_number, exp_date, cvv, password) VALUES ('$username', '$name', '$birthdate', '$address','$filename', $card_number, '$exp_date', $cvv, '$password')";
		mysqli_query($db, $query);

		if (move_uploaded_file($tempname, $folder)) {

			$msg = "Image uploaded successfully";
		} else {

			$msg = "Failed to upload image";
		}
		$_SESSION['username'] = $username;
		$_SESSION['success']  = "You're now logged in";
		header('location: index.php');
	}

}

// Click Login
if (isset($_POST['login_user'])) {
	$username = mysqli_real_escape_string($db, $_POST['username']);
	$password = mysqli_real_escape_string($db, $_POST['password']);

	if (empty($username)) {
		array_push($errors, "Username is required");
	}

	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	if (count($errors) == 0) {
		$password = md5($password);

		$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
		$results = mysqli_query($db, $query);
		if (mysqli_num_rows($results) == 1) {
			$_SESSION['username'] = $username;
			$_SESSION['success']  = "You are now logged in";
			header('location: index.php');
		} else {
			array_push($errors, "Wrong username/password combination");
		}
	}
}

?>