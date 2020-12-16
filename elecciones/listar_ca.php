<?php
include "connection.php";
$link = OpenCon();
if(isset($_GET["nombre"])){
    $partido = $_GET["nombre"];
}else if(isset($_GET["partido"])){
    $partido = $_GET["partido"];
}else if(isset($_POST["pp"])){
    $partido = $_POST["pp"];
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Alcalde</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <script>
        function validate()
        {
            c = confirm("¿Borrar el candidato seleccionado?");
            if(c)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        function change()
            {
                document.alc.municipio.value = '';
                dep = document.alc.departamento.value * 100;
                max = dep + 100;
                
                var municipios = document.getElementById("munic").getElementsByTagName("option");
                for (var i = 0; i < municipios.length; i++) {
                  (dep <= municipios[i].value && municipios[i].value < max) 
                    ? municipios[i].hidden = false 
                    : municipios[i].hidden = true ;
                }

                document.alc.municipio.disabled = false;
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
                        <span style="float:left">Candidatos a Alcaldes</span>
                    </h3>
                </div>

                <?php if(isset($_GET["nombre"])){ ?>
                <div id="fp-bcontainer" class="text-m">
                    <table class="display" cellspacing="0" cellpadding="3" border="0">
                        <tbody>
                            <tr class="header">
                                <th id="fp-table2">DPI</th>
                                <th id="fp-table2">Nombre</th>
                                <th id="fp-table2">Apellido</th>
                                <th id="fp-table2">Municipio</th>
                                <th id="fp-table2">Editar</th>
                                <th id="fp-table2">Eliminar</th>
                            </tr>
                            <?php

                            $query = "SELECT * FROM Alcalde WHERE partido = '$partido'";
                            $result = pg_query($link, $query) or die('Query failed: '.pg_result_error());

                            while($line = pg_fetch_array($result,NULL,PGSQL_ASSOC)){
                                $dpiA = $line["dpi"];
                                $muni = $line["municipio"];
                                $queryN = "SELECT nombres,apellidos FROM Empadronado WHERE dpi = $dpiA";
                                $line = pg_fetch_array(pg_query($link, $queryN));
                                $query1 = "SELECT nombre FROM Municipio WHERE codigo = $muni";
                                $line1 = pg_fetch_array(pg_query($link, $query1));
                                $municipio = $line1["nombre"];
                                $nombreA = $line[0];
                                $apellidoA = $line[1];
                                echo "\t<tr>\n";
                                echo "<td id=\"fp-btable1\"><img alt=\"acc\" src=\"img/acc.png\" style=\"padding-right:5px;\">$dpiA</td>\n";
                                echo "<td id=\"fp-btable1\">$nombreA</td>\n";
                                echo "<td id=\"fp-btable1\">$apellidoA</td>\n";
                                echo "<td id=\"fp-btable1\">$municipio</td>\n";
                                echo "<td id=\"fp-btable1\"><a href=listar_ca.php?dpi=$dpiA&partido=$partido&municipio=$muni&editar=\"editar\"><img alt=\"Folder\" src=\"img/edit.png\"></a></td>\n";
							    echo "<td id=\"fp-btable1\"><a onclick=\"return validate()\" href=listar_ca.php?dpi=$dpiA&partido=$partido&eliminar=\"eliminar\"><img alt=\"Folder\" src=\"img/delete.png\"></a></td>\n";
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
                <div id="fp_bcontainer" class="text-m">
                <form name="alc" action="listar_ca.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                    <table class="display" cellspacing="0" cellpadding="3" border="0">
                        <?php
                        $dpi = $_GET["dpi"];
                        $municipio = $_GET["municipio"];
                        ?>
                        <tbody>
                            <tr class="header">
                                <th id="fp-table2">Campo</th>
                                <th id="fp-table2"></th>
                            </tr>
                            <tr>
                                <td id="fp-btable1">DPI del Alcalde</td>
                                <td id="fp-btable1"><input type="text" name="dpi" style="text-align:center" value=<?php echo $dpi; ?> readonly></td>
                            </tr>
                            <tr>
                                <td id="fp-btable1">Partido Politico</td>
                                <td id="fp-btable1"><input type="text" name='pp' style="text-align:center" value=<?php echo $partido; ?> readonly></td>
                            </tr>
                            <tr>
                                <td id="fp-btable1">Departamento</td>
                                <td id="fp-btable1">
                                    <select name="departamento" required style="text-align:center;" onchange="change()">
                                        <?php
                                            $q = "SELECT D.codigo, D.nombre FROM Departamento D, Municipio M WHERE D.codigo = M.departamento AND M.codigo = $municipio";
                                            $r = pg_query($link, $q) or die('Query failed: ' . pg_result_error());
                                            $l = pg_fetch_array($r, NULL, PGSQL_ASSOC);
                                            $departamento = $l["codigo"];
                                            $dep = $l["nombre"];
                                            echo "<option selected value=\"$departamento\">$dep</option>";


                                            $query = "SELECT codigo, nombre FROM Departamento WHERE codigo > 0 AND codigo <> $departamento ORDER BY nombre";
                                            $result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
                                            $codigo="";
                                            $nombre=0;

                                            while ($line1 = pg_fetch_array($result, NULL, PGSQL_ASSOC))
                                            {
                                                $codigo=$line1["codigo"];
                                                $nombre=$line1["nombre"];

                                                $query2 = "SELECT COUNT(codigo) as cant FROM Municipio WHERE departamento = $codigo";
                                                $result2 = pg_query($link, $query2) or die('Query failed: ' . pg_result_error());
                                                $line2 = pg_fetch_array($result2, NULL, PGSQL_ASSOC);

                                                if ($line2["cant"] != 0)
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
                                    <select name="municipio" required style="text-align:center;" id="munic">
                                        <option disabled value>-- Escoger Municipio --</option>
                                        <?php
                                            $query = "SELECT codigo, nombre FROM Municipio WHERE codigo = $municipio";
                                            $result1 = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
                                            $line1 = pg_fetch_array($result1, NULL, PGSQL_ASSOC);
                                            $dep = $line1["nombre"];
                                            echo "<option selected value=\"$municipio\">$dep</option>";


                                            $query = "SELECT codigo, nombre FROM Municipio WHERE codigo <> $municipio ORDER BY nombre";
                                            $result = pg_query($link, $query) or die('Query failed: ' . pg_result_error());
                                            $codigo="";
                                            $nombre=0;
                                            $departamento = $departamento * 100;
                                            $max = $departamento + 100;

                                            while ($line1 = pg_fetch_array($result, NULL, PGSQL_ASSOC))
                                            {
                                               $codigo=$line1["codigo"];
                                               $nombre=$line1["nombre"];

                                               if ($departamento <= $codigo && $codigo < $max)
                                               {
                                                    echo "<option value=\"$codigo\">$nombre</option>\n";
                                               }
                                               else
                                               {
                                                echo "<option value=\"$codigo\" hidden>$nombre</option>\n";
                                               }
                                               
                                            }
                                        ?>
                                    </select>
                                </td>
                            </tr>

                        </tbody>
                    </table>

                    <?php CloseCon($link);?>
                    <br>
                    <table class="display" cellspacing="0" cellpadding="3" border="0">
                        <td id="fp-btable1">
                            <span valign="top"><input type="submit" name="submit" value="Editar" id="add-bttn"></span>
                        </td>
                    </table>
                    </form>
                    <br>
                </div>
                <br>
                <div>
                    <?php
                        echo "<span style=\"float:center\" valign=\"top\"><a id=\"add-bttn\" href=listar_ca.php?nombre=$partido onclick=\"return true;\">Regresar</a></span>";
                    ?>
                </div>
                <?php }else if(isset($_GET["eliminar"])){?>
                    <table class="display" cellspacing="0" cellpadding="3" border="0">
					    <td id="fp-btable1">
                            <span style="font-size: 17px">
							<?php
							$dpi=$_GET["dpi"];
							$query = "DELETE FROM Alcalde WHERE dpi = $dpi";
							$result = pg_query($link, $query) or die('Query failed: ' . pg_result_error($link));
							if ($result){
								echo "<br>El registro de alcalde se elimino exitosamente.";
							}else{
								echo "Ups, ocurrio un error. Intentelo de nuevo.\n";
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
                                echo "<span style=\"float:center\" valign=\"top\"><a id=\"add-bttn\" href=listar_ca.php?nombre=$partido>Regresar</a></span>";
                                echo "<meta http-equiv=\"refresh\" content=\"2;url=listar_ca.php?nombre=$partido\"/>";
                             ?>
                        </td>
                    </table>
                    <br>
                <?php }else if(isset($_POST["submit"])){ ?>
                    <table class="display" cellspacing="0" cellpadding="3" border="0">
                        <td id="fp-btable1">
                            <span style="font-size: 17px">
                            <?php
                            $dpi = $_POST["dpi"];
                            $municipio = $_POST["municipio"];

                            $updated = "UPDATE alcalde SET municipio=$municipio WHERE dpi=$dpi";
                            if(pg_query($link,$updated)){
                                echo "<br>Se actualizo exitosamente.\n";
                            }else{
                                echo "Ocurrio algo, intentalo de nuevo.\n";
                            }
                            ?>
                            </span>
                        </td>
                    </table>
                    <br>
                    <table class="display" cellspacing="0" cellpadding="3" border="0">
                        <td id="fp-btable1">
                            <?php
                                echo "<span style=\"float:center\" valign=\"top\"><a id=\"add-bttn\" href=listar_ca.php?nombre=$partido>Regresar</a></span>";
                                echo "<meta http-equiv=\"refresh\" content=\"2;url=listar_ca.php?nombre=$partido\"/>";
                             ?>
                        </td>
                    </table>
                    <br>
                <?php
                }
                ?>
            </div>

            <div id="fp-footer" style="bottom: 0px">
                <h1 id="fp-project">Ciencias de la computacion V</h1>
            </div>
        </div>
    </body>
</html>