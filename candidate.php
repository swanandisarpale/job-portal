<?php

include "db.php";

session_start();

date_default_timezone_set("Asia/Kolkata");

$message = "";


/* =====================================================
   DELETE CANDIDATE
===================================================== */

if (isset($_GET['delete'])) {

    $id = intval($_GET['delete']);

    mysqli_query($conn, "DELETE FROM candidate WHERE id='$id'");

    header("Location: candidate.php");
    exit();
}


/* =====================================================
   CHANGE STATUS
===================================================== */

if (isset($_GET['status']) && isset($_GET['id'])) {

    $id = intval($_GET['id']);
    $status = $_GET['status'];

    if ($status == "Active" || $status == "Inactive") {

        mysqli_query(
            $conn,
            "UPDATE candidate SET status='$status' WHERE id='$id'"
        );
    }

    header("Location: candidate.php");
    exit();
}


/* =====================================================
   DEFAULT EDIT VALUES
===================================================== */

$edit_id = "";
$edit_name = "";
$edit_email = "";
$edit_phone = "";
$edit_gender = "";
$edit_dob = "";
$edit_address = "";
$edit_qualification = "";
$edit_skills = "";
$edit_experience = "";
$edit_status = "Active";


/* =====================================================
   GET CANDIDATE FOR EDIT
===================================================== */

if (isset($_GET['edit'])) {

    $edit_id = intval($_GET['edit']);

    $result = mysqli_query(
        $conn,
        "SELECT * FROM candidate WHERE id='$edit_id'"
    );

    if ($result && mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_assoc($result);

        $edit_name = $row['full_name'];
        $edit_email = $row['email'];
        $edit_phone = $row['phone'];
        $edit_gender = $row['gender'];
        $edit_dob = $row['dob'];
        $edit_address = $row['address'];
        $edit_qualification = $row['qualification'];
        $edit_skills = $row['skills'];
        $edit_experience = $row['experience'];
        $edit_status = $row['status'];
    }
}


/* =====================================================
   ADD / UPDATE CANDIDATE
===================================================== */

if (isset($_POST['save_candidate'])) {

    $id = intval($_POST['id']);

    $full_name = mysqli_real_escape_string(
        $conn,
        $_POST['full_name']
    );

    $email = mysqli_real_escape_string(
        $conn,
        $_POST['email']
    );

    $phone = mysqli_real_escape_string(
        $conn,
        $_POST['phone']
    );

    $gender = mysqli_real_escape_string(
        $conn,
        $_POST['gender']
    );

    $dob = mysqli_real_escape_string(
        $conn,
        $_POST['dob']
    );

    $address = mysqli_real_escape_string(
        $conn,
        $_POST['address']
    );

    $qualification = mysqli_real_escape_string(
        $conn,
        $_POST['qualification']
    );

    $skills = mysqli_real_escape_string(
        $conn,
        $_POST['skills']
    );

    $experience = mysqli_real_escape_string(
        $conn,
        $_POST['experience']
    );

    $status = mysqli_real_escape_string(
        $conn,
        $_POST['status']
    );


    /* =================================================
       UPDATE CANDIDATE
    ================================================= */

    if ($id > 0) {

        $sql = "UPDATE candidate SET

                full_name='$full_name',
                email='$email',
                phone='$phone',
                gender='$gender',
                dob='$dob',
                address='$address',
                qualification='$qualification',
                skills='$skills',
                experience='$experience',
                status='$status'

                WHERE id='$id'";


        if (mysqli_query($conn, $sql)) {

            header("Location: candidate.php");
            exit();

        } else {

            $message = "Error updating candidate: "
                     . mysqli_error($conn);
        }

    }


    /* =================================================
       ADD NEW CANDIDATE
    ================================================= */

    else {

        $ts = date("Y-m-d H:i:s");

        if (isset($_SESSION['login_user'])) {

            $logger = mysqli_real_escape_string(
                $conn,
                $_SESSION['login_user']
            );

        } else {

            $logger = "Admin";
        }


        $sql = "INSERT INTO candidate
                (
                    full_name,
                    email,
                    phone,
                    gender,
                    dob,
                    address,
                    qualification,
                    skills,
                    experience,
                    status,
                    ts,
                    logger
                )

                VALUES
                (
                    '$full_name',
                    '$email',
                    '$phone',
                    '$gender',
                    '$dob',
                    '$address',
                    '$qualification',
                    '$skills',
                    '$experience',
                    '$status',
                    '$ts',
                    '$logger'
                )";


        if (mysqli_query($conn, $sql)) {

            header("Location: candidate.php");
            exit();

        } else {

            $message = "Error adding candidate: "
                     . mysqli_error($conn);
        }
    }
}

?>


