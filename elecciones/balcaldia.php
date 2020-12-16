<html>
	<head>
		<title>
			Boleta Alcaldia
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
		<script>
			function validate()
			{
				return true;
			}
		</script>
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
						$dpi=$_GET["dpi"];
							include 'connection.php';
							$link = OpenCon();
							$query = "SELECT M.nombre as mun, E.municipio FROM Empadronado E, Municipio M WHERE E.dpi = $dpi AND E.municipio = M.codigo";
							$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
							$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);
							$mun = $line["mun"];
							$cmun = $line["municipio"];

							echo "<span style=\"float:left\">Candidatos a Alcaldia Del Municipio '$mun'</span>";
						?>
					</h3>
				</div>
				<div id="fp-bcontainer" class="text-m">
				<form name="cuentas" action="votar.php" method="post">
					<table class="display" cellspacing="0" cellpadding="3" border="0">
						<tbody>

							<tr class="header">
								<th id="fp-table2">Votar</th>
								<th id="fp-table2">Partido Politico</th>
								<th id="fp-table2">Alcalde</th>
							</tr>

							<?php

								$query = "SELECT E.nombres, E.apellidos, PP.nombre as pp FROM Alcalde A, Empadronado E, PartidoPolitico PP WHERE PP.nombre = A.partido AND A.municipio = $cmun AND A.dpi = E.dpi";
								$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());

								$alcalde = "";
								$pp = "";

								while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC))
								{
									$pp = $line["pp"];
									$alcalde=$line["nombres"]." ".$line["apellidos"];

									echo "\t<tr>\n";
									echo "<td id=\"fp-btable1\"><input type=\"radio\" name=\"partido\" value=\"$pp\" required>Votar</td>";
									echo "<td id=\"fp-btable1\"><img src=logo.php?data=$pp style=\"max-width: 100px; max-height: 100px\"/></td>\n";
									echo "<td id=\"fp-btable1\">$alcalde</td>\n";
									echo "<input value=\"$dpi\" type=\"number\" min=\"0\" name=\"dpi\" style=\"text-align:center\" required hidden>";
									echo "<input value=\"1\" type=\"number\" min=\"0\" name=\"vopt\" style=\"text-align:center\" required hidden>";
									
									echo "\t</tr>\n";
								}

								CloseCon($link);
							?>

						</tbody>
					</table>
					<br>
					<table class="display" cellspacing="0" cellpadding="3" border="0">
						<td id="fp-btable1">
								<span valign="top"><input type="submit" name="submit" value="Enviar" id="add-bttn" onclick="return validate()"></span>
						</td>
					</table>
					</form>
				</div>
				<br>

				<div>
					<?php 
						echo "<span style=\"float:center\" valign=\"top\"><a id=\"add-bttn\" href=\"votomenu.php?dpi=$dpi\" onclick=\"return true;\">Regresar</a></span>";
					?>
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