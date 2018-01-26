<?php

class CREGIST
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
\section*{\sc Confirmation d'inscription\\newline La Rentr\'{e}e dans l'Errant}


\\begin{flushright}
\includegraphics{".LINK."assets/pdf/img/logo.jpg}
\\end{flushright}

\\vspace{28pt}
Vous venez de vous inscrire pour participer \`{a} {\sc \"La Rentr\'{e}e dans l'Errant\"}, organis\'{e}e par le club VTT Errants.\\newline
Votre choix de parcours est : @distance@\\newline
Vous pouvez voir la liste des participants \href{http://vtterrants-corbie.sytes.net/vtterrants/rando/list}{sur le site}.\\newline

\\vspace{14pt}
\\noindent Vous \^{e}tes inscrit avec l'identit\'{e} suivante :\\newline
Nom : @name@ \\newline
Pr\'{e}nom : @firstname@ \\newline
Email : @email@ \\newline
T\'{e}l\'{e}phone : @phonenumber@ \\newline
Club : @club@ \\newline
Parcours : @distance@ \\newline

\\vspace{14pt}
Le jour de la rando, vous devrez pr\'{e}senter ce document pour b\'{e}n\'{e}ficier du tarif en ligne (@tarif@).

J'ai pris connaissance du r\'{e}glement et je d\'{e}sengage le club VTT Errants de toutes responsabilit\'{e}es en cas de manquement \`{a} ce dernier.\\newline

Signature

\\vspace{14pt}
\\begin{flushright}
\\noindent Le club VTT Errants, le @date@
\\end{flushright}

\\vspace{14pt}

\\rule{\linewidth}{.5pt}
\\textbf{Coupon \`{a} remettre au participant}

\\noindent Nom : @name@, Pr\'{e}nom : @firstname@, Club : @club@ \\newline
Email : @email@, T\'{e}l\'{e}phone : @phonenumber@ \\newline
Parcours : @distance@ \\newline
\\textbf{Mobile en cas de probl\`{e}me :  06 18 67 50 51}

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

    private static $name;
    private static $firstname;

    public function setInfos($name, $firstname, $email, $phonenumber, $distance, $club)
    {
        self::$name = $name;
        self::$firstname = $firstname;
        $name = preg_replace("#é#", "\'{e}", $name);
        $name = preg_replace("#è#", "\`{e}", $name);
        $name = preg_replace("#à#", "\`{a}", $name);
        $name = preg_replace("#ç#", "\c{c}", $name);
        $name = preg_replace("#ê#", "\^{e}", $name);

        $firstname = preg_replace("#é#", "\'{e}", $firstname);
        $firstname = preg_replace("#è#", "\`{e}", $firstname);
        $firstname = preg_replace("#à#", "\`{a}", $firstname);
        $firstname = preg_replace("#ç#", "\c{c}", $firstname);
        $firstname = preg_replace("#ê#", "\^{e}", $firstname);

        $email = preg_replace("#é#", "\'{e}", $email);
        $email = preg_replace("#è#", "\`{e}", $email);
        $email = preg_replace("#à#", "\`{a}", $email);
        $email = preg_replace("#ç#", "\c{c}", $email);
        $email = preg_replace("#ê#", "\^{e}", $email);

        $club = preg_replace("#é#", "\'{e}", $club);
        $club = preg_replace("#è#", "\`{e}", $club);
        $club = preg_replace("#à#", "\`{a}", $club);
        $club = preg_replace("#ç#", "\c{c}", $club);
        $club = preg_replace("#ê#", "\^{e}", $club);

        self::$sourceCode = preg_replace("#@name@#", $name, self::$sourceCode);
        self::$sourceCode = preg_replace("#@firstname@#", $firstname, self::$sourceCode);
        self::$sourceCode = preg_replace("#@email@#", $email, self::$sourceCode);
        self::$sourceCode = preg_replace("#@phonenumber@#", $phonenumber, self::$sourceCode);
        self::$sourceCode = preg_replace("#@distance@#", $distance, self::$sourceCode);
        self::$sourceCode = preg_replace("#@club@#", $club, self::$sourceCode);
        self::$sourceCode = preg_replace("#@date@#", date("d/m/Y", time()), self::$sourceCode);
        if($distance == "marche"){
            self::$sourceCode = preg_replace("#@tarif@#", "2 Euros", self::$sourceCode);
        }else{
            self::$sourceCode = preg_replace("#@tarif@#", "4 Euros", self::$sourceCode);
        }
    }

    public function writeFile()
    {
        $fileName = time().'_'.strtoupper(self::$name).'_'.strtoupper(self::$firstname)."_register";
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