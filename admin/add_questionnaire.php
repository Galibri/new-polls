<?php include './includes/header.php';?>

<?php
    if (isset($_POST['questionnaire_submit'])) {
        $questionnaire = $_POST['questionnaire'];

        if ($questionnaire != '') {
            $stmt = $conn->prepare("INSERT INTO questionnaires (name) VALUES(:name)");

            $stmt->execute([
                'name' => $questionnaire
            ]);
            redirect('add_to_questionnaire.php?q_id=' . $conn->lastInsertId());
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
                            required="required">
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