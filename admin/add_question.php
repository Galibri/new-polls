<?php include './includes/header.php';?>

<?php
    if (isset($_POST['question_submit'])) {
        $question      = $_POST['question'];
        $type          = $_POST['type'];
        $is_global     = $_POST['is_global'];
        $number_of_ans = $_POST['number_of_ans'];

        if ($question != '') {
            $stmt = $conn->prepare("INSERT INTO questions (user_id, question, type, is_global, number_of_ans, added_on) VALUES(:user_id, :question, :type, :is_global, :number_of_ans, :added_on)");

            $stmt->execute([
                'user_id'       => $_SESSION['user_id'],
                'question'      => $question,
                'type'          => $type,
                'is_global'     => $is_global,
                'number_of_ans' => $number_of_ans,
                'added_on'      => date('Y-m-d H:i:s')
            ]);
            if ($type == 3) {
                redirect('questions.php');
            } else {
                redirect('add_answer.php?q_id=' . $conn->lastInsertId());
            }
        }
    }
?>

<div class="main-container mt-3">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>Add a question</h3>
            </div>
        </div>
    </div>
    <div class="container mt-3">
        <div class="row">
            <div class="col-12">
                <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="POST">
                    <div class="form-group">
                        <label for="question">Type your question</label>
                        <input type="text" name="question" id="question" class="form-control" required="required">
                    </div>
                    <div class="form-group">
                        <div class="choice">Question Type</div>
                        <label>
                            <input type="radio" name="type" value="1" class="form-control" checked="checked">Multiple
                            choice (One answer)
                        </label>
                        <label>
                            <input type="radio" name="type" value="2" class="form-control">Multiple choice (Multi
                            answer)
                        </label>
                        <label>
                            <input type="radio" name="type" value="3" class="form-control">Free hand textarea
                        </label>
                    </div>
                    <div class="form-group">
                        <div class="choice">Global Question?</div>
                        <label>
                            <input type="radio" name="is_global" value="1" class="form-control" checked="checked">Yes
                        </label>
                        <label>
                            <input type="radio" name="is_global" value="0" class="form-control">No
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="number_of_ans">Number of answers</label>
                        <input type="number" min="1" name="number_of_ans" id="number_of_ans" class="form-control"
                            value="1" required="required">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="question_submit" class="btn btn">Save and add answers</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include './includes/footer.php';?>