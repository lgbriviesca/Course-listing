<?php include("adminTemplate/adminHeader.php");
?>

<div class="col-md-12">
    <div class="jumbotron">
        <h1 class="display-3">Welcome, admin</h1>
        <p class="lead">If you don't find some course information or need to know more about a specific course, enter to the database.</p>
        <hr class="my-2">
        <br>
        <p class="lead">
            <a class="btn btn-primary btn-lg" href="<?php echo $url; ?>/admin/adminSection/adminDatabase.php" role="button">Consult Database</a>
        </p>
    </div>
</div>

<?php include("adminTemplate/adminFooter.php");
?>