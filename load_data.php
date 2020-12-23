<?php  
 //load_data.php  
 $connect = mysqli_connect("localhost", "root", "", "hello");  
 $output = '';  
 if(isset($_POST["brand_id"]))  
 {  
      if($_POST["brand_id"] != '')  
      {  
           $sql = "SELECT * FROM emp_list WHERE post_id = '".$_POST["brand_id"]."'";  
      }  
      else  
      {  
           $sql = "SELECT * FROM emp_list";  
      }  
      $result = mysqli_query($connect, $sql); 
       
      while($row = mysqli_fetch_array($result))  
      {  ?>
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