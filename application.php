<?php

session_start();
require 'db.php';

/* =====================================================
   CHECK LOGIN
===================================================== */

if (!isset($_SESSION['login_user'])) {
    header("location: login.php");
    exit();
}


/* =====================================================
   ADD APPLICATION
===================================================== */

$message = "";

if (isset($_POST['submit'])) {

    $candidate_id = $_POST['candidate_id'];
    $job_id       = $_POST['job_id'];
    $status       = $_POST['status'];

    $sql = "INSERT INTO application
            (candidate_id, job_id, status)
            VALUES
            ('$candidate_id', '$job_id', '$status')";

    if (mysqli_query($conn, $sql)) {

        $message = "Application added successfully.";

    } else {

        $message = "Error: " . mysqli_error($conn);

    }
}


/* =====================================================
   DELETE APPLICATION
===================================================== */

if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    $sql = "DELETE FROM application WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {

        header("Location: application.php");
        exit();

    } else {

        $message = "Error deleting application.";

    }
}

?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta charset="utf-8" />

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0" />

    <title>Job Portal - Applications</title>


    <!-- BOOTSTRAP STYLES -->

    <link href="assets/css/bootstrap.css"
          rel="stylesheet" />


    <!-- FONTAWESOME STYLES -->

    <link href="assets/css/font-awesome.css"
          rel="stylesheet" />


    <!-- CUSTOM STYLES -->

    <link href="assets/css/custom.css"
          rel="stylesheet" />


    <!-- GOOGLE FONTS -->

    <link href="http://fonts.googleapis.com/css?family=Open+Sans"
          rel="stylesheet"
          type="text/css" />


</head>


<body>