<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Candidate Management</title>


    <!-- BOOTSTRAP -->

    <link href="assets/css/bootstrap.css"
          rel="stylesheet">


    <!-- FONT AWESOME -->

    <link href="assets/css/font-awesome.css"
          rel="stylesheet">


    <!-- CUSTOM CSS -->

    <link href="assets/css/custom.css"
          rel="stylesheet">


    <!-- DATATABLE CSS -->

    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap.css"
          rel="stylesheet">


    <style>


        /* =====================================================
           FORM
        ===================================================== */

        .form-control {

            border-radius: 3px;

        }


        /* =====================================================
           TABLE
        ===================================================== */

        #candidateTable {

            width: 100% !important;

            font-size: 12px;

        }


        #candidateTable th,
        #candidateTable td {

            padding: 7px 5px;

            vertical-align: middle;

        }


        #candidateTable th {

            white-space: nowrap;

            text-align: center;

        }


        /* =====================================================
           STATUS + ACTION BUTTONS
        ===================================================== */

        .status-btn,
        .action-btn {

            display: inline-block;

            width: 70px;

            height: 30px;

            line-height: 28px;

            padding: 0;

            margin: 1px;

            text-align: center;

            vertical-align: middle;

            font-size: 11px;

        }


        /* =====================================================
           STATUS COLUMN
        ===================================================== */

        .status-column {

            width: 80px;

            min-width: 80px;

            text-align: center;

        }


        /* =====================================================
           ACTION COLUMN
        ===================================================== */

        .action-column {

            width: 150px;

            min-width: 150px;

            text-align: center;

            white-space: nowrap;

        }


        /* =====================================================
           NAME
        ===================================================== */

        .candidate-name {

            font-weight: bold;

            white-space: nowrap;

        }


        /* =====================================================
           EMAIL
        ===================================================== */

        .candidate-email {

            word-break: break-word;

            max-width: 160px;

        }


        /* =====================================================
           PANEL
        ===================================================== */

        .panel-heading {

            font-weight: bold;

        }


        /* =====================================================
           SAVE BUTTON
        ===================================================== */

        .save-btn {

            min-width: 120px;

        }


        /* =====================================================
           SMALLER SCREENS
        ===================================================== */

        @media (max-width: 1200px) {

            #candidateTable {

                font-size: 11px;

            }


            #candidateTable th,
            #candidateTable td {

                padding: 5px 3px;

            }


            .status-btn,
            .action-btn {

                width: 65px;

                height: 28px;

                line-height: 26px;

                font-size: 10px;

            }


            .action-column {

                width: 140px;

                min-width: 140px;

            }

        }


    </style>

</head>


<body>


