
<?php
		$serverName = "sdt3\Dts"; //serverName\instanceName
		$connectionInfo = array( "Database"=>"GcOSMtto", "UID"=>"sa", "PWD"=>"G4v0514g0");
		$conn = sqlsrv_connect( $serverName, $connectionInfo);

		if( $conn ) {
			 echo "Conexión establecida.<br />";
		}else{
			 echo "Conexión no se pudo establecer.<br />";
			 die( print_r( sqlsrv_errors(), true));
		}
?>
