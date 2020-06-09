<?php
	global $id_sector;
	$rs_search 	= array('/', 'sector-detalle');
	$rs_replace = array('', '');
	$id_sector 	= str_replace($rs_search, $rs_replace, $_SERVER['REQUEST_URI']);
	$id_sector	= explode('?', $id_sector);
	$id_sector	= is_numeric($id_sector[0]) ? $id_sector[0] : '1';

	//var_dump($id_sector); die;
	$title_sector 	= '';
	$content_sector = '';

	$code_sector	= isset($_GET['code_sector']) && $_GET['code_sector']!='' ? $_GET['code_sector'] : '';



	if(is_numeric($id_sector)){
		// change id's/code_sector ijensen
			//$sql_sector = "select id_sector, code_sector ,name_sector from cl_sectors where id_sector = ".$id_sector;
		$sql_sector = "select id_sector ,name_sector from cl_sectors where id_sector = ".$id_sector;
        $rs_sector  = $wpdb->get_results($sql_sector);

        //var_dump($rs_sector); die;
        if(is_array($rs_sector) && count($rs_sector)>0){
        	$args_sector        = array(
				'post_type'     => 'detalle_sector',
				'post_status'   => 'publish',
				'showposts'     => 1,
				'order'         => 'ASC',
				'meta_query' => array(
		          'relation'    => 'WHERE',
		          array(
		            'key'   => 'id',
		            'value'     => $rs_sector[0]->id_sector,
		            'compare'   => '=
		            ',
		          )
		        )
			);
			
			$wp_sector = new WP_Query( $args_sector );

			if ( $wp_sector->have_posts() ) :
	        	while ( $wp_sector->have_posts() ) : $wp_sector->the_post();
	        		$title_sector 	= get_the_title();
	        		$content_sector = get_the_content();

	        	endwhile;
	    		wp_reset_postdata();
	    	endif;

	    	get_header(); 

    	?>
    			<div class="bloque-titular">
			        <div class="container">
			            <h1 class="col-9"><?php echo ucwords(strtolower($rs_sector[0]->name_sector)); ?></h1>
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
							<!-- <li class="nav-item">
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

					<?php
			    		//Sector al alza en número de ocupados
			    		$results_alza_ocupados = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 48 limit 1");

			    		if( $results_alza_ocupados ):

							$sectors = json_decode($results_alza_ocupados[0]->data, true); 
							
							foreach($sectors as $sector){
								if( $sector['data']['title'] == $title_sector ){
									$sector_value_alza_ocupados = $sector['data']['value'];	
								}
					        } 

							if ( !empty( $sector_value_alza_ocupados ) ):
					?> 
					            <div class="col-12">
					                <div class="bloque-icono">
					                    <div class="row">
					                        <div class="col-sm-12 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
					                            <div class="icono">
					                                <a href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'/#numero_ocupados'; ?>" class="icon-plus " class="scrollLink"><i class="fal fa-plus"></i></a>
					                                <i class="iconcl-ocupacion-xl"></i>
					                            </div>
					                            <div class="text">
					                                <span class="title"><?php echo $title_sector; ?></span>
					                                <p>Es el sector con mayor crecimiento en el nº de ocupados a nivel nacional en el último periodo</p>
					                            </div>
					                        </div>
					                    </div>
					                </div>
					            </div>
					            <!-- FIN BLOQUE ICONO -->
							<?php endif;?>
						<?php endif;?>

					<?php
			    		//Sector al alza en migrantes
			    		$results_alza_migrantes = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 56 limit 1");

			    		if( $results_alza_migrantes ):

							$sectors = json_decode($results_alza_migrantes[0]->data, true); 
							
							foreach($sectors as $sector){
								if( $sector['data']['title'] == $title_sector ){
									$sector_value_alza_migrantes = $sector['data']['value'];	
								}
					        } 

							if ( !empty( $sector_value_alza_migrantes ) ):
					?> 
					            <div class="col-12">
					                <div class="bloque-icono">
					                    <div class="row">
					                        <div class="col-sm-12 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
					                            <div class="icono">
					                                <a href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'/#migrantes'; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
					                                <i class="iconcl-migrantes-xl"></i>
					                            </div>
					                            <div class="text">
					                                <span class="title"><?php echo $title_sector; ?></span>
					                                <p>Es uno de los cuatro sectores con mayor crecimiento en el número de migrantes a nivel nacional en el último período</p>
					                            </div>
					                        </div>
					                    </div>
					                </div>
					            </div>
					            <!-- FIN BLOQUE ICONO -->
							<?php endif;?>
						<?php endif;?>
						 <?php

							//Dificultades para llenar vacantes de los puestos de trabajo
							$results_dificultad = 	$wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 64 limit 1");
							
							if( $results_dificultad ) : 
							
								$occupations_dificultad = json_decode($results_dificultad[0]->data, true);

								foreach($occupations_dificultad as $occupation){
									if( $occupation['data']['sector'] == $title_sector ){
									
										$name_dificultad  = $occupation['data']['name']; 
									}	
								}


								if ( !empty( $name_dificultad ) ):										
						?>
									<div class="col-12 col-md-6">
										<div class="bloque-icono">
											<div class="row">
												<div class="col-md-12 ">
													<div class="icono">
														  
														<i class="iconcl-ocupacion-xl"></i>
													</div>
													<div class="text">
														<span class="title"><?php echo $name_dificultad; ?></span>
														<p>Es la causa que dificulta llenar vacantes en este sector</p>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php endif;?>	
							<?php endif;?>

					<?php
			    		//Sector a la baja en número de ocupados 
			    		$results_baja_ocupados = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 49 limit 1");

			    		if( $results_baja_ocupados ):

							$sectors = json_decode($results_baja_ocupados[0]->data, true); 
							foreach($sectors as $sector){
								if( $sector['data']['title'] == $title_sector ){
									$sector_value_baja_ocupados = $sector['data']['value'];	
								}
					        } 

							if ( !empty( $sector_value_baja_ocupados ) ):
					?>  
					            <div class="col-12">
					                <div class="bloque-icono red">
					                    <div class="row">
					                        <div class="col-sm-12 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
					                            <div class="icono ">
					                                <a href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'/#numero_ocupados'; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
					                                <i class="iconcl-decrecimiento-xl"></i>
					                            </div>
					                            <div class="text">
					                                <span class="title"><?php echo $title_sector; ?></span>
					                                <p>Es el sector con menor crecimiento en el nº de migrantes a nivel nacional en el último periodo</p>
					                            </div>
					                        </div>
					                    </div>
					                </div>
					            </div>
					            <!-- FIN BLOQUE ICONO -->
							<?php endif;?>
						<?php endif;?>

					<?php
			    		//Sector a la baja en migrantes
			    		$results_baja_migrantes = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 57 limit 1");

			    		if( $results_baja_migrantes ):

							$sectors = json_decode($results_baja_migrantes[0]->data, true); 
							foreach($sectors as $sector){
								if( $sector['data']['title'] == $title_sector ){
									$sector_value_baja_migrantes = $sector['data']['value'];	
								}
					        } 

							if ( !empty( $sector_value_baja ) ):
					?>  
					            <div class="col-12">
					                <div class="bloque-icono red">
					                    <div class="row">
					                        <div class="col-sm-12 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
					                            <div class="icono ">
					                                <a href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'/#migrantes'; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
					                                <i class="iconcl-migrantes-xl"></i>
					                            </div>
					                            <div class="text">
					                                <span class="title"><?php echo $title_sector; ?></span>
					                                <p>Es el sector con menor crecimiento en el nº de ocupados a nivel nacional en el último periodo</p>
					                            </div>
					                        </div>
					                    </div>
					                </div>
					            </div>
					            <!-- FIN BLOQUE ICONO -->
							<?php endif;?>
						<?php endif;?>

					<?php
			    		//Sector al alza en mujeres
			    		$results_alza_mujeres = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 58 limit 1");

			    		if( $results_alza_mujeres ):

							$sectors = json_decode($results_alza_mujeres[0]->data, true); 
							
							foreach($sectors as $sector){
								if( $sector['data']['title'] == $title_sector ){
									$sector_value_alza_mujeres = $sector['data']['value'];	
								}
					        } 

							if ( !empty( $sector_value_alza_mujeres ) ):
					?> 
					            <div class="col-12">
					                <div class="bloque-icono">
					                    <div class="row">
					                        <div class="col-sm-12 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
					                            <div class="icono">
					                                <a href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'/#mujeres'; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
					                                <i class="iconcl-mujeres-xl"></i>
					                            </div>
					                            <div class="text">
					                                <span class="title"><?php echo $title_sector; ?></span>
					                                <p>Es el sector con mayor crecimiento en el nº de mujeres a nivel nacional en el último periodo</p>
					                            </div>
					                        </div>
					                    </div>
					                </div>
					            </div>
					            <!-- FIN BLOQUE ICONO -->
							<?php endif;?>
						<?php endif;?>

					<?php
			    		//Sector a la baja mujeres
			    		$results_baja_mujeres = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 59 limit 1");

			    		if( $results_baja_mujeres ):

							$sectors = json_decode($results_baja_mujeres[0]->data, true);
							foreach($sectors as $sector){
								if( $sector['data']['title'] == $title_sector ){
									$sector_value_baja_mujeres = $sector['data']['value'];	
								}
					        } 

							if ( !empty( $sector_value_baja_mujeres ) ):
					?>  
					            <div class="col-12">
					                <div class="bloque-icono red">
					                    <div class="row">
					                        <div class="col-sm-12 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
					                            <div class="icono ">
					                                <a href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'/#mujeres'; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
					                                <i class="iconcl-mujeres-xl"></i>
					                            </div>
					                            <div class="text">
					                                <span class="title"><?php echo $title_sector; ?></span>
					                                <p>Es el sector con menor crecimiento en el nº de mujeres a nivel nacional en el último periodo</p>
					                            </div>
					                        </div>
					                    </div>
					                </div>
					            </div>
					            <!-- FIN BLOQUE ICONO -->
							<?php endif;?>
						<?php endif;?>

					<?php
			    		//Sector al alza en mujeres
			    		$results_contratos_alza = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 58 limit 1");

			    		if( $results_contratos_alza ):

							$sectors = json_decode($results_contratos_alza[0]->data, true); 
							
							foreach($sectors as $sector){
								if( $sector['data']['title'] == $title_sector ){
									$sector_value_alza_contratos = $sector['data']['value'];	
								}
					        } 

							if ( !empty( $sector_value_alza_contratos ) ):
					?> 
					            <div class="col-12">
					                <div class="bloque-icono">
					                    <div class="row">
					                        <div class="col-sm-12 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
					                            <div class="icono">
					                                <a href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'/#mujeres'; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
					                                <i class="iconcl-contratos-xl"></i>
					                            </div>
					                            <div class="text">
					                                <span class="title"><?php echo $title_sector; ?></span>
					                                <p>Es el sector con mayor crecimiento en el nº de contratos indefinidos a nivel nacional en el último periodo</p>
					                            </div>
					                        </div>
					                    </div>
					                </div>
					            </div>
					            <!-- FIN BLOQUE ICONO -->
							<?php endif;?>
						<?php endif;?>

					
			
						<?php
							//Rotacion intersectorial
							$results_rotacion = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 54 limit 1");
							
							if( $results_rotacion ):

								$sectors = json_decode($results_rotacion[0]->data, true); 

								foreach($sectors as $sector){
									if( $sector['data']['title'] == $title_sector ){
										$sector_value_rotacion = $sector['data']['value'];	
									}
								} 
							
								if ( !empty( $sector_value_rotacion ) ): 
									$value   = number_format($sector_value_rotacion, 1, ',', '.'); 
									
						?>   
					        		
				        		<div class="col-12 col-md-6 owl-desktop">
					        		<div class="bloque-indicador">
					                    <div class="grafica-circulo">
					                        <span class="indicador-icon"><i class="iconcl-ocupacion"></i></span>
					                        <a href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'/#rotacion'; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
					                        <a href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'/#rotacion'; ?>">
					                            <svg class="radial-progress" data-percentage="<?php echo $sector_value_rotacion; ?>" viewBox="0 0 80 80">
					                            <circle class="incomplete" cx="40" cy="40" r="35"></circle>
					                            <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
					                            <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value; ?>%</text>
					                            </svg>
					                        </a>
					                    </div>
					                    <div class="text">
					                        <a href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'/#rotacion'; ?>" class="title">Rotacion intersectorial</a>
					                        <p>Porcentaje de rotacion intersectorial en el ultimo año</p>
					                    </div>
					                </div>
				                </div>

					   			<?php endif;?>
					    	<?php endif;?>
					   

					<?php
						//nuevos trabajadores
						$results_nuevos_trabajadores = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 55 limit 1");
						
						if( $results_nuevos_trabajadores ):

							$sectors = json_decode($results_nuevos_trabajadores[0]->data, true); 

							foreach($sectors as $sector){
								if( $sector['data']['title'] == $title_sector ){
									$sector_value = $sector['data']['value'];	
								}
					        } 
					       
							if ( !empty( $sector_value ) ): 
								$value   = number_format($sector_value, 1, ',', '.'); 
					?>   
					        		
				        		<div class="col-12 col-md-6 owl-desktop">
					        		<div class="bloque-indicador">
					                    <div class="grafica-circulo">
					                        <span class="indicador-icon"><i class="iconcl-ocupacion"></i></span>
					                        <a href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'/#nuevos_trabajadores'; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
					                        <a href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'/#nuevos_trabajadores'; ?>">
					                            <svg class="radial-progress" data-percentage="<?php echo $sector_value; ?>" viewBox="0 0 80 80">
					                            <circle class="incomplete" cx="40" cy="40" r="35"></circle>
					                            <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
					                            <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value; ?>%</text>
					                            </svg>
					                        </a>
					                    </div>
					                    <div class="text">
					                        <a href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'/#nuevos_trabajadores'; ?>" class="title">Nuevos trabajadores</a>
					                        <p>Porcentaje de nuevos trabajadores en el ultimo año</p>
					                    </div>
					                </div>
				                </div>

							<?php endif;?>	
						<?php endif;?>

						<?php
						//contratos indefindos %
						$results_contratos_indefinidos = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 50 limit 1");
						
						if( $results_contratos_indefinidos ):

							$sectors = json_decode($results_contratos_indefinidos[0]->data, true); 

							foreach($sectors as $sector){
								if( $sector['data']['title'] == $title_sector ){
									$sector_value = $sector['data']['value'];	
								}
					        } 
					       
							if ( !empty( $sector_value ) ): 
								$value   = number_format($sector_value, 1, ',', '.'); 
					?>   
					        		
				        		<div class="col-12 col-md-6 owl-desktop">
					        		<div class="bloque-indicador">
					                    <div class="grafica-circulo">
					                        <span class="indicador-icon"><i class="iconcl-contratos"></i></span>
					                        <a href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'/#p_contratos_indefinidos'; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
					                        <a href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'/#p_contratos_indefinidos'; ?>">
					                            <svg class="radial-progress" data-percentage="<?php echo $sector_value; ?>" viewBox="0 0 80 80">
					                            <circle class="incomplete" cx="40" cy="40" r="35"></circle>
					                            <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
					                            <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value; ?>%</text>
					                            </svg>
					                        </a>
					                    </div>
					                    <div class="text">
					                        <a href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'/#p_contratos_indefinidos'; ?>" class="title">Contratos Indefinidos</a>
					                        <p>Porcentaje de contratos indefinidos en el ultimo año</p>
					                    </div>
					                </div>
				                </div>

							<?php endif;?>	
						<?php endif;?>

					
					
						 <!-- Cesantia
						<div class="col-12 col-md-6 owl-desktop">
					        <div class="bloque-indicador-dato">
					            <div class="grafica-circulo ">
					                <span class="indicador-icon"><i class="iconcl-cesantia"></i></span>
					                <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
					                <a href="#">
					                    <svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
					                    <circle class="complete" cx="40" cy="40" r="35"></circle>
					                    <text class="percentage" x="50%" y="50%" transform="matrix(0, 1, -1, 0, 80, 0)">1</text>
					                    <text class="text-sub" x="50%" y="66%" transform="matrix(0, 1, -1, 0, 80, 0)">MES</text>
					                    </svg>
					                </a>
					            </div>
					            <div class="text">
					                <a href="#" class="title">Cesantías</a>
					                <p>Promedio duración de censantía para este sector a nivel nacional en el último periodo</p>
					            </div>
					        </div>
					    </div>
 							-->

		            </div>
	            </div>

				
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