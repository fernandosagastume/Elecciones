<html>
	<head>
		<title>
			Partidos Politicos
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
		<meta http-equiv="refresh" content="2;url=lista_pp.php"/>
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

								$nombre=$_POST["nombre"];
								$acronimo = $_POST["acronimo"];
								$secretario = $_POST["secretario"];
								$logo = $_POST["logo"];

								$link = OpenCon();

								$query = "UPDATE PartidoPolitico SET acronimo = '$acronimo', secretariogeneral = '$secretario', logo = $logo WHERE nombre = '$nombre'";
								$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());

								if ($result)
								{
									echo "Partido politico actualizado exitosamente.";
								}
								else
								{
									echo "Rechazo de actualizacion de partido politico: ya existe un partido con el nombre modificado.";
								}
								CloseCon($link);
							?>
						</span>
					</td>
				</table>
				<br>
				<table class="display" cellspacing="0" cellpadding="3" border="0">
					<td id="fp-btable1">
						<span style="float:center" valign="top"><a id="add-bttn" href="lista_pp.php" onclick="return true;">Regresar</a></span>
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