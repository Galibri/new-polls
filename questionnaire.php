<?php include './includes/header.php';?>

<?php
    $email_error = '';
    $success_msg = '';
    if (isset($_GET['q_id'])) {
        $questionnaire_id = $_GET['q_id'];
        $stmt             = $conn->prepare("SELECT * FROM questionnaires WHERE id=:id");
        $stmt->execute([
            'id' => $questionnaire_id
        ]);
        if ($stmt->rowCount() == 0) {
            redirect('questionnaire.php');
        }
        $questionnaire = $stmt->fetch();
        if ($questionnaire['question_ids'] == null) {
            redirect('questionnaire.php');
        }
        $questions_ids_arr = explode(', ', $questionnaire['question_ids']);
        $question_str_id   = $questionnaire['question_ids'];

        $stmt = $conn->prepare("SELECT * FROM questions WHERE id IN ($question_str_id) ORDER BY id DESC");
        $stmt->execute(['is_global' => 1]);
        $questions = $stmt->fetchAll();

        // Add answer
        if (isset($_POST['front_answer_submit'])) {
            if ($_POST['email'] != '') {
                $polling_email             = $_POST['email'];
                $_SESSION['polling_email'] = $polling_email;

                // Check if user has already taken polls
                $stmt5 = $conn->prepare("SELECT * FROM user_q_answers WHERE user_email=:user_email AND questionnaire_id=:questionnaire_id");
                $stmt5->execute([
                    'user_email'       => $polling_email,
                    'questionnaire_id' => $questionnaire_id
                ]);
                if ($stmt5->rowCount() > 0) {
                    $email_error = 'You have already taken this survey.';
                } else {
                    if (isset($_POST['open'])) {
                        foreach ($_POST['open'] as $question_id => $openQuestion) {
                            if ($openQuestion != '') {
                                $stmt4 = $conn->prepare("INSERT INTO user_q_answers (questionnaire_id, user_email, question_id, free_answer) VALUES (:questionnaire_id, :user_email, :question_id, :free_answer)");
                                $stmt4->execute([
                                    'questionnaire_id' => $questionnaire_id,
                                    'user_email'       => $polling_email,
                                    'question_id'      => $question_id,
                                    'free_answer'      => $openQuestion
                                ]);
                            }
                        }
                    }

                    if (isset($_POST['radio'])) {
                        foreach ($_POST['radio'] as $question_id => $radioQuestion) {
                            $stmt4 = $conn->prepare("INSERT INTO user_q_answers (questionnaire_id, user_email, question_id, answer_id) VALUES (:questionnaire_id, :user_email, :question_id, :answer_id)");
                            $stmt4->execute([
                                'questionnaire_id' => $questionnaire_id,
                                'user_email'       => $polling_email,
                                'question_id'      => $question_id,
                                'answer_id'        => $radioQuestion
                            ]);
                        }
                    }

                    if (isset($_POST['check'])) {
                        foreach ($_POST['check'] as $question_id => $checkQuestions) {
                            foreach ($checkQuestions as $checkQuestion) {
                                $stmt4 = $conn->prepare("INSERT INTO user_q_answers (questionnaire_id, user_email, question_id, answer_id) VALUES (:questionnaire_id, :user_email, :question_id, :answer_id)");
                                $stmt4->execute([
                                    'questionnaire_id' => $questionnaire_id,
                                    'user_email'       => $polling_email,
                                    'question_id'      => $question_id,
                                    'answer_id'        => $checkQuestion
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
    } else {
        $questions = array();
        $stmt2     = $conn->prepare("SELECT * FROM questionnaires ORDER BY id DESC");
        $stmt2->execute();
        $questionnaires = $stmt2->fetchAll();
    }
?>

<main>

    <?php echo count($questions) > 0 ? "<h1>Questions</h1>" : "<h1>Questionnaires</h1>"; ?>
    <h4 class="text-danger text-center error-message"><?php echo $email_error; ?></h4>
    <h4 class="text-success text-center success-message"><?php echo $success_msg; ?></h4>

    <ul class="questions mt-3">
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
        <?php else: ?>
        <?php if (count($questionnaires) > 0): ?>
        <table class="table2">
            <tbody>
                <?php foreach ($questionnaires as $questionnaire): ?>
                <tr>
                    <td><?php echo $questionnaire['name']; ?></td>
                    <td><a href="questionnaire.php?q_id=<?php echo $questionnaire['id']; ?>" class="btn btn-info">View /
                            Take part in</a>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        <?php endif;?>
        <?php endif;?>
    </ul>


    <?php include './includes/footer.php';?>