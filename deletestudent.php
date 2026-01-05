<?php
include 'db.php';

if (isset($_GET['id'])) {
    $grade_id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM grades WHERE grade_id=?");
    $stmt->bind_param("i", $grade_id);
    $stmt->execute();
    $stmt->close();
}

header("Location: index.php");
exit();
?>
