<html>
	<head>
		<title>
			Mesas
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
		<script>
			function validate()
			{
				c = confirm("¿Borrar la mesa seleccionada?\nSe eliminarán todos los datos asociados.");
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
						<span style="float:left">Mesas</span>
						
					</h3>
				</div>
				<div id="fp-bcontainer" class="text-m">
					<table class="display" cellspacing="0" cellpadding="3" border="0">
						<tbody>

							<tr class="header">
								<th id="fp-table2">No. de Mesa</th>
								<th id="fp-table2">Departamento</th>
								<th id="fp-table2">Municipio</th>
								<th id="fp-table2">Ubicacion</th>
								<th id="fp-table2">Direccion</th>
								<th id="fp-table2">Detalles</th>
								<th id="fp-table2">Modificar</th>
								<th id="fp-table2">Eliminar</th>
							</tr>

							<?php
								include 'connection.php';
								$link = OpenCon();

								$query = "SELECT M.no_mesa, M.nombreubicacion, M.direccionubicacion, C.nombre as mun, D.nombre as dep FROM Mesa M, Municipio C, Departamento D WHERE M.municipio = C.codigo AND C.departamento = D.codigo ORDER BY M.no_mesa ASC";
								$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());

								$mesa=0;
								$departamento = "";
								$municipio = "";
								$ubicacion = "";
								$direccion = "";

								while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC))
								{

									$mesa=$line["no_mesa"];
									$departamento = $line["dep"];
									$municipio = $line["mun"];
									$ubicacion = $line["nombreubicacion"];
									$direccion = $line["direccionubicacion"];

									echo "\t<tr>\n";
									echo "<td id=\"fp-btable1\"><img alt=\"acc\" src=\"img/reportg.gif\" style=\"padding-right:5px;\">$mesa</td>\n";
									echo "<td id=\"fp-btable1\">$departamento</td>\n";
									echo "<td id=\"fp-btable1\">$municipio</td>\n";
									echo "<td id=\"fp-btable1\">$ubicacion</td>\n";
									echo "<td id=\"fp-btable1\">$direccion</td>\n";

									echo "<td id=\"fp-btable1\"><a href=detalles_mes.php?mesa=$mesa><img alt=\"Folder\" src=\"img/gen.png\"></a></td>\n";
									echo "<td id=\"fp-btable1\"><a href=modificar_mes.php?mesa=$mesa><img alt=\"Folder\" src=\"img/edit.png\"></a></td>\n";
									echo "<td id=\"fp-btable1\"><a onclick=\"return validate()\" href=eliminar_mes.php?mesa=$mesa><img alt=\"Folder\" src=\"img/delete.png\"></a></td>\n";
									
									echo "\t</tr>\n";
								}

								CloseCon($link);
							?>
							
						</tbody>
					</table>

				</div>
				<br>

				<div>
					<span style="float:center" valign="top"><a id="add-bttn" href="mesas.php" onclick="return true;">Regresar</a></span>
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