<?php
include "connection.php";
$link = OpenCon();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Congreso</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <script>
        function validate()
        {
            c = confirm("¿Borrar el diputado seleccionado?");
            if(c)
            {
                return true;
            }
            else
            {
                return false;
            }
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
                        <span style="float:left">Candidatos a Congreso</span>
                    </h3>
                </div>

                <?php if(isset($_GET["nombre"])){?>
                <div id="fp-bcontainer" class="text-m">
                    <table class="display" cellspacing="0" cellpadding="3" border="0">
                        <tbody>
                            <tr class="header">
                                <th id="fp-table2">DPI</th>
                                <th id="fp-table2">Nombre</th>
                                <th id="fp-table2">Apellido</th>
                                <th id="fp-table2">Departamento</th>
                                <th id="fp-table2">Casilla</th>
                                <th id="fp-table2">Editar</th>
                                <th id="fp-table2">Eliminar</th>
                            </tr>

                            <?php
                            if(isset($_GET["nombre"])){
                                $partido = $_GET["nombre"];
                            }else if(isset($_GET["partido"])){
                                $partido = $_GET["partido"];
                            }
                            $query = "SELECT * FROM Congreso WHERE partido='$partido'";
                            $resultado = pg_query($link,$query);

                            $dpi = "";
                            $departamento = "";
                            while($row = pg_fetch_array($resultado,NULL,PGSQL_ASSOC)){
                                $dpi = $row["dpi"];
                                $queryC = "SELECT nombres,apellidos FROM Empadronado WHERE $dpi=dpi;";
                                
                                $result = pg_fetch_array(pg_query($link,$queryC));
                                $nombre = $result["nombres"];
                                $apellido = $result["apellidos"];
                                $departamento = $row["departamento"];
                                $casilla = $row["casilla"];

                                $queryD = "SELECT nombre FROM Departamento WHERE codigo=$departamento;";
                                $resultD = pg_fetch_array(pg_query($link,$queryD));
                                $departamento = $resultD["nombre"];
                                echo "\t<tr>\n";
                                echo "<td id=\"fp-btable1\"><img alt=\"acc\" src=\"img/acc.png\" style=\"padding-right:5px;\">$dpi</td>\n";
                                echo "<td id=\"fp-btable1\">$nombre</td>\n";
                                echo "<td id=\"fp-btable1\">$apellido</td>\n";
                                echo "<td id=\"fp-btable1\">$departamento</td>\n";
                                echo "<td id=\"fp-btable1\">$casilla</td>\n";
                                echo "<td id=\"fp-btable1\"><a href=listar_cc.php?editar=$dpi&partido=$partido><img alt=\"Folder\" src=\"img/edit.png\"></a></td>\n";
                                echo "<td id=\"fp-btable1\"><a onclick=\"return validate()\" href=listar_cc.php?eliminar=$dpi&partido=$partido><img alt=\"Folder\" src=\"img/delete.png\"></a></td>\n";
                                echo "\t</tr>\n";

                            }
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
                <?php
                CloseCon($link); 
                }else if(isset($_GET["editar"])){?>
                <?php
                $dpi = $_GET["editar"];
                $query = "SELECT departamento,casilla FROM Congreso WHERE $dpi = dpi;";
                $datos = pg_fetch_array(pg_query($link,$query));
                $departamento = $datos["departamento"];
                $casilla = $datos["casilla"];
                $partido = $_GET["partido"];
                ?>
                <div id="fp-bcontainer" class="text-m">
                    <form name="presidenteyvicepresidente" action="listar_cc.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                        <table class="display" cellspacing="0" cellpadding="3" border="0">
                            <tbody>
                                <tr class="header">
                                    <th id="fp-table2">Campo</th>
                                    <th id="fp-table2"></th>
                                </tr>
                                <tr>
                                    <td id="fp-btable1">DPI del Candidato</td>
                                    <td id="fp-btable1"><input type="number" name="dpi" style="text-align:center" value=<?php echo $dpi; ?> readonly></td>
                                </tr>
                                <tr>
                                    <td id="fp-btable1">Departamento</td>
                                    <td id="fp-btable1">
                                        <select name="departamento" required style="text-align:center;">
                                            <?php
                                            $q = "SELECT nombre FROM Departamento WHERE codigo = $departamento";
                                            $r = pg_query($link, $q) or die('Query failed: ' . pg_result_error());
                                            $l = pg_fetch_array($r, NULL, PGSQL_ASSOC);
                                            $n = $l["nombre"];

                                            echo "<option selected value=\"$departamento\">$n</option>";


											$queryDep = "SELECT codigo, nombre FROM Departamento WHERE codigo <> $departamento ORDER BY nombre";
											$resultDep = pg_query($link, $queryDep) or die('Query failed: ' . pg_result_error());
											$codigoD="";
											$nombreD=0;

											while ($lineD = pg_fetch_array($resultDep, NULL, PGSQL_ASSOC))
											{
											   $codigoD=$lineD["codigo"];
											   $nombreD=$lineD["nombre"];

                                               $query1 = "SELECT COUNT(codigo) as cant FROM Municipio WHERE departamento = $codigoD";
                                                $result1 = pg_query($link, $query1) or die('Query failed: ' . pg_result_error());
                                                $line1 = pg_fetch_array($result1, NULL, PGSQL_ASSOC);

                                                $cant = $line1["cant"];
                                                if ($cant != 0 || $codigoD == 0)
                                                {
                                                    echo "<option value=\"$codigoD\">$nombreD</option>\n";
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
                                    <td id="fp-btable1"><input type="number" min="1" max="5" name="casilla" style="text-align:center" value=<?php echo $casilla; ?> required></td>
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
                        echo "<span style=\"float:center\" valign=\"top\"><a id=\"add-bttn\" href=listar_cc.php?nombre=$partido onclick=\"return true;\">Regresar</a></span>";
                    ?>
                </div>
                <?php
                CloseCon($link); 
                }else if(isset($_GET["eliminar"])){?>
                <table class="display" cellspacing="0" cellpadding="3" border="0">
					<td id="fp-btable1">
						<span style="font-size: 17px">
							<?php
                            $dpi = $_GET["eliminar"];
                            $partido = $_GET["partido"];
                            $query = "DELETE FROM Congreso WHERE $dpi=dpi";
                            if(pg_query($link,$query)){
                                echo "<br>\n";
                                echo "El candidato se elimino exitosamente.\n";
                            }else{
                                echo "<br>\n";
                                echo "Ocurrio algo, intentelo de nuevo.\n";
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
                            echo "<span style=\"float:center\" valign=\"top\"><a id=\"add-bttn\" href=lista_pp.php?nombre=$partido&gestionar=\"\" onclick=\"return true;\">Regresar</a></span>";
                            
                            echo "<meta http-equiv=\"refresh\" content=\"2;url=lista_pp.php?nombre=$partido&gestionar=\"\"/>";
                        ?>
                    </td>
                </table>
                <br>
                <?php }else if(isset($_POST["submit"])){?>
                <table class="display" cellspacing="0" cellpadding="3" border="0">
					<td id="fp-btable1">
						<span style="font-size: 17px">
                            <?php
                            $dpi = $_POST["dpi"];
                            $departamento = $_POST["departamento"];
                            $partido = $_POST["pp"];
                            $casilla = $_POST["casilla"];
                            
                            $query = "UPDATE Congreso SET departamento=$departamento,casilla=$casilla WHERE dpi=$dpi";
                            if(pg_query($link,$query)){
                                echo "<br>";
                                echo "El candidato se actualizco exitosamente.\n";
                            }else{
                                echo "<br>";
                                echo "Ocurrio algo, intentalo de nuevo.\n";
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
                            echo "<span style=\"float:center\" valign=\"top\"><a id=\"add-bttn\" href=lista_pp.php?nombre=$partido&gestionar=\"\" onclick=\"return true;\">Regresar</a></span>";
                            
                            echo "<meta http-equiv=\"refresh\" content=\"2;url=lista_pp.php?nombre=$partido&gestionar=\"\"/>";
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