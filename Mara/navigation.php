<?php
// navigation.php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
$userRole = isset($_SESSION['role']) ? $_SESSION['role'] : null; // Get user role, or null if not set
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image:url('Images/background.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        nav {
            background-color: #333;
            overflow: hidden;
            position: fixed;
            top: 0px;
             height: 100px;
            width: 100%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            padding: 0 30px;
            width: 100%;
            z-index: 100; /* Ensure it's on top */
        }

        nav a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        nav a:hover {
            background-color: #ddd;
            color: black;
        }

        .nav-right {
            float: right;
        }

        .nav-admin {
            display: <?php echo ($isLoggedIn && $userRole === 'admin') ? 'block' : 'none'; ?>;
        }

        .nav-user {
            display: <?php echo ($isLoggedIn && $userRole !== 'admin') ? 'block' : 'none'; ?>;
        }
    </style>
</head>
<body>
    <nav>
        <a href="home.php">Home</a>

        <a href="about.php">About</a>
        <a href="services.php">Services</a>
        <a href="contact.php">Contact</a>

            <div class="nav-admin">
                <a href="admin.php">Admin Dashboard</a>
                <a href="manage_users.php">Manage Users</a>
            </div>

            <div class="nav-right">
                <a href="logout.php">Logout</a>
            </div>

        
            <div class="nav-right">
                <a href="profile.php">Profile</a>
                <a href="services.php">Services</a>
                <a href="loans.php">Loans</a>
                <a href="savings.php">Savings</a>
            </div>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
                <a href="contact.php">Contact</a>
            </div>

    
    </nav>
</body>
</html>