<?php
    include_once 'admin-auth.php';

    if (isset($_GET['home'])) {
        header('Location: dashboard.php');
    }
    if (isset($_GET['logout'])) {
        disconnect_admin();
    }
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once '../db_connect.php';
    if (!isset($_GET['id'])) {
        header('Location: index.php');
    }
    $id_livre = $_GET['id'];
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Modifier livre </title>
    <link rel="stylesheet" href="../bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <script src="../bootstrap/bootstrap.min.js"></script>
</head>
<body>
    <?php
        $title = "";
        $auteur = "";
        $description = "";
        $cover_path = "";
        $book = mysqli_query($connexion, "SELECT * FROM books WHERE ID = '$id_livre' ");
        while ($information = $book->fetch_assoc()) {
            $title = $information['Titre'];
            $auteur = $information['Auteur'];
            $description = $information['Description'];
            $cover_path = $information['Image_Path'];
        }
    ?>
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom"> 
        <a href="../index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none"> 
            <span class="fs-4">Admin Panel</span> 
        </a> 
        <ul class="nav nav-pills"> 
            <li class="nav-item">
                <form action="" style="float: right;" method="get">
                    <input type="submit" name="home" value="Accueil" class="nav-link" ></li> 
                    <input type="submit" name="logout" value="Se déconnecter" class="nav-link" ></li> 
                </form>
            
        </ul> 
    </header>
    <div class="card" style="margin: 0 150px;">
        <h5 class="card-header" style="margin: 0;">Modifier livre</h5>
        <div class="card-body">
            <form action="" method="POST" class="form-floating" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="titre">Titre</label>
                    <input type="text" class="form-control" id="titre" placeholder="Titre de livre" name="titre_n" value="<?= $title ?>" autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label for="auteur">Auteur</label>
                    <input type="text" class="form-control" id="auteur" placeholder="Auteur de livre" name="auteur_n" value="<?= $auteur ?>" autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description_n" rows="3"><?= $description ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="image">Cover image</label>
                    <input type="file" class="form-control" id="image" name="cover_n" rows="3" accept="image/*"></textarea>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" name="edit-livre" type="submit">Mise à jour livre</button>
                </div>
            </form>
        </div>
    </div>
    <?php
        if(isset($_POST['edit-livre'])) {
            $title_n = mysqli_real_escape_string($connexion, $_POST['titre_n']);
            $auteur_n = mysqli_real_escape_string($connexion, $_POST['auteur_n']);
            $description_n = mysqli_real_escape_string($connexion, $_POST['description_n']);
            $modified = false;

            if($title_n != $title) {
                mysqli_query($connexion, "UPDATE books SET Titre = '$title_n' WHERE ID = '$id_livre'");
                //echo mysqli_error($connexion);
                $modified = true;
            }
            if ($auteur_n != $auteur) {
                mysqli_query($connexion, "UPDATE books SET Auteur = '$auteur_n' WHERE ID = '$id_livre' ");
                $modified = true;
            }
            if ($description_n != $description) {
                mysqli_query($connexion, "UPDATE books SET Description = '$description_n' WHERE ID = '$id_livre' ");
                $modified = true;
            }
            if (!empty($_FILES["cover_n"]["name"])) {
                unlink('../' . $cover_path);
                $dir = "img/" . basename($_FILES["cover_n"]["name"]);
                if (move_uploaded_file($_FILES["cover_n"]["tmp_name"], '../' . $dir)) {
                    mysqli_query($connexion, "UPDATE books SET Image_Path = '$dir' WHERE ID = '$id_livre' ");
                }
                $modified = true;
            }
            if ($modified != false) {
                $_SESSION['message'] = 'Livre bien modifier';
                header('Location: dashboard.php');
            } else {
                $_SESSION['message'] = 'Non modification';
                header('Location: dashboard.php');
            }

        }
    ?>
    

</body>
</html>