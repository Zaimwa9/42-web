<?php
	class UnholyFactory {

		private $stomach = [];

		public function absorb($fighter) {
			if (!($this->stomach[$fighter->name]) && ($fighter instanceof Fighter) === True) {
				$this->stomach[$fighter->name] = $fighter;
				print("(Factory absorbed a fighter of type " . $fighter->name . ")" . PHP_EOL);
			} else {
				if (!($fighter instanceof Fighter))
					print("(Factory can't absorb this, it's not a fighter)" . PHP_EOL);
				else
					print("(Factory already absorbed a fighter of type " . $fighter->name . ")" . PHP_EOL);
			}
		}

		public function fabricate ( $fighter ) {
			if (($this->stomach[$fighter])) {
				print("(Factory fabricates a fighter of type " . $fighter . ")" . PHP_EOL);
				return ($this->stomach[$fighter]);
			} else {
				print("(Factory hasn't absorbed any fighter of type " . $fighter . ")" . PHP_EOL);
			}
		}
	}
?>
