<?php
require('Latex.php');
class LREGIST extends Latex
{
    private static $sourceCode =
    "\documentclass[a4paper, 12pt]{article}
\usepackage[utf8]{inputenc}
\usepackage[top=3cm, left=2cm, right=2cm, bottom=3cm]{geometry}
\usepackage{graphics}
\usepackage{hyperref}
\usepackage{longtable}

\\title{confirmationInscription}
\author{Asa }
\date{June 2017}


\\begin{document}
\section*{\sc Liste des inscrits}
\\begin{longtable}[c]{|p{6cm}|p{2cm}|p{2cm}|p{5cm}|}
Nom & Distance & Status & Club
\\endfirsthead
\\hline
@table@
\\end{longtable}
\\end{document}
";

    public function setInfos($list)
    {
        $table = "";
        $alter = false;
        foreach ($list as $key => $row) {
            $table .= $this->utf8Format($row->name).' '.$this->utf8Format($row->firstname).' & '.$this->utf8Format($row->distance).' & ';
            if($row->register)
            {
                $table .= 'inscrit';
            }
            else
            {
                $table .= "pr\'{e}-inscrit";
            }
            $table .= " & ".$this->utf8Format($row->club);

                $table .= addslashes("\\").addslashes("\\")."\n";
                $table .= "\\hline "."\n";
            
            //echo $table;
        }

        self::$sourceCode = preg_replace("#@table@#", $table, self::$sourceCode);
    }

    public function writeFile()
    {
        $fileName = time()."_list";
        $file = fopen(LINK."assets/pdf/".$fileName.".tex",'w');

        fwrite($file, self::$sourceCode);
        fclose($file);

        // compilation fichier
        $tmp = array();
        exec("pdflatex ".LINK."assets/pdf/".$fileName.".tex", $tmp);
        //var_dump($tmp);
        exec("mv ".LINK.'/'.$fileName.".pdf ".LINK."assets/pdf/".$fileName.".pdf");
        exec("rm -R ".$fileName.".* ".LINK."assets/pdf/".$fileName.".tex");

        return $fileName;
    }
}

?>