<?php
	session_start();
	// error_reporting(0);
	 $mysqli= new mysqli("localhost", "root", "", "hello");
	if (!isset($_SESSION['mysession'])) 
{
	header("Location: index.php");
}
$query=$mysqli->query("SELECT * FROM users WHERE id=".$_SESSION['mysession']);
$userRow=$query->fetch_array();


if (isset($_POST['btnsave'])) {
	$empname=$_POST['empname'];
	$profession=$_POST['profession'];

	$imgFile= $_FILES['empimg']['name'];
	$tmp_dir=$_FILES['empimg']['tmp_name'];
	$imgSize=$_FILES['empimg']['size'];
	if (empty($empname)) 
	{
		$errMSG="Please enter emp name";
	}
	else if (empty($profession)) 
	{
		$errMSG="Please enter youe profession";
	}
	else if (empty($imgFile)) 
	{
		$errMSG="Please insert an image";
	}
	else
	{
		$upload_dir = 'user_images/';

		$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); 
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); 
		$userpic = rand(1000,1000000).".".$imgExt;


		if(in_array($imgExt, $valid_extensions))
		{			

			if($imgSize < 5000000)				
			{
				move_uploaded_file($tmp_dir,$upload_dir.$userpic);
			}
			else
			{
				$errMSG = "Sorry, your file is too large.";
			}
		}
		else
		{
			$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";	
		}	
	}
	if (!isset($errMSG)) 

	{
		$stmt=$mysqli->query("INSERT INTO emp_list (emp_name, post_id, emp_pic) VALUES ('$empname', '$profession', '$userpic')");
		
		$empname="";
		$empimg="";
		$profession="";
		$suc="ok";

	}
	else
	{
		$errMSG="Something is worng";
	}
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Insert Emp</title>
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
			 <?php
    	error_reporting(~E_NOTICE);
    	if (isset($errMSG)) 
    	{
    		?>
    		<div>
    			<span><strong><?php echo $errMSG; ?></strong></span>
    		</div>
    <?php
    	}
    	else if (isset($suc)) 
    	{
    		?>
    		<div>
    			
				<script>
				alert('Successfully Updated ...');
				 </script>
    		</div>	
    		<?php
    	}
    ?>
				<div class="col-md-6 p-2">
					<h2 class="text-white text-center bg-danger">Add an Emp</h2>
					<form method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label>Emp Name</label>
						<input type="text" name="empname" class="form-control">
					</div>
					<div class="form-group">
						<label>Select Your Profession</label>
						<select class="form-control" name="profession">
							<option value="">Select Your Profession</option>
							<option value="2">Doctors</option>
							<option value="3">Nurse</option>
							<option value="4">Stafs</option>
							<option value="1">Maintenance</option>
						</select>
					</div>
					<div class="form-group">
						<label>Insert your Picture</label><br>
						<input type="file" name="empimg" accept="image/*" />
					</div>
					<div class="form-group">
						<input type="submit" name="btnsave" class="form-control btn btn-success">
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