<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>
<?php
require_once 'admin-auth.php';
if (isset($_POST['back'])) {
    header('Location: dashboard.php');
}
if (isset($_GET['home'])) {
    unset($_GET['id']);
    header('Location: index.php');
    die();
}
if (isset($_GET['logout'])) {
    disconnect_admin();
}
?>
<?php 
    require_once '../db_connect.php';
    if (!isset($_GET['id'])) {
        header('Location: index.php');
        die();
    }
    $id_livre = $_GET['id'];
    $_SESSION['idlivre'] = $id_livre

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
        $book = mysqli_query($connexion, "SELECT * FROM books WHERE ID = '$id_livre' ");
        while ($information = $book->fetch_assoc()) {
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


    <h1> Confirmer la suppresion de livre</h1>
    <form action="" method="POST" class="form-floating" enctype="multipart/form-data">
        <div class="col-12">
            <button class="btn btn-primary" name="delete-livre" type="submit">Supprimer le livre</button>
            <button class="btn btn-primary" name="back" type="submit">Annuler</button>
        </div>
    </form>

    <?php
        if(isset($_POST['delete-livre'])) {
            unlink('../' . $cover_path);
            $id_livre = $_SESSION['idlivre'];
            mysqli_query($connexion, "DELETE FROM books WHERE ID = '$id_livre'");
            //echo mysqli_error($connexion);
            $_SESSION['message'] = 'Livre bien supprimer';
            header('Location: dashboard.php');
         }
        
    ?>

</body>
</html>