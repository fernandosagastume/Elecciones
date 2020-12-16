<html>
	<head>
		<title>
			Empadronados
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
		<meta http-equiv="refresh" content="2;url=lista_emp.php"/>
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
								$dpi = $_POST["dpi"];
								$nombres = $_POST["nombres"];
								$apellidos = $_POST["apellidos"];
								$departamento = $_POST["departamento"];
								$municipio = $_POST["municipio"];
								$direccion = $_POST["direccion"];

								$link = OpenCon();

								$query = "UPDATE Empadronado SET nombres = '$nombres', apellidos = '$apellidos', departamento = $departamento, municipio = $municipio, direccion = '$direccion' WHERE dpi = $dpi";
								$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());

								if ($result)
								{
									echo "Empadronado actualizado exitosamente.";
								}
								else
								{
									echo "Rechazo de actualizacion de empadronado: ya existe un ciudadano empadronado con el DPI modificado.";
								}
								CloseCon($link);
							?>
						</span>
					</td>
				</table>
				<br>
				<table class="display" cellspacing="0" cellpadding="3" border="0">
					<td id="fp-btable1">
						<span style="float:center" valign="top"><a id="add-bttn" href="lista_emp.php" onclick="return true;">Regresar</a></span>
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