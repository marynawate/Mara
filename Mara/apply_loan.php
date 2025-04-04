<?php
// apply_loan.php

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
include 'navigation.php'; // Include the navigation bar
include 'db.php';
include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST["amount"];
    $interest_rate = $_POST["interest_rate"];
    $due_date = $_POST["due_date"];

    if (apply_loan($conn, $_SESSION["user_id"], $amount, $interest_rate, $due_date)) {
        echo "<p style='color: green; text-align: center;'>Loan application submitted successfully!</p>";
    } else {
        echo "<p style='color: red; text-align: center;'>Failed to submit loan application.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Apply for Loan</title>
    <style>
        body {
            font-family: sans-serif;
            padding-top: 80px; /* Adjust for navigation bar height */
        }
        .loan-form-container {
            width: 300px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .loan-form-container h1 {
            text-align: center;
        }
        .loan-form-container label {
            display: block;
            margin-bottom: 5px;
        }
        .loan-form-container input[type="number"],
        .loan-form-container input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .loan-form-container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        .loan-form-container input[type="submit"]:hover {
            background-color: #3e8e41;
        }
    </style>
</head>
<body>
    <div class="loan-form-container">
        <h1>Apply for Loan</h1>
        <form action="apply_loan.php" method="post">
            <label for="amount">Amount:</label>
            <input type="number" name="amount" id="amount" min="0" step="0.01" required><br>

            <label for="interest_rate">Interest Rate:</label>
            <input type="number" name="interest_rate" id="interest_rate" min="0" step="0.01" required><br>

            <label for="due_date">Due Date:</label>
            <input type="date" name="due_date" id="due_date" required><br>

            <input type="submit" value="Apply">
        </form>
    </div>
</body>
</html>