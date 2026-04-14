<?php
$employees = [
    ["id" => 1, "name" => "Ahmad Ansari",  "role" => "DevOps Engineer",   "dept" => "IT",         "status" => "Active",   "email" => "ahmad@company.com",   "phone" => "+92-300-1234567", "joined" => "2022-03-15"],
    ["id" => 2, "name" => "Sara Khan",     "role" => "Frontend Dev",      "dept" => "Development","status" => "Active",   "email" => "sara@company.com",    "phone" => "+92-321-2345678", "joined" => "2021-07-22"],
    ["id" => 3, "name" => "Ali Raza",      "role" => "Backend Dev",       "dept" => "Development","status" => "On Leave", "email" => "ali@company.com",     "phone" => "+92-333-3456789", "joined" => "2020-11-10"],
    ["id" => 4, "name" => "Fatima Noor",   "role" => "UI Designer",       "dept" => "Design",     "status" => "Active",   "email" => "fatima@company.com",  "phone" => "+92-345-4567890", "joined" => "2023-01-05"],
    ["id" => 5, "name" => "Usman Malik",   "role" => "QA Engineer",       "dept" => "Testing",    "status" => "Active",   "email" => "usman@company.com",   "phone" => "+92-312-5678901", "joined" => "2022-08-18"],
    ["id" => 6, "name" => "Hina Shah",     "role" => "Project Manager",   "dept" => "Management", "status" => "Remote",   "email" => "hina@company.com",    "phone" => "+92-301-6789012", "joined" => "2019-05-30"],
    ["id" => 7, "name" => "Bilal Ahmed",   "role" => "Data Analyst",      "dept" => "Analytics",  "status" => "Active",   "email" => "bilal@company.com",   "phone" => "+92-311-7890123", "joined" => "2023-06-14"],
    ["id" => 8, "name" => "Zara Siddiqui", "role" => "Cloud Architect",   "dept" => "IT",         "status" => "Active",   "email" => "zara@company.com",    "phone" => "+92-322-8901234", "joined" => "2021-02-28"],
];

$departments = array_unique(array_column($employees, 'dept'));
$active  = count(array_filter($employees, fn($e) => $e['status'] === 'Active'));
$onLeave = count(array_filter($employees, fn($e) => $e['status'] === 'On Leave'));
$remote  = count(array_filter($employees, fn($e) => $e['status'] === 'Remote'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TeamBoard — Employee Directory</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
<style>
:root {
  --bg:       #080c14;
  --surface:  #0e1623;
  --surface2: #141e30;
  --border:   #1e2d45;
  --accent:   #00d4ff;
  --accent2:  #7c3aed;
  --accent3:  #f97316;
  --text:     #e2ecf8;
  --muted:    #4a6080;
  --green:    #10b981;
  --amber:    #f59e0b;
  --blue:     #3b82f6;
}
*, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }

html { scroll-behavior: smooth; }

body {
  font-family: 'DM Sans', sans-serif;
  background: var(--bg);
  color: var(--text);
  min-height: 100vh;
  overflow-x: hidden;
}

/* ── NOISE OVERLAY ── */
body::before {
  content:'';
  position:fixed; inset:0;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
  pointer-events:none; z-index:0;
}

/* ── GRID LINES ── */
body::after {
  content:'';
  position:fixed; inset:0;
  background-image:
    linear-gradient(rgba(0,212,255,.03) 1px, transparent 1px),
    linear-gradient(90deg, rgba(0,212,255,.03) 1px, transparent 1px);
  background-size: 60px 60px;
  pointer-events:none; z-index:0;
}

/* ── TOP NAV ── */
nav {
  position: fixed; top:0; left:0; right:0; z-index:100;
  display: flex; align-items:center; justify-content:space-between;
  padding: 0 40px;
  height: 64px;
  background: rgba(8,12,20,.85);
  backdrop-filter: blur(20px);
  border-bottom: 1px solid var(--border);
}
.nav-logo {
  font-family:'Syne',sans-serif;
  font-size:1.2rem; font-weight:800;
  letter-spacing:-.02em;
  color:#fff;
}
.nav-logo span { color: var(--accent); }
.nav-links { display:flex; gap:6px; }
.nav-links a {
  font-size:.82rem; font-weight:500;
  color: var(--muted);
  text-decoration:none;
  padding: 6px 14px;
  border-radius:8px;
  transition: all .2s;
}
.nav-links a:hover { color:#fff; background: var(--surface2); }

/* ── HERO ── */
.hero {
  position:relative; z-index:1;
  padding: 140px 40px 80px;
  max-width: 1100px; margin: 0 auto;
  display:grid; grid-template-columns:1fr 1fr; gap:60px; align-items:center;
}
.hero-badge {
  display:inline-flex; align-items:center; gap:6px;
  background: rgba(0,212,255,.08);
  border: 1px solid rgba(0,212,255,.2);
  color: var(--accent);
  font-size:.75rem; font-weight:600; letter-spacing:.08em; text-transform:uppercase;
  padding:5px 14px; border-radius:20px;
  margin-bottom:20px;
}
.hero-badge::before { content:''; width:6px; height:6px; border-radius:50%; background:var(--accent); animation: pulse 2s infinite; }
@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.3} }

