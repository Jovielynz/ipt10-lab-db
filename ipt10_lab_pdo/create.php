<?php

require_once 'config.php';

$errors = [];

$first_name = '';
$middle_name = '';
$last_name = '';
$birthday = '';
$sex = '';
$email = '';
$student_number = '';
$program = '';
$enrolment_date = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $first_name = trim($_POST['first_name'] ?? '');
    $middle_name = trim($_POST['middle_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $birthday = trim($_POST['birthday'] ?? '');
    $sex = trim($_POST['sex'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $student_number = trim($_POST['student_number'] ?? '');
    $program = trim($_POST['program'] ?? '');
    $enrolment_date = trim($_POST['enrolment_date'] ?? '');

    if (
        empty($first_name) ||
        strlen($first_name) < 2 ||
        strlen($first_name) > 100 ||
        !preg_match('/^[A-Za-z\s]+$/', $first_name)
    ) {
        $errors['first_name'] = 'First name is required and must contain only letters and spaces.';
    }

    if (
        empty($last_name) ||
        strlen($last_name) < 2 ||
        strlen($last_name) > 100 ||
        !preg_match('/^[A-Za-z\s]+$/', $last_name)
    ) {
        $errors['last_name'] = 'Last name is required and must contain only letters and spaces.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address.';
    }

    if (
        empty($birthday) ||
        !preg_match('/^\d{4}-\d{2}-\d{2}$/', $birthday)
    ) {
        $errors['birthday'] = 'Birthday must use YYYY-MM-DD format.';
    }

    if (!in_array($sex, ['Male', 'Female'], true)) {
        $errors['sex'] = 'Please select Male or Female.';
    }

    if ($student_number !== '') {
        if (
            strlen($student_number) > 50 ||
            !preg_match('/^[A-Za-z0-9]+$/', $student_number)
        ) {
            $errors['student_number'] = 'Student number must be alphanumeric and maximum 50 characters.';
        }
    }

    if (strlen($program) > 200) {
        $errors['program'] = 'Program must not exceed 200 characters.';
    }

    if (
        empty($enrolment_date) ||
        !preg_match('/^\d{4}-\d{2}-\d{2}$/', $enrolment_date)
    ) {
        $errors['enrolment_date'] = 'Enrolment date must use YYYY-MM-DD format.';
    }

    if (empty($errors)) {

        $sql = 'INSERT INTO students
                (id, first_name, middle_name, last_name, birthday, sex, email, student_number, program, enrolment_date)
                VALUES (UUID(), ?, ?, ?, ?, ?, ?, ?, ?, ?)';

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $first_name,
            $middle_name,
            $last_name,
            $birthday,
            $sex,
            $email,
            $student_number,
            $program,
            $enrolment_date
        ]);

        if ($stmt->rowCount() === 1) {
            echo '<p>Student created successfully!</p>';
        }

        $first_name = '';
        $middle_name = '';
        $last_name = '';
        $birthday = '';
        $sex = '';
        $email = '';
        $student_number = '';
        $program = '';
        $enrolment_date = '';
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Add New Student</h2>

<form method="POST">

    <label>First Name:</label><br>
    <input type="text" name="first_name" value="<?= htmlspecialchars($first_name) ?>">
    <?php if (isset($errors['first_name'])): ?>
        <p style="color:red;"><?= htmlspecialchars($errors['first_name']) ?></p>
    <?php endif; ?>

    <br>

    <label>Middle Name:</label><br>
    <input type="text" name="middle_name" value="<?= htmlspecialchars($middle_name) ?>">

    <br><br>

    <label>Last Name:</label><br>
    <input type="text" name="last_name" value="<?= htmlspecialchars($last_name) ?>">
    <?php if (isset($errors['last_name'])): ?>
        <p style="color:red;"><?= htmlspecialchars($errors['last_name']) ?></p>
    <?php endif; ?>

    <br>

    <label>Birthday:</label><br>
    <input type="date" name="birthday" value="<?= htmlspecialchars($birthday) ?>">
    <?php if (isset($errors['birthday'])): ?>
        <p style="color:red;"><?= htmlspecialchars($errors['birthday']) ?></p>
    <?php endif; ?>

    <br>

    <label>Sex:</label><br>
    <select name="sex">
        <option value="">Select Sex</option>
        <option value="Male" <?= $sex === 'Male' ? 'selected' : '' ?>>Male</option>
        <option value="Female" <?= $sex === 'Female' ? 'selected' : '' ?>>Female</option>
    </select>

    <?php if (isset($errors['sex'])): ?>
        <p style="color:red;"><?= htmlspecialchars($errors['sex']) ?></p>
    <?php endif; ?>

    <br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= htmlspecialchars($email) ?>">
    <?php if (isset($errors['email'])): ?>
        <p style="color:red;"><?= htmlspecialchars($errors['email']) ?></p>
    <?php endif; ?>

    <br>

    <label>Student Number:</label><br>
    <input type="text" name="student_number" value="<?= htmlspecialchars($student_number) ?>">
    <?php if (isset($errors['student_number'])): ?>
        <p style="color:red;"><?= htmlspecialchars($errors['student_number']) ?></p>
    <?php endif; ?>

    <br>

    <label>Program:</label><br>
    <input type="text" name="program" value="<?= htmlspecialchars($program) ?>">
    <?php if (isset($errors['program'])): ?>
        <p style="color:red;"><?= htmlspecialchars($errors['program']) ?></p>
    <?php endif; ?>

    <br>

    <label>Enrolment Date:</label><br>
    <input type="date" name="enrolment_date" value="<?= htmlspecialchars($enrolment_date) ?>">
    <?php if (isset($errors['enrolment_date'])): ?>
        <p style="color:red;"><?= htmlspecialchars($errors['enrolment_date']) ?></p>
    <?php endif; ?>

    <br><br>

    <button type="submit">Create Student</button>

</form>

<br>

<a href="index.php">Back to Students</a>

</body>
</html>