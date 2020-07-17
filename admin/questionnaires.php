<?php include './includes/header.php';?>

<?php

    $stmt = $conn->prepare("SELECT * FROM questionnaires ORDER BY id DESC");
    $stmt->execute();
    $questionnaires = $stmt->fetchAll();
?>

<div class="main-container mt-3">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>All Questionnaires</h3>
                <a href="add_questionnaire.php" class="btn-danger">Add New Questionnaire</a>
            </div>
        </div>
    </div>
    <div class="container mt-3">
        <div class="row">
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($questionnaires) > 0): ?>
                        <?php foreach ($questionnaires as $questionnaire): ?>
                        <tr>
                            <td><?php echo $questionnaire['name']; ?></td>
                            <td style="width: 300px;">
                                <a href="edit_questionnaire.php?q_id=<?php echo $questionnaire['id'] ?>"
                                    class="btn-warning">Edit</a>
                                <a href="delete_questionnaire.php?q_id=<?php echo $questionnaire['id'] ?>"
                                    class="btn-danger">Delete</a>
                                <a href="add_to_questionnaire.php?q_id=<?php echo $questionnaire['id'] ?>"
                                    class="btn-info">Add/Remove
                                    questions</a>
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