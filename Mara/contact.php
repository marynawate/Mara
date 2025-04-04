<?php
// contact.php
include 'navigation.php'; // Include the navigation bar
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Us</title>
    <style>
        body {
            font-family: sans-serif;
            padding-top: 80px; /* Adjust for navigation bar height */
        }
        .contact-container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .contact-container h1 {
            text-align: center;
        }
        .contact-container p {
            text-align: center;
            margin-bottom: 20px;
        }
        .contact-container form {
            width: 50%;
            margin: 0 auto;
        }
        .contact-container label {
            display: block;
            margin-bottom: 5px;
        }
        .contact-container input[type="text"],
        .contact-container input[type="email"],
        .contact-container textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .contact-container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        .contact-container input[type="submit"]:hover {
            background-color: #3e8e41;
        }
    </style>
</head>
<body>
    <div class="contact-container">
        <h1>Contact Us</h1>
        <p>Please fill out the form below to contact us.</p>

        <form action="contact_process.php" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required><br>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required><br>

            <label for="subject">Subject:</label>
            <input type="text" name="subject" id="subject" required><br>

            <label for="message">Message:</label><br>
            <textarea name="message" id="message" rows="5" required></textarea><br>

            <input type="submit" value="Send Message">
        </form>

        <p>Or you can contact us directly at:</p>
        <p>Email: contact@example.com</p>
        <p>Phone: 123-456-7890</p>
    </div>
</body>
</html>

