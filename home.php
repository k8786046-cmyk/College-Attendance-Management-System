<?php
require 'config/db.php';

// Public, illustrative counts for the landing page (no login required)
$totalStudents = $pdo->query("SELECT COUNT(*) c FROM students")->fetch()['c'];
$totalRooms    = $pdo->query("SELECT COUNT(*) c FROM rooms")->fetch()['c'];
$occupiedSeats = $pdo->query("SELECT COALESCE(SUM(occupied),0) c FROM rooms")->fetch()['c'];
$capacitySeats = $pdo->query("SELECT COALESCE(SUM(capacity),0) c FROM rooms")->fetch()['c'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hostel Management System</title>
<link href="assets/img/favicon.svg" rel="icon" type="image/svg+xml">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="home-body">

<nav class="navbar navbar-dark hms-navbar px-3 px-md-5 sticky-nav" id="mainNav">
  <span class="brand-mark">
    <svg class="brand-crest" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
      <path d="M16 2 L28 7 V16 C28 23 22.5 27.5 16 30 C9.5 27.5 4 23 4 16 V7 Z" fill-opacity="0.15"/>
      <path d="M16 2 L28 7 V16 C28 23 22.5 27.5 16 30 C9.5 27.5 4 23 4 16 V7 Z" fill="none" stroke="#C9A227" stroke-width="1.6"/>
      <path d="M11 19 V13 L16 10 L21 13 V19 H17.5 V15.5 H14.5 V19 Z" fill="#C9A227"/>
    </svg>
    Hostel Management System
  </span>
  <div class="d-none d-md-flex gap-4 nav-links">
    <a href="#about">About</a>
    <a href="#facilities">Facilities</a>
    <a href="#rulebook">Rules</a>
    <a href="#faq">FAQ</a>
    <a href="#contact">Contact</a>
  </div>
  <div class="d-flex gap-2">
    <a href="#apply" class="btn btn-sm btn-brass">Apply for Hostel</a>
    <a href="student_login.php" class="btn btn-sm btn-outline-light">Student login</a>
    <a href="login.php" class="btn btn-sm btn-outline-light">Admin login</a>
  </div>
</nav>

<header class="home-hero px-3 px-md-5">
  <div class="home-hero-inner">
    <p class="hero-eyebrow">Hostel administration, in one register</p>
    <h1>Every room, resident, and rupee — accounted for.</h1>
    <p class="hero-sub">One system for the warden's desk: room allotment, fee
      collection, attendance, complaints, and visitor logs, with a
      dedicated portal so residents can check their own record any time.</p>
    <div class="d-flex flex-wrap gap-3 mt-4">
      <a href="#apply" class="btn btn-brass btn-lg">Apply for a Seat</a>
      <a href="login.php" class="btn btn-outline-hero btn-lg">Admin login</a>
      <a href="student_login.php" class="btn btn-outline-hero btn-lg">Student login</a>
    </div>
  </div>

  <div class="home-hero-figures">
    <div class="figure-block">
      <div class="figure-num"><?= (int)$totalStudents ?></div>
      <div class="figure-label">Residents housed</div>
    </div>
    <div class="figure-block">
      <div class="figure-num"><?= (int)$totalRooms ?></div>
      <div class="figure-label">Rooms on record</div>
    </div>
    <div class="figure-block">
      <div class="figure-num"><?= $capacitySeats > 0 ? round(($occupiedSeats / $capacitySeats) * 100) : 0 ?>%</div>
      <div class="figure-label">Occupancy</div>
    </div>
  </div>
</header>

<section class="home-about px-3 px-md-5" id="about">
  <div class="about-text">
    <p class="section-eyebrow">About us</p>
    <h2>A residence run like a proper institution — not a guesswork register.</h2>
    <p>Our hostel has been housing students through their course years with a
      focus on safety, discipline, and comfort. Every room, resident, fee
      receipt, and gate entry is logged the same way it always has been —
      carefully — except now it's searchable in seconds instead of buried in
      a ledger.</p>
    <p>The warden's desk and the resident's own record are kept in the same
      system, so a fee status, an attendance mark, or an approved leave is
      never "check and get back to you" — it's already on screen.</p>
    <div class="about-stat-row">
      <div>
        <div class="about-stat-num"><?= (int)$totalRooms ?></div>
        <div class="about-stat-label">Rooms on record</div>
      </div>
      <div>
        <div class="about-stat-num"><?= (int)$totalStudents ?></div>
        <div class="about-stat-label">Residents housed</div>
      </div>
      <div>
        <div class="about-stat-num">24x7</div>
        <div class="about-stat-label">Security &amp; support</div>
      </div>
    </div>
  </div>
  <div class="about-panel">
    <h4><i class="fa-solid fa-star"></i> Why residents and parents trust us</h4>
    <ul>
      <li><i class="fa-solid fa-check"></i> Gate timings enforced, with parents alerted the moment a resident returns after curfew</li>
      <li><i class="fa-solid fa-check"></i> Every visitor signed in and out, with the hostel rules and fee structure handed to them at the gate</li>
      <li><i class="fa-solid fa-check"></i> Leave of 7 or more continuous days automatically reduces the mess fee — no separate request needed</li>
      <li><i class="fa-solid fa-check"></i> A resident can check their own fees, attendance, and days-in-hostel at any time</li>
    </ul>
  </div>
</section>

<section class="home-facilities" id="facilities">
  <div class="section-inner px-3 px-md-5">
    <p class="section-eyebrow">On campus</p>
    <h2 class="contact-heading" style="margin-bottom:0;">Facilities</h2>
    <div class="facility-grid">
      <div class="facility-item">
        <div class="facility-icon"><i class="fa-solid fa-wifi"></i></div>
        <h3>High-Speed WiFi</h3>
        <p>Campus-wide broadband coverage in every room and common area.</p>
      </div>
      <div class="facility-item">
        <div class="facility-icon"><i class="fa-solid fa-utensils"></i></div>
        <h3>Hygienic Mess</h3>
        <p>Fixed breakfast, lunch, and dinner timings with a balanced daily menu.</p>
      </div>
      <div class="facility-item">
        <div class="facility-icon"><i class="fa-solid fa-shield-halved"></i></div>
        <h3>24x7 Security &amp; CCTV</h3>
        <p>Manned gate, curfew enforcement, and camera coverage across the premises.</p>
      </div>
      <div class="facility-item">
        <div class="facility-icon"><i class="fa-solid fa-bolt"></i></div>
        <h3>Power Backup</h3>
        <p>Generator backup so rooms and common areas never lose power for long.</p>
      </div>
      <div class="facility-item">
        <div class="facility-icon"><i class="fa-solid fa-shirt"></i></div>
        <h3>Laundry Service</h3>
        <p>Scheduled washing and ironing service on a weekly cycle.</p>
      </div>
      <div class="facility-item">
        <div class="facility-icon"><i class="fa-solid fa-book-open"></i></div>
        <h3>Study Room</h3>
        <p>A quiet reading room separate from the dorms, open beyond regular hours.</p>
      </div>
      <div class="facility-item">
        <div class="facility-icon"><i class="fa-solid fa-droplet"></i></div>
        <h3>RO Drinking Water</h3>
        <p>Purified water coolers on every floor, refilled and serviced regularly.</p>
      </div>
      <div class="facility-item">
        <div class="facility-icon"><i class="fa-solid fa-table-tennis-paddle-ball"></i></div>
        <h3>Recreation Room</h3>
        <p>Indoor games and a common TV lounge for residents to unwind.</p>
      </div>
    </div>
  </div>
</section>

<section class="home-rulebook px-3 px-md-5" id="rulebook">
  <div class="rulebook-grid">
    <div class="rulebook-visual" aria-hidden="true">
      <div class="book">
        <div class="book-cover">
          <i class="fa-solid fa-book"></i>
          <span>Hostel Rule Book</span>
        </div>
        <div class="book-page book-page-1"></div>
        <div class="book-page book-page-2"></div>
      </div>
    </div>
    <div class="rulebook-text">
      <p class="section-eyebrow">Know before you stay</p>
      <h2>The Hostel Rule Book</h2>
      <p>Curfew timings, visitor hours, leave policy, mess fee reduction
        rules, and the full fee structure — everything a resident or a
        parent needs to know, kept in one official document instead of
        scattered notices.</p>
      <ul class="rulebook-points">
        <li><i class="fa-solid fa-check"></i> Gate curfew &amp; late-entry policy</li>
        <li><i class="fa-solid fa-check"></i> Leave &amp; mess fee reduction rules</li>
        <li><i class="fa-solid fa-check"></i> Visitor hours &amp; conduct</li>
        <li><i class="fa-solid fa-check"></i> Complete fee structure</li>
      </ul>
      <a href="hostel_rules.php" class="btn btn-brass btn-lg mt-2"><i class="fa-solid fa-book-open"></i> Open the Rule Book</a>
    </div>
  </div>
</section>

<section class="home-features px-3 px-md-5" id="features">
  <p class="section-eyebrow">What it keeps track of</p>
  <div class="feature-grid">
    <div class="feature-item">
      <i class="fa-solid fa-user-graduate"></i>
      <h3>Students</h3>
      <p>Admission details, contact info, and room assignment in one record per resident.</p>
    </div>
    <div class="feature-item">
      <i class="fa-solid fa-door-open"></i>
      <h3>Rooms</h3>
      <p>Capacity and occupancy tracked automatically as residents move in and out.</p>
    </div>
    <div class="feature-item">
      <i class="fa-solid fa-money-bill"></i>
      <h3>Fees</h3>
      <p>Due dates and payment status, so nothing pending slips through unnoticed.</p>
    </div>
    <div class="feature-item">
      <i class="fa-solid fa-triangle-exclamation"></i>
      <h3>Complaints</h3>
      <p>Residents file their own; the warden tracks each through to resolution.</p>
    </div>
    <div class="feature-item">
      <i class="fa-solid fa-calendar-check"></i>
      <h3>Attendance</h3>
      <p>Daily present/absent marking with a searchable history by date.</p>
    </div>
    <div class="feature-item">
      <i class="fa-solid fa-address-book"></i>
      <h3>Visitors</h3>
      <p>Who came to see whom, and when they signed in and out.</p>
    </div>
  </div>
</section>

<section class="home-steps px-3 px-md-5" id="how">
  <p class="section-eyebrow">How it works</p>
  <div class="steps-row">
    <div class="step-item">
      <div class="step-num">01</div>
      <h3>Warden sets up the register</h3>
      <p>Add rooms and residents once — capacity, admission details,
        and a login password for each student are set from the admin desk.</p>
    </div>
    <div class="step-item">
      <div class="step-num">02</div>
      <h3>Daily records get logged</h3>
      <p>Attendance is marked, fees are recorded as they're paid, and
        visitors are signed in and out — a few minutes a day, not a
        stack of registers.</p>
    </div>
    <div class="step-item">
      <div class="step-num">03</div>
      <h3>Residents check their own record</h3>
      <p>Students sign in with their roll number to see their room,
        fee status, and attendance, and to file a complaint directly —
        no need to ask the warden every time.</p>
    </div>
  </div>
</section>

<section class="home-split px-3 px-md-5">
  <p class="section-eyebrow">Built for both sides of the desk</p>
  <div class="split-row">
    <div class="split-card">
      <i class="fa-solid fa-user-shield"></i>
      <h3>For the warden</h3>
      <ul>
        <li>Add, edit, and manage every student and room record</li>
        <li>Track fee dues and mark payments as they come in</li>
        <li>Resolve complaints and keep a status on each one</li>
        <li>Mark daily attendance and pull up any past date instantly</li>
        <li>Log every visitor with their in and out time</li>
      </ul>
      <a href="login.php" class="btn btn-brass btn-sm mt-2">Admin login</a>
    </div>
    <div class="split-card split-card-dark">
      <i class="fa-solid fa-user-graduate"></i>
      <h3>For the resident</h3>
      <ul>
        <li>Sign in with roll number — no separate registration needed</li>
        <li>See which room and bed is assigned, at a glance</li>
        <li>Check fee dues and payment history any time</li>
        <li>File a complaint and follow its status to resolution</li>
        <li>Review a personal day-by-day attendance record</li>
      </ul>
      <a href="student_login.php" class="btn btn-outline-hero btn-sm mt-2">Student login</a>
    </div>
  </div>
</section>

<section class="home-faq px-3 px-md-5" id="faq">
  <p class="section-eyebrow">Common questions</p>
  <div class="accordion" id="faqAccordion">

    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
          Do students need to register separately?
        </button>
      </h2>
      <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body">No — the warden creates the student record once. A login
          password is set at that point (or defaults to the student's roll number), and the
          student signs in with their roll number from then on.</div>
      </div>
    </div>

    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
          Can a student see another resident's data?
        </button>
      </h2>
      <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body">No. Each student login is scoped to that student's own room,
          fees, attendance, and complaints only. Only the admin login has visibility across every
          resident.</div>
      </div>
    </div>

    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
          What happens when a room fills up?
        </button>
      </h2>
      <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body">Occupancy updates automatically the moment a student is
          assigned, reassigned, or removed from a room, so a full room simply won't appear in the
          list of available rooms when adding the next student.</div>
      </div>
    </div>

    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
          Where is all this data stored?
        </button>
      </h2>
      <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body">In a MySQL database on the same server the system runs on.
          Passwords are stored as bcrypt hashes, never as plain text, and every query is built
          with parameterised statements.</div>
      </div>
    </div>

  </div>
</section>

<section class="home-apply px-3 px-md-5" id="apply">
  <p class="section-eyebrow">New here?</p>
  <h2 class="contact-heading">Apply for a Seat</h2>

  <?php if (isset($_GET['applied'])): ?>
    <?php if ($_GET['applied'] === '1'): ?>
      <div class="alert alert-success py-2 text-center mb-4">Application received — the warden's office will contact you shortly.</div>
    <?php else: ?>
      <div class="alert alert-danger py-2 text-center mb-4">Please fill in at least your name and phone number, then try again.</div>
    <?php endif; ?>
  <?php endif; ?>

  <div class="contact-form-card apply-form-card mx-auto">
    <form method="POST" action="admission.php">
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Full Name *</label>
          <input type="text" name="full_name" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Guardian Name</label>
          <input type="text" name="guardian_name" class="form-control">
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Phone *</label>
          <input type="text" name="phone" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control">
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Course &amp; Year</label>
          <input type="text" name="course_year" class="form-control" placeholder="e.g. B.E CSE, 2nd Year">
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Parent Phone</label>
          <input type="text" name="parent_phone" class="form-control">
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Preferred Room Type</label>
        <select name="room_type" class="form-select">
          <option value="Shared" selected>Shared Room</option>
          <option value="Single">Single Room</option>
          <option value="Dormitory">Dormitory</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Anything else we should know?</label>
        <textarea name="message" class="form-control" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-brass w-100"><i class="fa-solid fa-paper-plane"></i> Submit Application</button>
    </form>
  </div>
</section>

<section class="home-contact px-3 px-md-5" id="contact">
  <p class="section-eyebrow">Get in touch</p>
  <h2 class="contact-heading">Contact us</h2>

  <?php if (isset($_GET['sent'])): ?>
    <?php if ($_GET['sent'] === '1'): ?>
      <div class="alert alert-success py-2 text-center mb-4">Thanks — your message has been received. We'll get back to you soon.</div>
    <?php else: ?>
      <div class="alert alert-danger py-2 text-center mb-4">Please fill in your name, email, and message, then try again.</div>
    <?php endif; ?>
  <?php endif; ?>

  <div class="contact-grid">
    <div class="contact-info-card">
      <h4><i class="fa-solid fa-address-card"></i> Reach the warden's office</h4>
      <div class="contact-info-item">
        <i class="fa-solid fa-location-dot"></i>
        <div>
          <div class="label">Address</div>
          <div class="value">Hostel Administration Block,<br>College Campus, Tiruchirappalli,<br>Tamil Nadu, India</div>
        </div>
      </div>
      <div class="contact-info-item">
        <i class="fa-solid fa-phone"></i>
        <div>
          <div class="label">Phone</div>
          <div class="value">+91 98765 43210</div>
        </div>
      </div>
      <div class="contact-info-item">
        <i class="fa-solid fa-envelope"></i>
        <div>
          <div class="label">Email</div>
          <div class="value">warden@hostel.example</div>
        </div>
      </div>
      <div class="contact-info-item">
        <i class="fa-solid fa-clock"></i>
        <div>
          <div class="label">Office Hours</div>
          <div class="value">Mon - Sat, 9:00 AM - 6:00 PM</div>
        </div>
      </div>
    </div>

    <div class="contact-form-card">
      <form method="POST" action="contact.php">
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Name *</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Email *</label>
            <input type="email" name="email" class="form-control" required>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control">
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Subject</label>
            <input type="text" name="subject" class="form-control">
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Message *</label>
          <textarea name="message" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-brass"><i class="fa-solid fa-paper-plane"></i> Send Message</button>
      </form>
    </div>
  </div>
</section>

<section class="home-cta px-3 px-md-5">
  <div class="cta-inner">
    <h2>Ready to open the register?</h2>
    <p>Sign in to the desk that already knows the answer to "which room is she in?"</p>
    <div class="d-flex flex-wrap justify-content-center gap-3 mt-3">
      <a href="login.php" class="btn btn-dark btn-lg">Admin login</a>
      <a href="student_login.php" class="btn btn-outline-dark btn-lg">Student login</a>
    </div>
  </div>
</section>

<footer class="home-footer-full px-3 px-md-5">
  <div class="footer-grid">
    <div class="footer-col footer-brand">
      <span class="brand-mark-dark">
        <svg class="brand-crest" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
          <path d="M16 2 L28 7 V16 C28 23 22.5 27.5 16 30 C9.5 27.5 4 23 4 16 V7 Z" fill-opacity="0.08"/>
          <path d="M16 2 L28 7 V16 C28 23 22.5 27.5 16 30 C9.5 27.5 4 23 4 16 V7 Z" fill="none" stroke="#14213D" stroke-width="1.6"/>
          <path d="M11 19 V13 L16 10 L21 13 V19 H17.5 V15.5 H14.5 V19 Z" fill="#14213D"/>
        </svg>
        Hostel Management System
      </span>
      <p class="text-muted small mt-2">The warden's desk and resident portal, in one register.</p>
    </div>
    <div class="footer-col">
      <h6>System</h6>
      <a href="#about">About</a>
      <a href="#facilities">Facilities</a>
      <a href="#features">What it does</a>
      <a href="#how">How it works</a>
      <a href="#faq">FAQ</a>
    </div>
    <div class="footer-col">
      <h6>Access</h6>
      <a href="#apply">Apply for a seat</a>
      <a href="login.php">Admin login</a>
      <a href="student_login.php">Student login</a>
      <a href="hostel_rules.php">Hostel rules</a>
      <a href="#contact">Contact</a>
    </div>
  </div>
  <div class="footer-bottom">
    <span>Hostel Management System</span>
    <span class="text-muted small">Mini project — PHP &amp; MySQL</span>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  window.addEventListener('scroll', function () {
    document.getElementById('mainNav').classList.toggle('scrolled', window.scrollY > 10);
  });
</script>

</body>
</html>
