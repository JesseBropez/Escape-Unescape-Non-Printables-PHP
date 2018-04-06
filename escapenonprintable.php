<?php


	function Escape($string) //escapes non-printables to \x[a-fA-F0-9]{2}
	{
		$string = str_replace('\\','\\\\',$string); //escape single backslashes already present, this way, when we unescape, we'll know the difference
		$string = preg_replace_callback('/[^\x20-\x7E]/',
		function ($m)
		{
			return '\\x' . bin2hex($m[0]);
			
		}, $string);
		return $string;
	}

	function Unescape($string) //unescapes \x[a-fA-F0-9]{2}
	{
		$string = preg_replace_callback('/(\\\\+)x([a-fA-F0-9]{2})/',
		function ($m)
		{
			if (strlen($m[1]) % 2 !== 0) //check count of backslashes to make sure they're odd, if they are, these were escaped non-printable characters
			{
				return substr($m[0], 0, -4) . hex2bin($m[2]);
			}
			return $m[0];
			
		}, $string);
		return str_replace('\\\\','\\',$string);
	}


?>
