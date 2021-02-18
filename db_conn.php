<?php 

	$sName = "localhost";
	$uName = "root";
	$pass = "";
	$db_name = "to_do_list";

	try {
		$conn = new PDO("mysql:host=$sName;dbname=$db_name;",
					$uName, $pass);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}catch(PDOExeption $e){
		echo "Conection failed : ".$e->getMessage();
	}

?>