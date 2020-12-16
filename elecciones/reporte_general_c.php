<?php
date_default_timezone_set("America/Guatemala");
setlocale(LC_ALL,"es_ES");
include "connection.php";
$link = OpenCon();
?>

<!DOCTYPE html>
<html>
    <?php
    if(!$_POST and !$_GET){
    ?>
    <head>
        <title>Resultados Generales para Congreso</title>
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
                        <span style="float:left">Resultados Generales para Congreso</span>
                    </h3>
                </div>

                <div id="fp-bcontainer" class="text-m">
                    <form name="departamentosf" action="reporte_general_c.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                        <table class="display" cellspacing="0" cellpadding="3" border="0">
                            <tbody>
                                <tr class="header">
                                    <th id="fp-table2">Seleccione un reporte:</th>
                                    <th id="fp-table2">Departamentos Registrados</th>
                                </tr>
                                <tr>
                                    <td id="fp-btable2"><img alt="Flag" src="img/folder.png" style="margin-left: 60px; padding-right:5px;" ><a href="reporte_general_c.php?tipo=1">RESULTADOS GENERALES PARA EL LISTADO NACIONAL</a></td>
                                </tr>
                                <tr>
                                    <td id="fp-btable2"><img alt="Flag" src="img/folder.png" style="margin-left: 60px; padding-right:5px;" ><a href="">SELECCIONE UN DISTRITO PARA GENERAR EL REPORTE: </a></td>
                                    <td id="fp-btable1">
                                        <select name="departamento" required style="text-align:center;">
                                            <?php
                                            $query = "SELECT * FROM departamento WHERE codigo > 0;";
                                            $result = pg_query($link,$query);
											while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC))
											{
											   $codigo=$line["codigo"];
											   $nombre=$line["nombre"];
											   echo "\t\t\t\t\t\t\t\t\t\t<option value=\"$codigo\">$nombre</option>\n";
											}
											CloseCon($link);
										?>
									    </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <table class="display" cellspacing="0" cellpadding="3" border="0">
                            <td id="fp-btable1">
                                <span valign="top"><input type="submit" name="submit" value="Generar Reporte Distrital" id="add-bttn"></span>
                            </td>
                        </table>
                    </form>
				</div>

                <br>
                <div>
				    <span style="float:center" valign="top"><a id="add-bttn" href="reportes.html">Regresar</a></span>
				</div>
            </div>
            <div id="fp-footer" style="bottom: 0px">
				<h1 id="fp-project">Ciencias de la computacion V</h1>
			</div>
        </div>
    </body>
    <?php
    }else if(isset($_GET["tipo"])){
    ?>
    <head>
        <title>Resultados Generales para LN</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="paper.min.css" rel="stylesheet" />
    </head>
    <body class = "legal">
        <section class="sheet padding-25mm">
            <article>
                <h1 style="font-size:30px;"><u>REPORTE - RESULTADOS GENERALES PARA LISTADO NACIONAL</u></h1>
                <h3>ELECCIONES GUATEMALA 2019</h3>


                <table style="border:1px solid black; border-collapse: collapse; width:100%;">
                    <tr>
                        <th style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;">Partido Politico</th>
                        <th style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;">Votos Obtenidos</th>
                        <th style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;">Votos Blancos</th>
                        <th style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;">Partido Nulos</th>
                    </tr>

                    <?php 
                    $query = "SELECT * FROM partidopolitico";
                    $resultado = pg_query($link,$query);

                    $totalvotosB = 0;
                    $totalvotosN = 0;
                    $totalvotosG = 0;

                    while($linea = pg_fetch_array($resultado,NULL,PGSQL_ASSOC)){
                        $partido = $linea["nombre"];
                        $queryc = "SELECT * FROM congreso WHERE partido='$partido' AND departamento=0;";
                        if(pg_num_rows(pg_query($link,$queryc)) == 5){
                            $querym = "SELECT COALESCE(SUM(votodiputadoslistadonacional),0) AS Total
                                       FROM conteofinal 
                                       WHERE no_mesa IN (SELECT no_mesa FROM mesa) AND partido='$partido'";
                            $querybn = "SELECT COALESCE(SUM(votoblanconacional),0) AS TotalB, COALESCE(SUM(votonulonacional),0) AS TotalN
                                       FROM conteofinal 
                                       WHERE no_mesa IN (SELECT no_mesa FROM mesa)";
                            $totalvotos = pg_fetch_array(pg_query($link,$querym));
                            $totalvotosG = $totalvotos["total"];

                            $totalvotosbn = pg_fetch_array(pg_query($link,$querybn));
                            $totalvotosB = $totalvotosbn["totalb"];
                            $totalvotosN = $totalvotosbn["totaln"]; 

                    ?>
                    <tr>
                        <td style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;"><?php echo $partido;?></td>
                        <td style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;"><?php echo $totalvotosG;?></td>
                        <td style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;"><?php echo $totalvotosB;?></td>
                        <td style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;"><?php echo $totalvotosN;?></td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                </table>
                <br>
                Hora de creacion: <?php echo date("h").":".date("i")." ".date("A"); ?> <br>
                Fecha de creacion: <?php echo date("d")."/".date("m")."/".date("Y"); ?>
            </article>
        </section>
    </body>
    <?php

    }else if(isset($_POST["submit"])){
        $coddepartamento = $_POST["departamento"];
        $nombrequery = "SELECT * FROM departamento WHERE codigo=$coddepartamento";
        $departamentoN = pg_fetch_array(pg_query($link,$nombrequery));
        $departamentoN = $departamentoN["nombre"];
    ?>
    <head>
        <title>Resultados Generales Distritales</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="paper.min.css" rel="stylesheet" />
    </head>
    <body class = "legal">
        <section class="sheet padding-25mm">
            <article>
                <h1 style="font-size:30px;"><u>REPORTE - RESULTADOS GENERALES DEL DISTRITO <?php echo strtoupper($departamentoN);?></u></h1>
                <h3>ELECCIONES GUATEMALA 2019</h3>


                <table style="border:1px solid black; border-collapse: collapse; width:100%;">
                    <tr>
                        <th style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;">Partido Politico</th>
                        <th style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;">Votos Obtenidos</th>
                        <th style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;">Votos Blancos</th>
                        <th style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;">Partido Nulos</th>
                    </tr>

                    <?php 
                    $query = "SELECT * FROM partidopolitico";
                    $resultado = pg_query($link,$query);

                    while($linea = pg_fetch_array($resultado,NULL,PGSQL_ASSOC)){
                        $partido = $linea["nombre"];
                        $queryc = "SELECT * FROM congreso WHERE partido='$partido' AND departamento=$coddepartamento;";
                        if(pg_num_rows(pg_query($link,$queryc)) == 5){
                            //muestra las mesas ubicadas en ese departamaneto
                            $queryvotos = "SELECT COALESCE(SUM(votodiputadosdistritales),0) AS Total
                                           FROM conteofinal
                                           WHERE no_mesa IN (SELECT no_mesa 
                                                             FROM mesa
                                                             WHERE municipio IN (SELECT codigo FROM municipio WHERE departamento=$coddepartamento)) AND partido='$partido'";

                            $queryvotosbn = "SELECT COALESCE(SUM(votoblancodistrital),0) AS TotalB, COALESCE(SUM(votonulodistrital),0) AS TotalN
                                             FROM conteofinal
                                             WHERE no_mesa IN (SELECT no_mesa 
                                                               FROM mesa
                                                               WHERE municipio IN (SELECT codigo FROM municipio WHERE departamento=$coddepartamento));";
                            $totalvotos = pg_fetch_array(pg_query($link,$queryvotos));
                            $totalvotosG = $totalvotos["total"];

                            $totalvotosbn = pg_fetch_array(pg_query($link,$queryvotosbn));
                            $totalvotosB = $totalvotosbn["totalb"];
                            $totalvotosN = $totalvotosbn["totaln"];

                    ?>
                    <tr>
                        <td style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;"><?php echo $partido;?></td>
                        <td style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;"><?php echo $totalvotosG;?></td>
                        <td style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;"><?php echo $totalvotosB;?></td>
                        <td style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;"><?php echo $totalvotosN;?></td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                </table>
                <br>
                Hora de creacion: <?php echo date("h").":".date("i")." ".date("A"); ?> <br>
                Fecha de creacion: <?php echo date("d")."/".date("m")."/".date("Y"); ?>
            </article>
        </section>
    </body>
    <?php
    }
    ?>
</html>