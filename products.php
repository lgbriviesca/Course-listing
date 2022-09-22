<?php include("template/header.php"); ?>
<?php include("admin/config/db.php");
$fetchSentence = $conection->prepare("SELECT * FROM cursos");
$fetchSentence->execute();
$courseListing = $fetchSentence->fetchAll(PDO::FETCH_ASSOC);
?>


<?php foreach ($courseListing as $course) { ?>

    <div class="col-md-3 courseCard">
        <div class="card">
            <img class="card-img-top" src="./imgs/<?php echo $course["picture"];?>" alt="">
            <div class="card-body">
                <h4 class="card-title"><?php echo $course["title"] ?></h4>
                <br>
                <a class="btn btn-primary" href="productsDetail.php?courseId=<?php echo $course["id"]?>">Ver curso</a>
            </div>
        </div>
    </div>
<?php } ?>


<?php include("template/footer.php"); ?>