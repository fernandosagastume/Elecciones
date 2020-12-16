<?php
	function OpenCon()
	{
		$con_str = "host=localhost port=80 dbname=final user=root password=";
		$conn = pg_connect($con_str);

		return $conn;
	}

	function CloseCon($conn)
	{
		pg_close($conn);
	}
?>