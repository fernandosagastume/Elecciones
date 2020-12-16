<html>
	<head>
		<title>
			Lista de Representantes Electos por Distrito
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
					<?php 
						include 'connection.php';
						$nombredepa = $_POST["depart"];
						$link = OpenCon();

						echo "Resultados de $nombredepa";
						CloseCon($link);
					 ?> 
					</h3>
					<b><h4>
					<?php 

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
										$departamento = $_POST["depart"];
										$link = OpenCon();
										
								
										if($departamento == 'Municipios del Departamento de Guatemala'){
											$query = "SELECT nombre FROM partidopolitico";
											$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
											$arr = array();
											$arr1 = array();
											$arr2 = array();
											$cont = 0; 
											while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
												$nombre=$line["nombre"];
												$query1 = "SELECT SUM(C.votodiputadosdistritales) AS sumadevotos
														   FROM conteofinal C, mesa M, municipio U, departamento D
														   WHERE C.no_mesa = M.no_mesa AND M.municipio = U.codigo AND 
														   U.departamento = D.codigo AND U.nombre != 'Guatemala'
														   AND (D.nombre = 'GUATEMALA' OR D.nombre = 'Guatemala' OR
																D.nombre = 'guatemala') AND C.partido = '$nombre' ";	
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

									         $divtotal = array_merge($arr1,$div2,$div3,$div4,$div5);
									         rsort($divtotal);
									       	 $cifrarepartidora = $divtotal[4];  
									       	 $arrfin = array();
											 for( $i = 0; $i<sizeof($arr1); $i++) {
											 	if($cifrarepartidora != 0){
											 	   array_push($arrfin, floor($arr1[$i]/$cifrarepartidora));
											 	} 
									         }
									         $algo = array_merge($arrfin,$arr2);
											 
											 $querytot = "SELECT Count(nombre) as totalpartidos FROM partidopolitico";
											$resultot = pg_query($link, $querytot) or die('Query failed: ' . pg_result_error());

											$linetot = pg_fetch_array($resultot, NULL, PGSQL_ASSOC);
											$partidonum=$linetot["totalpartidos"];
											for( $i = $partidonum, $j = 0; $i<sizeof($algo); $i++, $j++) {
												if ($algo[$j] != 0){
													for ($cont = 1; $cont<=$algo[$j]; $cont++){

														$consu = "SELECT E.nombres, E.apellidos FROM empadronado E, congreso C WHERE E.dpi = C.dpi AND C.departamento = 1
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
										}
										if($departamento == 'Distrito Central'){
											$query = "SELECT nombre FROM partidopolitico";
											$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
											$arr = array();
											$arr1 = array();
											$arr2 = array();
											$cont = 0; 
											while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
												$nombre=$line["nombre"];
												$query1 = "SELECT SUM(C.votodiputadosdistritales) AS sumadevotos
														   FROM conteofinal C, mesa M, municipio U, departamento D
														   WHERE C.no_mesa = M.no_mesa AND M.municipio = U.codigo AND 
														   U.departamento = D.codigo AND (U.nombre = 'Guatemala' OR 
														   U.nombre = 'Guatemala') AND (D.nombre = 'GUATEMALA' OR D.nombre = 'Guatemala' OR
														   D.nombre = 'guatemala') AND C.partido = '$nombre' ";	
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

									         $divtotal = array_merge($arr1,$div2,$div3,$div4,$div5);
									         rsort($divtotal);
									       	 $cifrarepartidora = $divtotal[4];  
									       	 $arrfin = array();
											 for( $i = 0; $i<sizeof($arr1); $i++) {
											 	if($cifrarepartidora != 0){
											 	   array_push($arrfin, round($arr1[$i]/$cifrarepartidora));
											 	}  
									         }

									         $algo = array_merge($arrfin,$arr2);
											 
											 $querytot = "SELECT Count(nombre) as totalpartidos FROM partidopolitico";
											$resultot = pg_query($link, $querytot) or die('Query failed: ' . pg_result_error());

											$linetot = pg_fetch_array($resultot, NULL, PGSQL_ASSOC);
											$partidonum=$linetot["totalpartidos"];
											for( $i = $partidonum, $j = 0; $i<sizeof($algo); $i++, $j++) {
												if ($algo[$j] != 0){
													for ($cont = 1; $cont<=$algo[$j]; $cont++){

														$consu = "SELECT E.nombres, E.apellidos FROM empadronado E, congreso C WHERE E.dpi = C.dpi AND C.departamento = 1
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
										}

										if($departamento == 'El Progreso'){
											$query = "SELECT nombre FROM partidopolitico";
											$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
											$arr = array();
											$arr1 = array();
											$arr2 = array();
											$cont = 0; 
											while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
												$nombre=$line["nombre"];
												$query1 = "SELECT SUM(C.votodiputadosdistritales) AS sumadevotos
														   FROM conteofinal C, mesa M, municipio U, departamento D
														   WHERE C.no_mesa = M.no_mesa AND M.municipio = U.codigo AND 
														   U.departamento = D.codigo AND D.nombre = '$departamento' AND C.partido = '$nombre' ";	
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

									         $divtotal = array_merge($arr1,$div2,$div3,$div4,$div5);
									         rsort($divtotal);
									       	 $cifrarepartidora = $divtotal[4];  
									       	 $arrfin = array();
											 for( $i = 0; $i<sizeof($arr1); $i++) {
											 	if($cifrarepartidora != 0){
											 	   array_push($arrfin, floor($arr1[$i]/$cifrarepartidora));
											 	} 
									         }

									         $algo = array_merge($arrfin,$arr2);
											 
											 $querytot = "SELECT Count(nombre) as totalpartidos FROM partidopolitico";
											$resultot = pg_query($link, $querytot) or die('Query failed: ' . pg_result_error());

											$linetot = pg_fetch_array($resultot, NULL, PGSQL_ASSOC);
											$partidonum=$linetot["totalpartidos"];
											for( $i = $partidonum, $j = 0; $i<sizeof($algo); $i++, $j++) {
												if ($algo[$j] != 0){
													for ($cont = 1; $cont<=$algo[$j]; $cont++){

														$consu = "SELECT E.nombres, E.apellidos FROM empadronado E, congreso C WHERE E.dpi = C.dpi AND C.departamento = 2
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
										}

										if($departamento == 'Huehuetenango'){
											$query = "SELECT nombre FROM partidopolitico";
											$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
											$arr = array();
											$arr1 = array();
											$arr2 = array();
											$cont = 0; 
											while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
												$nombre=$line["nombre"];
												$query1 = "SELECT SUM(C.votodiputadosdistritales) AS sumadevotos
														   FROM conteofinal C, mesa M, municipio U, departamento D
														   WHERE C.no_mesa = M.no_mesa AND M.municipio = U.codigo AND 
														   U.departamento = D.codigo AND D.nombre = '$departamento' AND C.partido = '$nombre' ";	
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

									         $divtotal = array_merge($arr1,$div2,$div3,$div4,$div5);
									         rsort($divtotal);
									       	 $cifrarepartidora = $divtotal[4];  
									       	 $arrfin = array();
											 for( $i = 0; $i<sizeof($arr1); $i++) {
											 	if($cifrarepartidora != 0){
											 	   array_push($arrfin, floor($arr1[$i]/$cifrarepartidora));
											 	} 
									         }

									         $algo = array_merge($arrfin,$arr2);
											 
											 $querytot = "SELECT Count(nombre) as totalpartidos FROM partidopolitico";
											$resultot = pg_query($link, $querytot) or die('Query failed: ' . pg_result_error());

											$linetot = pg_fetch_array($resultot, NULL, PGSQL_ASSOC);
											$partidonum=$linetot["totalpartidos"];
											for( $i = $partidonum, $j = 0; $i<sizeof($algo); $i++, $j++) {
												if ($algo[$j] != 0){
													for ($cont = 1; $cont<=$algo[$j]; $cont++){

														$consu = "SELECT E.nombres, E.apellidos FROM empadronado E, congreso C WHERE E.dpi = C.dpi AND C.departamento = 13
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
										}

										if($departamento == 'El Quiche'){
											$query = "SELECT nombre FROM partidopolitico";
											$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
											$arr = array();
											$arr1 = array();
											$arr2 = array();
											$cont = 0; 
											while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
												$nombre=$line["nombre"];
												$query1 = "SELECT SUM(C.votodiputadosdistritales) AS sumadevotos
														   FROM conteofinal C, mesa M, municipio U, departamento D
														   WHERE C.no_mesa = M.no_mesa AND M.municipio = U.codigo AND 
														   U.departamento = D.codigo AND D.nombre = '$departamento' AND C.partido = '$nombre' ";	
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

									         $divtotal = array_merge($arr1,$div2,$div3,$div4,$div5);
									         rsort($divtotal);
									       	 $cifrarepartidora = $divtotal[4];  
									       	 $arrfin = array();
											 for( $i = 0; $i<sizeof($arr1); $i++) {
											 	if($cifrarepartidora != 0){
											 	   array_push($arrfin, floor($arr1[$i]/$cifrarepartidora));
											 	} 
									         }

									         $algo = array_merge($arrfin,$arr2);
											 
											 $querytot = "SELECT Count(nombre) as totalpartidos FROM partidopolitico";
											$resultot = pg_query($link, $querytot) or die('Query failed: ' . pg_result_error());

											$linetot = pg_fetch_array($resultot, NULL, PGSQL_ASSOC);
											$partidonum=$linetot["totalpartidos"];
											for( $i = $partidonum, $j = 0; $i<sizeof($algo); $i++, $j++) {
												if ($algo[$j] != 0){
													for ($cont = 1; $cont<=$algo[$j]; $cont++){

														$consu = "SELECT E.nombres, E.apellidos FROM empadronado E, congreso C WHERE E.dpi = C.dpi AND C.departamento = 14
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
										}

										if($departamento == 'Quetzaltenango'){
											$query = "SELECT nombre FROM partidopolitico";
											$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
											$arr = array();
											$arr1 = array();
											$arr2 = array();
											$cont = 0; 
											while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
												$nombre=$line["nombre"];
												$query1 = "SELECT SUM(C.votodiputadosdistritales) AS sumadevotos
														   FROM conteofinal C, mesa M, municipio U, departamento D
														   WHERE C.no_mesa = M.no_mesa AND M.municipio = U.codigo AND 
														   U.departamento = D.codigo AND D.nombre = '$departamento' AND C.partido = '$nombre' ";	
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

									         $divtotal = array_merge($arr1,$div2,$div3,$div4,$div5);
									         rsort($divtotal);
									       	 $cifrarepartidora = $divtotal[4];  
									       	 $arrfin = array();
											 for( $i = 0; $i<sizeof($arr1); $i++) {
											 	if($cifrarepartidora != 0){
											 	   array_push($arrfin, floor($arr1[$i]/$cifrarepartidora));
											 	} 
									         }

									         $algo = array_merge($arrfin,$arr2);
											 
											 $querytot = "SELECT Count(nombre) as totalpartidos FROM partidopolitico";
											$resultot = pg_query($link, $querytot) or die('Query failed: ' . pg_result_error());

											$linetot = pg_fetch_array($resultot, NULL, PGSQL_ASSOC);
											$partidonum=$linetot["totalpartidos"];
											for( $i = $partidonum, $j = 0; $i<sizeof($algo); $i++, $j++) {
												if ($algo[$j] != 0){
													for ($cont = 1; $cont<=$algo[$j]; $cont++){

														$consu = "SELECT E.nombres, E.apellidos FROM empadronado E, congreso C WHERE E.dpi = C.dpi AND C.departamento = 9
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
										}


										if($departamento == 'Escuintla'){
											$query = "SELECT nombre FROM partidopolitico";
											$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
											$arr = array();
											$arr1 = array();
											$arr2 = array();
											$cont = 0; 
											while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
												$nombre=$line["nombre"];
												$query1 = "SELECT SUM(C.votodiputadosdistritales) AS sumadevotos
														   FROM conteofinal C, mesa M, municipio U, departamento D
														   WHERE C.no_mesa = M.no_mesa AND M.municipio = U.codigo AND 
														   U.departamento = D.codigo AND D.nombre = '$departamento' AND C.partido = '$nombre' ";	
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

									         $divtotal = array_merge($arr1,$div2,$div3,$div4,$div5);
									         rsort($divtotal);
									       	 $cifrarepartidora = $divtotal[4];  
									       	 $arrfin = array();
											 for( $i = 0; $i<sizeof($arr1); $i++) {
											 	if($cifrarepartidora != 0){
											 	   array_push($arrfin, floor($arr1[$i]/$cifrarepartidora));
											 	} 
									         }

									         $algo = array_merge($arrfin,$arr2);
											 
											 $querytot = "SELECT Count(nombre) as totalpartidos FROM partidopolitico";
											$resultot = pg_query($link, $querytot) or die('Query failed: ' . pg_result_error());

											$linetot = pg_fetch_array($resultot, NULL, PGSQL_ASSOC);
											$partidonum=$linetot["totalpartidos"];
											for( $i = $partidonum, $j = 0; $i<sizeof($algo); $i++, $j++) {
												if ($algo[$j] != 0){
													for ($cont = 1; $cont<=$algo[$j]; $cont++){

														$consu = "SELECT E.nombres, E.apellidos FROM empadronado E, congreso C WHERE E.dpi = C.dpi AND C.departamento = 5
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
										}

										if($departamento == 'Alta Verapaz' || $departamento == 'San Marcos'){
											$query = "SELECT nombre FROM partidopolitico";
											$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
											$arr = array();
											$arr1 = array();
											$arr2 = array();
											$cont = 0; 
											while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
												$nombre=$line["nombre"];
												$query1 = "SELECT SUM(C.votodiputadosdistritales) AS sumadevotos
														   FROM conteofinal C, mesa M, municipio U, departamento D
														   WHERE C.no_mesa = M.no_mesa AND M.municipio = U.codigo AND 
														   U.departamento = D.codigo AND D.nombre = '$departamento' AND C.partido = '$nombre' ";	
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

									         $divtotal = array_merge($arr1,$div2,$div3,$div4,$div5);
									         rsort($divtotal);
									       	 $cifrarepartidora = $divtotal[4];  
									       	  
									       	 $arrfin = array();
											 for( $i = 0; $i<sizeof($arr1); $i++) {
											 	if($cifrarepartidora != 0){
											 	   array_push($arrfin, floor($arr1[$i]/$cifrarepartidora));
											 	} 
									         }

									         $algo = array_merge($arrfin,$arr2);
											 
											 $querytot = "SELECT Count(nombre) as totalpartidos FROM partidopolitico";
											$resultot = pg_query($link, $querytot) or die('Query failed: ' . pg_result_error());

											$linetot = pg_fetch_array($resultot, NULL, PGSQL_ASSOC);
											$partidonum=$linetot["totalpartidos"];
											for( $i = $partidonum, $j = 0; $i<sizeof($algo); $i++, $j++) {
												if ($algo[$j] != 0){
													for ($cont = 1; $cont<=$algo[$j]; $cont++){

														$consudepa = "SELECT codigo FROM departamento WHERE nombre = '$departamento'";

														$resultadepa = pg_query($link, $consudepa) or die('Query failed: ' . pg_result_error());
														$lindepa = pg_fetch_array($resultadepa, NULL, PGSQL_ASSOC);
														$coddepa=$lindepa["codigo"];

														$consu = "SELECT E.nombres, E.apellidos FROM empadronado E, congreso C WHERE E.dpi = C.dpi 
																  AND C.departamento = $coddepa AND casilla = $cont AND C.partido = '$algo[$i]'";

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
										}
										if($departamento == 'Chimaltenango' || $departamento == 'Suchitepequez'){
											$query = "SELECT nombre FROM partidopolitico";
											$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
											$arr = array();
											$arr1 = array();
											$arr2 = array();
											$cont = 0; 
											while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
												$nombre=$line["nombre"];
												$query1 = "SELECT SUM(C.votodiputadosdistritales) AS sumadevotos
														   FROM conteofinal C, mesa M, municipio U, departamento D
														   WHERE C.no_mesa = M.no_mesa AND M.municipio = U.codigo AND 
														   U.departamento = D.codigo AND D.nombre = '$departamento' AND C.partido = '$nombre' ";	
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

									         $divtotal = array_merge($arr1,$div2,$div3,$div4,$div5);
									         rsort($divtotal);
									       	 $cifrarepartidora = $divtotal[4];  
									       	  
									       	 $arrfin = array();
											 for( $i = 0; $i<sizeof($arr1); $i++) {
											 	if($cifrarepartidora != 0){
											 	   array_push($arrfin, floor($arr1[$i]/$cifrarepartidora));
											 	} 
									         }

									         $algo = array_merge($arrfin,$arr2);
											 
											 $querytot = "SELECT Count(nombre) as totalpartidos FROM partidopolitico";
											$resultot = pg_query($link, $querytot) or die('Query failed: ' . pg_result_error());

											$linetot = pg_fetch_array($resultot, NULL, PGSQL_ASSOC);
											$partidonum=$linetot["totalpartidos"];
											for( $i = $partidonum, $j = 0; $i<sizeof($algo); $i++, $j++) {
												if ($algo[$j] != 0){
													for ($cont = 1; $cont<=$algo[$j]; $cont++){

														$consudepa = "SELECT codigo FROM departamento WHERE nombre = '$departamento'";

														$resultadepa = pg_query($link, $consudepa) or die('Query failed: ' . pg_result_error());
														$lindepa = pg_fetch_array($resultadepa, NULL, PGSQL_ASSOC);
														$coddepa=$lindepa["codigo"];

														$consu = "SELECT E.nombres, E.apellidos FROM empadronado E, congreso C WHERE E.dpi = C.dpi 
																  AND C.departamento = $coddepa AND casilla = $cont AND C.partido = '$algo[$i]'";

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
										}

										if($departamento == 'Jutiapa' || $departamento == 'El Peten' || $departamento == 'Totonicapan'){
											$query = "SELECT nombre FROM partidopolitico";
											$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
											$arr = array();
											$arr1 = array();
											$arr2 = array();
											$cont = 0; 
											while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
												$nombre=$line["nombre"];
												$query1 = "SELECT SUM(C.votodiputadosdistritales) AS sumadevotos
														   FROM conteofinal C, mesa M, municipio U, departamento D
														   WHERE C.no_mesa = M.no_mesa AND M.municipio = U.codigo AND 
														   U.departamento = D.codigo AND D.nombre = '$departamento' AND C.partido = '$nombre' ";	
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

									         $divtotal = array_merge($arr1,$div2,$div3,$div4,$div5);
									         rsort($divtotal);
									       	 $cifrarepartidora = $divtotal[4];  
									       	  
									       	 $arrfin = array();
											 for( $i = 0; $i<sizeof($arr1); $i++) {
											 	if($cifrarepartidora != 0){
											 	   array_push($arrfin, floor($arr1[$i]/$cifrarepartidora));
											 	} 
									         }

									         $algo = array_merge($arrfin,$arr2);
											 
											 $querytot = "SELECT Count(nombre) as totalpartidos FROM partidopolitico";
											$resultot = pg_query($link, $querytot) or die('Query failed: ' . pg_result_error());

											$linetot = pg_fetch_array($resultot, NULL, PGSQL_ASSOC);
											$partidonum=$linetot["totalpartidos"];
											for( $i = $partidonum, $j = 0; $i<sizeof($algo); $i++, $j++) {
												if ($algo[$j] != 0){
													for ($cont = 1; $cont<=$algo[$j]; $cont++){

														$consudepa = "SELECT codigo FROM departamento WHERE nombre = '$departamento'";

														$resultadepa = pg_query($link, $consudepa) or die('Query failed: ' . pg_result_error());
														$lindepa = pg_fetch_array($resultadepa, NULL, PGSQL_ASSOC);
														$coddepa=$lindepa["codigo"];

														$consu = "SELECT E.nombres, E.apellidos FROM empadronado E, congreso C WHERE E.dpi = C.dpi 
																  AND C.departamento = $coddepa AND casilla = $cont AND C.partido = '$algo[$i]'";

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
										}

										if($departamento == 'Chiquimula' || $departamento == 'IzabalL' || $departamento == 'Jalapa' || $departamento == 'Retalhuleu' || $departamento == 'Sacatepequez' || $departamento == 'Santa Rosa' || $departamento == 'Solola'){
											$query = "SELECT nombre FROM partidopolitico";
											$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
											$arr = array();
											$arr1 = array();
											$arr2 = array();
											$cont = 0; 
											while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
												$nombre=$line["nombre"];
												$query1 = "SELECT SUM(C.votodiputadosdistritales) AS sumadevotos
														   FROM conteofinal C, mesa M, municipio U, departamento D
														   WHERE C.no_mesa = M.no_mesa AND M.municipio = U.codigo AND 
														   U.departamento = D.codigo AND D.nombre = '$departamento' AND C.partido = '$nombre' ";	
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

									         $divtotal = array_merge($arr1,$div2,$div3,$div4,$div5);
									         rsort($divtotal);
									         
									       	 $cifrarepartidora = $divtotal[4]; 
									       	 $arrfin = array();
											 for( $i = 0; $i<sizeof($arr1); $i++) {
											 	if($cifrarepartidora != 0){
											 	   array_push($arrfin, floor($arr1[$i]/$cifrarepartidora));
											 	} 
									         }

									         $algo = array_merge($arrfin,$arr2);
									        
											 $querytot = "SELECT Count(nombre) as totalpartidos FROM partidopolitico";
											$resultot = pg_query($link, $querytot) or die('Query failed: ' . pg_result_error());

											$linetot = pg_fetch_array($resultot, NULL, PGSQL_ASSOC);
											$partidonum=$linetot["totalpartidos"];
											for( $i = $partidonum, $j = 0; $i<sizeof($algo); $i++, $j++) {
												if ($algo[$j] != 0){
													for ($cont = 1; $cont<=$algo[$j]; $cont++){

														$consudepa = "SELECT codigo FROM departamento WHERE nombre = '$departamento'";

														$resultadepa = pg_query($link, $consudepa) or die('Query failed: ' . pg_result_error());
														$lindepa = pg_fetch_array($resultadepa, NULL, PGSQL_ASSOC);
														$coddepa=$lindepa["codigo"];

														$consu = "SELECT E.nombres, E.apellidos FROM empadronado E, congreso C WHERE E.dpi = C.dpi 
																  AND C.departamento = $coddepa AND casilla = $cont AND C.partido = '$algo[$i]'";

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
										}

										if($departamento == 'Baja Verapaz' || $departamento == 'Zacapa'){
											$query = "SELECT nombre FROM partidopolitico";
											$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
											$arr = array();
											$arr1 = array();
											$arr2 = array();
											$cont = 0; 
											while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
												$nombre=$line["nombre"];
												$query1 = "SELECT SUM(C.votodiputadosdistritales) AS sumadevotos
														   FROM conteofinal C, mesa M, municipio U, departamento D
														   WHERE C.no_mesa = M.no_mesa AND M.municipio = U.codigo AND 
														   U.departamento = D.codigo AND D.nombre = '$departamento' AND C.partido = '$nombre' ";	
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

									         $divtotal = array_merge($arr1,$div2,$div3,$div4,$div5);
									         rsort($divtotal);
									       	 $cifrarepartidora = $divtotal[4];  
									       	  
									       	 $arrfin = array();
											 for( $i = 0; $i<sizeof($arr1); $i++) {
											 	if($cifrarepartidora != 0){
											 	   array_push($arrfin, floor($arr1[$i]/$cifrarepartidora));
											 	} 
									         }

									         $algo = array_merge($arrfin,$arr2);
											 
											 $querytot = "SELECT Count(nombre) as totalpartidos FROM partidopolitico";
											$resultot = pg_query($link, $querytot) or die('Query failed: ' . pg_result_error());

											$linetot = pg_fetch_array($resultot, NULL, PGSQL_ASSOC);
											$partidonum=$linetot["totalpartidos"];
											for( $i = $partidonum, $j = 0; $i<sizeof($algo); $i++, $j++) {
												if ($algo[$j] != 0){
													for ($cont = 1; $cont<=$algo[$j]; $cont++){

														$consudepa = "SELECT codigo FROM departamento WHERE nombre = '$departamento'";

														$resultadepa = pg_query($link, $consudepa) or die('Query failed: ' . pg_result_error());
														$lindepa = pg_fetch_array($resultadepa, NULL, PGSQL_ASSOC);
														$coddepa=$lindepa["codigo"];

														$consu = "SELECT E.nombres, E.apellidos FROM empadronado E, congreso C WHERE E.dpi = C.dpi 
																  AND C.departamento = $coddepa AND casilla = $cont AND C.partido = '$algo[$i]'";

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
										}

										CloseCon($link);
								?>

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