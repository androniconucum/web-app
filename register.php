<?php
session_start();
include 'db.php';

if(isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $role = $_POST['role'];


    if(empty($username) || empty($password) || empty($email) || empty($role)) {
        $error = "All fields are required";
    }
    elseif(!preg_match("/^(?=.*[A-Z])(?=.*\d)/", $username)) {
        $error = "Username must have a capital letter and a number";
    }
    elseif(!preg_match("/^(?=.*[A-Z])(?=.*\d)(?=.*[@._\/!])/", $password)) {
        $error = "Password mus have a capital letter, a number and a special character";
    }
    else {
        $checkUsername = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
        $checkEmail = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

        if(mysqli_num_rows($checkUsername) > 0) {
            $error = "Username not available";
        }
        elseif(mysqli_num_rows($checkEmail) > 0) {
            $error = "Email already used!";
        }
        else {
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users(username, password, email, role) VALUES('$username', '$hashPassword', '$email', '$role')";

            if(mysqli_query($conn, $sql)) {
                $_SESSION['success'] = "Registration Successful";
                header("Location: register.php");
                exit();
            }
            else {
                $error = "error: " . mysqli_error($conn);
            }
        }
    }
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div><p>Register</p></div>
    <?php if(isset($error)) {?>
        <div><?php echo $error ?></div>
        <?php } ?>
    
    <?php if(isset($_SESSION['success'])) { ?>
        <div><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php } ?>
    <form method="post">
        <input type="text" name="username"  placeholder="Enter username">
        <input type="password" name="password" placeholder="Enter password">
        <input type="email" name="email" placeholder="Enter email">
        <select name="role" id="role">
            <option value="user">user</option>
            <option value="admin">admin</option>
        </select>
        <button type="submit" name="submit">Register</button>
    </form>
    <a href="index.php">Login now</a>
</body>
</html>