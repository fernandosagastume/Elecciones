<?php
include "connection.php";
$link = OpenCon();
header('Content-Type: image/png');
if(isset($_GET["data"])){
    $partido = $_GET["data"];
    $query = "SELECT logo FROM partidopolitico WHERE '$partido'=nombre";
    $result = pg_query($link, $query) or die('Query failed: '.pg_result_error());
    $fila = pg_fetch_assoc($result);
    $foto = $fila['logo'];
    echo pg_unescape_bytea($foto);
}
?>