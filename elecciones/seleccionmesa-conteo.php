<html>
	<head>
		<title>
			Conteo Final
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
						<span style="float:left">INGRESE NUMERO DE MESA</span>
						
					</h3>
				</div>
				<div id="fp-bcontainer" class="text-m">
				<form name="nummesa" action="conteoFinal-IngresoVotos.php" method="get">
					<table class="display" cellspacing="0" cellpadding="3" border="0">
						<tbody>

							<tr class="header">
								<th id="fp-table2">Campo</th>
								<th id="fp-table2"></th>
							</tr>
							
							<tr>
								<td id="fp-btable1">Numero de Mesa</td>
								<td id="fp-btable1">
									<select name="no_mesa" required style="text-align:center;">
										<option disabled selected value>--Seleccione Numero de Mesa--</option>
										<?php
											include 'connection.php';

											$link = OpenCon();

											$query = "SELECT no_mesa FROM mesa";
											$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
										

											while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC))
											{
											   $no_mesa=$line["no_mesa"];
											   echo "\t\t\t\t\t\t\t\t\t\t<option value=\"$no_mesa\">$no_mesa</option>\n";
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
					<span style="float:center" valign="top"><a id="add-bttn" href="index.php" onclick="return true;">Regresar</a></span>
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