<div id="wrapper">


    <!-- =================================================
         SAME SIDEBAR / MENU
    ================================================== -->

    <?php include 'menu.php'; ?>


    <!-- =================================================
         PAGE WRAPPER
    ================================================== -->

    <div id="page-wrapper">

        <div id="page-inner">


            <!-- =================================================
                 PAGE TITLE
            ================================================== -->

            <div class="row">

                <div class="col-md-12">

                    <h2>
                        Applications
                    </h2>

                    <h5>
                        Manage candidate job applications
                    </h5>

                </div>

            </div>


            <hr />


            <!-- =================================================
                 SUCCESS / ERROR MESSAGE
            ================================================== -->

            <?php if ($message != "") { ?>

                <div class="alert alert-info">

                    <?php echo $message; ?>

                </div>

            <?php } ?>


            <!-- =================================================
                 ADD APPLICATION
            ================================================== -->

            <div class="row">

                <div class="col-md-12">

                    <div class="panel panel-default">


                        <div class="panel-heading">

                            Add Application

                        </div>


                        <div class="panel-body">


                            <form method="POST"
                                  action="">


                                <div class="row">


                                    <!-- CANDIDATE -->

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Candidate *
                                            </label>


                                            <select name="candidate_id"
                                                    class="form-control"
                                                    required>

                                                <option value="">
                                                    Select Candidate
                                                </option>


                                                <?php

                                                $candidate_result = mysqli_query(
                                                    $conn,
                                                    "SELECT * FROM candidate ORDER BY id DESC"
                                                );


                                                if ($candidate_result) {

                                                    while ($candidate = mysqli_fetch_assoc($candidate_result)) {

                                                ?>

                                                        <option value="<?php echo $candidate['id']; ?>">

                                                            <?php

                                                            if (isset($candidate['name'])) {

                                                                echo htmlspecialchars($candidate['name']);

                                                            } else {

                                                                echo "Candidate #" . $candidate['id'];

                                                            }

                                                            ?>

                                                        </option>

                                                <?php

                                                    }

                                                }

                                                ?>

                                            </select>

                                        </div>

                                    </div>


                                    <!-- JOB -->

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Job *
                                            </label>


                                            <select name="job_id"
                                                    class="form-control"
                                                    required>

                                                <option value="">
                                                    Select Job
                                                </option>


                                                <?php

                                                $job_result = mysqli_query(
                                                    $conn,
                                                    "SELECT * FROM job ORDER BY id DESC"
                                                );


                                                if ($job_result) {

                                                    while ($job = mysqli_fetch_assoc($job_result)) {

                                                ?>

                                                        <option value="<?php echo $job['id']; ?>">

                                                            <?php

                                                            if (isset($job['title'])) {

                                                                echo htmlspecialchars($job['title']);

                                                            } elseif (isset($job['job_title'])) {

                                                                echo htmlspecialchars($job['job_title']);

                                                            } elseif (isset($job['name'])) {

                                                                echo htmlspecialchars($job['name']);

                                                            } else {

                                                                echo "Job #" . $job['id'];

                                                            }

                                                            ?>

                                                        </option>

                                                <?php

                                                    }

                                                }

                                                ?>

                                            </select>

                                        </div>

                                    </div>


                                    <!-- STATUS -->

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Status *
                                            </label>


                                            <select name="status"
                                                    class="form-control"
                                                    required>

                                                <option value="">
                                                    Select Status
                                                </option>

                                                <option value="Pending">
                                                    Pending
                                                </option>

                                                <option value="Shortlisted">
                                                    Shortlisted
                                                </option>

                                                <option value="Selected">
                                                    Selected
                                                </option>

                                                <option value="Rejected">
                                                    Rejected
                                                </option>

                                            </select>

                                        </div>

                                    </div>


                                </div>


                                <br />


                                <!-- SUBMIT BUTTON -->

                                <button type="submit"
                                        name="submit"
                                        class="btn btn-primary">

                                    <i class="fa fa-plus"></i>
                                    Add Application

                                </button>


                            </form>


                        </div>

                    </div>

                </div>

            </div>



            <!-- =================================================
                 APPLICATION LIST
            ================================================== -->

            <div class="row">

                <div class="col-md-12">

                    <div class="panel panel-default">


                        <div class="panel-heading">

                            Application List

                        </div>


                        <div class="panel-body">


                            <div class="table-responsive">


                                <table class="table table-striped table-bordered table-hover">


                                    <thead>

                                        <tr>

                                            <th>
                                                Id
                                            </th>

                                            <th>
                                                Candidate
                                            </th>

                                            <th>
                                                Job
                                            </th>

                                            <th>
                                                Status
                                            </th>

                                            <th>
                                                Action
                                            </th>

                                        </tr>

                                    </thead>


                                    <tbody>


                                    <?php

                                    $application_result = mysqli_query(
                                        $conn,
                                        "SELECT * FROM application ORDER BY id DESC"
                                    );


                                    if ($application_result) {

                                        while ($application = mysqli_fetch_assoc($application_result)) {

                                    ?>


                                        <tr>


                                            <!-- ID -->

                                            <td>

                                                <?php
                                                echo $application['id'];
                                                ?>

                                            </td>


                                            <!-- CANDIDATE -->

                                            <td>

                                                <?php

                                                $candidate_id =
                                                    $application['candidate_id'];


                                                $candidate_query = mysqli_query(
                                                    $conn,
                                                    "SELECT * FROM candidate
                                                     WHERE id='$candidate_id'"
                                                );


                                                if ($candidate_query &&
                                                    mysqli_num_rows($candidate_query) > 0) {

                                                    $candidate_data =
                                                        mysqli_fetch_assoc($candidate_query);


                                                    if (isset($candidate_data['name'])) {

                                                        echo htmlspecialchars(
                                                            $candidate_data['name']
                                                        );

                                                    } else {

                                                        echo "Candidate #"
                                                             . $candidate_id;

                                                    }

                                                } else {

                                                    echo "Candidate #"
                                                         . $candidate_id;

                                                }

                                                ?>

                                            </td>


                                            <!-- JOB -->

                                            <td>

                                                <?php

                                                $job_id =
                                                    $application['job_id'];


                                                $job_query = mysqli_query(
                                                    $conn,
                                                    "SELECT * FROM job
                                                     WHERE id='$job_id'"
                                                );


                                                if ($job_query &&
                                                    mysqli_num_rows($job_query) > 0) {

                                                    $job_data =
                                                        mysqli_fetch_assoc($job_query);


                                                    if (isset($job_data['title'])) {

                                                        echo htmlspecialchars(
                                                            $job_data['title']
                                                        );

                                                    } elseif (isset($job_data['job_title'])) {

                                                        echo htmlspecialchars(
                                                            $job_data['job_title']
                                                        );

                                                    } elseif (isset($job_data['name'])) {

                                                        echo htmlspecialchars(
                                                            $job_data['name']
                                                        );

                                                    } else {

                                                        echo "Job #"
                                                             . $job_id;

                                                    }

                                                } else {

                                                    echo "Job #"
                                                         . $job_id;

                                                }

                                                ?>

                                            </td>


                                            <!-- STATUS -->

                                            <td>

                                                <?php

                                                $status =
                                                    $application['status'];


                                                if ($status == "Pending") {

                                                    echo '<span class="label label-warning">
                                                            Pending
                                                          </span>';

                                                } elseif ($status == "Shortlisted") {

                                                    echo '<span class="label label-info">
                                                            Shortlisted
                                                          </span>';

                                                } elseif ($status == "Selected") {

                                                    echo '<span class="label label-success">
                                                            Selected
                                                          </span>';

                                                } elseif ($status == "Rejected") {

                                                    echo '<span class="label label-danger">
                                                            Rejected
                                                          </span>';

                                                } else {

                                                    echo htmlspecialchars($status);

                                                }

                                                ?>

                                            </td>


                                            <!-- ACTION -->

                                            <td>

                                                <a href="application.php?delete=<?php echo $application['id']; ?>"
                                                   class="btn btn-danger btn-sm"
                                                   onclick="return confirm('Are you sure you want to delete this application?');">

                                                    <i class="fa fa-trash"></i>
                                                    Delete

                                                </a>

                                            </td>


                                        </tr>


                                    <?php

                                        }

                                    } else {

                                    ?>

                                        <tr>

                                            <td colspan="5"
                                                class="text-center">

                                                No applications found.

                                            </td>

                                        </tr>

                                    <?php

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



<!-- =================================================
     JAVASCRIPT
================================================== -->

<script src="assets/js/jquery-1.10.2.js"></script>

<script src="assets/js/bootstrap.min.js"></script>

<script src="assets/js/jquery.metisMenu.js"></script>

<script src="assets/js/custom.js"></script>


</body>

</html>