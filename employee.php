<?php
require 'db.php';
 session_start();
    if(!isset($_SESSION['login_user']))
    {
        header("location: login.php");
    }

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$shop_id = $_SESSION['login_user'];
if(isset($_POST['submit'])){
  
  $p_name=$_POST['p_name'];
   

$sql = "INSERT INTO Job Category (name)
VALUES ('$p_name')";


if ($conn->query($sql) === TRUE) {
   echo "<script>alert('Job Category Name Added Successfully')</script>";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
}

//$conn->close();
?>





<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    
    
    
    
     <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Job Portal</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
     <!-- MORRIS CHART STYLES-->
   
        <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
     <!-- TABLE STYLES-->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    
    
</head>
<body>
    <div id="wrapper">
        <?php include "menu.php" ?>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                           
                 <!-- /. ROW  -->
                  <hr />
                         
               
                 <!-- /. ROW  -->
              
                 
                <div class="row">
                    <div class="col-xs-12">
                        
                         
                         <div class="panel panel-default">
                        <div class="panel-heading">
                           Job Category Creation Page
                        </div>
                        <div class="panel-body">
                               <form action="" method="POST">
							   
                    <div class="row">
                   <div class="col-md-3">
                            <div class="form-group">

                                <label><h5><b>Job Category *</b></h5></label>

                                <select id="job_category"
                                        name="job_category"
                                        class="form-control"
                                        style="width:100%;"
                                        required>

                                    <option value=""></option>

                                    <option value="IT">IT</option>
                                    <option value="Software Development">Software Development</option>
                                    <option value="Marketing">Marketing</option>
                                    <option value="Finance">Finance</option>
                                    <option value="Human Resources">Human Resources</option>
                                    <option value="Sales">Sales</option>
                                    <option value="Customer Support">Customer Support</option>
                                    <option value="Healthcare">Healthcare</option>
                                    <option value="Education">Education</option>
                                    <option value="Engineering">Engineering</option>
                                    <option value="Business Development">Business Development</option>
                                    <option value="Operations">Operations</option>
                                    <option value="Administration">Administration</option>
                                    <option value="Legal">Legal</option>
                                    <option value="Banking">Banking</option>
                                    <option value="Accounting">Accounting</option>
                                    <option value="Manufacturing">Manufacturing</option>
                                    <option value="Logistics">Logistics</option>
                                    <option value="Retail">Retail</option>
                                    <option value="Other">Other</option>

                                </select>

                            </div>
                        </div>
					   <div class="col-md-3">
                        <div class="form-group">
                          <label ><h5><b>Job Title *</b></h5></label></>
                               <select class="form-control" name="job_title" required>
								<option value="">-- Select Job Title --</option>
								<option value="Software Developer">Software Developer</option>
								<option value="Web Developer">Web Developer</option>
								<option value="Java Developer">Java Developer</option>
								<option value="Python Developer">Python Developer</option>
								<option value="Data Analyst">Data Analyst</option>
								<option value="UI/UX Designer">UI/UX Designer</option>
								<option value="Project Manager">Project Manager</option>
								<option value="HR Executive">HR Executive</option>
								<option value="Marketing Executive">Marketing Executive</option>
								<option value="Sales Executive">Sales Executive</option>
								<option value="Graphic Designer">Graphic Designer</option>
								<option value="QA Engineer">QA Engineer</option>
							</select>
                        </div>
                      </div>
					   <div class="col-md-3">
                            <div class="form-group">
                                <label><h5><b>Company Name *</b></h5></label>

                                <select id="company_name" class="form-control" name="company_name" style="width:100%;" required>
                                    <option></option>
                                    <option>Tata Consultancy Services (TCS)</option>
                                    <option>Infosys</option>
                                    <option>Wipro</option>
                                    <option>HCL Technologies</option>
                                    <option>Tech Mahindra</option>
                                    <option>Accenture</option>
                                    <option>Capgemini</option>
                                    <option>Cognizant</option>
                                    <option>IBM</option>
                                    <option>Oracle</option>
                                    <option>Microsoft</option>
                                    <option>Google</option>
                                    <option>Amazon</option>
                                    <option>Meta</option>
                                    <option>Apple</option>
                                    <option>Intel</option>
                                    <option>NVIDIA</option>
                                    <option>Dell Technologies</option>
                                    <option>HP</option>
                                    <option>Cisco</option>
                                    <option>Adobe</option>
                                    <option>Salesforce</option>
                                    <option>Zoho</option>
                                    <option>Paytm</option>
                                    <option>PhonePe</option>
                                    <option>Flipkart</option>
                                    <option>Reliance Jio</option>
                                    <option>Reliance Industries</option>
                                    <option>Mahindra & Mahindra</option>
                                    <option>Tata Motors</option>
                                    <option>Larsen & Toubro (L&T)</option>
                                    <option>Bajaj Finserv</option>
                                    <option>HDFC Bank</option>
                                    <option>ICICI Bank</option>
                                    <option>Axis Bank</option>
                                    <option>State Bank of India (SBI)</option>
                                    <option>Persistent Systems</option>
                                    <option>KPIT Technologies</option>
                                    <option>LTIMindtree</option>
                                    <option>Hexaware Technologies</option>
                                    <option>Mphasis</option>
                                    <option>Birlasoft</option>
                                    <option>Cybage</option>
                                    <option>Red Hat</option>
                                    <option>Other</option>
                                </select>

                            </div>
                        </div>

               </div>
			    <div class="row">
					   <div class="col-md-2">
                                <div class="form-group">
                                    <label><h5><b>Job Location *</b></h5></label>

                                    <input type="text"
                                        class="form-control"
                                        name="job_location"
                                        list="jobLocationList"
                                        placeholder="Select or type location"
                                        required>

                                    <datalist id="jobLocationList">
                                        <option value="Mumbai">
                                        <option value="Pune">
                                        <option value="Nagpur">
                                        <option value="Nashik">
                                        <option value="Aurangabad">
                                        <option value="Latur">
                                        <option value="Kolhapur">
                                        <option value="Solapur">
                                        <option value="Thane">
                                        <option value="Navi Mumbai">
                                        <option value="Hyderabad">
                                        <option value="Bengaluru">
                                        <option value="Chennai">
                                        <option value="Delhi">
                                        <option value="Noida">
                                        <option value="Gurugram">
                                        <option value="Kolkata">
                                        <option value="Ahmedabad">
                                        <option value="Jaipur">
                                        <option value="Indore">
                                        <option value="Bhopal">
                                        <option value="Surat">
                                        <option value="Vadodara">
                                        <option value="Lucknow">
                                        <option value="Chandigarh">
                                        <option value="Kochi">
                                        <option value="Visakhapatnam">
                                        <option value="Coimbatore">
                                        <option value="Remote">
                                        <option value="Work From Home">
                                        <option value="Hybrid">
                                        <option value="Other">
                                    </datalist>
                                </div>
                            </div>
					  <div class="col-md-4">
                        <div class="form-group">



                            <label><h5><b>Experience Required *</b></h5></label>

                            <input type="text"
                                class="form-control"
                                name="experience_required"
                                list="experienceList"
                                placeholder="Select or type experience"
                                required>

                            <datalist id="experienceList">
                                <option value="Fresher">
                                <option value="0-1 Years">
                                <option value="1-2 Years">
                                <option value="2-3 Years">
                                <option value="3-5 Years">
                                <option value="5-7 Years">
                                <option value="7-10 Years">
                                <option value="10+ Years">
                            </datalist>
                        </div>
                    </div>
                



                        <div class="col-md-3">
                        <div class="form-group">
                            <label><h5><b>Vacancies *</b></h5></label>

                            <select id="vacancies"
                                    name="vacancies"
                                    class="form-control"
                                    style="width:100%;"
                                    required>

                                <option value=""></option>

                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                                <option value="25">25</option>
                                <option value="30">30</option>
                                <option value="50">50</option>
                                <option value="100">100</option>

                            </select>

                        </div>
                    </div>


					   <div class="col-md-3">
                <div class="form-group">
                    <label><h5><b>Work Mode *</b></h5></label>

                    <select id="work_mode"
                            name="work_mode"
                            class="form-control"
                            style="width:100%;"
                            required>

                        <option value=""></option>

                        <option value="Work From Office">Work From Office</option>
                        <option value="Remote">Remote</option>
                        <option value="Hybrid">Hybrid</option>
                        <option value="Part Time">Part Time</option>
                        <option value="Full Time">Full Time</option>
                        <option value="Internship">Internship</option>
                        <option value="Contract">Contract</option>
                        <option value="Freelance">Freelance</option>
                        <option value="Temporary">Temporary</option>
                        <option value="Shift Based">Shift Based</option>
                        <option value="Night Shift">Night Shift</option>
                        <option value="Flexible Hours">Flexible Hours</option>
                        <option value="Other">Other</option>

                    </select>

                </div>
            </div> 
</div>			
             <!-- /. PAGE INNER  -->
             <hr />
                <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Job Category List Table
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                             
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <?php
                                            $row=mysqli_query($conn,"select * from Job Category order by name asc");
                                            while($result=mysqli_fetch_assoc($row))
                                            {
                                             ?>
                                          <tr>
                                            <td><a><?php echo $result["id"];?></a></td>
                                            <td><a><?php echo $result["name"];?></a></td>
                                            <td><button class="btn btn-block" style="background-color:red;color:white" onclick="if(!confirm('Are You Sure Want to Delete this Job Category')){return false;}else{DeleteCategory('<?php echo $result['id'];?>');}" type="submit">Remove Job Category</button></td>
                                          </tr>
                                          <?php  }?>
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
            </div>    
            <div>
            </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    
    </div>
    
    
    
    <div class="modal fade" id="loadingmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    ....Loading....
                </div>
            </div>
        </div>
    </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
     <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
     <!-- DATA TABLE SCRIPTS -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
    </script>
         <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
    <script>
        function DeleteCategory(id)
        {
            $('#defaultLoading').modal('show'); 
               $.ajax({
                    url:"deleteoperation.php",
                    method:"POST",
                    data:{id:id,request:'DeleteJob Category'},
                    success:function(data)
                    {
                        $('#defaultLoading').modal('hide'); 
                        console.log(data);
                       if(data=="true")
                        {
                           window.location.href = "Job Category.php";
                        }
                        else{
                            
                        }
                        
                    }
                  });
        }
    </script>
    
   
</body>
</html>
