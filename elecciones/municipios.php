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
						<?php 
							$dep = $_GET["dep"];
							include 'connection.php';
							$link = OpenCon();
							$query = "SELECT nombre FROM Departamento WHERE codigo = $dep";
							$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error($link));
							$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);

							$ndep = $line["nombre"];
							echo "<span style=\"float:left\">Municipios de $ndep</span>";
							CloseCon($link);
						?>
					</h3>
				</div>
				<div id="fp-bcontainer" class="text-m">
					<table class="display" cellspacing="0" cellpadding="3" border="0">
						<tbody>

							<tr>
								<th id="fp-table3">Municipios Registrados</th>
								<th id="fp-table2">Registrar Municipio</th>
							</tr>

							<tr>
								<?php
									
									echo "<td id=\"fp-btable2\"><img alt=\"Flag\" src=\"img/folder.png\" style=\"margin-left: 60px; padding-right:5px;\" ><a href=\"lista_mun.php?dep=$dep\">Municipios</a></td>"; 
									echo "<td id=\"fp-btable1\"><a href=\"registro_mun.php?dep=$dep\"><img alt=\"gen\" src=\"img/home.gif\" style=\"padding-right:5px;\">Registrar</a></td>";
								?>
							</tr>
							
						</tbody>
					</table>
				</div>
				<br>

				<div>
					<span style="float:center" valign="top"><a id="add-bttn" href="lista_dep.php" onclick="return true;">Regresar</a></span>
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