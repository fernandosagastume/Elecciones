<html>
	<head>
		<title>
			Mesas
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
		<meta http-equiv="refresh" content="2;url=mesas.php"/>
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
									$query = "SELECT COUNT(no_mesa) as cant from Mesa WHERE no_mesa = $mesa";
									$result = pg_query($link, $query);
									$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);
									$cant = $line["cant"];

									if ($cant == 0)
									{
										#Insertar Mesa

										$query = "INSERT INTO Mesa VALUES ($mesa,'$presidente', '$secretario', '$vocal', '$alguacil', '$ubicacion', '$direccion', $min, $max, NULL, NULL, $municipio)";
										$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());

										echo "Mesa ingresada exitosamente.";
										
										#Relacionar Mesas con Partidos politicos que tengan candidatos a presidencia

										$query2 = "SELECT partido FROM Presidencia WHERE partido NOT IN (SELECT partido FROM ConteoFinal WHERE no_mesa = $mesa)";
										$result2 = pg_query($link, $query2);

										while ($line2 = pg_fetch_array($result2, NULL, PGSQL_ASSOC))
										{
											$partido = $line2["partido"];
											$query3 = "INSERT INTO ConteoFinal VALUES($mesa, '$partido', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
											$result3 = @pg_query($link, $query3);
										}

										#Relacionar Mesas con Partidos Politicos que tengan cadidatos a alcaldia de ese municipio

										$query2 = "SELECT partido FROM Alcalde WHERE municipio = $municipio AND partido NOT IN (SELECT partido FROM ConteoFinal WHERE no_mesa = $mesa)";
										$result2 = pg_query($link, $query2);

										while ($line2 = pg_fetch_array($result2, NULL, PGSQL_ASSOC))
										{
											$partido = $line2["partido"];
											$query3 = "INSERT INTO ConteoFinal VALUES($mesa, '$partido', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
											$result3 = @pg_query($link, $query3);
										}

										#Relacionar Mesas con Partidos Politicos con candidatos a diputados del mismo departamento

										$query2 = "SELECT C.partido FROM Congreso C, Departamento D, Municipio M WHERE M.codigo = $municipio AND D.codigo = M.departamento AND C.departamento = D.codigo AND C.partido NOT IN (SELECT partido FROM ConteoFinal WHERE no_mesa = $mesa)";
										$result2 = pg_query($link, $query2);

										while ($line2 = pg_fetch_array($result2, NULL, PGSQL_ASSOC))
										{
											$partido = $line2["partido"];
											$query3 = "INSERT INTO ConteoFinal VALUES($mesa, '$partido', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
											$result3 = @pg_query($link, $query3);
										}

										#Relacionar Mesas con Partidos Politicos con candidatos a Listado Nacional

										$query2 = "SELECT partido FROM Congreso WHERE departamento = 0 AND partido NOT IN (SELECT partido FROM ConteoFinal WHERE no_mesa = $mesa)";
										$result2 = pg_query($link, $query2);

										while ($line2 = pg_fetch_array($result2, NULL, PGSQL_ASSOC))
										{
											$partido = $line2["partido"];
											$query3 = "INSERT INTO ConteoFinal VALUES($mesa, '$partido', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
											$result3 = @pg_query($link, $query3);
										}
									}
									else
									{
										echo "Rechazo de ingreso de mesa: ya existe una mesa con el mismo identificador.";
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
						<span style="float:center" valign="top"><a id="add-bttn" href="mesas.php" onclick="return true;">Regresar</a></span>
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