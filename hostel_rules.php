<?php
require 'config/db.php';
$rules = $pdo->query("SELECT * FROM rules ORDER BY sort_order, id")->fetchAll();
$feeItems = $pdo->query("SELECT * FROM fee_structure ORDER BY sort_order, id")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hostel Rules &amp; Fee Structure</title>
<link href="assets/img/favicon.svg" rel="icon" type="image/svg+xml">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
<style>
  @media print { .no-print { display: none !important; } body { background: #fff !important; } }
  .slip-wrap { max-width: 760px; margin: 0 auto; }
</style>
</head>
<body class="home-body">

<nav class="navbar navbar-dark hms-navbar px-3 no-print">
  <span class="brand-mark">
    <svg class="brand-crest" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
      <path d="M16 2 L28 7 V16 C28 23 22.5 27.5 16 30 C9.5 27.5 4 23 4 16 V7 Z" fill-opacity="0.15"/>
      <path d="M16 2 L28 7 V16 C28 23 22.5 27.5 16 30 C9.5 27.5 4 23 4 16 V7 Z" fill="none" stroke="#C9A227" stroke-width="1.6"/>
      <path d="M11 19 V13 L16 10 L21 13 V19 H17.5 V15.5 H14.5 V19 Z" fill="#C9A227"/>
    </svg>
    Hostel Management System
  </span>
  <div class="d-flex gap-2">
    <button class="btn btn-sm btn-brass" onclick="window.print()"><i class="fa-solid fa-print"></i> Print</button>
    <a href="home.php" class="btn btn-sm btn-outline-light">Home</a>
  </div>
</nav>

<div class="slip-wrap p-4">
  <div class="text-center mb-4">
    <h2 class="mb-0">Hostel Rules &amp; Fee Structure</h2>
    <p class="text-muted">Please read the rules below and note the current fee structure.</p>
  </div>

  <div class="card p-4 mb-4">
    <div class="panel-title">Hostel Rules</div>
    <?php if (!$rules): ?>
      <p class="text-muted mb-0">No rules have been added yet.</p>
    <?php else: ?>
      <ol class="mb-0">
        <?php foreach ($rules as $r): ?>
          <li class="mb-2">
            <strong><?= htmlspecialchars($r['title']) ?></strong><br>
            <span class="text-muted"><?= nl2br(htmlspecialchars($r['description'])) ?></span>
          </li>
        <?php endforeach; ?>
      </ol>
    <?php endif; ?>
  </div>

  <div class="card p-4 mb-4">
    <div class="panel-title">Fee Structure</div>
    <?php if (!$feeItems): ?>
      <p class="text-muted mb-0">No fee structure items have been added yet.</p>
    <?php else: ?>
      <table class="table mb-0">
        <thead><tr><th>Category</th><th>Amount</th><th>Period</th></tr></thead>
        <tbody>
          <?php $total = 0; foreach ($feeItems as $f): $total += $f['period']==='Monthly' ? $f['amount'] : 0; ?>
            <tr>
              <td><?= htmlspecialchars($f['category']) ?></td>
              <td>₹<?= number_format($f['amount'],2) ?></td>
              <td><?= htmlspecialchars($f['period']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr><th>Total (Monthly recurring)</th><th>₹<?= number_format($total,2) ?></th><th></th></tr>
        </tfoot>
      </table>
    <?php endif; ?>
  </div>

  <p class="text-muted small text-center no-print">This page can be shown or printed for visitors and parents at the gate.</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
