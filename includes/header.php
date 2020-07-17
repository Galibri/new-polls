<?php include './functions.php';?>
<!DOCTYPE html>
<html>

<head>
    <title>iPoll System</title>
    <link rel="stylesheet" href="assets/Chart.min.css" />
    <link rel="stylesheet" href="ipoll.css" />
    <script src="assets/jquery-1.12.4.min.js"></script>
    <script src="assets/Chart.min.js"></script>
    <script src="assets/custom.js"></script>
</head>

<body>
    <header>
        <h1><span class="i">i</span><span class="b">P</span><span class="u">o</span><span class="y">l</span><span
                class="i">l</span></h1>
        <div class="navbar">
            <ul class="nav-menu float-right">
                <li><a class="<?php echo nav_active_class('index.php'); ?>" href="<?php echo home_url(); ?>">Home</a>
                </li>
                <li><a class="<?php echo nav_active_class('questionnaire.php'); ?>"
                        href="<?php echo home_url() . 'questionnaire.php'; ?>">Questionnaire</a></li>
                <li><a class="<?php echo nav_active_class('results.php'); ?>"
                        href="<?php echo home_url() . 'results.php'; ?>">Results</a></li>
                <?php if (is_user_logged_in()): ?>
                <li><a href="<?php echo admin_url(); ?>">Dashboard</a></li>
                <?php else: ?>
                <li><a href="<?php echo home_url() . 'login.php'; ?>">Login</a></li>
                <?php endif;?>
            </ul>
        </div>

    </header>
    <img src="images/randombanner.php" alt="Banner" />