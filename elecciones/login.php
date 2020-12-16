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
					<a href="login.php">ELECCIONES 2019</a>
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
								<th colspan="2" id="fp-table1">Tipo de Usuario</th>
								<th id="fp-table2">Login</th>
								<th id="fp-table2" style="width:300px;"></th>
							</tr>

							<tr>
								<td style="padding-left:15px; width:20px;"><img alt="Folder" src="img/acc.png"></td>
								<td width="350">
									<b>Administrador</b>
								</td>
								<td id="fp-btable1">
									<form name="cuentas" action="loginadmin.php" method="post">
										<input type="text" name="user" value="No Jaquies" required hidden>
										<input type="text" name="pass" value="" hidden>
										<input type="number" name="type" value="0" required hidden>
										<input type="submit" name="submit" value="Continuar...">
									</form>
								</td>
							</tr>

							<tr>
								<td style="padding-left:15px; width:20px;"><img alt="Folder" src="img/acc.png"></td>
								<td width="350">
									<b>Votante</b>
								</td>
								<td id="fp-btable1">
									<form name="cuentas" action="votoe.php" method="post">
										<input type="submit" name="submit" value="Continuar...">
									</form>
								</td>
							</tr>

						</tbody>
					</table>
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