.hero h1 {
  font-family:'Syne',sans-serif;
  font-size:clamp(2.4rem,5vw,3.6rem);
  font-weight:800; line-height:1.05; letter-spacing:-.03em;
  color:#fff;
  margin-bottom:16px;
}
.hero h1 .hl {
  background: linear-gradient(135deg, var(--accent), var(--accent2));
  -webkit-background-clip:text; -webkit-text-fill-color:transparent;
}
.hero-sub {
  color: var(--muted); font-size:1rem; line-height:1.7;
  max-width:420px; margin-bottom:32px;
}
.hero-actions { display:flex; gap:12px; flex-wrap:wrap; }
.btn {
  display:inline-flex; align-items:center; gap:8px;
  padding:12px 24px; border-radius:10px;
  font-family:'DM Sans',sans-serif; font-size:.9rem; font-weight:500;
  cursor:pointer; border:none; text-decoration:none;
  transition: all .2s;
}
.btn-primary {
  background: linear-gradient(135deg, var(--accent), #0099cc);
  color:#000; font-weight:700;
}
.btn-primary:hover { transform:translateY(-2px); box-shadow:0 8px 30px rgba(0,212,255,.3); }
.btn-outline {
  background:transparent;
  border:1px solid var(--border);
  color: var(--text);
}
.btn-outline:hover { border-color: var(--accent); color:var(--accent); }

/* stats card in hero */
.hero-visual {
  display:grid; grid-template-columns:1fr 1fr; gap:16px;
}
.stat-card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius:16px; padding:24px;
  position:relative; overflow:hidden;
  transition: transform .3s;
}
.stat-card:hover { transform:translateY(-4px); }
.stat-card::before {
  content:''; position:absolute; inset:0;
  background: linear-gradient(135deg, rgba(0,212,255,.05), transparent);
  pointer-events:none;
}
.stat-card.big { grid-column:span 2; }
.stat-num {
  font-family:'Syne',sans-serif;
  font-size:2.8rem; font-weight:800; line-height:1;
  color:#fff; margin-bottom:4px;
}
.stat-card.big .stat-num { font-size:3.5rem; }
.stat-label { font-size:.78rem; color:var(--muted); text-transform:uppercase; letter-spacing:.06em; }
.stat-icon { font-size:1.6rem; margin-bottom:10px; }

/* ── SECTION WRAPPER ── */
.section {
  position:relative; z-index:1;
  max-width:1100px; margin:0 auto;
  padding:40px 40px 80px;
}
.section-header {
  display:flex; align-items:center; justify-content:space-between;
  margin-bottom:32px;
  padding-bottom:20px;
  border-bottom:1px solid var(--border);
}
.section-title {
  font-family:'Syne',sans-serif;
  font-size:1.5rem; font-weight:700;
  color:#fff;
}
.section-title span { color:var(--accent); }

/* ── FILTER BAR ── */
.filter-bar {
  display:flex; align-items:center; gap:10px; flex-wrap:wrap;
  margin-bottom:28px;
}
.filter-btn {
  padding:7px 16px; border-radius:8px;
  font-size:.8rem; font-weight:500;
  border:1px solid var(--border);
  background:var(--surface); color:var(--muted);
  cursor:pointer; transition:all .2s;
}
.filter-btn:hover, .filter-btn.active {
  border-color:var(--accent); color:var(--accent);
  background:rgba(0,212,255,.08);
}
.search-box {
  margin-left:auto;
  display:flex; align-items:center; gap:8px;
  background:var(--surface); border:1px solid var(--border);
  border-radius:8px; padding:7px 14px;
}
.search-box input {
  background:none; border:none; outline:none;
  font-family:'DM Sans',sans-serif; font-size:.85rem;
  color: var(--text); width:160px;
}
.search-box input::placeholder { color:var(--muted); }

