<?php

defined('BASEPATH') OR exit('No direct script access allowed');


function generateToken()
{
    $time = microtime();
        $token = uniqid($time, true);
        $token = str_replace(" ","", $token);
        $token = str_replace(".","", $token);
        $token = substr($token, 2);

    return $tokens;
}

?>