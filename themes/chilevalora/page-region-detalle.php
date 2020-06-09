<?php
	
	$rs_search 	= array('/', 'region-detalle');
	$rs_replace = array('', '');
	$id_region 	= str_replace($rs_search, $rs_replace, $_SERVER['REQUEST_URI']);
	$id_region	= is_numeric($id_region) ? $id_region : '1';

	//var_dump($id_region); die;

	if(is_numeric($id_region)){
		$sql_region = "select id_region, name_region from cl_regions where id_region = ".$id_region;
        $rs_region  = $wpdb->get_results($sql_region);
        if(is_array($rs_region) && count($rs_region)>0){
        	$args_region        = array(
				'post_type'     => 'regiones_detalle',
				'post_status'   => 'publish',
				'showposts'     => 1,
				'order'         => 'ASC',
				'meta_query' => array(
		          'relation'    => 'WHERE',
		          array(
		            'key'   => 'id',
		            'value'     => $rs_region[0]->id_region,
		            'compare'   => '=',
		          )
		        )
			);
			
			$wp_region = new WP_Query( $args_region );

			if ( $wp_region->have_posts() ) :
	        	while ( $wp_region->have_posts() ) : $wp_region->the_post();
	        		$title_region 	= get_the_title();
	        		$content_region = get_the_content();

	        	endwhile;
	    		wp_reset_postdata();
	    	endif;

	    	get_header(); 
    	?>
    		<style type="text/css">
    			.content_justify p{
    				text-align: justify !important;
    			}
    		</style>
				<div class="bloque-titular">
				    <div class="container">
				        <h1><?php echo ucwords(strtolower($rs_region[0]->name_region)); ?></h1>
				    </div>
				</div>
				<div class="container">
				    <div class="row">
				        <!-- BLOQUE TEXTO -->
				        <div class="col-12">
				            <div class="bloque-texto row">
				                <div class="col-12 col-lg-2">
				                    <h2><?php echo $title_region; ?></h2>
				                </div>
				                <div class="col-12 col-lg-10 content_justify" >
				                    <?php echo $content_region; ?>
				                </div>
				            </div>
				        </div>
				        <div class="owl-carousel owl-theme">
			            
			    <?php
					//mujeres
					$results_mujeres = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 30 limit 1");

					if( $results_mujeres ) : 

						$regions  = json_decode($results_mujeres[0]->data, true);

						foreach($regions as $region){
							if( $region['data']['title'] == $title_region ){
								$value_mujeres = $region['data']['value'];
								$name_mujeres = $region['data']['region'];

								$value_mujeres_format = number_format($value_mujeres, 1, ',', '.');
							}	
						}
						if ( !empty( $name_mujeres ) ):
				?>         		
			        		<div class="item">
				        		<div class="bloque-indicador">
				                    <div class="grafica-circulo">
				                        <span class="indicador-icon"><i class="iconcl-mujeres"></i></span>
				                        <a href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'/#mujeres'; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
				                        <a href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'/#mujeres'; ?>">
				                            <svg class="radial-progress" data-percentage="<?php echo $value_mujeres; ?>" viewBox="0 0 80 80">
				                            <circle class="incomplete" cx="40" cy="40" r="35"></circle>
				                            <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
				                            <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value_mujeres_format ?>%</text>
				                            </svg>
				                        </a>
				                    </div>
				                    <div class="text">
				                        <a href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'/#mujeres'; ?>" class="title">Mujeres</a>
				                        <p>Porcentaje de Mujeres activas</p>
				                    </div>
				                </div>
			                </div>
			   			<?php endif;?>
			   		<?php endif;?>

			    <?php
					//porcentaje de contratos indefinidos
					$results_contratos = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 3 limit 1");

					if( $results_contratos ) : 
								
						$regions  = json_decode($results_contratos[0]->data, true);

						foreach($regions as $region){
							if( $region['data']['region'] == $title_region ){
								$value_contratos = $region['data']['value'];
								$name_contratos = $region['data']['region'];

								$value_contratos_format = number_format($value_contratos, 1, ',', '.');
							}	
						}
						if ( !empty( $name_contratos ) ):
				?>           		
			        		<div class="item">
				        		<div class="bloque-indicador">
				                    <div class="grafica-circulo">
				                        <span class="indicador-icon"><i class="iconcl-contratos"></i></span>
				                        <a href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'/#contratos_indefinidos'; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
				                        <a href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'/#contratos_indefinidos'; ?>">
				                            <svg class="radial-progress" data-percentage="<?php echo $value_contratos; ?>" viewBox="0 0 80 80">
				                            <circle class="incomplete" cx="40" cy="40" r="35"></circle>
				                            <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
				                            <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value_contratos_format ?>%</text>
				                            </svg>
				                        </a>
				                    </div>
				                    <div class="text">
				                        <a href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'/#contratos_indefinidos'; ?>" class="title">Contratos indefinidos</a>
				                        <p>Porcentaje de contratos indefinidos en la region</p>
				                    </div>
				                </div>
			                </div>
			   			<?php endif;?>
			   		<?php endif;?>

  				<?php
					//poblacion activa
					$results_poblacion_activa = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 32 limit 1");
					if( $results_poblacion_activa ) : 
								
						$regions  = json_decode($results_poblacion_activa[0]->data, true);

						foreach($regions as $region){
							if( $region['data']['title'] == $title_region ){
								$value_poblacion_activa = $region['data']['value'];
								$name_poblacion_activa = $region['data']['region'];

								$value_poblacion_activa_format = number_format($value_poblacion_activa, 1, ',', '.');
							}	
						}

						if ( !empty( $name_poblacion_activa ) ):
				?>   					        		
			        		<div class="item">
				        		<div class="bloque-indicador">
				                    <div class="grafica-circulo">
				                        <span class="indicador-icon"><i class="iconcl-mujeres"></i></span>			                       
				                            <svg class="radial-progress" data-percentage="<?php echo $value_poblacion_activa; ?>" viewBox="0 0 80 80">
				                            <circle class="incomplete" cx="40" cy="40" r="35"></circle>
				                            <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
				                            <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value_poblacion_activa_format ?>%</text>
				                            </svg>
				                        </a>
				                    </div>
				                    <div class="text">
				                        <p>Porcentaje de población en activo en esta región en el último periodo</p>
				                    </div>
				                </div>
			                </div>
			   			<?php endif;?>
			   		<?php endif;?>
			    </div>

	            <?php
					//mujeres
					$results_mujeres = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 30 limit 1");

					if( $results_mujeres ) : 
								
						$regions = json_decode($results_mujeres[0]->data, true);

						foreach($regions as $region){
							if( $region['data']['title'] == $title_region ){
								$value_mujeres = $region['data']['value'];
								$name_mujeres = $region['data']['region'];

								$value_mujeres_format = number_format($value_mujeres, 1, ',', '.');
							}	
						}
						if ( !empty( $name_mujeres ) ):
				?>   	        		
			        		<div class="col-12 col-md-6 owl-desktop">
				        		<div class="bloque-indicador">
				                    <div class="grafica-circulo">
				                        <span class="indicador-icon"><i class="iconcl-mujeres"></i></span>
				                        <a href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'/#mujeres'; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
				                        <a href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'/#mujeres'; ?>">
				                            <svg class="radial-progress" data-percentage="<?php echo $value_mujeres; ?>" viewBox="0 0 80 80">
				                            <circle class="incomplete" cx="40" cy="40" r="35"></circle>
				                            <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
				                            <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value_mujeres_format ?>%</text>
				                            </svg>
				                        </a>
				                    </div>
				                    <div class="text">
				                        <a href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'/#mujeres'; ?>" class="title">Mujeres</a>
				                        <p>Porcentaje de mujeres en activo en esta región en el último periodo</p>
				                    </div>
				                </div>
			                </div>
			   			<?php endif;?>
			   		<?php endif;?>

			    <?php
					//porcentaje de contratos indefinidos
					$results_contratos = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 3 limit 1");
					
					if( $results_contratos ) : 
								
						$regions = json_decode($results_contratos[0]->data, true);

						foreach($regions as $region){
							if( $region['data']['region'] == $title_region ){
								$value_contratos = $region['data']['value'];
								$name_contratos = $region['data']['region'];

								$value_contratos_format = number_format($value_contratos, 1, ',', '.');
							}	
						}
						if ( !empty( $name_contratos ) ):
				?>   	        		
			        		<div class="col-12 col-md-6 owl-desktop">
				        		<div class="bloque-indicador">
				                    <div class="grafica-circulo">
				                        <span class="indicador-icon"><i class="iconcl-contratos"></i></span>
				                        <a href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'/#contratos_indefinidos'; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
				                        <a href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'/#contratos_indefinidos'; ?>">
				                            <svg class="radial-progress" data-percentage="<?php echo $value_contratos; ?>" viewBox="0 0 80 80">
				                            <circle class="incomplete" cx="40" cy="40" r="35"></circle>
				                            <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
				                            <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value_contratos_format ?>%</text>
				                            </svg>
				                        </a>
				                    </div>
				                    <div class="text">
				                        <a href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'/#contratos_indefinidos'; ?>" class="title">Contratos indefinidos</a>
				                        <p>Porcentaje de contratos indefinidos en la region</p>
				                    </div>
				                </div>
			                </div>
			   			<?php endif;?>
			   		<?php endif;?>
  			
			   	<?php
					//poblacion activa
					$results_poblacion_activa = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 32 limit 1");

					if( $results_poblacion_activa ) : 
								
						$regions = json_decode($results_poblacion_activa[0]->data, true);

						foreach($regions as $region){
							if( $region['data']['title'] == $title_region ){
								$value_poblacion_activa = $region['data']['value'];
								$name_poblacion_activa = $region['data']['region'];

								$value_poblacion_activa_format = number_format($value_poblacion_activa, 1, ',', '.');
							}	
						}
						if ( !empty( $value_poblacion_activa ) ):
				?>           		
			        		<div class="col-12 col-md-6 owl-desktop">
				        		<div class="bloque-indicador">
				                    <div class="grafica-circulo">
				                        <span class="indicador-icon"><i class="iconcl-mujeres"></i></span>
				                            <svg class="radial-progress" data-percentage="<?php echo $value_poblacion_activa; ?>" viewBox="0 0 80 80">
				                            <circle class="incomplete" cx="40" cy="40" r="35"></circle>
				                            <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
				                            <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value_poblacion_activa_format ?>%</text>
				                            </svg>
				                       
				                    </div>
				                    <div class="text">
				                        <a class="title">Población activa</a>
				                        <p>Porcentaje de población en activo en esta región en el último periodo</p>
				                    </div>
				                </div>
			                </div>
			   			<?php endif;?>
			   		<?php endif;?>

			   		<?php
			    		//ranking ocupados banner
			    		$results_region_banner = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 34 limit 1");

			    		if( $results_region_banner ):

							$regions = json_decode($results_region_banner[0]->data, true); 
							
							foreach($regions as $region){
								if( $region['data']['region'] == $title_region ){
									$title_region_banner = $region['data']['title'];
									$name_region_banner = $region['data']['name'];
									$value_region_banner = $region['data']['value'];	

								}
					        } 
							
							if ( !empty( $value_region_banner ) ):
					?> 
					            <div class="col-12">
					                <div class="bloque-icono">
					                    <div class="row">
					                        <div class="col-sm-12 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
					                            <div class="icono"> 
					                                <i class="iconcl-ocupacion-xl"></i>
					                            </div>
					                            <div class="text">
					                                <span class="title"><?php echo $title_region_banner; ?></span>
					                                <p>Tiene un total de <?php echo $value_region_banner; ?> vacantes a causa de <?php echo $name_region_banner; ?></p>
					                            </div>
					                        </div>
					                    </div>
					                </div>
								</div>
							<?php endif; ?>
						<?php endif; ?>


				<?php
					//top 3 mujeres region
					$results_mujeres_top = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 11 limit 1");

					if( $results_mujeres_top ) : 

						$region_value_mujeres = array();
						
						$region_title_mujeres = array();

						$regions  = json_decode($results_mujeres_top[0]->data, true);
					
						$i=0;

							foreach($regions as $region){
								
								if( $region['data']['region'] == $title_region ){

									$region_value_mujeres[$i] = $region['data']['value'];

									$region_title_mujeres[$i] = $region['data']['title'];
									
									$i++;				
								}	
							}

							$value = number_format($region_value_mujeres[0], 1, ',', '.');
							$value_u = number_format($region_value_mujeres[1], 1, ',', '.');
							$value_d = number_format($region_value_mujeres[2], 1, ',', '.');

							$results_link = $wpdb->get_results("SELECT id_sector code from cl_sectors where name_sector = '".$region_title_mujeres[0]."'");
							$code = $results_link[0]->code;

							$results_link_u = $wpdb->get_results("SELECT id_sector code from cl_sectors where name_sector = '".$region_title_mujeres[1]."'");
							$code_u = $results_link_u[0]->code;

							$results_link_d = $wpdb->get_results("SELECT id_sector code from cl_sectors where name_sector = '".$region_title_mujeres[2]."'");
							$code_d = $results_link_d[0]->code;

					if ( !empty( $region_value_mujeres ) ):
				?>   	
						<!-- BLOQUE CABECERA -->
						<div class="col-12">
							<div class="bloque-cabecera">
								<div class="linea"><i class="iconcl-mujeres"></i></div>
								<h2>Mujeres</h2>
								<p>Sectores con mayor porcentaje de mujeres en esta región en el último periodo</p>
							</div>
						</div>
						<!-- FIN BLOQUE CABECERA -->
						<!-- BLOQUE INDICADORES DISTRIBUTIVA -->
						<div class="bloque-indicadores-distributiva">
							<div class="owl-carousel owl-theme">
								<div class="col-12 col-md-6 item">
									<div class="bloque-indicador-dato">
										<div class="grafica-circulo">
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code; ?>">
												<svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
												<circle class="complete" cx="40" cy="40" r="35"></circle>
												<text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value; ?>%</text>
												</svg>
											</a>
										</div>
										<div class="text">
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code; ?>" class="title"><?php echo $region_title_mujeres[0]; ?></a>
										</div>
									</div>
								</div>
								<div class="col-12 col-md-6 item">
									<div class="bloque-indicador-dato">
										<div class="grafica-circulo">
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code_u; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code_u; ?>">
												<svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
												<circle class="complete" cx="40" cy="40" r="35"></circle>
												<text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value_u; ?>%</text>
												</svg>
											</a>
										</div>
										<div class="text">
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code_d; ?>" class="title"><?php echo $region_title_mujeres[1]; ?></a>
										</div>
									</div>
								</div>
								<div class="col-12 col-md-6 item">
									<div class="bloque-indicador-dato">
										<div class="grafica-circulo">
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code_d; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code_d; ?>">
												<svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
												<circle class="complete" cx="40" cy="40" r="35"></circle>
												<text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value_d; ?>%</text>
												</svg>
											</a>
										</div>
										<div class="text">
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code_d; ?>" class="title"><?php echo $region_title_mujeres[2]; ?></a>
										</div>
									</div>
								</div>
							</div>
									
							<div class="row owl-desktop justify-content-center">
								<div class="col-2 col-sm-6 col-md-4">
									<div class="bloque-indicador-dato">
										<div class="grafica-circulo">
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code; ?>">
												<svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
												<circle class="complete" cx="40" cy="40" r="35"></circle>
												<text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value; ?>%</text>
												</svg>
											</a>
										</div>
										<div class="text">
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code; ?>" class="title"><?php echo $region_title_mujeres[0]; ?></a>
										</div>
									</div>
								</div>
								<div class="col-2 col-sm-6 col-md-4">
									<div class="bloque-indicador-dato">
										<div class="grafica-circulo">
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code_u; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code_u; ?>">
												<svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
												<circle class="complete" cx="40" cy="40" r="35"></circle>
												<text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value_u; ?>%</text>
												</svg>
											</a>
										</div>
										<div class="text">
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code_u; ?>" class="title"><?php echo $region_title_mujeres[1]; ?></a>
										</div>
									</div>
								</div>
								<div class="col-2 col-sm-6 col-md-4">
									<div class="bloque-indicador-dato">
										<div class="grafica-circulo">
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code_d; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code_d; ?>">
												<svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
												<circle class="complete" cx="40" cy="40" r="35"></circle>
												<text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value_d; ?>%</text>
												</svg>
											</a>
										</div>
										<div class="text">
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code_d; ?>" class="title"><?php echo $region_title_mujeres[2]; ?></a>
										</div>
									</div>
								</div>
							</div>
							
							<div class="bloque-boton">
								<a href="<?php echo get_site_url().'/sectores-productivos'?>" class="btn btn-yellow">Ver más sectores</a>
							</div>
						</div>
					<?php endif;?>
					<?php endif;?>


				<?php
					//top 3 contratos region
					$results_contratos = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 4 limit 1");

					if( $results_contratos ) : 

						$region_value_contratos = array();

						$region_title_contratos = array();

						$regions  = json_decode($results_contratos[0]->data, true);

						$i=0;

						foreach($regions as $region){
							
							if( $region['data']['region'] == $title_region ){

								$region_value_contratos[$i] = $region['data']['value'];

								$region_title_contratos[$i] = $region['data']['title'];

								$i++;	
								
							}	
						}
								$value = number_format($region_value_contratos[0], 1, ',', '.');
								$value_u = number_format($region_value_contratos[1], 1, ',', '.');
								$value_d = number_format($region_value_contratos[2], 1, ',', '.');
								
								$results_link = $wpdb->get_results("SELECT id_sector code from cl_sectors where name_sector = '".$region_title_contratos[0]."'");
								$code = $results_link[0]->code;

								$results_link_u = $wpdb->get_results("SELECT id_sector code from cl_sectors where name_sector = '".$region_title_contratos[1]."'");
								$code_u = $results_link_u[0]->code;

								$results_link_d = $wpdb->get_results("SELECT id_sector code from cl_sectors where name_sector = '".$region_title_contratos[2]."'");
								$code_d = $results_link_d[0]->code;

							if ( !empty( $region_title ) ):

				?>   	
						<!-- BLOQUE CABECERA -->
						<div class="col-12">
							<div class="bloque-cabecera">
								<div class="linea"><i class="iconcl-contratos"></i></div>
								<h2>Contratos</h2>
								<p>Sectores con mayor porcentaje de contratos indefinidos en esta región en el último periodo</p>
							</div>
						</div>
						<!-- FIN BLOQUE CABECERA -->
						<!-- BLOQUE INDICADORES DISTRIBUTIVA -->
						<div class="bloque-indicadores-distributiva">
							<div class="owl-carousel owl-theme">
								<div class="col-12 col-md-6 item">
									<div class="bloque-indicador-dato">
										<div class="grafica-circulo">
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code; ?>">
												<svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
												<circle class="complete" cx="40" cy="40" r="35"></circle>
												<text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value; ?>%</text>
												</svg>
											</a>
										</div>
										<div class="text">
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code; ?>" class="title"><?php echo $region_title_contratos[0]; ?></a>
										</div>
									</div>
								</div>
								<div class="col-12 col-md-6 item">
									<div class="bloque-indicador-dato">
										<div class="grafica-circulo">
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code_u; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code_u; ?>">
												<svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
												<circle class="complete" cx="40" cy="40" r="35"></circle>
												<text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value_u; ?>%</text>
												</svg>
											</a>
										</div>
										<div class="text">
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code_d; ?>" class="title"><?php echo $region_title_contratos[1]; ?></a>
										</div>
									</div>
								</div>
								<div class="col-12 col-md-6 item">
									<div class="bloque-indicador-dato">
										<div class="grafica-circulo">
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code_d; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code_d; ?>">
												<svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
												<circle class="complete" cx="40" cy="40" r="35"></circle>
												<text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value_d; ?>%</text>
												</svg>
											</a>
										</div>
										<div class="text">
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code_d; ?>" class="title"><?php echo $region_title_contratos[2]; ?></a>
										</div>
									</div>
								</div>
							</div>
									
							<div class="row owl-desktop justify-content-center">
								<div class="col-2 col-sm-6 col-md-4">
									<div class="bloque-indicador-dato">
										<div class="grafica-circulo">
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code; ?>">
												<svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
												<circle class="complete" cx="40" cy="40" r="35"></circle>
												<text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value; ?>%</text>
												</svg>
											</a>
										</div>
										<div class="text">
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code; ?>" class="title"><?php echo $region_title_contratos[0]; ?></a>
										</div>
									</div>
								</div>
								<div class="col-2 col-sm-6 col-md-4">
									<div class="bloque-indicador-dato">
										<div class="grafica-circulo">
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code_u; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code_u; ?>">
												<svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
												<circle class="complete" cx="40" cy="40" r="35"></circle>
												<text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value_u; ?>%</text>
												</svg>
											</a>
										</div>
										<div class="text">
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code_u; ?>" class="title"><?php echo $region_title_contratos[1]; ?></a>
										</div>
									</div>
								</div>
								<div class="col-2 col-sm-6 col-md-4">
									<div class="bloque-indicador-dato">
										<div class="grafica-circulo">
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code_d; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code_d; ?>">
												<svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
												<circle class="complete" cx="40" cy="40" r="35"></circle>
												<text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value_d; ?>%</text>
												</svg>
											</a>
										</div>
										<div class="text">
											<a href="<?php echo get_site_url().'/sector-detalle/'.$code_d; ?>" class="title"><?php echo $region_title_contratos[2]; ?></a>
										</div>
									</div>
								</div>
							</div>
							
							<div class="bloque-boton">
								<a href="<?php echo get_site_url().'/sectores-productivos'?>" class="btn btn-yellow">Ver más sectores</a>
							</div>
						</div>
					<?php endif;?>
				<?php endif; ?>
				

				<?php
					//numero de vacantes
					$results_vacantes = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 33 limit 1");
					
					if( $results_vacantes ) : 

						$region_value_vacantes  = array();

						$region_title_vacantes = array();

						$regions  = json_decode($results_vacantes[0]->data, true);
						
						$i=0;

						foreach($regions as $region){
							
							if( $region['data']['region'] == $title_region ){

								$region_value_vacantes[$i] = $region['data']['value'];

								$region_title_vacantes[$i] = $region['data']['title'];							

								$i++;

							}	
						}

						$results_link = $wpdb->get_results("SELECT id_sector code from cl_sectors where name_sector = '".$region_title_vacantes[0]."'");
						$code = $results_link[0]->code;

						$results_link_a = $wpdb->get_results("SELECT id_sector code from cl_sectors where name_sector = '".$region_title_vacantes[1]."'");
						$code_a = $results_link_a[0]->code;

						$results_link_b = $wpdb->get_results("SELECT id_sector code from cl_sectors where name_sector = '".$region_title_vacantes[2]."'");
						$code_b = $results_link_b[0]->code;

						$results_link_c = $wpdb->get_results("SELECT id_sector code from cl_sectors where name_sector = '".$region_title_vacantes[3]."'");
						$code_c = $results_link_c[0]->code;

						$results_link_d = $wpdb->get_results("SELECT id_sector code from cl_sectors where name_sector = '".$region_title_vacantes[4]."'");
						$code_d = $results_link_d[0]->code;

						if ( !empty( $region_title_vacantes ) ):

				?>
						<div class="col-12">
			                <div class="bloque-cabecera">
			                    <div class="linea"><i class="iconcl-ocupacion"></i></div>
			                    <h2>Ocupaciones con mayor numero de vacantes</h2>
			                    <p>Ocupaciones con mayor numero de vacantes en la region</p>
			                </div>
			            </div>    
			            <div class="col-12 col-lg-8 offset-lg-2">
			                <div class="bloque-barra">
			                    <div class="bloque-progress">
			                        <p><?php echo $region_title_vacantes[0]; ?></p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Cuenta con un total de <?php echo $region_value_vacantes[0]; ?> vacantes</div>
			                        </div>
			                        <a href="<?php echo get_site_url().'/sector-detalle/'.$code; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                    <div class="bloque-progress">
			                        <p><?php echo $region_title_vacantes[1]; ?></p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Cuenta con un total de <?php echo $region_value_vacantes[1]; ?> vacantes</div>
			                        </div>
			                        <a href="<?php echo get_site_url().'/sector-detalle/'.$code_a; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                    <div class="bloque-progress">
			                        <p><?php echo $region_title_vacantes[2]; ?></p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Cuenta con un total de <?php echo $region_value_vacantes[2]; ?> vacantes</div>
			                        </div>
			                        <a href="<?php echo get_site_url().'/sector-detalle/'.$code_b; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                    <div class="bloque-progress">
			                        <p><?php echo $region_title_vacantes[3]; ?></p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Cuenta con un total de <?php echo $region_value_vacantes[3]; ?> vacantes</div>
			                        </div>
			                        <a href="<?php echo get_site_url().'/sector-detalle/'.$code_c; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                    <div class="bloque-progress">
			                        <p><?php echo $region_title_vacantes[4]; ?></p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Cuenta con un total de <?php echo $region_value_vacantes[4]; ?> vacantes</div>
			                        </div>
			                        <a href="<?php echo get_site_url().'/sector-detalle/'.$code_c; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                   				                   
			                </div>
			            </div>
			        	<?php endif;?>
			        <?php endif;?>

			<?php
					//dificultades para llenar vacantes
					$results_dificultades = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 35 limit 1");	

					if( $results_dificultades ) : 

						$region_value_dificultades = array();

						$region_title_dificultades = array();

						$regions = json_decode($results_dificultades[0]->data, true);
						
						$i=0;

						foreach($regions as $region){
							
							if( $region['data']['region'] == $title_region ){

							
								$region_value_dificultades[$i] = $region['data']['value'];

								$region_title_dificultades[$i] = $region['data']['title'];

								$region_name_dificultades[$i] = $region['data']['name'];							

								$i++;

							}	
						}

				$results_link = $wpdb->get_results("SELECT id_occupation, code_job_position from cl_job_positions where name_job_position = '".$region_title_dificultades[0]."'");
				$results_link_a = $wpdb->get_results("SELECT id_occupation, code_job_position from cl_job_positions where name_job_position = '".$region_title_dificultades[1]."'");
				$results_link_b = $wpdb->get_results("SELECT id_occupation, code_job_position from cl_job_positions where name_job_position = '".$region_title_dificultades[2]."'");

						if ( !empty( $region_title_dificultades ) ):

				?>
							<div class="col-12">
				                <div class="bloque-cabecera">
				                    <div class="linea"><i class="iconcl-ocupacion"></i></div>
				                    <h2>Conocimientos mas requeridos en una ocupacion </h2>
				                    <p>Conocimientos con mayor numero de vacantes en la region</p>
				                </div>
				            </div>    
				            <div class="col-12 col-lg-8 offset-lg-2">
				                <div class="bloque-barra">
				                    <div class="bloque-progress">
				                        <p><?php echo $region_title_dificultades[0]; ?></p>
				                        <div class="progress">
				                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"><?php echo $region_name_dificultades[0]; ?></div>
				                        </div>
				                        
				                        <a href="<?php echo get_site_url().'/ocupacion-detalle/puesto-de-trabajo/?code_job_position='.$results_link[0]->code_job_position.'&id_occupation='.$results_link[0]->id_occupation.'/' ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
				                    </div>
				                    <div class="bloque-progress">
				                        <p><?php echo $region_title_dificultades[1]; ?></p>
				                        <div class="progress">
				                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"><?php echo $region_name_dificultades[1]; ?></div>
				                        </div>
				                        <a href="<?php echo get_site_url().'/ocupacion-detalle/puesto-de-trabajo/?code_job_position='.$results_link[1]->code_job_position.'&id_occupation='.$results_link_a[1]->id_occupation.'/' ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
				                    </div>
				                    <div class="bloque-progress">
				                        <p><?php echo $region_title_dificultades[2]; ?></p>
				                        <div class="progress">
				                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"><?php echo $region_name_dificultades[2]; ?></div>
				                        </div>
				                        <a href="<?php echo get_site_url().'/ocupacion-detalle/puesto-de-trabajo/?code_job_position='.$results_link[2]->code_job_position.'&id_occupation='.$results_link_b[2]->id_occupation.'/' ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
				                    </div>
				                  			                   
				                </div>
				            </div>
			        	<?php endif;?>
			        <?php endif;?>
			    <?php
					//canales 
					$results_canales = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 37 limit 1");


					if( $results_canales ) : 

						$region_value_canales = array();

					

						$regions = json_decode($results_canales[0]->data, true);
				
						$i=0;

						foreach($regions as $region){
							
							if( $region['data']['region'] == $title_region ){
							
								$region_value_canales[$i] = $region['data']['value'];

								

								$region_name_canales[$i] = $region['data']['name'];							

								$i++;

							}	
						}
							
						if ( !empty( $region_name_canales ) ):
				?>
							<div class="col-12">
				                <div class="bloque-cabecera">
				                    <div class="linea"><i class="iconcl-ocupacion"></i></div>
				                    <h2>Canales de reclutamiento mas utilizados </h2>
				                    <p>Canales de reclutamiento mas utilizados en la region</p>
				                </div>
				            </div>    
				            <div class="col-12 col-lg-8 offset-lg-2">
				                <div class="bloque-barra">
				                    <div class="bloque-progress">
				                        
				                        <div class="progress">
				                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"><?php echo $region_name_canales[0]; ?></div>
				                        </div>
				                        
				                    </div>
				                    <div class="bloque-progress">
				                        
				                        <div class="progress">
				                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"><?php echo $region_name_canales[1]; ?></div>
				                        </div>
				                        
				                    </div>
				                    <div class="bloque-progress">
				                       
				                        <div class="progress">
				                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"><?php echo $region_name_canales[2]; ?></div>
				                        </div>
				                    </div>	                   
				                </div>
				            </div>
			        	<?php endif;?>
			         <?php endif;?>

			   <?php
					//top 10 ocupados
					$results_top_ocupados = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 1 limit 1");

					if( $results_top_ocupados ) : 

						$region_value = array();

						$region_title = array();

						$regions  = json_decode($results_top_ocupados[0]->data, true);
						
						$i=0;

						foreach($regions as $region){
							
							if( $region['data']['region'] == $title_region ){

								$region_value[$i] = $region['data']['value'];

								$region_title[$i] = $region['data']['title'];							

								$i++;

							}	
						}

						$value 	 = number_format($region_value[0], 1, ',', '.');
						$value_a = number_format($region_value[1], 1, ',', '.');
						$value_b = number_format($region_value[2], 1, ',', '.');
						$value_c = number_format($region_value[3], 1, ',', '.');
						$value_d = number_format($region_value[4], 1, ',', '.');
						$value_e = number_format($region_value[5], 1, ',', '.');
						$value_f = number_format($region_value[6], 1, ',', '.');
						$value_g = number_format($region_value[7], 1, ',', '.');
						$value_h = number_format($region_value[8], 1, ',', '.');
						$value_i = number_format($region_value[9], 1, ',', '.');
					
						$results_link = $wpdb->get_results("SELECT id_sector code from cl_sectors where name_sector = '".$region_title[0]."'");
						$code = $results_link[0]->code;

						$results_link_a = $wpdb->get_results("SELECT id_sector code from cl_sectors where name_sector = '".$region_title[1]."'");
						$code_a = $results_link_a[0]->code;

						$results_link_b = $wpdb->get_results("SELECT id_sector code from cl_sectors where name_sector = '".$region_title[2]."'");
						$code_b = $results_link_b[0]->code;

						$results_link_c = $wpdb->get_results("SELECT id_sector code from cl_sectors where name_sector = '".$region_title[3]."'");
						$code_c = $results_link_c[0]->code;

						$results_link_d = $wpdb->get_results("SELECT id_sector code from cl_sectors where name_sector = '".$region_title[4]."'");
						$code_d = $results_link_d[0]->code;

						$results_link_e = $wpdb->get_results("SELECT id_sector code from cl_sectors where name_sector = '".$region_title[5]."'");
						$code_e = $results_link_e[0]->code;

						$results_link_f = $wpdb->get_results("SELECT id_sector code from cl_sectors where name_sector = '".$region_title[6]."'");
						$code_f = $results_link_f[0]->code;

						$results_link_g = $wpdb->get_results("SELECT id_sector code from cl_sectors where name_sector = '".$region_title[7]."'");
						$code_g = $results_link_g[0]->code;

						$results_link_h = $wpdb->get_results("SELECT id_sector code from cl_sectors where name_sector = '".$region_title[8]."'");
						$code_h = $results_link_h[0]->code;

						$results_link_i = $wpdb->get_results("SELECT id_sector code from cl_sectors where name_sector = '".$region_title[9]."'");
						$code_i = $results_link_i[0]->code;

						if ( !empty( $region_title[$i] ) ):

				?> 				
						<div class="col-12">
			                <div class="bloque-cabecera">
			                    <div class="linea"><i class="iconcl-ocupacion"></i></div>
			                    <h2>Sectores mas ocupados</h2>
			                    <p>Sectores más demandados en las bolsas de empleo en esta region</p>
			                </div>
			            </div>    
			            <div class="col-12 col-lg-8 offset-lg-2">
			                <div class="bloque-barra">
			                    <div class="bloque-progress">
			                        <p><?php echo $region_title[0]; ?></p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $region_value[0]; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value; ?>%</div>
			                        </div>
			                        <a href="<?php echo get_site_url().'/sector-detalle/'.$code; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                    <div class="bloque-progress">
			                        <p><?php echo $region_title[1]; ?></p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $region_value[1]; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value_a; ?>%</div>
			                        </div>
			                        <a href="<?php echo get_site_url().'/sector-detalle/'.$code_a; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                    <div class="bloque-progress">
			                        <p><?php echo $region_title[2]; ?></p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $region_value[2]; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value_b; ?>%</div>
			                        </div>
			                        <a href="<?php echo get_site_url().'/sector-detalle/'.$code_b; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                    <div class="bloque-progress">
			                        <p><?php echo $region_title[3]; ?></p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $region_value[3]; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value_c; ?>%</div>
			                        </div>
			                        <a href="<?php echo get_site_url().'/sector-detalle/'.$code_c; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                    <div class="bloque-progress">
			                        <p><?php echo $region_title[4]; ?></p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $region_value[4]; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value_d; ?>%</div>
			                        </div>
			                        <a href="<?php echo get_site_url().'/sector-detalle/'.$code_d; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                    <div class="bloque-progress">
			                        <p><?php echo $region_title[5]; ?></p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $region_value[5]; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value_e; ?>%</div>
			                        </div>
			                        <a href="<?php echo get_site_url().'/sector-detalle/'.$code_e; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                    <div class="bloque-progress">
			                        <p><?php echo $region_title[6]; ?></p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $region_value[6]; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value_f; ?>%</div>
			                        </div>
			                        <a href="<?php echo get_site_url().'/sector-detalle/'.$code_f; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                    <div class="bloque-progress">
			                        <p><?php echo $region_title[7]; ?></p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $region_value[7]; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value_g; ?>%</div>
			                        </div>
			                        <a href="<?php echo get_site_url().'/sector-detalle/'.$code_g; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                    <div class="bloque-progress">
			                        <p><?php echo $region_title[8]; ?></p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $region_value[8]; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value_h; ?>%</div>
			                        </div>
			                        <a href="<?php echo get_site_url().'/sector-detalle/'.$code_h; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>
			                    <div class="bloque-progress">
			                        <p><?php echo $region_title[9]; ?></p>
			                        <div class="progress">
			                            <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $region_value[9]; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value_i; ?>%</div>
			                        </div>
			                        <a href="<?php echo get_site_url().'/sector-detalle/'.$code_I; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
			                    </div>    
			                    <div class="bloque-boton">
			                        <a href="<?php echo get_site_url().'/sectores-productivos'?>" class="btn btn-yellow">Ver más sectores</a>
			                    </div>
			                </div>
			            </div>
			        <?php endif;?>
			        <?php endif;?>
			          
			            </div>
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