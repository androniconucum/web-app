<?php
    session_start();
    include 'db.php';

    if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !==true || $_SESSION['role'] !== 'admin') {
        header("Location: index.php");
        exit();
    }

    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .table th, .table td {
            padding: 10px;
        }
    </style>
</head>
<body>
    <p>HELLO</p>
    <table class="table">
        <thread>
            <tr>Id</tr>
            <tr>Username</tr>
            <tr>Email</tr>
            <tr>Role</tr>
            <tr>Actions</tr>
        </thread>
        <tbody>
            <?php foreach($user as $user) { ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['username'] ?></td>
                    <td><?php echo $user['password'] ?></td>
                    <td><?php echo $user['role'] ?></td>
                    <td></td>
                </tr>
                <?php } ?>
        </tbody>
    </table>
</body>
<a href="logout.php">Logout now</a>
</html>