<?php include './includes/header.php';?>

<?php
    if (!isset($_GET['q_id'])) {
        redirect('questions.php');
    }

    $questionnaire_id = $_GET['q_id'];
    $stmt             = $conn->prepare("SELECT * FROM questionnaires WHERE id=:id");
    $stmt->execute([
        'id' => $questionnaire_id
    ]);

    if ($stmt->rowCount() == 0) {
        redirect('questions.php');
    }
    $questionnaire = $stmt->fetch();

    if (isset($_POST['questionnaire_submit'])) {
        $questionnaire = $_POST['questionnaire'];

        if ($questionnaire != '') {
            $stmt = $conn->prepare("UPDATE questionnaires SET name=:name WHERE id=:id");

            $stmt->execute([
                'name' => $questionnaire,
                'id'   => $questionnaire_id
            ]);
            redirect('edit_questionnaire.php?q_id=' . $questionnaire_id);
        }
    }
?>

<div class="main-container mt-3">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>Add a questionnaire</h3>
            </div>
        </div>
    </div>
    <div class="container mt-3">
        <div class="row">
            <div class="col-12">
                <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="POST">
                    <div class="form-group">
                        <label for="questionnaire">Name of Questionnaire</label>
                        <input type="text" name="questionnaire" id="questionnaire" class="form-control"
                            value="<?php echo $questionnaire['name']; ?>" required="required">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="questionnaire_submit" class="btn btn">Save and add
                            questions</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include './includes/footer.php';?>