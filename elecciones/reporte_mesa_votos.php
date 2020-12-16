<?php
include "connection.php";
$link = OpenCon();
if(isset($_POST["mesa"])){
	$nomesa = $_POST["mesa"];
}
?>

<!DOCTYPE html>
<html>
	<?php
	if(!$_POST){ 
	?>
	<head>
		<title>Reporte de Mesa</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
	</head>
		<body>
		<div id="fp-container">
			<div id="fp-header">
				<h1 id="fp-enterprise"><span style="float:left"><a href="index.php">ELECCIONES 2019</a></span></h1>
			</div>

			<div id="fp-body">
				<div id="fp-bcontainer">
					<h3 class="title"><span style="float:left">Reporte de Mesa</span></h3>
				</div>

				
				<div id="fp-bcontainer" class="text-m">
				<form name="formulariomesa" action="reporte_mesa_votos.php" method="POST" autocomplete="off" enctype="multipart/form-data">
					<table class="display" cellspacing="0" cellpadding="3" border="0">
						<tbody>
							<tr class="header">
								<th id="fp-table2">Campo</th>
								<th id="fp-table2"></th>
							</tr>	
							<tr>
								<td id="fp-btable1">Ingrese el No. de Mesa: </td>
								<td id="fp-btable1"><input type="number" name="mesa" style="text-align:center" required></td>
							</tr>
							<tr>
								<td id="fp-btable1">Tipo: </td>
								<td id="fp-btable1">
									<select style="text-align:center;" name="tipodevoto" required>
										<option value="votop">Presidente/Vicepresidente</option>
										<option value="votoa">Alcalde</option>
										<option value="votoln">Congreso/Listado Nacional</option>
										<option value="votodis">Congreso/Distrital</option>
									</select>
								</td>
							</tr>
						</tbody>
					</table>
					<br>
					<table class="display" cellspacing="0" cellpadding="3" border="0">
						<td id="fp-btable1"><span valign="top"><input type="submit" name="submit" value="Enviar" id="add-bttn" ></span></td>
					</table>
					</form>
				</div>

				<br>
				<div>
					<span style="float:center" valign="top"><a id="add-bttn" href="reportes.html">Regresar</a></span>
				</div>
			</div>

			<div id="fp-footer" style="bottom: 0px"><h1 id="fp-project">Ciencias de la computacion V</h1></div>
		</div>
	</body>
	<?php
	}else{
		$query = "SELECT * FROM mesa WHERE $nomesa=no_mesa";
		$existe = pg_num_rows(pg_query($link,$query));
		if($existe == 1){
	?>
	<head>
		<title>Reporte de Mesa</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="paper.min.css" rel="stylesheet" />
	</head>
	<body class="legal">
		<section class="sheet padding-25mm">
			<article>
				<?php
				$query_u = "SELECT * FROM mesa WHERE no_mesa=$nomesa";
				$datos = pg_fetch_array(pg_query($link,$query_u));
				$ubicacion = pg_fetch_array(pg_query($link,$query_u));
				$ubicacion = $ubicacion["municipio"];
				$query_n = "SELECT nombre FROM municipio WHERE codigo=$ubicacion";
				$ubicacion = pg_fetch_array(pg_query($link,$query_n));
				$ubicacion = $ubicacion["nombre"];
				?>
				<h1 style="font-size:30px;"><u>REPORTE DE MESA #<?php echo $nomesa;?></u></h1>
				<h3>ELECCIONES GUATEMALA 2019</h3>
				<p>
					<b>INFORMACION DE LA MESA</b><br>
					Municipio: <i> <?php echo $ubicacion;?> </i><br>
					Direccion: <i><?php echo $datos["direccionubicacion"];?></i> <br>
					Presidente de mesa: <i> <?php echo $datos["nombrepresidente"];?> </i><br>
					Secretario: <i> <?php echo $datos["secretario"];?> </i><br>
					Vocal: <i><?php echo $datos["vocal"];?></i> <br>
					Alguacil: <i><?php echo $datos["alguacil"];?></i> <br><br><br>

					<b><u>TIPO DE VOTACION - 
					<?php
					if($_POST["tipodevoto"] == "votop"){
						echo "PRESIDENTE/VICEPRESIDENTE </u></b><br><br><br>\n";
						$queryp = "SELECT partido,votopresidencia FROM conteofinal WHERE no_mesa=$nomesa";
						$resultp = pg_query($link,$queryp);

						?>

						<table style="border:1px solid black; border-collapse: collapse; width:100%;">
							<tr>
								<th style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;">Logo</th>
								<th style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;">Partido Politico</th>
								<th style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;">Votos</th>
							</tr>

							<?php
							while($linea = pg_fetch_array($resultp,NULL,PGSQL_ASSOC)){
								$partido = $linea["partido"];
								$votop = $linea["votopresidencia"];
								echo "<tr>";
								echo "<td style=\"text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;\"><img src=logo.php?data=$partido style=\"max-width: 50px; max-height: 50px\" /></td>";
								echo "<td style=\"text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;\">".strtoupper($partido)."</td>";
								echo "<td style=\"text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;\">$votop</td>";
								echo "</tr>";
							}
							?>
						</table>
						
						
						<?php
					}else if($_POST["tipodevoto"] == "votoa"){
						echo "ALCALDE </u></b><br><br><br>\n";
						$querya = "SELECT partido,votoalcalde FROM conteofinal WHERE no_mesa=$nomesa";
						$resulta = pg_query($link,$querya);

						?>
						
						<table style="border:1px solid black; border-collapse: collapse; width:100%;">
							<tr>
								<th style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;">Logo</th>
								<th style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;">Partido Politico</th>
								<th style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;">Votos</th>
							</tr>

							<?php
							while($linea = pg_fetch_array($resulta,NULL,PGSQL_ASSOC)){
								$partido = $linea["partido"];
								$votoa = $linea["votoalcalde"];
								echo "<tr>";
								echo "<td style=\"text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;\"><img src=logo.php?data=$partido style=\"max-width: 50px; max-height: 50px\" /></td>";
								echo "<td style=\"text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;\">".strtoupper($partido)."</td>";
								echo "<td style=\"text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;\">$votoa</td>";
								echo "</tr>";
							}
							?>
						</table>
						
						<?php
					}else if($_POST["tipodevoto"] == "votodep"){
						echo "CONGRESO/DEPARTAMENTAL </b><br><br><br>\n";

					}else if($_POST["tipodevoto"] == "votoln"){
						echo "CONGRESO/LISTADO NACIONAL </u></b><br><br><br>\n";
						$queryln = "SELECT partido,votodiputadoslistadonacional FROM conteofinal WHERE no_mesa=$nomesa<br>";
						$resultln = pg_query($link,$queryln);

						?>
						<table style="border:1px solid black; border-collapse: collapse; width:100%;">
							<tr>
								<th style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;">Logo</th>
								<th style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;">Partido Politico</th>
								<th style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;">Votos</th>
							</tr>

							<?php
							while($linea = pg_fetch_array($resultln,NULL,PGSQL_ASSOC)){
								$partido = $linea["partido"];
								$votoln = $linea["votodiputadoslistadonacional"];
								echo "<tr>";
								echo "<td style=\"text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;\"><img src=logo.php?data=$partido style=\"max-width: 50px; max-height: 50px\" /></td>";
								echo "<td style=\"text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;\">".strtoupper($partido)."</td>";
								echo "<td style=\"text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;\">$votoln</td>";
								echo "</tr>";
							}
							?>
						</table>
						<?php
					}else if($_POST["tipodevoto"] == "votodis"){
						echo "CPNGRESO/DISTRITO CENTAL </u></b><br><br><br>\n";
						$querydis = "SELECT partido,votodiputadosdistritales FROM conteofinal WHERE no_mesa=$nomesa";
						$resultdis = pg_query($link,$querydis);

						?>
						<table style="border:1px solid black; border-collapse: collapse; width:100%;">
							<tr>
								<th style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;">Logo</th>
								<th style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;">Partido Politico</th>
								<th style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;">Votos</th>
							</tr>

							<?php
							while($linea = pg_fetch_array($resultdis,NULL,PGSQL_ASSOC)){
								$partido = $linea["partido"];
								$votodis = $linea["votodiputadosdistritales"];
								echo "<tr>";
								echo "<td style=\"text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;\"><img src=logo.php?data=$partido style=\"max-width: 50px; max-height: 50px\" /></td>";
								echo "<td style=\"text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;\">".strtoupper($partido)."</td>";
								echo "<td style=\"text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;\">$votodis</td>";
								echo "</tr>";
							}
							?>
						</table>
						<?php
					}
					?>


				</p>
					
			</article>
		</section>
	</body>
	<?php
		}else{ ?>
		<head>
			<title>Reporte de Mesa</title>
			<link rel="stylesheet" type="text/css" href="styles.css">
	    </head>
		<body>
		<div id="fp-container">
			<div id="fp-header">
				<h1 id="fp-enterprise"><span style="float:left"><a href="index.php">ELECCIONES 2019</a></span></h1>
			</div>

			<div id="fp-body">
				<div id="fp-bcontainer">
					<h3 class="title"><span style="float:left">Reporte de Mesa</span></h3>
				</div>	
				<div id="fp-bcontainer" class="text-m">
					<table class="display" cellspacing="0" cellpadding="3" border="0">
						<td id="fp-btable1">
							<span style="font-size: 17px">
							<?php echo "No existe la mesa ".$nomesa.".";?>
						    </span>
					    </td>
				    </table>
				</div>
				<br>
				<div>
					<span style="float:center" valign="top"><a id="add-bttn" href="reporte_mesa_votos.php">Regresar</a></span>
				</div>
			</div><div id="fp-footer" style="bottom: 0px"><h1 id="fp-project">Ciencias de la computacion V</h1></div></div>
	    </body>
		<?php
		}
	}
	?>
	



</html>