<?php
// login_process.php
session_start(); // Start the session


if ($_SERVER["REQUEST_METHOD"] == "POST" || (isset($_SESSION['email']) && isset($_SESSION['password']))) { // Check for session data

    include 'db.php';
    include 'functions.php';
include 'navigation.php'; // Include the navigation bar

    if (isset($_SESSION['email']) && isset($_SESSION['password'])){
        $username = $_SESSION['email'];
        $password = $_SESSION['password'];
        unset($_SESSION['email']);
        unset($_SESSION['password']);
    } else {
        $username = $_POST["username"];
        $password = $_POST["password"];
    }

    $sql = "SELECT user_id, password_hash, role FROM Users WHERE email = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username); // $username is email
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (verify_password($password, $row["password_hash"])) {
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["role"] = $row["role"];
            header("Location: services.php"); // Redirect to profile
            exit();
        } else {
            echo "<p style='color: green;font: size 20px; text-align: center;'>Log in Successful.</p>";
        
        }
    } else {
        echo "<p style='color: red; text-align: center;'>User not found.</p>";
    }

    $stmt->close();

    $conn->close();
}
?>
