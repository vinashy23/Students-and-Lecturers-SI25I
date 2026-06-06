<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'campus';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("connection failed " . $conn->connect_error);
}

// Handle DELETE for students
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $deletesql = "DELETE FROM students where id=$id";
    $conn->query($deletesql);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle ADD for students
if (isset($_POST['add'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $major = $_POST['major'];
    $class = $_POST['class'];
    $hobby = $_POST['hobby'];
    $insertsql = "INSERT INTO students (id, name, major, class, hobby)
                VALUES('$id', '$name', '$major', '$class', '$hobby')";
    $conn->query($insertsql);
    header("Location: " . $_SERVER['PHP_SELF'] . "?view=student");
    exit();
}

// Handle DELETE for lecturers
if (isset($_GET['delete_lecturer'])) {
    $nidn = $_GET['delete_lecturer'];
    $deletesql = "DELETE FROM lecturer WHERE NIDN='$nidn'";
    $conn->query($deletesql);
    header("Location: " . $_SERVER['PHP_SELF'] . "?view=lecturer");
    exit();
}

// Handle ADD for lecturers
if (isset($_POST['add_lecturer'])) {
    $nidn = $_POST['nidn'];
    $name = $_POST['name'];
    $major = $_POST['major'];
    $course = $_POST['course'];
    $insertsql = "INSERT INTO lecturer (NIDN, Name, Major, Course)
                VALUES('$nidn', '$name', '$major', '$course')";
    $conn->query($insertsql);
    header("Location: " . $_SERVER['PHP_SELF'] . "?view=lecturer");
    exit();
}

// Get data for displays
$studentResult = $conn->query("SELECT id, name, major, class, hobby FROM students");
$lecturerResult = $conn->query("SELECT NIDN, Name, Major, Course FROM lecturer");

// Stats
$countResult = $conn->query("SELECT COUNT(*) as total FROM students");
$countRow = $countResult->fetch_assoc();
$totalStudents = $countRow['total'];

$majorResult = $conn->query("SELECT COUNT(DISTINCT major) as cnt FROM students");
$majorRow = $majorResult->fetch_assoc();
$totalMajors = $majorRow['cnt'];

$classResult = $conn->query("SELECT COUNT(DISTINCT class) as cnt FROM students");
$classRow = $classResult->fetch_assoc();
$totalClasses = $classRow['cnt'];

$lecturerCountResult = $conn->query("SELECT COUNT(*) as total FROM lecturer");
$lecturerCountRow = $lecturerCountResult->fetch_assoc();
$totalLecturers = $lecturerCountRow['total'];

// Keep track of active view from URL parameter if present, defaults to student
$activeView = isset($_GET['view']) && $_GET['view'] === 'lecturer' ? 'lecturer' : 'student';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Campus Database - Students & Lecturers</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --lilac:     #c9b8e8;
            --lilac-soft:#e8dff5;
            --pink:      #f5c6d8;
            --pink-soft: #fce8f0;
            --mint:      #b8e4d8;
            --mint-soft: #dff5ee;
            --peach:     #f7c9a8;
            --peach-soft:#fde9d8;
            --sky:       #a8d4f5;
            --sky-soft:  #daeeff;
            --rose:      #e88fa8;
            --text-dark: #3d2d4a;
            --text-mid:  #6b5778;
            --text-light:#9a85a8;
            --white:     #fffaff;
            --shadow:    rgba(180, 140, 200, 0.18);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Rockwell', 'Rockwell Nova', 'Courier Bold', Georgia, serif;
            background: linear-gradient(135deg, #f5eeff 0%, #ffe8f3 40%, #e8f5fd 100%);
            min-height: 100vh;
            padding: 40px 24px;
            color: var(--text-dark);
        }

        .page-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .page-header h2 {
            font-size: 2.4rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            background: linear-gradient(90deg, #b07fe8, #e87faa, #7fbce8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 6px;
        }

        .page-header p {
            color: var(--text-light);
            font-size: 0.95rem;
            letter-spacing: 0.06em;
            font-style: italic;
        }

        .header-deco {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-top: 10px;
        }

        .header-deco span {
            display: block;
            height: 2px;
            width: 80px;
            background: linear-gradient(90deg, transparent, var(--lilac), transparent);
            border-radius: 2px;
        }

        .header-deco .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--pink);
        }

        .card {
            background: rgba(255,255,255,0.72);
            backdrop-filter: blur(16px);
            border-radius: 24px;
            border: 1.5px solid rgba(200, 170, 230, 0.3);
            box-shadow: 0 8px 40px var(--shadow);
            padding: 32px 36px;
            margin-bottom: 32px;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        .card-title {
            font-size: 1rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--text-light);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-title::before {
            content: '';
            display: inline-block;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--lilac), var(--pink));
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 14px;
            align-items: end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group label {
            font-size: 0.75rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--text-mid);
        }

        input[type="text"],
        select {
            font-family: 'Rockwell', 'Rockwell Nova', 'Courier Bold', Georgia, serif;
            font-size: 0.88rem;
            padding: 10px 14px;
            border: 1.5px solid rgba(190, 155, 220, 0.4);
            border-radius: 12px;
            background: rgba(255,255,255,0.85);
            color: var(--text-dark);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            width: 100%;
        }

        input[type="text"]:focus,
        select:focus {
            border-color: var(--lilac);
            box-shadow: 0 0 0 3px rgba(185, 140, 230, 0.15);
        }

        input::placeholder {
            color: var(--text-light);
        }

        .btn {
            font-family: 'Rockwell', 'Rockwell Nova', 'Courier Bold', Georgia, serif;
            font-size: 0.82rem;
            letter-spacing: 0.07em;
            padding: 10px 20px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-weight: 600;
            transition: transform 0.15s, box-shadow 0.15s, filter 0.15s;
            white-space: nowrap;
        }

        .btn:hover {
            transform: translateY(-2px);
            filter: brightness(1.06);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn-add {
            background: linear-gradient(135deg, var(--lilac), #b07fe8);
            color: #fff;
            box-shadow: 0 4px 16px rgba(176, 127, 232, 0.35);
        }

        .btn-add-lecturer {
            background: linear-gradient(135deg, var(--mint), #7fcea8);
            color: #fff;
            box-shadow: 0 4px 16px rgba(127, 206, 168, 0.35);
        }

        .btn-delete {
            background: linear-gradient(135deg, var(--rose), #e85c7a);
            color: #fff;
            box-shadow: 0 3px 10px rgba(232, 100, 130, 0.3);
            font-size: 0.76rem;
            padding: 7px 16px;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            font-family: 'Rockwell', 'Rockwell Nova', 'Courier Bold', Georgia, serif;
            font-weight: 600;
            letter-spacing: 0.06em;
            transition: transform 0.15s, filter 0.15s;
        }

        .btn-delete:hover {
            transform: translateY(-2px);
            filter: brightness(1.08);
        }

        /* --- TABS SYSTEM STYLING --- */
        .table-toggle-container {
            display: flex;
            justify-content: center;
            gap: 16px;
            margin-bottom: 20px;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        .tab-btn {
            font-family: 'Rockwell', 'Rockwell Nova', 'Courier Bold', Georgia, serif;
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            padding: 12px 32px;
            border: 1.5px solid rgba(200, 170, 230, 0.4);
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(10px);
            color: var(--text-mid);
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 4px 15px var(--shadow);
        }

        .tab-btn:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: translateY(-1px);
        }

        .tab-btn.active[data-target="students-view"] {
            background: linear-gradient(135deg, var(--lilac), #b07fe8);
            color: white;
            border-color: #b07fe8;
            box-shadow: 0 6px 20px rgba(176, 127, 232, 0.4);
        }

        .tab-btn.active[data-target="lecturers-view"] {
            background: linear-gradient(135deg, var(--mint), #7fcea8);
            color: white;
            border-color: #7fcea8;
            box-shadow: 0 6px 20px rgba(127, 206, 168, 0.4);
        }

        .view-section {
            display: none;
        }

        .view-section.active-view {
            display: table-row-group;
        }
        /* --------------------------- */

        .table-wrapper {
            overflow-x: auto;
            border-radius: 16px;
        }

        table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            font-size: 0.88rem;
        }

        thead tr {
            background: linear-gradient(90deg, var(--lilac-soft), var(--pink-soft), var(--sky-soft));
        }

        th {
            padding: 14px 18px;
            text-align: center;
            color: var(--text-mid);
            font-size: 0.75rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            font-weight: 700;
            border-bottom: 2px solid rgba(200, 170, 230, 0.25);
        }

        th:first-child { border-radius: 16px 0 0 0; }
        th:last-child  { border-radius: 0 16px 0 0; }

        tbody tr {
            transition: background 0.18s;
        }

        tbody tr:nth-child(odd)  { background: rgba(255,255,255,0.55); }
        tbody tr:nth-child(even) { background: rgba(240,225,255,0.25); }

        tbody tr:hover { background: rgba(200, 170, 230, 0.15); }

        td {
            padding: 13px 18px;
            text-align: center;
            color: var(--text-dark);
            border-bottom: 1px solid rgba(200, 170, 230, 0.15);
        }

        .id-pill, .nidn-pill {
            display: inline-block;
            background: linear-gradient(135deg, var(--mint-soft), var(--sky-soft));
            color: var(--text-mid);
            border-radius: 50px;
            padding: 3px 12px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.05em;
        }
    
        .major-badge, .course-badge {
            display: inline-block;
            background: linear-gradient(135deg, var(--peach-soft), var(--pink-soft));
            color: var(--text-mid);
            border-radius: 50px;
            padding: 4px 12px;
            font-size: 0.78rem;
        }

        .class-badge {
            display: inline-block;
            background: linear-gradient(135deg, var(--sky-soft), var(--mint-soft));
            color: var(--text-mid);
            border-radius: 50px;
            padding: 4px 12px;
            font-size: 0.78rem;
        }

        .empty-state {
            text-align: center;
            padding: 48px 24px;
            color: var(--text-light);
            font-style: italic;
        }

        .empty-state .emoji {
            font-size: 2.5rem;
            display: block;
            margin-bottom: 10px;
        }

        .stats-strip {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: 0 auto 28px;
        }

        .stat-chip {
            flex: 1;
            min-width: 130px;
            background: rgba(255,255,255,0.7);
            border-radius: 16px;
            padding: 16px 20px;
            border: 1.5px solid rgba(200,170,230,0.25);
            box-shadow: 0 4px 16px var(--shadow);
            text-align: center;
        }

        .stat-chip .num {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1;
        }

        .stat-chip .lbl {
            font-size: 0.72rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--text-light);
            margin-top: 4px;
        }

        .chip-lilac { border-top: 3px solid var(--lilac); }
        .chip-pink  { border-top: 3px solid var(--pink);  }
        .chip-mint  { border-top: 3px solid var(--mint);  }
        .chip-peach { border-top: 3px solid var(--peach); }
        .chip-sky   { border-top: 3px solid var(--sky);   }

        .section-divider {
            margin: 24px 0 10px;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--lilac), var(--pink), var(--mint), transparent);
            border-radius: 3px;
        }

        a { text-decoration: none; }

        @media (max-width: 640px) {
            .card { padding: 20px 16px; }
            .form-grid { grid-template-columns: 1fr 1fr; }
        }
    </style>
</head>
<body>

<div class="page-header">
    <h2>✦ Campus Database ✦</h2>
    <p>NUSA PUTRA UNIVERSITY | STUDENTS & LECTURERS</p>
    <div class="header-deco">
        <span></span><div class="dot"></div><span></span>
    </div>
</div>

<div class="stats-strip">
    <div class="stat-chip chip-lilac">
        <div class="num"><?php echo $totalStudents; ?></div>
        <div class="lbl">Total Students</div>
    </div>
    <div class="stat-chip chip-pink">
        <div class="num"><?php echo $totalMajors; ?></div>
        <div class="lbl">Student Majors</div>
    </div>
    <div class="stat-chip chip-mint">
        <div class="num"><?php echo $totalClasses; ?></div>
        <div class="lbl">Student Classes</div>
    </div>
    <div class="stat-chip chip-sky">
        <div class="num"><?php echo $totalLecturers; ?></div>
        <div class="lbl">Total Lecturers</div>
    </div>
</div>

<div class="card">
    <div class="card-title">📚 Add New Student</div>
    <form method="POST">
        <div class="form-grid">
            <div class="form-group">
                <label>Student ID</label>
                <input type="text" name="id" placeholder="e.g. 2024001" required>
            </div>
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" placeholder="Enter name" required>
            </div>
            <div class="form-group">
                <label>Major</label>
                <select name="major" required>
                    <option value="">-- Select Major --</option>
                    <option value="Accounting">Accounting</option>
                    <option value="Civic Engineering">Civic Engineering</option>
                    <option value="Design Visual Communication">Design Visual Comm.</option>
                    <option value="Informatics Engineering">Informatics Engineering</option>
                    <option value="Information Systems">Information Systems</option>
                    <option value="Medicine">Medicine</option>
                </select>
            </div>
            <div class="form-group">
                <label>Class</label>
                <input type="text" name="class" placeholder="e.g. A / B / 3C" required>
            </div>
            <div class="form-group">
                <label>Hobby</label>
                <input type="text" name="hobby" placeholder="e.g. Reading" required>
            </div>
            <div class="form-group" style="justify-content:flex-end;">
                <button type="submit" name="add" class="btn btn-add">＋ Add Student</button>
            </div>
        </div>
    </form>
</div>

<div class="card">
    <div class="card-title">👨‍🏫 Add New Lecturer</div>
    <form method="POST">
        <div class="form-grid">
            <div class="form-group">
                <label>NIDN</label>
                <input type="text" name="nidn" placeholder="e.g. 1234567890" required>
            </div>
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" placeholder="Enter lecturer name" required>
            </div>
            <div class="form-group">
                <label>Major</label>
                <select name="major" required>
                    <option value="">-- Select Major --</option>
                    <option value="Accounting">Accounting</option>
                    <option value="Civic Engineering">Civic Engineering</option>
                    <option value="Design Visual Communication">Design Visual Comm.</option>
                    <option value="Informatics Engineering">Informatics Engineering</option>
                    <option value="Information Systems">Information Systems</option>
                    <option value="Medicine">Medicine</option>
                </select>
            </div>
            <div class="form-group">
                <label>Course</label>
                <input type="text" name="course" placeholder="e.g. Database Systems" required>
            </div>
            <div class="form-group" style="justify-content:flex-end;">
                <button type="submit" name="add_lecturer" class="btn btn-add-lecturer">＋ Add Lecturer</button>
            </div>
        </div>
    </form>
</div>

<div class="section-divider"></div>

<div class="table-toggle-container">
    <button type="button" class="tab-btn <?php echo $activeView === 'student' ? 'active' : ''; ?>" data-target="students-view" onclick="switchView('students-view', this)">👩‍🎓 View Students</button>
    <button type="button" class="tab-btn <?php echo $activeView === 'lecturer' ? 'active' : ''; ?>" data-target="lecturers-view" onclick="switchView('lecturers-view', this)">👨‍🏫 View Lecturers</button>
</div>

<div class="card">
    <div class="card-title" id="table-card-title">📁 Data Records</div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr id="student-headers" style="display: <?php echo $activeView === 'student' ? 'table-row' : 'none'; ?>;">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Major</th>
                    <th>Class</th>
                    <th>Hobby</th>
                    <th>Action</th>
                </tr>
                <tr id="lecturer-headers" style="display: <?php echo $activeView === 'lecturer' ? 'table-row' : 'none'; ?>;">
                    <th>NIDN</th>
                    <th>Name</th>
                    <th>Major</th>
                    <th>Course</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody id="students-view" class="view-section <?php echo $activeView === 'student' ? 'active-view' : ''; ?>">
            <?php if ($studentResult->num_rows === 0): ?>
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <span class="emoji">🌸</span>
                            No students found. Add one above!
                        </div>
                    </td>
                </tr>
            <?php else:
                while($row = $studentResult->fetch_assoc()): ?>
                <tr>
                    <td><span class="id-pill"><?php echo htmlspecialchars($row["id"]); ?></span></td>
                    <td><?php echo htmlspecialchars($row["name"]); ?></td>
                    <td><span class="major-badge"><?php echo htmlspecialchars($row["major"]); ?></span></td>
                    <td><span class="class-badge"><?php echo htmlspecialchars($row["class"]); ?></span></td>
                    <td><?php echo htmlspecialchars($row["hobby"]); ?></td>
                    <td>
                        <a href="?delete=<?php echo $row['id']; ?>&view=student"
                           onclick="return confirm('🌸 Delete this student?')">
                            <button class="btn-delete">✕ Delete</button>
                        </a>
                    </td>
                </tr>
            <?php endwhile; endif; ?>
            </tbody>

            <tbody id="lecturers-view" class="view-section <?php echo $activeView === 'lecturer' ? 'active-view' : ''; ?>">
            <?php if ($lecturerResult->num_rows === 0): ?>
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <span class="emoji">📖</span>
                            No lecturers found. Add one above!
                        </div>
                    </td>
                </tr>
            <?php else:
                while($row = $lecturerResult->fetch_assoc()): ?>
                <tr>
                    <td><span class="id-pill"><?php echo htmlspecialchars($row["NIDN"]); ?></span></td>
                    <td><?php echo htmlspecialchars($row["Name"]); ?></td>
                    <td><span class="major-badge"><?php echo htmlspecialchars($row["Major"]); ?></span></td>
                    <td><span class="course-badge"><?php echo htmlspecialchars($row["Course"]); ?></span></td>
                    <td>
                        <a href="?delete_lecturer=<?php echo urlencode($row['NIDN']); ?>&view=lecturer"
                           onclick="return confirm('📖 Delete this lecturer?')">
                            <button class="btn-delete">✕ Delete</button>
                        </a>
                    </td>
                </tr>
            <?php endwhile; endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function switchView(targetId, buttonElement) {
    // Hide all tbody blocks
    document.querySelectorAll('.view-section').forEach(tbody => {
        tbody.classList.remove('active-view');
    });
    
    // Deactivate all tab style classes
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });

    // Show the targeted elements
    document.getElementById(targetId).classList.add('active-view');
    buttonElement.classList.add('active');

    // Toggle specific headers & titles instantly
    const studentHeader = document.getElementById('student-headers');
    const lecturerHeader = document.getElementById('lecturer-headers');
    const cardTitle = document.getElementById('table-card-title');

    if (targetId === 'students-view') {
        studentHeader.style.display = 'table-row';
        lecturerHeader.style.display = 'none';
        cardTitle.innerText = '👩‍🎓 Registered Students';
    } else {
        studentHeader.style.display = 'none';
        lecturerHeader.style.display = 'table-row';
        cardTitle.innerText = '👨‍🏫 Registered Lecturers';
    }
}

// Fire once on window load to guarantee proper state titles match the active view
window.addEventListener('DOMContentLoaded', () => {
    const activeBtn = document.querySelector('.tab-btn.active');
    if(activeBtn) {
        switchView(activeBtn.getAttribute('data-target'), activeBtn);
    }
});
</script>

</body>
</html>
<?php $conn->close(); ?>