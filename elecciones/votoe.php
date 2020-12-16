<html>
	<head>
		<title>
			Voto Electrónico
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
		<script>
			function validate()
			{
				num = document.empadronado.dpi.value;
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
					alert("El DPI ingresado debe contener solamento numeros.");
				}

				return (len && format);
			}
		</script>
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
						<span style="float:left">Ingrese su DPI</span>
					</h3>
				</div>
				<div id="fp-bcontainer" class="text-m">
				<form name="empadronado" action="confirmacion.php" method="post">
					<table class="display" cellspacing="0" cellpadding="3" border="0">
						<tbody>
							<tr>
								<td id="fp-btable1">DPI</td>
								<td id="fp-btable1"><input type="text" name="dpi" style="text-align:center" required></td>
							</tr>
						</tbody>
					</table>
					<br>
					<table class="display" cellspacing="0" cellpadding="3" border="0">
						<td id="fp-btable1">
							<span valign="top">
								<input type="submit" name="submit" value="Enviar" id="add-bttn" onclick="return validate()">
							</span>
						</td>
					</table>
					</form>
				</div>
				<br>

				<div>
					<span style="float:center" valign="top"><a id="add-bttn" href="login.php" onclick="return true;">Regresar</a></span>
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