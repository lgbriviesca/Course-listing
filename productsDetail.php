<?php include("template/header.php"); ?>
<?php include("admin/config/db.php");

$courseId = $_GET["courseId"];
$emptyMessage = "";

$getSentence = $conection->prepare("SELECT * FROM cursos WHERE `id` = '{$courseId}'");
$getSentence->execute();
$course = $getSentence->fetchAll(PDO::FETCH_ASSOC);

if (!$course) {
    $emptyMessage = "¡Ups! parece que estás buscando algo que no existe";
    echo $emptyMessage;
} else {
    $courseToShow = $course;
}

?>

<div class="card border-primary col-md-6 cardDetails">
    <div class="card-header authorField"><?php echo $courseToShow[0]["author"] ?></div>
    <div class="card-body">

        <h4 class="card-title"><?php echo $courseToShow[0]["title"] ?></h4>

        <p class="card-text detailsField"><?php echo $courseToShow[0]["details"] ?></p>
    </div>
</div>
<div class="card border-primary col-md-3 pictureField">
    <div class="card-body">
        <img src="imgs/<?php echo $course[0]["picture"]; ?>" alt="" class="">
    </div>
</div>

<?php include("template/footer.php"); ?>