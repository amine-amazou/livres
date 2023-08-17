<?php require_once 'db_connect.php'; ?>
<?php require_once 'auth.php'; ?>
<?php connect_user() ?>
<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>
<!DOCTYPE html>
<?php 
    if(isset($_GET['Valider'])) {
        $id_livre = $_SESSION['idlivre'];
        $id_user = $_SESSION['login'];
        $date_revenir = $_GET['daterevenir'];
        mysqli_query($connexion, "INSERT INTO books_em VALUES ('$id_user', '$id_livre', NOW(), '$date_revenir')");
        $_SESSION['message'] = "Nouveau livre emprunter Date de rendre: $date_revenir";
        
        header('Location: livres-empruntes.php');
        die();

    }
    
    if (isset($_GET['idlivre'])) {
        $id_livre = $_GET['idlivre'];
        $_SESSION['idlivre'] = $id_livre;
        $book = mysqli_query($connexion, "SELECT * FROM books WHERE ID = '$id_livre' ");
        if ($book->num_rows == 0) {
            header('Location: ../404-error.html');
            die();
        }
    } else {
       header('Location: ../404-error.html');
        die();
    }
?>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emprunter livre</title>
    <link rel="stylesheet" href="bootstrap\bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
     
</head>
<body>
    <?php $id_user = $_SESSION['login']; ?>
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom"> 
        <a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none"> 
            <span class="fs-4">Livres</span> 
        </a> 
        <ul class="nav nav-pills"> 
            <li class="nav-item" style="float: right;">
                <a href="livres-empruntes.php" class="nav-link">Les livres empruntes</a>
                <a href="disconnect.php" class="nav-link"> Se déconnecter </a>
            </li>
        </ul> 
    </header>
    <?php  
        while ($information = $book->fetch_assoc()) {
            $title = $information['Titre'];
            $auteur = $information['Auteur'];
            $description = $information['Description'];
            $cover_path = $information['Image_Path'];
         }

    ?>
    <div class="card">
        <div class="card-body">
            <img src="<?= $cover_path ?>" class="img-thumbnail" alt="<?= $title ?>">
            <p class="fs-3"> <?= $title ?> <span class="fs-6"> <?= $auteur ?> </span>
            <p class="fs-6 fw-bold">Description de livre: </p>
            <p class="fs-6"><?= $description ?></p>
        </div>
    </div>
    <?php
        $verify = mysqli_query($connexion, "SELECT * FROM books_em WHERE ID_book = '$id_livre' AND ID_user = '$id_user' ");
        if ($verify->num_rows == 0) {
            $existealready = false;
        } else {
            $existealready = true;
        }
    ?>
    <form action="" method="GET">
        <div class="mb-3" style="padding-right: 900px;">
            <label for="daterevenir" class="form-label">Date revenir</label>
            <input type="date" class="form-control" name="daterevenir" id="daterevenir" height="200" required>
        </div>
        <div class="mb-3">
            <?php if($existealready) { ?>
                <input type="submit" name="Valider" class="btn btn-primary" value="Valider" disabled>
            <?php } else { ?>
                <input type="submit" name="Valider" class="btn btn-primary" value="Valider">
            <?php } ?>
        </div>


    </form>
    
</body>
</html>