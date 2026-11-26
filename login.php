<?php
include("db.php");
session_start();

if (isset($_POST["submit"])) {

    $myusername = $_POST['username'];
    $mypassword = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE phone = '$myusername' AND password = '$mypassword'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);

    if ($count >= 1) {

        while ($row = mysqli_fetch_assoc($result)) {

            $_SESSION['login_user'] = $myusername;
            $_SESSION['login_role'] = $row["role"];

            if ($row["status"] == "yes") {
                header("location:employee.php");
                exit();
            } else {
                echo "<script>alert('You are blocked');</script>";
            }
        }

    } else {
        echo "<script>alert('Your Login Name or Password is invalid');</script>";
    }
}
?>

<!DOCTYPE html>

<html lang="en">

<head>

```
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Login | Employee Management System</title>

<!-- Google Font -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<!-- <style>

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html,
    body {
        width: 100%;
        min-height: 100%;
    }

    body {

        font-family: "Inter", sans-serif;

        min-height: 100vh;

        display: flex;
        justify-content: center;
        align-items: center;

        overflow: hidden;

        background:
            radial-gradient(circle at 10% 20%, rgba(99, 102, 241, 0.35), transparent 30%),
            radial-gradient(circle at 90% 80%, rgba(14, 165, 233, 0.30), transparent 30%),
            linear-gradient(135deg, #0f172a, #172554, #1e1b4b);

        position: relative;
    }


    /* =========================
       BACKGROUND CIRCLES
    ========================= */

    .circle {
        position: absolute;
        border-radius: 50%;
        filter: blur(2px);
        opacity: 0.5;
        animation: float 8s ease-in-out infinite;
    }

    .circle-one {

        width: 300px;
        height: 300px;

        background: linear-gradient(135deg, #6366f1, #8b5cf6);

        top: -120px;
        left: -100px;
    }

    .circle-two {

        width: 250px;
        height: 250px;

        background: linear-gradient(135deg, #06b6d4, #3b82f6);

        right: -80px;
        bottom: -80px;

        animation-delay: 2s;
    }

    .circle-three {

        width: 100px;
        height: 100px;

        background: #a855f7;

        right: 15%;
        top: 10%;

        animation-delay: 4s;
    }


    @keyframes float {

        0%,
        100% {
            transform: translateY(0) scale(1);
        }

        50% {
            transform: translateY(-25px) scale(1.05);
        }
    }


    /* =========================
       MAIN CONTAINER
    ========================= */

    .login-page {

        width: 100%;
        max-width: 1150px;

        padding: 30px;

        position: relative;
        z-index: 5;
    }


    .login-wrapper {

        display: grid;

        grid-template-columns: 1fr 1fr;

        min-height: 650px;

        border-radius: 30px;

        overflow: hidden;

        background: rgba(255, 255, 255, 0.10);

        border: 1px solid rgba(255, 255, 255, 0.20);

        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);

        box-shadow:
            0 30px 80px rgba(0, 0, 0, 0.45),
            inset 0 1px 0 rgba(255, 255, 255, 0.15);

        animation: appear 0.8s ease;
    }


    @keyframes appear {

        from {
            opacity: 0;
            transform: translateY(30px) scale(0.97);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }


    /* =========================
       LEFT SIDE
    ========================= */

    .welcome-section {

        padding: 70px 60px;

        display: flex;
        flex-direction: column;
        justify-content: center;

        color: white;

        background:
            linear-gradient(
                145deg,
                rgba(99, 102, 241, 0.75),
                rgba(30, 64, 175, 0.55)
            );

        position: relative;

        overflow: hidden;
    }


    .welcome-section::before {

        content: "";

        position: absolute;

        width: 350px;
        height: 350px;

        border-radius: 50%;

        border: 1px solid rgba(255, 255, 255, 0.15);

        right: -150px;
        top: -100px;
    }


    .welcome-section::after {

        content: "";

        position: absolute;

        width: 250px;
        height: 250px;

        border-radius: 50%;

        border: 1px solid rgba(255, 255, 255, 0.12);

        left: -130px;
        bottom: -100px;
    }


    .logo {

        width: 70px;
        height: 70px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 20px;

        background: rgba(255, 255, 255, 0.16);

        border: 1px solid rgba(255, 255, 255, 0.25);

        backdrop-filter: blur(10px);

        margin-bottom: 30px;

        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }


    .logo i {

        font-size: 32px;
        color: white;
    }


    .welcome-section h1 {

        font-size: 42px;

        line-height: 1.15;

        font-weight: 800;

        letter-spacing: -1.5px;

        margin-bottom: 20px;
    }


    .welcome-section h1 span {

        display: block;

        color: #c4b5fd;
    }


    .welcome-section p {

        font-size: 15px;

        line-height: 1.8;

        color: rgba(255, 255, 255, 0.75);

        max-width: 430px;

        margin-bottom: 35px;
    }


    .features {

        display: flex;

        flex-direction: column;

        gap: 18px;
    }


    .feature {

        display: flex;

        align-items: center;

        gap: 14px;

        color: rgba(255, 255, 255, 0.85);

        font-size: 14px;
    }


    .feature-icon {

        width: 36px;
        height: 36px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 10px;

        background: rgba(255, 255, 255, 0.12);

        color: #ddd6fe;
    }


    /* =========================
       RIGHT LOGIN SIDE
    ========================= */

    .form-section {

        background: rgba(255, 255, 255, 0.96);

        padding: 70px 60px;

        display: flex;

        align-items: center;
        justify-content: center;
    }


    .form-container {

        width: 100%;
        max-width: 400px;
    }


    .form-header {

        margin-bottom: 35px;
    }


    .form-header h2 {

        font-size: 30px;

        color: #111827;

        font-weight: 800;

        margin-bottom: 10px;

        letter-spacing: -0.8px;
    }


    .form-header p {

        color: #6b7280;

        font-size: 14px;

        line-height: 1.6;
    }


    /* =========================
       INPUTS
    ========================= */

    .input-group {

        margin-bottom: 22px;

        position: relative;
    }


    .input-group label {

        display: block;

        font-size: 13px;

        font-weight: 600;

        color: #374151;

        margin-bottom: 8px;
    }


    .input-wrapper {

        position: relative;
    }


    .input-icon {

        position: absolute;

        left: 17px;
        top: 50%;

        transform: translateY(-50%);

        color: #9ca3af;

        font-size: 16px;

        transition: 0.3s;
    }


    .input-group input {

        width: 100%;

        height: 55px;

        border: 1.5px solid #e5e7eb;

        border-radius: 14px;

        outline: none;

        padding: 0 48px;

        font-family: "Inter", sans-serif;

        font-size: 14px;

        color: #111827;

        background: #f9fafb;

        transition: all 0.3s ease;
    }


    .input-group input:hover {

        border-color: #c7d2fe;
    }


    .input-group input:focus {

        border-color: #6366f1;

        background: white;

        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.10);
    }


    .input-group input:focus + .input-icon {

        color: #6366f1;
    }


    .password-toggle {

        position: absolute;

        right: 17px;

        top: 50%;

        transform: translateY(-50%);

        border: none;

        background: transparent;

        color: #9ca3af;

        cursor: pointer;

        font-size: 16px;

        transition: 0.2s;
    }


    .password-toggle:hover {

        color: #6366f1;
    }


    /* =========================
       REMEMBER ME
    ========================= */

    .form-options {

        display: flex;

        align-items: center;
        justify-content: space-between;

        margin: 5px 0 28px;
    }


    .remember {

        display: flex;

        align-items: center;

        gap: 8px;

        font-size: 13px;

        color: #6b7280;

        cursor: pointer;
    }


    .remember input {

        width: 16px;
        height: 16px;

        accent-color: #6366f1;

        cursor: pointer;
    }


    .forgot {

        font-size: 13px;

        color: #6366f1;

        text-decoration: none;

        font-weight: 600;
    }


    .forgot:hover {

        text-decoration: underline;
    }


    /* =========================
       LOGIN BUTTON
    ========================= */

    .login-btn {

        width: 100%;

        height: 55px;

        border: none;

        border-radius: 14px;

        background:
            linear-gradient(
                135deg,
                #6366f1,
                #4f46e5
            );

        color: white;

        font-family: "Inter", sans-serif;

        font-size: 14px;

        font-weight: 700;

        letter-spacing: 0.3px;

        cursor: pointer;

        display: flex;

        align-items: center;
        justify-content: center;

        gap: 10px;

        box-shadow:
            0 12px 25px rgba(79, 70, 229, 0.25);

        transition: all 0.3s ease;

        position: relative;

        overflow: hidden;
    }


    .login-btn::before {

        content: "";

        position: absolute;

        top: 0;
        left: -100%;

        width: 100%;
        height: 100%;

        background: linear-gradient(
            90deg,
            transparent,
            rgba(255,255,255,0.25),
            transparent
        );

        transition: 0.5s;
    }


    .login-btn:hover {

        transform: translateY(-2px);

        box-shadow:
            0 18px 30px rgba(79, 70, 229, 0.35);
    }


    .login-btn:hover::before {

        left: 100%;
    }


    .login-btn:active {

        transform: translateY(0);
    }


    /* =========================
       SECURITY TEXT
    ========================= */

    .security {

        display: flex;

        align-items: center;
        justify-content: center;

        gap: 7px;

        margin-top: 25px;

        color: #9ca3af;

        font-size: 11px;
    }


    .security i {

        color: #22c55e;
    }


    .footer-text {

        text-align: center;

        margin-top: 30px;

        font-size: 11px;

        color: #9ca3af;
    }


    /* =========================
       RESPONSIVE
    ========================= */

    @media (max-width: 900px) {

        body {
            overflow-y: auto;
            padding: 30px 0;
        }

        .login-page {
            padding: 20px;
        }

        .login-wrapper {

            grid-template-columns: 1fr;

            max-width: 500px;

            margin: auto;
        }

        .welcome-section {

            padding: 45px 40px;

            min-height: 350px;
        }

        .welcome-section h1 {

            font-size: 34px;
        }

        .features {
            display: none;
        }

        .form-section {

            padding: 45px 40px;
        }
    }


    @media (max-width: 500px) {

        .login-page {
            padding: 12px;
        }

        .login-wrapper {
            border-radius: 22px;
        }

        .welcome-section {
            padding: 35px 25px;
        }

        .welcome-section h1 {
            font-size: 29px;
        }

        .welcome-section p {
            font-size: 13px;
        }

        .form-section {
            padding: 35px 25px;
        }

        .form-header h2 {
            font-size: 25px;
        }

        .form-options {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }
    }

</style> -->


<link rel="stylesheet" href="login.css">


</head>

<body>

```
<!-- Decorative Background -->
<div class="circle circle-one"></div>
<div class="circle circle-two"></div>
<div class="circle circle-three"></div>


