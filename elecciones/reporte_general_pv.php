<?php
date_default_timezone_set("America/Guatemala");
setlocale(LC_ALL,"es_ES");
include "connection.php";
$link = OpenCon(); 
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Resultados Generales de Presidente/Vicepresidente</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="paper.min.css" rel="stylesheet" />
    </head>
    <body class="legal">
        <section class="sheet padding-25mm">
            <article>
                <h1 style="font-size:30px;"><u>REPORTE - RESULTADOS DE GENERALES PARA PRESIDENTE Y VICEPRESIDENTE</u></h1>
                <h3>ELECCIONES GUATEMALA 2019</h3>
                
                Los siguientes resultados son recabados a partir de la suma<br>
                de todos los datos existentes por mesa, tomando en cuenta que puede existir<br>
                partidos politicos sin candidatos para la presidencia.

                
                <br><br>
                <table style="border:1px solid black; border-collapse: collapse; width:100%;">
                    <tr>
                        <th style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;">Candidato Presidente</th>   
                        <th style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;">Partido Politico</th>
                        <th style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;">Votos Conseguidos</th>                             
                    </tr>
                <?php
                $queryx = "SELECT * FROM partidopolitico;";
                $resultado = pg_query($link,$queryx);
                while($linea = pg_fetch_array($resultado,NULL,PGSQL_ASSOC)){
                    $partido = $linea["nombre"];
                    $querypresi = "SELECT * FROM presidencia WHERE '$partido'=partido";
                    if(pg_num_rows(pg_query($link,$querypresi)) == 1){ //Verifica que el partido politico tenga candidato a presidente.
                        $totalvotos = 0;
                        $votosblancos = 0;
                        $votosnulos = 0;
                        $queryvotos = "SELECT COALESCE(SUM(votopresidencia),0) AS total FROM conteofinal WHERE '$partido'=partido";
                        $queryvotosbn = "SELECT COALESCE(SUM(votoblancopresi),0) AS totalb, COALESCE(SUM(votonulopresi),0) AS totaln FROM conteofinal";

                        $querydpi = "SELECT dpi_presi,dpi_vice FROM presidencia WHERE '$partido'=partido";
                        $dpipv = pg_fetch_array(pg_query($link,$querydpi));
                        $dpip = $dpipv["dpi_presi"];
                        $dpiv = $dpipv["dpi_vice"];

                        $querynombresp = "SELECT nombres,apellidos FROM empadronado WHERE dpi=$dpip;";
                        $querynombresv = "SELECT nombres,apellidos FROM empadronado WHERE dpi=$dpiv;";
                        $nombresp = pg_fetch_array(pg_query($link,$querynombresp));
                        $nombrep = $nombresp["nombres"];
                        $apellidop = $nombresp["apellidos"];
                        $nombresv = pg_fetch_array(pg_query($link,$querynombresv));
                        $nombrev = $nombresv["nombres"];
                        $apellidosv = $nombresv["apellidos"];


                        $totalvotos = pg_fetch_array(pg_query($link,$queryvotos));
                        $totalvotos = $totalvotos["total"];

                        $totalvotosbn = pg_fetch_array(pg_query($link,$queryvotosbn));
                        $votosblancos = $totalvotosbn["totalb"];
                        $votosnulos = $totalvotosbn["totaln"];
                        ?>
                        <tr>
                            <td style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;"><?php echo $nombrep." ".$apellidop;?></td>
                            <td style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;"><?php echo $partido;?></td>
                            <td style="text-align:center; border:1px solid black; border-collapse: collapse; padding:10px;"><?php echo $totalvotos;?></td>
                        </tr>
                        <?php
                    }
                }

                
                ?>
                </table>
                <br>
                VOTOS BLANCOS: <b style="font-size:20px;"><?php echo $votosblancos;?> </b><br>
                VOTOS NULOS: <b style="font-size:20px;"><?php echo $votosnulos;?> </b><br><br>
                Hora de creacion: <?php echo date("h").":".date("i")." ".date("A"); ?> <br>
                Fecha de creacion: <?php echo date("d")."/".date("m")."/".date("Y"); ?>
            </article>
        </section>
    </body>
</html>