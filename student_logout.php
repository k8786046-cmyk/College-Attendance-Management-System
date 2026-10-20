<?php
session_start();
unset($_SESSION['student_id'], $_SESSION['student_name'], $_SESSION['student_roll']);
session_destroy();
header("Location: student_login.php");
exit;