/* ── EMPLOYEE GRID ── */
#employees-grid {
  display:grid;
  grid-template-columns: repeat(auto-fill, minmax(320px,1fr));
  gap:16px;
}
.emp-card {
  background:var(--surface);
  border:1px solid var(--border);
  border-radius:16px; padding:22px;
  display:flex; gap:16px; align-items:flex-start;
  transition: all .25s;
  animation: fadeUp .4s ease both;
  position:relative; overflow:hidden;
}
.emp-card::after {
  content:''; position:absolute;
  top:0; left:0; right:0; height:2px;
  background: linear-gradient(90deg, var(--accent), var(--accent2));
  transform:scaleX(0); transform-origin:left;
  transition: transform .3s;
}
.emp-card:hover { border-color:rgba(0,212,255,.3); transform:translateY(-3px); box-shadow:0 16px 40px rgba(0,0,0,.4); }
.emp-card:hover::after { transform:scaleX(1); }

@keyframes fadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }

.emp-avatar {
  width:48px; height:48px; border-radius:12px;
  background: linear-gradient(135deg, var(--accent2), var(--accent));
  display:flex; align-items:center; justify-content:center;
  font-family:'Syne',sans-serif; font-weight:700; font-size:1.1rem;
  color:#fff; flex-shrink:0;
}
.emp-body { flex:1; min-width:0; }
.emp-name { font-family:'Syne',sans-serif; font-weight:700; font-size:1rem; color:#fff; margin-bottom:2px; }
.emp-role { font-size:.82rem; color:var(--muted); margin-bottom:12px; }
.emp-meta { display:flex; flex-direction:column; gap:5px; margin-bottom:14px; }
.emp-meta-row { display:flex; align-items:center; gap:7px; font-size:.78rem; color:var(--muted); }
.emp-meta-row svg { opacity:.5; flex-shrink:0; }
.emp-footer { display:flex; align-items:center; justify-content:space-between; }
.dept-tag {
  font-size:.72rem; font-weight:600; letter-spacing:.04em;
  padding:3px 10px; border-radius:6px;
  background:rgba(255,255,255,.05); border:1px solid var(--border);
  color:var(--muted);
}
.status-badge {
  font-size:.72rem; font-weight:700; letter-spacing:.04em;
  padding:4px 12px; border-radius:20px;
}
.status-Active  { background:rgba(16,185,129,.12); color:var(--green); border:1px solid rgba(16,185,129,.2); }
.status-On.Leave { background:rgba(245,158,11,.12); color:var(--amber); border:1px solid rgba(245,158,11,.2); }
.status-Remote  { background:rgba(59,130,246,.12); color:var(--blue);  border:1px solid rgba(59,130,246,.2);  }

/* ── ADD EMPLOYEE FORM ── */
#add-section {
  background: var(--surface);
  border:1px solid var(--border);
  border-radius:20px; padding:36px;
  margin-bottom:80px;
}
.form-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:24px; }
.form-group { display:flex; flex-direction:column; gap:8px; }
.form-group.full { grid-column:span 2; }
.form-group label {
  font-size:.78rem; font-weight:600; text-transform:uppercase;
  letter-spacing:.06em; color:var(--muted);
}
.form-group input,
.form-group select {
  background:var(--surface2);
  border:1px solid var(--border);
  border-radius:10px; padding:11px 14px;
  font-family:'DM Sans',sans-serif; font-size:.9rem;
  color:var(--text); outline:none;
  transition:border-color .2s;
}
.form-group input:focus,
.form-group select:focus { border-color:var(--accent); }
.form-group select option { background:var(--surface2); }
.form-actions { display:flex; gap:12px; }
.btn-save {
  background: linear-gradient(135deg,var(--green),#059669);
  color:#fff; font-weight:700;
}
.btn-save:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(16,185,129,.3); }
.btn-reset {
  background:var(--surface2); border:1px solid var(--border);
  color:var(--muted);
}
.btn-reset:hover { color:var(--text); border-color:var(--muted); }

