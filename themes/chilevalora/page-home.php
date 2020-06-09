<?php
	get_header(); 
?>
<!-- Inicio Slider -->

<?php
	$args          = array(
		'post_type'     => 'slide_home',
		'post_status'   => 'publish',
		'showposts'     => 1,
		'order'         => 'DESC'
	);
	
	$products_loop = new WP_Query( $args );
	if ( $products_loop->have_posts() ) :
		while ( $products_loop->have_posts() ) : $products_loop->the_post();
			// Set variables
			$id 		 = get_the_ID();
			$title       = get_the_title();
			$description = get_the_content();
			$image       = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
			$imagen_lg 	 = get_field('imagen_lg');
			$imagen_xs 	 = get_field('imagen_xs'); 
			
			?>
			<style type="text/css">
                .bloque-carousel-home {
                   
                   /* position: relative;
                    width: 100%;
                    height: 668px;
                    background: url(<?php echo $imagen_lg; ?>) no-repeat center top #304c70;
                    background-size: cover;
                    color: #304c70;
                    margin: 0 auto 44px;
                    max-width: 1480px;
                    
                    position: relative;
                    background: url(<?php echo $imagen_lg; ?>) no-repeat center top #304c70;
                    color: #304c70;
                    margin: 0 auto 44px;
                        */
                    position: relative;
                    width: 100%;
                    /*height: 668px;*/
                    background: url(<?php echo $imagen_lg; ?>) no-repeat center top #304c70;
                    background-size: cover;
                    color: #304c70;
                    margin: 0 auto 44px;

                }

                @media (max-width: 767px) {
                  .bloque-carousel-home {
                        height: 611px;
                        background-image: url(<?php echo $imagen_xs; ?>);
                        padding: 40px 0;
                        margin-bottom: 44px;
                    }
                }
            </style>
            <div class="bloque-carousel-home">
                <div class="container">
    	            <div class="content">
    			        <h1><?php echo $title; ?></h1>
    			        <form action="#">
		                    <div class="input-group" id="search-type">
		                        <label>Buscar en:</label> 
		                        <div class="form-check">
		                            <label class="container">Sectores productivos
		                                <input type="radio" name="radio" value="1" checked>
		                                <span class="checkmark"></span>
		                            </label>
		                        </div>
		                        <div class="form-check">
		                            <label class="container">Ocupaciones
		                                <input type="radio" name="radio" value="2">
		                                <span class="checkmark"></span>
		                            </label>
		                        </div>
		                    </div>
		                    <div class="input-group">
		                        <input class="form-control border-right-0 border" type="search" value="" id="home-search-input" id="home-search-sub" placeholder="Escribe aquí lo que estás buscando...">
		                        <span class="input-group-append">
		                            <button class="btn btn-outline-secondary border-left-0 border" type="submit">
		                                <i class="far fa-search fa-flip-horizontal"></i>
		                            </button>
		                          </span>
		                    </div>
		                    <div id="home-search-results" id="home-search-sub" class="results">
	                        	
	                        </div>
		                </form>
    			    </div>
                </div><!-- /container -->
			</div><!-- bloque-carousel-home -->
			<?php
		endwhile;
	wp_reset_postdata();
	endif;
