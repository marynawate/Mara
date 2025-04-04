<?php
// register_process.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db.php';
    include 'functions.php';

    $memberName = $_POST["memberName"];
    $nationalID = $_POST["nationalID"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $dob = $_POST["dob"];
    $phone = $_POST["phone"];
    $role = $_POST["role"];
    $savings = $_POST["savings"];
    $amount = $_POST["amount"];

    $hashed_password = hash_password($password);

    try {
        $conn->begin_transaction(); // Start a transaction

        $sql_user = "INSERT INTO Users (full_name, national_id, email, password_hash, dob, phone, role, registration_date, initial_deposit) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), ?)";
        $stmt_user = $conn->prepare($sql_user);
        $stmt_user->bind_param("sssssssd", $memberName, $nationalID, $email, $hashed_password, $dob, $phone, $role, $amount);
        $stmt_user->execute();

        $user_id = $conn->insert_id; // Get the user ID

        $sql_account = "INSERT INTO Accounts (user_id, balance, savings_plan) VALUES (?, ?, ?)";
        $stmt_account = $conn->prepare($sql_account);
        $stmt_account->bind_param("ids", $user_id, $amount, $savings);
        $stmt_account->execute();

        $conn->commit(); // Commit the transaction

        // Store email and password in session for immediate login (optional)
        session_start();
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;

        echo "<p style='text-align:center;'>Registration successful! <a href='login.php'>Login here</a></p>";

    } catch (mysqli_sql_exception $exception) {
        $conn->rollback(); // Rollback on error
        echo "Error: " . $exception->getMessage();
    }

    $conn->close();
}
?>
