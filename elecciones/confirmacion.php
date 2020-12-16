<html>
	<head>
		<title>
			Voto Electrónico
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
	</head>
	<body>
		<div id="fp-container">
			<div id="fp-header">
				<h1 id="fp-enterprise">
					<span style="float:left"><a href="votoe.php">ELECCIONES 2019</a></span>
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
								$dpi=$_POST["dpi"];
								$dpi = str_replace(" ", "", $dpi);
								$dpi = str_replace("-", "", $dpi);

								$link = OpenCon();

								

								$query = "SELECT COUNT(dpi) as cant from Empadronado WHERE dpi = $dpi";
								$result = pg_query($link, $query);
								$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);
								$cant = $line["cant"];
								$page = "";

								if ($cant == 0)
								{
									echo "Usted no se ha empadronado. Voto electronico rechazado.";
									$page = "votoe.php";
								}
								else
								{
									echo "DPI validado. Prosiga a las boletas.";
									$page = "votomenu.php?dpi=$dpi";
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
							echo "<span style=\"float:center\" valign=\"top\"><a id=\"add-bttn\" href=\"$page\" onclick=\"return true;\">Continuar</a></span>";
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