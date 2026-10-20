<?php
session_start();
require 'config/db.php';

if (isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id']   = $admin['id'];
        $_SESSION['admin_name'] = $admin['username'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login - Hostel Management System</title>
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
    <p>The administration desk for rooms, fees, attendance, complaints and visitor records across the hostel.</p>
  </div>

  <div class="login-form-panel">
    <div class="login-form-inner">
      <h4>Admin sign in</h4>
      <p class="lead-note">Enter your admin credentials to continue.</p>

      <?php if ($error): ?>
        <div class="alert alert-danger py-2"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Sign in</button>
      </form>

      <p class="text-center text-muted small mt-4 mb-0">Default: admin / admin123</p>
      <p class="text-center small mt-2 mb-0"><a href="student_login.php">Student login</a> &middot; <a href="home.php">Back to home</a></p>
    </div>
  </div>

</div>
</body>
</html>