<div class="login-page">

    <div class="login-wrapper">


        <!-- ================= LEFT SECTION ================= -->

        <div class="welcome-section">

            <div class="logo">
                <i class="fa-solid fa-users"></i>
            </div>


            <h1>
                Employee
                <span>Management</span>
            </h1>


            <p>
                Manage your employees, attendance, salary,
                education and organizational data from one
                secure and centralized platform.
            </p>


            <div class="features">

                <div class="feature">

                    <div class="feature-icon">
                        <i class="fa-solid fa-user-group"></i>
                    </div>

                    <span>
                        Complete Employee Management
                    </span>

                </div>


                <div class="feature">

                    <div class="feature-icon">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>

                    <span>
                        Smart Attendance Tracking
                    </span>

                </div>


                <div class="feature">

                    <div class="feature-icon">
                        <i class="fa-solid fa-money-bill-wave"></i>
                    </div>

                    <span>
                        Salary & Payroll Management
                    </span>

                </div>


                <div class="feature">

                    <div class="feature-icon">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>

                    <span>
                        Secure Admin Access
                    </span>

                </div>

            </div>

        </div>


        <!-- ================= LOGIN SECTION ================= -->

        <div class="form-section">

            <div class="form-container">


                <div class="form-header">

                    <h2>
                        Welcome Back 👋
                    </h2>

                    <p>
                        Sign in to access your employee
                        management dashboard.
                    </p>

                </div>


                <form
                    class="login-form"
                    action=""
                    method="POST"
                    onsubmit="loginLoading()"
                >


                    <!-- Username -->

                    <div class="input-group">

                        <label>
                            Username / Phone
                        </label>

                        <div class="input-wrapper">

                            <input
                                type="text"
                                name="username"
                                placeholder="Enter your phone number"
                                required
                                autocomplete="username"
                            >

                            <i class="fa-solid fa-user input-icon"></i>

                        </div>

                    </div>


                    <!-- Password -->

                    <div class="input-group">

                        <label>
                            Password
                        </label>

                        <div class="input-wrapper">

                            <input
                                type="password"
                                name="password"
                                id="password"
                                placeholder="Enter your password"
                                required
                                autocomplete="current-password"
                            >

                            <i class="fa-solid fa-lock input-icon"></i>

                            <button
                                type="button"
                                class="password-toggle"
                                onclick="togglePassword()"
                            >

                                <i
                                    class="fa-solid fa-eye"
                                    id="eyeIcon"
                                ></i>

                            </button>

                        </div>

                    </div>


                    <!-- Options -->

                    <div class="form-options">

                        <label class="remember">

                            <input
                                type="checkbox"
                                name="remember"
                            >

                            Remember me

                        </label>


                        <a href="#" class="forgot">
                            Forgot Password?
                        </a>

                    </div>


                    <!-- Login Button -->

                    <button
                        type="submit"
                        name="submit"
                        class="login-btn"
                        id="loginButton"
                    >

                        <span id="buttonText">
                            Login to Dashboard
                        </span>

                        <i class="fa-solid fa-arrow-right"></i>

                    </button>


                    <!-- Security -->

                    <div class="security">

                        <i class="fa-solid fa-shield-halved"></i>

                        Your connection is secure

                    </div>


                    <div class="footer-text">

                        © 2026 Employee Management System
                        <br>
                        All rights reserved.

                    </div>


                </form>

            </div>

        </div>

    </div>

</div>


<script>

    /* =========================
       SHOW / HIDE PASSWORD
    ========================= */

    function togglePassword() {

        const password =
            document.getElementById("password");

        const eyeIcon =
            document.getElementById("eyeIcon");


        if (password.type === "password") {

            password.type = "text";

            eyeIcon.classList.remove("fa-eye");

            eyeIcon.classList.add("fa-eye-slash");

        } else {

            password.type = "password";

            eyeIcon.classList.remove("fa-eye-slash");

            eyeIcon.classList.add("fa-eye");

        }
    }


    /* =========================
       LOGIN LOADING
    ========================= */

    function loginLoading() {

        const button =
            document.getElementById("loginButton");

        const text =
            document.getElementById("buttonText");


        button.style.opacity = "0.8";

        button.style.pointerEvents = "none";

        text.innerHTML =
            '<i class="fa-solid fa-spinner fa-spin"></i> Signing in...';
    }

</script>
```

</body>

</html>
