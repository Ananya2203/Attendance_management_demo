<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$conn = new mysqli('localhost', 'root', '', 'college_attendance');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle adding a teacher
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_teacher'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO teachers (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_teachers.php");
    exit();
}

// Handle deleting a teacher
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $teacher_id = $_GET['delete'];

    // Temporarily disable foreign key checks
    $conn->query("SET FOREIGN_KEY_CHECKS = 0");

    $stmt = $conn->prepare("DELETE FROM teachers WHERE teacher_id = ?");
    $stmt->bind_param("i", $teacher_id);
    $stmt->execute();
    $stmt->close();

    // Re-enable foreign key checks
    $conn->query("SET FOREIGN_KEY_CHECKS = 1");

    header("Location: manage_teachers.php");
    exit();
}

// Handle updating a teacher
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_teacher'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE teachers SET name=?, email=?, password=? WHERE teacher_id=?");
        $stmt->bind_param("sssi", $name, $email, $password, $id);
    } else {
        $stmt = $conn->prepare("UPDATE teachers SET name=?, email=? WHERE teacher_id=?");
        $stmt->bind_param("ssi", $name, $email, $id);
    }

    $stmt->execute();
    $stmt->close();
    header("Location: manage_teachers.php");
    exit();
}

$teachers = $conn->query("SELECT * FROM teachers");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Teachers - EduTrackers</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<nav>
    <div class="logo">EduTrackers</div>
    <div class="nav-links">
        <a href="dashboard.php">Dashboard</a>
        <a href="manage_teachers.php" class="active">Manage Teachers</a>
        <a href="logout.php">Logout</a>
    </div>
</nav>

<div class="container">
    <h2>Manage Teachers</h2>

    <!-- Add Teacher Form -->
    <div class="form-container">
        <h3>Add New Teacher</h3>
        <form method="post">
            <input type="text" name="name" placeholder="Teacher Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="add_teacher">Add Teacher</button>
        </form>
    </div>
    
    <!-- Teacher List -->
    <h3>Teacher List</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $count = 1; while ($row = $teachers->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td>********</td>
                    <td>
                        <a href="edit_teacher.php?id=<?php echo urlencode($row['teacher_id']); ?>">Edit</a>
                        <a href="?delete=<?php echo urlencode($row['teacher_id']); ?>" onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>
