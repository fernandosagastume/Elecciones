<html>
	<head>
		<title>
			Departamentos
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
		<script>
			function validate()
			{
				c = confirm("¿Borrar el departamento seleccionado?\nSe eliminarán todos los datos asociados.");
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
						<span style="float:left">Departamentos</span>
						
					</h3>
				</div>
				<div id="fp-bcontainer" class="text-m">
					<table class="display" cellspacing="0" cellpadding="3" border="0">
						<tbody>

							<tr class="header">
								<th id="fp-table2">Codigo</th>
								<th id="fp-table2">Nombre</th>
								<th id="fp-table2">Cant. Municipios</th>
								<th id="fp-table2">Gestionar Municipios</th>
								<th id="fp-table2">Modificar</th>
								<th id="fp-table2">Eliminar</th>
							</tr>

							<?php
								include 'connection.php';
								$link = OpenCon();

								$query = "SELECT * FROM Departamento ORDER BY codigo";
								$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());

								$codigo=0;
								$nombre = "";

								while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC))
								{

									$codigo=$line["codigo"];
									$nombre=$line["nombre"];

									$query1 = "SELECT COUNT(codigo) as cant FROM Municipio WHERE departamento = $codigo";
									$result1 = pg_query($link, $query1) or die('Query failed: ' . pg_result_error());
									$line1 = pg_fetch_array($result1, NULL, PGSQL_ASSOC);

									$cant = $line1["cant"];

									echo "\t<tr>\n";
									echo "<td id=\"fp-btable1\"><img alt=\"acc\" src=\"img/home.gif\" style=\"padding-right:5px;\">$codigo</td>\n";
									echo "<td id=\"fp-btable1\">$nombre</td>\n";
									echo "<td id=\"fp-btable1\">$cant</td>\n";

									if ($codigo != 0)
									{
										echo "<td id=\"fp-btable1\"><a href=municipios.php?dep=$codigo><img alt=\"Folder\" src=\"img/gen.png\"></a></td>\n";
									}
									else
									{
										echo "<td id=\"fp-btable1\"></td>\n";
									}
									echo "<td id=\"fp-btable1\"><a href=modificar_dep.php?codigo=$codigo><img alt=\"Folder\" src=\"img/edit.png\"></a></td>\n";
									echo "<td id=\"fp-btable1\"><a onclick=\"return validate()\" href=eliminar_dep.php?codigo=$codigo><img alt=\"Folder\" src=\"img/delete.png\"></a></td>\n";		
									echo "\t</tr>\n";
								}

								CloseCon($link);
							?>
							
						</tbody>
					</table>

				</div>
				<br>

				<div>
					<span style="float:center" valign="top"><a id="add-bttn" href="departamentos.php" onclick="return true;">Regresar</a></span>
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