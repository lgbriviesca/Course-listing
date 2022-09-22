<?php
session_start();
if ($_POST) {
    if (($_POST["admin"] == "admin") && ($_POST["adminPassword"] == "adminPassword")) { //aquí se valida para la base de datos. 
        $_SESSION["user"] = "ok";
        $_SESSION["userName"] = "adminInSession";
        header("Location:adminHome.php");
    } else {
        $adminError = "Error: Check your credentials";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
                <br>
                <br>
                <div class="card">
                    <div class="card-header">
                        Login
                    </div>
                    <div class="card-body">

                        <?php if (isset($adminError)) { ?>
                            <div class="alert alert-warning" role="alert">
                                <?php echo $adminError ?>
                            </div>
                        <?php } ?>
                        <form method="POST">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Administrator</label>
                                <input type="text" class="form-control" name="admin" placeholder="Enter admin name">
                                <small id="emailHelp" class="form-text text-muted">Administrator: admin <br>Password: adminPassword </small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control" name="adminPassword" placeholder="Password">
                            </div>
                            <button type="submit" class="btn btn-primary">Log in the system</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>