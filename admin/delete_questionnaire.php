<?php
include './functions.php';

if (!isset($_GET['q_id'])) {
    redirect(home_url());
}

$q_id = $_GET['q_id'];

$stmt = $conn->prepare("DELETE FROM questionnaires WHERE id=:id");
$res  = $stmt->execute(['id' => $q_id]);

redirect('questionnaires.php');
die();