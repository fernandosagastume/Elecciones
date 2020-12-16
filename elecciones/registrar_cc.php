<?php
include "connection.php";
$link = OpenCon();
if(isset($_GET["nombre"])){
    $partido = $_GET["nombre"];
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Registrar</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <script>
            function validate()
            {
                num = document.congresoform.dpi.value;
                re = new RegExp("[- ]", 'g');
                num = num.replace(re, '')
                len = (num.length == 13)? true:false; 

                if(!len)
                {
                    alert("El DPI del diputado debe contener 13 numeros en total.");
                }

                re = new RegExp("[^0-9]");
                format = (num.match(re))? false:true;

                if(!format)
                {
                    alert("El DPI del diputado ingresado debe contener solamente numeros.");
                }

                return (len && format);
            }
        </script>
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
                        <span style="float:left">Registro de Candidato para Congreso</span>
                    </h3>
                </div>

                <?php if(!$_POST){?>
                <div id="fp-bcontainer" class="text-m">
                    <form name="congresoform" action="registrar_cc.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                        <table class="display" cellspacing="0" cellpadding="3" border="0">
                            <tbody>
                                <tr class="header">
                                    <th id="fp-table2">Campo</th>
                                    <th id="fp-table2"></th>
                                </tr>
                                <tr>
                                    <td id="fp-btable1">DPI del Candidato</td>
                                    <td id="fp-btable1"><input type="text" name="dpi" style="text-align:center" required autocomplete></td>
                                </tr>
                                <tr>
                                    <td id="fp-btable1">Departamento</td>
                                    <td id="fp-btable1">
                                        <select name="departamento" required style="text-align:center;">
                                            <option selected value=0>Pais Guatemala</option>
                                            <?php
											$query = "SELECT codigo, nombre FROM Departamento ORDER BY nombre";
											$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
											$codigo="";
											$nombre=0;

											while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC))
											{
											     $codigo=$line["codigo"];
											     $nombre=$line["nombre"];

                                                $query1 = "SELECT COUNT(codigo) as cant FROM Municipio WHERE departamento = $codigo";
                                                $result1 = pg_query($link, $query1) or die('Query failed: ' . pg_result_error());
                                                $line1 = pg_fetch_array($result1, NULL, PGSQL_ASSOC);

                                                $cant = $line1["cant"];
                                                if ($cant != 0 || $codigo == 0)
                                                {
                                                    echo "<option value=\"$codigo\">$nombre</option>\n";
                                                }
											}
										    ?>
									    </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td id="fp-btable1">Partido Politico</td>
                                    <td id="fp-btable1"><input type="text" name='pp' style="text-align:center" value=<?php echo $partido; ?> readonly></td>
                                </tr>
                                <tr>
                                    <td id="fp-btable1">Casilla</td>
                                    <td id="fp-btable1"><input type="number" min="1" max="5" name="casilla" style="text-align:center" max=5000 required></td>
                                </tr>
                                
                            </tbody>
                        </table>
                        <br>
                        <table class="display" cellspacing="0" cellpadding="3" border="0">
                            <td id="fp-btable1">
                                <span valign="top"><input type="submit" name="submit" value="Registrar" id="add-bttn" onclick="return validate()"></span>
                            </td>
                        </table>
                    </form>
                    <br>
                </div>
                <br>
                <div>
                    <?php
                    echo "<span style=\"float:center\" valign=\"top\"><a id=\"add-bttn\" href=lista_pp.php?nombre=$partido&gestionar=\"\" >Regresar</a></span>";
                    ?>
                </div>
                <?php }else{?>
                <table class="display" cellspacing="0" cellpadding="3" border="0">
                    <td id="fp-btable1">
                        <span style="font-size: 17px">
                        <?php
                        $dpi = $_POST["dpi"];
                        $dpi = str_replace(" ", "", $dpi);
                        $dpi = str_replace("-", "", $dpi);
                        $departamento = $_POST["departamento"];
                        $partido = $_POST["pp"];
                        $casilla = $_POST["casilla"];

                        $query1 = "SELECT * FROM Congreso WHERE $dpi=dpi"; //verificar que no exista en la tabla
                        $query2 = "SELECT * FROM Presidencia WHERE $dpi=dpi_presi OR $dpi=dpi_vice;"; //verificar si existe en otra categoria
                        $query3 = "SELECT * FROM Alcalde WHERE $dpi=dpi;"; //verificar si existe en algun puesto de alcalde
                        $query4 = "SELECT * FROM Congreso WHERE $casilla=casilla AND partido='$partido' AND departamento=$departamento;"; //verificar que la casilla no se repita 
                        $query5 = "SELECT * FROM Congreso WHERE $departamento=departamento AND '$partido'=partido;"; 
                        $query6 = "SELECT * FROM Empadronado WHERE dpi=$dpi;";
                        
                        if(pg_num_rows(pg_query($link,$query1))==0 and pg_num_rows(pg_query($link,$query2))==0 and pg_num_rows(pg_query($link,$query3))==0){
                            if(pg_num_rows(pg_query($link,$query4))==0 and pg_num_rows(pg_query($link,$query5)) <=5){
                                if(pg_num_rows(pg_query($link,$query6)) == 1){
                                    $insert = "INSERT INTO Congreso VALUES($dpi,$departamento,'$partido',$casilla);";
                                    if(pg_query($link,$insert)){
                                        if ($departamento == 0)
                                        {
                                            $query = "SELECT M.no_mesa FROM Mesa M WHERE M.no_mesa NOT IN (SELECT C.no_mesa FROM ConteoFinal C WHERE C.partido = '$partido')";
                                            $result = pg_query($link,$query);
                                            while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC))
                                            {
                                                $mesa = $line["no_mesa"];
                                                $query5 = "INSERT INTO ConteoFinal VALUES($mesa, '$partido', NULL, NULL, NULL, NULL)";
                                                $result5 = pg_query($link, $query5);
                                            }
                                        }
                                        else
                                        {
                                            $query = "SELECT A.no_mesa FROM Mesa A, municipio M, Departamento D WHERE D.codigo = M.departamento AND M.codigo = A.municipio AND D.codigo = $departamento AND A.no_mesa NOT IN (SELECT C.no_mesa FROM ConteoFinal C WHERE C.partido = '$partido')";
                                            $result = pg_query($link,$query);
                                            while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC))
                                            {
                                                $mesa = $line["no_mesa"];
                                                $query5 = "INSERT INTO ConteoFinal VALUES($mesa, '$partido', NULL, NULL, NULL, NULL)";
                                                $result5 = pg_query($link, $query5);
                                            }
                                        }
                                        echo "<br>\n";
                                        echo "El candidato se registro exitosamente.\n";
                                    }else{
                                        echo "<br>\n";
                                        echo "Ocurrio algo, intentalo de nuevo.\n";
                                    }
                                }else{
                                    echo "<br>\n";
                                    echo "El dpi ".$dpi." no esta empradronado.\n";
                                }
                            }else{
                                echo "<br>\n";
                                echo "Ocurrio un error, pueda que la casilla ya este ocupada o se alcanzo el maximo de candidatos por departamento.";
                            }
                        }else{
                            echo "<br>\n";
                            $queryE = "SELECT nombres, apellidos FROM Empadronado WHERE $dpi=dpi";
                            $nombre = pg_fetch_array(pg_query($link,$queryE));
                            echo "El candidato ".$nombre["apellidos"]." ya esta inscrito como candidato.";
                        }
                        CloseCon($link);
                        ?>
                        </span>
                    </td>
                </table>
                <br>
                <table class="display" cellspacing="0" cellpadding="3" border="0">
                    <td id="fp-btable1">
                        <?php
                            echo "<span style=\"float:center\" valign=\"top\"><a id=\"add-bttn\" href=lista_pp.php?nombre=$partido&gestionar=\"\" >Regresar</a></span>";
                            echo "<meta http-equiv=\"refresh\" content=\"4;url=lista_pp.php?nombre=$partido&gestionar=\"\"/>";
                        ?>
                    </td>
                </table>
                <br>
                <?php }?>

                
            </div>

            <div id="fp-footer" style="bottom: 0px">
                <h1 id="fp-project">Ciencias de la computacion V</h1>
            </div>
        </div>
    </body>
</html>