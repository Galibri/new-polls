<?php
include './functions.php';

if (!isset($_GET['q_id'])) {
    redirect(home_url());
}

$q_id = $_GET['q_id'];

$stmt = $conn->prepare("DELETE FROM answers WHERE question_id=:id");
$res  = $stmt->execute(['id' => $q_id]);

$stmt2 = $conn->prepare("DELETE FROM questions WHERE id=:id");
$res   = $stmt2->execute(['id' => $q_id]);

redirect('questions.php');
die();