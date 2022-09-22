<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location:../index.php");
} else {
    if ($_SESSION["user"] == "ok") {
        $userName = $_SESSION["userName"];
    };
};
?>
<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="../../css/custom.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <?php $url = "http://" . $_SERVER["HTTP_HOST"] . "/sitioweb" ?>

    <nav class="navbar navbar-expand navbar-light bg-light">
        <div class="nav navbar-nav">
            <a class="nav-item nav-link active" href="<?php echo $url; ?>/admin/adminHome.php">Administration <span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link" href="<?php echo $url; ?>/admin/adminSection/adminDatabase.php">Consult Database</a>
            <a class="nav-item nav-link" href="<?php echo $url; ?>/admin/adminSection/adminProducts.php">Administrate Products</a>
            <a class="nav-item nav-link" href="<?php echo $url; ?>">Go to site in production</a>
            <a class="nav-item nav-link" href="<?php echo $url; ?>/admin/adminSection/adminlogout.php">Logout</a>
        </div>
    </nav>
    <br>
    <div class="container">
        <div class="row">