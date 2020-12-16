<html>
	<head>
		<title>
			Voto Electrónico
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
	</head>
	<body>
		<div id="fp-container">

			<div id="fp-header">
				<h1 id="fp-enterprise">
					<a href="index.php">ELECCIONES 2019</a>
				</h1>
			</div>

			<div id="fp-body">
				<div id="fp-bcontainer" class="text-m">
					<table class="display" cellspacing="0" cellpadding="3" border="0">
						<tbody>

							

							<?php
								$dpi = $_GET["dpi"];
								include 'connection.php';
								$link = OpenCon();
								$query = "SELECT votop, votoa, votoc, votoln from Empadronado WHERE dpi = $dpi";
								$result = pg_query($link, $query);
								$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);
								$votop = $line["votop"];
								$votoa = $line["votoa"];
								$votoc = $line["votoc"];
								$votoln = $line["votoln"];

								$query = "SELECT COUNT(M.no_mesa) as cant FROM Mesa M, Empadronado E WHERE E.dpi = $dpi AND E.municipio = M.municipio AND M.rangoempadronamientominimo <= $dpi AND $dpi <= M.rangoempadronamientomaximo";
								$result = pg_query($link, $query);
								$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);
								$cant = $line["cant"];

								$flagp = FALSE;
								$flaga = FALSE;
								$flagc = FALSE;
								$flagln = FALSE;
								$flagm = TRUE;

								if (($votop == 1 && $votoa == 1 && $votoc == 1 && $votoln == 1) || $cant == 0 )
								{
									if ($cant == 0)
									{
										echo "<center><b><h3>Las votaciones aún no están listas.</h3></b></center>";
										echo "<meta http-equiv=\"refresh\" content=\"3;url=votoe.php\"/>";
										echo "<br>";
										$flagm = FALSE;
									}
									else
									{
										echo "<center><b><h3>Ya realizó sus votos. ¡Gracias por Participar!</h3></b></center>";
										echo "<meta http-equiv=\"refresh\" content=\"3;url=votoe.php\"/>";
										echo "<br>";
									}
								}
								else
								{
									if ($votop == 0)
									{
										$query = "SELECT COUNT(dpi_presi) as cant FROM Presidencia";
										$result = pg_query($link, $query);
										$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);
										$cant = $line["cant"];

										$flagp = ($cant > 0)? TRUE:FALSE;
									}
									else
									{
										$flagp = FALSE;
									}

									if ($votoa == 0) {

										$query = "SELECT COUNT(A.dpi) as cant FROM Alcalde A, Empadronado E WHERE E.dpi = $dpi AND E.municipio = A.municipio";
										$result = pg_query($link, $query);
										$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);
										$cant = $line["cant"];

										$flaga = ($cant > 0)? TRUE:FALSE;
									}
									else
									{
										$flaga = FALSE;
									}

									if ($votoc == 0) {

										$query = "SELECT COUNT(C.dpi) as cant FROM Congreso C, Empadronado E, Municipio M WHERE E.dpi = $dpi AND E.municipio = M.codigo AND M.departamento = C.departamento";
										$result = pg_query($link, $query);
										$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);
										$cant = $line["cant"];

										$flagc = ($cant > 0)? TRUE:FALSE;
									}
									else
									{
										$flagc = FALSE;
									}

									if ($votoln == 0) {

										$query = "SELECT COUNT(dpi) as cant FROM Congreso WHERE departamento = 0";
										$result = pg_query($link, $query);
										$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);
										$cant = $line["cant"];

										$flagln = ($cant > 0)? TRUE:FALSE;
									}
									else
									{
										$flagln = FALSE;
									}
								}

								if (!$flagm)
								{
									echo "";
								}
								else if(!$flagp && !$flaga && !$flagc && !$flagln)
								{
									echo "<center><b><h3>No existen más votos por el momento. Regrese más tarde</h3></b></center>";
									echo "<meta http-equiv=\"refresh\" content=\"3;url=votoe.php\"/>";
									echo "<br>";							
								}
								else
								{
									echo "<tr class=\"header\">";
									echo "<th colspan=\"2\" id=\"fp-table1\">Tipo de Voto</th>";
									echo "<th id=\"fp-table2\">Numero</th>";
									echo "<th id=\"fp-table2\" style=\"width:300px;\"></th>";
									echo "</tr>";

									if ($flagp)
									{
										echo "<tr>";
										echo "<td style=\"padding-left:15px; width:20px;\"><img alt=\"Folder\" src=\"img/folder.png\"></td>";
										echo "<td width=\"350\">";
										echo "<b><a href=\"bpresidencia.php?dpi=$dpi\">Boleta Presidencia</a></b>";
										echo "</td>";
										echo "</tr>"; 
									}

									if ($flaga)
									{
										echo "<tr>";
										echo "<td style=\"padding-left:15px; width:20px;\"><img alt=\"Folder\" src=\"img/folder.png\"></td>";
										echo "<td width=\"350\">";
										echo "<b><a href=\"balcaldia.php?dpi=$dpi\">Boleta Alcaldia</a></b>";
										echo "</td>";
										echo "</tr>";
									}

									if ($flagc)
									{
										echo "<tr>";
										echo "<td style=\"padding-left:15px; width:20px;\"><img alt=\"Folder\" src=\"img/folder.png\"></td>";
										echo "<td width=\"350\">";
										echo "<b><a href=\"bcongreso.php?dpi=$dpi\">Boleta Congreso</a></b>";
										echo "</td>";
										echo "</tr>";
									}

									if ($flagln)
									{
										echo "<tr>";
										echo "<td style=\"padding-left:15px; width:20px;\"><img alt=\"Folder\" src=\"img/folder.png\"></td>";
										echo "<td width=\"350\">";
										echo "<b><a href=\"blnacional.php?dpi=$dpi\">Boleta Listado Nacional</a></b>";
										echo "</td>";
										echo "</tr>";
									}
								}

							?>
						</tbody>
					</table>
				</div>
				<br>

				<div>
					<span style="float:center" valign="top"><a id="add-bttn" href="votoe.php" onclick="return true;">Regresar</a></span>
				</div>
			</div>

			<div id="fp-footer" style="bottom: 0px">
				<h1 id="fp-project">
					Ciencias de la computacion V
				</h1>
			</div>
		</div>
	</body>
</html>