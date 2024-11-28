<?php
    session_start();
    include 'db.php';

    //Redirect
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        if($_SESSION['role'] === 'admin'){
            header("Location: admin-dashboard.php");
        }
        else {
            header("Location: user-dashboard.php");
        }
        exit();
    }

    if(isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if(empty($username) || empty($password)) {
            $error = "All fields are required";
        }
        else {
            $sql = "SELECT * FROM users WHERE username = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);

                if(password_verify($password, $row['password'])) {
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['role'] = $row['role'];
                    $_SESSION['logged_in'] = true;

                    if($_SESSION['role'] === 'admin'){
                        header("Location: admin-dashboard.php");
                    }
                    else {
                        header("Location: user-dashboard.php");
                    }
                    exit();
                }
                else{
                    $error = "Wrong password";
                }
            }
            else {
                $error = "Username doesnt exist";
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
    <div><p>Login</p></div>
    <?php
    if(isset($error)) {
    ?>
    <div><?php echo $error ?></div>
    <?php } ?>

    <?php if(isset($_SESSION['success'])) { ?>
        <div> <?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php } ?>
    <form method="post">
        <input type="text" name="username" id="username" placeholder="Enter username">
        <input type="password" id="password" name="password" placeholder="Enter password">
        <button type="submit" id="submit" name="submit">Login</button>
    </form>
</body>
</html>