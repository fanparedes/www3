<?php
	/*global $id_occupation;
	$rs_search 	= array('/', 'ocupacion-detalle');
	$rs_replace = array('', '');
	//var_dump($id_occupation); die;
	$id_occupation 	= str_replace($rs_search, $rs_replace, $_SERVER['REQUEST_URI']);
	$id_occupation	= explode('?', $id_occupation);
	$id_occupation	= is_numeric($id_occupation[0]) ? $id_occupation[0] : '1';*/

	//var_dump($id_occupation); die;

	global $id_occupation;
	$title_ocupacion 	= '';
	$content_ocupacion = '';
	$code_job_position = isset($_GET['code_job_position']) && $_GET['code_job_position']!='' ? $_GET['code_job_position'] : '';
	
	$get_the_ID =  get_the_ID();

	//var_dump($get_the_ID); die;

	$args_ocupacion        = array(
		'post_type'     => 'detalle_ocupacion',
		'post_status'   => 'publish',
		'showposts'     => 1,
		'order'         => 'ASC',
		'post__in'		=> array($get_the_ID)
	);
	
	$wp_ocupacion = new WP_Query( $args_ocupacion );

	if ( $wp_ocupacion->have_posts() ) :
    	while ( $wp_ocupacion->have_posts() ) : $wp_ocupacion->the_post();
    		$title_ocupacion 	= get_the_title();
    		$content_ocupacion = get_the_content();
    		$id_occupation = get_field('id');

    	endwhile;
		wp_reset_postdata();
	endif;

	if(is_numeric($id_occupation)){

		$sql_ocupacion = "select id_occupation, name_occupation from cl_occupations where id_occupation = ".$id_occupation;

        $rs_ocupacion  = $wpdb->get_results($sql_ocupacion);
       	
       
        
        $sql_job 		= "SELECT digital  FROM cl_job_positions  WHERE code_job_position = '".$code_job_position."'";
        $rs_job	 		= $wpdb->get_results($sql_job);
        $job_position 	= array_shift($rs_job);
        
        //var_dump($job_position);
        //var_dump($rs_ocupacion); die;
        
        if(is_array($rs_ocupacion) && count($rs_ocupacion)>0){
        
	    	get_header(); 

    	?>
    			<div class="bloque-titular">
			        <div class="container">
			            <h1><?php echo $title_ocupacion; ?></h1>
			        </div>
			    </div>
    			<!-- BLOQUE TABS -->
			    <div class="bloque-tabs">
			        <div class="container">
			            <div class="d-none d-sm-block">
			                <ul class="nav nav-tabs">
			                    <li class="nav-item">
			                        <a class="nav-link active" href="<?php echo get_site_url().'/ocupacion-detalle/'.$id_occupation.'?code_job_position='.$code_job_position; ?>">Resumen</a>
			                    </li>
			                    <li class="nav-item">
			                        <a class="nav-link" href="<?php echo get_site_url().'/ocupacion-mas-info/'.$id_occupation.'?code_job_position='.$code_job_position; ?>">Más información</a>
			                    </li>

			                   	<?php if( $job_position->digital == 't' ): ?>
								<li class="nav-item">
			                        <a class="nav-link" href="<?php echo get_site_url().'/ocupacion-habilidades/'.$id_occupation.'?code_job_position='.$code_job_position; ?>">Habilidades</a>
			                    </li>
			                	<?php endif; ?>
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
	                        <h2><?php echo $title_ocupacion; ?></h2>
	                    </div>
	                    <div class="col-12 col-lg-10">
	                        <?php echo $content_ocupacion; ?>
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
			                                <span class="title">Demanda</span>
			                                <p>Es la ocupación digital más demandada en la Región Metropolitana</p>
			                            </div>
			                        </div>
			                    </div>
			                </div>
			            </div>
			            <!-- FIN BLOQUE ICONO -->
			            <!-- BLOQUE INDICADOR -->
			            <div class="col-12 col-md-6">
			                <div class="bloque-indicador">
			                        <div class="grafica-circulo">
			                            <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
			                            <a href="#">
			                                <svg class="radial-progress" data-percentage="30" viewBox="0 0 80 80">
			                                <circle class="incomplete" cx="40" cy="40" r="35"></circle>
			                                <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
			                                <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">30%</text>
			                                </svg>
			                            </a>
			                        </div>
			                        <div class="text">
			                            <a href="#" class="title">Demanda</a>
			                            <p>Porcentaje de las ofertas de empleo que citan esta ocupación en las bolsas de empleo</p>
			                        </div>
			                </div>
			            </div>
			            <!-- FIN BLOQUE INDICADOR -->
			            <!-- BLOQUE ICONO -->
			            <div class="col-12 col-md-6">
			                <div class="bloque-icono">
			                    <div class="row" style="height: 207px !important;">
			                        <div class="col-md-12">
			                            <div class="icono">
			                                <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>    
			                                <i class="iconcl-crecimiento-xl"></i>
			                            </div>
			                            <div class="text">
			                                <span class="title">Crecimiento de demanda</span>
			                                <p>Esta ocupación lleva ascendiendo en su demanda en los últimos 12 meses</p>
			                            </div>
			                        </div>
			                    </div>
			                </div>
			            </div>
			            <!-- FIN BLOQUE ICONO -->
			            <!-- BLOQUE TITULAR -->
			            <div class="col-12">
			                <div class="bloque-titular">
			                    <h2>Datos comunes para <?php echo $title_ocupacion; ?></h2>
			                </div>
			            </div>
			            <!-- FIN BLOQUE TITULAR -->
			            <!-- BLOQUE GRUPO INDICADORES -->
			            <!-- BLOQUE GRUPO INDICADORES CARRUSEL -->
			            <div class="owl-carousel owl-theme">
			                <div class="item">
			                    <div class="bloque-indicador">
			                        <div class="grafica-circulo">
			                            <span class="indicador-icon"><i class="iconcl-mujeres"></i></span>
			                            <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
			                            <a href="#">
			                                <svg class="radial-progress" data-percentage="26" viewBox="0 0 80 80">
			                                <circle class="incomplete" cx="40" cy="40" r="35"></circle>
			                                <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
			                                <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">26%</text>
			                                </svg>
			                            </a>
			                        </div>
			                        <div class="text">
			                            <a href="#" class="title">Mujeres</a>
			                            <p>Porcentaje de mujeres emploeadas como desarrolladoras informáticas en el último periodo</p>
			                        </div>
			                    </div>
			                </div>
			                <div class="item">
			                    <div class="bloque-indicador-dato">
			                        <div class="grafica-circulo">
			                            <span class="indicador-icon"><i class="iconcl-ingresos"></i></span>
			                            <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
			                            <a href="#">
			                                <svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
			                                <circle class="complete" cx="40" cy="40" r="35"></circle>
			                                <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">$1,45M</text>
			                                </svg>
			                            </a>
			                        </div>
			                        <div class="text">
			                            <a href="#" class="title">Mediana salarial</a>
			                            <p>Mediana salarial de los desarrolladores informáticos a nivel nacional en el último periodo</p>
			                        </div>
			                    </div>
			                </div>
			                <div class="item">
			                    <div class="bloque-indicador">
			                        <div class="grafica-circulo green">
			                            <span class="indicador-icon"><i class="iconcl-contratos"></i></span>
			                            <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
			                            <a href="#">
			                                <svg class="radial-progress" data-percentage="77" viewBox="0 0 80 80">
			                                <circle class="incomplete" cx="40" cy="40" r="35"></circle>
			                                <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
			                                <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">77%</text>
			                                </svg>
			                            </a>
			                        </div>
			                        <div class="text">
			                            <a href="#" class="title">Contratos indefinidos</a>
			                            <p>Porcentaje de contratos indefinidos para desarrolladores informáticos a nivel nacional en el último periodo</p>
			                        </div>
			                    </div>
			                </div>
			            </div>
			            <!-- BLOQUE GRUPO INDICADORES DESKTOP -->
			            <div class="col-12 col-md-6 owl-desktop">
			                <div class="bloque-indicador">
			                    <div class="grafica-circulo">
			                            <span class="indicador-icon"><i class="iconcl-mujeres"></i></span>
			                            <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
			                            <a href="#">
			                                <svg class="radial-progress" data-percentage="26" viewBox="0 0 80 80">
			                                <circle class="incomplete" cx="40" cy="40" r="35"></circle>
			                                <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
			                                <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">26%</text>
			                                </svg>
			                            </a>
			                        </div>
			                        <div class="text">
			                            <a href="#" class="title">Mujeres</a>
			                            <p>Porcentaje de mujeres emploeadas como desarrolladoras informáticas en el último periodo</p>
			                        </div>
			                </div>
			            </div>
			            <div class="col-12 col-md-6 owl-desktop">
			                <div class="bloque-indicador-dato">
			                    <div class="grafica-circulo">
			                        <span class="indicador-icon"><i class="iconcl-ingresos"></i></span>
			                        <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
			                        <a href="#">
			                            <svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
			                            <circle class="complete" cx="40" cy="40" r="35"></circle>
			                            <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">$1,45M</text>
			                            </svg>
			                        </a>
			                    </div>
			                    <div class="text">
			                        <a href="#" class="title">Media salarial</a>
			                        <p>Mediana salarial de los desarrolladores informáticos a nivel nacional en el último periodo</p>
			                    </div>
			                </div>
			            </div>
			            <div class="col-12 col-md-6 owl-desktop">
			                <div class="bloque-indicador">
			                        <div class="grafica-circulo green">
			                            <span class="indicador-icon"><i class="iconcl-contratos"></i></span>
			                            <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
			                            <a href="#">
			                                <svg class="radial-progress" data-percentage="77" viewBox="0 0 80 80">
			                                <circle class="incomplete" cx="40" cy="40" r="35"></circle>
			                                <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
			                                <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">77%</text>
			                                </svg>
			                            </a>
			                        </div>
			                        <div class="text">
			                            <a href="#" class="title">Contratos indefinidos</a>
			                            <p>Porcentaje de contratos indefinidos para desarrolladores informáticos a nivel nacional en el último periodo</p>
			                        </div>
			                    </div>
			            </div>
			            <!-- FIN BLOQUE GRUPO INDICADORES -->
			            
			            <!-- BLOQUE CABECERA 
			            <div class="col-12">
			                <div class="bloque-cabecera">
			                    <div class="linea"><i class="iconcl-habilidades"></i></div>
			                    <h2>Habilidades más solicitadas para Desarrollador Web</h2>
			                    <p>Habilidades más solicitadas para esta ocupación en las bolsas de empleo</p>
			                </div>
			            </div>
			             //FIN BLOQUE CABECERA 
			             //BLOQUE BARRA DISTRIBUTIBA 
			            <div class="col-12 col-lg-8 offset-lg-2">
			                <div class="bloque-barra">
			                    <div class="bloque-progress">
			                        <p>Android Software Development</p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="94" aria-valuemin="0" aria-valuemax="100">94%</div>
			                        </div>
			                        <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                    <div class="bloque-progress">
			                        <p>Swift</p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="76" aria-valuemin="0" aria-valuemax="100">76%</div>
			                        </div>
			                        <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                    <div class="bloque-progress">
			                        <p>Java</p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100">72%</div>
			                        </div>
			                        <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                    <div class="bloque-progress">
			                        <p>Git</p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="64" aria-valuemin="0" aria-valuemax="100">64%</div>
			                        </div>
			                        <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                    <div class="bloque-progress">
			                        <p>Cloud computing</p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">45%</div>
			                        </div>
			                        <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                    <div class="bloque-progress">
			                        <p>Kotlin</p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="38" aria-valuemin="0" aria-valuemax="100">38%</div>
			                        </div>
			                        <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                    <div class="bloque-progress">
			                        <p>Model View Controller (MVC)</p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100">31%</div>
			                        </div>
			                        <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                    <div class="bloque-progress">
			                        <p>Programador PHP</p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="26" aria-valuemin="0" aria-valuemax="100">26%</div>
			                        </div>
			                        <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                    <div class="bloque-progress">
			                        <p>Javascript</p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100">22%</div>
			                        </div>
			                        <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                    <div class="bloque-progress">
			                        <p>Angular JS</p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="16" aria-valuemin="0" aria-valuemax="100">16%</div>
			                        </div>
			                        <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>    
			                </div>
			            </div>
			            // FIN BLOQUE BARRA DISTRIBUTIBA 
			        </div>
			    </div>-->

			    
			    <?php get_template_part('buscador-ocupaciones'); ?>

				<?php include 'related-occupations.php'?>
	
	    <!-- FIN BLOQUE AMARILLO -->
			    <!-- BOTON SOLO MÓVIL -->
			    <div class="col-12 d-block d-sm-none">
			        <div class="bloque-boton">
			            <a href="ocupacion-digital-desarrollador-web-masinfo.html" class="btn btn-arrow btn-block">Ver más información</a>
			        </div>
			    </div>
			    <!-- FIN BOTON SOLO MÓVIL -->
			
				
			<?php
			get_footer();

        }else{
        	header("HTTP/1.1 301 Moved Permanently");
			header("Location: ".home_url( '/404/' ));
			exit();
        }
	}else{
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: ".home_url( '/404/' ));
		exit();
	}
?>