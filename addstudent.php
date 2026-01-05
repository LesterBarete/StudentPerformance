<?php
include 'db.php';

if (isset($_POST['submit'])) {

    $first_name    = $_POST['first_name'];
    $last_name     = $_POST['last_name'];
    $course        = $_POST['course'];
    $year_level    = $_POST['year_level'];
    $subject       = $_POST['subject'];
    $final_grade   = $_POST['final_grade'];
    $semester      = $_POST['semester'];
    $academic_year = $_POST['academic_year'];

    // 1️⃣ Insert student
    $stmt = $conn->prepare(
        "INSERT INTO students (first_name, last_name, course, year_level)
         VALUES (?, ?, ?, ?)"
    );
    $stmt->bind_param("sssi", $first_name, $last_name, $course, $year_level);
    $stmt->execute();

    $student_id = $stmt->insert_id;
    $stmt->close();

    // 2️⃣ Check if subject exists
    $stmt = $conn->prepare("SELECT subject_id FROM subjects WHERE subject_name=?");
    $stmt->bind_param("s", $subject);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $subject_id = $row['subject_id'];
    } else {
        // Insert new subject
        $stmt2 = $conn->prepare(
            "INSERT INTO subjects (subject_name) VALUES (?)"
        );
        $stmt2->bind_param("s", $subject);
        $stmt2->execute();
        $subject_id = $stmt2->insert_id;
        $stmt2->close();
    }
    $stmt->close();

    // 3️⃣ Insert grade
    $stmt = $conn->prepare(
        "INSERT INTO grades (student_id, subject_id, final_grade, semester, academic_year)
         VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->bind_param(
        "iidss",
        $student_id,
        $subject_id,
        $final_grade,
        $semester,
        $academic_year
    );
    $stmt->execute();
    $stmt->close();

    header("Location: index.php");
    exit();
}
?>
