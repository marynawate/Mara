<?php
// profile.php

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php?redirect=profile.php"); // Redirect with redirect URL
    exit();
}
include 'db.php';
include 'functions.php';
include 'navigation.php';

$user_id = $_SESSION["user_id"];

// Retrieve user details
$sql_user = "SELECT full_name, email, national_id, dob, phone, initial_deposit, profile_image FROM Users WHERE user_id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user_details = $result_user->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $national_id = $_POST["national_id"];
    $dob = $_POST["dob"];
    $phone = $_POST["phone"];

    $sql_update = "UPDATE Users SET full_name = ?, email = ?, national_id = ?, dob = ?, phone = ? WHERE user_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssssi", $full_name, $email, $national_id, $dob, $phone, $user_id);

    if ($stmt_update->execute()) {
        $uploadDir = "uploads/"; // Directory to store images
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create directory if it doesn't exist
        }

        if (isset($_FILES["profile_image"]) && $_FILES["profile_image"]["error"] == 0) {
            $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
            $filename = $_FILES["profile_image"]["name"];
            $filetype = $_FILES["profile_image"]["type"];
            $filesize = $_FILES["profile_image"]["size"];

            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (!array_key_exists($ext, $allowed)) {
                $imageError = "Error: Please select a valid file format.";
            }

            $maxsize = 5 * 1024 * 1024; // 5MB
            if ($filesize > $maxsize) {
                $imageError = "Error: File size is larger than the allowed limit.";
            }

            if (in_array($filetype, $allowed)) {
                $newFilename = uniqid() . "." . $ext;
                $targetFile = $uploadDir . $newFilename;

                if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFile)) {
                    $sql_image = "UPDATE Users SET profile_image = ? WHERE user_id = ?";
                    $stmt_image = $conn->prepare($sql_image);
                    $stmt_image->bind_param("si", $newFilename, $user_id);
                    $stmt_image->execute();
                    $user_details['profile_image'] = $newFilename; // Update user_details for display
                } else {
                    $imageError = "Error: There was a problem uploading your file.";
                }
            } else {
                $imageError = "Error: There was a problem uploading your file.";
            }
        }
        $success = "Profile updated successfully!";
    } else {
        $error = "Failed to update profile.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <style>
        body { font-family: sans-serif; padding-top: 80px; }
        .profile-container { width: 80%; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .profile-container h1 { text-align: center; }
        .profile-container p { margin-bottom: 10px; }
        .profile-container img { max-width: 200px; max-height: 200px; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <div class="profile-container">
        <h1>Profile</h1>
        <?php if (isset($error)): ?> <p class="error"><?php echo $error; ?></p> <?php endif; ?>
        <?php if (isset($success)): ?> <p class="success"><?php echo $success; ?></p> <?php endif; ?>
        <form action="profile.php" method="post" enctype="multipart/form-data">
            <label for="full_name">Full Name:</label>
            <input type="text" name="full_name" id="full_name" value="<?php echo $user_details['full_name']; ?>" required><br>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo $user_details['email']; ?>" required><br>

            <label for="national_id">National ID:</label>
            <input type="text" name="national_id" id="national_id" value="<?php echo $user_details['national_id']; ?>" required><br>

            <label for="dob">Date of Birth:</label>
            <input type="date" name="dob" id="dob" value="<?php echo $user_details['dob']; ?>" required><br>

            <label for="phone">Phone Number:</label>
            <input type="text" name="phone" id="phone" value="<?php echo $user_details['phone']; ?>" required><br>

            <label for="profile_image">Profile Image:</label>
            <input type="file" name="profile_image" id="profile_image"><br>

            <?php if ($user_details['profile_image']): ?>
                <img src="uploads/<?php echo $user_details['profile_image']; ?>" alt="Profile Image">
            <?php endif; ?>

            <input type="submit" value="Update Profile">
        </form>
    </div>
</body>
</html>
<?php
// Close the database connection    
$conn->close();
?>
