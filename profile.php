<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'college_attendance');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get logged-in user details (Assuming user_id is stored in session)
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Check if password is being updated
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $updateQuery = "UPDATE users SET name=?, email=?, password=? WHERE user_id=?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("sssi", $name, $email, $password, $user_id);
    } else {
        $updateQuery = "UPDATE users SET name=?, email=? WHERE user_id=?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ssi", $name, $email, $user_id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully!'); window.location='profile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .container { width: 50%; margin: 50px auto; background: white; padding: 20px; border-radius: 8px; }
        label { font-weight: bold; display: block; margin: 10px 0 5px; }
        input { width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 5px; }
        button { background: #6a5acd; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #5a4abc; }
    </style>
</head>
<body>

    <div class="container">
        <h2>User Profile</h2>
        <form method="POST">
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo $user['name']; ?>" required>
            
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
            
            <label>New Password (Leave blank to keep current password):</label>
            <input type="password" name="password">

            <button type="submit">Update Profile</button>
        </form>
        <br>
        <a href="dashboard.php" style="color: #6a5acd; text-decoration: none;">Back to Dashboard</a>
    </div>

</body>
</html>
