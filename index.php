<?php
require 'includes/auth.php';
require 'config/db.php';
$base = '';
$page_title = 'Dashboard';

$totalStudents  = $pdo->query("SELECT COUNT(*) c FROM students")->fetch()['c'];
$totalRooms     = $pdo->query("SELECT COUNT(*) c FROM rooms")->fetch()['c'];
$vacantSeats    = $pdo->query("SELECT COALESCE(SUM(capacity-occupied),0) c FROM rooms")->fetch()['c'];
$occupiedSeats  = $pdo->query("SELECT COALESCE(SUM(occupied),0) c FROM rooms")->fetch()['c'];
$pendingFees    = $pdo->query("SELECT COUNT(*) c FROM fees WHERE status='Pending'")->fetch()['c'];
$paidFees       = $pdo->query("SELECT COUNT(*) c FROM fees WHERE status='Paid'")->fetch()['c'];
$openComplaints = $pdo->query("SELECT COUNT(*) c FROM complaints WHERE status != 'Resolved'")->fetch()['c'];
$todayVisitors  = $pdo->prepare("SELECT COUNT(*) c FROM visitors WHERE visit_date = CURDATE()");
$todayVisitors->execute();
$todayVisitors  = $todayVisitors->fetch()['c'];

// Last 7 days attendance trend (present count per day)
$attendTrend = [];
for ($i = 6; $i >= 0; $i--) {
    $d = date('Y-m-d', strtotime("-$i days"));
    $stmt = $pdo->prepare("SELECT COUNT(*) c FROM attendance WHERE att_date = ? AND status = 'Present'");
    $stmt->execute([$d]);
    $attendTrend[] = ['date' => date('D', strtotime($d)), 'count' => (int)$stmt->fetch()['c']];
}

include 'includes/header.php';
?>

<h3 class="page-title">Dashboard</h3>

<div class="stat-strip">
  <div class="stat-block">
    <i class="fa-solid fa-user-graduate stat-icon"></i>
    <div class="stat-num"><?= $totalStudents ?></div>
    <div class="stat-label">Students</div>
  </div>
  <div class="stat-block">
    <i class="fa-solid fa-door-open stat-icon"></i>
    <div class="stat-num"><?= $totalRooms ?></div>
    <div class="stat-label">Rooms</div>
  </div>
  <div class="stat-block">
    <i class="fa-solid fa-bed stat-icon"></i>
    <div class="stat-num"><?= $vacantSeats ?></div>
    <div class="stat-label">Vacant Seats</div>
  </div>
  <div class="stat-block <?= $pendingFees > 0 ? 'flag' : '' ?>">
    <i class="fa-solid fa-money-bill stat-icon"></i>
    <div class="stat-num"><?= $pendingFees ?></div>
    <div class="stat-label">Pending Fees</div>
  </div>
  <div class="stat-block <?= $openComplaints > 0 ? 'flag' : '' ?>">
    <i class="fa-solid fa-triangle-exclamation stat-icon"></i>
    <div class="stat-num"><?= $openComplaints ?></div>
    <div class="stat-label">Open Complaints</div>
  </div>
  <div class="stat-block">
    <i class="fa-solid fa-address-book stat-icon"></i>
    <div class="stat-num"><?= $todayVisitors ?></div>
    <div class="stat-label">Visitors Today</div>
  </div>
</div>

<div class="row g-3 mb-3">
  <div class="col-lg-7">
    <div class="card p-4 h-100">
      <div class="panel-title">Attendance, last 7 days</div>
      <div class="chart-box"><canvas id="attendanceChart"></canvas></div>
    </div>
  </div>
  <div class="col-lg-5">
    <div class="card p-4 h-100">
      <div class="panel-title">Room occupancy</div>
      <div class="chart-box chart-box-sm"><canvas id="occupancyChart"></canvas></div>
      <hr class="my-3" style="border-color: var(--line-soft);">
      <div class="d-flex justify-content-between small text-muted mb-1">
        <span>Fee status</span>
        <span><?= $paidFees ?> paid &middot; <?= $pendingFees ?> pending</span>
      </div>
      <?php $feeTotal = $paidFees + $pendingFees; $paidPct = $feeTotal > 0 ? round($paidFees / $feeTotal * 100) : 0; ?>
      <div class="fee-bar">
        <div class="fee-bar-paid" style="width: <?= $paidPct ?>%;"></div>
      </div>
    </div>
  </div>
</div>

<div class="card p-4 quick-actions">
  <div class="panel-title">Quick actions</div>
  <div class="d-flex flex-wrap gap-2">
    <a href="students/list.php?new=1" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-plus"></i> Add student</a>
    <a href="rooms/list.php?new=1" class="btn btn-outline-success btn-sm"><i class="fa-solid fa-plus"></i> Add room</a>
    <a href="fees/list.php?new=1" class="btn btn-outline-warning btn-sm"><i class="fa-solid fa-plus"></i> Record fee</a>
    <a href="complaints/list.php?new=1" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-plus"></i> File complaint</a>
    <a href="attendance/mark.php" class="btn btn-outline-info btn-sm"><i class="fa-solid fa-calendar-check"></i> Mark attendance</a>
    <a href="visitors/list.php?new=1" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-plus"></i> Log visitor</a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
const attendLabels = <?= json_encode(array_column($attendTrend, 'date')) ?>;
const attendData   = <?= json_encode(array_column($attendTrend, 'count')) ?>;

if (typeof Chart === 'undefined') {
  document.getElementById('attendanceChart').closest('.chart-box').innerHTML =
    '<p class="text-muted small mb-0">Charts need an internet connection to load (Chart.js from CDN). Data is fine — refresh once you\'re online.</p>';
} else {
  new Chart(document.getElementById('attendanceChart'), {
    type: 'bar',
    data: {
      labels: attendLabels,
      datasets: [{
        label: 'Present',
        data: attendData,
        backgroundColor: '#C9A227',
        borderRadius: 3,
        maxBarThickness: 34
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: {
        y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#E2E5EE' } },
        x: { grid: { display: false } }
      }
    }
  });

  new Chart(document.getElementById('occupancyChart'), {
    type: 'doughnut',
    data: {
      labels: ['Occupied seats', 'Vacant seats'],
      datasets: [{
        data: [<?= $occupiedSeats ?>, <?= $vacantSeats ?>],
        backgroundColor: ['#14213D', '#C9A227'],
        borderWidth: 0
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      cutout: '65%',
      plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } } }
    }
  });
}
</script>

<?php include 'includes/footer.php'; ?>
