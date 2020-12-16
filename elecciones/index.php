<html>
	<head>
		<title>
			Proyecto 2 CCV
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
	</head>
	<body>
		<div id="fp-container">

			<div id="fp-header">
				<h1 id="fp-enterprise">
					<a href="index.php">ELECCIONES 2019</a>
				</h1>
			</div>

			<div id="fp-body">
				<div id="fp-bcontainer">
					<h3 class="title">
						Menu Principal 
					</h3>
					Hecho por: <br>
					<img alt="Folder" src="img/acc.png"><span style="padding-left:5px;">Isaí Pashel - 17001030</span><br>
					<img alt="Folder" src="img/acc.png"><span style="padding-left:5px;">Fernando Sagastume - 17004989</span><br>
					<img alt="Folder" src="img/acc.png"><span style="padding-left:5px;">Kevin Hernández - 17001095</span>
				</div>
				<div id="fp-bcontainer" class="text-m">
					<table class="display" cellspacing="0" cellpadding="3" border="0">
						<tbody>

							<tr class="header">
								<th colspan="2" id="fp-table1">Bienvenido</th>
								<th id="fp-table2">Numero</th>
								<th id="fp-table2" style="width:300px;"></th>
							</tr>

							<tr>
								<td style="padding-left:15px; width:20px;"><img alt="Folder" src="img/folder.png"></td>
								<td width="350">
									<b><a href="departamentos.php">Departamentos</a></b>
								</td>
								<td id="fp-btable1"><img alt="Folder" src="img/home.gif" style="padding-right:5px;">
									<b>
										<?php
											include 'connection.php';
											$link = OpenCon();
											$query = "SELECT Count(codigo) as total FROM Departamento D";
											$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error($link));
											$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);
											$total = $line["total"] -1 ;
											if ($total < 0)
											{
												echo "0";
											}
											else
											{
												echo "$total";
											}
										?>
									</b>
								</td>
							</tr>

							<tr>
								<td style="padding-left:15px; width:20px;"><img alt="Folder" src="img/folder.png"></td>
								<td width="350">
									<b><a href="empadronados.php">Empadronados</a></b>
								</td>
								<td id="fp-btable1"><img alt="Folder" src="img/acc.png" style="padding-right:5px;">
									<b>
										<?php
											$query = "SELECT Count(DPI) as total FROM Empadronado E";
											$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error($link));
											$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);
											$total = $line["total"];
											echo "$total";
										?>
									</b>
								</td>
							</tr>

							<tr>
								<td style="padding-left:15px; width:20px;"><img alt="Folder" src="img/folder.png"></td>
								<td width="350">
									<b><a href="partidospoliticos.php">Partidos Politicos</a></b>
								</td>
								<td id="fp-btable1"><img alt="Folder" src="img/flag.png" style="padding-right:5px;">
									<b>
										<?php
											$query = "SELECT Count(nombre) as total FROM PartidoPolitico P";
											$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error($link));
											$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);
											$total = $line["total"];
											echo "$total";
										?>
									</b>
								</td>
							</tr>

							<tr>
								<td style="padding-left:15px; width:20px;"><img alt="Folder" src="img/folder.png"></td>
								<td width="350">
									<b><a href="mesas.php">Mesas</a></b>
								</td>
								<td id="fp-btable1"><img alt="Folder" src="img/reportg.gif" style="padding-right:5px;">
									<b>
										<?php
											$query = "SELECT Count(no_mesa) as total FROM Mesa M";
											$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error($link));
											$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);
											$total = $line["total"];
											echo "$total";
											CloseCon($link);
										?>
									</b>
								</td>
							</tr>

							<tr>
								<td style="padding-left:15px; width:20px;"><img alt="Folder" src="img/folder.png"></td>
								<td width="350">
								<?php 
								echo "<b><a href=\"seleccionmesa-conteo.php\">Control de Votacion</a></b>";
								?>
								</td>
								<td id="fp-btable1">
									<b>
										---
									</b>
								</td>
							</tr>

							<tr>
								<td style="padding-left:15px; width:20px;"><img alt="Folder" src="img/folder.png"></td>
								<td width="350">
									<b><a href="reportes.html">Reportes</a></b>
									
								</td>
								<td id="fp-btable1"><img alt="Folder" src="img/case.png" style="padding-right:5px;"><b>6</b></td>
							</tr>

						</tbody>
					</table>
					<br>
						<table class="display" cellspacing="0" cellpadding="3" border="0">
							<td id="fp-btable1">
								<span style="float:center" valign="top"><a id="add-bttn" href="login.php" onclick="return true;">Log Out</a></span>
							</td>
						</table>
					<br>
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