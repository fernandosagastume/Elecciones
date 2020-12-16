<html>
	<head>
		<title>
			Departamentos
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

								$mun=$_GET["mun"];
								$dep = $_GET["dep"];
								$link = OpenCon();

								$query = "DELETE FROM Municipio WHERE codigo = $mun";
								$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error($link));
								if ($result)
								{
									echo "Municipio borrado exitosamente.";
								}
								else
								{
									echo "Ocurrio un error en el procesamiento de su peticion.";
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