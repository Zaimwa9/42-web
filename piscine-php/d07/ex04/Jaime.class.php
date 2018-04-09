<?php
	class Jaime extends Lannister {
		public function sleepWith($mate) {
			if (($mate instanceof Cersei) === True)
				print("With pleasure, but only in a tower in Winterfell, then." . PHP_EOL);
			else if (($mate instanceof Lannister) === True)
				print("Not even if I'm drunk !" . PHP_EOL);
			else if (($mate instanceof Stark) === True)
				print("Let's do this." . PHP_EOL);
		}
	}
?>
