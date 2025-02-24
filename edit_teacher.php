<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'college_attendance');

if (!isset($_GET['teacher_id'])) {
    header("Location: manage_teachers.php");
    exit();
}

$teacher_id = $_GET['teacher_id'];
$stmt = $conn->prepare("SELECT * FROM teachers WHERE teacher_id = ?");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
$teacher = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $updateStmt = $conn->prepare("UPDATE teachers SET name=?, email=?, password=? WHERE teacher_id=?");
        $updateStmt->bind_param("sssi", $name, $email, $password, $teacher_id);
    } else {
        $updateStmt = $conn->prepare("UPDATE teachers SET name=?, email=? WHERE teacher_id=?");
        $updateStmt->bind_param("ssi", $name, $email, $teacher_id);
    }

    $updateStmt->execute();
    $updateStmt->close();
    header("Location: manage_teachers.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Teacher - EduTrackers</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Edit Teacher</h2>
        <form method="post">
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($teacher['name']); ?>" required>
            
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($teacher['email']); ?>" required>
            
            <label>Password:</label>
            <input type="text" name="password" value="<?php echo htmlspecialchars($teacher['password']); ?>">

            <button type="submit">Update Teacher</button>
        </form>
        <br>
        <a href="manage_teachers.php">Back to Teacher List</a>
    </div>
</body>
</html>
