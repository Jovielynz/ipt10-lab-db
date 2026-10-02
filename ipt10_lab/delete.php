<?php

require_once 'db_connect.php';

$id = trim($_GET['id'] ?? '');

if ($id === '') {
    die('Invalid student ID');
}

$stmt = $conn->prepare('SELECT first_name, last_name FROM students WHERE id = ?');
$stmt->bind_param('s', $id);
$stmt->execute();

$result = $stmt->get_result();
$student = $result->fetch_assoc();

$stmt->close();

if (!$student) {
    die('Student not found');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $conn->prepare('DELETE FROM students WHERE id = ?');
    $stmt->bind_param('s', $id);
    $stmt->execute();

    if ($stmt->affected_rows === 1) {
        echo '<p>Student deleted successfully!</p>';
        echo '<a href="index.php">Back to Students</a>';
        $stmt->close();
        $conn->close();
        exit;
    }

    echo '<p>Student could not be deleted.</p>';

    $stmt->close();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>  

<h2>Delete Student</h2>

<p>
    Are you sure you want to delete
    <strong>
        <?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?>
    </strong>?
</p>

<form method="POST">
    <button type="submit">Yes, Delete</button>
    <a href="index.php">Cancel</a>
</form>

</body>
</html>

<?php
$conn->close();
?>