<div id="wrapper">


    <!-- =====================================================
         COMMON MENU
    ===================================================== -->

    <?php include "menu.php"; ?>


    <!-- =====================================================
         PAGE WRAPPER
    ===================================================== -->

    <div id="page-wrapper">


        <div id="page-inner">


            <!-- =================================================
                 PAGE TITLE
            ================================================= -->

            <div class="row">

                <div class="col-md-12">

                    <h2>

                        <i class="fa fa-users"></i>

                        Candidate Management

                    </h2>

                    <hr>

                </div>

            </div>



            <!-- =================================================
                 ERROR MESSAGE
            ================================================= -->

            <?php if ($message != "") { ?>

                <div class="alert alert-danger">

                    <?php echo $message; ?>

                </div>

            <?php } ?>



            <!-- =================================================
                 ADD / EDIT FORM
            ================================================= -->

            <div class="row">

                <div class="col-md-12">


                    <div class="panel panel-default">


                        <div class="panel-heading">

                            <?php

                            if ($edit_id > 0) {

                                echo '<i class="fa fa-edit"></i> Edit Candidate';

                            } else {

                                echo '<i class="fa fa-user-plus"></i> Add Candidate';

                            }

                            ?>

                        </div>


                        <div class="panel-body">


                            <form method="POST"
                                  action="candidate.php">


                                <input type="hidden"
                                       name="id"
                                       value="<?php echo $edit_id; ?>">



                                <!-- =========================================
                                     ROW 1
                                ========================================== -->

                                <div class="row">


                                    <!-- NAME -->

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Full Name
                                            </label>

                                            <input type="text"
                                                   name="full_name"
                                                   class="form-control"
                                                   placeholder="Enter full name"
                                                   value="<?php echo htmlspecialchars($edit_name); ?>"
                                                   required>

                                        </div>

                                    </div>



                                    <!-- EMAIL -->

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Email
                                            </label>

                                            <input type="email"
                                                   name="email"
                                                   class="form-control"
                                                   placeholder="Enter email"
                                                   value="<?php echo htmlspecialchars($edit_email); ?>"
                                                   required>

                                        </div>

                                    </div>



                                    <!-- PHONE -->

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Phone
                                            </label>

                                            <input type="text"
                                                   name="phone"
                                                   class="form-control"
                                                   placeholder="Enter phone number"
                                                   value="<?php echo htmlspecialchars($edit_phone); ?>"
                                                   required>

                                        </div>

                                    </div>

                                </div>



                                <!-- =========================================
                                     ROW 2
                                ========================================== -->

                                <div class="row">


                                    <!-- GENDER -->

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Gender
                                            </label>

                                            <select name="gender"
                                                    class="form-control"
                                                    required>

                                                <option value="">
                                                    Select Gender
                                                </option>


                                                <option value="Male"
                                                    <?php
                                                    if ($edit_gender == "Male")
                                                        echo "selected";
                                                    ?>>
                                                    Male
                                                </option>


                                                <option value="Female"
                                                    <?php
                                                    if ($edit_gender == "Female")
                                                        echo "selected";
                                                    ?>>
                                                    Female
                                                </option>


                                                <option value="Other"
                                                    <?php
                                                    if ($edit_gender == "Other")
                                                        echo "selected";
                                                    ?>>
                                                    Other
                                                </option>

                                            </select>

                                        </div>

                                    </div>



                                    <!-- DOB -->

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Date of Birth
                                            </label>

                                            <input type="date"
                                                   name="dob"
                                                   class="form-control"
                                                   value="<?php echo htmlspecialchars($edit_dob); ?>">

                                        </div>

                                    </div>



                                    <!-- QUALIFICATION -->

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Qualification
                                            </label>

                                            <input type="text"
                                                   name="qualification"
                                                   class="form-control"
                                                   placeholder="e.g. B.E. IT"
                                                   value="<?php echo htmlspecialchars($edit_qualification); ?>">

                                        </div>

                                    </div>

                                </div>



                                <!-- =========================================
                                     ROW 3
                                ========================================== -->

                                <div class="row">


                                    <!-- SKILLS -->

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Skills
                                            </label>

                                            <input type="text"
                                                   name="skills"
                                                   class="form-control"
                                                   placeholder="e.g. PHP, Java, SQL"
                                                   value="<?php echo htmlspecialchars($edit_skills); ?>">

                                        </div>

                                    </div>



                                    <!-- EXPERIENCE -->

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Experience
                                            </label>

                                            <select name="experience"
                                                    class="form-control">


                                                <option value="">
                                                    Select Experience
                                                </option>


                                                <option value="Fresher"
                                                    <?php
                                                    if ($edit_experience == "Fresher")
                                                        echo "selected";
                                                    ?>>
                                                    Fresher
                                                </option>


                                                <option value="0-1 Year"
                                                    <?php
                                                    if ($edit_experience == "0-1 Year")
                                                        echo "selected";
                                                    ?>>
                                                    0-1 Year
                                                </option>


                                                <option value="1-2 Years"
                                                    <?php
                                                    if ($edit_experience == "1-2 Years")
                                                        echo "selected";
                                                    ?>>
                                                    1-2 Years
                                                </option>


                                                <option value="2-5 Years"
                                                    <?php
                                                    if ($edit_experience == "2-5 Years")
                                                        echo "selected";
                                                    ?>>
                                                    2-5 Years
                                                </option>


                                                <option value="5+ Years"
                                                    <?php
                                                    if ($edit_experience == "5+ Years")
                                                        echo "selected";
                                                    ?>>
                                                    5+ Years
                                                </option>


                                            </select>

                                        </div>

                                    </div>



                                    <!-- STATUS -->

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Status
                                            </label>

                                            <select name="status"
                                                    class="form-control">


                                                <option value="Active"
                                                    <?php
                                                    if ($edit_status == "Active")
                                                        echo "selected";
                                                    ?>>
                                                    Active
                                                </option>


                                                <option value="Inactive"
                                                    <?php
                                                    if ($edit_status == "Inactive")
                                                        echo "selected";
                                                    ?>>
                                                    Inactive
                                                </option>


                                            </select>

                                        </div>

                                    </div>

                                </div>



                                <!-- =========================================
                                     ADDRESS
                                ========================================== -->

                                <div class="row">

                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>
                                                Address
                                            </label>

                                            <textarea name="address"
                                                      class="form-control"
                                                      rows="2"
                                                      placeholder="Enter candidate address"><?php echo htmlspecialchars($edit_address); ?></textarea>

                                        </div>

                                    </div>

                                </div>



                                <!-- =========================================
                                     FORM BUTTONS
                                ========================================== -->

                                <div class="row">

                                    <div class="col-md-12">


                                        <?php if ($edit_id > 0) { ?>


                                            <button type="submit"
                                                    name="save_candidate"
                                                    class="btn btn-primary save-btn">

                                                <i class="fa fa-save"></i>

                                                Update Candidate

                                            </button>


                                            <a href="candidate.php"
                                               class="btn btn-default">

                                                <i class="fa fa-times"></i>

                                                Cancel

                                            </a>


                                        <?php } else { ?>


                                            <button type="submit"
                                                    name="save_candidate"
                                                    class="btn btn-success save-btn">

                                                <i class="fa fa-plus"></i>

                                                Add Candidate

                                            </button>


                                        <?php } ?>


                                    </div>

                                </div>


                            </form>


                        </div>

                    </div>

                </div>

            </div>



            <!-- =================================================
                 CANDIDATE LIST
            ================================================= -->

            <div class="row">

                <div class="col-md-12">


                    <div class="panel panel-default">


                        <div class="panel-heading">

                            <i class="fa fa-list"></i>

                            Candidate List

                        </div>


                        <div class="panel-body">


                            <div class="table-responsive">


                                <table class="table table-striped table-bordered table-hover"
                                       id="candidateTable">


                                    <thead>

                                        <tr>

                                            <th style="width:45px;">
                                                ID
                                            </th>


                                            <th>
                                                Candidate Name
                                            </th>


                                            <th>
                                                Email
                                            </th>


                                            <th>
                                                Phone
                                            </th>


                                            <th>
                                                Qualification
                                            </th>


                                            <th>
                                                Experience
                                            </th>


                                            <th class="status-column">
                                                Status
                                            </th>


                                            <th class="action-column">
                                                Action
                                            </th>

                                        </tr>

                                    </thead>


                                    <tbody>


                                    <?php

                                    $result = mysqli_query(
                                        $conn,
                                        "SELECT * FROM candidate
                                         ORDER BY id DESC"
                                    );


                                    if ($result && mysqli_num_rows($result) > 0) {


                                        while ($row = mysqli_fetch_assoc($result)) {

                                    ?>


                                        <tr>


                                            <!-- ID -->

                                            <td>

                                                <?php
                                                echo $row['id'];
                                                ?>

                                            </td>



                                            <!-- NAME -->

                                            <td class="candidate-name">

                                                <?php

                                                echo htmlspecialchars(
                                                    $row['full_name']
                                                );

                                                ?>

                                            </td>



                                            <!-- EMAIL -->

                                            <td class="candidate-email">

                                                <?php

                                                echo htmlspecialchars(
                                                    $row['email']
                                                );

                                                ?>

                                            </td>



                                            <!-- PHONE -->

                                            <td>

                                                <?php

                                                echo htmlspecialchars(
                                                    $row['phone']
                                                );

                                                ?>

                                            </td>



                                            <!-- QUALIFICATION -->

                                            <td>

                                                <?php

                                                echo htmlspecialchars(
                                                    $row['qualification']
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



                                            <!-- STATUS -->

                                            <td class="status-column">


                                                <?php

                                                if ($row['status'] == "Active") {

                                                ?>


                                                    <a href="candidate.php?id=<?php echo $row['id']; ?>&status=Inactive"

                                                       class="btn btn-success btn-sm status-btn"

                                                       onclick="return confirm('Make this candidate Inactive?');">

                                                        Active

                                                    </a>


                                                <?php

                                                } else {

                                                ?>


                                                    <a href="candidate.php?id=<?php echo $row['id']; ?>&status=Active"

                                                       class="btn btn-default btn-sm status-btn"

                                                       onclick="return confirm('Make this candidate Active?');">

                                                        Inactive

                                                    </a>


                                                <?php

                                                }

                                                ?>

                                            </td>



                                            <!-- ACTION -->

                                            <td class="action-column">


                                                <a href="candidate.php?edit=<?php echo $row['id']; ?>"

                                                   class="btn btn-primary btn-sm action-btn">

                                                    <i class="fa fa-edit"></i>

                                                    Edit

                                                </a>



                                                <a href="candidate.php?delete=<?php echo $row['id']; ?>"

                                                   class="btn btn-danger btn-sm action-btn"

                                                   onclick="return confirm('Are you sure you want to delete this candidate?');">

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

                                            <td colspan="8"
                                                class="text-center">

                                                No candidates found.

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



<!-- =====================================================
     JAVASCRIPT
===================================================== -->

<script src="assets/js/jquery-1.10.2.js"></script>

<script src="assets/js/bootstrap.min.js"></script>

<script src="assets/js/jquery.metisMenu.js"></script>

<script src="assets/js/custom.js"></script>


<!-- DATATABLE -->

<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script>


<script>

$(document).ready(function () {

    $('#candidateTable').DataTable({

        "pageLength": 10,

        "ordering": true,

        "searching": true,

        "lengthChange": true

    });

});

</script>


</body>

</html>