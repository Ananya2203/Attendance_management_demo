<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Announcements</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav>
        <a href="dashboard.php">Back to Dashboard</a>
    </nav>
    <h2>Latest Announcements</h2>
    <ul>
        <li>New attendance system update coming soon!</li>
        <li>School holiday on 15th March.</li>
    </ul>
</body>
</html>
