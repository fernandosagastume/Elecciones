<?php 
include 'connection.php';
$link = OpenCon();
header('Content-Type: image/png');
$pKey = $_GET['data'];
$partido = $_GET['partido'];
$query = "SELECT foto FROM presidencia WHERE partido = '$partido' and dpi_presi='$pKey'";
$result = pg_query($link, $query) or die('Query failed: '.pg_result_error());
$fila = pg_fetch_assoc($result);
$foto = $fila['foto'];
echo pg_unescape_bytea($foto);
?>