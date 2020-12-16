<?php
include "connection.php";
$link = OpenCon();
$nodemsa = "?";
$municipio = "?";
if(isset($_POST["mesa"])){
	$nodemsa = $_POST["mesa"];
	$queryM = "SELECT municipio FROM mesa WHERE $nodemsa=no_mesa";
	if(pg_num_rows(pg_query($link,$queryM)) != 0){
		$filaM = pg_fetch_array(pg_query($link,$queryM));
		$codigoM = $filaM["municipio"];
		$queryM = "SELECT nombre FROM municipio WHERE codigo=$codigoM";
		$nombrem = pg_fetch_array(pg_query($link,$queryM));
		$municipio = $nombrem["nombre"];
	}
}
?>
<html>
	<head>
		<title>PADRON POR MESA #<?php echo $nodemsa;?></title>
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
			<?php if(isset($_POST["submitmesa"])){?>
				<div id="fp-bcontainer">
					<h3 class="title">
						<span style="float:left">Padron por Mesa #<?php echo $nodemsa;?></span>
					</h3>
					<h3 class="title">
						<span style="float:left">Municipio: <?php echo $municipio;?></span>
					</h3>
				</div>
				<br><br><br>
				<?php
				$querymesa = "SELECT no_mesa FROM mesa WHERE no_mesa=$nodemsa";
				if(pg_num_rows(pg_query($link,$querymesa)) != 0){ ?>
				<div id="fp-bcontainer" class="text-m">
                    <table class="display" cellspacing="0" cellpadding="3" border="0">
                        <tbody>
                            <tr class="header">
                                <th id="fp-table2">DPI</th>
                                <th id="fp-table2">Nombres</th>
                                <th id="fp-table2">Apellidos</th>
                            </tr>
							<?php
							$queryE = "SELECT dpi,nombres,apellidos FROM Empadronado WHERE municipio=$codigoM";
							$resultado = pg_query($link,$queryE);
							while($linea = pg_fetch_array($resultado,NULL,PGSQL_ASSOC)){
								$dpi = $linea["dpi"];
								$nombres = $linea["nombres"];
								$apellidos = $linea["apellidos"];
							?>
							<tr>
							<td id="fp-btable1"><?php echo $dpi;?></td>
							<td id="fp-btable1"><?php echo $nombres;?></td>
							<td id="fp-btable1"><?php echo $apellidos;?></td>
							</tr>
							<?php 
							}
							?>
                        </tbody>
                    </table>
                </div>
				<div>
					<span style="float:center" valign="top"><a id="add-bttn" href="padron_mesa.php">Regresar</a></span>
				</div>
				<?php }else{?>
				<table class="display" cellspacing="0" cellpadding="3" border="0">
					<td id="fp-btable1">
						<span style="font-size: 17px">
							<?php
							echo "<br>\n";
							echo "La mesa #".$nodemsa." no esta registrada.\n";
							?>
						</span>
					</td>
				</table>
				<div>
					<span style="float:center" valign="top"><a id="add-bttn" href="padron_mesa.php">Regresar</a></span>
				</div>
				<?php }?>
			<?php }else{?>
				<div id="fp-bcontainer">
					<h3 class="title">
						<span style="float:left">Reporte de Mesa</span>
					</h3>
				</div>
				<br><br>
				<div id="fp-bcontainer" class="text-m">
                    <form name="formmesa" action="padron_mesa.php" method="POST" autocomplete="off">
                        <table class="display" cellspacing="0" cellpadding="3" border="0">
                            <tbody>
                                <tr class="header">
                                    <th id="fp-table2">Campo</th>
                                    <th id="fp-table2"></th>
                                </tr>
                                <tr>
                                    <td id="fp-btable1">Buscar No. de Mesa</td>
                                    <td id="fp-btable1"><input type="number" name="mesa" style="text-align:center" required></td>
                                </tr>                  
                            </tbody>
                        </table>
                        <br>
                        <table class="display" cellspacing="0" cellpadding="3" border="0">
                            <td id="fp-btable1">
                                <span valign="top"><input type="submit" name="submitmesa" value="Buscar" id="add-bttn"></span>
                            </td>
                        </table>
                    </form>
                </div>
				<div>
					<span style="float:center" valign="top"><a id="add-bttn" href="reportes.html">Regresar</a></span>
				</div>
			<?php }?>
			</div>

			<div id="fp-footer" style="bottom: 0px">
				<h1 id="fp-project">
					Ciencias de la computacion V
				</h1>
			</div>
		</div>
	</body>
</html>