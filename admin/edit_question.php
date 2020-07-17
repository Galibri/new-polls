<?php include './includes/header.php';?>

<?php
    if (!isset($_GET['q_id'])) {
        redirect('questions.php');
    }

    $question_id = $_GET['q_id'];
    $stmt        = $conn->prepare("SELECT * FROM questions WHERE id=:id");
    $stmt->execute([
        'id' => $question_id
    ]);

    if ($stmt->rowCount() == 0) {
        redirect('questions.php');
    }
    $db_question = $stmt->fetch();
    if ($db_question['type'] == 3) {
        redirect('questions.php');
    }

    if (isset($_POST['question_submit'])) {
        $question      = $_POST['question'];
        $type          = $_POST['type'];
        $is_global     = $_POST['is_global'];
        $number_of_ans = $_POST['number_of_ans'];

        if ($question != '') {
            $stmt = $conn->prepare("UPDATE questions SET question=:question, type=:type, is_global=:is_global WHERE id=:question_id");

            $stmt->execute([
                'question'    => $question,
                'type'        => $type,
                'is_global'   => $is_global,
                'question_id' => $question_id
            ]);
            redirect('edit_question.php?q_id=' . $question_id);
        }
    }
?>

<div class="main-container mt-3">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>Edit question</h3>
                <h4 class="mt-3">Question:<?php echo $db_question['question']; ?></h4>
            </div>
        </div>
    </div>
    <div class="container mt-3">
        <div class="row">
            <div class="col-12">
                <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="POST">
                    <div class="form-group">
                        <label for="question">Type your question</label>
                        <input type="text" name="question" id="question" class="form-control" required="required"
                            value="<?php echo $db_question['question']; ?>">
                    </div>
                    <div class="form-group">
                        <div class="choice">Question Type</div>
                        <label>
                            <input type="radio" name="type" value="1" class="form-control"
                                <?php echo $db_question['type'] == 1 ? "checked='checked'" : ""; ?>>Multiple
                            choice (One answer)
                        </label>
                        <label>
                            <input type="radio" name="type" value="2" class="form-control"
                                <?php echo $db_question['type'] == 2 ? "checked='checked'" : ""; ?>>Multiple choice
                            (Multi
                            answer)
                        </label>
                        <label>
                            <input type="radio" name="type" value="3" class="form-control"
                                <?php echo $db_question['type'] == 3 ? "checked='checked'" : ""; ?>>Free hand textarea
                        </label>
                    </div>
                    <div class="form-group">
                        <div class="choice">Global Question?</div>
                        <label>
                            <input type="radio" name="is_global" value="1" class="form-control"
                                <?php echo $db_question['is_global'] == 1 ? "checked='checked'" : ""; ?>>Yes
                        </label>
                        <label>
                            <input type="radio" name="is_global" value="0" class="form-control"
                                <?php echo $db_question['is_global'] == 0 ? "checked='checked'" : ""; ?>>No
                        </label>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="question_submit" class="btn btn">Save question</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include './includes/footer.php';?>