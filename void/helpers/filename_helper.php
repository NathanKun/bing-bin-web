<?php

defined('BASEPATH') OR exit('No direct script access allowed');

function getThumb($originalFileName)
    {
        $extension = substr($originalFileName, strpos($originalFileName,'.')+1);
        $fileName =  substr($originalFileName, 0, strpos($originalFileName,'.'));

        return $fileName.'_thumb.'.$extension;
    }

function camelCase($string)
{
    $string = ucwords($string);
    $string = str_replace(' ', '', $string);

    return $string;
}

function dispURL($url)
{
    if(strpos($project['url'], "http") !== FALSE)
    {
        return $project['url'];
    }else{
        return URL.$project['url'];
    }
}

?>