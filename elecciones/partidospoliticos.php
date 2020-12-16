<html>
	<head>
		<title>
			Partidos Politicos
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
						<span style="float:left">Partidos Politicos</span>
						
					</h3>
				</div>
				<div id="fp-bcontainer" class="text-m">
					<table class="display" cellspacing="0" cellpadding="3" border="0">
						<tbody>

							<tr>
								<th id="fp-table3">Partidos Politicos Registrados</th>
								<th id="fp-table2">Registrar Partido Politico</th>
							</tr>

							<tr>
								<?php 
								echo "<td id=\"fp-btable2\"><img alt=\"Flag\" src=\"img/folder.png\" style=\"margin-left: 60px; padding-right:5px;\" ><a href=\"lista_pp.php?listar=\"\"\">Partidos Politicos</a></td>";
								?>
								<td id="fp-btable1"><a href="registro_pp.php"><img alt="gen" src="img/flag.png" style="padding-right:5px;">Registrar</a></td>
							</tr>
							
						</tbody>
					</table>
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