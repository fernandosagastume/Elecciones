<?php
date_default_timezone_set("America/Guatemala");
setlocale(LC_ALL,"es_ES");
include "connection.php";
$link = OpenCon(); 
?>

<!DOCTYPE html>
<html>


    <?php
    if($_POST){
    ?>
    <head>
        <title>Resultados Generales de Alcalde</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="paper.min.css" rel="stylesheet" />
    </head>
    <body class="legal">
        <section class="sheet padding-25mm">
            <article>
                <h1 style="font-size:30px;"><u>REPORTE - RESULTADOS GENERALES PARA ALCALDE</u></h1>
                <h3>ELECCIONES GUATEMALA 2019</h3>
                
                Los siguientes resultados son recabados a partir de la suma<br>
                de todos los datos existentes por mesa, tomando en cuenta que puede existir<br>
                partidos politicos sin candidatos para la alcaldia..

                
                <br><br>
                <table style="border:1px solid black; border-collapse: collapse; width:100%;">
                    <tr>
                        <th style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;">Candidato de Alcaldia</th>   
                        <th style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;">Partido Politico</th>
                        <th style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;">Votos Conseguidos</th>                               
                    </tr>
                <?php
                $codmunicipio = $_POST["municipio"];
                $querypp = "SELECT * FROM partidopolitico";
                $resultadopp = pg_query($link,$querypp);

                while($linea = pg_fetch_array($resultadopp,NULL,PGSQL_ASSOC)){ //todas las mesas que esten en ese municipio
                    $partido = $linea["nombre"];
                    $queryal = "SELECT * FROM alcalde WHERE partido='$partido' AND $codmunicipio=municipio";
                    $alcaldes = pg_query($link,$queryal);
                    if(pg_num_rows($alcaldes) == 1){
                        $queryvotos = "SELECT COALESCE(SUM(votoalcalde),0) AS total FROM conteofinal,mesa WHERE $codmunicipio=mesa.municipio AND conteofinal.partido='$partido'";
                        $queryvotosbn = "SELECT COALESCE(SUM(votoblancoalcal),0) AS votob, COALESCE(SUM(votonuloalcal),0) AS voton FROM conteofinal,mesa WHERE $codmunicipio=mesa.municipio";
                        $totalvotosbn = pg_fetch_array(pg_query($link,$queryvotosbn));

                        $votosb = $totalvotosbn["votob"];
                        $votosn = $totalvotosbn["voton"];

                        $totalvotos = pg_fetch_array(pg_query($link,$queryvotos));
                        $totalvotos = $totalvotos["total"];

                        $dpi = pg_fetch_array($alcaldes);
                        $dpi = $dpi["dpi"];
                        $querydpi = "SELECT * FROM empadronado WHERE dpi=$dpi";
                        $nombrer = pg_fetch_array(pg_query($link,$querydpi));
                        $nombrealcalde = $nombrer["nombres"];
                        $apellidoalcalde = $nombrer["apellidos"];
                ?>
                    <tr>
                        <td style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;"><?php echo $nombrealcalde." ".$apellidoalcalde;?></td>
                        <td style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;"><?php echo $partido;?></td>
                        <td style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;"><?php echo $totalvotos;?></td>
                    </tr>
                <?php
                    }
                }
                ?>
                </table>
                <br>
                VOTOS BLANCOS: <b style="font-size:20px;"><?php echo $votosb;?> </b><br>
                VOTOS NULOS: <b style="font-size:20px;"><?php echo $votosn;?> </b><br><br>
                Hora de creacion: <?php echo date("h").":".date("i")." ".date("A"); ?> <br>
                Fecha de creacion: <?php echo date("d")."/".date("m")."/".date("Y"); ?>
            </article>
        </section>
    </body>

    <?php
    }else{ ?>
    <head>
        <title>Resultados Generales para Alcalde</title>
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
                        <span style="float:left">Resultados Generales para Alcalde</span>
                    </h3>
                </div>

                <div id="fp-bcontainer" class="text-m">
                    <form name="municipios" action="reporte_general_a.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                        <table class="display" cellspacing="0" cellpadding="3" border="0">
                            <tbody>
                                <tr class="header">
                                    <th id="fp-table2">Campo</th>
                                    <th id="fp-table2">Municipios Registrados</th>
                                </tr>
                                <tr>
                                    <td id="fp-btable1">Seleccione un municipio: </td>
                                    <td id="fp-btable1">
                                        <select name="municipio" required style="text-align:center;">
                                            <?php
                                            $query = "SELECT * FROM municipio";
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
                                <span valign="top"><input type="submit" name="submit" value="Generar Reporte" id="add-bttn"></span>
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
    }
    ?>
</html>