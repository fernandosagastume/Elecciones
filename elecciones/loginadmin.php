<html>
	<head>
		<title>
			Elecciones 2019
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
		<script>
			function showPassword()
			{
				var x = document.getElementById("spass");
				if (x.type === "password") {
				  x.type = "text";
				} else {
				  x.type = "password";
				}
			}
		</script>
	</head>
	<?php
		$user = $_POST["user"];
		$pass = $_POST["pass"];
		$type = $_POST["type"];
	?>
	<body>
		<div id="fp-container">

			<div id="fp-header">
				<h1 id="fp-enterprise">
					<span style="float:left"><a href="login.php">ELECCIONES 2019</a></span>
				</h1>
			</div>

			<div id="fp-body">
				<div id="fp-bcontainer">
					<h3 class="title">
						<span style="float:left">Ingresar</span>
						
					</h3>
				</div>
				<div id="fp-bcontainer" class="text-m">

				<?php
					if ($type == 0)
					{
						echo "<form name=\"cuentas\" action=\"loginadmin.php\" method=\"post\">";
						echo "<table class=\"display\" cellspacing=\"0\" cellpadding=\"3\" border=\"0\">";
						echo "<tbody>";

						echo "<tr class=\"header\">";
						echo "<th id=\"fp-table2\">Campo</th>";
						echo "<th id=\"fp-table2\"></th>";
						echo "</tr>";
									
						echo "<tr>";
						echo "<td id=\"fp-btable1\">Usuario</td>";
						echo "<td id=\"fp-btable1\">";
											
							echo "<input value=\"$user\" type=\"text\" name=\"user\" style=\"text-align:center\" required>";
											
						echo "</td>";
						echo "</tr>";

						echo "<tr>";
						echo "<td id=\"fp-btable1\">Contraseña</td>";
						echo "<td id=\"fp-btable1\">";
											
							echo "<input type=\"password\" name=\"pass\" style=\"text-align:center\" id=\"spass\" required>";
											
						echo "</td>";
						echo "</tr>";

						echo "<tr>";
						echo "<td id=\"fp-btable1\"></td>";
						echo "<td id=\"fp-btable1\">";
											
							echo "<input type=\"checkbox\" onclick=\"showPassword()\">Mostrar Contraseña";
											
						echo "</td>";
						echo "</tr>";

							echo "<input type=\"number\" name=\"type\" value=\"1\" required hidden>";

						echo "</tbody>";
						echo "</table>";
						echo "<br>";
						echo "<table class=\"display\" cellspacing=\"0\" cellpadding=\"3\" border=\"0\">";
						echo "<td id=\"fp-btable1\">";
						echo "<span valign=\"top\"><input type=\"submit\" name=\"submit\" value=\"Enviar\" id=\"add-bttn\" onclick=\"return validate()\"></span>";
						echo "</td>";
						echo "</table>";
						echo "</form>";
					}
					else
					{
						$con = @pg_connect("host=localhost port=5432 dbname=final user=$user password='$pass'");
						
						if ($con)
						{
							echo "<center><b><h3>Acceso Concedido</h3></b></center>";
							echo "<meta http-equiv=\"refresh\" content=\"1.5;url=index.php\"/>";
							echo "<br>";
						}
						else
						{
							echo "<center><h3><b>Acceso Denegado</b></h3></center>";
							echo "<meta http-equiv=\"refresh\" content=\"1.5;url=login.php\"/>";
							echo "<br>";
						}
					}
					
				?>

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