<?php require_once 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<?php
    require_once 'auth.php';
    if (is_connected()) {   
        header('Location: index.php');
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
            <li class="nav-item"><a href="sign-up.php" class="nav-link">S'inscrire</a></li> 
        </ul> 
    </header>
    <?php if(!empty($_SESSION['message'])) { ?>
        <div class="alert alert-danger d-flex align-items-center" role="alert" style="margin: 10px 150px 20px;">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>
                    <?php
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    ?>
                </div>
        </div>
    <?php } ?>
    <div class="col-md-10 mx-auto col-lg-5"> 
        <form action="" method="post" class="p-4 p-md-5 border rounded-3 bg-light">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" autocomplete="off" aria-describedby="" required>
                <label for="username" >Username</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" aria-describedby="passwordhelp" required>
                <label for="password">Password</label>
                <div id="passwordhelp" class="form-text">We'll never share your username and your password with anyone else.</div>
            </div>
            <button class="w-100 btn btn-lg btn-primary" name="log-in" type="submit">Se connecter</button>         
        </form>
    </div>
    <?php
        if (isset($_POST['log-in'])) {
            $username = $_POST['username'];
            $password = md5($_POST['password']); 
            $result = mysqli_query($connexion, "SELECT * FROM users WHERE username = '$username' AND password_ = '$password'");
            if ($result and $result->num_rows == 1) {
                session_start();
                while($row = $result->fetch_assoc()) {
                    $_SESSION['login'] = $row['ID'];
                }
                
                header('Location: index.php'); 
            } else {
                $_SESSION['message'] = 'Username or Password is incorrect';
                header('Location: login.php');
            }
        }
    ?>
</body>
</html>