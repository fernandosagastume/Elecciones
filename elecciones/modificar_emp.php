<html>
	<head>
		<title>
			Empadronados
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
		<script>
			function validate()
			{
				return true;
			}

			function change()
			{
				document.empadronamiento.municipio.value = '';
				dep = document.empadronamiento.departamento.value * 100;
				max = dep + 100;
				
				var municipios = document.getElementById("munic").getElementsByTagName("option");
				for (var i = 0; i < municipios.length; i++) {
				  (dep <= municipios[i].value && municipios[i].value < max) 
				    ? municipios[i].hidden = false 
				    : municipios[i].hidden = true ;
				}

				document.empadronamiento.municipio.disabled = false;
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
						<span style="float:left">Registrar Ciudadano</span>
						
					</h3>
				</div>
				<div id="fp-bcontainer" class="text-m">
				<form name="empadronamiento" action="update_emp.php" method="post">
					<table class="display" cellspacing="0" cellpadding="3" border="0">
						<tbody>

							<tr class="header">
								<th id="fp-table2">Campo</th>
								<th id="fp-table2"></th>
							</tr>
							
							<tr>
								<td id="fp-btable1">DPI</td>
								<?php
									$dpi = $_GET["dpi"];
									echo "<td id=\"fp-btable1\">$dpi</td>";
									echo "<td id=\"fp-btable1\"><input type=\"text\" name=\"dpi\" style=\"text-align:center\" required value=\"$dpi\" hidden></td>";
								?>
							</tr>

							<tr>
								<td id="fp-btable1">Nombres</td>
								<?php
									include 'connection.php';
									$link = OpenCon();
									$query = "SELECT * FROM Empadronado WHERE dpi = $dpi";
									$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error($link));
									$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);
									$nombres = $line["nombres"];
									echo "<td id=\"fp-btable1\"><TEXTAREA Name=\"nombres\" ROWS=\"2\" COLS=\"40\" required>$nombres</TEXTAREA></td>";
								?>
							</tr>

							<tr>
								<td id="fp-btable1">Apellidos</td>
								<?php
									$apellidos = $line["apellidos"];
									echo "<td id=\"fp-btable1\"><TEXTAREA Name=\"apellidos\" ROWS=\"2\" COLS=\"40\" required>$apellidos</TEXTAREA></td>";
								?>
							</tr>

							<tr>
								<td id="fp-btable1">Departamento</td>
								<td id="fp-btable1">
									<select name="departamento" required style="text-align:center;" onchange="change()">
										<?php
											$departamento = $line["departamento"];
											$query = "SELECT codigo, nombre FROM Departamento WHERE codigo = $departamento";
											$result1 = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
											$line1 = pg_fetch_array($result1, NULL, PGSQL_ASSOC);
											$dep = $line1["nombre"];
											echo "<option selected value=\"$departamento\">$dep</option>";


											$query = "SELECT codigo, nombre FROM Departamento WHERE codigo > 0 AND codigo <> $departamento ORDER BY nombre";
											$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
											$codigo="";
											$nombre=0;

											while ($line1 = pg_fetch_array($result, NULL, PGSQL_ASSOC))
											{
											   	$codigo=$line1["codigo"];
											   	$nombre=$line1["nombre"];

											   	$query2 = "SELECT COUNT(codigo) as cant FROM Municipio WHERE departamento = $codigo";
												$result2 = pg_query($link, $query2) or die('Query failed: ' . pg_result_error());
												$line2 = pg_fetch_array($result2, NULL, PGSQL_ASSOC);

												if ($line2["cant"] != 0)
												{
													echo "<option value=\"$codigo\">$nombre</option>\n";
												}
											}
										?>
									</select>
								</td>
							</tr>

							<tr>
								<td id="fp-btable1">Municipio</td>
								<td id="fp-btable1">
									<select name="municipio" required style="text-align:center;" id="munic">
										<option disabled value>-- Escoger Municipio --</option>
										<?php
											$municipio = $line["municipio"];
											$query = "SELECT codigo, nombre FROM Municipio WHERE codigo = $municipio";
											$result1 = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
											$line1 = pg_fetch_array($result1, NULL, PGSQL_ASSOC);
											$dep = $line1["nombre"];
											echo "<option selected value=\"$municipio\">$dep</option>";


											$query = "SELECT codigo, nombre FROM Municipio WHERE codigo <> $municipio ORDER BY nombre";
											$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
											$codigo="";
											$nombre=0;
											$departamento = $departamento * 100;
											$max = $departamento + 100;

											while ($line1 = pg_fetch_array($result, NULL, PGSQL_ASSOC))
											{
											   $codigo=$line1["codigo"];
											   $nombre=$line1["nombre"];

											   if ($departamento <= $codigo && $codigo < $max)
											   {
													echo "<option value=\"$codigo\">$nombre</option>\n";
											   }
											   else
											   {
											   	echo "<option value=\"$codigo\" hidden>$nombre</option>\n";
											   }
											   
											}
										?>
									</select>
								</td>
							</tr>

							<tr>
								<td id="fp-btable1">Direccion</td>
								<?php
									$direccion = $line["direccion"];
									echo "<td id=\"fp-btable1\"><TEXTAREA Name=\"direccion\" ROWS=\"2\" COLS=\"40\" required>$direccion</TEXTAREA></td>";
								?>
							</tr>

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
					<span style="float:center" valign="top"><a id="add-bttn" href="lista_emp.php" onclick="return true;">Regresar</a></span>
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