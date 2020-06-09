<?php
    get_header(); 
?>

<div class="bloque-titular">
    <div class="container">
        <h1><?php echo get_the_title(); ?></h1>
    </div>
</div>

<div class="container">
    <div class="row">
        <!-- BLOQUE TITULAR -->
        <div class="col-12">
            <div class="bloque-titular">
                <h2>Selecciona una región</h2>
            </div>
        </div>
        <?php 
            $sql_region = "select id_region, name_region from cl_regions where id_region > 0 order by cast(code_region as integer) asc";
            $rs_region  = $wpdb->get_results($sql_region);
        ?>
        <div class="cpntainer" style="padding-left: 0px; padding-right: 0px;">
            <div class="bloque-regiones" >
                <ul>
                <?php if(is_array($rs_region) && count($rs_region)>0): ?>
                    
                    <?php foreach ($rs_region as $row): 
                        //var_dump($row->id_region); die;
                        $id_region      = isset($row->id_region)      && $row->id_region !=''    ? $row->id_region : '';
                        $name_region    = isset($row->name_region)    && $row->name_region !=''  ? $row->name_region : '';

                        $args_region        = array(
                            'post_type'     => 'regiones_detalle',
                            'post_status'   => 'publish',
                            'showposts'     => 1,
                            'order'         => 'ASC',
                            'meta_query' => array(
                              'relation'    => 'WHERE',
                              array(
                                'key'   => 'id',
                                'value'     => $id_region,
                                'compare'   => '=',
                              )
                            )
                        );
                        
                        $wp_region = new WP_Query( $args_region ); ?>

                        <?php if ( $wp_region->have_posts() ) :  ?>
                            <?php while ( $wp_region->have_posts() ) : 

                                $wp_region->the_post();
                                $title_region   = get_the_title();
                                $content_region = get_the_content();
                                $icono          = get_field('icono');
                                $nombre_corto   = get_field('nombre_corto');
                                $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full');

                            endwhile;
                            wp_reset_postdata();
                        endif; 

                         ?>
                        
                        <li>
                            <a href="<?php echo get_site_url().'/region-detalle/'.$id_region; ?>"> 
                                <img src="<?= $featured_img_url; ?> " alt="<?php the_title(); ?>">
                                <?php echo $nombre_corto; ?>
                            </a>
                        </li>
                        
                    <?php endforeach;  ?>
                <?php endif; ?>
                   
                </ul>
            </div>
             <p style="font-size: 11px;" class="float-right">Imágenes pertenecientes al “Banco Audiovisual” de SERNATUR </p>
        </div>


           <!--//BLOQUE MAPA  -->
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






        <!-- BLOQUE TITULAR -->
        <div class="col-12">
            <div class="bloque-titular">
                <h2>Datos generales para todo el territorio nacional</h2>
            </div>
        </div>
          <div class="owl-carousel owl-theme">
                        
        <!-- FIN BLOQUE TITULAR -->
        <!-- BLOQUE GRUPO INDICADORES -->
            <!--
            <div class="item">
                <div class="bloque-indicador">
                    <div class="grafica-circulo red">
                        <span class="indicador-icon"><i class="iconcl-cesantia"></i></span>
                        <a class="icon-plus"><i class="fal fa-plus"></i></a>
                        <a >
                            <svg class="radial-progress" data-percentage="36" viewBox="0 0 80 80">
                            <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                            <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                            <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">36%</text>
                            </svg>
                        </a>
                    </div>
                    <div class="text">
                        <a  class="title">Tasa Cesantía</a>
                        <p>Tasa de cesantía en todo el territorio nacional</p>
                    </div>
                </div>
            </div>
            -->
        <!-- BLOQUE GRUPO INDICADORES DESKTOP -->
                <?php
                    //mujeres
                    $results_mujeres = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 31 limit 1");
                    if( $results_mujeres ) : 
                                
                        $regions  = json_decode($results_mujeres[0]->data, true);

                        foreach($regions as $region){
                            if( $region['data']['title'] == $title_region ){
                                $region_value = $region['data']['value'];
                                $region_title_contratos = $region['data']['region'];

                                $value = number_format($region_value, 1, ',', '.');
                            }   
                        }
                ?>   
                                    
                        <div class="item">
                            <div class="bloque-indicador">
                                <div class="grafica-circulo">
                                    <span class="indicador-icon"><i class="iconcl-mujeres"></i></span>
                                    <!--<a href="" class="icon-plus"><i class="fal fa-plus"></i></a>-->
                                   <!-- <a href="">-->
                                        <svg class="radial-progress" data-percentage="<?php echo $region_value; ?>" viewBox="0 0 80 80">
                                        <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                        <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                        <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value ?>%</text>
                                        </svg>
                                    </a>
                                </div>
                                <div class="text">
                                    <a style="pointer-events: none;" class="title">Mujeres</a>
                                    <p>Porcentaje de mujeres en activo en todo el territorio nacional</p>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>
                    </div>
        <!--
        <div class="col-12 col-md-6 owl-desktop">
            <div class="bloque-indicador">
                <div class="grafica-circulo red">
                    <span class="indicador-icon"><i class="iconcl-cesantia"></i></span>
                    <a  class="icon-plus"><i class="fal fa-plus"></i></a>
                    <a >
                        <svg class="radial-progress" data-percentage="36" viewBox="0 0 80 80">
                        <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                        <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                        <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">36%</text>
                        </svg>
                    </a>
                </div>
                <div class="text">
                    <a class="title">Tasa Cesantía</a>
                    <p>Tasa de cesantía en todo el territorio nacional</p>
                </div>
            </div>
        </div>
        -->
                <?php
                    //mujeres
                    $results_mujeres = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 30 limit 1");
                    if( $results_mujeres ) : 
                                
                        $regions  = json_decode($results_mujeres[0]->data, true);

                        foreach($regions as $region){
                            if( $region['data']['title'] == $title_region ){
                                $region_value = $region['data']['value'];
                                $region_title_contratos = $region['data']['region'];

                                $value = number_format($region_value, 1, ',', '.');
                            }   
                        }
                ?>   
                                    
                        <div class="col-12 col-md-6 owl-desktop">
                            <div class="bloque-indicador">
                                <div class="grafica-circulo">
                                    <span class="indicador-icon"><i class="iconcl-mujeres"></i></span>
                                     <!--<a href="" class="icon-plus"><i class="fal fa-plus"></i></a>-->
                                   <!-- <a href="">-->
                                        <svg class="radial-progress" data-percentage="<?php echo $region_value; ?>" viewBox="0 0 80 80">
                                        <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                        <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                        <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $value ?>%</text>
                                        </svg>
                                    </a>
                                </div>
                                <div class="text">
                                    <a style="pointer-events: none;" class="title">Mujeres</a>
                                    <p>Porcentaje de mujeres en activo en esta región en el último periodo</p>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>
                    
            <!-- FIN BLOQUE GRUPO INDICADORES -->
            <!-- BLOQUE INDICADOR DATO -->
            <!--
            <div class="col-12 col-md-6">
                <div class="bloque-indicador-dato">
                    <div class="grafica-circulo">
                        <span class="indicador-icon"><i class="iconcl-ingresos"></i></span>
                        <a class="icon-plus"><i class="fal fa-plus"></i></a>
                        <a >
                            <svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
                            <circle class="complete" cx="40" cy="40" r="35"></circle>
                            <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">$1,5M</text>
                            </svg>
                        </a>
                    </div>
                    <div class="text">
                        <a  class="title">Ingresos</a>
                        <p>Promedio de ingresos mensuales en todo el territorio nacional</p>
                    </div>
                </div>
            </div>
            -->
            <!-- FIN BLOQUE INDICADOR DATO -->
    </div>
</div>

<?php
    get_footer();
?>