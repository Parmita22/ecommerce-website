<?php
include 'components/connection.php';
session_start();

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
    exit(); // Ensure the script stops executing after redirect
}

// Handle login
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL); // Correct filter for email
    $pass = $_POST['pass'];
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    // Check if the user exists
    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_user->execute([$email]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if ($select_user->rowCount() > 0) {
        // Verify password
        if (password_verify($pass, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            header('location: home.php');
            exit(); // Ensure the script stops executing after redirect
        } else {
            $message[] = 'Incorrect password';
        }
    } else {
        $message[] = 'Incorrect email or password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document - Login Page</title>
    <style type="text/css">
        <?php include 'style.css'; ?>
    </style>
</head>
<body>
    <div class="main-container">
        <section class="form-container">
            <div class="title">
                <h1>Login now</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque ut commodi eius.</p>
            </div>
            <form action="" method="post">
                <div class="input-field">
                    <p>Your email <sup>*</sup></p> 
                    <input type="email" name="email" required placeholder="Enter your email.." maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="input-field">
                    <p>Your password <sup>*</sup></p> 
                    <input type="password" name="pass" required placeholder="Enter your password.." maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <input type="submit" name="submit" value="Login now" class="btn">
                <p>Do not have an account? <a href="register.php">Register now</a></p>
            </form>
        </section>
    </div>
</body>
</html>
 