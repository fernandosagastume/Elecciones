<html>
	<head>
		<title>
			Empadronados
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
		<script>
			function validate()
			{
				num = document.empadronamiento.dpi.value;
				re = new RegExp("[- ]", 'g');
				num = num.replace(re, '')
				len = (num.length == 13)? true:false; 

				if(!len)
				{
					alert("El DPI debe contener 13 numeros en total.");
				}

				re = new RegExp("[^0-9]");
				format = (num.match(re))? false:true;

				if(!format)
				{
					alert("El DPI ingresado debe contener solamente numeros.");
				}

				return (len && format);
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
				<form name="empadronamiento" action="insertar_emp.php" method="post">
					<table class="display" cellspacing="0" cellpadding="3" border="0">
						<tbody>

							<tr class="header">
								<th id="fp-table2">Campo</th>
								<th id="fp-table2"></th>
							</tr>
							
							<tr>
								<td id="fp-btable1">DPI</td>
								<td id="fp-btable1"><input type="text" name="dpi" style="text-align:center" required></td>
							</tr>

							<tr>
								<td id="fp-btable1">Nombres</td>
								<td id="fp-btable1"><TEXTAREA Name="nombres" ROWS="2" COLS="40" required></TEXTAREA></td>
							</tr>

							<tr>
								<td id="fp-btable1">Apellidos</td>
								<td id="fp-btable1"><TEXTAREA Name="apellidos" ROWS="2" COLS="40" required></TEXTAREA></td>
							</tr>

							<tr>
								<td id="fp-btable1">Departamento</td>
								<td id="fp-btable1">
									<select name="departamento" required style="text-align:center;" onchange="change()">
										<option disabled selected value>-- Escoger Departamento --</option>
										<?php
											include 'connection.php';

											$link = OpenCon();

											$query = "SELECT codigo, nombre FROM Departamento WHERE codigo > 0 ORDER BY nombre";
											$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
											$codigo="";
											$nombre=0;

											while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC))
											{
												$codigo=$line["codigo"];
											   	$nombre=$line["nombre"];

												$query1 = "SELECT COUNT(codigo) as cant FROM Municipio WHERE departamento = $codigo";
												$result1 = pg_query($link, $query1) or die('Query failed: ' . pg_result_error());
												$line1 = pg_fetch_array($result1, NULL, PGSQL_ASSOC);

												if ($line1["cant"] != 0)
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
									<select name="municipio" required style="text-align:center;" id="munic" disabled>
										<option disabled selected value>-- Escoger Municipio --</option>
										<?php
											$query = "SELECT codigo, nombre FROM Municipio ORDER BY nombre";
											$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
											$codigo="";
											$nombre=0;

											while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC))
											{
											   $codigo=$line["codigo"];
											   $nombre=$line["nombre"];
											   echo "<option value=\"$codigo\">$nombre</option>\n";
											}

											CloseCon($link);
										?>
									</select>
								</td>
							</tr>

							<tr>
								<td id="fp-btable1">Direccion</td>
								<td id="fp-btable1"><TEXTAREA Name="direccion" ROWS="2" COLS="40" required></TEXTAREA></td>
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