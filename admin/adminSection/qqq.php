<?php include("../adminTemplate/adminHeader.php"); ?>
<?php

$courseId = (isset($_POST["courseId"])) ? $_POST["courseId"] : "";
$courseName = (isset($_POST["courseName"])) ? $_POST["courseName"] : "";
$courseImage = (isset($_FILES["courseImage"]["name"])) ? $_FILES["courseImage"]["name"] : "";
$action = (isset($_POST["action"])) ? $_POST["action"] : "";

include("../config/db.php");

//-------------------

$productsPerPage = 10;

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

//----------------------

switch ($action) {
    case "Add":
        $addSentence = $conection->prepare("INSERT INTO cursos (title, picture) VALUES (:title, :picture);");
        $addSentence->bindParam(":title", $courseName);
        $date = new DateTime();
        $fileName = ($courseImage != "") ? $date->getTimestamp() . "_" . $_FILES["courseImage"]["name"] : "image.jpg";
        $tempFile = $_FILES["courseImage"]["tmp_name"];
        if ($tempFile != "") {
            move_uploaded_file($tempFile, "../../imgs/" . $fileName);
        }

        $addSentence->bindParam(":picture", $fileName);
        $addSentence->execute();
        header("Location:adminProducts.php");
        break;
    case "Modify":
        $updateSentence = $conection->prepare("UPDATE cursos SET title = :title WHERE id = :id");
        $updateSentence->bindParam(":title", $courseName);
        $updateSentence->bindParam(":id", $courseId);
        $updateSentence->execute();

        if ($courseImage != "") {

            $date = new DateTime();
            $fileName = ($courseImage != "") ? $date->getTimestamp() . "_" . $_FILES["courseImage"]["name"] : "image.jpg";
            $tempFile = $_FILES["courseImage"]["tmp_name"];

            move_uploaded_file($tempFile, "../../imgs/" . $fileName);

            $getSentence = $conection->prepare("SELECT picture FROM cursos WHERE id = :id");
            $getSentence->bindParam(":id", $courseId);
            $getSentence->execute();
            $course = $getSentence->fetch(PDO::FETCH_LAZY);

            if (isset($course["picture"]) && ($course["picture"] != "image.jpg")) {
                if (file_exists("../../imgs/" . $course["picture"])) {
                    unlink("../../imgs/" . $course["picture"]);
                }
            }

            $updateSentence = $conection->prepare("UPDATE cursos SET picture = :picture WHERE id = :id");
            $updateSentence->bindParam(":picture", $fileName);
            $updateSentence->bindParam(":id", $courseId);
            $updateSentence->execute();
        }
        header("Location:adminProducts.php");
        break;
    case "Cancel":
        header("Location:adminProducts.php");
        break;
    case "Select":
        $getSentence = $conection->prepare("SELECT * FROM cursos WHERE id = :id");
        $getSentence->bindParam(":id", $courseId);
        $getSentence->execute();
        $courseShow = $getSentence->fetch(PDO::FETCH_LAZY);
        $courseName = $courseShow["title"];
        $courseImage = $courseShow["picture"];
        break;
    case "Remove":
        $getSentence = $conection->prepare("SELECT picture FROM cursos WHERE id = :id");
        $getSentence->bindParam(":id", $courseId);
        $getSentence->execute();
        $course = $getSentence->fetch(PDO::FETCH_LAZY);

        if (isset($course["picture"]) && ($course["picture"] != "image.jpg")) {
            if (file_exists("../../imgs/" . $course["picture"])) {
                unlink("../../imgs/" . $course["picture"]);
            }
        }

        $removeSentence = $conection->prepare("DELETE FROM cursos WHERE id = :id");
        $removeSentence->bindParam(":id", $courseId);
        $removeSentence->execute();
        break;
}
/* $fetchSentence = $conection->prepare("SELECT * FROM cursos");
$fetchSentence->execute();
$courseListing = $fetchSentence->fetchAll(PDO::FETCH_ASSOC); */
?>

<div class="col-md-5">
    <div class="card">
        <div class="card-header">
            Course data
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="courseId">Course ID:</label>
                    <input readonly type="text" value="<?php echo $courseId ?>" class="form-control" name="courseId" id="courseId" placeholder="course ID">
                    <small id="courseIdHelp" class="form-text text-muted">Course ID cannot be modified</small>
                </div>
                <div class="form-group">
                    <label for="courseName">Name:</label>
                    <input required type="text" value="<?php echo $courseName ?>" class="form-control" name="courseName" id="courseName" placeholder="course name">
                </div>
                <div class="form-group">
                    <label for="courseImage">Cover image:</label>
                    <?php echo $courseImage; ?>
                    <?php if ($courseImage != "") { ?>
                        <img src="../../imgs/<?php echo $courseImage; ?>" width="100" alt="">
                    <?php } ?>
                    <input type="file" value="<?php echo $courseImage ?>" class="form-control" name="courseImage" id="courseImage" placeholder="upload the course cover image">
                    <small id="courseImageHelp" class="form-text text-muted">JPG, JPEG image</small>
                </div>
                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="action" <?php echo ($action == "Select") ? "disabled" : "" ?> value="Add" class="btn btn-success">Add</button>
                    <button type="submit" name="action" <?php echo ($action != "Select") ? "disabled" : "" ?> value="Modify" class="btn btn-warning">Modify</button>
                    <button type="submit" name="action" <?php echo ($action != "Select") ? "disabled" : "" ?> value="Cancel" class="btn btn-info">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="col-md-7 productsWithAction">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>COVER IMAGE</th>
                <th>ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($courses as $course) { ?>
                <tr>
                    <td><?php echo $course->id ?></td>
                    <td><?php echo $course->title ?></td>
                    <td>
                        <img src="../../imgs/<?php echo $course->picture ?>" width="100" alt="">
                    </td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="courseId" id="courseId" value="<?php echo $course->id ?>" />
                            <input type="submit" name="action" value="Select" class="btn btn-primary" />
                            <input type="submit" name="action" value="Remove" class="btn btn-danger" />
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="paginationUpper">
        <p>Showing <?php echo $productsPerPage ?> of <?php echo $conteo ?> courses in database </p>
    </div>
    <ul class="pagination paginationDown">
        <?php if ($page > 1) { ?>
            <li class="page-link">
                <a href="./qqq.php?pagina=<?php echo $page - 1 ?>">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php } ?>
        <?php for ($x = 1; $x <= $pages; $x++) { ?>
            <li class="<?php if ($x == $page) echo "active" ?> page-link">
                <a href="./qqq.php?pagina=<?php echo $x ?>">
                    <?php echo $x ?></a>
            </li>
        <?php } ?>
        <?php if ($page < $pages) { ?>
            <li class="page-link">
                <a href="./qqq.php?pagina=<?php echo $page + 1 ?>">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        <?php } ?>
    </ul>
</div>

<?php include("../adminTemplate/adminFooter.php"); ?>