<?php
/* Template name: Page sectores productivos */
	get_header(); 

	$post_content_oc = 12;//This is page id or post id 
    $content_post = get_post($post_content_oc);
    $content = $content_post->post_content;
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);

  
    $m_meta_description = get_post_meta($post->ID, 'm_meta_description', true);
?>
<div class="bloque-titular">
    <div class="container">
        <h1>Sectores productivos</h1>
        <div class="filtros-titular">
           	<!--<a href="#" class="openFiltroSector">Elige un sector <i class="fal fa-filter"></i></a>-->
            <a href="#" class="openFiltroRegion">Elige una región <i class="fal fa-filter"></i></a>
        </div>
    </div>
</div>
<div class="container">
            <div class="banners-home-buscar banner-ocupaciones">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="banner-item">
                            <img src="../wp-content/themes/chilevalora/images/banner-botton-sectores-productivos.jpg" class="img-fluid" alt="Ocupaciones">
                            <div class="banner-datos">
                                <div class="resumen">
                                    <p ><?php echo $content; ?></p>
                                </div>
                                <form action="#">
                                    <div class="input-group">
                                        <input class=" form-control  border-right-0 border" id="buscar_sectores" type="search" value="" data-toggle="collapse" href="#collapse1" placeholder="Escribe aquí la sector que buscas...">
                                        <span class="input-group-append">
                                            <button disabled class="btn btn-outline-secondary border-left-0 border">
                                                <i class="far fa-search fa-flip-horizontal"></i>
                                            </button>
                                          </span>
                                    </div>
                                </form>
                                <div class="list-group" id="sector_search">
                                    <div id="collapse1" class="panel-collapse collapse">
                                        <ul class="list-group">
                                        <!--Contenido Ajax -->
                                        </ul>       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<div class="container">
    <div class="row">
        <!-- BLOQUE PODIO -->
        
        
            <?php
                //Sectores con mayor crecimiento en el nº de ocupados en todo el territorio nacional    
				$results = 	$wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 48 limit 1"); 

               // var_dump($results);

                if( $results ) : 

                    $array  = 	json_decode($results[0]->data, true); 

                    $results_link = $wpdb->get_results("SELECT id_sector code from cl_sectors where name_sector = '".$array[0]["data"]["title"]."'");

                    $code 	= $results_link[0]->code;

                    $results_link_u = $wpdb->get_results("SELECT id_sector code_u from cl_sectors where name_sector = '".$array[1]["data"]["title"]."'");
                    $code_u = $results_link_u[0]->code_u;

                    $results_link_d = $wpdb->get_results("SELECT id_sector code_d from cl_sectors where name_sector = '".$array[2]["data"]["title"]."'");
                    $code_d = $results_link_d[0]->code_d;

                    $value   = number_format($array[0]['data']['value'], 1, ',', '.');
                    $value_u = number_format($array[1]['data']['value'], 1, ',', '.');
                    $value_d = number_format($array[2]['data']['value'], 1, ',', '.');

		    ?>
                    <!-- mobile -->
                <div class="bloque-podio">
                    <div class="intro">
                        <div class="icono"><i class="iconcl-podium-xl"></i></div>
                        <h2>Número de ocupados</h2>
                        <p>Sectores con mayor crecimiento en el nº de ocupados en todo el territorio nacional <a href="#popover" data-container="body" data-toggle="popover" data-placement="top" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus."><i class="fas fa-question-circle"></i></a></p>
                    </div>
                    <!-- CARRUSEL PODIO -->
                    <div class="container">
                            <div class="owl-carousel owl-theme">
                                <div class="col-12 col-md-6 item">
                                    <div class="bloque-indicador">
                                        <div class="grafica-circulo">
                                            <span class="indicador-icon"><i class="iconcl-puesto1"></i></span>
                                            <a href="<?php echo get_site_url().'/sector-detalle/'.$code; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                            <a href="<?php echo get_site_url().'/sector-detalle/'.$code; ?>">
                                                <svg class="radial-progress" data-percentage="<?php echo $array[0]["data"]["value"]; ?>" viewBox="0 0 80 80">
                                                <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                                <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                                <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value; ?>%</text>
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="text">
                                            <a href="<?php echo get_site_url().'/sector-detalle/'.$code; ?>" class="title"><?php echo $array[0]["data"]["title"]; ?></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 item">
                                    <div class="bloque-indicador">
                                        <div class="grafica-circulo">
                                            <span class="indicador-icon"><i class="iconcl-puesto2"></i></span>
                                            <a href="<?php echo get_site_url().'/sector-detalle/'.$code_u; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                            <a href="<?php echo get_site_url().'/sector-detalle/'.$code_u; ?>">
                                                <svg class="radial-progress" data-percentage="<?php echo $array[1]["data"]["value"]; ?>" viewBox="0 0 80 80">
                                                <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                                <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                                <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value_u; ?>%</text>
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="text">
                                            <a href="<?php echo get_site_url().'/sector-detalle/'.$code_u; ?>" class="title"><?php echo $array[1]["data"]["title"];?></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 item">
                                    <div class="bloque-indicador">
                                        <div class="grafica-circulo">
                                            <span class="indicador-icon"><i class="iconcl-puesto3"></i></span>
                                            <a href="<?php echo get_site_url().'/sector-detalle/'.$code_d; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                            <a href="<?php echo get_site_url().'/sector-detalle/'.$code_d; ?>">
                                                <svg class="radial-progress" data-percentage="<?php echo $array[2]["data"]["value"]; ?>" viewBox="0 0 80 80">
                                                <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                                <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                                <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value_d; ?>%</text>
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="text">
                                            <a href="<?php echo get_site_url().'/sector-detalle/'.$code_d; ?>" class="title"><?php echo $array[2]["data"]["title"]; ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- FIN CARRUSEL PODIO -->
                            <!-- Desktop -->
                            <div class="row owl-desktop">
                                <div class="col-4 owl-desktop">
                                    <div class="bloque-indicador">
                                        <div class="grafica-circulo">
                                            <span class="indicador-icon"><i class="iconcl-puesto1"></i></span>
                                            <a href="<?php echo get_site_url().'/sector-detalle/'.$code; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                            <a href="<?php echo get_site_url().'/sector-detalle/'.$code; ?>">
                                                <svg class="radial-progress" data-percentage="<?php echo $array[0]["data"]["value"]; ?>" viewBox="0 0 80 80">
                                                <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                                <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                                <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value;?>%</text>
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="text">
                                            <a href="<?php echo get_site_url().'/sector-detalle/'.$code; ?>" class="title"><?php echo $array[0]["data"]["title"]; ?></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 owl-desktop">
                                    <div class="bloque-indicador">
                                        <div class="grafica-circulo">
                                            <span class="indicador-icon"><i class="iconcl-puesto2"></i></span>
                                            <a href="<?php echo get_site_url().'/sector-detalle/'.$code_u; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                            <a href="<?php echo get_site_url().'/sector-detalle/'.$code_u; ?>">
                                                <svg class="radial-progress" data-percentage="<?php echo $array[1]["data"]["value"]; ?>" viewBox="0 0 80 80">
                                                <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                                <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                                <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value_u; ?>%</text>
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="text">
                                            <a href="<?php echo get_site_url().'/sector-detalle/'.$code_u; ?>" class="title"><?php echo $array[1]["data"]["title"]; ?></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 owl-desktop">
                                    <div class="bloque-indicador">
                                        <div class="grafica-circulo">
                                            <span class="indicador-icon"><i class="iconcl-puesto3"></i></span>
                                            <a href="<?php echo get_site_url().'/sector-detalle/'.$code_d; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                            <a href="<?php echo get_site_url().'/sector-detalle/'.$code_d; ?>">
                                                <svg class="radial-progress" data-percentage="<?php echo $array[2]["data"]["value"]; ?>" viewBox="0 0 80 80">
                                                <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                                <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                                <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value_d; ?>%</text>
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="text">
                                            <a href="<?php echo get_site_url().'/sector-detalle/'.$code_d; ?>" class="title"><?php echo $array[2]["data"]["title"]; ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- FIN BLOQUE PODIO -->
		          <?php endif;?>
		
                </div>
        <!-- Termino Indicador -->

                
        <!-- Comienzo indicador -->
        <!-- BLOQUE CABECERA -->
        <div class="col-12 jnsn">
            <div class="bloque-cabecera">
                <div class="linea"><i class="iconcl-mujeres"></i></div>
                <h2>Mujeres</h2>
                <p>Sectores con mayor porcentaje de mujeres en todo el territorio nacional</p>
                </div>
        </div>
        <!-- FIN BLOQUE CABECERA -->
        <!-- BLOQUE BARRA DISTRIBUTIBA -->
        <div class="col-12 col-lg-8 offset-lg-2">
            <div class="bloque-barra">
                <?php
                    //Sectores con mayor porcentaje de mujeres en todo el territorio nacional
					$results = 	$wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 58 limit 1");

                    if( $results ) : 

    	                $array  = 	json_decode($results[0]->data, true);

    					$results_link = $wpdb->get_results("SELECT id_sector code from cl_sectors where name_sector = '".$array[0]["data"]["title"]."'");
    					$code 	= $results_link[0]->code;

    					$results_link_u = $wpdb->get_results("SELECT id_sector code_u from cl_sectors where name_sector = '".$array[1]["data"]["title"]."'");
    					$code_u = $results_link_u[0]->code_u;

    				    $results_link_d = $wpdb->get_results("SELECT id_sector code_d from cl_sectors where name_sector = '".$array[2]["data"]["title"]."'");
    	                $code_d = $results_link_d[0]->code_d;
    	                                          
    	                $results_link_t = $wpdb->get_results("SELECT id_sector code_t from cl_sectors where name_sector = '".$array[3]["data"]["title"]."'");
                        $code_t = $results_link_t[0]->code_t; 
                        
                        $value   = number_format($array[0]['data']['value'], 1, ',', '.');
                        $value_u = number_format($array[1]['data']['value'], 1, ',', '.');
                        $value_d = number_format($array[2]['data']['value'], 1, ',', '.');
                        $value_t = number_format($array[3]['data']['value'], 1, ',', '.');
                    
                ?>
                        <!-- BLOQUE BARRA DISTRIBUTIBA -->
        				<div class="bloque-progress">
                            <p><?php echo $array[0]["data"]["title"]; ?></p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $array[0]["data"]["value"]; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value; ?>%</div>
                            </div>
                            <a href="<?php echo get_site_url().'/sector-detalle/'.$code; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                        </div>
                        <div class="bloque-progress">
                            <p><?php echo $array[1]["data"]["title"]; ?></p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $array[1]["data"]["value"]; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value_u; ?>%</div>
                            </div>
                            <a href="<?php echo get_site_url().'/sector-detalle/'.$code_u; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                        </div>                    
                        <div class="bloque-progress">
                            <p><?php echo $array[2]["data"]["title"]; ?></p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $array[2]["data"]["value"]; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value_d; ?>%</div>
                            </div>
                            <a href="<?php echo get_site_url().'/sector-detalle/'.$code_d; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                        </div>
                        <div class="bloque-progress">
                            <p><?php echo $array[3]["data"]["title"]; ?></p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $array[3]["data"]["value"]; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value_t; ?>%</div>
                            </div>
                            <a href="<?php echo get_site_url().'/sector-detalle/'.$code_t; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                        </div>
	            <?php endif;?>
            </div>
        </div>
        <!-- FIN BLOQUE BARRA DISTRIBUTIBA -->
        <!-- Termino indicador -->

        <!-- Comienzo indicador -->
        <!-- BLOQUE CABECERA -->
        <div class="col-12">
            <div class="bloque-cabecera">
                <div class="linea"><i class="iconcl-migrante"></i></div>
                <h2>Migrantes</h2>
                <p>Sectores con mayor porcentaje de migrantes en todo el territorio nacional</p>
            </div>
        </div>
        <!-- FIN BLOQUE CABECERA -->
        <!-- BLOQUE INDICADORES DISTRIBUTIVA -->

        <?php
            //Sectores con mayor porcentaje de migrantes en todo el territorio nacional
            $results = 	$wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 56 limit 1");
          
            if( $results ) : 

                $array  = 	json_decode($results[0]->data, true); 

                $results_link = $wpdb->get_results("SELECT id_sector code from cl_sectors where name_sector = '".$array[0]["data"]["title"]."'");
                $code 	= $results_link[0]->code;

                $results_link_u = $wpdb->get_results("SELECT id_sector code_u from cl_sectors where name_sector = '".$array[1]["data"]["title"]."'");
                $code_u = $results_link_u[0]->code_u;

                $results_link_d = $wpdb->get_results("SELECT id_sector code_d from cl_sectors where name_sector = '".$array[2]["data"]["title"]."'");
                $code_d = $results_link_d[0]->code_d;
                                    
                $results_link_t = $wpdb->get_results("SELECT id_sector code_t from cl_sectors where name_sector = '".$array[3]["data"]["title"]."'");
                $code_t = $results_link_t[0]->code_t;  

                $value   = number_format($array[0]['data']['value'], 1, ',', '.');
                $value_u = number_format($array[1]['data']['value'], 1, ',', '.');
                $value_d = number_format($array[2]['data']['value'], 1, ',', '.');
                $value_t = number_format($array[3]['data']['value'], 1, ',', '.');
        ?>

                <!-- BLOQUE INDICADORES DISTRIBUTIVA -->
                <!--Mobile-->
                <div class="bloque-indicadores-distributiva">
                    <div class="owl-carousel owl-theme">
                        <div class="col-12 col-md-6 item">
                            <div class="bloque-indicador">
                                <div class="grafica-circulo">
                                    <a href="<?php echo get_site_url().'/sector-detalle/'.$code; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                    <a href="<?php echo get_site_url().'/sector-detalle/'.$code; ?>">
                                        <svg class="radial-progress" data-percentage="<?php echo $array[0]["data"]["value"]; ?>" viewBox="0 0 80 80">
                                        <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                        <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                        <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value; ?>%</text>
                                        </svg>
                                    </a>
                                </div>
                                <div class="text">
                                    <a href="<?php echo get_site_url().'/sector-detalle/'.$code; ?>" class="title"><?php echo $array[0]["data"]["title"]; ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 item">
                            <div class="bloque-indicador">
                                <div class="grafica-circulo">
                                    <a href="<?php echo get_site_url().'/sector-detalle/'.$code_u; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                    <a href="<?php echo get_site_url().'/sector-detalle/'.$code_u; ?>">
                                        <svg class="radial-progress" data-percentage="<?php echo $array[1]["data"]["value"]; ?>" viewBox="0 0 80 80">
                                        <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                        <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                        <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php  echo $value_u; ?>%</text>
                                        </svg>
                                    </a>
                                </div>
                                <div class="text">
                                    <a href="<?php echo get_site_url().'/sector-detalle/'.$code_u; ?>" class="title"><?php echo $array[1]["data"]["title"]; ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 item">
                            <div class="bloque-indicador">
                                <div class="grafica-circulo">
                                    <a href="<?php echo get_site_url().'/sector-detalle/'.$code_d; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                    <a href="<?php echo get_site_url().'/sector-detalle/'.$code_d; ?>">
                                        <svg class="radial-progress" data-percentage="<?php  echo $array[2]["data"]["value"]; ?>" viewBox="0 0 80 80">
                                        <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                        <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                        <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value_d; ?>%</text>
                                        </svg>
                                    </a>
                                </div>
                                <div class="text">
                                    <a href="<?php echo get_site_url().'/sector-detalle/'.$code_d; ?>" class="title"><?php echo $array[2]["data"]["title"]; ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 item">
                            <div class="bloque-indicador">
                                <div class="grafica-circulo">
                                    <a href="<?php echo get_site_url().'/sector-detalle/'.$code_t; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                    <a href="<?php echo get_site_url().'/sector-detalle/'.$code_t; ?>">
                                        <svg class="radial-progress" data-percentage="<?php echo $array[3]["data"]["value"]; ?>" viewBox="0 0 80 80">
                                        <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                        <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                        <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value_t ?>%</text>
                                        </svg>
                                    </a>
                                </div>
                                <div class="text">
                                    <a href="<?php echo get_site_url().'/sector-detalle/'.$code_t; ?>" class="title"><?php echo $array[3]["data"]["title"]; ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Desktop-->
                <div class="col-12 col-xl-10 offset-xl-1">
                    <div class="row owl-desktop justify-content-center">
                        <div class="col-2 col-sm-6 col-lg-3 col-xl-3">
                            <div class="bloque-indicador">
                                <div class="grafica-circulo">
                                    <a href="<?php echo get_site_url().'/sector-detalle/'.$code; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                    <a href="<?php echo get_site_url().'/sector-detalle/'.$code; ?>">
                                        <svg class="radial-progress" data-percentage="<?php echo $array[0]["data"]["value"]; ?>" viewBox="0 0 80 80">
                                        <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                        <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                        <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value; ?>%</text>
                                        </svg>
                                    </a>
                                </div>
                                <div class="text">
                                    <a href="<?php echo get_site_url().'/sector-detalle/'.$code; ?>" class="title"><?php echo $array[0]["data"]["title"]; ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 col-sm-6 col-lg-3 col-xl-3">
                            <div class="bloque-indicador">
                                <div class="grafica-circulo">
                                    <a href="<?php echo get_site_url().'/sector-detalle/'.$code_u; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                    <a href="<?php echo get_site_url().'/sector-detalle/'.$code_u; ?>">
                                        <svg class="radial-progress" data-percentage="<?php echo $array[1]["data"]["value"]; ?>" viewBox="0 0 80 80">
                                        <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                        <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                        <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value_u; ?>%</text>
                                        </svg>
                                    </a>
                                </div>
                                <div class="text">
                                    <a href="<?php echo get_site_url().'/sector-detalle/'.$code_u; ?>" class="title"><?php echo $array[1]["data"]["title"]; ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 col-sm-6 col-lg-3 col-xl-3">
                            <div class="bloque-indicador">
                                <div class="grafica-circulo">
                                    <a href="<?php echo get_site_url().'/sector-detalle/'.$code_d; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                    <a href="<?php echo get_site_url().'/sector-detalle/'.$code_d; ?>">
                                        <svg class="radial-progress" data-percentage="<?php echo $array[2]["data"]["value"]; ?>" viewBox="0 0 80 80">
                                        <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                        <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                        <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value_d; ?>%</text>
                                        </svg>
                                    </a>
                                </div>
                                <div class="text">
                                    <a href="<?php echo get_site_url().'/sector-detalle/'.$code_d; ?>" class="title"><?php echo $array[2]["data"]["title"]; ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 col-sm-6 col-lg-3 col-xl-3">
                            <div class="bloque-indicador">
                                <div class="grafica-circulo">
                                    <a href="<?php echo get_site_url().'/sector-detalle/'.$code_t; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                    <a href="<?php echo get_site_url().'/sector-detalle/'.$code_t; ?>">
                                        <svg class="radial-progress" data-percentage="<?php echo $array[3]["data"]["value"]; ?>" viewBox="0 0 80 80">
                                        <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                        <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                        <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value_t; ?>%</text>
                                        </svg>
                                    </a>
                                </div>
                                <div class="text">
                                    <a href="<?php echo get_site_url().'/sector-detalle/'.$code_t; ?>" class="title"><?php echo $array[3]["data"]["title"]; ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- FIN BLOQUE INDICADORES DISTRIBUTIVA -->
            <?php endif;?>
                                  
            <?php
                //Sectores con mayor porcentaje de contratos indefinidos en todo el territorio nacional
                $results = 	$wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 50 limit 1");	 

                    if( $results ) : 
                
                    $array  = 	json_decode($results[0]->data, true); 

                    $results_link = $wpdb->get_results("SELECT id_sector code from cl_sectors where name_sector = '".$array[0]["data"]["title"]."'");
                    $code 	= $results_link[0]->code;


                    $results_link_u = $wpdb->get_results("SELECT id_sector code_u from cl_sectors where name_sector = '".$array[1]["data"]["title"]."'");
                    $code_u = $results_link_u[0]->code_u;
                    
            
                    $results_link_d = $wpdb->get_results("SELECT id_sector code_d from cl_sectors where name_sector = '".$array[2]["data"]["title"]."'");
                    $code_d = $results_link_d[0]->code_d;

                    $results_link_t = $wpdb->get_results("SELECT id_sector code_t from cl_sectors where name_sector = '".$array[3]["data"]["title"]."'");
                    $code_t = $results_link_t[0]->code_t;

                    $value   = number_format($array[0]['data']['value'], 1, ',', '.');

                    $value_u = number_format($array[1]['data']['value'], 1, ',', '.');

                    $value_d = number_format($array[2]['data']['value'], 1, ',', '.');
                    
                    $value_t = number_format($array[3]['data']['value'], 1, ',', '.');

            ?>
                <!-- BLOQUE CABECERA -->
                    <div class="col-12">
                        <div class="bloque-cabecera">
                            <div class="linea"><i class="iconcl-contratos"></i></div>
                            <h2>Contratos indefinidos</h2>
                            <p>Sectores con mayor porcentaje de contratos indefinidos en todo el territorio nacional</p>
                            </div>
                    </div>
                <!-- FIN BLOQUE CABECERA -->
                <!-- BLOQUE BARRA DISTRIBUTIBA -->
                    <div class="col-12 col-lg-8 offset-lg-2">
                        <div class="bloque-progress">
                            <p><?php echo $array[0]["data"]["title"]?></p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $array[0]["data"]["value"];?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value;?>%</div>
                            </div>
                            <a href="<?php echo get_site_url().'/sector-detalle/'.$code; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                        </div>
                        <div class="bloque-progress">
                                <p><?php echo $array[1]["data"]["title"]?></p>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $array[1]["data"]["value"];?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value_u;?>%</div>
                                </div>
                                <a href="<?php echo get_site_url().'/sector-detalle/'.$code_u; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                        </div>
                        <div class="bloque-progress">
                            <p><?php echo $array[2]["data"]["title"]?></p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $array[2]["data"]["value"];?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value_d;?>%</div>
                            </div>
                            <a href="<?php echo get_site_url().'/sector-detalle/'.$code_d; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                        </div>
                        <div class="bloque-progress">
                            <p><?php echo $array[3]["data"]["title"]?></p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $array[3]["data"]["value"];?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value_t;?>%</div>
                            </div>
                            <a href="<?php echo get_site_url().'/sector-detalle/'.$code_t; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                        </div>
                    </div>
                    <!-- FIN BLOQUE BARRA DISTRIBUTIBA -->           
            <?php endif;?>
       
        <?php
            //Sector con mayor incorporación de nuevos trabajadores
            $results = 	$wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 55 limit 1");
        
            if( $results ) :

                $array  = 	json_decode($results[0]->data, true); 

                $results_link = $wpdb->get_results("SELECT id_sector code from cl_sectors where name_sector = '".$array[0]["data"]["title"]."'");
                $code 	= $results_link[0]->code; 
        ?>

                <!-- BLOQUE ICONO -->
                <div class="col-12">
                    <div class="bloque-icono">
                        <div class="row">
                            <div class="col-sm-12 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
                                <div class="icono">
                                    <a href="<?php echo get_site_url().'/sector-detalle/'.$code; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>                                
                                    <i class="iconcl-puesto1-xl"></i>
                                </div>
                                <div class="text">
                                    <a href="<?php echo get_site_url().'/sector-detalle/'.$code; ?>" class="title"><?php echo $array[0]["data"]["title"]; ?></a>
                                    <p>Sector con mayor incorporación de nuevos trabajadores en el ultimo año <a href="#popover" data-container="body" data-toggle="popover" data-placement="top" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus."><i class="fas fa-question-circle"></i></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FIN BLOQUE ICONO -->
            <?php endif;?>
		    

        </div>
            <div class="row parrafo-texto">
                <div class="col-xs-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2">
                    <p class="text-justify"><?php echo 'TEXTO ENRIQUECIDO: ' . $m_meta_description;; ?></p>
                </div>
            </div>
    </div>
				

<?php
	get_footer();
?>