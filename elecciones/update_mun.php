<html>
	<head>
		<title>
			Municipios
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css">

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

								$dep=$_POST["dep"];
								$codigo=$_POST["codigo"];
								$nombre = $_POST["nombre"];
								$hab=$_POST["hab"];
								$dep=$_POST["dep"];

								$link = OpenCon();

								$query = "UPDATE Municipio SET nombre = '$nombre', no_habitantes = $hab WHERE codigo = $codigo AND departamento = $dep";
								$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());

								if ($result)
								{
									echo "Municipio actualizado exitosamente.";
								}
								else
								{
									echo "Rechazo de actualizacion de municipio: ya existe un municipio con el codigo modificado.";
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
							echo "<span style=\"float:center\" valign=\"top\"><a id=\"add-bttn\" href=\"lista_mun.php?dep=$dep\" onclick=\"return true;\">Regresar</a></span>";
							echo "<meta http-equiv=\"refresh\" content=\"2;url=lista_mun.php?dep=$dep\"/>";
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