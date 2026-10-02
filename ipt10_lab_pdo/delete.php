<?php

require_once 'config.php';

$id = trim($_GET['id'] ?? '');

if ($id === '') {
    die('Invalid student ID');
}

$stmt = $pdo->prepare('SELECT first_name, last_name FROM students WHERE id = ?');
$stmt->execute([$id]);

$student = $stmt->fetch();

if (!$student) {
    die('Student not found');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $pdo->prepare('DELETE FROM students WHERE id = ?');
    $stmt->execute([$id]);

    if ($stmt->rowCount() === 1) {
        echo '<p>Student deleted successfully!</p>';
        echo '<a href="index.php">Back to Students</a>';
        exit;
    }

    echo '<p>Student could not be deleted.</p>';
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