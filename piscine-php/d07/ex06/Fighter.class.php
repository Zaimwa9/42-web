<?php
	abstract class Fighter {
		static $name = "";

		abstract public function fight($target);

		public function __construct($string) {
			$this->name = $string;
		}
	}
?>
