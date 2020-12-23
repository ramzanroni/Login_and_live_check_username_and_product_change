<?php
//index.php

	session_start();
	 $mysqli= new mysqli("localhost", "root", "", "hello");
	if (!isset($_SESSION['mysession'])) 
{
	header("Location: index.php");
}
$query=$mysqli->query("SELECT * FROM users WHERE id=".$_SESSION['mysession']);
$userRow=$query->fetch_array();
$mysqli->close();


$error = '';
$name = '';
$email = '';
$subject = '';
$message = '';

function clean_text($string)
{
	$string = trim($string);
	$string = stripslashes($string);
	$string = htmlspecialchars($string);
	return $string;
}

if(isset($_POST["submit"]))
{
	if(empty($_POST["name"]))
	{
		$error .= '<p><label class="text-danger">Please Enter your Name</label></p>';
	}
	else
	{
		$name = clean_text($_POST["name"]);
		if(!preg_match("/^[a-zA-Z ]*$/",$name))
		{
			$error .= '<p><label class="text-danger">Only letters and white space allowed</label></p>';
		}
	}
	if(empty($_POST["email"]))
	{
		$error .= '<p><label class="text-danger">Please Enter your Email</label></p>';
	}
	else
	{
		$email = clean_text($_POST["email"]);
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$error .= '<p><label class="text-danger">Invalid email format</label></p>';
		}
	}
	if(empty($_POST["subject"]))
	{
		$error .= '<p><label class="text-danger">Subject is required</label></p>';
	}
	else
	{
		$subject = clean_text($_POST["subject"]);
	}
	if(empty($_POST["message"]))
	{
		$error .= '<p><label class="text-danger">Message is required</label></p>';
	}
	else
	{
		$message = clean_text($_POST["message"]);
	}
	if($error == '')
	{
		require 'class/class.phpmailer.php';
		$mail = new PHPMailer(true);
		$mail->IsSMTP(); 
		$mail->SMTPDebug  = 0;                     
		$mail->SMTPAuth   = true;                  
		$mail->SMTPSecure = "tls";                 
		$mail->Host       = "smtp.gmail.com";      
		$mail->Port       = 587;             
		$mail->AddAddress('mdramzanroni76@gmail.com');
		$mail->Username='mdramzanroni76@gmail.com';  
		$mail->Password='ramzan@1298';            
		$mail->SetFrom('mdramzanroni76@gmail.com',$email);
		$mail->AddReplyTo("mdramzanroni76@gmail.com","IDB");
		$mail->WordWrap = 50;
		$mail->IsHTML(true);
		$mail->Subject = $_POST["subject"];				//Sets the Subject of the message
		$mail->Body = $_POST["message"];	
		$mail->Send();	//Adds a "Cc" address
									//Sets word wrapping on the body of the message to a given number of characters
									//Sets message type to HTML				
					//An HTML or plain text message body
		if($mail->Send())								//Send an Email. Return true on success or false on error
		{
			$error = '<label class="text-success">Thank you for contacting us</label>';
			header("Location: home.php");
		}
		else
		{
			$error = '<label class="text-danger">There is an Error</label>';
		}
		$name = '';
		$email = '';
		$subject = '';
		$message = '';
	}
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Send an Email on Form Submission</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
	</head>
	<body>
		<br />
		<div class="container">
			<div class="row">
				<div class="col-md-12 bg-dark">
				<div class="row">
					<div class="col-md-6">
						<a href="home.php"><i class="fas fa-home fa-2x p-2 text-white"></i></a>
					</div>
					<div class="col-md-6">
						<div class="row ">
							<div class="col-md-5 p-2 m-2 ">
								
							</div>
							<div class="float-right" class="col-md-6 p-2 m-2">
								
								<a class="float-right btn btn-info m-2" href="logout.php?logout">Logout</a>
								<a class="float-right btn btn-info m-2" href="feedback.php">Contact us</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			</div>
			<div class="row">
				<div class="col-md-8" style="margin:0 auto; float:none;">
					<h3 align="center">Send Feedback</h3>
					<br />
					<?php echo $error; ?>
					<form method="post">
						<div class="form-group">
							<label>Enter Name</label>
							<input type="text" name="name" placeholder="Enter Name" class="form-control" value="<?php echo $name; ?>" />
						</div>
						<div class="form-group">
							<label>Enter Email</label>
							<input type="text" name="email" class="form-control" placeholder="Enter Email" value="<?php echo $email; ?>" />
						</div>
						<div class="form-group">
							<label>Enter Subject</label>
							<input type="text" name="subject" class="form-control" placeholder="Enter Subject" value="<?php echo $subject; ?>" />
						</div>
						<div class="form-group">
							<label>Enter Message</label>
							<textarea name="message" class="form-control" placeholder="Enter Message"><?php echo $message; ?></textarea>
						</div>
						<div class="form-group" align="center">
							<input type="submit" name="submit" value="Submit" class="btn btn-info form-control" />
						</div>
					</form>
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





