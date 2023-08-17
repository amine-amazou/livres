<?php require_once '../db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<?php require 'admin-auth.php'; ?>
<?php connect_admin() ?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <script src="../bootstrap/bootstrap.min.js"></script>
    <title>Admin | Accueil</title>
</head>
<body>
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom"> 
        <a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none"> 
            <span class="fs-4">Admin Panel</span> 
        </a> 
        <ul class="nav nav-pills"> 
            <li class="nav-item">
                <form action="" style="float: right;" method="get">
                    <input type="submit" name="add-book" value="Ajouter livre" class="nav-link" ></li> 
                    <input type="submit" name="logout" value="Se déconnecter" class="nav-link" ></li> 
                </form>
        </ul> 
    </header>
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
    
    <h1 class="fs-4">Les livres existe dans la base de données: </h1>
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
                    <img src="<?= '../' . $book['Image_Path']?>" alt="<?= $book['Titre']?>" width="50" height="50">
                </td>
                <td><?= $book['Titre']?></td>
                <td><?= $book['Auteur']?></td>
                <td><?= $book['Description']?></td>
                <td>
                    <a href="modifier-livre.php?id=<?= $book['ID'] ?>">
                        <button class="btn btn-outline-danger">Modifier</button>
                    </a>
                    <a href="supprimer-livre.php?id=<?= $book['ID'] ?>">
                        <button class="btn btn-outline-danger">Supprimer</button>
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php
        if (isset($_GET['logout'])) {
            disconnect_admin();
            header('Location: index.php');
        }
        if (isset($_GET['add-book'])) {
            header('Location: ajouter-livre.php');
        }
    ?>
</body>
</html>