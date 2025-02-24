<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user_role = $_SESSION['role'];
$user_name = $_SESSION['user']; 

// Dynamic Greeting Based on Time
date_default_timezone_set("Asia/Kolkata"); 
$hour = date("H");
if ($hour < 12) {
    $greeting = "Good Morning";
} elseif ($hour < 18) {
    $greeting = "Good Afternoon";
} else {
    $greeting = "Good Evening";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduTrackers - Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <style>
        /* General Styles */
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; margin: 0; padding: 0; }
        nav { display: flex; justify-content: space-between; align-items: center; background: #6a5acd; padding: 15px; color: white; }
        .logo { font-size: 22px; font-weight: bold; }
        .nav-links a { color: white; text-decoration: none; margin: 0 15px; font-weight: bold; }
        .dashboard-container { width: 85%; margin: 30px auto; background: white; padding: 20px; border-radius: 8px; }
        h2 { color: #6a5acd; }
        .cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-top: 20px; }
        .card { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1); text-align: center; transition: 0.3s; }
        .card:hover { transform: translateY(-5px); box-shadow: 2px 2px 15px rgba(0, 0, 0, 0.2); }
        .card i { font-size: 40px; color: #6a5acd; }
        .card h3 { margin: 10px 0; }
        .card a { text-decoration: none; background: #6a5acd; color: white; padding: 8px 15px; border-radius: 5px; display: inline-block; margin-top: 10px; }
        .footer { text-align: center; margin-top: 30px; padding: 20px; background: #6a5acd; color: white; }
        .footer a { color: yellow; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

    <nav>
        <div class="logo">EduTrackers</div>
        <div class="nav-links">
            <a href="dashboard.php">Dashboard</a>
            <?php if ($user_role == 'Admin') { ?>
                <a href="manage_teachers.php">Manage Teachers</a>
                <a href="site_settings.php">Settings</a>
            <?php } ?>
            <?php if ($user_role == 'Teacher') { ?>
                <a href="manage_students.php">Manage Students</a>
                <a href="attendance.php">Mark Attendance</a>
            <?php } ?>
            <a href="logout.php">Logout</a>
        </div>
    </nav>

    <div class="dashboard-container">
        <h2><?php echo $greeting . ", " . ucfirst($user_name); ?> 👋</h2>
        <p>Welcome to your EduTrackers dashboard. Manage your attendance and other features efficiently.</p>

        <div class="cards">
            <?php if ($user_role == 'Admin') { ?>
                <div class="card">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <h3>Manage Teachers</h3>
                    <p>Add, edit, and remove teachers</p>
                    <a href="manage_teachers.php">Go</a>
                </div>
                <div class="card">
                    <i class="fas fa-cogs"></i>
                    <h3>Site Settings</h3>
                    <p>Configure system settings</p>
                    <a href="site_settings.php">Go</a>
                </div>
            <?php } ?>

            <?php if ($user_role == 'Teacher') { ?>
                <div class="card">
                    <i class="fas fa-user-graduate"></i>
                    <h3>Manage Students</h3>
                    <p>Add, edit, and track student records</p>
                    <a href="manage_students.php">Go</a>
                </div>
                <div class="card">
                    <i class="fas fa-clipboard-list"></i>
                    <h3>Mark Attendance</h3>
                    <p>Take attendance for your class</p>
                    <a href="attendance.php">Go</a>
                </div>
            <?php } ?>

            <div class="card">
                <i class="fas fa-chart-line"></i>
                <h3>Attendance Report</h3>
                <p>View attendance trends & statistics</p>
                <a href="report.php">Go</a>
            </div>

            <div class="card">
                <i class="fas fa-bullhorn"></i>
                <h3>Announcements</h3>
                <p>View the latest updates</p>
                <a href="announcements.php">Go</a>
            </div>

            <div class="card">
                <i class="fas fa-user"></i>
                <h3>My Profile</h3>
                <p>Update your details</p>
                <a href="profile.php">Go</a>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; <?php echo date("Y"); ?> EduTrackers. All rights reserved.</p>
        <p>For support, <a href="contact.php">Contact Us</a></p>
    </div>

</body>
</html>
