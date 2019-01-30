<?php
	class bd {
		public $DBH = null; //Database Handler

		function __construct(){
			$this->ligar_bd();
		}

		function ligar_bd() {
			//variaveis que se encontram no ficheiro conf
			global $host; global $dbname; global $user; global $pass;

			try {
				$this->DBH = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
				$this->DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch(PDOException $e) {
				echo $e->getMessage();
			}
		}

		function desligar_bd(){
			$this->DBH = null;
		}
	}

?>
