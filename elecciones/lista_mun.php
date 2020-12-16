<html>
	<head>
		<title>
			Municipios
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
		<script>
			function validate()
			{
				c = confirm("¿Borrar el municipio seleccionado?\nSe eliminarán todos los datos asociados.");
				if(c)
				{
					return true;
				}
				else
				{
					return false;
				}
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
							$dep = $_GET["dep"];
							include 'connection.php';
							$link = OpenCon();
							$query = "SELECT nombre FROM Departamento WHERE codigo = $dep";
							$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error($link));
							$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);

							$ndep = $line["nombre"];
							echo "<span style=\"float:left\">Municipios de $ndep</span>";
						?>
					</h3>
				</div>
				<div id="fp-bcontainer" class="text-m">
					<table class="display" cellspacing="0" cellpadding="3" border="0">
						<tbody>

							<tr class="header">
								<th id="fp-table2">Codigo</th>
								<th id="fp-table2">Nombre</th>
								<th id="fp-table2">Numero de Habitantes</th>
								<th id="fp-table2">Modificar</th>
								<th id="fp-table2">Eliminar</th>
							</tr>

							<?php

								$query = "SELECT * FROM Municipio WHERE departamento = $dep ORDER BY codigo";
								$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());

								$codigo=0;
								$nombre = "";
								$hab = 0;

								while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC))
								{

									$codigo=$line["codigo"];
									$nombre=$line["nombre"];
									$hab = $line["no_habitantes"];

									echo "\t<tr>\n";
									echo "<td id=\"fp-btable1\"><img alt=\"acc\" src=\"img/home.gif\" style=\"padding-right:5px;\">$codigo</td>\n";
									echo "<td id=\"fp-btable1\">$nombre</td>\n";
									echo "<td id=\"fp-btable1\">$hab</td>\n";

									echo "<td id=\"fp-btable1\"><a href=modificar_mun.php?mun=$codigo><img alt=\"Folder\" src=\"img/edit.png\"></a></td>\n";
									echo "<td id=\"fp-btable1\"><a onclick=\"return validate()\" href=eliminar_mun.php?mun=$codigo&dep=$dep><img alt=\"Folder\" src=\"img/delete.png\"></a></td>\n";
									
									echo "\t</tr>\n";
								}
								CloseCon($link);

							?>
							
						</tbody>
					</table>

				</div>
				<br>

				<div>
					<?php

						echo "<span style=\"float:center\" valign=\"top\"><a id=\"add-bttn\" href=\"municipios.php?dep=$dep\" onclick=\"return true;\">Regresar</a></span>";
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