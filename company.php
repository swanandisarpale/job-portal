

<?php

require 'db.php';
session_start();

if (!isset($_SESSION['login_user'])) {
    header("location: login.php");
    exit();
}

date_default_timezone_set("Asia/Kolkata");

$logger = $_SESSION['login_user'];

/* =====================================================
   DELETE COMPANY
===================================================== */

if (isset($_GET['delete'])) {

    $id = intval($_GET['delete']);

    $delete = mysqli_query($conn, "DELETE FROM company WHERE id = '$id'");

    if ($delete) {
        header("Location: company.php");
        exit();
    } else {
        die("Error deleting company: " . mysqli_error($conn));
    }
}


/* =====================================================
   ADD COMPANY
===================================================== */

$message = "";

if (isset($_POST['submit'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $website = mysqli_real_escape_string($conn, $_POST['website']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $district = mysqli_real_escape_string($conn, $_POST['district']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $industry = mysqli_real_escape_string($conn, $_POST['industry']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $ts = date("Y-m-d H:i:s");

    $sql = "INSERT INTO company
    (
        name,
        address,
        website,
        email,
        phone,
        industry,
        description,
        state,
        district,
        city,
        ts,
        logger
    )
    VALUES
    (
        '$name',
        '$address',
        '$website',
        '$email',
        '$phone',
        '$industry',
        '$description',
        '$state',
        '$district',
        '$city',
        '$ts',
        '$logger'
    )";

    if (mysqli_query($conn, $sql)) {

        $message = "<div class='alert alert-success'>
                        Company added successfully.
                    </div>";

    } else {

        $message = "<div class='alert alert-danger'>
                        Error: " . mysqli_error($conn) . "
                    </div>";
    }
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta charset="utf-8" />

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0" />

    <title>Company Management</title>


    <!-- BOOTSTRAP STYLES -->
    <link href="assets/css/bootstrap.css"
          rel="stylesheet" />


    <!-- FONTAWESOME STYLES -->
    <link href="assets/css/font-awesome.css"
          rel="stylesheet" />


    <!-- CUSTOM STYLES -->
    <link href="assets/css/custom.css"
          rel="stylesheet" />


    <!-- DATA TABLES -->
    <link href="assets/js/dataTables/dataTables.bootstrap.css"
          rel="stylesheet" />


<link rel="stylesheet" href="company.css">

</head>


<body>

<div id="wrapper">


    <!-- =====================================================
         SAME MENU
    ====================================================== -->

    <?php include "menu.php"; ?>


    <!-- =====================================================
         PAGE CONTENT
    ====================================================== -->

    <div id="page-wrapper">

        <div id="page-inner">


            <!-- PAGE TITLE -->

            <div class="row">

                <div class="col-md-12">

                    <h2 class="page-header">
                        <i class="fa fa-building"></i>
                        Company Management
                    </h2>

                </div>

            </div>


            <!-- MESSAGE -->

            <?php echo $message; ?>


            <!-- =================================================
                 ADD COMPANY FORM
            ================================================== -->

            <div class="row">

                <div class="col-md-12">

                    <div class="panel panel-default">

                        <div class="panel-heading">

                            <i class="fa fa-plus"></i>
                            Add Company

                        </div>


                        <div class="panel-body">

                            <form method="POST"
                                  action="company.php">


                                <!-- ROW 1 -->

                                <div class="row">

                                    <!-- COMPANY NAME -->

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Company Name
                                            </label>

                                            <input type="text"
                                                   name="name"
                                                   class="form-control"
                                                   placeholder="Enter company name"
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
                                                   placeholder="Enter company email"
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
                                                   placeholder="Enter phone number">

                                        </div>

                                    </div>

                                </div>


                                <!-- ROW 2 -->

                                <div class="row">

                                    <!-- WEBSITE -->

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Company Website
                                            </label>

                                            <input type="text"
                                                   name="website"
                                                   class="form-control"
                                                   placeholder="https://www.example.com">

                                        </div>

                                    </div>


                                    <!-- INDUSTRY -->

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Industry
                                            </label>

                                            <input type="text"
                                                   name="industry"
                                                   class="form-control"
                                                   placeholder="IT, Finance, Education etc.">

                                        </div>

                                    </div>


                                    <!-- ADDRESS -->

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Address
                                            </label>

                                            <input type="text"
                                                   name="address"
                                                   class="form-control"
                                                   placeholder="Enter company address">

                                        </div>

                                    </div>

                                </div>


                                <!-- ROW 3 -->

                                <div class="row">

                                    <!-- STATE -->

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                State
                                            </label>

                                            <select name="state"
                                                    id="state"
                                                    class="form-control"
                                                    required>

                                                <option value="">
                                                    Select State
                                                </option>

                                                <?php

                                                $states = mysqli_query(
                                                    $conn,
                                                    "SELECT * FROM states
                                                     ORDER BY state_name ASC"
                                                );

                                                while ($s = mysqli_fetch_assoc($states)) {

                                                ?>

                                                    <option value="<?php echo $s['id']; ?>">

                                                        <?php
                                                        echo htmlspecialchars(
                                                            $s['state_name']
                                                        );
                                                        ?>

                                                    </option>

                                                <?php } ?>

                                            </select>

                                        </div>

                                    </div>


                                    <!-- DISTRICT -->

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                District
                                            </label>

                                            <select name="district"
                                                    id="district"
                                                    class="form-control"
                                                    required
                                                    disabled>

                                                <option value="">
                                                    Select District
                                                </option>

                                            </select>

                                        </div>

                                    </div>


                                    <!-- CITY -->

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                City
                                            </label>

                                            <select name="city"
                                                    id="city"
                                                    class="form-control"
                                                    required
                                                    disabled>

                                                <option value="">
                                                    Select City
                                                </option>

                                            </select>

                                        </div>

                                    </div>

                                </div>


                                <!-- DESCRIPTION -->

                                <div class="row">

                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>
                                                Company Description
                                            </label>

                                            <textarea name="description"
                                                      class="form-control"
                                                      rows="4"
                                                      placeholder="Enter company description"></textarea>

                                        </div>

                                    </div>

                                </div>


                                <!-- SUBMIT -->

                                <div class="row">

                                    <div class="col-md-12">

                                        <button type="submit"
                                                name="submit"
                                                class="btn btn-primary">

                                            <i class="fa fa-save"></i>
                                            Submit

                                        </button>

                                        <button type="reset"
                                                class="btn btn-default">

                                            <i class="fa fa-refresh"></i>
                                            Reset

                                        </button>

                                    </div>

                                </div>


                            </form>

                        </div>

                    </div>

                </div>

            </div>


            <!-- =================================================
                 COMPANY LIST
            ================================================== -->

            <div class="row">

                <div class="col-md-12">

                    <div class="panel panel-default">


                        <div class="panel-heading">

                            <i class="fa fa-building"></i>
                            Company List

                        </div>


                        <div class="panel-body">

                            <div class="table-responsive">


                                <table class="table table-striped
                                              table-bordered table-hover"
                                       id="companyTable">


                                    <thead>

                                    <tr>

                                        <th>ID</th>

                                        <th>Company Name</th>

                                        <th>Address</th>

                                        <th>Website</th>

                                        <th>Email</th>

                                        <th>Phone</th>

                                        <th>Industry</th>

                                        <th>State</th>

                                        <th>District</th>

                                        <th>City</th>

                                        <th>Action</th>

                                    </tr>

                                    </thead>


                                    <tbody>


                                    <?php

                                    /* =================================================
                                       IMPORTANT QUERY

                                       This joins the IDs with actual names
                                    ================================================== */

                                    $row = mysqli_query(
                                        $conn,
                                        "
                                        SELECT
                                            company.*,

                                            states.state_name,

                                            districts.district_name,

                                            cities.city_name

                                        FROM company

                                        LEFT JOIN states
                                            ON company.state = states.id

                                        LEFT JOIN districts
                                            ON company.district = districts.id

                                        LEFT JOIN cities
                                            ON company.city = cities.id

                                        ORDER BY company.name ASC
                                        "
                                    );


                                    if (!$row) {

                                        die(
                                            "Company query error: "
                                            . mysqli_error($conn)
                                        );

                                    }


                                    while ($result = mysqli_fetch_assoc($row)) {

                                    ?>


                                    <tr>


                                        <!-- ID -->

                                        <td>

                                            <?php
                                            echo $result['id'];
                                            ?>

                                        </td>


                                        <!-- COMPANY NAME -->

                                        <td class="company-name">

                                            <?php

                                            echo htmlspecialchars(
                                                $result['name']
                                            );

                                            ?>

                                        </td>


                                        <!-- ADDRESS -->

                                        <td>

                                            <?php

                                            echo htmlspecialchars(
                                                $result['address']
                                            );

                                            ?>

                                        </td>


                                        <!-- WEBSITE -->

                                        <td>

                                            <?php

                                            if (!empty($result['website'])) {

                                                $website =
                                                    trim($result['website']);

                                                /*
                                                 * Add https:// if user
                                                 * didn't enter it.
                                                 */

                                                if (
                                                    !preg_match(
                                                        "/^https?:\/\//i",
                                                        $website
                                                    )
                                                ) {

                                                    $website =
                                                        "https://" . $website;

                                                }

                                            ?>

                                                <a href="<?php
                                                echo htmlspecialchars($website);
                                                ?>"
                                                   target="_blank"
                                                   class="btn btn-info btn-xs website-btn">

                                                    <i class="fa fa-globe"></i>
                                                    Visit

                                                </a>

                                            <?php

                                            } else {

                                                echo "-";

                                            }

                                            ?>

                                        </td>


                                        <!-- EMAIL -->

                                        <td>

                                            <?php

                                            echo htmlspecialchars(
                                                $result['email']
                                            );

                                            ?>

                                        </td>


                                        <!-- PHONE -->

                                        <td>

                                            <?php

                                            echo htmlspecialchars(
                                                $result['phone']
                                            );

                                            ?>

                                        </td>


                                        <!-- INDUSTRY -->

                                        <td>

                                            <?php

                                            echo htmlspecialchars(
                                                $result['industry']
                                            );

                                            ?>

                                        </td>


                                        <!-- =================================================
                                             ACTUAL STATE NAME
                                        ================================================== -->

                                        <td>

                                            <?php

                                            echo htmlspecialchars(
                                                $result['state_name']
                                                ?? '-'
                                            );

                                            ?>

                                        </td>


                                        <!-- =================================================
                                             ACTUAL DISTRICT NAME
                                        ================================================== -->

                                        <td>

                                            <?php

                                            echo htmlspecialchars(
                                                $result['district_name']
                                                ?? '-'
                                            );

                                            ?>

                                        </td>


                                        <!-- =================================================
                                             ACTUAL CITY NAME
                                        ================================================== -->

                                        <td>

                                            <?php

                                            echo htmlspecialchars(
                                                $result['city_name']
                                                ?? '-'
                                            );

                                            ?>

                                        </td>


                                        <!-- ACTION -->

                                        <td style="white-space: nowrap;">

                                            <a href="company.php?delete=<?php
                                            echo $result['id'];
                                            ?>"
                                               class="btn btn-danger btn-sm action-btn"
                                               onclick="return confirm('Are you sure you want to delete this company?');">

                                                <i class="fa fa-trash"></i>
                                                Delete

                                            </a>

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
====================================================== -->

<script src="assets/js/jquery-1.10.2.js"></script>

<script src="assets/js/bootstrap.min.js"></script>

<script src="assets/js/jquery.metisMenu.js"></script>

<script src="assets/js/custom.js"></script>


<!-- DATATABLES -->

<script src="assets/js/dataTables/jquery.dataTables.js"></script>

<script src="assets/js/dataTables/dataTables.bootstrap.js"></script>


<script>

$(document).ready(function () {

    $('#companyTable').DataTable();

});

</script>




<!-- =====================================================
     STATE → DISTRICT → CITY
====================================================== -->

<script>

/* =====================================================
   STATE CHANGE → LOAD DISTRICTS
===================================================== */

$('#state').change(function () {

    var state = $(this).val();

    $('#district')
        .html('<option value="">Select District</option>')
        .prop('disabled', true);

    $('#city')
        .html('<option value="">Select City</option>')
        .prop('disabled', true);


    if (state != '') {

        $.ajax({

            url: 'GetSubdata.php',

            type: 'POST',

            data: {

                state: state,
                request: 'GetDistrict'

            },

            success: function (response) {

                $('#district')
                    .html(
                        '<option value="">Select District</option>' +
                        response
                    )
                    .prop('disabled', false);

            },

            error: function () {

                alert('Unable to load districts.');

            }

        });

    }

});


/* =====================================================
   DISTRICT CHANGE → LOAD CITIES
===================================================== */

$('#district').change(function () {

    var district = $(this).val();

    var state = $('#state').val();


    $('#city')
        .html('<option value="">Select City</option>')
        .prop('disabled', true);


    if (district != '') {

        $.ajax({

            url: 'GetSubdata.php',

            type: 'POST',

            data: {

                district1: district,

                state1: state,

                request: 'GetCities'

            },

            success: function (response) {

                $('#city')
                    .html(
                        '<option value="">Select City</option>' +
                        response
                    )
                    .prop('disabled', false);

            },

            error: function () {

                alert('Unable to load cities.');

            }

        });

    }

});

</script>
<script>

    
    /* ==============================================
       STATE CHANGE
    ============================================== */

    $('#state').change(function () {

        var state = $(this).val();
        

        $('#district')
            .html('<option value="">Select District</option>')
            .prop('disabled', true);


        $('#city')
            .html('<option value="">Select City</option>')
            .prop('disabled', true);


        if (state != '') {

            $.ajax({

                url: 'GetSubdata.php',

                type: 'POST',

                data: {

                    state: state,

                    request: 'GetDistrict'

                },

                success: function (response) {
                   
                    $('#district')
                        .html(
                            '<option value="">Select District</option>'
                            + response
                        )
                        .prop('disabled', false);

                },

                error: function () {

                    alert('Unable to load districts.');

                }

            });

        }

    });

    

</script>

</body>

</html>