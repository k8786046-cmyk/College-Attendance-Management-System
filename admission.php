<?php
require 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName    = trim($_POST['full_name'] ?? '');
    $guardian    = trim($_POST['guardian_name'] ?? '');
    $phone       = trim($_POST['phone'] ?? '');
    $email       = trim($_POST['email'] ?? '');
    $courseYear  = trim($_POST['course_year'] ?? '');
    $parentPhone = trim($_POST['parent_phone'] ?? '');
    $roomType    = $_POST['room_type'] ?? 'Shared';
    $message     = trim($_POST['message'] ?? '');

    if (!in_array($roomType, ['Single', 'Shared', 'Dormitory'], true)) {
        $roomType = 'Shared';
    }

    if ($fullName !== '' && $phone !== '') {
        $stmt = $pdo->prepare("INSERT INTO hostel_applications
            (full_name, guardian_name, phone, email, course_year, parent_phone, room_type, message)
            VALUES (?,?,?,?,?,?,?,?)");
        $stmt->execute([$fullName, $guardian, $phone, $email, $courseYear, $parentPhone, $roomType, $message]);
        header("Location: home.php?applied=1#apply");
        exit;
    }
}

header("Location: home.php?applied=0#apply");
exit;
