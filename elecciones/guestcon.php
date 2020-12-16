<?php
	function OpenCon()
	{
		$con_str = "host=localhost port=5432 dbname=final user=empadronado password='aiudenos'";
		$conn = pg_connect($con_str);

		return $conn;
	}

	function CloseCon($conn)
	{
		pg_close($conn);
	}
?>