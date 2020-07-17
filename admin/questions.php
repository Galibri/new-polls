<?php include './includes/header.php';?>

<?php

    $stmt = $conn->prepare("SELECT * FROM questions ORDER BY id DESC");
    $stmt->execute();
    $questions = $stmt->fetchAll();
?>

<div class="main-container mt-3">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>All Questions</h3>
            </div>
        </div>
    </div>
    <div class="container mt-3">
        <div class="row">
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Question</th>
                            <th>Type</th>
                            <th>Number of answers</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($questions) > 0): ?>
                        <?php foreach ($questions as $question): ?>
                        <tr>
                            <td><?php echo $question['question']; ?></td>
                            <td>
                                <?php
                                    if ($question['type'] == 1) {
                                        echo "Multiple choice (One answer)";
                                    } elseif ($question['type'] == 2) {
                                        echo "Multiple choice (Multi answer)";
                                    } elseif ($question['type'] == 3) {
                                        echo "Free hand textarea";
                                    }
                                ?>
                            </td>
                            <td><?php echo $question['number_of_ans']; ?></td>
                            <td>
                                <a href="edit_question.php?q_id=<?php echo $question['id'] ?>"
                                    class="btn-warning">Edit</a>
                                <a href="delete_question.php?q_id=<?php echo $question['id'] ?>"
                                    class="btn-danger">Delete</a>
                                <?php if ($question['type'] != 3): ?>
                                <a href="add_answer.php?q_id=<?php echo $question['id'] ?>" class="btn-info">Add/Edit
                                    answers</a>
                                <?php endif;?>
                            </td>
                        </tr>
                        <?php endforeach;?>
                        <?php endif;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include './includes/footer.php';?>