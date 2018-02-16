<header id="top-bar" class="navbar-fixed-top animated-header">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <div class="col-md-3 col-xs-12">
                <!-- Vtt logo -->
                <img class="img-responsive logo" src="<?= IMG.'king.png'; ?>"/>
            </div>

            <div class="col-md-6 col-xs-12">

            </div>

            <div class="col-md-3 hidden-sm hidden-xs">

            </div>
        </div>
        <nav class="collapse navbar-collapse navbar-right" role="navigation">
            <div class="main-menu">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?= site_url(); ?>" >Home</a></li>
                    <li><a href="<?= site_url('welcome/profil'); ?>">Profil</a></li>
                    <li><a href="<?= site_url('welcome/skills'); ?>">Compétences</a></li>
                    <li><a href="<?= site_url('projects/index'); ?>">Mes Projets</a></li>
                    <li><a href="<?= site_url('welcome/contact'); ?>">Contact</a></li>
                </ul>
            </div>
        </nav>
    </div>
</header>
