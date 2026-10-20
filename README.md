# Hostel Management System (PHP + MySQL)

A mini project for managing hostel students, rooms, fees, complaints,
attendance, and visitors.

**Design:** an institutional "registry" theme — deep navy and brass on
a warm parchment background, serif headings (Fraunces) with Inter for
body/data, and ledger-style tables instead of generic dashboard cards.
Everything is in `assets/css/style.css`, layered on top of Bootstrap 5
so no other file needed a rewrite.

## Modules
- **Home** (`home.php`) – public landing page with an overview and
  links into both logins; open this first
- **Admin Login** – full access (session based)
- **Student Login** – students log in with Roll No + password to view
  only their own data
- **Students** – add/edit/delete, assign to a room, set/reset login password
- **Rooms** – manage room inventory and occupancy
- **Fees** – record and track pending/paid fees
- **Complaints** – log and track complaint status (students can file their own)
- **Attendance** – mark daily present/absent, view history by date
- **Visitors** – log visitor in/out times per student; each visitor row
  has a printable "Rules & Fee" slip
- **Leaves** – record/approve student leave; a leave of 7+ continuous
  days automatically credits a proportional mess-fee reduction and
  marks attendance Absent for those dates
- **Late Entry** – gate register for late returns; any entry after the
  curfew time automatically logs a parent alert
- **Parent Alerts** – log of every simulated alert message sent to a
  parent (no real SMS gateway is wired up — this records exactly what
  would be sent)
- **Rules** and **Fee Structure** – admin-editable content shown on
  the public `hostel_rules.php` page and on visitor slips
- **Student detail view** (`students/view.php`) – a single student's
  total fees paid/pending, days in hostel, attendance summary, and
  leave history, for the admin

## Student Portal
- URL: `student_login.php`
- Login: Roll No + password
- Default password for a new student = their Roll No, unless the admin
  sets a custom one in the "Student Login Password" field on the
  Add/Edit Student form
- Students can view their own room, fees (with total paid/pending and
  days in hostel), attendance, complaint status, and leave history;
  they can file complaints and apply for leave — but cannot see other
  students' data or access admin features

## Leave & mess-fee reduction
- Students apply for leave from **My Leaves**; the warden approves or
  rejects it from **Leaves** in the admin panel. Leave recorded
  directly by the admin is approved immediately.
- On approval, if the leave runs `LEAVE_REDUCTION_MIN_DAYS` (default
  7) days or more, a mess-fee credit of `MESS_FEE_PER_DAY` × days is
  added as a fee record automatically (shown as a green "Credit" line
  in Fees), and attendance for every day of the leave is marked
  Absent. Both settings live in `config/db.php`.

## Late entry & parent alerts
- The warden logs a gate entry time in **Late Entry**. Anything after
  `CURFEW_TIME` (default 9:00 PM, in `config/db.php`) automatically
  writes a message to **Parent Alerts** — this project has no real SMS
  gateway configured, so the alert log is a stand-in that shows
  exactly what would be sent and to which parent phone number.
- Add a student's Parent Name/Phone from the Add/Edit Student form so
  alerts can reference them.

## Rules & Fee Structure
- Manage rule entries and fee-structure line items from the admin
  sidebar. They appear together on `hostel_rules.php`, a public page
  (no login) meant to be shown or printed for visitors, and on each
  visitor's printable slip (`visitors/slip.php`).

## Home page & Contact form
- `home.php` is a single, scrollable public landing page with **About**,
  **Facilities**, **Rule Book** (visual link to the hostel rules), "What
  it keeps track of", "How it works", FAQ, an **Apply for a Seat**
  admission form, and **Contact** — with anchored nav links and a sticky
  header.
- The Contact form posts to `contact.php` → `contact_messages` table.
  Admin manages these from **Enquiries** in the sidebar.
- The admission form posts to `admission.php` → `hostel_applications`
  table (no login needed to apply). Admin reviews, approves, or rejects
  each request from **Admissions** in the sidebar
  (`applications/list.php`) — once approved, add the resident for real
  from **Students** and assign a room. A badge on both sidebar links
  shows unread/pending counts.

## If you already imported the old hostel_db.sql
Run `sql/migration_add_student_password.sql`, then
`sql/migration_hostel_features.sql`, then
`sql/migration_contact_messages.sql`, then
`sql/migration_hostel_applications.sql`, in phpMyAdmin's SQL tab on
your existing `hostel_db` database — these add the new columns/tables
for parent contacts, rules, fee structure, leaves, late entries,
parent alerts, contact-form enquiries, and admission applications,
without wiping your existing data. Then edit each existing
student once (Students → edit → set a password) so they can log in to
the student portal.

## Tech Stack
- PHP (no framework, plain PDO)
- MySQL
- Bootstrap 5 (via CDN) for UI
- Font Awesome (via CDN) for icons

## Setup (XAMPP / WAMP / MAMP)

1. Copy the `hostel_management` folder into your server's `htdocs`
   (XAMPP) or `www` (WAMP) directory.

2. Start Apache and MySQL from your control panel.

3. Open **phpMyAdmin** (http://localhost/phpmyadmin), create a new
   database, and import `sql/hostel_db.sql`. This creates the
   database `hostel_db` with all tables and a default admin login.

4. If your MySQL username/password isn't the default (`root` / empty
   password), edit `config/db.php` and update `$user` and `$pass`.

5. Visit `http://localhost/hostel_management/home.php` in your
   browser.

6. Login with:
   - **Username:** admin
   - **Password:** admin123

## Project Structure
```
hostel_management/
├── config/db.php          -> database connection
├── includes/               -> shared header, footer, auth guard
├── sql/hostel_db.sql       -> database schema + default admin
├── assets/css/style.css    -> custom styling
├── login.php / logout.php
├── index.php               -> dashboard
├── students/                -> list.php, form.php, delete.php
├── rooms/                   -> list.php, form.php, delete.php
├── fees/                     -> list.php, form.php, delete.php
├── complaints/               -> list.php, form.php, delete.php
├── attendance/                -> mark.php, view.php
└── visitors/                   -> list.php, form.php, checkout.php, delete.php
```

## Notes for Viva / Report
- Passwords are stored using PHP's `password_hash()` / `password_verify()`
  (bcrypt), not plain text — mention this if asked about security.
- All queries use PDO **prepared statements** to prevent SQL injection.
- Room occupancy count auto-updates when a student is assigned,
  reassigned, or removed from a room (see `students/form.php` and
  `students/delete.php`).
- Attendance uses a unique key on `(student_id, att_date)` with
  `ON DUPLICATE KEY UPDATE`, so re-marking the same day updates
  instead of duplicating.

## Possible Extensions (if you want to add more for evaluation)
- Export fee/attendance reports to PDF or Excel
- Email/SMS notification for pending fees
- Student self-login portal (separate from admin)
- Charts on the dashboard (e.g. Chart.js for occupancy/fee trends)
