<?php
    get_header();
    global $wpdb;

    $post_content_oc = 14;//This is page id or post id 16regiones 12sectores
    $content_post = get_post($post_content_oc);
    $content = $content_post->post_content;
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);

  
    $m_meta_description = get_post_meta($post->ID, 'm_meta_description', true);

 
?>
            <div class="bloque-titular">
                <div class="container">
                    <h1>Ocupaciones</h1>
                    <!--<div class="filtros-titular">
                        <a href="#modal" class="openFiltroOcupacion">Elige una ocupación <i class="fal fa-filter"></i></a>
                    </div> -->
                </div>
            </div>
        <div class="container">
            <div class="banners-home-buscar banner-ocupaciones">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="banner-item">
                            <img src="../wp-content/themes/chilevalora/images/banner-botton-ocupaciones.jpg" class="img-fluid" alt="Ocupaciones">
                            <div class="banner-datos">
                                <div class="resumen">
                                    <p><?php echo $content; ?></p>
                                </div>
                                <form action="#">
                                    <div class="input-group">
                                        <input class=" form-control  border-right-0 border" id="buscar_ocupaciones" type="search" value="" data-toggle="collapse" href="#collapse1" placeholder="Escribe aquí la ocupación que buscas...">
                                        <span class="input-group-append">
                                            <button disabled class="btn btn-outline-secondary border-left-0 border">
                                                <i  class="far fa-search fa-flip-horizontal"></i>
                                            </button>
                                          </span>
                                    </div>
                                </form>
                                <div class="list-group" id="ocupacion_search">
                                    <div id="collapse1" class="panel-collapse collapse">
                                             
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Comienzo indicador Ocupaciones Top 3 -->

        <?php 

            $fuente =  $wpdb->get_results("SELECT MAX(ano) FROM cl_busy_casen");
            $min =  $wpdb->get_results("SELECT MIN(ano) FROM cl_busy_casen");


            $results =  $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 46 limit 1");


            
            if( $results ) : 

                $array  = 	json_decode($results[0]->data , true); 

                
                
                $results_link = $wpdb->get_results("SELECT id_occupation code from cl_occupations where name_occupation  = '".$array[0]["data"]["title"]."'");
                $code 	= $results_link[0]->code;

                $results_link_u = $wpdb->get_results("SELECT id_occupation code_u from cl_occupations where name_occupation = '".$array[1]["data"]["title"]."'");
                $code_u = $results_link_u[0]->code_u;

                $results_link_d = $wpdb->get_results("SELECT id_occupation code_d from cl_occupations where name_occupation = '".$array[2]["data"]["title"]."'");
                $code_d = $results_link_d[0]->code_d; 

                $value   = number_format($array[0]['data']['value'], 1, ',', '.');
                $value_u = number_format($array[1]['data']['value'], 1, ',', '.');
                $value_d = number_format($array[2]['data']['value'], 1, ',', '.');
        ?>
            
            
            
            <div class="container">
                <div class="row">
                    <div class="bloque-podio">
                <div class="intro">
                    <div class="icono"><i class="iconcl-podium-xl"></i></div>
                    <h2>Ocupaciones más demandadas</h2>
                    <p>Ocupaciones mas demandadas en las bolsas de empleo a nivel nacional en el último periodo <a href="#popover" data-container="body" data-toggle="popover" data-placement="top" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus."><i class="fas fa-question-circle"></i></a></p>
                    <p>Fuente de datos: CASEN <?php echo($fuente[0]->max); ?> </p>
                </div>
  
                <div class="owl-carousel owl-theme">
                    <div class="col-12 col-md-6 item">
                        <div class="bloque-indicador">
                            <div class="grafica-circulo">
                                <span class="indicador-icon"><i class="iconcl-puesto1"></i></span>
                                <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code;?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code;?>">
                                    <svg class="radial-progress" data-percentage="<?php echo $array[0]['data']['value']; ?>" viewBox="0 0 80 80">
                                    <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                    <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                    <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value ?></text>
                                    </svg>
                                </a>
                            </div>
                                <div class="text">
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code;?>" class="title"><?php echo $array[0]["data"]["title"]; ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 item">
                            <div class="bloque-indicador">
                                <div class="grafica-circulo">
                                    <span class="indicador-icon"><i class="iconcl-puesto2"></i></span>
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code_u;?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code_u;?>">
                                        <svg class="radial-progress" data-percentage="<?php echo $array[1]['data']['value'] ?>" viewBox="0 0 80 80">
                                        <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                        <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                        <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value_u ?>%</text>
                                        </svg>
                                    </a>
                                </div>
                                <div class="text">
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code_u;?>" class="title"><?php echo $array[1]["data"]["title"]; ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 item">
                            <div class="bloque-indicador">
                                <div class="grafica-circulo">
                                    <span class="indicador-icon"><i class="iconcl-puesto3"></i></span>
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code_d;?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code_d;?>">
                                        <svg class="radial-progress" data-percentage="<?php echo $array[2]['data']['value'] ?>" viewBox="0 0 80 80">
                                        <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                        <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                        <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value_d; ?>%</text>
                                        </svg>
                                    </a>
                                </div>
                                <div class="text">
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code_d;?>" class="title"><?php echo $array[2]["data"]["title"]; ?></a>
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
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code;?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code;?>">
                                        <svg class="radial-progress" data-percentage="<?php echo $array[0]['data']['value']; ?>" viewBox="0 0 80 80">
                                        <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                        <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                        <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value; ?>%</text>
                                        </svg>
                                    </a>
                                </div>
                                <div class="text">
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code;?>" class="title"><?php echo  $array[0]["data"]["title"];?></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 owl-desktop">
                            <div class="bloque-indicador">
                                <div class="grafica-circulo">
                                    <span class="indicador-icon"><i class="iconcl-puesto2"></i></span>
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code_u;?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code_u;?>">
                                        <svg class="radial-progress" data-percentage="<?php echo $array[1]['data']['value']; ?>" viewBox="0 0 80 80">
                                        <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                        <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                        <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value_u; ?>%</text>
                                        </svg>
                                    </a>
                                </div>
                                <div class="text">
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code_u;?>" class="title"><?php echo $array[1]["data"]["title"]; ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 owl-desktop">
                            <div class="bloque-indicador">
                                <div class="grafica-circulo">
                                    <span class="indicador-icon"><i class="iconcl-puesto3"></i></span>
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code_d;?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code_d;?>">
                                        <svg class="radial-progress" data-percentage="<?php echo $array[2]['data']['value']; ?>" viewBox="0 0 80 80">
                                        <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                        <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                        <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value_d; ?>%</text>
                                        </svg>
                                    </a>
                                </div>
                                    <div class="text">
                                        <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code_d;?>" class="title"><?php echo $array[2]["data"]["title"]; ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                           <!--  <div class="bloque-boton">
                                <a href="<?php echo get_site_url().'/ocupaciones'; ?>" class="btn btn-yellow">Ver más ocupaciones</a>
                            </div>
 -->                    </div>
                    <!-- FIN BLOQUE PODIO -->
                </div>
                <hr>
            <?php endif;?>
            <!--termina indicador -->
           
            
             <!-- BLOQUE TITULAR -->
            <div class="col-12">
                <div class="bloque-titular">
                    <h2>Demanda por regiones</h2>
                </div>
            </div>
            <!-- //FIN BLOQUE TITULAR 
             //BLOQUE MAPA  -->
            <div class="col-12">
                <style>
                  * {
                    box-sizing: border-box;
                    margin: 0;
                    padding: 0;
                  }

                  html,
                  body {
                    width: 100%;
                    height: 100%;
                  }
              
                  #fundacion-telefonica-employment {
                    width: 100%;
                    height: 100%;
                    position: absolute;
                    overflow: hidden;
                    display: flex;
                  }
                </style>
                <noscript>
                  <strong>We're sorry but fundacion-telefonica-employment doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
                </noscript>
                
                <div id="fundacion-telefonica-employment"></div>
                <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/fundacion-telefonica-employment.css">
                <script src="<?php echo get_template_directory_uri(); ?>/js/fundacion-telefonica-employment.js"></script>
                <script>
                  function getData(url) {
                    return fetch('<?php echo get_template_directory_uri(); ?>/data/' + url)
                    .then(res => res.json())
                  }

                  function getDataR(url) {
                   

                    if(url=='digitales'){
                        return fetch('<?php echo get_site_url(); ?>/wp-json/wp/v2/digitales_json/')
                        .then(res => res.json())
                    }
                    if(url=='nodigitales'){
                        return fetch('<?php echo get_site_url(); ?>/wp-json/wp/v2/nodigitales_json/')
                        .then(res => res.json())
                    }
                    if(url=='habilidades'){
                        return fetch('<?php echo get_site_url(); ?>/wp-json/wp/v2/habilidades_json/')
                        .then(res => res.json())
                    }
                            
                  }
                  
                  Promise.all([
                     getData('config.json'),
                    // getData('digitales.json'),
                    // getData('habilidades.json'),
                    // getData('nodigitales.json')
                    getDataR('digitales'),
                    getDataR('habilidades'),
                    getDataR('nodigitales')
                  ])
                  .then(([
                    config,
                    jobs,
                    skills,
                    noDigital
                  ]) => {
                    const el = new FundacionTelefonicaEmployment('#fundacion-telefonica-employment', {
                      config,
                      component: 'Map',
                      data: [
                        jobs,
                        skills,
                        noDigital,
                      ]
                    })
                  })
                </script>
            </div>
            <!-- FIN BLOQUE MAPA -->

            <!--Comienzo indicador Mediana Salarial Top 3 -->

        <?php 
            $results =  $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 61 limit 1");

            if( $results ) :

				$array  = 	json_decode($results[0]->data , true); 

                //var_dump($array);die;

                $results_link = $wpdb->get_results("SELECT id_occupation code from cl_occupations where name_occupation = '".$array[0]["data"]["title"]."'");
                $code 	= $results_link[0]->code;

                $results_link_u = $wpdb->get_results("SELECT id_occupation code_u from cl_occupations where name_occupation = '".$array[1]["data"]["title"]."'");
                $code_u = $results_link_u[0]->code_u;
                
                $results_link_d = $wpdb->get_results("SELECT id_occupation code_d from cl_occupations where name_occupation = '".$array[2]["data"]["title"]."'");
                $code_d = $results_link_d[0]->code_d; 
                
                $value = $array[0]["data"]["value"] * 0.000001;
                $total = substr($value, 0, 3);

                
                $value_u = $array[1]["data"]["value"] * 0.000001;
                $total_u = substr($value_u, 0, 3);


                $value_d = $array[2]["data"]["value"] * 0.000001;
                $total_d = substr($value_d, 0, 3);

        ?> 
                <div class="col-12">
                    <div class="bloque-cabecera">
                        <div class="linea"><i class="iconcl-ingresos"></i></div>
                        <h2>Ingresos</h2>
                        <p>Ocupaciones con mayores ingresos mensuales</p>
                    </div>
                </div>

                <div class="bloque-indicadores-distributiva">
                    <div class="owl-carousel owl-theme">
                        <div class="col-12 col-md-6 item">
                            <div class="bloque-indicador-dato">
                                <div class="grafica-circulo">
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code; ?>">
                                        <svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
                                        <circle class="complete" cx="40" cy="40" r="35"></circle>
                                        <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">$<?php echo $total ?>M</text>
                                        </svg>
                                    </a>
                                </div>
                                <div class="text">
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code; ?>" class="title"><?php echo $array[0]["data"]["title"]; ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 item">
                            <div class="bloque-indicador-dato">
                                <div class="grafica-circulo">
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code_u; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code_u; ?>">
                                        <svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
                                        <circle class="complete" cx="40" cy="40" r="35"></circle>
                                        <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">$<?php echo $total_u; ?>M</text>
                                        </svg>
                                    </a>
                                </div>
                                <div class="text">
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code_u; ?>" class="title"><?php echo $array[1]["data"]["title"]; ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 item">
                            <div class="bloque-indicador-dato">
                                <div class="grafica-circulo">
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code_d; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code_d; ?>">
                                        <svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
                                        <circle class="complete" cx="40" cy="40" r="35"></circle>
                                        <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">$<?php echo $total_d; ?>M</text>
                                        </svg>
                                    </a>
                                </div>
                                <div class="text">
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code_d; ?>" class="title"><?php echo $array[2]["data"]["title"]; ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Desktop-->
                    <div class="row owl-desktop justify-content-center">
                        <div class="col-2 col-sm-6 col-md-4">
                            <div class="bloque-indicador-dato">
                                <div class="grafica-circulo">
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code; ?>">
                                        <svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
                                        <circle class="complete" cx="40" cy="40" r="35"></circle>
                                        <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">$<?php echo $total; ?>M</text>
                                        </svg>
                                    </a>
                                </div>
                                <div class="text">
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code; ?>" class="title"><?php echo $array[0]["data"]["title"]; ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 col-sm-6 col-md-4">
                            <div class="bloque-indicador-dato">
                                <div class="grafica-circulo">
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code_u; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code_u; ?>">
                                        <svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
                                        <circle class="complete" cx="40" cy="40" r="35"></circle>
                                        <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">$<?php echo $total_u; ?>M</text>
                                        </svg>
                                    </a>
                                </div>
                                <div class="text">
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code_u; ?>" class="title"><?php echo $array[1]["data"]["title"]?></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 col-sm-6 col-md-4">
                            <div class="bloque-indicador-dato">
                                <div class="grafica-circulo">
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code_d; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code_d; ?>">
                                        <svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
                                        <circle class="complete" cx="40" cy="40" r="35"></circle>
                                        <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">$<?php echo $total_d; ?>M</text>
                                        </svg>
                                    </a>
                                </div>
                                <div class="text">
                                    <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code_d; ?>" class="title"><?php echo $array[2]["data"]["title"]?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif;?>
        <!-- Termino Indicador -->
        
         <!-- Comienzo indicador contratos indefinidos-->
  

        <?php 
            $results =  $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 47 limit 1");

            if( $results ) : 

                $array  = 	json_decode($results[0]->data, true); 

                $results_link = $wpdb->get_results("SELECT id_occupation code from cl_occupations where name_occupation = '".$array[0]["data"]["title"]."'");
                $code 	= $results_link[0]->code;

                $results_link_u = $wpdb->get_results("SELECT id_occupation code_u from cl_occupations where name_occupation = '".$array[1]["data"]["title"]."'");
                $code_u = $results_link_u[0]->code_u;
                    
                $results_link_d = $wpdb->get_results("SELECT id_occupation code_d from cl_occupations where name_occupation = '".$array[2]["data"]["title"]."'");
                $code_d = $results_link_d[0]->code_d; 

                $value   = number_format($array[0]['data']['value'], 1, ',', '.');
                $value_u = number_format($array[1]['data']['value'], 1, ',', '.');
                $value_d = number_format($array[2]['data']['value'], 1, ',', '.');
        ?>  
                <div class="col-12">
                    <div class="bloque-cabecera">
                        <div class="linea"><i class="iconcl-contratos"></i></div>
                        <h2>Contratos Indefinidos</h2>
                        <p>Ocupaciones con mayor porcentaje de contratos indefinidos a nivel nacional</p>
                        <p>Fuente de datos: CASEN <?php echo($fuente[0]->max); ?></p>
                    </div>
                </div>

                <div class="col-12 col-lg-8 offset-lg-2">
                    <div class="bloque-barra">
                        <div class="bloque-progress">
                            <p><?php echo $array[0]["data"]["title"]; ?></p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $array[0]['data']['value'];?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value;?>%</div>
                            </div>
                        <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                    </div>
                    <div class="bloque-progress">
                        <p><?php echo $array[1]["data"]["title"]; ?></p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $array[1]['data']['value'];?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value_u;?>%</div>
                        </div>
                        <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code_u; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                    </div>
                    <div class="bloque-progress">
                        <p><?php echo $array[2]["data"]["title"]; ?></p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $array[2]['data']['value'];?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value_d;?>%</div>
                        </div>
                        <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code_d; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                        </div>
                    </div>
                </div>
            <?php endif;?>
        <!-- Termino Indicador -->

        <!-- Comienzo indicador mujeres -->
        <?php 
            $results =  $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 60 limit 1");

            if( $results ) : 

                $array  = 	json_decode($results[0]->data, true); 

                $results_link = $wpdb->get_results("SELECT id_occupation code from cl_occupations where name_occupation = '".$array[0]["data"]["title"]."'");
                $code 	= $results_link[0]->code;

                $results_link_u = $wpdb->get_results("SELECT id_occupation code_u from cl_occupations where name_occupation = '".$array[1]["data"]["title"]."'");
                $code_u = $results_link_u[0]->code_u;

                $results_link_d = $wpdb->get_results("SELECT id_occupation code_d from cl_occupations where name_occupation = '".$array[2]["data"]["title"]."'");
                $code_d = $results_link_d[0]->code_d;  

                $value   = number_format($array[0]['data']['value'], 1, ',', '.');
                $value_u = number_format($array[1]['data']['value'], 1, ',', '.');
                $value_d = number_format($array[2]['data']['value'], 1, ',', '.');
        ?>
            
                <div class="col-12">
                    <div class="bloque-cabecera">
                        <div class="linea"><i class="iconcl-mujeres"></i></div>
                        <h2>Mujeres</h2>
                        <p>Ocupaciones con mayor porcentaje de mujeres en todo el territorio nacional</p>
                        <p>Fuente de datos: CASEN <?php echo($fuente[0]->max); ?></p>
                    </div>
                </div>

                <div class="col-12 col-lg-8 offset-lg-2">
                    <div class="bloque-barra">
                        <div class="bloque-progress">
                            <p><?php echo $array[0]["data"]["title"]; ?></p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $array[0]['data']['value']; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value; ?>%</div>
                            </div>
                            <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                        </div>
                        <div class="bloque-progress">
                            <p><?php echo $array[1]["data"]["title"]; ?></p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $array[1]['data']['value']; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value_u; ?>%</div>
                            </div>
                            <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code_u; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                        </div>
                        <div class="bloque-progress">
                            <p><?php echo $array[2]["data"]["title"]; ?></p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $array[2]['data']['value']; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value_d; ?>%</div>
                            </div>
                            <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code_d; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                        </div>
                    </div>
                </div>
            <?php endif;?>
        <!-- Termino Indicador -->
  

         <?php 

            $results =    $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 71 limit 1");
         
            if( $results ) : 

                $array  = 	json_decode($results[0]->data, true); 

                $results_link = $wpdb->get_results("SELECT id_occupation code from cl_occupations where name_occupation = '".$array[0]["data"]["title"]."'");
                $code 	= $results_link[0]->code; 

        ?>
                <!-- BLOQUE ICONO -->
                <div class="col-12">
                        <div class="bloque-icono">
                            <div class="row">
                                <div class="col-sm-12 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
                                    <div class="icono">
                                        <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                        <i class="iconcl-crecimiento-xl"></i>
                                    </div>
                                    <div class="text">
                                        <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$code; ?>" class="title"><?php echo $array[0]["data"]["title"]; ?></a>
                                        <p>Ocupación con mayor tasa de crecimiento de ocupados entre periodo <?php echo($fuente[0]->max."-".$min[0]->min); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- FIN BLOQUE ICONO -->
            <?php endif;?>

           
         <!-- Termina Indicador -->

         <?php 
                $results =  $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 14 limit 1");
            
                if( $results ) : 

                    $array   = json_decode($results[0]->data , true); 


                    $value   = number_format($array[0]['data']['value'], 1, ',', '.');
                    $value_a = number_format($array[1]['data']['value'], 1, ',', '.');
                    $value_b = number_format($array[2]['data']['value'], 1, ',', '.');
                    $value_c = number_format($array[3]['data']['value'], 1, ',', '.');
                    $value_d = number_format($array[4]['data']['value'], 1, ',', '.');
                    $value_e = number_format($array[5]['data']['value'], 1, ',', '.');
                    $value_f = number_format($array[6]['data']['value'], 1, ',', '.');
                    $value_g = number_format($array[7]['data']['value'], 1, ',', '.');
                    $value_h = number_format($array[8]['data']['value'], 1, ',', '.');
                    $value_i = number_format($array[9]['data']['value'], 1, ',', '.');

            ?>
                        <div class="col-12">
                            <div class="bloque-cabecera">
                                <div class="linea"><i class="iconcl-habilidades"></i></div>
                                <h2>Conocimiento más solicitados</h2>
                                <p>Conocimiento más solicitados en las bolsas de empleo</p>
                                <p>Fuente de datos telefónica. Periodo Enero – Marzo 2020</p>
                            </div>
                        </div>
                            <!-- FIN BLOQUE CABECERA -->
                            <!-- BLOQUE BARRA DISTRIBUTIBA -->
                            <div class="col-12 col-lg-8 offset-lg-2">
                                <div class="bloque-barra">
                                    <div class="bloque-progress">
                                        <p><?php echo $array[0]['data']['title']; ?></p>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $array[0]['data']['value']; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value; ?>%</div>
                                        </div>
                                    
                                    </div>
                                    <div class="bloque-progress">
                                        <p><?php echo $array[1]['data']['title']; ?></p>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $array[1]['data']['value']; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value_a; ?>%</div>
                                        </div>
                                     
                                    </div>
                                    <div class="bloque-progress">
                                        <p><?php echo $array[2]['data']['title']; ?></p>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $array[2]['data']['value']; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value_b; ?>%</div>
                                        </div>
                                   
                                    </div>
                                    <div class="bloque-progress">
                                        <p><?php echo $array[3]['data']['title']; ?></p>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $array[3]['data']['value']; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value_c; ?>%</div>
                                        </div>
                                
                                    </div>
                                    <div class="bloque-progress">
                                        <p><?php echo $array[4]['data']['title']; ?></p>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $array[4]['data']['value']; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value_d; ?>%</div>
                                        </div>
                                   
                                    </div>
                                    <div class="bloque-progress">
                                        <p><?php echo $array[5]['data']['title']; ?></p>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $array[5]['data']['value']; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value_e; ?>%</div>
                                        </div>
                                      
                                    </div>
                                    <div class="bloque-progress">
                                        <p><?php echo $array[6]['data']['title']; ?></p>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $array[6]['data']['value']; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value_f; ?>%</div>
                                        </div>
                                   
                                    </div>
                                    <div class="bloque-progress">
                                        <p><?php echo $array[7]['data']['title']; ?></p>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $array[7]['data']['value']; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value_g; ?>%</div>
                                        </div>
                               
                                    </div>
                                    <div class="bloque-progress">
                                        <p><?php echo $array[8]['data']['title']; ?></p>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $array[8]['data']['value']; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value_h; ?>%</div>
                                        </div>
                               
                                    </div>
                                    <div class="bloque-progress">
                                        <p><?php echo $array[9]['data']['title']; ?></p>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $array[9]['data']['value']; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $value_i; ?>%</div>
                                        </div>
                                    
                                    </div>    
                                </div>
                            </div>
                            <!-- FIN BLOQUE BARRA DISTRIBUTIBA -->             
                <?php endif; ?>
          <?php 

            $results =    $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 63 limit 1");
         
            if( $results ) : 

                $array  = 	json_decode($results[0]->data, true); 

                $results_link = $wpdb->get_results("SELECT id_occupation id, code_job_position code from cl_job_positions cjp where name_job_position = '".$array[0]["data"]["title"]."'");
                $code 	= $results_link[0]->code; 
                $id = $results_link[0]->id;

        ?>
                <!-- BLOQUE ICONO -->
                <div class="col-12">
                        <div class="bloque-icono">
                            <div class="row">
                                <div class="col-sm-12 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
                                    <div class="icono"> 
                                        <a href="<?php echo get_site_url().'/ocupacion-detalle/puesto-de-trabajo/?code_job_position='.$code.'&id_occupation='.$id.'/'; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                        <i class="iconcl-ocupacion-xl"></i>
                                    </div>
                                    <div class="text">
                                        <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$id.'/?code_job_position='.$code.'%2F'; ?>" class="title"><?php echo $array[0]["data"]["title"]; ?></a>
                                        <p>Ocupacion con mayor dificultad para llenar vacantes</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- FIN BLOQUE ICONO -->
            <?php endif;?>

     <!--            <div class="row parrafo-texto">
                    <div class="col-xs-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2">
                        <p class="text-justify"><?php echo 'TEXTO ENRIQUECIDO: ' . $m_meta_description;; ?></p>
                    </div>
                </div> -->

            </div>
        </div>
    </div>
<?php
	get_footer();
?>