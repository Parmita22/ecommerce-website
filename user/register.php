<?php
    include 'components/connection.php';
    session_start();
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
    }else{
        $user_id = '';
    }
    if(isset($_POST['logout']))
    {
        session_destroy();
        header("location: login.php");
    }
    //register user
    if(isset($_POST['submit'])){
        $id = unique_id();
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $pass = $_POST['pass'];
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);
        $cpass = $_POST['cpass'];
        $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
    
        $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
        $select_user->execute([$email]);
        $row = $select_user->fetch(PDO::FETCH_ASSOC);
    
        if($select_user->rowCount() > 0){
            $message[] = 'Email already exists';
            echo 'Email already exists';
        } else {
            if($pass != $cpass){
                $message[] = 'Confirm your password';
                echo 'Confirm your password';
            } else {
                // Hash the password before storing it
                $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
                
                $insert_user = $conn->prepare("INSERT INTO `users` (id, name, email, password) VALUES(?, ?, ?, ?)");
                $insert_user->execute([$id, $name, $email, $hashed_pass]);
                
                // Verify if the user was successfully inserted
                $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
                $select_user->execute([$email]);
                $row = $select_user->fetch(PDO::FETCH_ASSOC);
                
                if($select_user->rowCount() > 0){
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['user_name'] = $row['name'];
                    $_SESSION['user_email'] = $row['email'];
                }
            }
        }
    }
    
?>

<style type="text/css">

<?php include 'style.css'; ?>

</style>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="main-container">
        <section class="form-container">
            <div class="title">
                <h1>register now</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque ut commodi eius.</p>
            </div>
            <form action="" method="post">
                <div class="input-field">
                    <p>your name <sup>*</sup> </p> 
                    <input type="text" name="name" required placeholder="Enter your name.." max-length="50">

                </div>
                <div class="input-field">
                    <p>your email <sup>*</sup> </p> 
                    <input type="email" name="email" required placeholder="Enter your email.." max-length="50" oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="input-field">
                    <p>your password <sup>*</sup> </p> 
                    <input type="password" name="pass" required placeholder="Enter your password.." max-length="50" oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="input-field">
                    <p>confirm password <sup>*</sup> </p> 
                    <input type="password" name="cpass" required placeholder="Enter your password.." max-length="50" oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <input type="submit" name="submit" value="register now" class="btn">
                <p>already have an account?<a href="login.php">login now</a></p>


            </form>
        </section>
    </div>
</body>
</html>