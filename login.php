<?php
 session_start();
 $msg="";
 $captcha=true;

 if (count($_POST)>0 && isset($_POST["captcha_code"]) && $_POST["captcha_code"]!=$_SESSION["captcha_code"])
 {
 	$captcha = false;
	$msg = "This Account Is Lock For This 1 Minute Wait Then You Are try It.";
 }
 $mysqli= new mysqli("localhost", "root", "", "hello");
 if (isset($_SESSION['mysession'])!="")
 {
	header("Location: home.php");
	exit;
}
$ip = $_SERVER['REMOTE_ADDR'];
$result = $mysqli->query("SELECT count(ip_address) AS failed_login_attempt FROM falied_login WHERE ip_address = '$ip'  AND date BETWEEN DATE_SUB( NOW() , INTERVAL 1 minute ) AND NOW()");
$row  = $result->fetch_array();
$result->free();

$failed_login_attempt = $row['failed_login_attempt'];

if(count($_POST)>0 && $captcha == true) 
{

if (isset($_POST['submit']))
 {
	
	$email = strip_tags($_POST['email']);
	$password = strip_tags($_POST['password']);
	
	
	$query = $mysqli->query("SELECT id, email, password FROM users WHERE email='$email'");
	$row=$query->fetch_array();
	
	$count = $query->num_rows; 
	
	if (password_verify($password, $row['password']) && $count==1) 
	{
		$_SESSION['mysession'] = $row['id'];
		$mysqli->query("DELETE FROM falied_login WHERE ip_address = '$ip'");
		header("Location: home.php");
	}
	 else 
	 {
		$msg = "Invalid Username Or Password";
		if ($failed_login_attempt < 3) 
		{
			$mysqli->query("INSERT INTO falied_login (ip_address,date) VALUES ('$ip', NOW())");
		} 
		else
		 {
			$msg = "You have tried more than 3 invalid attempts. Enter captcha code.";
		}
	}
	$mysqli->close();
}
}

?>

<!DOCTYPE html>
	<html>
	<head>
		<title>
			Login
		</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
	</head>
	<body>
		<div class="container">
			<div class="row">
			<div class="col-md-12 bg-dark">
				<div class="row">
					<div class="col-md-6">
						<a href="index.php"><i class="fas fa-home fa-2x p-2 text-white"></i></a>
					</div>
					
				</div>
			</div>
		</div>
			<div class="row">
				<div class="col-md-3">

				</div>
				<div class="col-md-6">
					<?php 
					if ($msg !="") 
					{
						echo $msg;
					}
					?>
					<form method="post">
						<h2 class="text-center bg-warning mt-2 p-2">Login</h2>
						<div class="form-group">
							<label>Email</label>
							<input type="email" name="email" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" name="password" class="form-control" required>
						</div>

						<?php
						if (isset($failed_login_attempt) && $failed_login_attempt>= 3)
						{
							?>
							<div class="d-none">
								<img src="captcha.php">
								<input type="text" name="captcha_code" class="form-control" placeholder="Please Enter the Captcha code">
							</div>

							<?php					
						}
						?>
						<div class="form-group">
							<input type="submit" name="submit" class="form-control btn btn-success">
						</div>
						<a href="registration.php">Create an Account</a>
					</form>
				</div>
				<div class="col-md-3">



				</div>
			</div>
			<div class="row">
			<div class="col-md-12 bg-dark">
				<p class="text-center text-white p-2">Hospital Manage System</p>
			</div>
		</div>
		</div>
	</body>
	</html>