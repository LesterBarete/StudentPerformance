<?php
include 'db.php';

if (!isset($_GET['id'])) {
    die("Invalid request: missing ID.");
}

$grade_id = $_GET['id'];

$sql = "SELECT g.grade_id, g.final_grade, g.semester, g.academic_year,
               s.first_name, s.last_name,
               sub.subject_name
        FROM grades g
        JOIN students s ON g.student_id = s.student_id
        JOIN subjects sub ON g.subject_id = sub.subject_id
        WHERE g.grade_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $grade_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("No record found for this grade ID.");
}

$row = $result->fetch_assoc();

if (isset($_POST['update'])) {
    $final_grade = $_POST['final_grade'];
    $semester = $_POST['semester'];
    $academic_year = $_POST['academic_year'];

    $stmt = $conn->prepare(
        "UPDATE grades SET final_grade=?, semester=?, academic_year=? WHERE grade_id=?"
    );
    $stmt->bind_param("dssi", $final_grade, $semester, $academic_year, $grade_id);
    $stmt->execute();

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Grade</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Modal for Edit Grade -->
<div id="editFormModal" class="modal" style="display:block;">
  <div class="modal-content">
      <span id="closeEditModal" class="close">&times;</span>
      <h2>Edit Grade</h2>
      <form action="editstudent.php?id=<?php echo $row['grade_id']; ?>" method="POST">
          <input type="hidden" name="grade_id" value="<?php echo $row['grade_id']; ?>">

          <label>Student Name</label>
          <input type="text" value="<?php echo $row['first_name'].' '.$row['last_name']; ?>" disabled>

          <label>Subject</label>
          <input type="text" value="<?php echo $row['subject_name']; ?>" disabled>

          <label>Final Grade</label>
          <input type="number" name="final_grade" value="<?php echo $row['final_grade']; ?>" step="0.01" required>

          <label>Semester</label>
          <input type="text" name="semester" value="<?php echo $row['semester']; ?>" required>

          <label>Academic Year</label>
          <input type="text" name="academic_year" value="<?php echo $row['academic_year']; ?>" required>

          <button type="submit" name="update">Update</button>
      </form>
  </div>
</div>

<script>
const editModal = document.getElementById('editFormModal');
const closeEditBtn = document.getElementById('closeEditModal');

// Close modal and redirect to index
closeEditBtn.onclick = () => window.location.href = 'index.php';
window.onclick = (event) => {
    if (event.target === editModal) window.location.href = 'index.php';
};
</script>

</body>
</html>
