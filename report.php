<?php
// Database Connection
$conn = new mysqli('localhost', 'root', '', 'college_attendance');

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch attendance records
$sql = "SELECT attendance_id, student_id, attendance_date, status FROM attendance ORDER BY attendance_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Report - EduTrackers</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; }
        .container { width: 80%; margin: 20px auto; background: white; padding: 20px; border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; text-align: center; border-bottom: 1px solid #ddd; }
        th { background-color: #6a5acd; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .back-btn { display: inline-block; margin: 10px 0; padding: 8px 16px; background: #6a5acd; color: white; text-decoration: none; border-radius: 4px; }
    </style>
</head>
<body>

    <div class="container">
        <h2>Attendance Report</h2>
        <a href="dashboard.php" class="back-btn">Back to Dashboard</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
    <?php if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['attendance_id']; ?></td> <!-- Corrected -->
                <td><?php echo $row['student_id']; ?></td>
                <td><?php echo $row['attendance_date']; ?></td> <!-- Corrected -->
                <td><?php echo $row['status'] == 1 ? 'Present' : 'Absent'; ?></td>
            </tr>
        <?php }
    } else { ?>
        <tr><td colspan="4">No attendance records found.</td></tr>
    <?php } ?>
</tbody>

        </table>
    </div>

</body>
</html>

<?php
$conn->close();
?>
