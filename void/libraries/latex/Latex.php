<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Latex
{

    public function utf8Format($string)
    {
        $string = preg_replace("#é#", "\'{e}", $string);
        $string = preg_replace("#è#", "\`{e}", $string);
        $string = preg_replace("#à#", "\`{a}", $string);
        $string = preg_replace("#ç#", "\c{c}", $string);
        $string = preg_replace("#ê#", "\^{e}", $string);
        return $string;
    }
}

?>