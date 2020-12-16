<?php
include "connection.php";
$link = OpenCon(); 
?>

<html>
	<head>
		<title>Mesas Disponibles</title>
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
						<span style="float:left">Mesas Disponibles</span>
						
					</h3>
				</div>

                <div id="fp-bcontainer" class="text-m">
                    <table class="display" cellspacing="0" cellpadding="3" border="0">
                        <tbody>
                            <tr class="header">
                                <th id="fp-table2">No. Mesa</th>
                                <th id="fp-table2">Municipio</th>
                                <th id="fp-table2">Partido Politico</th>
                                <th id="fp-table2">Presidente-Vicepresidente</th>
                                <th id="fp-table2">Alcalde</th>
                                <th id="fp-table2">Congreso</th>
                            </tr>

                            <?php

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