/* toast */
.toast {
  position:fixed; bottom:32px; right:32px; z-index:9999;
  background:var(--surface); border:1px solid var(--green);
  color:var(--green); padding:14px 22px; border-radius:12px;
  font-size:.88rem; font-weight:500;
  display:flex; align-items:center; gap:10px;
  box-shadow:0 8px 30px rgba(0,0,0,.4);
  transform:translateY(80px); opacity:0;
  transition: all .3s cubic-bezier(.34,1.56,.64,1);
}
.toast.show { transform:translateY(0); opacity:1; }

/* ── DOCKER SECTION ── */
.docker-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
.docker-card {
  background:var(--surface);
  border:1px solid var(--border);
  border-radius:16px; padding:28px;
  transition: border-color .2s;
}
.docker-card:hover { border-color:rgba(0,212,255,.25); }
.docker-card h3 {
  font-family:'Syne',sans-serif; font-weight:700;
  font-size:1rem; margin-bottom:16px;
  display:flex; align-items:center; gap:10px;
}
.docker-card h3 .ico {
  width:32px; height:32px; border-radius:8px;
  background:rgba(0,212,255,.1); border:1px solid rgba(0,212,255,.2);
  display:flex; align-items:center; justify-content:center; font-size:.9rem;
}
pre {
  background:var(--bg);
  border:1px solid var(--border);
  border-radius:10px; padding:16px;
  font-size:.78rem; line-height:1.7;
  color:#94a3b8; overflow-x:auto;
  font-family:'Courier New',monospace;
}
pre .cmd { color:var(--accent); }
pre .cmt { color:var(--muted); font-style:italic; }
pre .flag { color:var(--accent3); }

/* ── FOOTER ── */
footer {
  position:relative; z-index:1;
  border-top:1px solid var(--border);
  padding:32px 40px;
  text-align:center;
  color:var(--muted); font-size:.82rem;
}
footer a { color:var(--accent); text-decoration:none; }

/* ── RESPONSIVE ── */
@media(max-width:768px){
  nav { padding:0 20px; }
  .nav-links { display:none; }
  .hero { grid-template-columns:1fr; padding:120px 20px 60px; }
  .hero-visual { display:none; }
  .section { padding:30px 20px 60px; }
  .form-grid { grid-template-columns:1fr; }
  .form-group.full { grid-column:span 1; }
  .docker-grid { grid-template-columns:1fr; }
}

/* hidden class */
.hidden { display:none !important; }
</style>
</head>
<body>

<!-- NAV -->
<nav>
  <div class="nav-logo">Team<span>Board</span></div>
  <div class="nav-links">
    <a href="#directory">Directory</a>
    <a href="#add-section">Add Employee</a>
    <a href="#docker-section">Docker Setup</a>
  </div>
</nav>

<!-- HERO -->
<div class="hero">
  <div>
    <div class="hero-badge">Live Dashboard</div>
    <h1>Your Team,<br><span class="hl">All In One</span><br>Place.</h1>
    <p class="hero-sub">A fast, containerized employee directory built with PHP & Docker. Manage your team with style.</p>
    <div class="hero-actions">
      <a href="#directory" class="btn btn-primary">👥 View Directory</a>
      <a href="#add-section" class="btn btn-outline">➕ Add Member</a>
    </div>
  </div>
  <div class="hero-visual">
    <div class="stat-card big">
      <div class="stat-icon">👥</div>
      <div class="stat-num"><?= count($employees) ?></div>
      <div class="stat-label">Total Team Members</div>
    </div>
    <div class="stat-card">
      <div class="stat-icon">✅</div>
      <div class="stat-num"><?= $active ?></div>
      <div class="stat-label">Active</div>
    </div>
    <div class="stat-card">
      <div class="stat-icon">🌐</div>
      <div class="stat-num"><?= $remote ?></div>
      <div class="stat-label">Remote</div>
    </div>
  </div>
</div>

