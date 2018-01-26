<?php

class EREGIST
{
    private static $sourceCode =
    "\documentclass[a4paper, 12pt]{article}
%\usepackage[utf8]{inputenc}
\usepackage[T1]{fontenc}
\usepackage[top=3cm, left=2cm, right=2cm, bottom=3cm]{geometry}
\usepackage{graphics}
\usepackage{hyperref}

\\title{confirmationInscription}
\author{Asa }
\date{June 2017}


\\begin{document}
\\thispagestyle{empty}
\section*{\sc Fiche d'inscription\\newline La Rentr\'{e}e dans l'Errant}


\\begin{flushright}
\includegraphics{".LINK."assets/pdf/img/logo.jpg}
\\end{flushright}

\\vspace{28pt}
\\noindent Remplir les champs suivant pour vous inscrire:

\\vspace{14pt}
Nom :

Pr\'{e}nom : 

Email :

T\'{e}l\'{e}phone :

Club :

Parcours :

\\vspace{20pt}
\\textbf{Tarif}

VTT : 5 Euros

Marche : 3 Euros

\\vspace{14pt}
J'ai pris connaissance du r\'{e}glement et je d\'{e}sengage le club VTT Errants de toutes responsabilit\'{e}es en cas de manquement \`{a} ce dernier.\\newline

Signature


\\vspace{14pt}
\\rule{\linewidth}{.5pt}
\\textbf{Coupon \`{a} remettre au participant}

\\vspace{14pt}
Nom :

Pr\'{e}nom :

Club :

Email :

T\'{e}l\'{e}phone :

Parcours :

J'ai pris connaissance du r\'{e}glement et je d\'{e}sengage le club VTT Errants de toutes responsabilit\'{e}es en cas de manquement \`{a} ce dernier.\\newline

Signature

\\begin{flushright}

\\begin{tabular}{|c|p{1cm}|c|p{1cm}|}
\\hline
Boisson & & Sandwich &  \\\\
\\hline
\\end{tabular}

\\end{flushright}

\\newpage

\\input{".LINK."void/libraries/latex/reglement.tex}

\\end{document}
";

    public function writeFile()
    {
        $fileName = "empty_register";
        $file = fopen(LINK."assets/pdf/".$fileName.".tex",'w');

        fwrite($file, self::$sourceCode);
        fclose($file);

        // compilation fichier
        $tmp = array();
        exec("pdflatex ".LINK."assets/pdf/".$fileName.".tex", $tmp);
        //print_r($tmp);
        exec("mv ".LINK.'/'.$fileName.".pdf ".LINK."assets/pdf/".$fileName.".pdf");
        exec("rm -R ".$fileName.".* ".LINK."assets/pdf/".$fileName.".tex");

        return $fileName;
    }
}

?>