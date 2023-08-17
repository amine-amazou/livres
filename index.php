<?php require_once 'db_connect.php'; ?>
<?php require_once 'auth.php'; ?>
<?php connect_user() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="bootstrap/bootstrap.min.js"></script>
    <?php
        $iduser = $_SESSION['login'];
        $bm = mysqli_query($connexion, "SELECT ID_book, DATEDIFF(Date_revenir, Date_emprunter) AS 'Days_left' FROM books_em WHERE ID_user = '$iduser'");
        $_SESSION['expired'] = array();
        while ($b = $bm->fetch_assoc()) {
            if($b['Days_left'] <= 0) {
                $_SESSION['bookid'] = array_push($_SESSION['expired'], $b['ID_book']);
            }
        }

    ?>
</head>
    <?php //var_dump($_SESSION['expired'])?>
<body>
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom"> 
        <a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none"> 
            <span class="fs-4">Livres</span> 
        </a> 
        <ul class="nav nav-pills"> 
            <li class="nav-item" style="float: right; display: flexbox;">
                <a href="livres-empruntes.php" class="nav-link">Les livres empruntes</a>
                <a href="disconnect.php" class="nav-link"> Se déconnecter </a>
                <!-- <a href="?disconnect=1" class="nav-link"> Se déconnecter </a> -->
            </li>
        </ul> 
    </header>
    <?php if(!empty($_SESSION['expired'])) { ?>
        <?php foreach($_SESSION['expired'] as $e) { ?>
            <div class="alert alert-warning d-flex align-items-center" role="alert" style="margin: 10px 150px 20px;">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                    <div>
                        <p> 
                            Date expirée de livre à render:  <a href="rendre-livre.php?idlivre=<?= $e ?>"> Rendre livre maintenant </a> 
                        </p>
                    </div>
            </div>
        <?php } ?>
    <?php } ?>
    
    <h1 class="fs-4">Les livres disponibles: </h1>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $books = mysqli_query($connexion, 'SELECT * FROM books');
                while ($book = $books->fetch_assoc()) { 
            ?>
            <tr>
                <td>
                    <img src="<?= $book['Image_Path'] ?>" alt="<?= $book['Titre']?>" width="50" height="50">
                </td>
                <td><?= $book['Titre']?></td>
                <td><?= $book['Auteur']?></td>
                <td><?= $book['Description']?></td>
                <td>
                    <a href="emprunter-livre.php?idlivre=<?= $book['ID'] ?>" class="btn btn-outline-dark">Emprunter</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php 
        if(isset($_GET['disconnect'])) {
            disconnect_session(); 
            header('Location: login.php');
        } 
    ?>
</body>
</html>