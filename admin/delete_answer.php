<?php
include './functions.php';

if (!isset($_GET['id']) || !isset($_GET['q_id'])) {
    redirect(home_url());
}

$a_id = $_GET['id'];
$q_id = $_GET['q_id'];

$stmt = $conn->prepare("DELETE FROM answers WHERE id=:id");
$res  = $stmt->execute(['id' => $a_id]);

$stmt2 = $conn->prepare("UPDATE questions SET number_of_ans=number_of_ans-:number_of_ans WHERE id=:id");
$stmt2->execute([
    'id'            => $q_id,
    'number_of_ans' => 1
]);

redirect('add_answer.php?q_id=' . $q_id);
die();