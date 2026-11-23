<?php

 include('db.php');
 
  session_start();
    if(!isset($_SESSION['login_user']))
    {
        header("location: login.php");
    }

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$shop_id = $_SESSION['login_user'];
 $type = $_REQUEST['request'];
 
 if($type=="GetDistrict")
 {
     $state = $_REQUEST['state'];
      $query = "select * from districts where state_id = '$state' order by district_name asc";
     
 ?>
<option value="-Select-">-Select-</option>
    <?php                                             
    
    $result = mysqli_query($conn, $query);  
    while($row = mysqli_fetch_assoc($result))  
    {
    ?>
        <option value="<?php echo $row['id'];?>"><?php echo $row['district_name'];?></option>

    <?php
    }
 }
 else if($type=="GetCities")
 {
     $state = $_REQUEST['state1'];
     $district = $_REQUEST['district1'];
      $query = "select * from cities where state_id = '$state' and district_id = '$district' order by city_name ASC";
     // echo $query;
 ?>
<option value="-Select-">-Select-</option>
    <?php                                             
    
    $result = mysqli_query($conn, $query);  
    while($row = mysqli_fetch_assoc($result))  
    {
    ?>
        <option value="<?php echo $row['id'];?>"><?php echo $row['city_name'];?></option>

    <?php
    }
 }
 
 
 
 
 
 ?>