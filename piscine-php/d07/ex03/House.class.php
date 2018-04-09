<?php
	abstract class House {

		abstract function getHouseName();

		abstract function getHouseMotto();

		abstract function getHouseSeat();

		public function introduce() {
			print("House " . static::getHousename() . " of " . static::getHouseSeat() . ' : "' . static::getHouseMotto() . '"' . PHP_EOL);
		}
	}
?>
