<?php
include 'connection.php';
$link = OpenCon();
if(isset($_GET["nombre"])){
	$partido = $_GET["nombre"]; 
}else if(isset($_GET["partido"])){
	$partido = $_GET["partido"]; 
}
?>
<html>
	<head>
		<title>
			Partidos Politicos
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
	</head>
	<script>
			function validate()
			{
				c = confirm("¿Borrar el partido politico seleccionado?\nSe eliminarán todos los datos asociados.");
				if(c)
				{
					return true;
				}
				else
				{
					return false;
				}
			}

		</script>
	<body>
		<div id="fp-container">

			<div id="fp-header">
				<h1 id="fp-enterprise">
					<span style="float:left"><a href="index.php">ELECCIONES 2019</a></span>
				</h1>
			</div>

			<div id="fp-body">
				<div id="fp-bcontainer">
					<h3 class="title">
						<span style="float:left">Partidos Politicos</span>
						
					</h3>
				</div>

				<?php if(isset($_GET["listar"])){ ?>
				<div id="fp-bcontainer" class="text-m">
					<table class="display" cellspacing="0" cellpadding="3" border="0">
						<tbody>

							<tr class="header">
								<th id="fp-table2">Acronimo</th>
								<th id="fp-table2">Nombre</th>
								<th id="fp-table2">Logo</th>
								<th id="fp-table2">Secretario General</th>
								<th id="fp-table2">Gestionar</th>
								<th id="fp-table2">Modificar</th>
								<th id="fp-table2">Eliminar</th>
							</tr>

							<?php

								$query = "SELECT * FROM PartidoPolitico ORDER BY acronimo";
								$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());

								$acronimo="";
								$partido = "";
								$logo = 0;
								$secretario = "";

								while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC)){
									$acronimo=$line["acronimo"];
									$partido=$line["nombre"];
									$secretario = $line["secretariogeneral"];
									//echo $partido;
									echo "\t<tr>\n";
									echo "<td id=\"fp-btable1\"><img alt=\"acc\" src=\"img/flag.png\" style=\"padding-right:5px;\">$acronimo</td>\n";
									echo "<td id=\"fp-btable1\">$partido</td>\n";
									echo "<td id=\"fp-btable1\"><img src=logo.php?data=$partido style=\"max-width: 100px; max-height: 100px\"/></td>\n";
									echo "<td id=\"fp-btable1\"><img alt=\"acc\" src=\"img/acc.png\" style=\"padding-right:5px;\">$secretario</td>\n"; 
									$partido = str_replace(" ", "%20", $partido);
									echo "<td id=\"fp-btable1\"><a href=lista_pp.php?gestionar=\"\"&nombre=$partido><img alt=\"Folder\" src=\"img/case.png\"></a></td>\n";
									echo "<td id=\"fp-btable1\"><a href=lista_pp.php?modificar=\"\"&nombre=$partido><img alt=\"Folder\" src=\"img/edit.png\"></a></td>\n";
									echo "<td id=\"fp-btable1\"><a href=lista_pp.php?eliminar=\"\"&nombre=$partido onclick=\"return validate()\"><img alt=\"Folder\" src=\"img/delete.png\"></a></td>\n";
									
									echo "\t</tr>\n";
								}

								CloseCon($link);
							?>
							
						</tbody>
					</table>

				</div>
				<br>
				<div>
				<?php 
				echo "<span style=\"float:center\" valign=\"top\"><a id=\"add-bttn\" href=\"partidospoliticos.php\">Regresar</a></span>";
				?>
				</div>
				<?php }else if(isset($_GET["gestionar"])){?>
				<div id="fp-bcontainer">
					<h3 class="title">
						<span style="float:left">Gestion de: <?php echo "$partido"; ?></span>
						
					</h3>
				</div>
				<div id="fp-bcontainer" class="text-m">
					<table class="display" cellspacing="0" cellpadding="3" border="0">
						<tbody>
							<tr>
								<th id="fp-table3">Cargos</th>
								<th id="fp-table2">Registrar</th>
							</tr>

							<?php				
							$queryPV = "SELECT * FROM Presidencia WHERE partido = '$partido'";
							$resultPV = pg_query($link,$queryPV) or die('Query failed: '.pg_result_error());

							$queryA = "SELECT * FROM Alcalde WHERE partido = '$partido'";
							$resultA = pg_query($link,$queryA) or die('Query failed: '.pg_result_error());

							$queryC= "SELECT * FROM Congreso WHERE partido = '$partido'";
							$resultC = pg_query($link,$queryC) or die('Query failed: '.pg_result_error());
							
							echo "\t<tr>\n";
							echo "<td id='fp-btable2'><img alt='Flag' src='img/folder.png' style='margin-left: 60px; padding-right:5px;' ><a href=listar_cp.php?nombre=$partido>Presidente y Vicepresidente</a></td>\n";
							if(pg_num_rows($resultPV) == 1){
								echo "<td id=\"fp-btable1\"><a href=listar_cp.php?nombre=$partido><img alt=\"gen\" src=\"img/acc.png\" style=\"padding-right:5px;\">Cupo Lleno</a></td>\n";
							}else{
								echo "<td id=\"fp-btable1\"><a href=registrar_cp.php?nombre=$partido><img alt=\"gen\" src=\"img/acc.png\" style=\"padding-right:5px;\">Registrar</a></td>\n";
							}
							echo "\t</tr>\n";

							echo "\t<tr>\n";
							echo "<td id=\"fp-btable2\"><img alt=\"Flag\" src=\"img/folder.png\" style=\"margin-left: 60px; padding-right:5px;\" ><a href=listar_ca.php?nombre=$partido>Alcalde</a></td>\n";
							if(pg_num_rows($resultA) == 22){
								echo "<td id=\"fp-btable1\"><a href=listar_ca.php?nombre=$partido><img alt=\"gen\" src=\"img/acc.png\" style=\"padding-right:5px;\">Cupo Lleno</a></td>\n";
							}else{
								echo "<td id=\"fp-btable1\"><a href=registrar_ca.php?nombre=$partido><img alt=\"gen\" src=\"img/acc.png\" style=\"padding-right:5px;\">Registrar</a></td>\n";
							}
							echo "\t</tr>\n";

							echo "\t<tr>\n";
							echo "<td id=\"fp-btable2\"><img alt=\"Flag\" src=\"img/folder.png\" style=\"margin-left: 60px; padding-right:5px;\" ><a href=listar_cc.php?nombre=$partido>Congreso</a></td>\n";
							if(pg_num_rows($resultC) == 120){
								echo "<td id=\"fp-btable1\"><a href=listar_cc.php?nombre=$partido><img alt=\"gen\" src=\"img/acc.png\" style=\"padding-right:5px;\">Registrar</a></td>\n";
							}else{
								echo "<td id=\"fp-btable1\"><a href=registrar_cc.php?nombre=$partido><img alt=\"gen\" src=\"img/acc.png\" style=\"padding-right:5px;\">Registrar</a></td>\n";
							}
							echo "\t</tr>\n";

							CloseCon($link);
							?>			
						</tbody>
					</table>
				</div>
				<br>
				<div>
				<?php
				echo "<span style=\"float:center\" valign=\"top\"><a id=\"add-bttn\" href=\"lista_pp.php?listar=\"listar\"\" >Regresar</a></span>"; 
				?>
				</div>
				<?php }else if(isset($_GET["modificar"])){
					$query = "SELECT * FROM partidopolitico WHERE nombre='$partido'";
					$arrayR = pg_fetch_array(pg_query($link,$query));
					$acronimo = $arrayR["acronimo"];
					$secretario = $arrayR["secretariogeneral"];

				?>
				<div id="fp-bcontainer" class="text-m">
				    <form name="cuentas" action="lista_pp.php" method="POST" enctype="multipart/form-data">
					<table class="display" cellspacing="0" cellpadding="3" border="0">
						<tbody>
							<tr class="header">
								<th id="fp-table2">Campo</th>
								<th id="fp-table2"></th>
							</tr>
							<tr>
								<td id="fp-btable1">Nombre</td>
								<td id="fp-btable1"><input type="text" name="partido" style="text-align:center" value="<?php echo $partido;?>" readonly></td>
							</tr>
							<tr>
								<td id="fp-btable1">Acronimo</td>
								<td id="fp-btable1"><input type="text" name="acronimo" style="text-align:center" value=<?php echo $acronimo;?> required></td>
							</tr>

							<tr>
								<td id="fp-btable1">Secretario General</td>
								<td id="fp-btable1"><input type="text" name="secretario" style="text-align:center" value="<?php echo $secretario;?>" maxlength="40" required></td>
							</tr>

							<tr>
								<td id="fp-btable1">Logo</td>
								<td id="fp-btable1"><input type="file" name="imgfile" id="imgfile" style="text-align:center" required></td>
							</tr>

						</tbody>
					</table>
					<br>
					<table class="display" cellspacing="0" cellpadding="3" border="0">
						<td id="fp-btable1">
							<span valign="top"><input type="submit" name="submit" value="Enviar" id="add-bttn" ></span>
						</td>
					</table>
					</form>
				</div>
				<br>
				<div>
				<?php
				echo "<span style=\"float:center\" valign=\"top\"><a id=\"add-bttn\" href=\"lista_pp.php?listar=\"listar\"\" >Regresar</a></span>"; 
				?>
				</div>
				<?php }else if(isset($_POST["submit"])){?>
				<br>
				<br>
				<table class="display" cellspacing="0" cellpadding="3" border="0">
					<td id="fp-btable1">
						<span style="font-size: 17px">
							<?php
							    $partido = $_POST["partido"];
								$acronimo = $_POST["acronimo"];
								$secretario = $_POST["secretario"];

								$guardar = "images/$partido/";
								if(!file_exists($guardar)){
									mkdir($guardar,0777,true);
								}
								$ruta = $guardar.basename($_FILES["imgfile"]["name"]);
								$typeimage = strtolower(pathinfo($ruta,PATHINFO_EXTENSION));
								if($typeimage == "png" and !file_exists($ruta) and !($_FILES["imgfile"]["size"] > 300000) and move_uploaded_file($_FILES["imgfile"]["tmp_name"],$ruta)){
									$data = file_get_contents($ruta);
									$image = pg_escape_bytea($link,$data);
									$queryUpdate = "UPDATE partidopolitico SET acronimo='$acronimo',secretariogeneral='$secretario',logo='{$image}' WHERE nombre='$partido'";
									if(pg_query($link,$queryUpdate)){
										echo "<br>\n";
										echo "El Partido Politico se actualizo exitosamente.\n";
									}else{
										echo "<br>\n";
										echo "Ocurrio algo, intentelo de nuevo.\n";
									}
								}
								unlink($ruta);
								CloseCon($link);
							?>
						</span>
					</td>
				</table>
				<br>
				<table class="display" cellspacing="0" cellpadding="3" border="0">
					<td id="fp-btable1">
					<?php 
					echo "<span style=\"float:center\" valign=\"top\"><a id=\"add-bttn\" href=\"lista_pp.php?listar=\"\" \">Regresar</a></span>";
					?>
					</td>
				</table>
				<br>
				<meta http-equiv="refresh" content="2;url=lista_pp.php?listar=''"/>
				<?php }else if(isset($_GET["eliminar"])){?>
				<br>
				<br>
				<table class="display" cellspacing="0" cellpadding="3" border="0">
					<td id="fp-btable1">
						<span style="font-size: 17px">
							<?php
								$query = "DELETE FROM partidopolitico WHERE nombre='$partido'";
								if(pg_query($link,$query)){
									echo "<br>\n";
									echo "El Partido Politico se elimino exitosamente.\n";
								}else{
									echo "<br>\n";
									echo "Ocurrio algo, intentalo de nuevo.\n";
								}
								CloseCon($link);
							?>
						</span>
					</td>
				</table>
				<br>
				<table class="display" cellspacing="0" cellpadding="3" border="0">
					<td id="fp-btable1">
					<?php
					echo "<span style=\"float:center\" valign=\"top\"><a id=\"add-bttn\" href=\"lista_pp.php?listar=\"\" \" >Regresar</a></span>"; 
					?>
					</td>
				</table>
				<br>
				<meta http-equiv="refresh" content="2;url=lista_pp.php?listar=''"/>
				<?php }?>

				
			</div>
			<div id="fp-footer" style="bottom: 0px">
				<h1 id="fp-project">
					Ciencias de la computacion V
				</h1>
			</div>
		</div>
	</body>
</html>