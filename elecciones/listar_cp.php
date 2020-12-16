<?php
include 'connection.php';
$link = OpenCon(); 
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Presidente y Vicepresidente</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <script>
            function validate()
            {
                c = confirm("¿Borrar los candidatos seleccionados?");
                if(c)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }

            function validatedpi()
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
                        <span style="float:left">Candidatos Presidente y Vicepresidente</span>
                    </h3>
                </div>

                <?php if(isset($_GET["nombre"])){?>
                <div id="fp-bcontainer" class="text-m">
                    <table class="display" cellspacing="0" cellpadding="3" border="0">
                        <tbody>
                            <tr class="header">
                                <th id="fp-table2">DPI Presi.</th>
                                <th id="fp-table2">Presidente</th>
                                <th id="fp-table2">DPI Vice.</th>
                                <th id="fp-table2">Vicepresidente</th>
                                <th id="fp-table2">Foto</th>
                                <th id="fp-table2">Editar</th>
                                <th id="fp-table2">Eliminar</th>
                            </tr>

                            <?php
                            $partido = $_GET["nombre"];
                            $query = "SELECT * FROM presidencia WHERE partido = '$partido'";
                            $result = pg_query($link, $query) or die('Query failed: '.pg_result_error());

                            if(pg_num_rows($result) == 1){
                                $queryP = "SELECT dpi_presi,dpi_vice,foto FROM presidencia WHERE partido = '$partido'";
                                $resultP = pg_query($link, $queryP) or die('Query failed: '.pg_result_error());
                                $fila = pg_fetch_array($resultP);
                                $dpi_presi = $fila[0];
                                $dpi_vice = $fila[1];
                                $foto = $fila[2];
                                $queryNP = "SELECT nombres,apellidos FROM Empadronado WHERE dpi = $dpi_presi";
                                $queryNV = "SELECT nombres,apellidos FROM Empadronado WHERE dpi = $dpi_vice";
                                $nombreCompletoP = pg_fetch_array(pg_query($link, $queryNP));
                                $nombreCompletoV = pg_fetch_array(pg_query($link, $queryNV));
                                echo "\t<tr>\n";
                                echo "<td id=\"fp-btable1\"><img alt=\"acc\" src=\"img/acc.png\" style=\"padding-right:5px;\">$dpi_presi</td>\n";
                                echo "<td id=\"fp-btable1\">$nombreCompletoP[0] $nombreCompletoP[1]</td>\n";
                                echo "<td id=\"fp-btable1\"><img alt=\"acc\" src=\"img/acc.png\" style=\"padding-right:5px;\">$dpi_vice</td>\n";
                                echo "<td id=\"fp-btable1\">$nombreCompletoV[0] $nombreCompletoV[1]</td>\n";
                                echo "<td id=\"fp-btable1\"><img src=imagen.php?data=$dpi_presi&partido=$partido style=\"max-width: 100px; max-height: 100px\"/></td>\n";
                                echo "<td id=\"fp-btable1\"><a href=listar_cp.php?dpi_P=$dpi_presi&partido=$partido&editar=\"editar\"><img alt=\"Folder\" src=\"img/edit.png\"></a></td>\n";
								echo "<td id=\"fp-btable1\"><a onclick=\"return validate()\" href=listar_cp.php?dpi_P=$dpi_presi&partido=$partido&eliminar=\"eliminar\"><img alt=\"Folder\" src=\"img/delete.png\"></a></td>\n";
                                echo "\t</tr>\n";
                            }
                            CloseCon($link);
                            ?>

                        </tbody>
					</table>

                </div>
                <br>
                <div>
                    <?php
                    echo "<span style=\"float:center\" valign=\"top\"><a id=\"add-bttn\" href=lista_pp.php?nombre=$partido&gestionar=\"\" onclick=\"return true;\">Regresar</a></span>";
                    ?>
                </div>
                <?php }else if(isset($_GET["editar"])){?>
                    <?php
                    $dpipresidente = $_GET["dpi_P"];
                    $partido = $_GET["partido"];
                    $query = "SELECT dpi_vice FROM Presidencia WHERE dpi_presi = $dpipresidente";
                    $dpivicepresidente = pg_fetch_array(pg_query($link,$query));
                    $dpivicepresidente = $dpivicepresidente[0];
                    CloseCon($link);
                    ?>
                    <div id="fp-bcontainer" class="text-m">
                        <form name="presidenteyvicepresidente" action="listar_cp.php" method="POST" autocomplete="on" enctype="multipart/form-data">
                            <table class="display" cellspacing="0" cellpadding="3" border="0">
                                    <tbody>
                                        <tr class="header">
                                            <th id="fp-table2">Campo</th>
                                            <th id="fp-table2"></th>
                                        </tr>
                                        <tr>
                                            <td id="fp-btable1">DPI del Presidente</td>
                                            <td id="fp-btable1"><input type="text" name="dpiP" style="text-align:center" value=<?php echo $dpipresidente; ?> required></td>
                                        </tr>
                                        <tr>
                                            <td id="fp-btable1">DPI del Vice-Presidente</td>
                                            <td id="fp-btable1"><input type="text" name="dpiV" style="text-align:center" value=<?php echo $dpivicepresidente;?> required></td>
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
                                    <span valign="top"><input type="submit" name="submit" value="Actualizar" id="add-bttn" onclick="return validatedpi()"></span>
                                </td>
                            </table>
                        </form>
                        <br>
                    </div>
                    <br>
                    <div>
                        <?php
                        echo "<span style=\"float:center\" valign=\"top\"><a id=\"add-bttn\" href=listar_cp.php?nombre=$partido onclick=\"return true;\">Regresar</a></span>";
                        ?>
                    </div>
                <?php }else if(isset($_GET["eliminar"])){?>
                <table class="display" cellspacing="0" cellpadding="3" border="0">
					<td id="fp-btable1">
						<span style="font-size: 17px">
                        <?php
                        $dpipresidente = $_GET["dpi_P"];
                        $partido = $_GET["partido"];
                        $query = "DELETE FROM Presidencia WHERE dpi_presi = $dpipresidente";
                        if(pg_query($link,$query)){
                            echo "<br>Los candidatos se eliminaron exitosamente.\n";
                        }else{
                            echo "<br>Ups, ocurrio un error. Intentalo de nuevo.\n";
                        }
                        ?>
						</span>
					</td>
				</table>
                <br>
                <table class="display" cellspacing="0" cellpadding="3" border="0">
                    <td id="fp-btable1">
                        <?php
                            echo "<span style=\"float:center\" valign=\"top\"><a id=\"add-bttn\" href=lista_pp.php?nombre=$partido&gestionar=\"\" onclick=\"return true;\">Regresar</a></span>";
                            echo "<meta http-equiv=\"refresh\" content=\"2;url=lista_pp.php?nombre=$partido&gestionar=\"\"\"/>";
                         ?>
                    </td>
                </table>
                <br>
                
                <?php }else if(isset($_POST["submit"])){?>
                <table class="display" cellspacing="0" cellpadding="3" border="0">
					<td id="fp-btable1">
						<span style="font-size: 17px">
                        <?php
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
                                                    $query1 = "SELECT dpi_presi,dpi_vice FROM Presidencia WHERE partido = '$partido'";
                                                    $dpipresiT = pg_fetch_array(pg_query($link,$query1));
                                                    if($dpipresiT[0] != $dpipresidente){
                                                        $data = file_get_contents($ruta);
                                                        $image = pg_escape_bytea($link,$data);
                                                        if(pg_query($link,"DELETE FROM Presidencia WHERE dpi_presi = $dpipresiT[0]")){
                                                            if(pg_query($link,"INSERT INTO Presidencia VALUES($dpipresidente,$dpivicepresidente,'$partido','{$image}')")){
                                                                echo "<br>Se actualizo exitosamente.\n"; 
                                                            }else{
                                                                echo "Ocurrio algo, intentalo de nuevo.\n";
                                                            }
                                                        }else{
                                                            echo "Ocurrio algo, intentalo de nuevo.\n";
                                                        }
                                                    }else{
                                                        $data = file_get_contents($ruta);
                                                        $image = pg_escape_bytea($link,$data);
                                                        $queryUpdate = "UPDATE Presidencia SET dpi_vice=$dpivicepresidente,partido='$partido',foto='{$image}' WHERE dpi_presi = $dpipresidente";
                                                        if(pg_query($link,$queryUpdate)){
                                                            echo "<br>Se actualizo exitosamente.\n";
                                                        }else{
                                                            echo "Ocurrio algo, intentalo de nuevo.\n";
                                                        }
                                                    }                                              
                                                }else{
                                                    echo "<br>Una o dos personas ya estan registradas en el congreso.\n";
                                                }
                                            }else{
                                                echo "<br>Una o dos personas ya estan registradas como alcalde.";
                                            }
                                        }else{
                                            echo "<br>No puede participar la misma persona para dos cargos.\n";
                                        }
                                    }else{
                                        echo "<br>El archivo no pudo ser procesado.\n";
                                        
                                    }
                                }else{
                                    echo "<br>El archivo supera los 300KB.\n";
                                    
                                }
                            }else{
                                echo "<br>El archivo ya existe en la base de datos.\n";
                                
                            }
                        }else{
                            echo "<br>La imagen no es un archivo de tipo png.\n";     
                        }
                        unlink($ruta);
                        ?>
						</span>
					</td>
				</table>
                <br>
                <table class="display" cellspacing="0" cellpadding="3" border="0">
                    <td id="fp-btable1">
                        <?php
                            echo "<span style=\"float:center\" valign=\"top\"><a id=\"add-bttn\" href=lista_pp.php?nombre=$partido&gestionar=\"\" onclick=\"return true;\">Regresar</a></span>";
                            echo "<meta http-equiv=\"refresh\" content=\"2;url=lista_pp.php?nombre=$partido&gestionar=\"\"\"/>";
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