<?php
	try {

		$conn = mysqli_connect("mysql", "root", "1234", "dados_pet");

	} catch (mysqli_sql_exception $e){

		die("Erro ao conectar com o banco de dados: " . $e->getMessage());
	}

?>