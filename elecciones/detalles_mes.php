<html>
	<head>
		<title>
			Mesas
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
						<?php
							$mesa = $_GET["mesa"];
							echo "<span style=\"float:left\">Detalles de la Mesa No. $mesa</span>";
						?>
						
					</h3>
				</div>
				<div id="fp-bcontainer" class="text-m">
					<table class="display" cellspacing="0" cellpadding="3" border="0">
						<tbody>

							<tr class="header">
								<th id="fp-table2">Presidente</th>
								<th id="fp-table2">Secretario</th>
								<th id="fp-table2">Vocal</th>
								<th id="fp-table2">Alguacil</th>
								<th id="fp-table2">Rango (Min)</th>
								<th id="fp-table2">Rango (Max)</th>
							</tr>

							<?php
								include 'connection.php';
								$link = OpenCon();

								$query = "SELECT nombrepresidente, secretario, vocal, alguacil, rangoempadronamientominimo, rangoempadronamientomaximo FROM Mesa WHERE no_mesa = $mesa";
								$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());

								$presidente = "";
								$secretario = "";
								$vocal = "";
								$alguacil = "";
								$min = 0;
								$max = 0;

								while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC))
								{
									$presidente = $line["nombrepresidente"];
									$secretario = $line["secretario"];
									$vocal = $line["vocal"];
									$alguacil = $line["alguacil"];
									$min = $line["rangoempadronamientominimo"];
									$max = $line["rangoempadronamientomaximo"];

									echo "\t<tr>\n";
									echo "<td id=\"fp-btable1\"><img alt=\"acc\" src=\"img/acc.png\" style=\"padding-right:5px;\">$presidente</td>\n";
									echo "<td id=\"fp-btable1\"><img alt=\"acc\" src=\"img/acc.png\" style=\"padding-right:5px;\">$secretario</td>\n";
									echo "<td id=\"fp-btable1\"><img alt=\"acc\" src=\"img/acc.png\" style=\"padding-right:5px;\">$vocal</td>\n";
									echo "<td id=\"fp-btable1\"><img alt=\"acc\" src=\"img/acc.png\" style=\"padding-right:5px;\">$alguacil</td>\n";
									echo "<td id=\"fp-btable1\">$min</td>\n";
									echo "<td id=\"fp-btable1\">$max</td>\n";
									
									echo "\t</tr>\n";
								}

								CloseCon($link);
							?>
							
						</tbody>
					</table>

				</div>
				<br>

				<div>
					<span style="float:center" valign="top"><a id="add-bttn" href="lista_mes.php" onclick="return true;">Regresar</a></span>
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