<?php
$host = "localhost";
$bd = "phpcursos";
$user = "root";
$password = "root";

try {
    $conection = new PDO("mysql:host=$host;dbname=$bd", $user, $password);
    $conection->query("set names utf8;");
    $conection->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    $conection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
} catch (Exception $ex) {
    echo $ex->getMessage();
}
?>