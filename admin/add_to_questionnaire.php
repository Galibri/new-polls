<?php include './includes/header.php';?>

<?php
    if (!isset($_GET['q_id'])) {
        redirect('questionnaires.php');
    }

    $questionnaire_id = $_GET['q_id'];
    $stmt             = $conn->prepare("SELECT * FROM questionnaires WHERE id=:id");
    $stmt->execute([
        'id' => $questionnaire_id
    ]);

    if ($stmt->rowCount() == 0) {
        redirect('questionnaires.php');
    }
    $questionnaire = $stmt->fetch();

    $stmt2 = $conn->prepare("SELECT * FROM questions ORDER BY id DESC");
    $stmt2->execute();
    $questions = $stmt2->fetchAll();

    if (isset($_POST['questionnaire_submit'])) {
        if (array_key_exists('questionnaire', $_POST)) {
            $questions_id  = $_POST['questionnaire'];
            $questions_str = implode(', ', $questions_id);

            $stmt3 = $conn->prepare("UPDATE questionnaires SET question_ids=:questions_str WHERE id=:id");
            $stmt3->execute([
                'questions_str' => $questions_str,
                'id'            => $questionnaire_id
            ]);
            redirect('add_to_questionnaire.php?q_id=' . $questionnaire_id);
        }
    }

    if ($questionnaire['question_ids'] != null) {
        $question_id_arr = explode(',', $questionnaire['question_ids']);
    } else {
        $question_id_arr = array();
    }

?>

<div class="main-container mt-3">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>Add questions to questionnaire</h3>
            </div>
        </div>
    </div>
    <div class="container mt-3">
        <div class="row">
            <div class="col-12">
                <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="POST">
                    <?php foreach ($questions as $question): ?>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="questionnaire[<?php echo $question['id']; ?>]"
                                class="form-control"
                                <?php echo in_array($question['id'], $question_id_arr) ? "checked='checked'" : ''; ?>
                                value="<?php echo $question['id']; ?>"><?php echo $question['question']; ?>
                        </label>
                    </div>
                    <?php endforeach;?>

                    <div class="form-group">
                        <button type="submit" name="questionnaire_submit" class="btn btn">Save Questions</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include './includes/footer.php';?>