<?php
include 'db.php';

if (isset($_GET['id'])) {
    $grade_id = $_GET['id'];

    $sql = "SELECT g.grade_id, g.final_grade,
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
    $row = $result->fetch_assoc();
}

if (isset($_POST['update'])) {
    $grade_id = $_POST['grade_id'];
    $final_grade = $_POST['final_grade'];

    $stmt = $conn->prepare(
        "UPDATE grades SET final_grade=? WHERE grade_id=?"
    );
    $stmt->bind_param("di", $final_grade, $grade_id);
    $stmt->execute();

    header("Location: index.php");
    exit();
}
?>

<h2>Edit Grade</h2>
<form method="POST">
    <input type="hidden" name="grade_id" value="<?= $row['grade_id'] ?>">

    <p><strong>Student:</strong>
        <?= $row['first_name'] . " " . $row['last_name'] ?>
    </p>

    <p><strong>Subject:</strong>
        <?= $row['subject_name'] ?>
    </p>

    <label>Final Grade</label>
    <input type="number" name="final_grade"
           step="0.01"
           value="<?= $row['final_grade'] ?>" required>

    <button type="submit" name="update">Update</button>
</form>
