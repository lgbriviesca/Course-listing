<?php include("../adminTemplate/adminHeader.php"); ?>

<?php
include("../config/db.php");

$productsPerPage = 6;

$page = 1;
if (isset($_GET["pagina"])) {
    $page = $_GET["pagina"];
}

$limit = $productsPerPage;
$offset = ($page - 1) * $productsPerPage;

$sentence = $conection->query("SELECT count(*) AS conteo FROM cursos");
$conteo = $sentence->fetchObject()->conteo;

$pages = ceil($conteo / $productsPerPage);

$sentence = $conection->prepare("SELECT * FROM cursos LIMIT ? OFFSET ?");
$sentence->execute([$limit, $offset]);
$courses = $sentence->fetchAll(PDO::FETCH_OBJ);

?>

<?php
$courseName = (isset($_POST["courseName"])) ? $_POST["courseName"] : "";
$courseId = (isset($_POST["courseId"])) ? $_POST["courseId"] : "";
$action = (isset($_POST["action"])) ? $_POST["action"] : "";
$courseListing = [];
$emptyMessage = "";

switch ($action) {
    case "FindName":
        if (!$courseName) {
            $emptyMessage = "Please write something to search";
        } else {
            $getSentence = $conection->prepare("SELECT * FROM cursos WHERE `title` LIKE '%{$courseName}%'");
            $getSentence->execute();
            $courseShow = $getSentence->fetchAll(PDO::FETCH_ASSOC);

            if (!$courseShow) {
                $emptyMessage = "No matches found";
            } else {
                $courseListing = $courseShow;
            }
        }
        break;
    case "FindId":
        if (!$courseId) {
            $emptyMessage = "Please write an id to search";
        } else {
            $getSentence = $conection->prepare("SELECT * FROM cursos WHERE `id` = '{$courseId}'");
            $getSentence->execute();
            $courseShow = $getSentence->fetchAll(PDO::FETCH_ASSOC);

            if (!$courseShow) {
                $emptyMessage = "No matches found";
            } else {
                $courseListing = $courseShow;
            }
        }
        break;
}

?>


<div class="col-md-6 container dataBaseLeft">

    <div class="paginationUpper">
        <p>Showing <?php echo $productsPerPage ?> of <?php echo $conteo ?> courses in database </p>
    </div>
    <div class="paginationUpper2">
        <p>Page <?php echo $page ?> of <?php echo $pages ?> </p>
    </div>


    <div class="row">

        <?php foreach ($courses as $course) { ?>
            <div class="col-6 courseCard">
                <div class="card border-light mb-3">
                    <div class="card-header">Id: <?php echo $course->id ?></div>
                    <div class="card-body">
                        <h5 class="card-title">Title: <?php echo $course->title ?></h5>
                        <img src="../../imgs/<?php echo $course->picture ?>" width="100" alt="">
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>

    <ul class="pagination paginationDown">
        <?php if ($page > 1) { ?>
            <li class="page-link">
                <a href="./adminDatabase.php?pagina=<?php echo $page - 1 ?>">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php } ?>
        <?php for ($x = 1; $x <= $pages; $x++) { ?>
            <li class="<?php if ($x == $page) echo "active" ?> page-link">
                <a href="./adminDatabase.php?pagina=<?php echo $x ?>">
                    <?php echo $x ?></a>
            </li>
        <?php } ?>
        <?php if ($page < $pages) { ?>
            <li class="page-link">
                <a href="./adminDatabase.php?pagina=<?php echo $page + 1 ?>">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        <?php } ?>
    </ul>
</div>

<div class="col-md-5 dataBaseRight">

    <h5>Search course by words in title or by Id</h5>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group ">
            <label for="courseId">Course ID:</label>
            <input type="text" class="form-control" name="courseId" id="courseId" placeholder="course Id">
        </div>
        <div class="form-group ">
            <label for="courseName">Name:</label>
            <input type="text" class="form-control" name="courseName" id="courseName" placeholder="write title or keywords">
        </div>
        <div class="btn-group" role="group" aria-label="">
            <button type="submit" name="action" value="FindName" class="btn btn-success">Search by name</button>
            <button type="submit" name="action" value="FindId" class="btn btn-warning">Search by Id</button>
        </div>
    </form>

    <tbody>
        <br>
        <h4><?php echo $emptyMessage ?></h4>
        <?php foreach ($courseListing as $course) { ?>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Title: <?php echo $course["title"] ?></h4>
                    <p class="card-text">Id: <?php echo $course["id"] ?></p>
                    <img src="../../imgs/<?php echo $course["picture"] ?>" width="100" alt="">
                </div>
            </div>
        <?php } ?>
        <nav>
    </tbody>