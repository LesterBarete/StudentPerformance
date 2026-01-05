<?php
include 'db.php';

$sql = "SELECT g.grade_id, s.student_id,
               CONCAT(s.first_name,' ',s.last_name) AS name,
               sub.subject_name,
               g.final_grade,
               g.semester,
               g.academic_year
        FROM grades g
        JOIN students s ON g.student_id = s.student_id
        JOIN subjects sub ON g.subject_id = sub.subject_id
        ORDER BY s.student_id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Performance Tracker</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Student Performance Tracker</h1>

<button id="openFormBtn">Add Student</button>

<!-- MODAL -->
<div id="studentFormModal" class="modal">
  <div class="modal-content">
    <span id="closeModal" class="close">&times;</span>

    <form action="addstudent.php" method="POST">
        <input name="first_name" placeholder="First Name" required>
        <input name="last_name" placeholder="Last Name" required>
        <input name="course" placeholder="Course" required>
        <input name="year_level" type="number" placeholder="Year Level" required>
        <input name="subject" placeholder="Subject" required>
        <input name="final_grade" step="0.01" placeholder="Final Grade" required>
        <input name="semester" placeholder="Semester" required>
        <input name="academic_year" placeholder="2025-2026" required>

        <button type="submit" name="submit">Add Student</button>
    </form>
  </div>
</div>

<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Subject</th>
    <th>Grade</th>
    <th>Semester</th>
    <th>Year</th>
    <th>Actions</th>
</tr>


<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= $row['student_id'] ?></td>
    <td><?= $row['name'] ?></td>
    <td><?= $row['subject_name'] ?></td>
    <td><?= $row['final_grade'] ?></td>
    <td><?= $row['semester'] ?></td>
    <td><?= $row['academic_year'] ?></td>
    <td>
        <a href="editstudent.php?id=<?= $row['grade_id'] ?>">Edit</a> |
        <a href="deletestudent.php?id=<?= $row['grade_id'] ?>"
           onclick="return confirm('Delete this record?')">
           Delete
        </a>
    </td>
</tr>

<?php endwhile; ?>

</table>

<script src="script.js"></script>
</body>
</html>
