<html>
	<head>
		<title>
			Municipio
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
		<?php
			$dep = $_POST["cdep"];
			echo "<meta http-equiv=\"refresh\" content=\"2;url=municipios.php?dep=$dep\"/>";
		?>
		
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
						<span style="float:left">Aviso</span>
					</h3>
				</div>

				<br>
				<br>
				<br>


				<table class="display" cellspacing="0" cellpadding="3" border="0">
					<td id="fp-btable1">

						<span style="font-size: 17px">
							<?php
								include 'connection.php';
								$codigo = $_POST["codigo"] + (100*$dep);
								$nombre=$_POST["nombre"];
								$hab = $_POST["hab"];
								$link = OpenCon();

								

								$query = "SELECT COUNT(codigo) as cant from Municipio WHERE codigo = $codigo";
								$result = pg_query($link, $query);
								$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);
								$cant = $line["cant"];

								if ($cant == 0)
								{
									$query = "INSERT INTO Municipio VALUES ($codigo, '$nombre', $hab, $dep)";
									$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
									echo "Municipio ingresado exitosamente.";
								}
								else
								{
									echo "Rechazo de ingreso de municipio: ya existe un municipio con el mismo codigo.";
								}

								CloseCon($link);
							?>
						</span>
					</td>
				</table>
				<br>
				<table class="display" cellspacing="0" cellpadding="3" border="0">
					<td id="fp-btable1">
						<?php
							echo "<span style=\"float:center\" valign=\"top\"><a id=\"add-bttn\" href=\"municipios.php?dep=$dep\" onclick=\"return true;\">Regresar</a></span>";
						?>
					</td>
				</table>
				<br>
			</div>

			<div id="fp-footer" style="bottom: 0px">
				<h1 id="fp-project">
					Ciencias de la computacion V
				</h1>
			</div>
		</div>
	</body>
</html>