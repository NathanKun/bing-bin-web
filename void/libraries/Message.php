<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message
{

    public function error($string, $display = true)
    {
        $surround = "<div class=\"alert alert-danger text-center\" role=\"alert\">
            <span class=\"glyphicon glyphicon-alert\"></span>
            {$string}
        </div>";

        if($display){
            echo $surround;
        }
        else{
            return $surround;
        }
    }

    public function info($string, $display = true)
    {
        $surround = "<div class=\"alert alert-info text-center\" role=\"alert\">
            <span class=\"glyphicon glyphicon-info-sign\"></span>
            {$string}
        </div>";

        if($display){
            echo $surround;
        }
        else{
            return $surround;
        }
    }

    private function surround($string)
    {
        $surround = "<div class=\"alert alert-info text-center\" role=\"alert\">
            <span class=\"glyphicon glyphicon-info-sign\"></span>
            Les champs marqués * sont obligatoires
        </div>";
    }

    public function title($title, $subtitle='')
    {
        return "
        <section class=\"global-page-header\">
            <div class=\"container\">
                <div class=\"row\">
                    <div class=\"block\">
                        <h2>{$title}</h2>
                    </div>
                </div>
            </div>
        </section>
        ";

    }
}

?>