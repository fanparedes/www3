<?php
	global $id_occupation;
	$rs_search 	= array('/', 'ocupacion-detalle');
	$rs_replace = array('', '');
	//var_dump($id_occupation); die;
	$id_occupation 	= str_replace($rs_search, $rs_replace, $_SERVER['REQUEST_URI']);
	$id_occupation	= explode('?', $id_occupation);
	$id_occupation	= is_numeric($id_occupation[0]) ? $id_occupation[0] : '1';

	if(isset($_GET['code_job_position'])){
		$code_job_position = $_GET['code_job_position'];
	}

	//var_dump($id_occupation); die;
	$title_ocupacion 	= '';
	$content_ocupacion = '';



	if(is_numeric($id_occupation)){

		$sql_ocupacion = "select id_occupation, name_occupation from cl_occupations where id_occupation = ".$id_occupation;
        $rs_ocupacion  = $wpdb->get_results($sql_ocupacion);
       	
        
        if( isset($code_job_position) ){

        	$job_position = array_shift($wpdb->get_results("
        									SELECT digital 
        									FROM cl_job_positions 
											WHERE code_job_position = '" . $code_job_position . "' "));
        }
											
											
        
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
	        		$title_ocupacion 	= get_the_title();
	        		$content_ocupacion = get_the_content();

	        	endwhile;
	    		wp_reset_postdata();
	    	endif;

	    	get_header(); 

    	?>
    			<div class="bloque-titular">
			        <div class="container">
			            <h1><?php echo $rs_ocupacion[0]->name_occupation;  ?></h1>
			        </div>
			    </div>
    			<!-- BLOQUE TABS -->
			    <div class="bloque-tabs">
			        <div class="container">
		            	<div class="d-none d-sm-block">
							<ul class="nav nav-tabs">
								<li class="nav-item">
									<?php 
									$resumenUrl = get_site_url() . '/ocupacion-detalle/' . $id_occupation; ?>
									
									<a class="nav-link active" href="
									<?php echo isset( $code_job_position ) ? $resumenUrl . '?code_job_position=' . $code_job_position : $resumenUrl; ?>">Resumen</a>
								</li>
								<li class="nav-item">
									<?php 
									$masInformacionUrl =  get_site_url() . '/ocupacion-mas-info/'. $id_occupation; ?>
									<a class="nav-link" href="
									<?php echo isset($code_job_position) ? $masInformacionUrl . '?code_job_position='.$code_job_position : $masInformacionUrl; ?>">Más información</a>
								</li>

								<?php if( isset($code_job_position) && $job_position->digital == 't' ): ?>
								<li class="nav-item">
									<a class="nav-link" href="<?php echo get_site_url().'/ocupacion-conocimiento/'.$id_occupation.'?code_job_position='.$code_job_position; ?>">Conocimiento</a>
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
					<?php
			    		//ranking ocupados banner
			    		$results_ocupados_banner = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 46 limit 1");
			    		//var_dump($results_ocupados_banner);
			    		if( $results_ocupados_banner ):
							$occupations = json_decode($results_ocupados_banner[0]->data, true); 
							
							
							
							foreach($occupations as $occupation){
								if( $occupation['data']['title'] == $title_ocupacion ){
									$occupation_value_ranking_banner = $occupation['data']['value'];	
								}
					        } 
							
							if ( !empty( $occupation_value_ranking_banner ) ):
					?> 
			            <div class="col-12">
			                <div class="bloque-icono">
			                    <div class="row">
			                        <div class="col-sm-12 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
			                            <div class="icono">
			                                  
			                                <i class="iconcl-crecimiento-xl"></i>
			                            </div>
			                            <div class="text">
			                                <span class="title"><?php echo $title_ocupacion; ?></span>
			                                <p>Es una de las ocupaciones más demandada a nivel nacional el ultimo periodo</p>
			                            </div>
			                        </div>
			                    </div>
			                </div>
						</div>
						<?php endif; ?>
					<?php endif; ?>

			            <!-- FIN BLOQUE ICONO -->
						<!-- BLOQUE INDICADOR -->
					<?php
			    		//ranking ocupados
			    		$results_ranking = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 46 limit 1");

			    		if( $results_ranking ):

							$occupations = json_decode($results_ranking[0]->data, true); 
							
							foreach($occupations as $occupation){
								if( $occupation['data']['title'] == $title_ocupacion ){
									$occupation_value_ranking = $occupation['data']['value'];	
								}
					        } 

							if ( !empty( $occupation_value_ranking ) ):
							$value   = number_format($occupation_value_ranking, 1, ',', '.');
					?> 
								<div class="col-12 col-md-6">
									<div class="bloque-indicador">
										<div class="grafica-circulo">
											
												<svg class="radial-progress" data-percentage="<?php echo $occupation_value_ranking;?>" viewBox="0 0 80 80">
												<circle class="incomplete" cx="40" cy="40" r="35"></circle>
												<circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
												<text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value;?>%</text>
												</svg>
											</a>
										</div>
										<div class="text">
											<a class="title"><?php echo $title_ocupacion; ?></a>
											<p>Porcentaje de las ofertas de empleo que citan esta ocupación en las bolsas de empleo</p>
										</div>
									</div>
								</div>
							<?php endif; ?>
						<?php endif; ?>

			            <!-- FIN BLOQUE INDICADOR -->
			            <?php
							//tasa de crecimiento top 5
							$results_crecimiento = 	$wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 71 limit 1");
							
							//var_dump($results_crecimiento);


							if( $results_crecimiento ) : 
							
								$occupations = json_decode($results_crecimiento[0]->data, true);
								foreach($occupations as $occupation){
									if( $occupation['data']['title'] == $title_ocupacion ){
										$occupation_value_mayor = $occupation['data']['value'];
									}	
								}

								$results_link = $wpdb->get_results("SELECT id_occupation code from cl_occupations where name_occupation  = '".$occupations[0]["data"]["title"]."'");
								$code 	= $results_link[0]->code;


							//var_dump($occupation_value_mayor);
								
								if ( !empty( $occupation_value_mayor ) ):										
						?>
									<div class="col-12 col-md-6">
										<div class="bloque-icono">
											<div class="row">
												<div class="col-md-12 ">
													<div class="icono">
														<a href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'/#crecimiento'; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>    
														<i class="iconcl-crecimiento-xl"></i>
													</div>
													<div class="text">
														<span class="title"><?php echo $title_ocupacion; ?></span>
														<p>Ocupacion con mayor tasa en crecimiento de ocupados en ultimo periodo</p>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php endif;?>	
							<?php endif;?>
						<!-- BLOQUE TITULAR -->
						<?php
							//tasa de crecimiento menor top 1
							$results = 	$wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 72 limit 1");
								
							if( $results ) : 
							
								$occupations = json_decode($results[0]->data, true);
								foreach($occupations as $occupation){
									if( $occupation['data']['title'] == $title_ocupacion ){
										$occupation_value_menor = $occupation['data']['value'];
									}	
								}

								if ( !empty( $occupation_value_menor ) ):

										
						?>
								<div class="col-12 col-md-6">
									<div class="bloque-icono red">
										<div class="row">
											<div class="col-md-12 ">
												<div class="icono">
													<a href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'/#crecimiento'; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>        
													<i class="iconcl-decrecimiento-xl"></i>
												</div>
												<div class="text">
													<span class="title"><?php echo $title_ocupacion; ?></span>
													<p>Ocupacion con menor tasa en crecimiento de ocupados en ultimo periodo</p>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php endif;?>	
							<?php endif;?>
						<!-- BLOQUE TITULAR -->
						
            <div class="col-12">
                <div class="bloque-titular">
                    <h2>Datos comunes para <?php echo $title_ocupacion; ?></h2>
                </div>
			</div>

		

					<?php
						//mediana salarial
						$results = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 61 limit 1");
						
						if( $results ):

							$occupations = json_decode($results[0]->data, true); 

							foreach($occupations as $occupation){
								if( $occupation['data']['title'] == $title_ocupacion ){
									$occupation_value = $occupation['data']['value'];	
								}
							} 
								$value = $occupation_value * 0.000001;
								$total = substr($value, 0, 3);
					       
							if ( !empty( $occupation_value ) ): 
					?>   
					        		
							<div class="col-12 col-md-6 owl-desktop">
								<div class="bloque-indicador-dato">
									<div class="grafica-circulo">
										<span class="indicador-icon"><i class="iconcl-ingresos"></i></span>
									
											<svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
											<circle class="complete" cx="40" cy="40" r="35"></circle>
											<text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">$<?php echo $total; ?>M</text>
											</svg>
										</a>
									</div>
									<div class="text">
										<a class="title">Media salarial</a>
										<p>Mediana salarial de los <?php echo $title_ocupacion; ?> a nivel nacional en el último periodo</p>
									</div>
								</div>
							</div>

							<?php endif;?>	
						<?php endif;?>

					<?php
						//mujeres
						$results_mujeres = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 60 limit 1");
						
						if( $results_mujeres ):

							$occupations_mujeres = json_decode($results_mujeres[0]->data, true); 
							
							foreach($occupations_mujeres as $occupation){
								if( $occupation['data']['title'] == $title_ocupacion ){

									$title = $occupation['data']['title'];
									$value_raw = $occupation['data']['value'];

									
								}
					        } 
					
							if ( !empty( $title ) ): 
								$value   = number_format($value_raw, 1, ',', '.');
					?>   
					        		
							<div class="col-12 col-md-6 owl-desktop">
								<div class="bloque-indicador">
									<div class="grafica-circulo">
										<span class="indicador-icon"><i class="iconcl-mujeres"></i></span>
										
											<svg class="radial-progress" data-percentage="<?php echo $value_raw; ?>" viewBox="0 0 80 80">
											<circle class="incomplete" cx="40" cy="40" r="35"></circle>
											<circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
											<text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value; ?>%</text>
											</svg>
										</a>
									</div>
									<div class="text">
										<a class="title">Mujeres</a>
										<p>Porcentaje de mujeres empleadas en <?php echo $title; ?>  a nivel nacional en el último periodo</p>
									</div>
								</div>
							</div>

							<?php endif;?>	
						<?php endif;?>
					

						<!-- BLOQUE GRUPO INDICADORES DESKTOP -->
					<?php
						//contratos indefinidos
						$results = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 47 limit 1");
						
						if( $results ):

							$occupations = json_decode($results[0]->data, true); 
							
							foreach($occupations as $occupation){
								if( $occupation['data']['title'] == $title_ocupacion ){
									$title = $occupation['data']['title'];
									$value_raw = $occupation['data']['value'];	
								}
					        } 
					       
							if ( !empty( $title ) ):
								$value   = number_format($value_raw, 1, ',', '.'); 
					?>   
					        		
							<div class="col-12 col-md-6 owl-desktop">
								<div class="bloque-indicador">
									<div class="grafica-circulo">
										<span class="indicador-icon"><i class="iconcl-contratos"></i></span>
										
											<svg class="radial-progress" data-percentage="<?php echo $value_raw; ?>" viewBox="0 0 80 80">
											<circle class="incomplete" cx="40" cy="40" r="35"></circle>
											<circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
											<text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value; ?>%</text>
											</svg>
										</a>
									</div>
									<div class="text">
										<a class="title">Contratos indefinidos</a>
										<p>Porcentaje de contratos indefinidos para <?php echo $title; ?> a nivel nacional en el último periodo</p>
									</div>
								</div>
							</div>

							<?php endif;?>	
						<?php endif;?>		

				<?php
					//dificultades para llenar vacantes
					$results_abilities = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 65 limit 1");	

					if( $results_abilities ) : 

						$value_abilities = array();

						$title_abilities = array();

						$name_abilities = array();

						$occupations_abilities = json_decode($results_abilities[0]->data, true);
						
						$i=0;

						foreach($occupations_abilities as $occupation){
							
							if( $occupation['data']['occupation'] == $title_ocupacion ){

							
								$value_abilities[$i] = $occupation['data']['value'];
								$title_abilities[$i] = $occupation['data']['title'];
								$name_abilities[$i] = $occupation['data']['name'];

								$i++;

							}	
						}

						if ( !empty( $title_abilities ) ):

				?>
							<div class="col-12">
				                <div class="bloque-cabecera">
				                    <div class="linea"><i class="iconcl-ocupacion"></i></div>
				                    <h2>Conocimientos mas requeridos</h2>
				                    <p>Conocimientos con mayor numero de vacantes a nivel nacional</p>
				                </div>
				            </div>    
				            <div class="col-12 col-lg-8 offset-lg-2">
				                <div class="bloque-barra">
				                    <div class="bloque-progress">
				                 
				                        <div class="progress">
				                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"><?php echo $name_abilities[0]; ?></div>
				                        </div>
				                    </div>
				                    <div class="bloque-progress">
				                       
				                        <div class="progress">
				                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"><?php echo $name_abilities[1]; ?></div>
				                        </div>
				                    </div>
				                    <div class="bloque-progress">
				                      
				                        <div class="progress">
				                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"><?php echo $name_abilities[2]; ?></div>
				                        </div>
				                    </div>
				                  			                   
				                </div>
				            </div>
			        	<?php endif;?>
			        <?php endif;?>   


				<!-- Mobile -->
			<div class="owl-carousel owl-theme">
				<?php
						//mediana salarial
						$results_salario = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 61 limit 1");
						
						if( $results_salario ):

							$occupations = json_decode($results_salario[0]->data, true); 

							foreach($occupations as $occupation){
								if( $occupation['data']['title'] == $title_ocupacion ){
									$occupation_value = $occupation['data']['value'];	
								}
							} 
								$value = $occupation_value * 0.000001;
								$total = substr($value, 0, 3);
					       
							if ( !empty( $occupation_value ) ): 
								$value   = number_format($total, 1, ',', '.');
					?>   
					       <div class="item">
			                    <div class="bloque-indicador-dato">
			                        <div class="grafica-circulo">
			                            <span class="indicador-icon"><i class="iconcl-ingresos"></i></span>
			                          
			                                <svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
			                                <circle class="complete" cx="40" cy="40" r="35"></circle>
			                                <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">$<?php echo $value; ?>M</text>
			                                </svg>
			                            </a>
			                        </div>
			                        <div class="text">
			                            <a class="title">Mediana salarial</a>
			                            <p>Mediana salarial de los <?php echo $title_ocupacion; ?> a nivel nacional en el último periodo</p>
			                        </div>
			                    </div>
			                </div>	
							<?php endif;?>	
						<?php endif;?>

					<?php
						//mujeres
						$results_mujeres = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 60 limit 1");
						
						if( $results_mujeres ):

							$occupations = json_decode($results_mujeres[0]->data, true); 

							foreach($occupations as $occupation){
								if( $occupation['data']['title'] == $title_ocupacion ){
									$occupation_value_mujeres = $occupation['data']['value'];	
								}
					        } 
					       
							if ( !empty( $occupation_value_mujeres ) ): 
								$value   = number_format($occupation_value_mujeres, 1, ',', '.');
					?>   
								<div class="item">
									<div class="bloque-indicador">
										<div class="grafica-circulo">
											<span class="indicador-icon"><i class="iconcl-mujeres"></i></span>
											
												<svg class="radial-progress" data-percentage="<?php echo $occupation_value_mujeres; ?>" viewBox="0 0 80 80">
												<circle class="incomplete" cx="40" cy="40" r="35"></circle>
												<circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
												<text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value; ?>%</text>
												</svg>
											</a>
										</div>
										<div class="text">
											<a class="title">Mujeres</a>
											<p>Porcentaje de mujeres empleadas <?php echo $title_ocupacion; ?>  en el último periodo</p>
										</div>
									</div>
								</div>

							<?php endif;?>	
						<?php endif;?>

						
					<?php
						//contratos indefinidos
						$results_contratos = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 47 limit 1");
						
						if( $results_contratos ):

							$occupations = json_decode($results_contratos[0]->data, true); 

							foreach($occupations as $occupation){
								if( $occupation['data']['title'] == $title_ocupacion ){
									$occupation_value = $occupation['data']['value'];	
								}
					        } 
					       
							if ( !empty( $occupation_value ) ):
								$value   = number_format($occupation_value, 1, ',', '.'); 
					?>   
							<div class="item">
			                    <div class="bloque-indicador">
			                        <div class="grafica-circulo">
			                            <span class="indicador-icon"><i class="iconcl-contratos"></i></span>
			                            
			                                <svg class="radial-progress" data-percentage="<?php echo $occupation_value; ?>" viewBox="0 0 80 80">
			                                <circle class="incomplete" cx="40" cy="40" r="35"></circle>
			                                <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
			                                <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value; ?>%</text>
			                                </svg>
			                            </a>
			                        </div>
			                        <div class="text">
			                            <a class="title">Contratos indefinidos</a>
			                            <p>Porcentaje de contratos indefinidos para <?php echo $title_ocupacion; ?> a nivel nacional en el último periodo</p>
			                        </div>
			                    </div>
			                </div>

							<?php endif;?>	
						<?php endif;?>		   
			</div>
            
			    
			    <?php get_template_part('buscador-ocupaciones'); ?>

				</div>
      		</div>
				<?php include 'related-occupations.php';?>
	
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