<?php
/**
 * Header Chile Valora
 *
 * @package chilevalora
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>

	<meta charset="utf-8" />
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1' /><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <title><?php echo get_the_title( ); ?> - Chile Valora</title>

    <meta name="theme-color" content="#ffffff">

	<?php wp_head(); ?>

	<!--[if lt IE 9]>
      <script src="js/html5.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->

    <script src="//cdn.loop11.com/embed.js" type="text/javascript" async="async"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-157726359-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-157726359-1');
    </script>

    <!-- Hotjar Tracking Code for http://chilevalora.ingeniaglobal.cl/ -->
    <script>
        (function(h,o,t,j,a,r){
            h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
            h._hjSettings={hjid:1672294,hjsv:6};
            a=o.getElementsByTagName('head')[0];
            r=o.createElement('script');r.async=1;
            r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
            a.appendChild(r);
        })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
    </script>
</head>


<body class="home">

    <header>

        <div class="container">
            
            <?php if ( function_exists( 'the_custom_logo' ) ):

                $custom_logo_id = get_theme_mod( 'custom_logo' );
                $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
                ?>
                <a href="<?php echo get_site_url(); ?>" class="logo">
                    <img src="<?php echo $image[0]; ?>" class="img-fluid">
                </a>

            <?php endif; ?>

    
   			<button class="navbar-toggler openMenu" type="button" data-toggle="collapse" aria-label="Toggle navigation">
                <i class="fal fa-bars"></i>
            </button>
            <!-- #site-navigation -->
            <nav class="navbar navbar-expand-lg navbar-mainmenu">
				<div class="collapse navbar-collapse cbp-spmenu" id="navbarNavDropdown">
					<div class="closeMenu"><i class="iconcl-aspa"></i>
                    </div>
                   <!-- <div class="dropdown dropdown-perfil">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Elige un perfil <i class="fas fa-chevron-circle-down"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="<?php echo get_site_url().'/estudiante'; ?>">Estudiantes</a>
                            <a class="dropdown-item" href="<?php echo get_site_url().'/personsas-en-edad-de-trabajar'; ?>">Personsas en edad de trabajar</a>
                            <a class="dropdown-item" href="<?php echo get_site_url().'/empresas'; ?>">Empresas</a>
                        </div>
                    </div>-->
					<?php
	                  wp_nav_menu( array(
	                      'theme_location' => 'principal',
	                      'menu_id' => '',
	                      'depth' => 2,
	                      'container' => false,
	                      'menu_class' => 'navbar-nav',
	                      'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
	                      'walker' => new WP_Bootstrap_Navwalker(),
	                  ) );
	                  ?>
                      <!--  <div class="dropdown dropdown-idioma">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">ES <i class="fas fa-chevron-circle-down"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">EN</a>
                            </div>
                        </div>-->
                        <?php dynamic_sidebar( 'header-sidebar' ); ?>  
                </div>
			</nav>
			<!-- #site-navigation -->
        </div>
    </header>
    <?php
        //Se valida si la página no es la home para mostrar el breadcrumb 
        $hide_breadcrumb = get_field( 'show_breadcrumb', get_the_ID() );
    
        if( !is_front_page() && !$hide_breadcrumb):   ?>
           
            <div class="bloque-breadcrumb">
                <div class="container">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <?php echo get_breadcrumb(); ?>
                            </li>
                        </ol>
                    </nav><!-- .site-branding -->
                </div>
            </div>
           
        <?php endif; ?>

