<?php
require "dbcon.php";

session_start();
    if(!isset($_SESSION['login_user']))
    {
        header("location: login.php");
    }

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$shop_id = $_SESSION['login_user'];
$shop_dept = $_SESSION['login_dept'];
$shop_post = $_SESSION['login_post'];

$request=$_POST["request"];

if($request=="DeleteBank")
{
    $id=$_POST["id"];
    if(mysqli_query($conn,"delete from bank where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}
else if($request=="GetDishrate")
{
	if($shop_dept == "Fastfood")
	{
		$myDept = "Fastfood";
	}
	else
	{
		$myDept = "Restaurant";
	}
    $dish12=$_POST["dish12"];
    $counterName=$_POST["counterName"];
	$sql = "SELECT $counterName as a FROM restro_dish where name = '$dish12' and divdept='$myDept'";
$result = $conn->query($sql);
     if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
		  echo $row["a"];
	  }
	 }
}
else if($request=="DelPermanDish")
{
    $id=$_POST["id"];
    $qty=$_POST["qty"];
    $idTot=$_POST["idTot"];
    $idDis=$_POST["idDis"];
    $scounter=$_POST["scounter"];
    $qty=$_POST["qty"];
    $price=$_POST["price"];
    $ts=$_POST["ts"];
	
	//idTot:idTot,idDis:idDis,scounter:scounter
	
	if($scounter == "Zomato" || $scounter == "Zomato R" || $scounter == "Swiggy" || $scounter == "Swiggy R")
	{
		$temp = $qty * $price;
		$remSettle = $idTot - $temp - $idDis;
	}
	else
	{
		$temp = $qty * $price;
		$idTot = $idTot - ($idTot * 0.05);
		$remSettle = $idTot - $temp - $idDis;
		$remSettle = round($remSettle);
	}
	if($remSettle > 0)
	{
		$sql = "delete from table_serve where id=$id;";
		//$sql .= "update settlement set amount='$remSettle' where reftime='$ts' and logdept = '$scounter';";
		if(mysqli_multi_query($conn,$sql))
		{
			echo "true";
		}
		else{
			echo "false";
		}
	}
	else
	{
		echo "tak";
	}
	
}
else if($request=="UpdatePermanDish")
{
    $id=$_POST["id"];
    $qty=$_POST["qty"];
    $idTot=$_POST["idTot"];
    $idDis=$_POST["idDis"];
    $scounter=$_POST["scounter"];
    $qty=$_POST["qty"];
    $price=$_POST["price"];
    $ts=$_POST["ts"];
    $dishname=$_POST["name"];
    $retqty12=$_POST["retqty12"];
	
	//idTot:idTot,idDis:idDis,scounter:scounter
	
	if($scounter == "Zomato" || $scounter == "Zomato R" || $scounter == "Swiggy" || $scounter == "Swiggy R")
	{
		$temp = $qty * $price;
		$remSettle = $idTot - $temp - $idDis;
	}
	else
	{
		$temp = $qty * $price;
		$idTot = $idTot - ($idTot * 0.05);
		$remSettle = $idTot - $temp - $idDis;
		$remSettle = round($remSettle);
	}
	$sql = "update table_serve set qty = '$qty', name='$dishname', retqty = '$retqty12', price='$price' where id=$id;";
		
		//$sql .= "update settlement set amount='$remSettle' where reftime='$ts' and logdept = '$scounter';";
		if(mysqli_multi_query($conn,$sql))
		{
			echo "true";
		}
		else{
			echo "false";
		}
	
}
//tablenoBill:tablenoBill,counterBill:counterBill,statusBill:statusBill,tsBill:tsBill,request:'RecallBillStl'
else if($request=="RecallBillStl")
{
	$tablenoBill=$_POST["tablenoBill"];
	$counterBill=$_POST["counterBill"];
	$statusBill=$_POST["statusBill"];
	$tsBill=$_POST["tsBill"];
	
	$sql = "update table_serve set status = 'Stl' where timestamp = '$tsBill' and tablename = '$tablenoBill' and type='$counterBill' and status = '$statusBill';";
	$sql .= "update waitertable set status = 'Stl' where timeout = '$tsBill' and tablename = '$tablenoBill' and type='$counterBill' and status = '$statusBill';";
	
	if(mysqli_multi_query($conn,$sql))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}
else if($request=="DelSettleEntry")
{
    $id=$_POST["id"];
    if(mysqli_query($conn,"delete from settlement where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}
else if($request=="StausOfWaiter")
{
    $stabno1 = $_POST["stabno1"];
    $countername = $_POST["countername"];
	$sqlq = "delete from waitertable where tablename = '$stabno1' and type = '$countername' and status != 'Yes';";
	$sqlq .= "delete from table_serve where tablename='$stabno1' and type='$countername' and status != 'Yes' and timestamp='';";
	$result1 = mysqli_multi_query($conn, $sqlq);
		while(mysqli_next_result($conn)){;}
		if ($result1) {
		     echo $sqlq;
    }
    else{
        echo "false";
    }
    
}
else if($request=="DeleteRoom")
{
    $id=$_POST["id"];
    if(mysqli_query($conn,"delete from lodroom where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}
else if($request=="DeleteServChargeEntry")
{
    $id=$_POST["id"];
    if(mysqli_query($conn,"delete from lodroomsevices where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}
//DelDistributeItem
else if($request=="DelDistributeItem")
{
    $id=$_POST["id"];
    if(mysqli_query($conn,"delete from distribute where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}
else if($request=="DeleteRestroTable")
{
    $id=$_POST["id"];
    if(mysqli_query($conn,"delete from restro_table where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}

else if($request=="DeleteRoomType")
{
    $id=$_POST["id"];
    if(mysqli_query($conn,"delete from roomtype where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}
//DeletePayModeType

else if($request=="DeletePayModeType")
{
    $id=$_POST["id"];
    if(mysqli_query($conn,"delete from paymode where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}


//DeleteRestroEmp

else if($request=="DeleteRestroEmp")
{
    $id=$_POST["id"];
    if(mysqli_query($conn,"delete from restro_emp where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}
//DeleteRestroTaxMaster
else if($request=="DeleteRestroTaxMaster")
{
    $id=$_POST["id"];
    if(mysqli_query($conn,"delete from restro_taxmaster where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}
else if($request=="DeleteRestroSubCategory")
{
    $id=$_POST["id"];
    if(mysqli_query($conn,"delete from restro_subcategory where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}
else if($request=="DeleteRestroCategory")
{
    $id=$_POST["id"];
    if(mysqli_query($conn,"delete from restro_category where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}
//DeleteSubCounter
else if($request=="DeleteSubCounter")
{
    $id=$_POST["id"];
    if(mysqli_query($conn,"delete from restro_subcounter where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}


else if($request=="DeleteCounter")
{
    $id=$_POST["id"];
    if(mysqli_query($conn,"delete from counter where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}

else if($request=="DeleteDepartment")
{
    $id=$_POST["id"];
    if(mysqli_query($conn,"delete from dept where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}
//DelTempBill
else if($request=="DelTempBill")
{
    $id=$_POST["id"];
    if(mysqli_query($conn,"delete from tempbill where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}
else if($request=="DeleteSubDepartment")
{
    $id=$_POST["id"];
    if(mysqli_query($conn,"delete from subdept where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}
 else if($request=="DeleteUnit")
{
    $id=$_POST["id"];
    if(mysqli_query($conn,"delete from unit where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}
//DelPurchase
 else if($request=="DelPurchaseList")
{
    $id=$_POST["id"];
    $q = "delete from item_tr where ref=$id;";
    $q .= "delete from transition where ref=$id";
	
	$result1 = mysqli_multi_query($conn, $q);
		while(mysqli_next_result($conn)){;}
		if ($result1) {
		     echo "true";
    }
    else{
        echo "false";
    }
	
	
   /* if(mysqli_multi_query($conn,$q))
    {
        echo "true";
    }
    else{
        echo "false";
    }*/
}
//DeleteChargesHead
else if($request=="DeleteChargesHead")
{
    $id=$_POST["id"];
    if(mysqli_query($conn,"delete from chargeshead where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}

 else if($request=="DelPurchase")
{
    $id=$_POST["id"];
    if(mysqli_query($conn,"delete from item_tr where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}
else if($request=="DeleteCoupon")
{
    $id=$_POST["id"];
    if(mysqli_query($conn,"delete from coupon where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}
else if($request=="DeleteAdver")
{
    $id=$_POST["id"];
    if(mysqli_query($conn,"delete from adver where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}
else if($request=="DeleteCombo")
{
    $id=$_POST["id"];
    if(mysqli_query($conn,"delete from combo where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}

 else if($request=="DelItem")
{
    $id=$_POST["id"];
    if(mysqli_query($conn,"delete from restro_dish where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}

else if($request=="DelVendor")
{
    $id=$_POST["id"];
    if(mysqli_query($conn,"delete from vendor where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}

else if($request=="DeleteCategory")
{
    $id=$_POST["id"];
    if(mysqli_query($conn,"delete from category where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}

else if($request=="DeleteSubCategory")
{
    $id=$_POST["id"];
    if(mysqli_query($conn,"delete from subcategory where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}

else if($request=="DeleteTable")
{
    $id=$_POST["id"];
    if(mysqli_query($conn,"delete from rtable where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}

else if($request=="DeleteExtraCharge")
{
    $id=$_POST["id"];
    if(mysqli_query($conn,"delete from echarge where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}

else if($request=="DeleteRoomType")
{
    $id=$_POST["id"];
    if(mysqli_query($conn,"delete from room where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}

else if($request=="DeleteSubRoom")
{
    $id=$_POST["id"];
    if(mysqli_query($conn,"delete from subroom where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}
else if($request=="DelJsonItem")
{
    $id=$_POST["id"];
    $pid=$_POST["pid"];
    $row1=mysqli_query($conn,"select * from purchase where id = '$pid'");
while($result1=mysqli_fetch_assoc($row1))
{
	$items = $result1["items"];
	
	$json = json_decode($items, true); //return an array
    foreach($json as $key => $value) {
       if($value['id'] == $id) {
        unset($json[$key]);
       }
    }
    $status = json_encode($json);
    $query="update purchase set `items` = '$status' where id = '$pid'";
    if(mysqli_query($conn,$query))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}   
}




else if($request=="DelDishItem")
{
    $id=$_POST["id"];
    $qty=$_POST["qty"];
    if(mysqli_query($conn,"update table_serve set status = 'Dl', retqty = $qty where id=$id"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}

else if($request=="SplitOption")
{
   $stabno = $_POST["stabno"];
	$scounter = $_POST["scounter"];
	$stimestamp = $_POST["stimestamp"];
	$sstatus = $_POST["sstatus"];
	
	
/*	if($stabno == "")
	{
	    echo "<script>alert('Select Table First')</script>";
	}
	else
	{
	
	if($sstatus == "Stl")
	{
	   echo "<script>alert('Bill already settled')</script>";
	}
	else
	{*/
	    $tabName1 = $stabno.'B';
	     $sql = "select * from restro_table where name= '$tabName1' && taxmaster='$scounter' && type='Temp'";
	    
            $result = mysqli_query($conn,$sql);
            $count = mysqli_num_rows($result);
            if($count >= 1) {
              
              ///////////Ask For B////////////////////
              $tabName2 = $stabno.'C';
              $sql1 = "select * from restro_table where name='$tabName2' && taxmaster='$scounter' && type='Temp'";
            $result1 = mysqli_query($conn,$sql1);
            $count1 = mysqli_num_rows($result1);
            if($count1 >= 1) {
              echo "<script>alert('Splitting Limit Exceeded')</script>";
              }
              else
              {
                  $tabName1 = $stabno.'C';
                  $sql21 = "INSERT INTO `restro_table`(`name`, `taxmaster`, `type`) VALUES ('$tabName1','$scounter','Temp');";
                       
                        if ($conn->query($sql21) === TRUE) {
                           echo "true";
                        } else {
                            
                          echo "Error: " . $sql . "<br>" . $conn->error;
                        }
              }
              
              
              }
              else
              {
                  $tabName = $stabno.'B';
                  $sql2 = "INSERT INTO `restro_table`(`name`, `taxmaster`, `type`) VALUES ('$tabName','$scounter','Temp');";
                        
                        if ($conn->query($sql2) === TRUE) {
                           echo "true";
                        } else {
                            
                          echo "Error: " . $sql . "<br>" . $conn->error;
                        }
              }
	//}
	}
//}
    
	
	else if($request=="DiscountCal")
{
	//tot:tot,disa:disa,disp:disp,stat:stat,tableno:tableno,ts:ts,counter:counter
    $tot=$_POST["tot"];
    $disa=$_POST["disa"];
    $disp=$_POST["disp"];
    $stat=$_POST["stat"];
    $tableno=$_POST["tableno"];
    $ts=$_POST["ts"];
    $counter=$_POST["counter"];
    $dsa=$_POST["dsa"];
    $rem=$_POST["rem"];
	
	$sql = "update table_serve set discount = '$dsa', rem='$rem' where status!='Stl' and timestamp='$ts' and tablename='$tableno' and type ='$counter'";
    if(mysqli_query($conn,$sql))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}


else if($request=="BillPrint") {
    
        
    $category = $_POST["countername"]; 
 	$tablename = $_POST["stabno1"];
 	/*if($tablename == "")
 	{
 	        echo "<script>alert('Select Table First...')</script>";
 	}
 	else
 	{*/
 	  $sqlV = "SELECT * FROM table_serve WHERE (status != 'Kt' and status != 'Dl') and tablename='$tablename' and type = '$category' and timeout = ''";
      $resultV = mysqli_query($conn,$sqlV);
      $countV = mysqli_num_rows($resultV);
      if($countV >= 1) 
	  {
        echo "NoKot";  
      }
      else
      {  
		//////////////////////////////////////////////////
			$category = $_POST["countername"]; 
			$tablename = $_POST["stabno1"];
			$sql = "SELECT count(id) as dt FROM waitertable WHERE type = '$category' group by timeout";
			$result = mysqli_query($conn,$sql);
			$billcount1 = mysqli_num_rows($result);
			$billcount = $billcount1 + 1; 
		//////////////////////////////////////////////////  
			date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
			$timestamp = date('Y-m-d H:i:s');
			$sql2 = "update `table_serve` set `status` = 'Stl', `timestamp`= '$timestamp', `agent`='$shop_id' where type ='$category' and tablename='$tablename' and status ='Kt';";
			$sql2 .= "update `table_serve` set `timestamp`= '$timestamp', `agent`='$shop_id' where type ='$category' and tablename='$tablename' and status ='Dl';";
			$sql2 .= "update waitertable set status = 'Stl', timeout = '$timestamp', billno = '$billcount' where type ='$category' and tablename='$tablename' and status = 'No'";
			
			
			$result2 = mysqli_multi_query($conn, $sql2);
			while(mysqli_next_result($conn)){;}
			if ($result2) {
				 echo "true";
			}
			else{
				echo "false";
			}
			
			/*if($result2=mysqli_multi_query($conn,$sql2))
			{
				echo "true";
				
			}
			else
			{
				 echo "false";
			}*/
      }   
 //	}
        
    
    }


else if($request=="BillSettleAndPrint")
{ 
 	$fromwhr = "";
    $category = $_POST["countername"]; 
 	$tablename = $_POST["stabno1"];
 	$shop_id = $_POST["s1"];
 	  $sqlV = "SELECT * FROM table_serve WHERE (status != 'Kt' and status != 'Dl') and tablename='$tablename' and type = '$category' and timestamp = ''";
 	  
      $resultV = mysqli_query($conn,$sqlV);
      $countV = mysqli_num_rows($resultV);
      if($countV >= 1) 
	  {
        echo "NoKot";  
      }
      else
      {  
		//////////////////////////////////////////////////
		if($category == 'Restaurant' || $category == 'Takeaway R' || $category == 'Homedelivery R' || $category == 'Banquets R' || $category == 'Future Order R' || $category == 'Office R' || $category == 'Zomato R' || $category == 'Swiggy R' || $category == 'Online R')
		{
			/*$sql = "SELECT count(id) as dt FROM waitertable WHERE (type = 'Restaurant' || type = 'Takeaway R' || type = 'Homedelivery R' || type = 'Banquets R' || type = 'Future Order R' || type = 'Office R' || type = 'Zomato R' || type = 'Swiggy R' || type = 'Online R') group by timeout";*/
			$sql = "select * from billno where type = 'Restaurant'";
			$fromwhr = "Restaurant";
		}
		else if($category == 'Fastfood' || $category == 'Takeaway' || $category == 'Homedelivery' || $category == 'Banquets' || $category == 'Future Order' || $category == 'Office' || $category == 'Zomato' || $category == 'Swiggy' || $category == 'Online')
		{
			/*$sql = "SELECT count(id) as dt FROM waitertable WHERE (type = 'Fastfood' || type = 'Takeaway' || type = 'Homedelivery' || type = 'Banquets' || type = 'Future Order' || type = 'Office' || type = 'Zomato' || type = 'Swiggy' || type = 'Online') group by timeout";*/
			$sql = "select * from billno where type = 'Fastfood'";
			$fromwhr = "Fastfood";
		}
		else if($category == 'Motel')
		{
			//$sql = "SELECT count(id) as dt FROM waitertable WHERE (type = 'Motel') group by timeout";
			$sql = "select * from billno where type = 'Motel'";
			$fromwhr = "Motel";
		}
			$result = mysqli_query($conn,$sql);
			$billcount1 = mysqli_num_rows($result);
			while($rowmain12=mysqli_fetch_assoc($result))
			{
				$billcount = $rowmain12["bill"] + 1;
			}
			/*if($category == 'Fastfood' || $category == 'Takeaway' || $category == 'Homedelivery' || $category == 'Banquets' || $category == 'Future Order' || $category == 'Office' || $category == 'Zomato' || $category == 'Swiggy' || $category == 'Online')
		{
			$billcount = $billcount1 + 1001; 
		}
		else
		{
			$billcount = $billcount1 + 1; 
		}*/
			
		//////////////////////////////////////////////////  
			date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30) 
			$timestamp = date('Y-m-d H:i:s');
			$sql2 = "update `table_serve` set `status` = 'Stl', `timestamp`= '$timestamp', `agent`='$shop_id' where type ='$category' and tablename='$tablename' and status ='Kt';";
			$sql2 .= "update `table_serve` set `timestamp`= '$timestamp', `agent`='$shop_id' where type ='$category' and tablename='$tablename' and status ='Dl' and timestamp = '' and kotno != '';";
			$sql2 .= "update waitertable set status = 'Stl', timeout = '$timestamp', billno = '$billcount' where type ='$category' and tablename='$tablename' and status = 'No';";
			$sql2 .= "update billno set bill = '$billcount' where type = '$fromwhr'";
			
			
			$result2 = mysqli_multi_query($conn, $sql2);
			while(mysqli_next_result($conn)){;}
			if ($result2) 
			{
				 echo $timestamp;
			}
			else
			{
				 echo "false";
			}
			/*if($result2=mysqli_multi_query($conn,$sql2))
			{
				//echo "<script>alert('Bill Submitted For Settlement')</script>";
				$url = "print_pos_rest.php?id=".$tablename."&type=".$category."&main=".$shop_dept;
				header('Location: '.$url);
			}
			else
			{
				 echo "<script>alert('Something went wrong')</script>";
			}*/
      }
}


else if($request=="RecallTable")
{
	//data:{countername:countername,stabno1:stabno1,status:y,ts:z,request:'RecallTable'},
    $countername=$_POST["countername"];
    $stabno1=$_POST["stabno1"];
    $status=$_POST["status"];
    $ts=$_POST["ts"];
	
	$sql = "update tableserve set status = 'Kt' where tablename = '$stabno1' and type='$countername' and timestamp = '$ts';";
	$sql .= "update waitertable set status = 'No' where timeout= '$ts' and tablename = '$stabno1' and type='$countername';";
	$sql .= "delete from settlement where reftime= '$ts' and logdept = '$shop_dept';";
	 $sqlV = "SELECT * FROM restro_table where name= '$stabno1'";
      $resultV = mysqli_query($conn,$sqlV);
      $countV = mysqli_num_rows($resultV);
      if($countV >= 1) 
	  {
	  }
	  else
	  {
		  $sql .= "insert into restro_table(name, taxmaster, type) values ('$stabno1', '$countername', 'Temp');";
	  }
	
    if(mysqli_multi_query($conn,$sql))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}

else if($request=="RepairTable")
{
    $stabno=$_POST["stabno"];
    $scounter=$_POST["scounter"];
    if(mysqli_query($conn,"delete from table_serve where name = '' || tablename = '' || qty= ''"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}
else if($request=="AddSettleAmountPlz")
{
    $timestamp=$_POST["timestamp"];
    $scounter=$_POST["counter"];
    $amount=$_POST["amount"];
    $settleid=$_POST["settleid"];
    if(mysqli_query($conn,"update settlement set amount = '$amount' where id = '$settleid' and reftime = '$timestamp' and logdept='$scounter'"))
    {
        echo "true";
    }
    else{
        echo "false";
    }
}
?>