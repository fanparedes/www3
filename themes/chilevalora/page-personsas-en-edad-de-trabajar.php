<?php
	get_header(); 
?>
<!-- Inicio Slider -->

<?php
	$args          = array(
		'post_type'     => 'slide_persona',
		'post_status'   => 'publish',
		'showposts'     => 1,
		'order'         => 'DESC'
	);
	$i             = 1;
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
				    position: relative;
				    width: 100%;
				    height: 668px;
				    background: url(<?php echo $imagen_lg; ?>) no-repeat center top #304c70;
				    background-size: cover;
				    color: #304c70;
				    margin: 0 auto 44px;
				    max-width: 1480px;
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
	            <div class="content">
			        <h1><?php echo $title; ?></h1>
			        <?php echo $description; ?>
			    </div>
			</div>
			<?php
			$i ++;
		endwhile;
	wp_reset_postdata();
	endif;
?>

	<div class="container">
		<!-- BANNERS -->
	    <div class="bloque-banners">
	        <div class="container">
	            <div class="row align-items-center">
	                <div class="col-12 col-md-4 text-center">
	                    <a href="<?php echo get_site_url().'/ocupaciones';?>" class="banner banner04 align-items-center">
	                        <div class="text">
	                            <p><small>Consulta los datos por</small> Ocupaciones</p>
	                            <span><i class="far fa-chevron-right"></i></span>
	                        </div>
	                    </a>
	                </div>
	                <div class="col-12 col-md-4 text-center">
	                    <a href="<?php echo get_site_url().'/regiones';?>" class="banner banner02 align-items-center">
	                        <div class="text">
	                            <p><small>Consulta los datos por</small> Regiones</p>
	                            <span><i class="far fa-chevron-right"></i></span>
	                        </div>
	                    </a>
	                </div>
	                <div class="col-12 col-md-4 text-center align-items-center">
	                    <a href="#" class="banner banner03">
	                        <div class="text">
	                            <p>¿Cómo funciona?</p>
	                            <span><i class="far fa-chevron-right"></i></span>
	                        </div>
	                    </a>
	                </div>
	            </div>
	        </div>
	    </div>
		<!-- FIN BANNERS -->
		<hr>
        <div class="row">
            <!-- BLOQUE ICONO -->
            <div class="col-12 col-md-6">
                <div class="bloque-icono green">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="icono">
                                <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>    
                                <i class="iconcl-crecimiento-xl"></i>
                            </div>
                            <div class="text">
                                <span class="title">Energías renovables de demanda</span>
                                <p>Sector con mayor tasa crecimiento en número de ocupados a nivel nacional en el último periodo</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- FIN BLOQUE ICONO -->
            <!-- BLOQUE ICONO -->
            <?php
            	//Sector con mayor incorporación de nuevos trabajadores
            	echo do_shortcode( '[sector_crecimiento_ingreso_trabajadores_home]' ); 
            ?>
            <!-- FIN BLOQUE ICONO -->
            <!-- BLOQUE PODIO -->
            <div class="bloque-podio">
                <div class="intro">
                    <div class="icono"><i class="iconcl-podium-xl"></i></div>
                    <h2>Ocupaciones más demandadas</h2>
                    <p>Ocupaciones mas demandadas en las bolsas de empleo a nivel nacional en el último periodo <a href="#popover" data-container="body" data-toggle="popover" data-placement="top" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus."><i class="fas fa-question-circle"></i></a></p>
                </div>
                <!-- CARRUSEL PODIO -->
                <div class="owl-carousel owl-theme">
                    <div class="col-12 col-md-6 item">
                        <div class="bloque-indicador">
                            <div class="grafica-circulo">
                                <span class="indicador-icon"><i class="iconcl-puesto1"></i></span>
                                <a href="sector-detalle-resumen.html" class="icon-plus"><i class="fal fa-plus"></i></a>
                                <a href="sector-detalle-resumen.html">
                                    <svg class="radial-progress" data-percentage="75" viewBox="0 0 80 80">
                                    <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                    <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                    <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">75%</text>
                                    </svg>
                                </a>
                            </div>
                            <div class="text">
                                <a href="sector-detalle-resumen.html" class="title">Especialista en ciberseguridad</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 item">
                        <div class="bloque-indicador">
                            <div class="grafica-circulo">
                                <span class="indicador-icon"><i class="iconcl-puesto2"></i></span>
                                <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                                <a href="#">
                                    <svg class="radial-progress" data-percentage="43" viewBox="0 0 80 80">
                                    <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                    <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                    <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">43%</text>
                                    </svg>
                                </a>
                            </div>
                            <div class="text">
                                <a href="#" class="title">Ingeniero técnico</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 item">
                        <div class="bloque-indicador">
                            <div class="grafica-circulo">
                                <span class="indicador-icon"><i class="iconcl-puesto3"></i></span>
                                <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                                <a href="#">
                                    <svg class="radial-progress" data-percentage="38" viewBox="0 0 80 80">
                                    <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                    <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                    <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">38%</text>
                                    </svg>
                                </a>
                            </div>
                            <div class="text">
                                <a href="#" class="title">Experto en Marketing Digital</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FIN CARRUSEL PODIO -->
                <div class="row owl-desktop">
                    <div class="col-4 owl-desktop">
                        <div class="bloque-indicador">
                            <div class="grafica-circulo">
                                <span class="indicador-icon"><i class="iconcl-puesto1"></i></span>
                                <a href="sector-detalle-resumen.html" class="icon-plus"><i class="fal fa-plus"></i></a>
                                <a href="sector-detalle-resumen.html">
                                    <svg class="radial-progress" data-percentage="75" viewBox="0 0 80 80">
                                    <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                    <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                    <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">75%</text>
                                    </svg>
                                </a>
                            </div>
                            <div class="text">
                                <a href="sector-detalle-resumen.html" class="title">Especialista en ciberseguridad</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 owl-desktop">
                        <div class="bloque-indicador">
                            <div class="grafica-circulo">
                                <span class="indicador-icon"><i class="iconcl-puesto2"></i></span>
                                <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                                <a href="#">
                                    <svg class="radial-progress" data-percentage="43" viewBox="0 0 80 80">
                                    <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                    <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                    <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">43%</text>
                                    </svg>
                                </a>
                            </div>
                            <div class="text">
                                <a href="#" class="title">Ingeniero técnico</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 owl-desktop">
                        <div class="bloque-indicador">
                            <div class="grafica-circulo">
                                <span class="indicador-icon"><i class="iconcl-puesto3"></i></span>
                                <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                                <a href="#">
                                    <svg class="radial-progress" data-percentage="38" viewBox="0 0 80 80">
                                    <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                    <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                    <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">38%</text>
                                    </svg>
                                </a>
                            </div>
                            <div class="text">
                                <a href="#" class="title">Experto en Marketing Digital</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bloque-boton">
                    <a href="<?php echo get_site_url().'/ocupaciones'; ?>" class="btn btn-yellow">Ver más ocupaciones</a>
                </div>
            </div>
            <!-- FIN BLOQUE PODIO -->
            <!-- BANNER-->
            <div class="col-12">
                <div class="banner-col-12 banner-transformacion">
                    <div class="content">
                        <strong>Súmate a la transformación</strong>
                        <p>Prepárate para las ocupaciones digitales encontrando la formación que necesitas para las conocimiento más demandadas del sector.</p>
                        <a href="<?php echo get_site_url().'/cursos'; ?>" class="btn btn-yellow">Buscar cursos</a> 
                    </div>    
                </div>
            </div>
            <!-- FIN BANNER -->
            <!-- BLOQUE PODIO -->
            <div class="bloque-podio como-funciona-destino-empleo">
                <div class="intro">
                    <h2>¿Cómo funciona Destino Empleo?</h2>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-4">
                        <i class="iconcl-almacena"></i>
                        <span>Almacena</span>
                        <p>Destino Empleo recoge toda la información existente procedente de diversas fuentes nacionales sobre el mercado laboral chileno. </p>
                    </div>
                    <div class="col-12 col-sm-4">
                        <i class="iconcl-procesa"></i>
                        <span>Procesa</span>
                        <p>Posteriormente, ordena y clasifica toda la información almacenada en diversos parámetros según criterios lógicos de utilidad.</p>
                    </div>
                    <div class="col-12 col-sm-4">
                        <i class="iconcl-informa"></i>
                        <span>Informa y orienta</span>
                        <p>Por último, Destino Empleo ofrece a los ciudadanos datos útiles sobre el mercado, orientación profesional y vías de capacitación digital.</p>
                    </div>
                </div>
                <div class="bloque-boton">
                    <a href="<?php echo get_site_url().'/ocupaciones'; ?>" class="btn btn-yellow">Saber más</a>
                </div>
            </div>
            <!-- FIN BLOQUE PODIO -->
            <!-- BANNER-->
            <div class="col-12">
                <div class="banner-col-12 banner-destino-empleo">
                    <div class="content">
                        <strong>Destino Empleo, sin duda</strong>
                        <p>Te ayudamos a sacar el máximo partido de tu consulta laboral en nuestra sección de preguntas frecuentes y glosario de términos relacionados.</p>
                        <a href="<?php echo get_site_url().'/ayuda'; ?>" class="btn btn-yellow">Consultar ayuda</a> 
                    </div>    
                </div>
            </div>
            <!-- FIN BANNER -->
        </div>
	</div>

<?php
	get_footer();
?>