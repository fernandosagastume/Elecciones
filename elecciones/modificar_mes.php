<html>
	<head>
		<title>
			Mesas
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
		<script>
			function validate()
			{
				mini = document.regmesas.min.value;
				maxi = document.regmesas.max.value;

				temp = (maxi - mini) > 0;
				
				mini = mini.toString();
				maxi = maxi.toString();

				re = new RegExp("[- ]", 'g');
				mini = mini.replace(re, '');
				len1 = (mini.length == 13)? true:false;
				if (!len1)
				{
					alert("El rango minimo ingresado debe tener 13 digitos.");
				}
				
				maxi = maxi.replace(re, '');
				len2 = (maxi.length == 13)? true:false;
				if (!len2)
				{
					alert("El rango maximo ingresado debe tener 13 digitos.");
				}

				re = new RegExp("[^0-9]");
				format1 = (mini.match(re))? false:true;
				if (!format1)
				{
					alert("El rango minimo ingresado debe tener únicamente dígitos.");
				}

				format2 = (maxi.match(re))? false:true;
				if (!format2)
				{
					alert("El rango maximo ingresado debe tener únicamente dígitos.");
				}

				minval = format1 && len1;
				maxval = format2 && len2;

				if (minval && maxval)
				{	
					if (temp)
					{
						return true;
					}
					else
					{
						alert("El rango maximo ingresado debe ser mayor al rango minimo");
						return false;
					}
				}
				else
				{
					return false;
				}

			}

			function change()
			{
				document.regmesas.municipio.value = '';
				dep = document.regmesas.departamento.value * 100;
				max = dep + 100;
				
				var municipios = document.getElementById("munic").getElementsByTagName("option");
				for (var i = 0; i < municipios.length; i++) {
				  (dep <= municipios[i].value && municipios[i].value < max) 
				    ? municipios[i].hidden = false 
				    : municipios[i].hidden = true ;
				}

				document.regmesas.municipio.disabled = false;
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
						<span style="float:left">Registrar Mesa de Votacion</span>
						
					</h3>
				</div>
				<div id="fp-bcontainer" class="text-m">
				<form name="regmesas" action="update_mes.php" method="post">
					<table class="display" cellspacing="0" cellpadding="3" border="0">
						<tbody>

							<tr class="header">
								<th id="fp-table2">Campo</th>
								<th id="fp-table2"></th>
							</tr>
							
							<tr>
								<td id="fp-btable1">No. de Mesa</td>
								<td id="fp-btable1">
									<?php
										$mesa = $_GET["mesa"];
										echo "$mesa";
										echo "<td id=\"fp-btable1\"><input type=\"number\" value=\"$mesa\" name=\"mesa\" min=\"0\" style=\"text-align:center\" required hidden></td>";
									?>
								</td>
							</tr>

							<tr>
								<td id="fp-btable1">Nombre del Presidente</td>
								<td id="fp-btable1">
									<?php
										include 'connection.php';
										$link = OpenCon();

										$query = "SELECT * FROM Mesa WHERE no_mesa = $mesa";
										$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());

										$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);

										$presidente = $line["nombrepresidente"];
										echo "<TEXTAREA Name=\"presidente\" ROWS=\"2\" COLS=\"40\" required>$presidente</TEXTAREA>";
									?>
								</td>
							</tr>

							<tr>
								<td id="fp-btable1">Nombre del Secretario</td>
								<td id="fp-btable1">
									<?php
										$secretario = $line["secretario"];
										echo "<TEXTAREA Name=\"secretario\" ROWS=\"2\" COLS=\"40\" required>$secretario</TEXTAREA>";
									?>
								</td>
							</tr>

							<tr>
								<td id="fp-btable1">Nombre del Vocal</td>
								<td id="fp-btable1">
									<?php
										$vocal = $line["vocal"];
										echo "<TEXTAREA Name=\"vocal\" ROWS=\"2\" COLS=\"40\" required>$vocal</TEXTAREA>";
									?>
								</td>
							</tr>

							<tr>
								<td id="fp-btable1">Nombre del Alguacil</td>
								<td id="fp-btable1">
									<?php
										$alguacil = $line["alguacil"];
										echo "<TEXTAREA Name=\"alguacil\" ROWS=\"2\" COLS=\"40\" required>$alguacil</TEXTAREA>";
									?>
								</td>
							</tr>

							<tr>
								<td id="fp-btable1">Departamento</td>
								<td id="fp-btable1">
									<select name="departamento" required style="text-align:center;" onchange="change()">
										<?php
											$municipio = $line["municipio"];

											$query1 = "SELECT D.codigo, D.nombre FROM Departamento D, Municipio M WHERE M.codigo = $municipio AND M.departamento = D.codigo";
											$result1 = pg_query($link, $query1) or die('Query failed: ' . pg_result_error());
											$line1 = pg_fetch_array($result1, NULL, PGSQL_ASSOC);
											$dep = $line1["nombre"];
											$departamento = $line1["codigo"];
											echo "<option selected value=\"$departamento\">$dep</option>";


											$query1 = "SELECT codigo, nombre FROM Departamento WHERE codigo > 0 AND codigo <> $departamento ORDER BY nombre";
											$result1 = pg_query($link, $query1) or die('Query failed: ' . pg_result_error());
											$codigo="";
											$nombre=0;

											while ($line1 = pg_fetch_array($result1, NULL, PGSQL_ASSOC))
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
											$query = "SELECT codigo, nombre FROM Municipio WHERE codigo = $municipio";
											$result1 = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
											$line1 = pg_fetch_array($result1, NULL, PGSQL_ASSOC);
											$dep = $line1["nombre"];
											echo "<option selected value=\"$municipio\">$dep</option>";


											$query = "SELECT codigo, nombre FROM Municipio WHERE codigo <> $municipio ORDER BY nombre";
											$result1 = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
											$codigo="";
											$nombre=0;
											$departamento = $departamento * 100;
											$max = $departamento + 100;

											while ($line1 = pg_fetch_array($result1, NULL, PGSQL_ASSOC))
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
								<td id="fp-btable1">Nombre de la Ubicacion</td>
								<td id="fp-btable1">
									<?php
										$ubicacion = $line["nombreubicacion"];
										echo "<TEXTAREA Name=\"ubicacion\" ROWS=\"2\" COLS=\"40\" required>$ubicacion</TEXTAREA>";
									?>
								</td>
							</tr>

							<tr>
								<td id="fp-btable1">Direccion de la Ubicacion</td>
								<td id="fp-btable1">
									<?php
										$direccion = $line["direccionubicacion"];
										echo "<TEXTAREA Name=\"direccion\" ROWS=\"2\" COLS=\"40\" required>$direccion</TEXTAREA>";
									?>
								</td>
							</tr>

							<tr>
								<td id="fp-btable1">Rango de Empadronamiento (Min)</td>
								<td id="fp-btable1">
									<?php
										$min = $line["rangoempadronamientominimo"];
										echo "<input type=\"number\" value=\"$min\" name=\"min\" min=\"0\" style=\"text-align:center\" required>";
									?>
								</td>
							</tr>

							<tr>
								<td id="fp-btable1">Rango de Empadronamiento (Max)</td>
								<td id="fp-btable1">
									<?php
										$max = $line["rangoempadronamientomaximo"];
										echo "<input type=\"number\" value=\"$max\" name=\"max\" min=\"0\" style=\"text-align:center\" required>";
									?>
								</td>
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