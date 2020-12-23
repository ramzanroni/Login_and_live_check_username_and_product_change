<?php
session_start();
$mysqli= new mysqli("localhost", "root", "", "hello");
if (!isset($_SESSION['mysession'])) 
{
	header("Location: index.php");
}
$query=$mysqli->query("SELECT * FROM users WHERE id=".$_SESSION['mysession']);
$userRow=$query->fetch_array();


function fill_brand($take_connection)  
{  
	$output = '';  
	$sql = "SELECT * FROM emp_group";  
	$result = mysqli_query($take_connection, $sql);  
	while($row = mysqli_fetch_array($result))  
	{  
		$output .= '<option value="'.$row["post_id"].'">'.$row["profession"].'</option>';  
	}  
	return $output;  
}  
function fill_product($take_connection)  
{  
	$output = '';  
	$sql = "SELECT * FROM emp_list";  
	$result = mysqli_query($take_connection, $sql);  
	while($row = mysqli_fetch_array($result))  
	{  
		?>
		
			<div class="col-3 float-left m-2 " style="border: 2px solid;">

				<p class="text-center"><?php echo $row['emp_name'];?></p>
				<img class="mx-auto" style="width: 250px; height: 250px; margin-left: 100px;" src="user_images/<?php echo $row['emp_pic']; ?>">
				<p class="text-center"><?php 
				if ($row['post_id']==1) 
				{
					echo "profession: "."Maintenanc";
				}
				else if ($row['post_id']==2) 
				{
					echo "profession: "."Doctors";
				}
				else if ($row['post_id']==3) 
				{
					echo "profession: "."Nurse";
				}
				else if ($row['post_id']==4) 
				{
					echo "profession: "."Stafs";
				}
				?></p>
			</div>
		
		<?php  
	}  

}  


?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo "Welcome".$userRow['user_name']?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
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
			<div class="col-md-12">
				<a class="text-center text-warning m-2" href="insert_emp.php"><i class="fas fa-user-plus fa-3x m-2"></i></a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="col-3">
				<select class="form-control" name="brand" id="brand">  
					<option value="">Show All Product</option>  
					<?php echo fill_brand( $mysqli); ?>  
				</select> 
				</div> 
				<br /><br />  
				<div class="row">
					<div class="col-md-12 border-1" id="show_product">  
						<?php echo fill_product( $mysqli);?>  
					</div>
				</div>  
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
<script>  
	$(document).ready(function()
	{  
		$('#brand').change(function()
		{  
			var brand_id = $(this).val();  
			$.ajax({  
				url:"load_data.php",  
				method:"POST",  
				data:{brand_id:brand_id},  
				success:function(data)
				{  
					$('#show_product').html(data);  
				}  
			});  
		});  
	});  
</script>  