?>

	<div class="container">
		<div class="banners-home-buscar">
	        <div class="row">
	            <div class="col-sm-12" >
	            	<div id="otroId" class="openChat" >
	                <p class="entrada text-center">
	                
	                    <img src="<?php bloginfo('template_directory');?>/images/orientador-shade.png" class="img-fluid"> Deja que nuestro <span>orientador profesional</span> te guie.
	                    
	                </p>
	                </div>
	            </div>
	        </div>
            <?php 
                $post_id_regiones = 12;
                $content_post = get_post($post_id_regiones);
                $content_r = $content_post->post_content;
                $content_r = apply_filters('the_content', $content_r);
                $content_r = str_replace(']]>', ']]&gt;', $content_r);
            ?>
	        <div class="row">
                <div class="col-sm-12">
                    <a href="<?php echo get_site_url().'/sectores-productivos';?>" class="banner-item" title="Busca por Sectores productivos">
                        <img src="<?php bloginfo('template_directory'); ?>/images/imagen-banner-home-buscar-sectores.jpg" class="img-fluid" alt="Sectores productivos">
                        <div class="banner-datos">
                            <span>Busca por</span>
                            <h4>Sectores productivos</h4>
                            <div class="resumen"><?php echo $content_r; ?></div>
                            <div class="rounded-icon"><i class="far fa-chevron-right"></i></div>
                        </div>
                    </a>
                </div>
            </div>
            <?php     
                $post_id_ocupaciones = 14;
                $content_post = get_post($post_id_ocupaciones);
                $content_oc = $content_post->post_content;
                $content_oc = apply_filters('the_content', $content_oc);
                $content_oc = str_replace(']]>', ']]&gt;', $content_oc);
            ?>
            <div class="row">
                <div class="col-sm-12">
                    <a href="<?php echo get_site_url().'/ocupaciones';?>" class="banner-item" title="Busca por Ocupaciones">
                        <img src="<?php bloginfo('template_directory'); ?>/images/imagen-banner-home-buscar-ocupaciones.jpg" class="img-fluid" alt="Ocupaciones">
                        <div class="banner-datos">
                            <span>Busca por</span>
                            <h4>Ocupaciones</h4>
                            <div class="resumen"><?php echo $content_oc; ?></div>
                            <div class="rounded-icon"><i class="far fa-chevron-right"></i></div>
                        </div>
                    </a>
                </div>
            </div>
            <?php
                $post_id_regiones = 16;
                $content_post = get_post($post_id_regiones);
                $content_r = $content_post->post_content;
                $content_r = apply_filters('the_content', $content_r);
                $content_r = str_replace(']]>', ']]&gt;', $content_r);
            ?>
            <div class="row">
                <div class="col-sm-12">
                    <a href="<?php echo get_site_url().'/regiones';?>" class="banner-item" title="Busca por Regiones">
                        <img src="<?php bloginfo('template_directory'); ?>/images/imagen-banner-home-buscar-regiones.jpg" class="img-fluid" alt="Regiones">
                        <div class="banner-datos">
                            <span>Busca por</span>
                            <h4>Regiones</h4>
                            <div class="resumen"><?php echo $content_r; ?></div>
                            <div class="rounded-icon"><i class="far fa-chevron-right"></i></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

	
	<?php get_template_part('buscador-ocupaciones'); ?>

    <!-- DESTINO EMPLEO -->
    <div class="container">
        <div class="row">
            <!-- BLOQUE PODIO -->
            <div class="bloque-podio como-funciona-destino-empleo">
                <div class="intro">
                    <h2 class="titular-grande">DestinoEmpleo, ¿cómo funciona?</h2>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-4">
                        <i class="iconcl-almacena"></i>
                        <span><strong>1. Almacena</strong></span>
                        <p>Destino Empleo recoge toda la información existente procedente de diversas fuentes nacionales sobre el mercado laboral chileno. </p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4">
                        <i class="iconcl-procesa"></i>
                        <span><strong>2. Procesa</strong></span>
                        <p>Posteriormente, ordena y clasifica toda la información almacenada en diversos parámetros según criterios lógicos de utilidad.</p>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4">
                        <i class="iconcl-informa"></i>
                        <span><strong>3. Informa y orienta</strong></span>
                        <p>Por último, Destino Empleo ofrece a los ciudadanos datos útiles sobre el mercado, orientación profesional y vías de capacitación digital.</p>
                    </div>
                </div>
                <div class="bloque-boton">
                    <a href="<?php echo get_site_url().'/como-funciona/'; ?>" class="btn btn-yellow">Saber más</a>
                </div>
            </div>
            <!-- FIN BLOQUE PODIO -->
        </div>
        <?php   $post_id_ayuda = 18;
                $content_post = get_post($post_id_ayuda);
                $content_ayuda = $content_post->post_content;
                $title_ayuda = $content_post->post_title;
                $content_ayuda = apply_filters('the_content', $content_ayuda);
                $content_ayuda = str_replace(']]>', ']]&gt;', $content_ayuda);

                
                 ?>
        <div class="row">
            <!-- BANNER-->
            <div class="col-12">
                <div class="banner-col-12 banner-destino-empleo">
                    <div class="content">
                        <a href="<?php echo get_site_url().'/como-funciona/'?>" title="Destino Empleo, sin duda">
                            <span><?php echo $title_ayuda; ?></span>
                            <?php echo $content_ayuda; ?>
                            <div class="rounded-icon"><i class="far fa-chevron-right"></i></div>
                        </a> 
                    </div>    
                </div>
            </div>
            <!-- FIN BANNER -->
        </div>
    </div>
    <!-- FIN DESTINO EMPLEO -->


       
       


<?php
	get_footer();
?>