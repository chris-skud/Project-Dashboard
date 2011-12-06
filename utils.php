<?php
function htmlEncodeRequest($var)
{
	if (is_array($var)) {
		$out = array();
		foreach ($var as $key => $v) {
			$out[$key] = htmlEncodeRequest($v);
		}
	} else {
		$out = htmlspecialchars_decode($var);
		$out = htmlspecialchars(stripslashes(trim($out)), ENT_QUOTES);
	}
   
	return $out;
}

// will return false if invalid param passed.
function GetDateFromSqlTimestamp($sqlTimestamp)
{
	return date("n/j/y", strtotime($sqlTimestamp));
}

?>