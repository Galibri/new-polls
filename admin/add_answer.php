<?php include './includes/header.php';?>

<?php
    $existingData = array();

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
    $question = $stmt->fetch();

    // Check if answer exists
    $stmt2 = $conn->prepare("SELECT * FROM answers WHERE question_id=:id");
    $stmt2->execute([
        'id' => $question_id
    ]);
    if ($stmt->rowCount() > 0) {
        $existingData = $stmt2->fetchAll();
    }

    if (isset($_POST['answer_submit'])) {
        unset($_POST['answer_submit']);
        foreach ($_POST as $answer) {
            $stmt = $conn->prepare("INSERT INTO answers (question_id, answer) VALUES(:question_id, :answer)");
            $stmt->execute([
                'question_id' => $question['id'],
                'answer'      => $answer
            ]);
        }
        redirect('questions.php');
    }

    if (isset($_POST['answer_update_submit'])) {
        unset($_POST['answer_update_submit']);
        $update_arr = $_POST['answer'][$question_id];
        // dd($update_arr);
        foreach ($update_arr as $key => $updated_ans) {
            $stmt2 = $conn->prepare("UPDATE answers SET answer=:answer WHERE id=:id");
            $stmt2->execute([
                'id'     => $key,
                'answer' => $updated_ans
            ]);
        }
        redirect('add_answer.php?q_id=' . $question_id);
    }

    // Additional answer
    if (isset($_POST['new_answer_submit'])) {
        if ($_POST['new_answer'] != '') {
            $stmt = $conn->prepare("INSERT INTO answers (question_id, answer) VALUES(:question_id, :answer)");
            $stmt->execute([
                'question_id' => $question_id,
                'answer'      => $_POST['new_answer']
            ]);

            $stmt2 = $conn->prepare("UPDATE questions SET number_of_ans=:number_of_ans WHERE id=:id");
            $stmt2->execute([
                'id'            => $question['id'],
                'number_of_ans' => ($question['number_of_ans'] + 1)
            ]);

            redirect('add_answer.php?q_id=' . $question_id);
        }
    }
?>

<div class="main-container mt-3">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php echo count($existingData) > 0 ? '<h3>Edit answer</h3>' : '<h3>Add answer</h3>'; ?>
                <h4 class="mt-3">Question:<?php echo $question['question']; ?></h4>
            </div>
        </div>
    </div>
    <div class="container mt-3">
        <div class="row">
            <div class="col-12">
                <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="POST">
                    <?php if (count($existingData) > 0): ?>
                    <?php foreach ($existingData as $key => $data): ?>
                    <div class="form-group">
                        <label for="answer_<?php echo $data['id']; ?>">Answer number
                            &nbsp;<?php echo $key + 1; ?></label>
                        <table class="table-2">
                            <tbody>
                                <tr>
                                    <td><input type="text"
                                            name="answer[<?php echo $data['question_id']; ?>][<?php echo $data['id']; ?>]"
                                            id="answer_<?php echo $data['id']; ?>" class="form-control"
                                            value="<?php echo $data['answer'] ?>"></td>
                                    <td><a href="delete_answer.php?id=<?php echo $data['id']; ?>&q_id=<?php echo $data['question_id']; ?>"
                                            class="btn-danger">Delete</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php endforeach;?>
                    <div class="form-group">
                        <button type="submit" name="answer_update_submit" class="btn btn">Update answers</button>
                    </div>
                    <?php else: ?>
                    <?php for ($i = 1; $i <= $question['number_of_ans']; $i++): ?>
                    <div class="form-group">
                        <label for="answer_<?php echo $i; ?>">Answer number &nbsp;<?php echo $i; ?></label>
                        <input type="text" name="ans_<?php echo $i; ?>" id="answer_<?php echo $i; ?>"
                            class="form-control">
                    </div>
                    <?php endfor;?>
                    <div class="form-group">
                        <button type="submit" name="answer_submit" class="btn btn">Save answers</button>
                    </div>
                    <?php endif;?>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <?php if (count($existingData) > 0): ?>
                <h3>Add another answer</h3>
                <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                    <div class="form-group">
                        <label for="new_answer">Append answer</label>
                        <input type="text" name="new_answer" id="new_answer" class="form-control">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="new_answer_submit" class="btn btn">Save answers</button>
                    </div>
                </form>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>

<?php include './includes/footer.php';?>