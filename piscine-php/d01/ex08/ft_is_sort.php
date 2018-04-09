<?php
function asc_sort($tab) {
	$compare = $tab;
	if ($compare) {
		sort($compare);
		foreach ($compare as $key => $elem)
		{
			if ($elem !== $tab[$key])
				return FALSE;
		}
	}
	return TRUE;
}

function desc_sort($tab)
{
	$compare = $tab;
	if ($compare) {
		rsort($compare);
		foreach ($compare as $key => $elem)
		{
			if ($elem !== $tab[$key])
				return FALSE;
		}
	}
	return TRUE;
}

function ft_is_sort($tab)
{
	if (asc_sort($tab) === FALSE && desc_sort($tab) === FALSE)
		return FALSE;
	else
		return TRUE;
}
?>
