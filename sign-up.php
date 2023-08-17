<?php require_once 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>
<?php
    require_once 'auth.php';
    if (is_connected()) {   
        header('Location: index.php');
    }
?>
<?php

function username_is_already_existe($connexion, $username) {
    $result = mysqli_query($connexion, "SELECT * FROM users WHERE username = '$username'");
    if ($result->num_rows == 0) {
        return false;
    } else {
        return true;
    }
}


?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="bootstrap/bootstrap.min.js"></script>
    <title> Connexion </title>
</head>
<body>
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom"> 
        <a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none"> 
            <span class="fs-4">Livres</span> 
        </a>
        <ul class="nav nav-pills"> 
            <li class="nav-item"><a href="login.php" class="nav-link">Se connecter</a></li> 
        </ul> 
    </header>
    <?php if(!empty($_SESSION['message'])) { ?>
        <?php if ($_SESSION['message-type'] == 'Success') { ?>
            <div class="alert alert-success d-flex align-items-center" role="alert" style="margin: 10px 150px 20px;">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                    <use xlink:href="#check-circle-fill"/></use>
                </svg>
                <div>
                    <?php 
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                        unset($_SESSION['message-type']);
                    ?>
                </div> 
            </div>
            <?php } else { ?>
            <div class="alert alert-danger d-flex align-items-center" role="alert" style="margin: 10px 150px 20px;">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                    <use xlink:href="#exclamation-triangle-fill"/>
                </svg>
                <div>
                    <?php 
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                        unset($_SESSION['message-type']);
                    ?>
                </div>
            </div>
            <?php } ?>  
        <?php } ?>
    <div class="col-md-10 mx-auto col-lg-5"> 
        <form action="" method="post" class="p-4 p-md-5 border rounded-3 bg-light">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" autocomplete="off" aria-describedby="" required>
                <label for="username" >Username</label>
            </div>
            <div class="form-floating mb-3">
                <input type="eamil" class="form-control" id="email" name="email" placeholder="Email" autocomplete="off" aria-describedby="" required>
                <label for="email" >Email</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" aria-describedby="" required>
                <label for="password">Password</label>
                <div id="passwordhelp" class="form-text">We'll never share your username and your password with anyone else.</div>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm password" aria-describedby="" required>
                <label for="cpassword">Confirm password</label>
                <div id="passwordhelp" class="form-text">Confirm password here.</div>
            </div>
            <button class="w-100 btn btn-lg btn-primary" name="sign-up" type="submit">S'inscrire</button>         
        </form>
            </div>
    <?php
        if (isset($_POST['sign-up'])) {
            $username = $_POST['username'];
            if (!username_is_already_existe($connexion, $username)) {
                $password = $_POST['password']; 
                if ($_POST['password'] != $_POST['cpassword']) {
                    $_SESSION['message-type'] = 'Erreur';
                    $_SESSION['message'] = 'Password confirmation is incorrect. ';
                } else {
                    $password = md5($password);
                    $email = $_POST['email'];
                    mysqli_query($connexion, "INSERT INTO users (email, username, password_) VALUES ('$email', '$username', '$password')");
                    $_SESSION['message-type'] = 'Success';
                    $_SESSION['message'] = 'Account created with successfuly. ';   
                } 
            } else {
                $_SESSION['message-type'] = 'Erreur';
                $_SESSION['message'] = 'Username already existe. ';
            }
            header('Location: sign-up.php');
        }
    ?>
</body>
</html>