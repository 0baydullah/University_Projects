<?php
    include_once "../db/db.php";

    if( isset( $_GET['login'] ) ){
        $username = $_GET['username'];
        $password = $_GET['password'];

        $sql = $connection->prepare( "SELECT * FROM users" );
        $sql->execute();

        while( $row = $sql->fetch() ){
            $dbusername = $row['username'];
            $dbpassword = $row['password'];

            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;

        }

        if( $username == $dbusername && $password == $dbpassword ){
            header( "Location: index.php" );
        }else{
            echo '<div class="alert alert-danger alert-box" role="alert">
                    Username or Password is incorrect.
                </div>';
        }

    }

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/admin.css" />
    
</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-4"></div>
        <div class="col-4">
            <form action="" method="GET">
                <div class="form-group">
                    <label for="">Username</label>
                    <input type="text" name="username" class="form-control" require>
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" name="password" class="form-control" require>
                </div>
                <button type="submit" class="btn btn-primary" name="login">Submit</button>
            </form>
        </div>
        <div class="col-4"></div>
    </div>
</div>

</body>