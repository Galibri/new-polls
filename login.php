<?php include './includes/header.php';?>
<?php
    $error = '';
    if (isset($_POST['login_submit'])) {
        $email    = $_POST['email'];
        $password = md5($_POST['password']);
        $stmt     = $conn->prepare("SELECT * FROM users WHERE email=:email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        if ($stmt->rowCount() > 0) {
            if ($user['password'] == $password) {
                $_SESSION['user_id'] = $user['id'];
                if ($user['is_admin'] == 1) {
                    redirect(admin_url());
                } else {
                    redirect(home_url());
                }
            } else {
                $error = "Password did not match.";
            }
        } else {
            $error = "Email doesn't exists";
        }
    }
?>

<main>
    <h1 class="text-center">Login</h1>
    <p class="text-center"><?php echo $error; ?></p>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="login-form" method="POST">
        <div class="input-wrap">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="email"
                value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
        </div>
        <div class="input-wrap">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="password">
        </div>
        <div class="input-wrap">
            <button type="submit" name="login_submit" class="btn btn-login">Login</button>
        </div>
    </form>
</main>

<?php include './includes/footer.php';?>