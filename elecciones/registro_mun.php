<html>
	<head>
		<title>
			Municipios
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
							$dep = $_GET["dep"];
							include 'connection.php';
							$link = OpenCon();
							$query = "SELECT nombre FROM Departamento WHERE codigo = $dep";
							$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error($link));
							$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);

							$ndep = $line["nombre"];
							echo "<span style=\"float:left\">Registrar Municipio de $ndep</span>";
							CloseCon($link);
						?>
					</h3>
				</div>
				<div id="fp-bcontainer" class="text-m">
				<form name="cuentas" action="insertar_mun.php" method="post">
					<table class="display" cellspacing="0" cellpadding="3" border="0">
						<tbody>

							<tr class="header">
								<th id="fp-table2">Campo</th>
								<th id="fp-table2"></th>
							</tr>

							<tr>
								<td id="fp-btable1">Codigo Departamento</td>
								<td id="fp-btable1">
									<?php
										echo "$dep";
										echo "<input value=\"$dep\" type=\"number\" min=\"0\" name=\"cdep\" style=\"text-align:center\" required hidden>";
									?>
								</td>
							</tr>
							
							<tr>
								<td id="fp-btable1">Codigo Municipio</td>
								<td id="fp-btable1">
									<input type="number" min="0" name="codigo" style="text-align:center" required>
								</td>
							</tr>

							<tr>
								<td id="fp-btable1">Nombre</td>
								<td id="fp-btable1"><input type="text" name="nombre" style="text-align:center" required></td>
							</tr>

							<tr>
								<td id="fp-btable1">Numero de Habitantes</td>
								<td id="fp-btable1"><input type="number" min="1" name="hab" style="text-align:center" required></td>
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