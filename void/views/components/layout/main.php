<html>

    <!-- HEAD -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Intelligent trash sorting system">
        <meta name="author" content="Tingyun DU">
        <title>BingBin | Sort better, live better</title>

        <!-- Bootstrap core CSS -->
        <link href="<?php URL ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom fonts for this template -->
        <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Futura:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

        <!-- Plugin CSS -->
        <link href="assets/vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="assets/css/creative.min.css" rel="stylesheet">
        <link href="assets/css/creative.css" rel="stylesheet">
        <?php
            foreach($css as $v)
            {
                echo "<link href=\"".URL.'assets/'.$v."\" rel=\"stylesheet\">\n";
            }
        ?>

    </head>

    <!-- BODY -->
    <body id="page-top">
        <!-- HEADER -->
<?= $header; ?>
        <!-- MAIN -->
        <main>

        <?php
            foreach($output as $v)
            {
echo $v;
            }
        ?>
        </main>
    </body>

    <!-- FOOTER -->
    <footer id="footer" class="midnight-blue footer">
        <div class="container">
            <div class="row">
            <div class="col-sm-6">

            </div>

            </div>
        </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
        <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Plugin JavaScript -->
        <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="assets/vendor/scrollreveal/scrollreveal.min.js"></script>
        <script src="assets/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

        <!-- Custom scripts for this template -->
        <script src="assets/js/creative.min.js"></script>
        <script src="assets/js/ajax.request/register.js"></script>

        <script src="assets/swal/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" type="text/css" href="assets/swal/dist/sweetalert2.css">

        <script>
$(this).ready(function(){

    $("#requestInvite").click(function(){
        object = $(this);
        name = $('#field_name').val();
        mail = $('#field_mail').val();
        $.ajax({
            url : '<?= site_url(); ?>/Welcome/register',
            type : 'post',
            dataType : 'text',
            data : {
                name : name,
                mail : mail
            },
            success : function(json, statut){
                //try {
                    console.log(json);
                    json = JSON.parse(json);
                    if(json.valid == true){
                        swal(
                            'Good',
                            'Thanks for your support, you will soon be granted acces to the app',
                            'success'
                        );
                    }else{
                        swal(
                            'Oups...',
                            json.errors,
                            'warning'
                        );
                    }
                //} catch (e) {
                    /*swal(
                        'Oups...',
                        'Impossible de lire la réponse du serveur',
                        'error'
                    );*/
                //}
            },
            error : function(resultat, statut, erreur){
                swal(
                    'Oups...',
                    erreur,
                    'error'
                );
            }

        });
    });
});
</script>

        <?php
            foreach($js as $v)
            {
                echo "<script src=\"".URL.'assets/'.$v."\"></script>\n";
            }
        ?>
</html>