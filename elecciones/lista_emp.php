<html>
	<head>
		<title>
			Empadronados
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
		<script>
			function validate()
			{
				c = confirm("¿Borrar el empadronado seleccionado?\nSe eliminarán todos los datos asociados.");
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
						<span style="float:left">Empadronados</span>
						
					</h3>
				</div>
				<div id="fp-bcontainer" class="text-m">
					<table class="display" cellspacing="0" cellpadding="3" border="0">
						<tbody>

							<tr class="header">
								<th id="fp-table2">DPI</th>
								<th id="fp-table2">Apellidos</th>
								<th id="fp-table2">Nombres</th>
								<th id="fp-table2">Direccion</th>
								<th id="fp-table2">Departamento</th>
								<th id="fp-table2">Municipio</th>
								<th id="fp-table2">Modificar</th>
								<th id="fp-table2">Eliminar</th>
							</tr>

							<?php
								include 'connection.php';
								$link = OpenCon();

								$query = "SELECT E.dpi, E.nombres, E.apellidos, E.direccion, D.nombre as dep, M.nombre as mun FROM empadronado E, departamento D, municipio M WHERE E.departamento = D.codigo AND E.municipio = M.codigo ORDER BY E.dpi";
								$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());

								$dpi=0;
								$nombres = "";
								$apellidos ="";
								$direccion = "";
								$departamento = "";
								$municipio = "";

								while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC))
								{

									$dpi=$line["dpi"];
									$nombres=$line["nombres"];
									$apellidos = $line["apellidos"];
									$direccion = $line["direccion"];
									$departamento = $line["dep"];
									$municipio = $line["mun"];

									echo "\t<tr>\n";
									echo "<td id=\"fp-btable1\"><img alt=\"acc\" src=\"img/acc.png\" style=\"padding-right:5px;\">$dpi</td>\n";
									echo "<td id=\"fp-btable1\">$apellidos</td>\n";
									echo "<td id=\"fp-btable1\">$nombres</td>\n";
									echo "<td id=\"fp-btable1\">$direccion</td>\n";
									echo "<td id=\"fp-btable1\">$departamento</td>\n";
									echo "<td id=\"fp-btable1\">$municipio</td>\n";

									echo "<td id=\"fp-btable1\"><a href=modificar_emp.php?dpi=$dpi><img alt=\"Folder\" src=\"img/edit.png\"></a></td>\n";
									echo "<td id=\"fp-btable1\"><a onclick=\"return validate()\" href=eliminar_emp.php?dpi=$dpi><img alt=\"Folder\" src=\"img/delete.png\"></a></td>\n";
									
									echo "\t</tr>\n";
								}

								CloseCon($link);
							?>
							
						</tbody>
					</table>

				</div>
				<br>

				<div>
					<span style="float:center" valign="top"><a id="add-bttn" href="empadronados.php" onclick="return true;">Regresar</a></span>
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