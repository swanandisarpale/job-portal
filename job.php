

<?php

require 'db.php';

session_start();

if (!isset($_SESSION['login_user'])) {
    header("location: login.php");
    exit();
}

$logger = $_SESSION['login_user'];

date_default_timezone_set("Asia/Kolkata");

$message = "";
$error = "";


/* =====================================================
   ADD JOB
===================================================== */

if (isset($_POST['submit'])) {

    $company_id  = mysqli_real_escape_string($conn, $_POST['company_id']);
    $job_title   = mysqli_real_escape_string($conn, $_POST['job_title']);
    $category    = mysqli_real_escape_string($conn, $_POST['category']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $location    = mysqli_real_escape_string($conn, $_POST['location']);
    $salary      = mysqli_real_escape_string($conn, $_POST['salary']);
    $job_type    = mysqli_real_escape_string($conn, $_POST['job_type']);
    $experience  = mysqli_real_escape_string($conn, $_POST['experience']);
    $vacancies   = mysqli_real_escape_string($conn, $_POST['vacancies']);
    $status      = mysqli_real_escape_string($conn, $_POST['status']);

    $ts = date("Y-m-d H:i:s");

    $sql = "INSERT INTO job
            (
                company_id,
                job_title,
                category,
                description,
                location,
                salary,
                job_type,
                experience,
                vacancies,
                status,
                ts,
                logger
            )
            VALUES
            (
                '$company_id',
                '$job_title',
                '$category',
                '$description',
                '$location',
                '$salary',
                '$job_type',
                '$experience',
                '$vacancies',
                '$status',
                '$ts',
                '$logger'
            )";

    if (mysqli_query($conn, $sql)) {

        $message = "Job added successfully.";

    } else {

        $error = "Error: " . mysqli_error($conn);
    }
}


/* =====================================================
   DELETE JOB
===================================================== */

if (isset($_GET['delete'])) {

    $id = intval($_GET['delete']);

    $sql = "DELETE FROM job WHERE id = $id";

    if (mysqli_query($conn, $sql)) {

        header("Location: jobs.php");
        exit();

    } else {

        $error = "Unable to delete job.";
    }
}

?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta charset="utf-8" />

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0" />

    <title>Jobs - Job Portal</title>


    <!-- BOOTSTRAP STYLES -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />

    <!-- FONTAWESOME STYLES -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />

    <!-- CUSTOM STYLES -->
    <link href="assets/css/custom.css" rel="stylesheet" />

    <!-- GOOGLE FONTS -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans"
          rel="stylesheet"
          type="text/css" />

</head>


<body>

<div id="wrapper">


    <!-- =====================================================
         MENU
    ====================================================== -->

    <?php include 'menu.php'; ?>


    <!-- =====================================================
         PAGE WRAPPER
    ====================================================== -->

    <div id="page-wrapper">

        <div id="page-inner">


            <!-- =====================================================
                 PAGE TITLE
            ====================================================== -->

            <div class="row">

                <div class="col-md-12">

                    <h2>Jobs</h2>

                    <h5>
                        Manage jobs posted by companies.
                    </h5>

                </div>

            </div>


            <hr />


            <!-- =====================================================
                 SUCCESS MESSAGE
            ====================================================== -->

            <?php if ($message != "") { ?>

                <div class="alert alert-success">

                    <?php echo $message; ?>

                </div>

            <?php } ?>


            <!-- =====================================================
                 ERROR MESSAGE
            ====================================================== -->

            <?php if ($error != "") { ?>

                <div class="alert alert-danger">

                    <?php echo $error; ?>

                </div>

            <?php } ?>


            <!-- =====================================================
                 ADD JOB FORM
            ====================================================== -->

            <div class="row">

                <div class="col-md-12">

                    <div class="panel panel-default">

                        <div class="panel-heading">

                            <i class="fa fa-briefcase"></i>
                            Add Job

                        </div>


                        <div class="panel-body">


                            <form method="POST"
                                  action="">


                                <!-- ROW 1 -->

                                <div class="row">


                                    <!-- JOB TITLE -->

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Job Title *
                                            </label>

                                            <input
                                                type="text"
                                                name="job_title"
                                                class="form-control"
                                                placeholder="Enter job title"
                                                required
                                            />

                                        </div>

                                    </div>


                                    <!-- COMPANY -->

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Company *
                                            </label>

                                            <select
                                                name="company_id"
                                                class="form-control"
                                                required
                                            >

                                                <option value="">
                                                    Select Company
                                                </option>

                                                <?php

                                                $company_result = mysqli_query(
                                                    $conn,
                                                    "SELECT id, name
                                                     FROM company
                                                     ORDER BY name ASC"
                                                );

                                                while (
                                                    $company =
                                                    mysqli_fetch_assoc(
                                                        $company_result
                                                    )
                                                ) {

                                                ?>

                                                    <option
                                                        value="<?php echo $company['id']; ?>"
                                                    >

                                                        <?php
                                                        echo htmlspecialchars(
                                                            $company['name']
                                                        );
                                                        ?>

                                                    </option>

                                                <?php

                                                }

                                                ?>

                                            </select>

                                        </div>

                                    </div>


                                    <!-- CATEGORY -->

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Job Category *
                                            </label>

                                            <select
                                                name="category"
                                                class="form-control"
                                                required
                                            >

                                                <option value="">
                                                    Select Category
                                                </option>

                                                <option value="IT & Software">
                                                    IT & Software
                                                </option>

                                                <option value="Web Development">
                                                    Web Development
                                                </option>

                                                <option value="Software Development">
                                                    Software Development
                                                </option>

                                                <option value="Data Science">
                                                    Data Science
                                                </option>

                                                <option value="Banking & Finance">
                                                    Banking & Finance
                                                </option>

                                                <option value="Marketing">
                                                    Marketing
                                                </option>

                                                <option value="Human Resources">
                                                    Human Resources
                                                </option>

                                                <option value="Sales">
                                                    Sales
                                                </option>

                                                <option value="Other">
                                                    Other
                                                </option>

                                            </select>

                                        </div>

                                    </div>

                                </div>


                                <!-- ROW 2 -->

                                <div class="row">


                                    <!-- LOCATION -->

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Location *
                                            </label>

                                            <input
                                                type="text"
                                                name="location"
                                                class="form-control"
                                                placeholder="e.g. Pune, Mumbai"
                                                required
                                            />

                                        </div>

                                    </div>


                                    <!-- SALARY -->

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Salary
                                            </label>

                                            <input
                                                type="text"
                                                name="salary"
                                                class="form-control"
                                                placeholder="e.g. 3 - 5 LPA"
                                            />

                                        </div>

                                    </div>


                                    <!-- JOB TYPE -->

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Job Type *
                                            </label>

                                            <select
                                                name="job_type"
                                                class="form-control"
                                                required
                                            >

                                                <option value="">
                                                    Select Job Type
                                                </option>

                                                <option value="Full Time">
                                                    Full Time
                                                </option>

                                                <option value="Part Time">
                                                    Part Time
                                                </option>

                                                <option value="Internship">
                                                    Internship
                                                </option>

                                                <option value="Work From Home">
                                                    Work From Home
                                                </option>

                                            </select>

                                        </div>

                                    </div>

                                </div>


                                <!-- ROW 3 -->

                                <div class="row">


                                    <!-- EXPERIENCE -->

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Experience
                                            </label>

                                            <select
                                                name="experience"
                                                class="form-control"
                                            >

                                                <option value="">
                                                    Select Experience
                                                </option>

                                                <option value="Fresher">
                                                    Fresher
                                                </option>

                                                <option value="0-1 Years">
                                                    0-1 Years
                                                </option>

                                                <option value="1-2 Years">
                                                    1-2 Years
                                                </option>

                                                <option value="2-5 Years">
                                                    2-5 Years
                                                </option>

                                                <option value="5+ Years">
                                                    5+ Years
                                                </option>

                                            </select>

                                        </div>

                                    </div>


                                    <!-- VACANCIES -->

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Vacancies *
                                            </label>

                                            <input
                                                type="number"
                                                name="vacancies"
                                                class="form-control"
                                                min="1"
                                                value="1"
                                                required
                                            />

                                        </div>

                                    </div>


                                    <!-- STATUS -->

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Status *
                                            </label>

                                            <select
                                                name="status"
                                                class="form-control"
                                                required
                                            >

                                                <option value="Active">
                                                    Active
                                                </option>

                                                <option value="Inactive">
                                                    Inactive
                                                </option>

                                            </select>

                                        </div>

                                    </div>

                                </div>


                                <!-- ROW 4 -->

                                <div class="row">

                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>
                                                Job Description *
                                            </label>

                                            <textarea
                                                name="description"
                                                class="form-control"
                                                rows="4"
                                                placeholder="Enter job description"
                                                required
                                            ></textarea>

                                        </div>

                                    </div>

                                </div>


                                <!-- SUBMIT BUTTON -->

                                <button
                                    type="submit"
                                    name="submit"
                                    class="btn btn-primary"
                                >

                                    <i class="fa fa-plus"></i>
                                    Add Job

                                </button>


                            </form>


                        </div>

                    </div>

                </div>

            </div>


            <!-- =====================================================
                 JOB LIST
            ====================================================== -->

            <div class="row">

                <div class="col-md-12">

                    <div class="panel panel-default">

                        <div class="panel-heading">

                            <i class="fa fa-list"></i>
                            Job List

                        </div>


                        <div class="panel-body">

                            <div class="table-responsive">


                                <table
                                    class="table table-striped table-bordered table-hover"
                                >

                                    <thead>

                                        <tr>

                                            <th>Id</th>

                                            <th>Job Title</th>

                                            <th>Company</th>

                                            <th>Category</th>

                                            <th>Location</th>

                                            <th>Salary</th>

                                            <th>Job Type</th>

                                            <th>Experience</th>

                                            <th>Vacancies</th>

                                            <th>Status</th>

                                            <th>Action</th>

                                        </tr>

                                    </thead>


                                    <tbody>


                                    <?php

                                    $job_result = mysqli_query(
                                        $conn,

                                        "SELECT
                                            job.*,
                                            company.name AS company_name

                                         FROM job

                                         LEFT JOIN company
                                         ON job.company_id = company.id

                                         ORDER BY job.id DESC"
                                    );


                                    if ($job_result) {

                                        while (
                                            $row =
                                            mysqli_fetch_assoc(
                                                $job_result
                                            )
                                        ) {

                                    ?>

                                        <tr>

                                            <!-- ID -->

                                            <td>
                                                <?php
                                                echo $row['id'];
                                                ?>
                                            </td>


                                            <!-- JOB TITLE -->

                                            <td>

                                                <?php
                                                echo htmlspecialchars(
                                                    $row['job_title']
                                                );
                                                ?>

                                            </td>


                                            <!-- COMPANY -->

                                            <td>

                                                <?php
                                                echo htmlspecialchars(
                                                    $row['company_name']
                                                );
                                                ?>

                                            </td>


                                            <!-- CATEGORY -->

                                            <td>

                                                <?php
                                                echo htmlspecialchars(
                                                    $row['category']
                                                );
                                                ?>

                                            </td>


                                            <!-- LOCATION -->

                                            <td>

                                                <?php
                                                echo htmlspecialchars(
                                                    $row['location']
                                                );
                                                ?>

                                            </td>


                                            <!-- SALARY -->

                                            <td>

                                                <?php
                                                echo htmlspecialchars(
                                                    $row['salary']
                                                );
                                                ?>

                                            </td>


                                            <!-- JOB TYPE -->

                                            <td>

                                                <?php
                                                echo htmlspecialchars(
                                                    $row['job_type']
                                                );
                                                ?>

                                            </td>


                                            <!-- EXPERIENCE -->

                                            <td>

                                                <?php
                                                echo htmlspecialchars(
                                                    $row['experience']
                                                );
                                                ?>

                                            </td>


                                            <!-- VACANCIES -->

                                            <td>

                                                <?php
                                                echo $row['vacancies'];
                                                ?>

                                            </td>


                                            <!-- STATUS -->

                                           

                                       <!-- STATUS -->
<td style="text-align: center; vertical-align: middle;">

    <?php if ($row['status'] == 'Active') { ?>

        <span class="btn btn-success btn-sm"
              style="display: inline-block;
                     width: 80px;
                     height: 30px;
                     line-height: 18px;
                     padding: 5px 10px;
                     text-align: center;">
            Active
        </span>

    <?php } else { ?>

        <span class="btn btn-danger btn-sm"
              style="display: inline-block;
                     width: 80px;
                     height: 30px;
                     line-height: 18px;
                     padding: 5px 10px;
                     text-align: center;">
            Inactive
        </span>

    <?php } ?>

</td>


<!-- ACTION -->
<td style="text-align: center; vertical-align: middle;">

    <a href="jobs.php?delete=<?php echo $row['id']; ?>"
       class="btn btn-danger btn-sm"
       style="display: inline-block;
              width: 80px;
              height: 30px;
              line-height: 18px;
              padding: 5px 10px;
              text-align: center;"
       onclick="return confirm('Are you sure you want to delete this job?');">

        <i class="fa fa-trash"></i> Delete

    </a>

</td>

                                        </tr>


                                    <?php

                                        }

                                    }

                                    ?>


                                    </tbody>

                                </table>


                            </div>

                        </div>

                    </div>

                </div>

            </div>


        </div>

    </div>


</div>


<!-- =====================================================
     SCRIPTS
====================================================== -->

<script src="assets/js/jquery-1.10.2.js"></script>

<script src="assets/js/bootstrap.min.js"></script>

<script src="assets/js/jquery.metisMenu.js"></script>

<script src="assets/js/custom.js"></script>


</body>

</html>