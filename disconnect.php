<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        if(isset($_GET['sourcepage'])) {
            $source_page = $_GET['sourcepage'];
        } else {
            $source_page = 'index';
        } 
    ?>
    <?php require_once 'auth.php'; ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disconnect</title>
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="bootstrap/bootstrap.min.js"></script>
</head>
<body>
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom"> 
        <a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none"> 
            <span class="fs-4">Livres</span> 
        </a> 
    </header>
    <h1 class="fw-bolder"> Confirmer la deconnexion</h1>
    <form action="" method="POST" class="form-floating" enctype="multipart/form-data">
        <div class="col-12">
            <button class="btn btn-primary" name="log-out" type="submit">Valider</button>
            <button class="btn btn-primary" name="back" type="submit">Annuler</button>
        </div>
    </form>
    <?php
        if (isset($_POST['log-out'])) {
            disconnect_session();
            header('Location: login.php');
        }
        if (isset($_POST['back'])) {
            header("Location: $source_page.php");
        }

    ?>
</body>
</html>