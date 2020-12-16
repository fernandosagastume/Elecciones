<?php
include "connection.php";
if(isset($_GET["nombre"])){
    $partido = $_GET["nombre"];
}else if(isset($_GET["partido"])){
    $partido = $_GET["partido"];
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
                num = document.presidenteyvicepresidente.dpiP.value;
                re = new RegExp("[- ]", 'g');
                num = num.replace(re, '')
                len = (num.length == 13)? true:false; 

                if(!len)
                {
                    alert("El DPI del presidente debe contener 13 numeros en total.");
                }

                re = new RegExp("[^0-9]");
                format = (num.match(re))? false:true;

                if(!format)
                {
                    alert("El DPI del presidente ingresado debe contener solamente numeros.");
                }

                valpresi = len && format;

                num = document.presidenteyvicepresidente.dpiV.value;
                re = new RegExp("[- ]", 'g');
                num = num.replace(re, '')
                len = (num.length == 13)? true:false; 

                if(!len)
                {
                    alert("El DPI del vicepresidente debe contener 13 numeros en total.");
                }

                re = new RegExp("[^0-9]");
                format = (num.match(re))? false:true;

                if(!format)
                {
                    alert("El DPI del vicepresidente ingresado debe contener solamente numeros.");
                }

                valvice = len && format;

                return (valpresi && valvice);
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
                        <span style="float:left">Registro de Presidente y Vicepresidente</span>
                    </h3>
                </div>

                <div id="fp-bcontainer" class="text-m">
                    <?php if(!$_POST){ ?>
                    <form name="presidenteyvicepresidente" action="registrar_cp.php" method="POST" autocomplete="on" enctype="multipart/form-data">
                        <table class="display" cellspacing="0" cellpadding="3" border="0">
                            <tbody>
                                <tr class="header">
                                    <th id="fp-table2">Campo</th>
                                    <th id="fp-table2"></th>
                                </tr>
                                <tr>
                                    <td id="fp-btable1">DPI del Presidente</td>
                                    <td id="fp-btable1"><input type="text" name="dpiP" style="text-align:center" required></td>
                                </tr>
                                <tr>
                                    <td id="fp-btable1">DPI del Vice-Presidente</td>
                                    <td id="fp-btable1"><input type="text" name="dpiV" style="text-align:center" required></td>
                                </tr>
                                <tr>
                                    <td id="fp-btable1">Partido Politico</td>
                                    <td id="fp-btable1"><input type="text" name='pp' style="text-align:center" value=<?php echo $partido; ?> readonly></td>
                                </tr>
                                <tr>
                                    <td id="fp-btable1">Imagen</td>
                                    <td id="fp-btable1"><input type="file" name="imgfile" id="imgfile" style="text-align:center" required></td>
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
                    <?php
                    }else{
                        $link = OpenCon();
                        echo "<table class=\"display\" cellspacing=\"0\" cellpadding=\"3\" border=\"0\">\n";
                        echo "<td id=\"fp-btable1\">\n";
                        echo "<span style=\"font-size: 17px\">\n";
                        $dpipresidente = $_POST["dpiP"];
                        $dpipresidente = str_replace(" ", "", $dpipresidente);
                        $dpipresidente = str_replace("-", "", $dpipresidente);
                        $dpivicepresidente = $_POST["dpiV"];
                        $dpivicepresidente = str_replace(" ", "", $dpivicepresidente);
                        $dpivicepresidente = str_replace("-", "", $dpivicepresidente);
                        $partido = $_POST["pp"];
                        $guardar = "images/$partido/presidentes/";
                        if(!file_exists($guardar)){
                            mkdir($guardar,0777,true);
                        }
                        $ruta = $guardar.basename($_FILES["imgfile"]["name"]);
                        $typeimage = strtolower(pathinfo($ruta,PATHINFO_EXTENSION));
                        if($typeimage == "png"){
                            if(!file_exists($ruta)){
                                if(!($_FILES["imgfile"]["size"] > 300000)){
                                    if(move_uploaded_file($_FILES["imgfile"]["tmp_name"],$ruta)){
                                        if($dpipresidente != $dpivicepresidente){
                                            //Verificar que no esten inscritos en otros partidos o cargos.
                                            $query1 = "SELECT dpi FROM Alcalde WHERE dpi = $dpipresidente";
                                            $query2 = "SELECT dpi FROM Alcalde WHERE dpi = $dpivicepresidente";
                                            $query3 = "SELECT dpi FROM Congreso WHERE dpi = $dpipresidente";
                                            $query4 = "SELECT dpi FROM Congreso WHERE dpi = $dpivicepresidente";
                                            if(pg_num_rows(pg_query($link,$query1)) == 0 and pg_num_rows(pg_query($link,$query2)) == 0){
                                                if(pg_num_rows(pg_query($link,$query3)) == 0 and pg_num_rows(pg_query($link,$query4)) == 0){
                                                    if(pg_num_rows(pg_query($link,"SELECT * FROM Presidencia WHERE partido='$partido'")) == 0){
                                                        $queryPresidentes = "SELECT dpi_presi FROM Presidencia WHERE $dpipresidente=dpi_presi OR $dpipresidente=dpi_vice";
                                                        $queryVicepresidentes = "SELECT dpi_presi FROM Presidencia WHERE $dpivicepresidente=dpi_presi OR $dpivicepresidente=dpi_vice";
                                                        if(pg_num_rows(pg_query($link,$queryPresidentes)) == 0 and pg_num_rows(pg_query($link,$queryVicepresidentes)) == 0){
                                                            $data = file_get_contents($ruta);
                                                            $image = pg_escape_bytea($link,$data);
                                                            $query = "INSERT INTO Presidencia VALUES($dpipresidente,$dpivicepresidente,'$partido','{$image}')";
                                                            if(pg_query($link,$query)){
                                                                $query = "SELECT M.no_mesa FROM Mesa M WHERE M.no_mesa NOT IN (SELECT C.no_mesa FROM ConteoFinal C WHERE C.partido = '$partido') ORDER BY M.no_mesa ASC";
                                                                $result = pg_query($link,$query);
                                                                while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC))
                                                                {
                                                                    $mesa = $line["no_mesa"];
                                                                    $query5 = "INSERT INTO ConteoFinal VALUES($mesa, '$partido', NULL, NULL, NULL, NULL)";
                                                                    $result5 = pg_query($link, $query5);
                                                                }

                                                                
                                                                echo "Los candidatos se registraron exitosamente";
                                                                echo "<meta http-equiv=\"refresh\" content=\"2;url=lista_pp.php?nombre=$partido&gestionar=\"\"\"/>";
                                                            }else{
                                                                echo "<br>Ocurrio un error, intentelo de nuevo.<br>";
                                                                echo "<meta http-equiv=\"refresh\" content=\"2;url=lista_pp.php?nombre=$partido&gestionar=\"\"\"/>";
                                                            }
                                                        }else{
                                                            echo "<br>Algun candidato ya esta registrado para presidente o vicepresidente.";
                                                            echo "<meta http-equiv=\"refresh\" content=\"2;url=lista_pp.php?nombre=$partido&gestionar=\"\"\"/>";
                                                        }
                                                    }else{
                                                        echo "<br>Cupo Lleno.<br>";
                                                        echo "<meta http-equiv=\"refresh\" content=\"2;url=lista_pp.php?nombre=$partido&gestionar=\"\"\"/>";
                                                    }                  
                                                }else{
                                                    echo "<br>Una o dos personas ya estan registradas en el congreso.<br>";
                                                    echo "<meta http-equiv=\"refresh\" content=\"2;url=lista_pp.php?nombre=$partido&gestionar=\"\"\"/>";
                                                }
                                            }else{
                                                echo "<br>Una o dos personas ya estan registradas como alcalde.";
                                                echo "<meta http-equiv=\"refresh\" content=\"2;url=lista_pp.php?nombre=$partido&gestionar=\"\"\"/>";
                                            }
                                        }else{
                                            echo "<br>No puede participar la misma persona para dos cargos.<br>";
                                            echo "<meta http-equiv=\"refresh\" content=\"2;url=lista_pp.php?nombre=$partido&gestionar=\"\"\"/>";
                                        }
                                    }else{
                                        echo "<br>El archivo no pudo ser procesado.<br>";
                                        echo "<meta http-equiv=\"refresh\" content=\"2;url=lista_pp.php?nombre=$partido&gestionar=\"\"\"/>";
                                    }
                                }else{
                                    echo "<br>El archivo supera los 300KB.<br>";
                                    echo "<meta http-equiv=\"refresh\" content=\"2;url=lista_pp.php?nombre=$partido&gestionar=\"\"\"/>";
                                }
                            }else{
                                echo "<br>El archivo ya existe en la base de datos.<br>";
                                echo "<meta http-equiv=\"refresh\" content=\"2;url=lista_pp.php?nombre=$partido&gestionar=\"\"\"/>";
                            }
                        }else{
                            echo "<br>La imagen no es un archivo de tipo png.<br>";    
                            echo "<meta http-equiv=\"refresh\" content=\"2;url=lista_pp.php?nombre=$partido&gestionar=\"\"\"/>";
                        }
                        unlink($ruta);
                        CloseCon($link);
                        echo "</span>\n";
                        echo "</td>\n";
                        echo "</table>\n";
                    } 
                    ?>
                    <br>
                </div>

                <br>
                <div>
                    <?php
                    echo "<span style=\"float:center\" valign=\"top\"><a id=\"add-bttn\" href=lista_pp.php?nombre=$partido&gestionar=\"\" >Regresar</a></span>";
                    ?>
                </div>
            </div>

            <div id="fp-footer" style="bottom: 0px">
                <h1 id="fp-project">Ciencias de la computacion V</h1>
            </div>
        </div>
    </body>
</html>