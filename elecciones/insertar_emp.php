<html>
	<head>
		<title>
			Empadronados
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
		<meta http-equiv="refresh" content="2;url=empadronados.php"/>
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
						<span style="float:left">Aviso</span>
					</h3>
				</div>

				<br>
				<br>
				<br>


				<table class="display" cellspacing="0" cellpadding="3" border="0">
					<td id="fp-btable1">

						<span style="font-size: 17px">
							<?php
								include 'connection.php';
								$dpi=$_POST["dpi"];
								$dpi = str_replace(" ", "", $dpi);
								$dpi = str_replace("-", "", $dpi);
								$nombres=$_POST["nombres"];
								$apellidos = $_POST["apellidos"];
								$direccion = $_POST["direccion"];
								$departamento = $_POST["departamento"];
								$municipio = $_POST["municipio"];

								$link = OpenCon();

								

								$query = "SELECT COUNT(dpi) as cant from Empadronado WHERE dpi = $dpi";
								$result = pg_query($link, $query);
								$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);
								$cant = $line["cant"];

								if ($cant == 0)
								{
									$query = "INSERT INTO Empadronado VALUES ($dpi,'$nombres', '$apellidos', '$direccion', $municipio, $departamento)";
									$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
									echo "Empadronado ingresado exitosamente.";
								}
								else
								{
									echo "Rechazo de ingreso de empadronado: ya existe un ciudadano empadronado con el mismo DPI.";
								}

								CloseCon($link);
							?>
						</span>
					</td>
				</table>
				<br>
				<table class="display" cellspacing="0" cellpadding="3" border="0">
					<td id="fp-btable1">
						<span style="float:center" valign="top"><a id="add-bttn" href="empadronados.php" onclick="return true;">Regresar</a></span>
					</td>
				</table>
				<br>
			</div>

			<div id="fp-footer" style="bottom: 0px">
				<h1 id="fp-project">
					Ciencias de la computacion V
				</h1>
			</div>
		</div>
	</body>
</html>