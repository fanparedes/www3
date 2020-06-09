<?php

	global $id_occupation;
	$rs_search 	= array('/', 'ocupacion-habilidades');
	$rs_replace = array('', '');
	$id_occupation 	= str_replace($rs_search, $rs_replace, $_SERVER['REQUEST_URI']);
	$id_occupation	= explode('?', $id_occupation);
	$id_occupation	= is_numeric($id_occupation[0]) ? $id_occupation[0] : '1';

	

	//var_dump($id_occupation); die;
	$title_ocupacion 	= '';
	$content_ocupacion = '';

    $code_job_position = $_GET['code_job_position'];
    

    $job_position = array_shift($wpdb->get_results("
    									SELECT digital 
    									FROM cl_job_positions 
    									WHERE code_job_position = '" . $code_job_position . "' "));

	if(is_numeric($id_occupation)){
		$sql_ocupacion = "select id_occupation, name_occupation from cl_occupations where id_occupation = ".$id_occupation;
        $rs_ocupacion  = $wpdb->get_results($sql_ocupacion);

        //var_dump($rs_ocupacion); die;
        if(is_array($rs_ocupacion) && count($rs_ocupacion)>0){
        	$args_ocupacion        = array(
				'post_type'     => 'detalle_ocupacion',
				'post_status'   => 'publish',
				'showposts'     => 1,
				'order'         => 'ASC',
				'meta_query' => array(
		          'relation'    => 'WHERE',
		          array(
		            'key'   => 'id',
		            'value'     => $rs_ocupacion[0]->id_occupation,
		            'compare'   => '=
		            ',
		          )
		        )
			);
			
			$wp_ocupacion = new WP_Query( $args_ocupacion );

			if ( $wp_ocupacion->have_posts() ) :
	        	while ( $wp_ocupacion->have_posts() ) : $wp_ocupacion->the_post();
	        		$title_ocupacion 	= get_field('habilidades_titulo');
	        		$content_ocupacion = get_field('detalle_habilidades');

	        	endwhile;
	    		wp_reset_postdata();
	    	endif;

	    	get_header(); 

    	?>
    			<div class="bloque-titular">
			        <div class="container">
			            <h1><?php echo $rs_ocupacion[0]->name_occupation; ?></h1>
			        </div>
			    </div>
    			<!-- BLOQUE TABS -->
			    <div class="bloque-tabs">
			        <div class="container">
			            <div class="d-none d-sm-block">
			                <ul class="nav nav-tabs">
			                    <li class="nav-item">
			                        <a class="nav-link" href="<?php echo get_site_url().'/ocupacion-detalle/'.$id_occupation.'?code_job_position='.$code_job_position; ?>">Resumen</a>
			                    </li>
			                    <li class="nav-item">
			                        <a class="nav-link" href="<?php echo get_site_url().'/ocupacion-mas-info/'.$id_occupation.'?code_job_position='.$code_job_position; ?>">Más información</a>
			                    </li>
								<?php if( $job_position->digital == 't' ): ?>		
			                    <li class="nav-item">
			                        <a class="nav-link active" href="#">Habilidades</a>
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
			            <!-- BLOQUE ICONO 
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
			             FIN BLOQUE ICONO -->
			            <!-- BLOQUE INDICADOR --
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
			            <!-- BLOQUE ICONO 
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
			             FIN BLOQUE ICONO -->
			            <!-- BLOQUE TITULAR 
			            <div class="col-12">
			                <div class="bloque-titular">
			                    <h2>Datos comunes para Desarrolladores Informáticos</h2>
			                </div>
			            </div>
			             FIN BLOQUE TITULAR -->
			            <!-- BLOQUE GRUPO INDICADORES -->
			            <!-- BLOQUE GRUPO INDICADORES CARRUSEL 
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
			            <!-- BLOQUE GRUPO INDICADORES DESKTOP 
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
			             FIN BLOQUE GRUPO INDICADORES -->
			            
			            <!-- BLOQUE CABECERA -->
			            <div class="col-12">
			                <div class="bloque-cabecera">
			                    <div class="linea"><i class="iconcl-habilidades"></i></div>
			                    <h2>Habilidades más solicitadas</h2>
			                    <p>Habilidades más solicitadas para esta ocupación en las bolsas de empleo</p>
			                </div>
			            </div>
			            <!-- FIN BLOQUE CABECERA -->
			            <!-- BLOQUE BARRA DISTRIBUTIBA -->
			            <div class="col-12 col-lg-8 offset-lg-2">
			                <div class="bloque-barra">
			                    <div class="bloque-progress">
			                        <p>User Experience (UX)</p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="94" aria-valuemin="0" aria-valuemax="100">94%</div>
			                        </div>
			                        <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                    <div class="bloque-progress">
			                        <p>User Interface (UI)</p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="76" aria-valuemin="0" aria-valuemax="100">76%</div>
			                        </div>
			                        <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                    <div class="bloque-progress">
			                        <p>CSS</p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100">72%</div>
			                        </div>
			                        <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                    <div class="bloque-progress">
			                        <p>HTML</p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="64" aria-valuemin="0" aria-valuemax="100">64%</div>
			                        </div>
			                        <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                    <div class="bloque-progress">
			                        <p>Adobe Photoshop</p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">45%</div>
			                        </div>
			                        <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                    <div class="bloque-progress">
			                        <p>Adobe Illustrator</p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="38" aria-valuemin="0" aria-valuemax="100">38%</div>
			                        </div>
			                        <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                    <div class="bloque-progress">
			                        <p>JavaScript</p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100">31%</div>
			                        </div>
			                        <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                    <div class="bloque-progress">
			                        <p>Bootstrap</p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="26" aria-valuemin="0" aria-valuemax="100">26%</div>
			                        </div>
			                        <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                    <div class="bloque-progress">
			                        <p>UiPath</p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100">22%</div>
			                        </div>
			                        <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                    <div class="bloque-progress">
			                        <p>jQuery</p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="16" aria-valuemin="0" aria-valuemax="100">16%</div>
			                        </div>
			                        <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>    
			                </div>
			            </div>
			            <!-- FIN BLOQUE BARRA DISTRIBUTIBA -->
			        </div>
			    </div>


			    <?php get_template_part('buscador-ocupaciones'); ?>
			    <!-- TAGS 
			    <div class="bloque-tags">
			        <div class="container">
			            <div class="row align-items-center">
			                <div class="col-12 col-lg-5 offset-lg-1 ">
			                    <div class="icono">
			                        <i class="iconcl-raton-xl"></i>
			                    </div>
			                    <div class="text">
			                        <h2>Prepárate</h2>
			                        <p>para las ocupaciones digitales encontrando la formación que necesitas para las habilidades más demandadas del sector.</p>
			                    </div>
			                </div>
			                <div class="col-12 col-lg-5 ">
			                    <form action="cursos.html">
			                        <div class="input-tags">
			                            <input type="text" class="form-control" name="preparate" value="" />
			                            <button type="submit"><i class="fal fa-flip-horizontal fa-search"></i></button>
			                        </div>
			                    </form>
			                </div>
			            </div>
			        </div>
			    </div>
			     FIN TAGS -->
			    <!-- BLOQUE BLANCO 
			    <div class="bloque-blanco">
			        <div class="container">
			             3 COLUMNAS 
			            <div class="bloque-columnas">
			                <h2>Ocupaciones relacionadas con Desarrolladores Informáticos</h2>
			                <div class="row">
			                    <div class="col-12 col-md-4">
			                        <h3><a href="#">Desarrollador de aplicaciones móviles</a></h3>
			                        <p>Dominus illuminatio mea et salus mea quem timebo per galia nostra summun et sinequa duis alter per galia domine lorem ipsum sit...</p>
			                        <div class="bloque-progress">
			                            <p>Demanda</p>
			                            <div class="progress">
			                                <div class="progress-bar" role="progressbar" aria-valuenow="67" aria-valuemin="0" aria-valuemax="100">67%</div>
			                            </div>
			                            <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
			                        </div>
			                    </div>
			                    <div class="col-12 col-md-4">
			                        <h3><a href="#">Desarrollador FullStack</a></h3>
			                        <p>Dominus illuminatio mea et salus mea quem timebo per galia nostra summun et sinequa duis alter per galia domine lorem ipsum sit...</p>
			                        <div class="bloque-progress">
			                            <p>Demanda</p>
			                            <div class="progress">
			                                <div class="progress-bar" role="progressbar" aria-valuenow="42" aria-valuemin="0" aria-valuemax="100">42%</div>
			                            </div>
			                            <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
			                        </div>
			                    </div>
			                    <div class="col-12 col-md-4">
			                        <h3><a href="#">Desarrollador de Big Data</a></h3>
			                        <p>Dominus illuminatio mea et salus mea quem timebo per galia nostra summun et sinequa duis alter per galia domine lorem ipsum sit...</p>
			                        <div class="bloque-progress">
			                            <p>Demanda</p>
			                            <div class="progress">
			                                <div class="progress-bar" role="progressbar" aria-valuenow="34" aria-valuemin="0" aria-valuemax="100">34%</div>
			                            </div>
			                            <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
			                        </div>
			                    </div>
			                </div>
			                <div class="bloque-boton">
			                    <a href="ocupacion-digital-desarrollador-informaticos.html" class="btn btn-yellow">Ver más ocupaciones relacionadas</a>
			                </div>
			            </div>
			             FIN 3 COLUMNAS 
			        </div>
			    </div>
			     FIN BLOQUE BLANCO 
			     BOTON SOLO MÓVIL -->
			    <div class="col-12 d-block d-sm-none">
			        <div class="bloque-boton">
			            <a href="ocupacion-digital-desarrollador-web-masinfo.html" class="btn btn-arrow btn-block">Ver más información</a>
			        </div>
			    </div>
			    <!-- FIN BOTON SOLO MÓVIL -->
   <!-- BLOQUE AMARILLO -->
	<?php include 'related-occupations.php'?>
   <!-- FIN BLOQUE AMARILLO -->	
				
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