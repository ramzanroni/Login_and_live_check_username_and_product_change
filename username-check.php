<?php
  
  $host="localhost";
  $user="root";
  $pass="";
  $dbname="hello";
  
  $dbcon = new PDO("mysql:host={$host};dbname={$dbname}",$user,$pass);
  
  if($_POST) 
  {
     $name     = strip_tags($_POST['name']);
      
	  $stmt=$dbcon->prepare("SELECT user_name FROM users WHERE user_name=:name");
	  $stmt->execute(array(':name'=>$name));
	  $count=$stmt->rowCount();
	  	  
	  if($count>0)
	  {
		  echo "<span style='color:brown;'>Sorry username already taken !!!</span>";
	  }
	  else
	  {
		  echo "<span style='color:green;'>available</span>";
	  }
  }
?>