<!-- DIRECTORY SECTION -->
<div class="section" id="directory">
  <div class="section-header">
    <div class="section-title">Employee <span>Directory</span></div>
    <div style="font-size:.82rem;color:var(--muted)"><?= count($employees) ?> members total</div>
  </div>

  <div class="filter-bar">
    <button class="filter-btn active" onclick="filterCards('all',this)">All</button>
    <?php foreach($departments as $d): ?>
      <button class="filter-btn" onclick="filterCards('<?= $d ?>',this)"><?= $d ?></button>
    <?php endforeach; ?>
    <div class="search-box">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
      <input type="text" id="searchInput" placeholder="Search name / role…" oninput="searchCards(this.value)">
    </div>
  </div>

  <div id="employees-grid">
    <?php foreach($employees as $i => $emp):
      $initials = implode('', array_map(fn($w)=>$w[0], explode(' ',$emp['name'])));
      $statusClass = str_replace(' ','',$emp['status']);
    ?>
    <div class="emp-card" data-dept="<?= $emp['dept'] ?>" data-name="<?= strtolower($emp['name']) ?>" data-role="<?= strtolower($emp['role']) ?>" style="animation-delay:<?= $i*0.06 ?>s">
      <div class="emp-avatar"><?= $initials ?></div>
      <div class="emp-body">
        <div class="emp-name"><?= $emp['name'] ?></div>
        <div class="emp-role"><?= $emp['role'] ?></div>
        <div class="emp-meta">
          <div class="emp-meta-row">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            <?= $emp['email'] ?>
          </div>
          <div class="emp-meta-row">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 15 19.79 19.79 0 0 1 1.58 6.38 2 2 0 0 1 3.55 4h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 11.91a16 16 0 0 0 5.91 5.91l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            <?= $emp['phone'] ?>
          </div>
          <div class="emp-meta-row">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Joined <?= date('M Y', strtotime($emp['joined'])) ?>
          </div>
        </div>
        <div class="emp-footer">
          <span class="dept-tag"><?= $emp['dept'] ?></span>
          <span class="status-badge status-<?= $statusClass ?>"><?= $emp['status'] ?></span>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- ADD EMPLOYEE SECTION -->
<div class="section" id="add-section">
  <div class="section-header">
    <div class="section-title">Add <span>New Member</span></div>
  </div>
  <div id="add-employee-form">
    <div class="form-grid">
      <div class="form-group">
        <label>Full Name</label>
        <input type="text" id="f-name" placeholder="e.g. Ahmad Ansari">
      </div>
      <div class="form-group">
        <label>Role / Title</label>
        <input type="text" id="f-role" placeholder="e.g. DevOps Engineer">
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" id="f-email" placeholder="name@company.com">
      </div>
      <div class="form-group">
        <label>Phone</label>
        <input type="text" id="f-phone" placeholder="+92-300-0000000">
      </div>
      <div class="form-group">
        <label>Department</label>
        <select id="f-dept">
          <option value="">Select department</option>
          <?php foreach($departments as $d): ?>
            <option value="<?= $d ?>"><?= $d ?></option>
          <?php endforeach; ?>
          <option value="Other">Other</option>
        </select>
      </div>
      <div class="form-group">
        <label>Status</label>
        <select id="f-status">
          <option value="Active">Active</option>
          <option value="Remote">Remote</option>
          <option value="On Leave">On Leave</option>
        </select>
      </div>
    </div>
    <div class="form-actions">
      <button class="btn btn-save" onclick="addEmployee()">✅ Save Employee</button>
      <button class="btn btn-reset" onclick="resetForm()">✖ Reset</button>
    </div>
  </div>
</div>

<!-- DOCKER SECTION -->
<div class="section" id="docker-section">
  <div class="section-header">
    <div class="section-title">Docker <span>Setup Guide</span></div>
  </div>
  <div class="docker-grid">
    <div class="docker-card">
      <h3><span class="ico">🐳</span> Dockerfile</h3>
      <pre><span class="cmt"># Base Image: PHP 8.2 + Apache</span>
<span class="cmd">FROM</span> php:8.2-apache

<span class="cmt"># Copy app to Apache web root</span>
<span class="cmd">COPY</span> index.php /var/www/html/

<span class="cmt"># Expose HTTP port</span>
<span class="cmd">EXPOSE</span> 80</pre>
    </div>
    <div class="docker-card">
      <h3><span class="ico">🔨</span> Build & Run</h3>
      <pre><span class="cmt"># Build Docker image</span>
<span class="cmd">docker build</span> <span class="flag">-t</span> emp-app .

<span class="cmt"># Run container</span>
<span class="cmd">docker run</span> <span class="flag">-d -p</span> 80:80 emp-app

<span class="cmt"># Check running containers</span>
<span class="cmd">docker ps</span>

<span class="cmt"># View logs</span>
<span class="cmd">docker logs</span> &lt;container_id&gt;</pre>
    </div>
    <div class="docker-card">
      <h3><span class="ico">☁️</span> EC2 Deploy</h3>
      <pre><span class="cmt"># Install Docker on Amazon Linux</span>
