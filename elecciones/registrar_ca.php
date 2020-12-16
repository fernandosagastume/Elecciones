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
        <script>
            function validate()
            {
                num = document.empadronamiento.dpi.value;
                re = new RegExp("[- ]", 'g');
                num = num.replace(re, '')
                len = (num.length == 13)? true:false; 

                if(!len)
                {
                    alert("El DPI debe contener 13 numeros en total.");
                }

                re = new RegExp("[^0-9]");
                format = (num.match(re))? false:true;

                if(!format)
                {
                    alert("El DPI ingresado debe contener solamente numeros.");
                }

                return (len && format);
            }

            function change()
            {
                document.alcalde.municipio.value = '';
                dep = document.alcalde.departamento.value * 100;
                max = dep + 100;
                
                var municipios = document.getElementById("munic").getElementsByTagName("option");
                for (var i = 0; i < municipios.length; i++) {
                  (dep <= municipios[i].value && municipios[i].value < max) 
                    ? municipios[i].hidden = false 
                    : municipios[i].hidden = true ;
                }

                document.alcalde.municipio.disabled = false;
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
                        <span style="float:left">Registro de Alcalde</span>
                    </h3>
                </div>

                <div id="fp-bcontainer" class="text-m">
                    <?php if(!$_POST){?>
                    <form name="alcalde" id="alc" action="registrar_ca.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                        <table class="display" cellspacing="0" cellpadding="3" border="0">
                            <tbody>
                                <tr class="header">
                                    <th id="fp-table2">Campo</th>
                                    <th id="fp-table2"></th>
                                </tr>
                                <tr>
                                    <td id="fp-btable1">DPI del Alcalde</td>
                                    <td id="fp-btable1"><input type="text" name="dpi" style="text-align:center" required></td>
                                </tr>
                                <tr>
                                    <td id="fp-btable1">Partido Politico</td>
                                    <td id="fp-btable1"><input type="text" name='pp' style="text-align:center" value=<?php echo $partido; ?> readonly></td>
                                </tr>

                                <tr>
                                    <td id="fp-btable1">Departamento</td>
                                    <td id="fp-btable1">
                                        <select name="departamento" required style="text-align:center;" onchange="change()">
                                            <option disabled selected value>-- Escoger Departamento --</option>
                                            <?php

                                                $query = "SELECT codigo, nombre FROM Departamento WHERE codigo > 0 ORDER BY nombre";
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

                                                    if ($line1["cant"] != 0)
                                                    {
                                                        echo "<option value=\"$codigo\">$nombre</option>\n";
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td id="fp-btable1">Municipio</td>
                                    <td id="fp-btable1">
                                        <select name="municipio" required style="text-align:center;" id="munic" disabled>
                                            <option disabled selected value>-- Escoger Municipio --</option>
                                            <?php
                                                $query = "SELECT codigo, nombre FROM Municipio ORDER BY nombre";
                                                $result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
                                                $codigo="";
                                                $nombre=0;

                                                while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC))
                                                {
                                                   $codigo=$line["codigo"];
                                                   $nombre=$line["nombre"];
                                                   echo "<option value=\"$codigo\">$nombre</option>\n";
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
                                <span valign="top"><input type="submit" name="submit" value="Registrar" id="add-bttn"></span>
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
                    <?php
                    }else{
                        echo "<table class=\"display\" cellspacing=\"0\" cellpadding=\"3\" border=\"0\">\n";
                        echo "<td id=\"fp-btable1\">\n";
                        echo "<span style=\"font-size: 17px\">\n";
                        $dpi = $_POST["dpi"];
                        $partido = $_POST["pp"];
                        $municipio = $_POST["municipio"];

                        $query1 = "SELECT * FROM Presidencia WHERE $dpi=dpi_presi OR $dpi=dpi_vice";
                        $query2 = "SELECT * FROM Alcalde WHERE $dpi=dpi;";
                        $query3 = "SELECT * FROM Congreso WHERE $dpi=dpi;";
                        $query4 = "SELECT * FROM Empadronado WHERE $dpi=dpi";
                        $query5 = "SELECT * FROM Alcalde WHERE '$partido'=partido AND $municipio=municipio";

                        if(pg_num_rows(pg_query($link,$query1))==0 and pg_num_rows(pg_query($link,$query2))==0 and pg_num_rows(pg_query($link,$query3))==0){
                            if(pg_num_rows(pg_query($link,$query4))==1){
                                if(pg_num_rows(pg_query($link,$query5))==0){
                                    if(pg_query($link,"INSERT INTO Alcalde VALUES($dpi,'$partido',$municipio);")){
                                        $query = "SELECT M.no_mesa FROM Mesa M WHERE M.municipio = $municipio AND M.no_mesa NOT IN (SELECT C.no_mesa FROM ConteoFinal C WHERE C.partido = '$partido')";
                                        $result = pg_query($link,$query);
                                        while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC))
                                        {
                                            $mesa = $line["no_mesa"];
                                            $query5 = "INSERT INTO ConteoFinal VALUES($mesa, '$partido', NULL, NULL, NULL, NULL)";
                                            $result5 = pg_query($link, $query5);
                                        }
                                        echo "El registro se completo exitosamente.";
                                    }else{
                                        echo "Ocurrio algo, intentalo de nuevo.";
                                    }
                                }else{
                                    echo "El municipio ya esta ocupado por otro candidato.";
                                }
                            }else{
                                echo "El candidato de DPI ".$dpi." no esta empadronado.";
                            }
                        }else{
                            echo "El candidato de DPI ".$dpi." ya esta registrado como candidato en la base de datos.";
                            echo "El candidato solo puede optar por un puesto.";
                        }

                        echo "</span>\n";
                        echo "</td>\n";
                        echo "</table>\n";
                        echo "<br>";
                        echo "<table class=\"display\" cellspacing=\"0\" cellpadding=\"3\" border=\"0\">";
                        echo "<td id=\"fp-btable1\">";
                        echo "<span style=\"float:center\" valign=\"top\"><a id=\"add-bttn\" href=\"lista_pp.php?nombre=$partido&gestionar=\"\"\">Regresar</a></span>";
                        echo "<meta http-equiv=\"refresh\" content=\"3;url=lista_pp.php?nombre=$partido&gestionar=\"\"\"/>";
                        echo "</td>";
                        echo "</table>";
                    } 
                    echo "<br></div>";
                    ?>
            </div>

            <div id="fp-footer" style="bottom: 0px">
                <h1 id="fp-project">Ciencias de la computacion V</h1>
            </div>
        </div>
    </body>
</html>