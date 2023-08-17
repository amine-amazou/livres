<?php require_once '../db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Ajouter livre </title>
    <link rel="stylesheet" href="../bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <script src="../bootstrap/bootstrap.min.js"></script>
</head>
<body>
<header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom"> 
        <a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none"> 
            <span class="fs-4">Admin Panel</span> 
        </a> 
        <ul class="nav nav-pills"> 
            <li class="nav-item">
                <form action="" style="float: right;" method="get">
                    <input type="submit" name="home" value="Accueil" class="nav-link" ></li> 
                    <input type="submit" name="logout" value="Se déconnecter" class="nav-link" ></li> 
                </form>
            <?php
                if (isset($_GET['home'])) {
                    header('Location: dashboard.php');
                }
            ?>

        </ul> 
    </header>
    <div class="card" style="margin: 0 150px;">
        <h5 class="card-header" style="margin: 0;">Nouveau livre</h5>
        <div class="card-body">
            <form action="" method="POST" class="form-floating" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="titre">Titre</label>
                    <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre de livre" value="" autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label for="auteur">Auteur</label>
                    <input type="text" class="form-control" id="auteur" name="auteur" placeholder="Auteur de livre" value="" autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="image">Cover image</label>
                    <input type="file" class="form-control" id="image" name="image" rows="3" required accept="image/*"></textarea>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" name="add-livre" type="submit">Ajouter livre</button>
                </div>
            </form>
        </div>
    </div>
    <?php 
        if(isset($_POST['add-livre'])) {
            $dir = "img/" . basename($_FILES["image"]["name"]);
            if (move_uploaded_file($_FILES["image"]["tmp_name"], '../' . $dir)) {
                $titre = mysqli_real_escape_string($connexion ,$_POST['titre']);
                $auteur = mysqli_real_escape_string($connexion, $_POST['auteur']);
                $description = mysqli_escape_string($connexion, $_POST['description']);
                mysqli_query($connexion, "INSERT INTO books (Titre, Auteur, Description, Image_Path) VALUES ('$titre', '$auteur', '$description', '$dir')");
                $_SESSION['message'] = 'Livre bien ajouter';
                header('Location: dashboard.php');
            }
        }

    ?>
    
</body>
</html>