<?php
session_start();
require 'db.php';

if (!isset($_SESSION['login_user'])) {
    header("Location: login.php");
    exit();
}

/* =========================
   COUNTS
========================= */

function getCount($conn, $table)
{
    $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM $table");

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }

    return 0;
}

$company_count     = getCount($conn, "company");
$candidate_count   = getCount($conn, "candidate");
$job_count         = getCount($conn, "job");
$application_count = getCount($conn, "application");


/* =========================
   APPLICATION STATUS
========================= */

$pending = 0;
$shortlisted = 0;
$selected = 0;
$rejected = 0;

$status_query = mysqli_query(
    $conn,
    "SELECT status, COUNT(*) AS total
     FROM application
     GROUP BY status"
);

if ($status_query) {

    while ($row = mysqli_fetch_assoc($status_query)) {

        $status = strtolower(trim($row['status']));

        if ($status == "pending") {
            $pending = $row['total'];
        }

        if ($status == "shortlisted") {
            $shortlisted = $row['total'];
        }

        if ($status == "selected") {
            $selected = $row['total'];
        }

        if ($status == "rejected") {
            $rejected = $row['total'];
        }
    }
}

$total_status = $pending + $shortlisted + $selected + $rejected;

if ($total_status > 0) {

    $pending_percent =
        round(($pending / $total_status) * 100);

    $shortlisted_percent =
        round(($shortlisted / $total_status) * 100);

    $selected_percent =
        round(($selected / $total_status) * 100);

    $rejected_percent =
        round(($rejected / $total_status) * 100);

} else {

    $pending_percent = 0;
    $shortlisted_percent = 0;
    $selected_percent = 0;
    $rejected_percent = 0;
}


/* =========================
   RECENT APPLICATIONS
========================= */

$recent_applications = mysqli_query(
    $conn,
    "SELECT
        application.*,
        candidate.full_name,
        job.job_title
     FROM application
     LEFT JOIN candidate
        ON application.candidate_id = candidate.id
     LEFT JOIN job
        ON application.job_id = job.id
     ORDER BY application.id DESC
     LIMIT 5"
);


/* =========================
   RECENT JOBS
========================= */

$recent_jobs = mysqli_query(
    $conn,
    "SELECT
        job.*,
        company.name AS company_name
     FROM job
     LEFT JOIN company
        ON job.company_id = company.id
     ORDER BY job.id DESC
     LIMIT 5"
);

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Job Portal Dashboard</title>

    <link href="assets/css/bootstrap.css"
          rel="stylesheet">

    <link href="assets/css/font-awesome.css"
          rel="stylesheet">

    <link href="assets/css/custom.css"
          rel="stylesheet">

    <link rel="stylesheet" href="dashboard.css">


    <style>

        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 767px) {

            #page-inner {
                padding: 15px;
            }

            .welcome-section {
                padding: 25px;
            }

            .welcome-section h1 {
                font-size: 23px;
            }

            .online-status {
                float: none;
                display: inline-block;
                margin-top: 15px;
            }

        }

    </style>

</head>


<body>

