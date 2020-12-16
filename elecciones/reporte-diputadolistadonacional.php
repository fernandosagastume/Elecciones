<html>
	<head>
		<title>
			Lista de Representantes Electos por Listado Nacional
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
					RESULTADOS DE LISTADO NACIONAL
					</h3>
					<b><h4>
					<?php 
						include 'connection.php';
						$link = OpenCon();
						$query = "SELECT Count(nombre) as totalpartidos FROM partidopolitico";
						$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());

						$line = pg_fetch_array($result, NULL, PGSQL_ASSOC);
						$totalpartidos=$line["totalpartidos"];
						echo "Participaron en la elección $totalpartidos partidos";
						CloseCon($link);
					 ?> 					
					</h4></b>

				</div>
				<div id="fp-bcontainer" class="text-m">
					<table id = "ta1" class="display" cellspacing="0" cellpadding="3" border="0">
						<tbody>

							<tr class="header">
								<th id="fp-table2" >Nombre</th>
								<th id="fp-table2" >Apellidos</th>
								<th id="fp-table2" style='text-align:left;'>Partido Politico</th>
							</tr>
								<?php
										$link = OpenCon();
									
											$query = "SELECT nombre FROM partidopolitico";
											$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
											$arr = array();
											$arr1 = array();
											$arr2 = array();
											$cont = 0; 
											while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
												$nombre=$line["nombre"];
												$query1 = "SELECT sum(votodiputadoslistadonacional) as sumadevotos
															FROM conteofinal
															WHERE partido = '$nombre' ";	
												$result1 = pg_query($link, $query1) or die('Query failed: ' . pg_result_error());
												$line1 = pg_fetch_array($result1, NULL, PGSQL_ASSOC);
												$votos=$line1["sumadevotos"];

											    array_push($arr, $votos);
											    array_push($arr1, $votos);
											    array_push($arr2, $nombre);
											}
											 
											 rsort($arr);
											 $div2 = array();
											 $div3 = array();
											 $div4 = array();
											 $div5 = array();
											 for( $i = 0; $i<sizeof($arr); $i++) {
											 	array_push($div2, round($arr[$i]/2)); 
									         }
									         for( $i = 0; $i<sizeof($arr); $i++) {
											 	array_push($div3, round($arr[$i]/3)); 
									         }
									         for( $i = 0; $i<sizeof($arr); $i++) {
											 	array_push($div4, round($arr[$i]/4)); 
									         }
									         for( $i = 0; $i<sizeof($arr); $i++) {
											 	array_push($div5, round($arr[$i]/5)); 
									         }

									         $querytot = "SELECT Count(nombre) as totalpartidos FROM partidopolitico";
											$resultot = pg_query($link, $querytot) or die('Query failed: ' . pg_result_error());

											$linetot = pg_fetch_array($resultot, NULL, PGSQL_ASSOC);
											$partidonum=$linetot["totalpartidos"];

									         $divtotal = array_merge($div2,$div3,$div4,$div5);
									         rsort($divtotal);
									         if ($partidonum >= 7){
									         	 $cifrarepartidora = $divtotal[31]; 
									         }
									       	 
									         else {
									         	if ($partidonum == 6){
									         	 $cifrarepartidora = $divtotal[24]; 
									         	}
									         	if ($partidonum == 5){
									         	 $cifrarepartidora = $divtotal[16]; 
									         	}
									         	if ($partidonum == 4){
									         	 $cifrarepartidora = $divtotal[12]; 
									         	}
									         	if ($partidonum == 3){
									         	 $cifrarepartidora = $divtotal[8]; 
									         	}
									         	if ($partidonum == 2){
									         	 $cifrarepartidora = $divtotal[4]; 
									         	}
									         	if ($partidonum == 2){
									         	 $cifrarepartidora = $divtotal[2]; 
									         	}
									         }
									       	 $arrfin = array();
											 for( $i = 0; $i<sizeof($arr1); $i++) {
											 	if($cifrarepartidora != 0){
											 	   array_push($arrfin, floor($arr1[$i]/$cifrarepartidora));
											 	} 
									         }
									         $algo = array_merge($arrfin,$arr2);
											 
											 
											for( $i = $partidonum, $j = 0; $i<sizeof($algo); $i++, $j++) {
												if ($algo[$j] != 0){
													for ($cont = 1; $cont<=$algo[$j]; $cont++){

														$consu = "SELECT E.nombres, E.apellidos FROM empadronado E, congreso C WHERE E.dpi = C.dpi AND C.departamento = 0
																  AND C.casilla = $cont AND C.partido = '$algo[$i]'";

														$resulta = pg_query($link, $consu) or die('Query failed: ' . pg_result_error());
														$lin = pg_fetch_array($resulta, NULL, PGSQL_ASSOC);
														$nombres=$lin["nombres"];
														$apellidos=$lin["apellidos"];
														if($nombres==null && $apellidos == null){
															break;
														}
														
														
													     echo "<tr>";
													     echo "<td width='700' style='text-align:center;'>$nombres</td>";
													     echo "<td width='700' style='text-align:center;'>$apellidos</td>";
													     echo "<td width='700' style='text-align:center;'>$algo[$i]</td>";
													     echo "</tr>";
													
													}
												}
											 	
									         }
									
										

										CloseCon($link);
								?>

						</tbody>
					</table>
				</div>
				
				<div>
					<span style="float:center" valign="top"><a id="add-bttn" href="listaderepresentantes-minorias.html" onclick="return true;">Regresar</a></span>
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