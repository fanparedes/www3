<?php
	/* Template name: Ocupación detalle: Puestos de trabajo */
	global $id_occupation;

	$code_job_position = esc_html(get_query_var('code_job_position'));
	$id_occupation = esc_html(get_query_var('id_occupation'));
	
    $job_position = array_shift($wpdb->get_results("
    									SELECT id_occupation, name_job_position, digital 
    									FROM cl_job_positions 
    									WHERE code_job_position = '" . $code_job_position . "' "));
  	
  	//Determinar si la ocupación es digital 
  	/*$occupation_type = postgresToBool($job_position->digital);
   
	if( $occupation_type ): */?>
	
		<?php

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
		<?php		

			$value = str_replace("/", "", $id_occupation);

			$occupations = $wpdb->get_results("SELECT name_occupation from cl_occupations where id_occupation = '".$value."' ");

			$occupation_name = $occupations[0]->name_occupation;

			$results = $wpdb->get_results("SELECT cl_occupations.name_occupation o_name, cl_job_positions.name_job_position j_name, cl_job_positions.description j_desc, code_job_position code
			FROM cl_occupations
			LEFT JOIN cl_job_positions 
			ON cl_occupations.id_occupation = cl_job_positions.id_occupation
			WHERE cl_job_positions.name_job_position = '".$job_position->name_job_position."'
			ORDER BY random()");

			$suggest = $wpdb->get_results('SELECT  name_occupation titulo, description descripcion, id_occupation id FROM cl_occupations ORDER BY  random() LIMIT 3');

			$link = $wpdb->get_results("SELECT co.id_occupation from cl_occupations co
                                        left join cl_job_positions cjp
                                        on co.id_occupation = cjp.id_occupation
                                        where name_job_position = '".$job_position->name_job_position."'");

		?>
		
    			<div class="bloque-titular">
			        <div class="container">
		
			            <h1><?php echo $job_position->name_job_position; ?></h1>
			        </div>
			    </div>
    			<!-- BLOQUE TABS -->
			    <div class="bloque-tabs">
			        <div class="container">
			            <div class="d-none d-sm-block">
			                <ul class="nav nav-tabs">
			                    <li class="nav-item">
			                        <a class="nav-link active" href="<?php echo get_site_url().'/ocupacion-detalle/puesto-de-trabajo/?code_job_position='.$code_job_position.'&id_occupation='.$id_occupation; ?>">Resumen</a>
			                    </li>
			                    <li class="nav-item">
									<?php 
									$masInformacionUrl =  get_site_url() . '/ocupacion-mas-info/'. $link[0]->id_occupation;  ?>
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
	                        		<h2><?php echo $job_position->name_job_position;?></h2>
	                    		</div>
								<div class="col-12 col-lg-10">
									<?php echo $results[0]->j_desc; ?>
								</div>
			        		</div>
			    		</div>
			            <!-- FIN BLOQUE TEXTO -->
						<!-- BLOQUE ICONO -->

					<?php
			    		//24
			    		$results_job_position = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 24 limit 1");

			    		if( $results_job_position ):

							$occupations = json_decode($results_job_position[0]->data, true); 
							
							foreach($occupations as $occupation){
								if( $occupation['data']['title'] == $job_position->name_job_position ){
									$occupation_value_ranking = $occupation['data']['value'];	
								}
					        } 

							if ( !empty( $occupation_value_ranking ) ):
							$value   = number_format($occupation_value_ranking, 1, ',', '.');
					?> 
								<div class="col-12 col-md-6">
									<div class="bloque-indicador">
										<div class="grafica-circulo">
											<a class="icon-plus"><i class="fal fa-plus"></i></a>
											<a href="#">
												<svg class="radial-progress" data-percentage="<?php echo $occupation_value_ranking;?>" viewBox="0 0 80 80">
												<circle class="incomplete" cx="40" cy="40" r="35"></circle>
												<circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
												<text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value;?>%</text>
												</svg>
											</a>
										</div>
										<div class="text">
											<a class="title"><?php echo $job_position->name_job_position; ?></a>
											<p>Porcentaje de las ofertas de empleo que citan esta ocupación en las bolsas de empleo</p>
										</div>
									</div>
								</div>
							<?php endif; ?>
						<?php endif; ?>
						<!-- BLOQUE GRUPO INDICADORES DESKTOP -->
				 
						
					<?php
			    		//ranking ocupaciones dificiles de llenar
			    		$results_vacantes = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 63 limit 1");
			    	
			    		if( $results_vacantes ):

							$occupations_vacantes = json_decode($results_vacantes[0]->data, true); 
					
							foreach($occupations_vacantes as $occupation){
								if( $occupation['data']['title'] == $job_position->name_job_position ){
									$value_vacantes = $occupation['data']['value'];
									$title_vacantes = $occupation['data']['title'];
								}
					        } 
							
							if ( !empty( $title_vacantes ) ):
					?> 
			            <div class="col-12">
			                <div class="bloque-icono">
			                    <div class="row">
			                        <div class="col-sm-12 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
			                            <div class="icono">
			                                  
			                                <i class="iconcl-ocupacion-xl"></i>
			                            </div>
			                            <div class="text">
			                                <span class="title"><?php echo $title_vacantes; ?></span>
			                                <p>Es una de las ocupaciones con mayor dificultad para llenar vacantes a nivel nacional</p>
			                            </div>
			                        </div>
			                    </div>
			                </div>
						</div>
						<?php endif; ?>
					<?php endif; ?>
					<?php
							//Dificultades para llenar vacantes de los puestos de trabajo
							$results_dificultad = 	$wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 64 limit 1");
							
							if( $results_dificultad ) : 
							
								$occupations_dificultad = json_decode($results_dificultad[0]->data, true);
								foreach($occupations_dificultad as $occupation){
									if( $occupation['data']['title'] == $job_position->name_job_position ){
										$value_dificultad = $occupation['data']['value'];
										$title_dificultad = $occupation['data']['title'];
									}	
								}


								if ( !empty( $title_dificultad ) ):										
						?>
									<div class="col-12 col-md-6">
										<div class="bloque-icono">
											<div class="row">
												<div class="col-md-12 ">
													<div class="icono">
														  
														<i class="iconcl-ocupacion-xl"></i>
													</div>
													<div class="text">
														<span class="title"><?php echo $title_dificultad; ?></span>
														<p>Es la ocupacion con mayor dificultad para llenar vacantes</p>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php endif;?>	
							<?php endif;?>

						<?php
							//HABILIDADES O COMPETENCIAS BUSCADAS EN UNA OCUPACIÓN
							$results_abilities = 	$wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 65 limit 1");
							
							if( $results_abilities ) : 
							
								$occupations_abilities = json_decode($results_abilities[0]->data, true);
								
								foreach($occupations as $occupation){
									if( $occupation['data']['title'] == $job_position->name_job_position ){
										$value_abilities = $occupation['data']['value'];
										$title_abilities = $occupation['data']['title'];
										$name_abilities = $occupation['data']['name'];
									}	
								}


								if ( !empty( $title_abilities ) ):										
						?>
									<div class="col-12 col-md-6">
										<div class="bloque-icono">
											<div class="row">
												<div class="col-md-12 ">
													<div class="icono">
					
														<i class="iconcl-ocupacion-xl"></i>
													</div>
													<div class="text">
														<span class="title"><?php echo $title_abilities; ?></span>
														<p><?php echo $name_abilities ; ?> es el conocimiento que mas se requiere en esta ocupacion</p>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php endif;?>	
							<?php endif;?>

						<?php
							//CANALES DE RECLUTAMIENTO POR OCUPACIÓN
							$results_canales = 	$wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 66 limit 1");
						
							if( $results_canales ) : 
							
								$occupations_canales = json_decode($results_canales[0]->data, true);
								foreach($occupations as $occupation){
									if( $occupation['data']['title'] == $title_ocupacion ){
										$value_canales = $occupation['data']['value'];
										$title_canales = $occupation['data']['title'];
										$name_canales = $occupation['data']['name'];
									}	
								}

								if ( !empty( $title_canales ) ):										
						?>
									<div class="col-12 col-md-6">
										<div class="bloque-icono">
											<div class="row">
												<div class="col-md-12 ">
													<div class="icono">
														    
														<i class="iconcl-ocupacion-xl"></i>
													</div>
													<div class="text">
														<span class="title"><?php echo $title_canales; ?></span>
														<p><?php echo  $name_canales ?> es el medio de reclutamiento mas utilizado en esta ocupacion</p>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php endif;?>	
							<?php endif;?>
			
			
				<div class="col-12">
					<div class="bloque-titular">
						<h2>Datos comunes para <?php echo $occupation_name; ?></h2>
					</div>
				</div>
				<?php
						//mediana salarial
						$results = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 61 limit 1");
						
						if( $results ):

							$occupations = json_decode($results[0]->data, true); 

							foreach($occupations as $occupation){
								if( $occupation['data']['title'] == $occupation_name ){
									$occupation_value = $occupation['data']['value'];	
								}
							} 
								$value = $occupation_value * 0.000001;
								$total = substr($value, 0, 3);
					       
							if ( !empty( $occupation_value ) ): 
								$value   = number_format($total, 1, ',', '.');
					?>   
					        		
							<div class="col-12 col-md-6 owl-desktop">
								<div class="bloque-indicador-dato">
									<div class="grafica-circulo">
										<span class="indicador-icon"><i class="iconcl-ingresos"></i></span>
										<a class="icon-plus"><i class="fal fa-plus"></i></a>
										<a >
											<svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
											<circle class="complete" cx="40" cy="40" r="35"></circle>
											<text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">$<?php echo $value; ?>M</text>
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

							$occupations = json_decode($results_mujeres[0]->data, true); 

							foreach($occupations as $occupation){
								if( $occupation['data']['title'] == $occupation_name ){
									$occupation_value_mujeres = $occupation['data']['value'];	
								}
					        } 
					       
							if ( !empty( $occupation_value_mujeres ) ): 
								$value   = number_format($occupation_value_mujeres, 1, ',', '.');
					?>   
					        		
							<div class="col-12 col-md-6 owl-desktop">
								<div class="bloque-indicador">
									<div class="grafica-circulo">
										<span class="indicador-icon"><i class="iconcl-mujeres"></i></span>
										<a class="icon-plus"><i class="fal fa-plus"></i></a>
										<a >
											<svg class="radial-progress" data-percentage="<?php echo $occupation_value_mujeres; ?>" viewBox="0 0 80 80">
											<circle class="incomplete" cx="40" cy="40" r="35"></circle>
											<circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
											<text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value; ?>%</text>
											</svg>
										</a>
									</div>
									<div class="text">
										<a class="title">Mujeres</a>
										<p>Porcentaje de mujeres emploeadas en <?php echo $occupation_name; ?>  a nivel nacional en el último periodo</p>
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
								if( $occupation['data']['title'] == $occupation_name ){
									$occupation_value = $occupation['data']['value'];	
								}
					        } 
					       
							if ( !empty( $occupation_value ) ):
								$value   = number_format($occupation_value, 1, ',', '.'); 
					?>   
					        		
							<div class="col-12 col-md-6 owl-desktop">
								<div class="bloque-indicador">
									<div class="grafica-circulo">
										<span class="indicador-icon"><i class="iconcl-contratos"></i></span>
										<a class="icon-plus"><i class="fal fa-plus"></i></a>
										<a>
											<svg class="radial-progress" data-percentage="<?php echo $occupation_value; ?>" viewBox="0 0 80 80">
											<circle class="incomplete" cx="40" cy="40" r="35"></circle>
											<circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
											<text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value; ?>%</text>
											</svg>
										</a>
									</div>
									<div class="text">
										<a class="title">Contratos indefinidos</a>
										<p>Porcentaje de contratos indefinidos para <?php echo $occupation_name; ?> a nivel nacional en el último periodo</p>
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
								if( $occupation['data']['title'] == $occupation_name ){
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
			                            <a  class="icon-plus"><i class="fal fa-plus"></i></a>
			                            <a >
			                                <svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
			                                <circle class="complete" cx="40" cy="40" r="35"></circle>
			                                <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">$<?php echo $value; ?>M</text>
			                                </svg>
			                            </a>
			                        </div>
			                        <div class="text">
			                            <a class="title">Mediana salarial</a>
			                            <p>Mediana salarial de los <?php echo $occupation_name; ?> a nivel nacional en el último periodo</p>
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
											<a class="icon-plus"><i class="fal fa-plus"></i></a>
											<a >
												<svg class="radial-progress" data-percentage="<?php echo $occupation_value_mujeres; ?>" viewBox="0 0 80 80">
												<circle class="incomplete" cx="40" cy="40" r="35"></circle>
												<circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
												<text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value; ?>%</text>
												</svg>
											</a>
										</div>
										<div class="text">
											<a class="title">Mujeres</a>
											<p>Porcentaje de mujeres empleadas <?php echo $occupation_name; ?>  en el último periodo</p>
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
			                            <a class="icon-plus"><i class="fal fa-plus"></i></a>
			                            <a>
			                                <svg class="radial-progress" data-percentage="<?php echo $occupation_value; ?>" viewBox="0 0 80 80">
			                                <circle class="incomplete" cx="40" cy="40" r="35"></circle>
			                                <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
			                                <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value; ?>%</text>
			                                </svg>
			                            </a>
			                        </div>
			                        <div class="text">
			                            <a class="title">Contratos indefinidos</a>
			                            <p>Porcentaje de contratos indefinidos para <?php echo $occupation_name; ?> a nivel nacional en el último periodo</p>
			                        </div>
			                    </div>
			                </div>

							<?php endif;?>	
						<?php endif;?>		   
			</div>
					    
			    <?php get_template_part('buscador-ocupaciones'); ?>

				</div>
      		</div>
      		<?php 
      		
      		$value = str_replace("/", "", $id_occupation);

      		$results = $wpdb->get_results("SELECT cjp.code_job_position code, name_job_position j_name, description j_desc, number_offer::float * 100 /( select sum(number_offer) from cl_job_positions_offers ) as total 
				from cl_job_positions cjp
				left join cl_job_positions_offers cjpo
				on cjp.code_job_position = cjpo.code_job_position
				where id_occupation = '".$value."'
				group by cjp.code_job_position, cjp.name_job_position, cjp.description, cjpo.number_offer
				order by random() "); ?>
			 	
	  <div class="bloque-blanco">
        <div class="container">
            <div class="bloque-columnas">
                <h2>Ocupaciones relacionadas con <?php echo $job_position->name_job_position; ?></h2>
                <div class="row">

                    <div class="col-12 col-md-4 pb-auto" >
                        <h3><a href="<?php echo get_site_url().'/ocupacion-detalle/'.$id_occupation.'/?code_job_position=/'.$results[0]->code; ?>"><?php echo $results[0]->j_name; ?></a></h3>
                        <p style="text-align:justify;"><?php echo $results[0]->j_desc; ?></p>
                       <div class="bloque-progress">
                         
                        <?php if ($results[0]->total == 0 ) :?>

      							<p class="font-italic">Sin informacion<p>
                                         
                        <?php else: ?>
                        	<p>Demanda</p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $results[0]->total; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo number_format($results[0]->total, 1, ',', '.'); ?>%</div>
                            </div>

                            

                        <?php endif;?>
                        </div> 
                    </div>

                    <div class="col-12 col-md-4 pb-auto" >
                        <h3><a href="<?php echo get_site_url().'/ocupacion-detalle/'.$id_occupation.'/?code_job_position=/'.$results[1]->code; ?>"><?php echo $results[1]->j_name; ?></a></h3>
                        <p style="text-align:justify;"><?php echo $results[1]->j_desc; ?></p>
                        <div class="bloque-progress">
                      
                        <?php if ($results[1]->total == 0 ) :?>
      
                                <p class="font-italic">Sin informacion<p>
                            
                        <?php else: ?>
                        	<p>Demanda</p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $results[1]->total; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo number_format($results[1]->total, 1, ',', '.'); ?>%</div>
                            </div>

                           

                        <?php endif;?> 
                        </div> 
                    </div>

                    <div class="col-12 col-md-4 pb-auto" >
                        <h3><a href="<?php echo get_site_url().'/ocupacion-detalle/'.$id_occupation.'/?code_job_position=/'.$results[2]->code; ?>"><?php echo $results[2]->j_name; ?></a></h3>
                        <p style="text-align:justify; "><?php echo $results[2]->j_desc; ?></p>
                         <div class="bloque-progress">
                        

                        <?php if ($results[2]->total == 0 ) :?>
      
                                <p class="font-italic">Sin informacion<p>
                            
                        <?php else: ?>
                        	<p>Demanda</p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $results[2]->total; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo number_format($results[2]->total, 1, ',', '.'); ?>%</div>
                            </div>

                   

                        <?php endif; ?>
                            
                        </div>
                    </div>
                </div>

                    <div class="collapse" id="collapseOcupaciones">
                        <div class="row">

                            <div class="col-12 col-md-4 pb-auto" >
                            <h3><a href="<?php echo get_site_url().'/ocupacion-detalle/'.$id_occupation.'/?code_job_position=/'.$results[3]->code; ?>"><?php echo $results[3]->j_name; ?></a></h3>
                            <p style="text-align: justify;"><?php echo $results[3]->j_desc; ?></p>
                                 <div class="bloque-progress">
                                    
                            <?php if ($results[3]->total == 0 ) :?>
      
                                <p class="font-italic">Sin informacion<p>
                            
	                        <?php else: ?>
	                        	<p>Demanda</p>
	                            <div class="progress">
	                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $results[3]->total; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo number_format($results[3]->total, 1, ',', '.'); ?>%</div>
	                            </div>


	                        <?php endif;?>
                                </div>
                            </div>

                   <div class="col-12 col-md-4 pb-auto" >
                        <h3><a href="<?php echo get_site_url().'/ocupacion-detalle/'.$id_occupation.'/?code_job_position=/'.$results[4]->code; ?>"><?php echo $results[4]->j_name; ?></a></h3>
                        <p style="text-align:justify;"><?php echo $results[4]->j_desc; ?></p>
                        <div class="bloque-progress">
                           

                            <?php if ($results[4]->total == 0 ) :?>
      
                                <p class="font-italic">Sin informacion<p>
                            
                        	<?php else: ?>
                        	<p>Demanda</p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $results[4]->total; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo number_format($results[4]->total, 1, ',', '.'); ?>%</div>
                            </div>
 

                        	<?php endif;?>
                    	</div>
                    </div>   

                    <div class="col-12 col-md-4 pb-auto" >
                        <h3><a href="<?php echo get_site_url().'/ocupacion-detalle/'.$id_occupation.'/?code_job_position=/'.$results[5]->code; ?>"><?php echo $results[5]->j_name; ?></a></h3>
                            <p style="text-align:justify;"><?php echo $results[5]->j_desc; ?></p>
                        <div class="bloque-progress">
                          
                            <?php if ($results[5]->total == 0 ) :?>
      
                                <p class="font-ilatic">Sin informacion<p>
                            
                    		<?php else: ?>
                        	<p>Demanda</p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $results[5]->total; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo number_format($results[5]->total, 1, ',', '.'); ?>%</div>
                            </div>


                       		<?php endif;?>
                        </div> 
                    </div>

                    <div class="col-12 col-md-4 pb-auto" >
                        <h3><a href="<?php echo get_site_url().'/ocupacion-detalle/'.$id_occupation.'/?code_job_position=/'.$results[6]->code; ?>"><?php echo $results[6]->j_name; ?></a></h3>
                        	<p style="text-align:justify;"><?php echo $results[6]->j_desc; ?></p>
                     	<div class="bloque-progress">
                           
                        	<?php if ($results[6]->total == 0 ) :?>
      
                                <p class="font-italic">Sin informacion<p>
                            
                    		<?php else: ?>
                        	<p>Demanda</p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $results[6]->total; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo number_format($results[6]->total, 1, ',', '.'); ?>%</div>
                            </div>


                       		<?php endif;?>
                        </div> 
                    </div>

                    <div class="col-12 col-md-4 pb-auto" >
                            <h3><a href="<?php echo get_site_url().'/ocupacion-detalle/'.$id_occupation.'/?code_job_position=/'.$results[7]->code; ?>"><?php echo $results[7]->j_name; ?></a></h3>
                            <p style="text-align:justify;"><?php echo $results[7]->j_desc; ?></p>
                        <div class="bloque-progress">
                            	
                                <?php if ($results[7]->total == 0 ) :?>
      
                            		<p class="font-italic">Sin informacion<p>
                            
                    			<?php else: ?>
                        		<p>Demanda</p>
		                        <div class="progress">
		                            <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $results[7]->total; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo number_format($results[7]->total, 1, ',', '.'); ?>%</div>
		                        </div>

                       		<?php endif;?>
                        </div> 
                    </div>

                        </div>
                    </div>
                    <div class="bloque-boton">
                        <a data-toggle="collapse" href="#collapseOcupaciones" role="button" aria-expanded="false" aria-controls="collapseOcupaciones" data-txtalt="Ver menos ocupaciones relacionadas" class="btn btn-yellow">Ver más ocupaciones relacionadas</a>
                    </div>
                </div>
            <!-- FIN 3 COLUMNAS -->
        </div>
    </div>
	<div class="col-12 d-block d-sm-none">
        <div class="bloque-boton">
            <a href="<?php echo get_site_url().'/ocupaciones/'; ?>" class="btn btn-arrow btn-block">Ver más información</a>
        </div>
    </div>
    <!-- FIN BOTON SOLO MÓVIL -->
    <!-- BLOQUE AMARILLO -->
    <div class="bloque-amarillo">
        <div class="container">
            <!-- 3 COLUMNAS -->
            <div class="bloque-columnas">
                <h2>También te puede interesar</h2>
                <div class="row">
                    <div style="padding-bottom: 20px;" class="col-12 col-md-4">
                        <h3><a href="<?php echo get_site_url().'/ocupacion-detalle/'.$suggest[0]->id; ?>"><?php echo $suggest[0]->titulo; ?></a></h3>
                        <p style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; text-align: justify;"><?php echo $suggest[0]->descripcion; ?></p>
                    </div>
                    <div style="padding-bottom: 20px;"  class="col-12 col-md-4">
                        <h3><a href="<?php echo get_site_url().'/ocupacion-detalle/'.$suggest[1]->id; ?>"><?php echo $suggest[1]->titulo; ?></a></h3>
                        <p style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; text-align: justify;"><?php echo $suggest[1]->descripcion ?></p>
                    </div>
                    <div style="padding-bottom: 20px;"  class="col-12 col-md-4">
                        <h3><a href="<?php echo get_site_url().'/ocupacion-detalle/'.$suggest[2]->id; ?>"><?php  echo $suggest[2]->titulo; ?></a></h3>
                        <p style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; text-align: justify;"><?php echo $suggest[2]->descripcion; ?></p>
                    </div>
                </div>
            </div>
            <!-- FIN 3 COLUMNAS -->
                </div>
             </div>
        </div>
    </div>
	
	
	    <!-- FIN BLOQUE AMARILLO -->
			    <!-- BOTON SOLO MÓVIL -->
			    <div class="col-12 d-block d-sm-none">
			        <div class="bloque-boton">
			            <a href="<?php echo get_site_url().'/ocupaciones/' ?>" class="btn btn-arrow btn-block">Ver más información</a>
			        </div>
			    </div>
			    <!-- FIN BOTON SOLO MÓVIL -->
	
	<?php //else: 

	/*$parent_page 	= get_page_by_title('Ocupacion Detalle');
	$page_url		= get_page_link($parent_page->ID);
	$redirect_url = $page_url . '/' . $job_position->id_occupation.'/?code_job_position='.$code_job_position;
	
	header('location:' . $redirect_url );

	endif */?>	
				
			<?php
			get_footer();

       
	
?>