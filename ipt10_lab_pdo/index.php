<?php

require_once 'config.php';

$stmt = $pdo->query('SELECT * FROM students ORDER BY created_at DESC');
$students = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Records - PDO</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Student Records - PDO</h2>

<?php if (isset($_GET['deleted']) && $_GET['deleted'] === '1'): ?>
    <p>Student deleted successfully!</p>
<?php endif; ?>

<p>
    <a href="create.php">Add Student</a>
</p>

<table>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Student Number</th>
        <th>Program</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($students as $student): ?>
        <tr>
            <td>
                <?= htmlspecialchars($student['first_name'] . ' ' . $student['middle_name'] . ' ' . $student['last_name']) ?>
            </td>
            <td><?= htmlspecialchars($student['email']) ?></td>
            <td><?= htmlspecialchars($student['student_number']) ?></td>
            <td><?= htmlspecialchars($student['program']) ?></td>
            <td>
                <a href="view.php?id=<?= urlencode($student['id']) ?>">View</a>
                <a href="edit.php?id=<?= urlencode($student['id']) ?>">Edit</a>
                <a href="delete.php?id=<?= urlencode($student['id']) ?>">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

</body>
</html>