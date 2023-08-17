<?php require_once 'db_connect.php'; ?>
<?php require_once 'auth.php' ?>
<?php connect_user() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les livres empruntes</title>
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="bootstrap/bootstrap.min.js"></script>
</head>
<body>
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom"> 
        <a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none"> 
            <span class="fs-4">Livres</span> 
        </a> 
        <ul class="nav nav-pills"> 
            <li class="nav-item" style="float: right;">
                <a href="index.php" class="nav-link">Les livres disponible</a>
                <a href="disconnect.php" class="nav-link"> Se déconnecter </a>
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
    <?php if(!empty($_SESSION['message'])) { ?>
        <div class="alert alert-success d-flex align-items-center" role="alert" style="margin: 10px 150px 20px;">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>
                    <?php
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    ?>
                </div>
        </div>
    <?php } ?>
    <h1 class="fs-4">Les livres empruntes: </h1>
    <table class="table">
        <thead>
            <?php $id_user = $_SESSION['login']; ?>
            <tr>
                <th>#</th>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Description</th>
                <th>Date d'emprunte</th>
                <th>Date de revenir</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $books = mysqli_query($connexion, "SELECT books.*, Date_emprunter, Date_revenir, DATEDIFF(Date_revenir, Date_emprunter) AS 'Days_left' FROM books_em INNER JOIN books ON books_em.ID_book = books.ID WHERE ID_user = '$id_user'");
                while ($book = $books->fetch_assoc()) { 
            ?>
            <tr>
                <td>
                    <img src="<?= $book['Image_Path']?>" alt="<?= $book['Titre']?>" width="50" height="50">
                </td>
                <td><?= $book['Titre']?></td>
                <td><?= $book['Auteur']?></td>
                <td><?= $book['Description']?></td>
                <td><?= $book['Date_emprunter']?></td>
                <td><?= $book['Date_revenir']?> <span class="fw-bold"> <?= $book['Days_left']?> days left </span></td>
                <td>
                    <a href="rendre-livre.php?idlivre=<?= $book['ID'] ?>" class="btn btn-outline-dark">
                        Rendre >
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>