<html>
	<head>
		<title>
			Boleta Congreso
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
							$query = "SELECT D.nombre as dep, D.codigo FROM Empadronado E, Municipio M, Departamento D WHERE E.dpi = $dpi AND E.municipio = M.codigo AND D.codigo = M.departamento";
							$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
							$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);
							$dep = $line["dep"];
							$cdep = $line["codigo"];

							echo "<span style=\"float:left\">Candidatos a Congreso Del Departamento de '$dep'</span>";
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
								<th id="fp-table2">Casilla 1</th>
								<th id="fp-table2">Casilla 2</th>
								<th id="fp-table2">Casilla 3</th>
								<th id="fp-table2">Casilla 4</th>
								<th id="fp-table2">Casilla 5</th>
							</tr>

							<?php

								$query = "SELECT E.nombres, E.apellidos, C.partido as pp FROM Congreso C, Empadronado E WHERE C.departamento = $cdep AND C.dpi = E.dpi ORDER BY C.partido ASC, C.casilla ASC";
								$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());

								$tipo = "";
								$pp = "";

								$count = 1;

								while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC))
								{
									$pp = $line["pp"];
									

									echo "\t<tr>\n";
									echo "<td id=\"fp-btable1\"><input type=\"radio\" name=\"partido\" value=\"$pp\" required>Votar</td>";
									echo "<td id=\"fp-btable1\"><img src=logo.php?data=$pp style=\"max-width: 100px; max-height: 100px\"/></td>\n";

									$tipo=$line["nombres"]." ".$line["apellidos"];
									echo "<td id=\"fp-btable1\">$tipo</td>\n";
									for ($i=0; $i < 4; $i++)
									{ 
										$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);
										$tipo=$line["nombres"]." ".$line["apellidos"];
										echo "<td id=\"fp-btable1\">$tipo</td>\n";
									}
									echo "<input value=\"$dpi\" type=\"number\" min=\"0\" name=\"dpi\" style=\"text-align:center\" required hidden>";
									echo "<input value=\"2\" type=\"number\" min=\"0\" name=\"vopt\" style=\"text-align:center\" required hidden>";
									
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