<?php
	// global $id_sector;
	// $rs_search 	= array('/', 'sector-detalle');
	// $rs_replace = array('', '');
	// $id_sector 	= str_replace($rs_search, $rs_replace, $_SERVER['REQUEST_URI']);
	// $id_sector	= explode('?', $id_sector);
	// $id_sector	= is_numeric($id_sector[0]) ? $id_sector[0] : '1';

	// //var_dump($id_sector); die;
	// $title_sector 	= '';
	// $content_sector = '';

	$code_sector	= isset($_GET['code_sector']) && $_GET['code_sector']!='' ? $_GET['code_sector'] : '';

	global $id_sector;
	$title_sector 	= '';
	$content_sector = '';
	
	$get_the_ID =  get_the_ID();


	if(is_numeric($get_the_ID)){
		
		$args_sector        = array(
			'post_type'     => 'detalle_sector',
			'post_status'   => 'publish',
			'showposts'     => 1,
			'order'         => 'ASC',
			'post__in'		=> array($get_the_ID)
		);
		
		$wp_sector = new WP_Query( $args_sector );

		if ( $wp_sector->have_posts() ) :
	    	while ( $wp_sector->have_posts() ) : $wp_sector->the_post();
	    		$title_sector 	= get_the_title();
	    		$content_sector = get_the_content();
	    		$id_sector 		= get_field('id');

	    	endwhile;
			wp_reset_postdata();
		endif;

	    	get_header(); 

    	?>
    			<div class="bloque-titular">
			        <div class="container">
			            <h1 class="col-9"><?php echo ucwords(strtolower($title_sector)); ?></h1>
			            <div class="filtros-titular col-3">
			                <a href="#" class="openFiltroRegion">Elige una región <i class="fal fa-filter"></i></a>
			            </div>
			        </div>
			    </div>
    			<!-- BLOQUE TABS -->
			    <div class="bloque-tabs">
			        <div class="container">
			            <div class="d-none d-sm-block">
			                <ul class="nav nav-tabs">
			                    <li class="nav-item">
			                        <a class="nav-link active" href="<?php echo get_site_url().'/sector-detalle/'.$id_sector.'?code_sector='.$code_sector; ?>">Resumen</a>
			                    </li>
			                    <li class="nav-item">
			                        <a class="nav-link" href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'?code_sector='.$code_sector; ?>">Más información</a>
			                    </li>
<!-- 			                    <li class="nav-item">
			                        <a class="nav-link" href="#">Ocupaciones</a>
			                    </li> -->
			                </ul>
			            </div>
			            <div class="dropdown d-block d-sm-none">
			                <a class="btn dropdown-toggle" href="#dropdown-toggle" role="button" id="dropdownMenuTabs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			                    Resumen
			                </a>
			                <div class="dropdown-menu" aria-labelledby="dropdownMenuTabs">
			                    <a class="dropdown-item" href="#">Más información</a>
			                    <a class="dropdown-item" href="#">Ocupaciones</a>                    
			                </div>
			            </div>
			        </div>
			    </div>
			    <!-- FIN BLOQUE TABS -->
			    
			    <div class="container">
	        		<div class="row">
	        			<!-- BLOQUE TEXTO -->
			            <div class="col-12">
			                <div class="bloque-texto row">
			                    <div class="col-12 col-lg-2">
			                        <h2><?php echo $title_sector; ?></h2>
			                    </div>
			                    <div class="col-12 col-lg-10">
			                        <?php echo $content_sector; ?>
			                    </div>
			                </div>
			            </div>
			            <!-- FIN BLOQUE TEXTO -->
			            <!-- BLOQUE ICONO -->
			            <div class="col-12">
			                <div class="bloque-icono">
			                    <div class="row">
			                        <div class="col-sm-12 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
			                            <div class="icono">
			                                <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
			                                <i class="iconcl-puesto1-xl"></i>
			                            </div>
			                            <div class="text">
			                                <span class="title">Nº de ocupados</span>
			                                <p>El sector con mayor crecimiento en el nº de ocupados a nivel nacional en el último periodo</p>
			                            </div>
			                        </div>
			                    </div>
			                </div>
			            </div>
			            <!-- FIN BLOQUE ICONO -->
			            <!-- BLOQUE GRUPO INDICADORES -->
			            <!-- BLOQUE GRUPO INDICADORES CARRUSEL -->
			            <div class="owl-carousel owl-theme">
			            	<?php
				            	//Detalle Sector grupo de indicadores	
				            	echo do_shortcode( '[sector_crecimiento_detalle_carrousel]' ); 
				            ?>
			            </div>
			            <?php
			            	//Detalle Sector grupo de indicadores	
			            	echo do_shortcode( '[sector_crecimiento_detalle_desktop]' ); 
			            ?>


		            </div>
	            </div>

				
			<?php
			get_footer();


	}else{
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: ".home_url( '/404/' ));
		exit();
	}
?>