<div id="wrapper">


    <!-- =================================================
         LEFT SIDE MENU
         KEEPING YOUR EXISTING MENU
    ================================================= -->

    <?php include "menu.php"; ?>


    <!-- =================================================
         PAGE
    ================================================= -->

    <div id="page-wrapper">

        <div id="page-inner">


            <!-- =================================================
                 WELCOME
            ================================================= -->

            <div class="welcome-section">

                <div class="welcome-content">

                    <div class="online-status">

                        <span class="online-dot"></span>

                        System Online

                    </div>


                    <h1>
                        Welcome to Job Portal
                    </h1>


                    <p>
                        Your complete recruitment management dashboard
                    </p>


                    <div class="welcome-user">

                        <i class="fa fa-user-circle"></i>

                        &nbsp;

                        <?php
                        echo htmlspecialchars(
                            $_SESSION['login_user']
                        );
                        ?>

                        &nbsp; | &nbsp;

                        Administrator

                    </div>

                </div>

            </div>



            <!-- =================================================
                 STATISTICS
            ================================================= -->

            <div class="row">


                <!-- COMPANY -->

                <div class="col-md-3 col-sm-6">

                    <div class="stat-card stat-blue">

                        <div class="stat-icon">

                            <i class="fa fa-building"></i>

                        </div>


                        <div class="stat-label">
                            TOTAL COMPANIES
                        </div>


                        <div class="stat-number">

                            <?php echo $company_count; ?>

                        </div>


                        <a href="company.php"
                           class="stat-link">

                            View Companies

                            <i class="fa fa-arrow-right pull-right"></i>

                        </a>

                    </div>

                </div>



                <!-- CANDIDATE -->

                <div class="col-md-3 col-sm-6">

                    <div class="stat-card stat-purple">

                        <div class="stat-icon">

                            <i class="fa fa-users"></i>

                        </div>


                        <div class="stat-label">
                            TOTAL CANDIDATES
                        </div>


                        <div class="stat-number">

                            <?php echo $candidate_count; ?>

                        </div>


                        <a href="candidate.php"
                           class="stat-link">

                            View Candidates

                            <i class="fa fa-arrow-right pull-right"></i>

                        </a>

                    </div>

                </div>



                <!-- JOB -->

                <div class="col-md-3 col-sm-6">

                    <div class="stat-card stat-green">

                        <div class="stat-icon">

                            <i class="fa fa-briefcase"></i>

                        </div>


                        <div class="stat-label">
                            TOTAL JOBS
                        </div>


                        <div class="stat-number">

                            <?php echo $job_count; ?>

                        </div>


                        <a href="job.php"
                           class="stat-link">

                            View Jobs

                            <i class="fa fa-arrow-right pull-right"></i>

                        </a>

                    </div>

                </div>



                <!-- APPLICATION -->

                <div class="col-md-3 col-sm-6">

                    <div class="stat-card stat-orange">

                        <div class="stat-icon">

                            <i class="fa fa-file-text-o"></i>

                        </div>


                        <div class="stat-label">
                            APPLICATIONS
                        </div>


                        <div class="stat-number">

                            <?php echo $application_count; ?>

                        </div>


                        <a href="application.php"
                           class="stat-link">

                            View Applications

                            <i class="fa fa-arrow-right pull-right"></i>

                        </a>

                    </div>

                </div>

            </div>



            <!-- =================================================
                 MANAGEMENT CENTER
            ================================================= -->

            <div class="dashboard-box">

                <div class="section-title">

                    <h3>

                        <i class="fa fa-th-large"></i>

                        &nbsp; Management Center

                    </h3>


                    <p>
                        Manage all major sections of your Job Portal
                    </p>

                </div>


                <div class="row">


                    <!-- COMPANY -->

                    <div class="col-md-2 col-sm-4 col-xs-6">

                        <a href="company.php"
                           class="module-card">

                            <div class="module-icon icon-company">

                                <i class="fa fa-building"></i>

                            </div>


                            <strong>
                                Company
                            </strong>


                            <span>
                                Manage companies
                            </span>

                        </a>

                    </div>



                    <!-- JOB -->

                    <div class="col-md-2 col-sm-4 col-xs-6">

                        <a href="job.php"
                           class="module-card">

                            <div class="module-icon icon-job">

                                <i class="fa fa-briefcase"></i>

                            </div>


                            <strong>
                                Jobs
                            </strong>


                            <span>
                                Manage jobs
                            </span>

                        </a>

                    </div>



                    <!-- APPLICATION -->

                    <div class="col-md-2 col-sm-4 col-xs-6">

                        <a href="application.php"
                           class="module-card">

                            <div class="module-icon icon-application">

                                <i class="fa fa-file-text-o"></i>

                            </div>


                            <strong>
                                Applications
                            </strong>


                            <span>
                                Review applications
                            </span>

                        </a>

                    </div>



                    <!-- CANDIDATE -->

                    <div class="col-md-2 col-sm-4 col-xs-6">

                        <a href="candidate.php"
                           class="module-card">

                            <div class="module-icon icon-candidate">

                                <i class="fa fa-user"></i>

                            </div>


                            <strong>
                                Candidate
                            </strong>


                            <span>
                                Manage candidates
                            </span>

                        </a>

                    </div>



                    <!-- USERS -->

                    <div class="col-md-2 col-sm-4 col-xs-6">

                        <a href="users.php"
                           class="module-card">

                            <div class="module-icon icon-users">

                                <i class="fa fa-users"></i>

                            </div>


                            <strong>
                                Users
                            </strong>


                            <span>
                                Manage users
                            </span>

                        </a>

                    </div>



                    <!-- REPORT -->

                    <div class="col-md-2 col-sm-4 col-xs-6">

                        <a href="report.php"
                           class="module-card">

                            <div class="module-icon icon-report">

                                <i class="fa fa-bar-chart"></i>

                            </div>


                            <strong>
                                Reports
                            </strong>


                            <span>
                                View reports
                            </span>

                        </a>

                    </div>

                </div>

            </div>



            <!-- =================================================
                 PIPELINE + STATUS
            ================================================= -->

            <div class="row">


                <!-- PIPELINE -->

                <div class="col-md-7">

                    <div class="dashboard-box">

                        <div class="section-title">

                            <h3>

                                <i class="fa fa-line-chart"></i>

                                &nbsp; Recruitment Pipeline

                            </h3>


                            <p>
                                Application progress overview
                            </p>

                        </div>


                        <!-- PENDING -->

                        <div class="pipeline-item">

                            <div class="pipeline-top">

                                Pending

                                <strong>

                                    <?php echo $pending; ?>

                                    &nbsp;

                                    <?php echo $pending_percent; ?>%

                                </strong>

                            </div>


                            <div class="progress">

                                <div class="progress-bar bar-pending"
                                     style="width:<?php echo $pending_percent; ?>%">

                                </div>

                            </div>

                        </div>



                        <!-- SHORTLISTED -->

                        <div class="pipeline-item">

                            <div class="pipeline-top">

                                Shortlisted

                                <strong>

                                    <?php echo $shortlisted; ?>

                                    &nbsp;

                                    <?php echo $shortlisted_percent; ?>%

                                </strong>

                            </div>


                            <div class="progress">

                                <div class="progress-bar bar-shortlisted"
                                     style="width:<?php echo $shortlisted_percent; ?>%">

                                </div>

                            </div>

                        </div>



                        <!-- SELECTED -->

                        <div class="pipeline-item">

                            <div class="pipeline-top">

                                Selected

                                <strong>

                                    <?php echo $selected; ?>

                                    &nbsp;

                                    <?php echo $selected_percent; ?>%

                                </strong>

                            </div>


                            <div class="progress">

                                <div class="progress-bar bar-selected"
                                     style="width:<?php echo $selected_percent; ?>%">

                                </div>

                            </div>

                        </div>



                        <!-- REJECTED -->

                        <div class="pipeline-item">

                            <div class="pipeline-top">

                                Rejected

                                <strong>

                                    <?php echo $rejected; ?>

                                    &nbsp;

                                    <?php echo $rejected_percent; ?>%

                                </strong>

                            </div>


                            <div class="progress">

                                <div class="progress-bar bar-rejected"
                                     style="width:<?php echo $rejected_percent; ?>%">

                                </div>

                            </div>

                        </div>

                    </div>

                </div>



                <!-- STATUS CARDS -->

                <div class="col-md-5">

                    <div class="dashboard-box">

                        <div class="section-title">

                            <h3>

                                <i class="fa fa-pie-chart"></i>

                                &nbsp; Application Status

                            </h3>


                            <p>
                                Current application summary
                            </p>

                        </div>


                        <div class="row">


                            <div class="col-xs-6">

                                <div class="status-mini status-pending">

                                    <h4>
                                        <?php echo $pending; ?>
                                    </h4>

                                    <p>
                                        Pending
                                    </p>

                                </div>

                            </div>



                            <div class="col-xs-6">

                                <div class="status-mini status-shortlisted">

                                    <h4>
                                        <?php echo $shortlisted; ?>
                                    </h4>

                                    <p>
                                        Shortlisted
                                    </p>

                                </div>

                            </div>



                            <div class="col-xs-6">

                                <div class="status-mini status-selected">

                                    <h4>
                                        <?php echo $selected; ?>
                                    </h4>

                                    <p>
                                        Selected
                                    </p>

                                </div>

                            </div>



                            <div class="col-xs-6">

                                <div class="status-mini status-rejected">

                                    <h4>
                                        <?php echo $rejected; ?>
                                    </h4>

                                    <p>
                                        Rejected
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>



            <!-- =================================================
                 RECENT APPLICATIONS + JOBS
            ================================================= -->

            <div class="row">


                <!-- APPLICATIONS -->

                <div class="col-md-7">

                    <div class="dashboard-box">

                        <div class="section-title">

                            <h3>

                                <i class="fa fa-clock-o"></i>

                                &nbsp; Recent Applications

                            </h3>


                            <p>
                                Latest applications received
                            </p>

                        </div>


                        <div class="table-responsive">

                            <table class="table recent-table">

                                <thead>

                                    <tr>

                                        <th>
                                            Candidate
                                        </th>

                                        <th>
                                            Job
                                        </th>

                                        <th>
                                            Status
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>

                                <?php

                                if (
                                    $recent_applications &&
                                    mysqli_num_rows($recent_applications) > 0
                                ) {

                                    while (
                                        $app =
                                        mysqli_fetch_assoc(
                                            $recent_applications
                                        )
                                    ) {

                                        $status =
                                            strtolower(
                                                trim(
                                                    $app['status']
                                                )
                                            );

                                        ?>

                                        <tr>

                                            <td>

                                                <span class="candidate-name">

                                                    <?php

                                                    echo htmlspecialchars(
                                                        $app['full_name']
                                                        ?: "Unknown"
                                                    );

                                                    ?>

                                                </span>

                                            </td>


                                            <td>

                                                <span class="job-name">

                                                    <?php

                                                    echo htmlspecialchars(
                                                        $app['job_title']
                                                        ?: "Unknown Job"
                                                    );

                                                    ?>

                                                </span>

                                            </td>


                                            <td>

                                                <span class="status-label

                                                <?php

                                                if ($status == "pending")
                                                    echo " label-pending";

                                                elseif ($status == "shortlisted")
                                                    echo " label-shortlisted";

                                                elseif ($status == "selected")
                                                    echo " label-selected";

                                                elseif ($status == "rejected")
                                                    echo " label-rejected";

                                                ?>">

                                                    <?php

                                                    echo ucfirst(
                                                        $app['status']
                                                    );

                                                    ?>

                                                </span>

                                            </td>

                                        </tr>

                                        <?php

                                    }

                                } else {

                                    ?>

                                    <tr>

                                        <td colspan="3"
                                            class="text-center"
                                            style="padding:30px !important;color:#999;">

                                            No applications found.

                                        </td>

                                    </tr>

                                    <?php

                                }

                                ?>

                                </tbody>

                            </table>

                        </div>


                        <a href="application.php"
                           class="btn btn-default btn-sm">

                            View All Applications

                            &nbsp;

                            <i class="fa fa-arrow-right"></i>

                        </a>

                    </div>

                </div>



                <!-- JOBS -->

                <div class="col-md-5">

                    <div class="dashboard-box">

                        <div class="section-title">

                            <h3>

                                <i class="fa fa-briefcase"></i>

                                &nbsp; Recent Jobs

                            </h3>


                            <p>
                                Latest job postings
                            </p>

                        </div>


                        <?php

                        if (
                            $recent_jobs &&
                            mysqli_num_rows($recent_jobs) > 0
                        ) {

                            while (
                                $job =
                                mysqli_fetch_assoc(
                                    $recent_jobs
                                )
                            ) {

                                ?>

                                <div class="job-row">

                                    <div class="job-circle">

                                        <i class="fa fa-briefcase"></i>

                                    </div>


                                    <div>

                                        <div class="job-title">

                                            <?php

                                            echo htmlspecialchars(
                                                $job['job_title']
                                            );

                                            ?>

                                        </div>


                                        <div class="job-company">

                                            <i class="fa fa-building-o"></i>

                                            &nbsp;

                                            <?php

                                            echo htmlspecialchars(
                                                $job['company_name']
                                                ?: "Company"
                                            );

                                            ?>

                                        </div>

                                    </div>


                                    <div style="clear:both;"></div>

                                </div>

                                <?php

                            }

                        } else {

                            ?>

                            <div class="text-center"
                                 style="padding:30px;color:#999;">

                                No jobs available.

                            </div>

                            <?php

                        }

                        ?>


                        <br>


                        <a href="job.php"
                           class="btn btn-default btn-sm">

                            View All Jobs

                            &nbsp;

                            <i class="fa fa-arrow-right"></i>

                        </a>

                    </div>

                </div>

            </div>



            <!-- =================================================
                 PORTAL INFORMATION
            ================================================= -->

            <div class="info-card">

                <h4>

                    <i class="fa fa-lightbulb-o"></i>

                    &nbsp;

                    Job Portal Management

                </h4>


                <p>

                    Manage companies, job postings, candidates,
                    applications, users and recruitment reports
                    from a single centralized dashboard.

                </p>

            </div>


        </div>

    </div>

</div>



<!-- JAVASCRIPT -->

<script src="assets/js/jquery-1.10.2.js"></script>

<script src="assets/js/bootstrap.min.js"></script>

<script src="assets/js/jquery.metisMenu.js"></script>

<script src="assets/js/custom.js"></script>


</body>

</html>