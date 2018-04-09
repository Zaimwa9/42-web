<?php
	class Lannister {
		public function sleepWith($mate) {
			if (($mate instanceof Lannister) === True)
				print ("Not even if I'm drunk !" . PHP_EOL);
			else if (($mate instanceof Sansa) === True)
				print ("Let's do this." . PHP_EOL);
		}
	}
?>
