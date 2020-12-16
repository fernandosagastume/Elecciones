<?php
include "connection.php";
$link = OpenCon();
?>
<html>
	<head>
		<title>
			Conteo Final
		</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
		<script>
			function validate()
			{
				return true;
			}
		</script>
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
						<span style="float:left">INGRESAR LOS VOTOS DEL PARTIDO</span>
						
					</h3>
				</div>
				<div id="fp-bcontainer" class="text-m">
					<?php
					if (!$_POST){ 
					?> 
					   	<form name="cuentas" action="conteoFinal-IngresoVotos.php" method="post">
					<table class="display" cellspacing="0" cellpadding="3" border="0">
						<tbody>

							<tr class="header">
								<th id="fp-table2">Campo</th>
								<th id="fp-table2"></th>
							</tr>


							<tr>
								<td id="fp-btable1">Numero de Mesa</td>
								<td id="fp-btable1">
									<select name="no_mesa" required style="text-align:center;">
										<?php
											$no_mesa = $_GET["no_mesa"];
											$query = "SELECT no_mesa FROM mesa WHERE $no_mesa = no_mesa";
											$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
											$nombre="";

											while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC))
											{
											   $nombre=$line["no_mesa"];
											   echo "\t\t\t\t\t\t\t\t\t\t<option value=\"$no_mesa\">$no_mesa</option>\n";
											}

										?>
									</select>
								</td>
							</tr>
							
							<tr>
								<td id="fp-btable1">Partido Politico</td>
								<td id="fp-btable1">
									<select name="partido" required style="text-align:center;">
										<option disabled selected value>-- Escoger Partido Politico --</option>
										<?php
											$no_mesa = $_GET["no_mesa"];
											$query = "SELECT partido FROM conteofinal WHERE no_mesa = $no_mesa";
											$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
											$nombre="";

											while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC))
											{
											   $nombre=$line["partido"];
											   echo "\t\t\t\t\t\t\t\t\t\t<option value=\"$nombre\">$nombre</option>\n";
											}

										?>
									</select>
								</td>
							</tr>

							<tr>
								<td id="fp-btable1">No. de Votos de Presidencia</td>
								<td id="fp-btable1"><input type="number" name="votopresidencia" style="text-align:center" required></td>
							</tr>


							<tr>
								<td id="fp-btable1">No. de Votos de Alcaldía</td>
								<td id="fp-btable1"><input type="number" name="votoalcalde" style="text-align:center" required></td>
							</tr>

							<?php			

											$query = "SELECT municipio FROM mesa WHERE no_mesa = $no_mesa";
											$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
											$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);
											$codigo=$line["municipio"];
											$query1 = "SELECT nombre FROM municipio WHERE codigo = $codigo";
											$result1 = pg_query($link, $query1) or die('Query failed: ' . pg_result_error());
											$line1 = pg_fetch_array($result1, NULL, PGSQL_ASSOC);
											$nombre=$line1["nombre"];
											if($nombre == "Ciudad de Guatemala"){
												echo " <tr>";
												echo "<td id='fp-btable1'>Votos de Diputados(Distrito Central)</td>";
												echo "<td id='fp-btable1'><input type='number' name='votodiputadosdistritales' style='text-align:center' required></td>";
												echo " </tr>";
											}
											else {
												echo " <tr>";
												echo "<td id='fp-btable1'>Votos de Diputados(Distrital)</td>";
												echo "<td id='fp-btable1'><input type='number' name='votodiputadosdistritales' style='text-align:center' required></td>";
												echo " </tr>";
											}
											 
										?>


							<tr>
								<td id="fp-btable1">Votos de Diputados(Listado Nacional)</td>
								<td id="fp-btable1"><input type="number" name="votodisputadoslistadonacional" style="text-align:center" required></td>
							</tr>

							<tr>
								<td id="fp-btable1">Votos Nulos</td>
								<td id="fp-btable1"><input type="number" name="votosnulos" style="text-align:center" required></td>
							</tr>

							<tr>
								<td id="fp-btable1">Votos en Blanco</td>
								<td id="fp-btable1"><input type="number" name="votosblanco" style="text-align:center" required></td>
							</tr>

							<tr>
								<td id="fp-btable1">Votos en Blanco (Presidencia)</td>
								<td id="fp-btable1"><input type="number" name="votosblancopresi" style="text-align:center" required></td>
							</tr>

							<tr>
								<td id="fp-btable1">Votos Nulos (Presidencia)</td>
								<td id="fp-btable1"><input type="number" name="votosnulopresi" style="text-align:center" required></td>
							</tr>


							<tr>
								<td id="fp-btable1">Votos en Blanco (Alcaldia)</td>
								<td id="fp-btable1"><input type="number" name="votosblancoalcal" style="text-align:center" required></td>
							</tr>

							<tr>
								<td id="fp-btable1">Votos Nulos (Alcaldia)</td>
								<td id="fp-btable1"><input type="number" name="votosnuloalcal" style="text-align:center" required></td>
							</tr>

							<tr>
								<td id="fp-btable1">Votos en Blanco (Diputado Distrital)</td>
								<td id="fp-btable1"><input type="number" name="votosblancodistrital" style="text-align:center" required></td>
							</tr>

							<tr>
								<td id="fp-btable1">Votos Nulos (Diputado Distrital)</td>
								<td id="fp-btable1"><input type="number" name="votosnulodistrital" style="text-align:center" required></td>
							</tr>	

							<tr>
								<td id="fp-btable1">Votos en Blanco (Diputado Listado Nacional)</td>
								<td id="fp-btable1"><input type="number" name="votosblanconacional" style="text-align:center" required></td>
							</tr>

							<tr>
								<td id="fp-btable1">Votos Nulos (Diputado Listado Nacional)</td>
								<td id="fp-btable1"><input type="number" name="votosnulonacional" style="text-align:center" required></td>
							</tr>


						</tbody>
					</table>
					<br>
					<table class="display" cellspacing="0" cellpadding="3" border="0">
						<td id="fp-btable1">
								<span valign="top"><input type="submit" name="submit" value="Enviar" id="add-bttn" onclick="return validate()"></span>
						</td>
					</table>
					</form> 

					<?php 
					}else{ 
					   	
								$partido = $_POST["partido"];
								$no_mesa = $_POST["no_mesa"];
								$votopresidencia=$_POST["votopresidencia"];
								$votoalcalde = $_POST["votoalcalde"];
								$votodiputadosdistritales = $_POST["votodiputadosdistritales"];
								$votodisputadoslistadonacional = $_POST["votodisputadoslistadonacional"];
								$votosnulos=$_POST["votosnulos"];
								$votosblanco=$_POST["votosblanco"];
								$votosblancopresi=$_POST["votosblancopresi"];
								$votosnulopresi=$_POST["votosnulopresi"];
								$votosblancoalcal=$_POST["votosblancoalcal"];
								$votosnuloalcal=$_POST["votosnuloalcal"];
								$votosblancodistrital=$_POST["votosblancodistrital"];
								$votosnulodistrital=$_POST["votosnulodistrital"];
								$votosblanconacional=$_POST["votosblanconacional"];
								$votosnulonacional=$_POST["votosnulonacional"];
								
								$queryverifica = "SELECT COUNT(A.dpi) AS alca, COUNT(C.dpi) AS dipu, COUNT(P.dpi_presi) AS presi
											     FROM alcalde A, congreso C, presidencia P
											     WHERE A.partido = C.partido AND C.partido = P.partido AND P.partido = A.partido";
								$resultverifica = pg_query($link, $queryverifica) or die('Query failed: ' . pg_result_error());
								$lineverifica = pg_fetch_array($resultverifica, NULL, PGSQL_ASSOC);
								$alca=$lineverifica["alca"];
								$dipu=$lineverifica["dipu"];
								$presi=$lineverifica["presi"];

								if ($presi != 0 && $alca != 0 && $dipu != 0){

									$query = "UPDATE conteofinal SET votopresidencia = $votopresidencia, votoalcalde = $votoalcalde, votodiputadosdistritales = $votodiputadosdistritales, votodiputadoslistadonacional = $votodisputadoslistadonacional, votoblancopresi = $votosblancopresi,
									    votonulopresi = $votosnulopresi, votoblancoalcal = $votosblancoalcal, votonuloalcal = $votosnuloalcal,  votoblancodistrital = $votosblancodistrital, votonulodistrital = $votosnulodistrital,  votoblanconacional = $votosblanconacional, votonulonacional = $votosnulonacional WHERE $no_mesa = no_mesa AND '$partido' = partido";

									$querynulo = "SELECT votosnulos FROM mesa WHERE no_mesa = $no_mesa";
									$queryblanco = "SELECT votosblanco FROM mesa WHERE no_mesa = $no_mesa";
									$resultnulo = pg_query($link, $querynulo) or die('Query failed: ' . pg_result_error());
									$resultblanco = pg_query($link, $queryblanco) or die('Query failed: ' . pg_result_error()); 
									$linenulo = pg_fetch_array($resultnulo, NULL, PGSQL_ASSOC);
									$lineblanco = pg_fetch_array($resultblanco, NULL, PGSQL_ASSOC);
									$nulo=$linenulo["votosnulos"];
									$blanco=$lineblanco["votosblanco"];
									$losnulos = $votosnulos + $nulo;
									$losblanco = $votosblanco + $blanco;
									$query1 = "UPDATE mesa SET votosnulos = $losnulos, votosblanco = $losblanco WHERE $no_mesa = no_mesa";
									
									$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
									$result1 = pg_query($link, $query1) or die('Query failed: ' . pg_result_error());
									echo "Los votos ha sido ingresado exitosamente.";
									CloseCon($link);
								}
								else {
								
									echo "<h2 class='title'>
											<span style='float:left'>
											El partido politico no tiene suficientes candidatos, por favor intente con otro partido.
											</span>
											</h2>";
								}
								
					} 
					?>
			</div>
				<br>

				<div>
					<span style="float:center" valign="top"><a id="add-bttn" href="seleccionmesa-conteo.php" onclick="return true;">Regresar</a></span>
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