<?php
    /* Template name: Ocupación detalle: Puestos de trabajo */

    global $id_occupation;
    
	$rs_search 	= array('/', 'ocupacion-conocimiento');
	$rs_replace = array('', '');

    $code_job_position = esc_html(get_query_var('code_job_position'));
    $id_occupation = esc_html(get_query_var('id_occupation'));
    
    $job_position = array_shift($wpdb->get_results("
                                        SELECT id_occupation, name_job_position, digital 
                                        FROM cl_job_positions 
                                        WHERE code_job_position = '" . $code_job_position . "' "));
    
    //Determinar si la ocupación es digital 
    $occupation_type = postgresToBool($job_position->digital);
   
    if( $occupation_type ): ?>
    
        <?php
    
          /* $wp_ocupacion = new WP_Query( $args_ocupacion );

            if ( $wp_ocupacion->have_posts() ) :
                while ( $wp_ocupacion->have_posts() ) : $wp_ocupacion->the_post();
                    $title_ocupacion    = get_the_title();
                    $content_ocupacion = get_the_content();

                endwhile;
                wp_reset_postdata();
            endif;*/

            get_header(); 

        ?>
        <?php       

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
                                    <a class="nav-link " href="<?php echo get_site_url().'/ocupacion-detalle/puesto-de-trabajo/?code_job_position='.$code_job_position.'&id_occupation='.$id_occupation; ?>">Resumen</a>
                                </li>
                                <li class="nav-item">
                                    <?php 
                                    $masInformacionUrl =  get_site_url() . '/ocupacion-mas-info/'. $link[0]->id_occupation; ?>
                                    <a class="nav-link" href="
                                    <?php echo isset($code_job_position) ? $masInformacionUrl . '?code_job_position='.$code_job_position : $masInformacionUrl; ?>">Más información</a>
                                </li>

                                <?php if( isset($code_job_position) && $job_position->digital == 't' ): ?>
                                <li class="nav-item">
                                    <a class="nav-link active" href="<?php echo get_site_url().'/ocupacion-conocimiento/'.$id_occupation.'?code_job_position='.$code_job_position; ?>">Conocimiento</a>
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
                        
                <?php
                    //top 10 ocupados
                    $results_ocupados = $wpdb->get_results("SELECT data, status from cl_indicators where status = 1 and id_indicator_type = 22 limit 1");

                    if( $results_ocupados ) : 

                        $job_position_value = array();

                        $job_position_title = array();

                        $job_position_knowledge = array();

                        $job_positions_json  = json_decode($results_ocupados[0]->data, true);

                        $i=0;

                        foreach($job_positions_json as $job_position_json){
                            
                            if( $job_position_json['data']['title'] == $job_position->name_job_position ){

                                $job_position_value[$i] = $job_position_json['data']['value'];

                                $job_position_knowledge[$i] = $job_position_json['data']['region'];

                                $i++;

                            }   
                        }

                        if ( !empty( $job_position_value ) ):
                            
                ?>              
                                <div class="col-12">
                                    <div class="bloque-cabecera">
                                        <div class="linea"><i class="iconcl-habilidades"></i></div>
                                        <h2>Conocimientos mas demandados en esta ocupacion</h2>
                                        <p>Conocimientos más demandados en las bolsas de empleo de esta ocupacion</p>
                                    </div>
                                </div>    
                                <div class="col-12 col-lg-8 offset-lg-2">
                                    <div class="bloque-barra">
                                        <div class="bloque-progress">
                                            <p><?php echo $job_position_knowledge[0]; ?></p>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $job_position_value[0]; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $job_position_value[0]; ?>%</div>
                                            </div>
                                            <a href="<?php //echo get_site_url().'/ocupacion-conocimiento/'; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                        </div>
                                        <div class="bloque-progress">
                                            <p><?php echo $job_position_knowledge[1]; ?></p>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $job_position_value[1]; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $job_position_value[1]; ?>%</div>
                                            </div>
                                            <a href="<?php //echo get_site_url().'/ocupacion-conocimiento/'; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                        </div>
                                        <div class="bloque-progress">
                                            <p><?php echo $job_position_knowledge[2]; ?></p>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $job_position_value[2]; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $job_position_value[2]; ?>%</div>
                                            </div>
                                            <a href="<?php //echo get_site_url().'/ocupacion-conocimiento/'; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                        </div>
                                        <div class="bloque-progress">
                                            <p><?php echo $job_position_knowledge[3]; ?></p>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $job_position_value[3]; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $job_position_value[3]; ?>%</div>
                                            </div>
                                            <a href="<?php //echo get_site_url().'/ocupacion-conocimiento/'; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                        </div>
                                        <div class="bloque-progress">
                                            <p><?php echo $job_position_knowledge[4]; ?></p>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $job_position_value[4]; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $job_position_value[4]; ?>%</div>
                                            </div>
                                            <a href="<?php //echo get_site_url().'/ocupacion-conocimiento/'; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                        </div>
                                        <div class="bloque-progress">
                                            <p><?php echo $job_position_knowledge[5]; ?></p>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $job_position_value[5]; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $job_position_value[5]; ?>%</div>
                                            </div>
                                            <a href="<?php// echo get_site_url().'/ocupacion-conocimiento/'; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                        </div>
                                        <div class="bloque-progress">
                                            <p><?php echo $job_position_knowledge[6]; ?></p>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $job_position_value[6]; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $job_position_value[6]; ?>%</div>
                                            </div>
                                            <a href="<?php //echo get_site_url().'/ocupacion-conocimiento/'; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                        </div>
                                        <div class="bloque-progress">
                                            <p><?php echo $job_position_knowledge[7]; ?></p>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $job_position_value[7]; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $job_position_value[7]; ?>%</div>
                                            </div>
                                            <a href="<?php //echo get_site_url().'/ocupacion-conocimiento/'; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                        </div>
                                        <div class="bloque-progress">
                                            <p><?php echo $job_position_knowledge[8]; ?></p>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $job_position_value[8]; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $job_position_value[8]; ?>%</div>
                                            </div>
                                            <a href="<<?php //echo get_site_url().'/ocupacion-conocimiento/'; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                        </div>
                                        <div class="bloque-progress">
                                            <p><?php echo $job_position_knowledge[9]; ?></p>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $job_position_value[9]; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $job_position_value[9]; ?>%</div>
                                            </div>
                                            <a href="<?php //echo get_site_url().'/ocupacion-conocimiento/'; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                                        </div>    
                                        <div class="bloque-boton">
                                            <a href="<?php echo get_site_url().'/ocupaciones'?>" class="btn btn-yellow">Ver más conocimientos</a>
                                        </div>
                                    </div>
                                </div>
                                <?php endif;?>
                    <?php endif;?>

                
        <?php 

            $related = $wpdb->get_results("SELECT cl_occupations.name_occupation o_name, cl_job_positions.name_job_position j_name, cl_job_positions.description j_desc, code_job_position code
            FROM cl_occupations
            LEFT JOIN cl_job_positions 
            ON cl_occupations.id_occupation = cl_job_positions.id_occupation
            WHERE cl_job_positions.name_job_position = '".$job_position->name_job_position."'
            ORDER BY random()");

            $occupation_name = $related[0]->o_name;

            $results = $wpdb->get_results("SELECT cl_occupations.name_occupation o_name, cl_job_positions.name_job_position j_name, cl_job_positions.description j_desc, code_job_position code
            FROM cl_occupations
            LEFT JOIN cl_job_positions 
            ON cl_occupations.id_occupation = cl_job_positions.id_occupation
            WHERE cl_occupations.name_occupation = '".$occupation_name."'
            ORDER BY random()");
        ?>      
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

$related = $wpdb->get_results("SELECT cl_occupations.name_occupation o_name, cl_job_positions.name_job_position j_name, cl_job_positions.description j_desc, code_job_position code
FROM cl_occupations
LEFT JOIN cl_job_positions 
ON cl_occupations.id_occupation = cl_job_positions.id_occupation
WHERE cl_job_positions.name_job_position = '".$job_position->name_job_position."'
ORDER BY random()");

$occupation_name = $related[0]->o_name;

$results = $wpdb->get_results("SELECT cl_occupations.name_occupation o_name, cl_job_positions.name_job_position j_name, cl_job_positions.description j_desc, code_job_position code
FROM cl_occupations
LEFT JOIN cl_job_positions 
ON cl_occupations.id_occupation = cl_job_positions.id_occupation
WHERE cl_occupations.name_occupation = '".$occupation_name."'
ORDER BY random()");
?>      
    <div class="bloque-blanco">
        <div class="container">
            <div class="bloque-columnas">
                <h2>Ocupaciones relacionadas con <?php echo $results[0]->o_name ?></h2>
                <div class="row">
                    <div class="col-12 col-md-4" style="padding-bottom: 35px;">
                        <h3><a href="<?php echo get_site_url().'/ocupacion-detalle/'.$id_occupation.'/?code_job_position=/'.$results[0]->code; ?>"><?php echo $results[0]->j_name; ?></a></h3>
                        <p style="text-align:justify;"><?php echo $results[0]->j_desc; ?></p>
                       <!-- <div class="bloque-progress">
                            <p>Demanda</p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="67" aria-valuemin="0" aria-valuemax="100">67%</div>
                            </div>
                            <a href="ocupacion-digital-desarrollador-web-resumen.html" class="icon-plus"><i class="fal fa-plus"></i></a>
                        </div> -->
                    </div>
                    <div class="col-12 col-md-4" style="padding-bottom: 35px;">
                        <h3><a href="<?php echo get_site_url().'/ocupacion-detalle/'.$id_occupation.'/?code_job_position=/'.$results[1]->code; ?>"><?php echo $results[1]->j_name; ?></a></h3>
                        <p style="text-align:justify;"><?php echo $results[2]->j_desc; ?></p>
                        <!-- <div class="bloque-progress">
                            <p>Demanda</p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="42" aria-valuemin="0" aria-valuemax="100">42%</div>
                            </div>
                            <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                        </div> -->
                    </div>
                    <div class="col-12 col-md-4" style="padding-bottom: 35px;">
                        <h3><a href="<?php echo get_site_url().'/ocupacion-detalle/'.$id_occupation.'/?code_job_position=/'.$results[2]->code; ?>"><?php echo $results[2]->j_name; ?></a></h3>
                        <p style="text-align:justify; "><?php echo $results[2]->j_desc; ?></p>
                        <!-- <div class="bloque-progress">
                            <p>Demanda</p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="46" aria-valuemin="0" aria-valuemax="100">46%</div>
                            </div>
                            <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a> 
                        </div>
                    </div>-->
                </div>
                    <div class="collapse" id="collapseOcupaciones">
                        <div class="row">
                            <div class="col-12 col-md-4" style="padding-bottom: 35px;">
                            <h3><a href="<?php echo get_site_url().'/ocupacion-detalle/'.$id_occupation.'/?code_job_position=/'.$results[3]->code; ?>"><?php echo $results[3]->j_name; ?></a></h3>
                            <p style="text-align: justify;"><?php echo $results[3]->j_desc; ?></p>
                                <!-- <div class="bloque-progress">
                                    <p>Demanda</p>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="63" aria-valuemin="0" aria-valuemax="100">63%</div>
                                    </div>
                                    <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                                </div> -->
                            </div>
                            <div class="col-12 col-md-4" style="padding-bottom: 35px;">
                            <h3><a href="<?php echo get_site_url().'/ocupacion-detalle/'.$id_occupation.'/?code_job_position=/'.$results[4]->code; ?>"><?php echo $results[4]->j_name; ?></a></h3>
                            <p style="text-align:justify;"><?php echo $results[4]->j_desc; ?></p>
                                <!-- <div class="bloque-progress">
                                    <p>Demanda</p>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="71" aria-valuemin="0" aria-valuemax="100">71%</div>
                                    </div>
                                    <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                                </div> -->
                            </div>
                            <div class="col-12 col-md-4" style="padding-bottom: 35px;">
                            <h3><a href="<?php echo get_site_url().'/ocupacion-detalle/'.$id_occupation.'/?code_job_position=/'.$results[5]->code; ?>"><?php echo $results[5]->j_name; ?></a></h3>
                            <p style="text-align:justify;"><?php echo $results[5]->j_desc; ?></p>
                                <!-- <div class="bloque-progress">
                                    <p>Demanda</p>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="83" aria-valuemin="0" aria-valuemax="100">83%</div>
                                    </div>
                                    <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                                </div> -->
                            </div>
                            <div class="col-12 col-md-4" style="padding-bottom: 35px;">
                            <h3><a href="<?php echo get_site_url().'/ocupacion-detalle/'.$id_occupation.'/?code_job_position=/'.$results[7]->code; ?>"><?php echo $results[6]->j_name; ?></a></h3>
                            <p style="text-align:justify;"><?php echo $results[6]->j_desc; ?></p>
                                <!-- <div class="bloque-progress">
                                    <p>Demanda</p>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="56" aria-valuemin="0" aria-valuemax="100">56%</div>
                                    </div>
                                    <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                                </div> -->
                            </div>
                            <div class="col-12 col-md-4" style="padding-bottom: 35px;">
                            <h3><a href="<?php echo get_site_url().'/ocupacion-detalle/'.$id_occupation.'/?code_job_position=/'.$results[7]->code; ?>"><?php echo $results[7]->j_name; ?></a></h3>
                            <p style="text-align:justify;"><?php echo $results[7]->j_desc; ?></p>
                                <!-- <div class="bloque-progress">
                                    <p>Demanda</p>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="23" aria-valuemin="0" aria-valuemax="100">23%</div>
                                    </div>
                                    <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                                </div> -->
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
    
    <?php else: 

    $parent_page    = get_page_by_title('Ocupacion Detalle');
    $page_url       = get_page_link($parent_page->ID);
    $redirect_url = $page_url . '/' . $job_position->id_occupation.'/?code_job_position='.$code_job_position;
    
    header('location:' . $redirect_url );

    endif ?>    
                
            <?php
            get_footer();

       
    
?>