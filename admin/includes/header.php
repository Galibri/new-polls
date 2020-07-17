<?php
    include './functions.php';
    if (!is_user_logged_in()) {
        redirect(home_url());
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin iPolls</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>

<body>
    <section class="admin-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ul class="admin-nav">
                        <li><a class="<?php echo nav_active_class('index.php'); ?>"
                                href="<?php echo admin_url(); ?>">Dashboard</a></li>
                        <li><a class="<?php echo nav_active_class('add_question.php'); ?>" href="add_question.php">Add
                                Question</a></li>
                        <li><a class="<?php echo nav_active_class('questions.php'); ?>"
                                href="questions.php">Questions</a></li>
                        <li><a class="<?php echo nav_active_class('questionnaires.php'); ?>"
                                href="questionnaires.php">Questionnaires</a></li>
                        <li><a href="<?php echo home_url() . '/logout.php'; ?>">Logout</a></li>
                    </ul>

                    <a href="<?php echo home_url(); ?>" class="btn btn-info admin-bar-btn" target="_blank">Home</a>
                </div>
            </div>
        </div>
    </section>