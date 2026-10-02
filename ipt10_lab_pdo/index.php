<?php

require_once 'config.php';

$sql = 'SELECT id, first_name, last_name, email, enrolment_date
        FROM students
        ORDER BY enrolment_date DESC, id DESC';

$rows = $pdo->query($sql)->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Records</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>All Student Records</h2>

<a href="create.php">Add New Student</a>

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Enrolled</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($rows as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['enrolment_date']) ?></td>
                <td>
                    <a href="view.php?id=<?= urlencode($row['id']) ?>">View</a>
                    <a href="edit.php?id=<?= urlencode($row['id']) ?>">Edit</a>
                    <a href="delete.php?id=<?= urlencode($row['id']) ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>