<span class="cmd">sudo yum install</span> docker <span class="flag">-y</span>
<span class="cmd">sudo systemctl start</span> docker

<span class="cmt"># Clone repo & build</span>
<span class="cmd">git clone</span> https://github.com/
  ahmadansari1942/docker-php.git
<span class="cmd">cd</span> docker-php
<span class="cmd">sudo docker build</span> <span class="flag">-t</span> emp-app .
<span class="cmd">sudo docker run</span> <span class="flag">-d -p</span> 80:80 emp-app</pre>
    </div>
    <div class="docker-card">
      <h3><span class="ico">🔄</span> Update & Redeploy</h3>
      <pre><span class="cmt"># Push new code to GitHub</span>
<span class="cmd">git add</span> .
<span class="cmd">git commit</span> <span class="flag">-m</span> "update"
<span class="cmd">git push</span>

<span class="cmt"># On EC2: pull & rebuild</span>
<span class="cmd">sudo git pull</span>
<span class="cmd">sudo docker stop</span> $(docker ps -q)
<span class="cmd">sudo docker build</span> <span class="flag">-t</span> emp-app .
<span class="cmd">sudo docker run</span> <span class="flag">-d -p</span> 80:80 emp-app</pre>
    </div>
  </div>
</div>

<footer>
  Built with 🐳 Docker + PHP by
  <a href="https://github.com/ahmadansari1942" target="_blank">@ahmadansari1942</a>
  &nbsp;·&nbsp; Repo: <a href="https://github.com/ahmadansari1942/docker-php" target="_blank">docker-php</a>
</footer>

<!-- TOAST -->
<div class="toast" id="toast">✅ Employee saved successfully!</div>

<script>
/* ── FILTER ── */
function filterCards(dept, btn) {
  document.querySelectorAll('.filter-btn').forEach(b=>b.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll('.emp-card').forEach(card=>{
    card.classList.toggle('hidden', dept !== 'all' && card.dataset.dept !== dept);
  });
}

/* ── SEARCH ── */
function searchCards(q) {
  q = q.toLowerCase();
  document.querySelectorAll('.emp-card').forEach(card=>{
    const match = card.dataset.name.includes(q) || card.dataset.role.includes(q);
    card.classList.toggle('hidden', !match);
  });
}

/* ── ADD EMPLOYEE ── */
function addEmployee() {
  const name   = document.getElementById('f-name').value.trim();
  const role   = document.getElementById('f-role').value.trim();
  const email  = document.getElementById('f-email').value.trim();
  const phone  = document.getElementById('f-phone').value.trim();
  const dept   = document.getElementById('f-dept').value;
  const status = document.getElementById('f-status').value;

  if (!name || !role || !dept) {
    alert('Please fill Name, Role, and Department at minimum.');
    return;
  }

  const initials = name.split(' ').map(w=>w[0]).join('').toUpperCase();
  const statusClass = status.replace(' ','');
  const joined = new Date().toLocaleDateString('en-US',{month:'short',year:'numeric'});

  const card = document.createElement('div');
  card.className = 'emp-card';
  card.dataset.dept = dept;
  card.dataset.name = name.toLowerCase();
  card.dataset.role = role.toLowerCase();
  card.innerHTML = `
    <div class="emp-avatar">${initials}</div>
    <div class="emp-body">
      <div class="emp-name">${name}</div>
      <div class="emp-role">${role}</div>
      <div class="emp-meta">
        <div class="emp-meta-row">✉ ${email || '—'}</div>
        <div class="emp-meta-row">📞 ${phone || '—'}</div>
        <div class="emp-meta-row">📅 Joined ${joined}</div>
      </div>
      <div class="emp-footer">
        <span class="dept-tag">${dept}</span>
        <span class="status-badge status-${statusClass}">${status}</span>
      </div>
    </div>`;

  document.getElementById('employees-grid').prepend(card);
  showToast();
  resetForm();

  // scroll to directory
  document.getElementById('directory').scrollIntoView({behavior:'smooth'});
}

function resetForm() {
  ['f-name','f-role','f-email','f-phone'].forEach(id=>document.getElementById(id).value='');
  document.getElementById('f-dept').value = '';
  document.getElementById('f-status').value = 'Active';
}

function showToast() {
  const t = document.getElementById('toast');
  t.classList.add('show');
  setTimeout(()=>t.classList.remove('show'), 3200);
}
</script>
</body>
</html>
