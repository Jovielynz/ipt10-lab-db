<?php

require_once 'db_connect.php';

$sql = 'SELECT id, first_name, last_name, email, enrolment_date
        FROM students
        ORDER BY enrolment_date DESC, id DESC';

$result = mysqli_query($conn, $sql);

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
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['enrolment_date']) ?></td>
                <td>
                    <a href="view.php?id=<?= urlencode($row['id']) ?>">View</a>
                    <a href="edit.php?id=<?= urlencode($row['id']) ?>">Edit</a>
                    <a href="delete.php?id=<?= urlencode($row['id']) ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php

mysqli_free_result($result);
$conn->close();

?>

</body>
</html>