<html>
	<head>
		<title>
			Partidos Politicos
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css">

	</head>
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
						<span style="float:left">Registrar Partido Politico</span>		
					</h3>
				</div>

				<?php if(!$_POST){?>
				<div id="fp-bcontainer" class="text-m">
				<form name="cuentas" action="registro_pp.php" method="POST" autocomplete="off" enctype="multipart/form-data">
					<table class="display" cellspacing="0" cellpadding="3" border="0">
						<tbody>
							<tr class="header">
								<th id="fp-table2">Campo</th>
								<th id="fp-table2"></th>
							</tr>	
							<tr>
								<td id="fp-btable1">Nombre</td>
								<td id="fp-btable1"><input type="text" name="nombre" style="text-align:center" required></td>
							</tr>
							<tr>
								<td id="fp-btable1">Acronimo</td>
								<td id="fp-btable1"><input type="text" name="acronimo" style="text-align:center" required></td>
							</tr>
							<tr>
								<td id="fp-btable1">Secretario General</td>
								<td id="fp-btable1"><input type="text" name="secretario" style="text-align:center" required></td>
							</tr>
							<tr>
								<td id="fp-btable1">Logo</td>
								<td id="fp-btable1"><input type="file" name="logoimg" id="logoimg" style="text-align:center" required></td>
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
					<span style="float:center" valign="top"><a id="add-bttn" href="partidospoliticos.php">Regresar</a></span>
				</div>
				<?php }else{?>
				<br>
				<br>
				<table class="display" cellspacing="0" cellpadding="3" border="0">
					<td id="fp-btable1">
						<span style="font-size: 17px">
							<?php
							include "connection.php";
							$link = OpenCon();  
								$nombre=$_POST["nombre"];
								$acronimo=$_POST["acronimo"];
								$secretario = $_POST["secretario"];

								$guardar = "images/$nombre/";
								if(!file_exists($guardar)){
									mkdir($guardar,0777,true);
								}
								$ruta = $guardar.basename($_FILES["logoimg"]["name"]);
								$typeimage = strtolower(pathinfo($ruta,PATHINFO_EXTENSION));
								if($typeimage == "png" and !file_exists($ruta) and !($_FILES["logoimg"]["size"] > 300000)){
									if(move_uploaded_file($_FILES["logoimg"]["tmp_name"],$ruta)){
										$data = file_get_contents($ruta);
                                        $logo = pg_escape_bytea($link,$data);
										$query = "INSERT INTO PartidoPolitico VALUES ('$nombre','$secretario', '{$logo}', '$acronimo')";
										if(@pg_query($link, $query)){
											echo "<br>Partido Politico ingresado exitosamente.";
										}else{
											echo "<br>Rechazo de ingreso de partido poltico: ya existe partido politico con el mismo nombre.";
										}
									}
								}
								unlink($ruta);
							?>
						</span>
					</td>
				</table>
				<br>
				<table class="display" cellspacing="0" cellpadding="3" border="0">
					<td id="fp-btable1">
						<span style="float:center" valign="top"><a id="add-bttn" href="partidospoliticos.php">Regresar</a></span>
					</td>
				</table>
				<br>
				<meta http-equiv="refresh" content="2;url=partidospoliticos.php"/>
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