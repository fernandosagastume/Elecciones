<html>
	<head>
		<title>
			Seleccion de Municipio
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
						<span style="float:left">INGRESE UN DEPARTAMENTO</span>
						
					</h3>
				</div>
				<div id="fp-bcontainer" class="text-m">
				<form name="depcode" action="reporte-diputadodistrital.php" method="post">
					<table class="display" cellspacing="0" cellpadding="3" border="0">
						<tbody>

							<tr class="header">
								<th id="fp-table2">Campo</th>
								<th id="fp-table2"></th>
							</tr>
							
							<tr>
								<td id="fp-btable1">Nombre del Departamento</td>
								<td id="fp-btable1">
									<select name="depart" required style="text-align:center;">
										<option disabled selected value>--Nombre de Departamento--</option>
										<option value="Municipios del Departamento de Guatemala">Municipios del Departamento de Guatemala</option>
										<option value="Distrito Central">Distrito Central</option>
										<?php
											include 'connection.php';

											$link = OpenCon();

											$query = "SELECT nombre FROM Departamento WHERE nombre != 'Pais Guatemala' AND nombre != 'Guatemala' ";
											$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());

											while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC))
											{
											   $nombre=$line["nombre"];
											   echo "\t\t\t\t\t\t\t\t\t\t<option value=\"$nombre\">$nombre</option>\n";
											}
									
										?>
										</select>
								</td>
							</tr>
							
						</tbody>
					</table>
					<br>
					<table class="display" cellspacing="0" cellpadding="3" border="0">
						<td id="fp-btable1">
								<span valign="top"><input type="submit" name="submit" value="Buscar" id="add-bttn" onclick="return validate()"></span>
						</td>
					</table>
					</form>
				</div>
				<br>

				<div>
					<span style="float:center" valign="top"><a id="add-bttn" href="listaderepresentantes-minorias.html" onclick="return true;">Regresar</a></span>
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