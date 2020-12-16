<html>
	<head>
		<title>
			Mesas
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
		<meta http-equiv="refresh" content="2;url=lista_mes.php"/>
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
								$mesa=$_POST["mesa"];
								$presidente=$_POST["presidente"];
								$secretario = $_POST["secretario"];
								$alguacil = $_POST["alguacil"];
								$vocal = $_POST["vocal"];
								$municipio = $_POST["municipio"];
								$ubicacion = $_POST["ubicacion"];
								$direccion = $_POST["direccion"];
								$min = $_POST["min"];
								$max = $_POST["max"];

								$link = OpenCon();

								$query = "SELECT rangoempadronamientominimo, rangoempadronamientomaximo, municipio FROM Mesa";
								$result = pg_query($link, $query);
								
								$f1 = False;
								$f2 = False;

								while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC))
								{
									$mini = $line["rangoempadronamientominimo"];
									$maxi = $line["rangoempadronamientomaximo"];
									$muni = $line["municipio"];

									$f1 = ($mini <= $min) && ($min <= $maxi) && ($municipio == $muni);
									$f2 = ($mini <= $max) && ($max <= $maxi) && ($municipio == $muni);
								}


								if ($f1 || $f2)
								{
									echo "Rechazo de ingreso de mesa: existe traslapamiento con otra mesa.";
								}
								else
								{
									$query = "UPDATE Mesa SET nombrepresidente = '$presidente', secretario = '$secretario', vocal = '$vocal', alguacil = '$alguacil', rangoempadronamientominimo = $min, rangoempadronamientomaximo = $max, municipio = $municipio, nombreubicacion = '$ubicacion', direccionubicacion = '$direccion' WHERE no_mesa = $mesa";
									$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());



									if ($result)
									{
										echo "Mesa actualizada exitosamente.";
									}
									else
									{
										echo "Rechazo de actualizacion de mesa: ya existe una mesa con el mismo identificador.";
									}
								}
						
								CloseCon($link);
							?>
						</span>
					</td>
				</table>
				<br>
				<table class="display" cellspacing="0" cellpadding="3" border="0">
					<td id="fp-btable1">
						<span style="float:center" valign="top"><a id="add-bttn" href="lista_mes.php" onclick="return true;">Regresar</a></span>
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