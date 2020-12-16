<html>
	<head>
		<title>
			Partidos Politicos
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
		<meta http-equiv="refresh" content="2;url=partidospoliticos.php"/>
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
								$acronimo=$_POST["acronimo"];
								$logo = $_POST["logo"];
								$secretario = $_POST["secretario"];

								$link = OpenCon();

								

								$query = "SELECT COUNT(nombre) as cant from PartidoPolitico WHERE nombre = '$nombre'";
								$result = pg_query($link, $query);
								$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);
								$cant = $line["cant"];

								if ($cant == 0)
								{
									$query = "INSERT INTO PartidoPolitico VALUES ('$nombre','$secretario', $logo, '$acronimo')";
									$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
									echo "Partido Politico ingresado exitosamente.";

									$query2 = "SELECT no_mesa FROM Mesa";
									$result2 = pg_query($link, $query2);

									while ($line2 = pg_fetch_array($result2, NULL, PGSQL_ASSOC))
									{
										$mes = $line2["no_mesa"];
										$query3 = "INSERT INTO ConteoFinal VALUES($mes, '$nombre', NULL, NULL, NULL, NULL)";
										$result3 = pg_query($link, $query3);
									}
								}
								else
								{
									echo "Rechazo de ingreso de partido poltico: ya existe partido politico con el mismo nombre.";
								}

								CloseCon($link);
							?>
						</span>
					</td>
				</table>
				<br>
				<table class="display" cellspacing="0" cellpadding="3" border="0">
					<td id="fp-btable1">
						<span style="float:center" valign="top"><a id="add-bttn" href="partidospoliticos.php" onclick="return true;">Regresar</a></span>
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