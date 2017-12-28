<?php 
  function EscapeNonASCII($string) //Convert string to hex, replace non-printable chars with escaped hex
    {
        $hexbytes = strtoupper(bin2hex($string));
        $i = 0;
        while ($i < strlen($hexbytes))
        {
            $hexpair = substr($hexbytes, $i, 2);
            $decimal = hexdec($hexpair);
            if ($decimal < 32 || $decimal > 126)
            {
                $top = substr($hexbytes, 0, $i);
                $escaped = EscapeHex($hexpair);
                $bottom = substr($hexbytes, $i + 2);
                $hexbytes = $top . $escaped . $bottom;
                $i += 8;
            }
            $i += 2;
        }
        $string = hex2bin($hexbytes);
        return $string;
    }

    function EscapeHex($string) //Helper function for EscapeNonASCII()
    {
        $x = "5C5C78"; //\x
        $topnibble = bin2hex($string[0]); //Convert top nibble to hex
        $bottomnibble = bin2hex($string[1]); //Convert bottom nibble to hex
        $escaped = $x . $topnibble . $bottomnibble; //Concatenate escape sequence "\x" with top and bottom nibble
        return $escaped;
    }
    

    function UnescapeNonASCII($string) //Convert string to hex, replace escaped hex with actual hex.
    {
        $stringtohex = bin2hex($string);
        $stringtohex = preg_replace_callback('/5c5c78([a-fA-F0-9]{4})/', function ($m) { 
            return hex2bin($m[1]);
        }, $stringtohex);
        return hex2bin(strtoupper($stringtohex));
    }
?>
