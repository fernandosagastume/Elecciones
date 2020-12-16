<html>
	<head>
		<title>
			Votar
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
								$pp = $_POST["partido"];
								$tipo = $_POST["vopt"];
								$link = OpenCon();
								$query = "SELECT COUNT(dpi) as cant, MIN(votop) as vp, MIN(votoa) as va, MIN(votoc) as vc, MIN(votoln) as vln, MIN(municipio) as mun from Empadronado WHERE dpi = $dpi";
								$result = pg_query($link, $query);
								$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);
								$cant = $line["cant"];
								$vp = $line["vp"];
								$va = $line["va"];
								$vc = $line["vc"];
								$vln = $line["vln"];
								$mun = $line["mun"];

								$query1 = "SELECT M.no_mesa FROM Empadronado E, Mesa M WHERE E.dpi = $dpi AND E.municipio = M.municipio AND M.rangoempadronamientominimo <= $dpi AND M.rangoempadronamientomaximo >= $dpi";
								$result1 = pg_query($link, $query1);
								$line1 = pg_fetch_array($result1, NULL, PGSQL_ASSOC);
								$mesa = $line1["no_mesa"];

								if ($tipo == 0)
								{
									if ($cant == 1 && $vp == 0)
									{
										$query = "SELECT votopresidencia FROM ConteoFinal WHERE no_mesa = $mesa AND partido = '$pp'";
										$result = pg_query($link, $query);
										$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);

										$isnull = $line["votopresidencia"];

										if(is_null($isnull))
										{
											$query = "UPDATE ConteoFinal SET votopresidencia = 1 WHERE no_mesa = $mesa AND partido = '$pp'";
										}
										else
										{
											$query = "UPDATE ConteoFinal SET votopresidencia = votopresidencia + 1 WHERE no_mesa = $mesa AND partido = '$pp'";
										}

										$result = pg_query($link, $query);

										if ($result)
										{
											$query = "UPDATE Empadronado SET votop = 1 WHERE dpi = $dpi";
											$result = pg_query($link, $query);
											echo "Ingreso de voto exitoso de presidencia";
										}
										else
										{
											echo "Rechazo de ingreso de voto a presidencia.";
										}
									}
									else if($cant == 0)
									{
										echo "Rechazo de ingreso de voto: la persona asociada con el DPI ingresado no esta empadronado.";
									}
									else
									{
										echo "Rechazo de ingreso de voto: la persona asociada con el DPI ingresado ya realizo su voto.";
									}
								}
								else if($tipo == 1)
								{
									if ($cant == 1 && $va == 0)
									{
										$query = "SELECT votoalcalde FROM ConteoFinal WHERE no_mesa = $mesa AND partido = '$pp'";
										$result = pg_query($link, $query);
										$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);

										$isnull = $line["votoalcalde"];

										if(is_null($isnull))
										{
											$query = "UPDATE ConteoFinal SET votoalcalde = 1 WHERE no_mesa = $mesa AND partido = '$pp'";
										}
										else
										{
											$query = "UPDATE ConteoFinal SET votoalcalde = votoalcalde + 1 WHERE no_mesa = $mesa AND partido = '$pp'";
										}

										$result = pg_query($link, $query);

										if ($result)
										{
											$query = "UPDATE Empadronado SET votoa = 1 WHERE dpi = $dpi";
											$result = pg_query($link, $query);
											echo "Ingreso de voto exitoso a alcaldia.";
										}
										else
										{
											echo "Rechazo de ingreso de voto a alcaldia.";
										}
									}
									else if($cant == 0)
									{
										echo "Rechazo de ingreso de voto: la persona asociada con el DPI ingresado no esta empadronado.";
									}
									else
									{
										echo "Rechazo de ingreso de voto: la persona asociada con el DPI ingresado ya realizo su voto.";
									}
								}
								else if($tipo == 2)
								{
									if ($cant == 1 && $vc == 0)
									{
										$query = "SELECT votodiputadosdistritales FROM ConteoFinal WHERE no_mesa = $mesa AND partido = '$pp'";
										$result = pg_query($link, $query);
										$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);

										$isnull = $line["votodiputadosdistritales"];

										if(is_null($isnull))
										{
											$query = "UPDATE ConteoFinal SET votodiputadosdistritales = 1 WHERE no_mesa = $mesa AND partido = '$pp'";
										}
										else
										{
											$query = "UPDATE ConteoFinal SET votodiputadosdistritales = votodiputadosdistritales + 1 WHERE no_mesa = $mesa AND partido = '$pp'";
										}

										$result = pg_query($link, $query);

										if ($result)
										{
											$query = "UPDATE Empadronado SET votoc = 1 WHERE dpi = $dpi";
											$result = pg_query($link, $query);
											echo "Ingreso de voto exitoso de congreso.";
										}
										else
										{
											echo "Rechazo de ingreso de voto de congreso.";
										}
									}
									else if($cant == 0)
									{
										echo "Rechazo de ingreso de voto: la persona asociada con el DPI ingresado no esta empadronado.";
									}
									else
									{
										echo "Rechazo de ingreso de voto: la persona asociada con el DPI ingresado ya realizo su voto.";
									}
								}
								else if($tipo == 3)
								{
									if ($cant == 1 && $vln == 0)
									{
										$query = "SELECT votodiputadoslistadonacional FROM ConteoFinal WHERE no_mesa = $mesa AND partido = '$pp'";
										$result = pg_query($link, $query);
										$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);
										$isnull = $line["votodiputadoslistadonacional"];

										if(is_null($isnull))
										{
											$query = "UPDATE ConteoFinal SET votodiputadoslistadonacional = 1 WHERE no_mesa = $mesa AND partido = '$pp'";
										}
										else
										{
											$query = "UPDATE ConteoFinal SET votodiputadoslistadonacional = votodiputadoslistadonacional + 1 WHERE no_mesa = $mesa AND partido = '$pp'";
										}

										$result = pg_query($link, $query);

										if ($result)
										{
											$query = "UPDATE Empadronado SET votoln = 1 WHERE dpi = $dpi";
											$result = pg_query($link, $query);
											echo "Ingreso de voto exitoso de congreso.";
										}
										else
										{
											echo "Rechazo de ingreso de voto de congreso.";
										}
									}
									else if($cant == 0)
									{
										echo "Rechazo de ingreso de voto: la persona asociada con el DPI ingresado no esta empadronado.";
									}
									else
									{
										echo "Rechazo de ingreso de voto: la persona asociada con el DPI ingresado ya realizo su voto.";
									}
								}
								else
								{
									echo "Opcion de voto no valida. Deja de hackear.";
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
							echo "<span style=\"float:center\" valign=\"top\"><a id=\"add-bttn\" href=\"votomenu.php?dpi=$dpi\" onclick=\"return true;\">Regresar</a></span>";
						?>
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