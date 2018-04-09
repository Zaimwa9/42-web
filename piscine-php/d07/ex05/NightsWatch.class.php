<?php

class NightsWatch {

	protected $fighters = [];

	public function recruit($fighter) {
		if (method_exists($fighter, 'fight'))
			$this->fighters[] = $fighter;
	}

	public function fight() {
		foreach ($this->fighters as $knight)
			if (($knight instanceof IFighter) === True)
				$knight->fight();
	}
}
?>
