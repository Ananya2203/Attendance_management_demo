<?php
$conn = new mysqli('localhost', 'root', '', 'college_attendance');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $class_id = $_POST['class_id'];
    $conn->query("INSERT INTO students (name, email, class_id) VALUES ('$name', '$email', '$class_id')");
}

$students = $conn->query("SELECT students.student_id, students.name, students.email, classes.class_name 
                          FROM students 
                          JOIN classes ON students.class_id = classes.class_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Students - EduTrackers</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</head>
<body>

    <nav>
        <div class="logo">EduTrackers</div>
        <div class="nav-links">
            <a href="dashboard.php">Dashboard</a>
            <a href="manage_students.php" class="active">Manage Students</a>
            <a href="logout.php">Logout</a>
        </div>
    </nav>

    <div class="container">
        <h2><i class="fas fa-user-graduate"></i> Manage Students</h2>

        <div class="form-container">
            <h3>Add New Student</h3>
            <form method="post">
                <input type="text" name="name" placeholder="Student Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="number" name="class_id" placeholder="Class ID" required>
                <button type="submit"><i class="fas fa-plus"></i> Add Student</button>
            </form>
        </div>

        <h3>Student List</h3>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Class</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $students->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['student_id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['class_name']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>
</html>
