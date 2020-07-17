<?php include './includes/header.php';?>

<?php
    $stmt = $conn->prepare("SELECT * FROM questions");
    $stmt->execute();
    $totalQuestions = $stmt->rowCount();

    $stmt2 = $conn->prepare("SELECT * FROM questionnaires");
    $stmt2->execute();
    $totalQuestionnaires = $stmt2->rowCount();

    $stmt3 = $conn->prepare("SELECT DISTINCT user_email FROM user_answers");
    $stmt3->execute();
    $totalParticipants = $stmt3->rowCount();
?>

<div class="main-container mt-3">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>Dashboard</h3>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-4 text-center">
                <div class="d-box">
                    <h3>Total Number of Questions:</h3>
                    <p class="d-num"><?php echo $totalQuestions; ?></p>
                </div>
            </div>
            <div class="col-4 text-center">
                <div class="d-box">
                    <h3>Total Number of Questionnaires:</h3>
                    <p class="d-num"><?php echo $totalQuestionnaires; ?></p>
                </div>
            </div>
            <div class="col-4 text-center">
                <div class="d-box">
                    <h3>Total Number of Participants:</h3>
                    <p class="d-num"><?php echo $totalParticipants; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './includes/footer.php';?>