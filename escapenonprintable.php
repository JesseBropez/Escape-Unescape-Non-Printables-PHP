<?php


function Escape($string) //escapes non-printables to \x[a-f0-9]{2}
{
  $string = preg_replace_callback('/[^\x20-\x7E]/',
  function ($m)
  {
    return '\\x' . bin2hex($m[0]);

  }, $string);
  return $string;
}

function Unescape($string) //unescapes \x[a-f0-9]{2}
{
  $unescape = preg_replace_callback('/\\\\x([a-f0-9]{2})/',
  function ($m)
  {
    return hex2bin($m[1]);
  }, $unescape);
  return $unescape;
}


?>
