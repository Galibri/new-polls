<?php include './includes/header.php';?>

<?php
    $email_error = '';
    $success_msg = '';
    $stmt        = $conn->prepare("SELECT * FROM questions WHERE is_global=:is_global ORDER BY id DESC");
    $stmt->execute(['is_global' => 1]);
    $questions = $stmt->fetchAll();

    if (isset($_POST['front_answer_submit'])) {
        if ($_POST['email'] != '') {
            $polling_email             = $_POST['email'];
            $_SESSION['polling_email'] = $polling_email;

            // Check if user has already taken polls
            $stmt5 = $conn->prepare("SELECT * FROM user_answers WHERE user_email=:user_email");
            $stmt5->execute([
                'user_email' => $polling_email
            ]);
            if ($stmt5->rowCount() > 0) {
                $email_error = 'You have already taken this survey.';
            } else {
                if (isset($_POST['open'])) {
                    foreach ($_POST['open'] as $question_id => $openQuestion) {
                        if ($openQuestion != '') {
                            $stmt4 = $conn->prepare("INSERT INTO user_answers (user_email, question_id, free_answer) VALUES (:user_email, :question_id, :free_answer)");
                            $stmt4->execute([
                                'user_email'  => $polling_email,
                                'question_id' => $question_id,
                                'free_answer' => $openQuestion
                            ]);
                        }
                    }
                }

                if (isset($_POST['radio'])) {
                    foreach ($_POST['radio'] as $question_id => $radioQuestion) {
                        $stmt4 = $conn->prepare("INSERT INTO user_answers (user_email, question_id, answer_id) VALUES (:user_email, :question_id, :answer_id)");
                        $stmt4->execute([
                            'user_email'  => $polling_email,
                            'question_id' => $question_id,
                            'answer_id'   => $radioQuestion
                        ]);
                    }
                }

                if (isset($_POST['check'])) {
                    foreach ($_POST['check'] as $question_id => $checkQuestions) {
                        foreach ($checkQuestions as $checkQuestion) {
                            $stmt4 = $conn->prepare("INSERT INTO user_answers (user_email, question_id, answer_id) VALUES (:user_email, :question_id, :answer_id)");
                            $stmt4->execute([
                                'user_email'  => $polling_email,
                                'question_id' => $question_id,
                                'answer_id'   => $checkQuestion
                            ]);
                        }
                    }
                }
                $success_msg = "Your answer were submitted successfully";
            }
        } else {
            $email_error = "Please provide an email address to take part.";
        }
    }
?>

<main>

    <h1>Questions</h1>
    <h4 class="text-danger text-center error-message"><?php echo $email_error; ?></h4>
    <h4 class="text-success text-center success-message"><?php echo $success_msg; ?></h4>

    <ul class="questions">
        <?php if (count($questions) > 0): ?>
        <form class="question-form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                    value="<?php echo isset($_SESSION['polling_email']) ? $_SESSION['polling_email'] : ''; ?>"
                    require="required">
            </div>
            <?php foreach ($questions as $index => $question): ?>
            <li>
                <h2>Question <?php echo $index + 1; ?></h2>
                <h3><?php echo $question['question'] ?></h3>
                <?php $answers = get_answers_by_question_id($question['id']);?>
                <?php if ($question['type'] == 3): ?>
                <label>Answer:</label>
                <textarea name="open[<?php echo $question['id']; ?>]"></textarea>
                <?php elseif ($question['type'] == 2): ?>
                <?php foreach ($answers as $answer): ?>

                <div class="form-group check-input">
                    <input type="checkbox" id="answer_<?php echo $answer['id']; ?>"
                        name="check[<?php echo $question['id'] ?>][<?php echo $answer['id'] ?>]"
                        value="<?php echo $answer['id'] ?>" /><label
                        for="answer_<?php echo $answer['id']; ?>"><?php echo $answer['answer'] ?></label>
                </div>
                <?php endforeach;?>
                <?php else: ?>
                <?php if (count($answers)): ?>
                <?php foreach ($answers as $answer): ?>
                <div class="form-group check-input">
                    <input type="radio" id="answer_<?php echo $answer['id']; ?>"
                        name="radio[<?php echo $question['id'] ?>]" value="<?php echo $answer['id'] ?>" />
                    <label for="answer_<?php echo $answer['id']; ?>"><?php echo $answer['answer'] ?></label>
                </div>
                <?php endforeach;?>
                <?php endif;?>
                <?php endif;?>


            </li>
            <?php endforeach;?>
            <input type="submit" name="front_answer_submit" value="Submit" />
        </form>
        <?php endif;?>
    </ul>


    <?php include './includes/footer.php';?>