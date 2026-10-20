<?php
session_start();
require 'config/db.php';

if (isset($_SESSION['student_id'])) {
    header("Location: student/dashboard.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roll_no = trim($_POST['roll_no']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM students WHERE roll_no = ?");
    $stmt->execute([$roll_no]);
    $student = $stmt->fetch();

    if ($student && $student['password'] && password_verify($password, $student['password'])) {
        $_SESSION['student_id']   = $student['id'];
        $_SESSION['student_name'] = $student['name'];
        $_SESSION['student_roll'] = $student['roll_no'];
        header("Location: student/dashboard.php");
        exit;
    } else {
        $error = "Invalid roll number or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Login - Hostel Management System</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link href="assets/img/favicon.svg" rel="icon" type="image/svg+xml">
<link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="login-wrapper">

  <div class="login-brand-panel">
    <svg class="crest-large" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
      <path d="M16 2 L28 7 V16 C28 23 22.5 27.5 16 30 C9.5 27.5 4 23 4 16 V7 Z" fill-opacity="0.15"/>
      <path d="M16 2 L28 7 V16 C28 23 22.5 27.5 16 30 C9.5 27.5 4 23 4 16 V7 Z" fill="none" stroke="#C9A227" stroke-width="1.2"/>
      <path d="M11 19 V13 L16 10 L21 13 V19 H17.5 V15.5 H14.5 V19 Z"/>
    </svg>
    <h1>Hostel Management System</h1>
    <div class="brand-rule"></div>
    <p>Check your room, fee status, attendance record, and complaint updates — all in one place.</p>
  </div>

  <div class="login-form-panel">
    <div class="login-form-inner">
      <h4>Student sign in</h4>
      <p class="lead-note">Use your roll number and the password given by your hostel admin.</p>

      <?php if ($error): ?>
        <div class="alert alert-danger py-2"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Roll Number</label>
          <input type="text" name="roll_no" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Sign in</button>
      </form>

      <p class="text-center small mt-4 mb-0"><a href="login.php">Admin login</a> &middot; <a href="home.php">Back to home</a></p>
    </div>
  </div>

</div>
</body>
</html>
