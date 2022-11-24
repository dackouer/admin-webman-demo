<?php
	namespace app\lib;

	class Encrypt{
		private $cost = 12;
		private $salt = '';

		public function __construct($cost = 12,$salt = 'tFOHr5IRw9zd2i9M8yK07gN70f5J9OEsd78m2Axux5'){
			$this->salt = $salt;
			$this->cost = $cost;
		}

		public static function create($str){
			return password_hash($str, PASSWORD_BCRYPT,["cost" => 12]);
		}
	}
?>