<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'college_attendance');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    $role = $_POST['role'];

    $table = ($role == 'Admin') ? 'admins' : (($role == 'Teacher') ? 'teachers' : 'students');

    $sql = "SELECT * FROM $table WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['user'] = $username;
        $_SESSION['role'] = $role;
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('Invalid username or password!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>EduTrackers - Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav>
        <div class="logo">EduTrackers</div>
    </nav>

    <div class="login-container">
        <form method="post">
            <h2>EduTrackers Login</h2>
            <label>Login As:</label>
            <select name="role">
                <option value="Admin">Admin</option>
                <option value="Teacher">Teacher</option>
                <option value="Student">Student</option>
            </select>
            <label>Username:</label>
            <input type="text" name="username" required>
            <label>Password:</label>
            <input type="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
