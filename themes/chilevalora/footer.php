<?php
/**
 *
 * @package chilevalora
 */

    global $wpdb;
    $post_id_ocupaciones = 14;//This is page id or post id 16regiones 12sectores
    $content_post = get_post($post_id_ocupaciones);
    $content_oc = $content_post->post_content;
    $content_oc = apply_filters('the_content', $content_oc);
    $content_oc = str_replace(']]>', ']]&gt;', $content_oc);

    $post_id_regiones = 16;//This is page id or post id 16regiones 12sectores
    $content_post = get_post($post_id_regiones);
    $content_r = $content_post->post_content;
    $content_r = apply_filters('the_content', $content_r);
    $content_r = str_replace(']]>', ']]&gt;', $content_r);

    $post_id_sectores = 12;//This is page id or post id 16regiones 12sectores
    $content_post = get_post($post_id_sectores);
    $content_s = $content_post->post_content;
    $content_s = apply_filters('the_content', $content_s);
    $content_s = str_replace(']]>', ']]&gt;', $content_s);

    $post_id_ayuda = 329;//This is page id or post id 16regiones 12sectores
    $content_post = get_post($post_id_ayuda);
    $content_a = $content_post->post_content;
    $content_a = apply_filters('the_content', $content_a);
    $content_a = str_replace(']]>', ']]&gt;', $content_a);



    //$current_url = home_url(add_query_arg(array(), $wp->request));
    $current = get_the_title();
  
    //var_dump(get_pages());
   
?>
    <?php
        //Se valida si la página no es la home para mostrar el breadcrumb 
        if(get_the_ID()!='105') :

    ?>

	<!-- BANNERS -->
     <div class="bloque-banners">
        <div class="container">
            <div class="row">
            <?php if ($current != 'Ocupaciones' and $current != 'Ocupacion Detalle' and $current != 'Ocupación Detalle: puesto de trabajo' and $current != 'Ocupación Conocimiento' and $current != 'Ocupacion Mas Info' ): ?>
                    <div class="col-12 col-md-4">
                        <a href="<?php echo get_site_url().'/ocupaciones'; ?>" class="banner" title="Consulta los datos por Sectores Productivos">
                            <img src="<?php echo get_site_url(); ?>/wp-content/themes/chilevalora/images/banner-botton-ocupaciones.jpg"  class=" img-fluid">
                            <div class="gradient "></div>
                            <div class="bloque-banner-bg">
                                <div class="bloque-encabezado">
                                    <p><small>Consulta los datos por</small> Ocupaciones</p>
                                    <span><i class="far fa-chevron-right"></i></span>
                                </div>
                                <div class="bloque-resumen">
                                    <?php echo $content_oc;?>
                                </div>
                            </div>
                        </a>
                    </div>
            <?php endif; ?>
            <?php if ($current != 'Sectores productivos' and $current != 'Sectores Productivos') : ?>
                <div class="col-12 col-md-4">
                    <a href="<?php echo get_site_url().'/sectores-productivos'; ?>" class="banner" title="Consulta los datos por Sectores Productivos">
                        <img src="<?php echo get_site_url();  ?>/wp-content/themes/chilevalora/images/banner-botton-sectores-productivos.jpg"  class="img-fluid">
                        <div class="gradient"></div>
                        <div class="bloque-banner-bg">
                            <div class="bloque-encabezado">
                                <p><small>Consulta los datos por</small> Sectores Productivos</p>
                                <span><i class="far fa-chevron-right"></i></span>
                            </div>
                            <div class="bloque-resumen">
                                <?php echo $content_s; ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endif; ?>
            <?php if ($current != 'Regiones'  ) : ?>
                <div class="col-12 col-md-4">
                    <a href="<?php echo get_site_url().'/regiones'; ?>" class="banner" title="Consulta los datos por Regiones">
                        <img src="<?php echo get_site_url(); ?>/wp-content/themes/chilevalora/images/banner-botton-regiones.jpg" class="img-fluid">
                        <div class="gradient"></div>
                        <div class="bloque-banner-bg">
                            <div class="bloque-encabezado">
                                <p><small>Consulta los datos por</small> Regiones</p>
                                <span><i class="far fa-chevron-right"></i></span>
                            </div>
                            <div class="bloque-resumen">
                                <?php echo $content_r; ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endif; ?>
            <?php if ($current != 'Cómo Funciona la plataforma' and $current != 'Cursos'  ): ?>
                <div class="col-12 col-md-4">
                    <a href="<?php echo get_site_url().'/como-funciona/'; ?>" class="banner" title="¿Cómo funciona?">
                        <img src="<?php echo get_site_url(); ?>/wp-content/themes/chilevalora/images/banner-botton-no-foto.jpg" class="img-fluid">
                        <div class="gradient"></div>
                        <div class="bloque-banner-bg">
                            <div class="bloque-encabezado">
                                <p><small>&nbsp;</small> ¿Cómo funciona?</p>
                                <span><i class="far fa-chevron-right"></i></span>
                            </div>
                            <div class="bloque-resumen">
                                <p class="text-justify text-limit-footer">DestinoEmpleo ​es una plataforma innovadora que tiene como objetivo disponer información del mundo laboral para orientar la toma de decisiones de las personas. La plataforma se nutre de todas las ofertas de empleo del país las cuales permiten identificar las ocupaciones digitales más demandadas, además de las principales competencias que se requieren. 
                                Podemos ver indicadores y gráficas según región, demanda y empleabilidad, con un lenguaje simple, claro y directo, para ti, para ellos, para todos. 
                                Conoce cuáles son las habilidades más requeridas, conoce cuál es tu próximo, conoce DestinoEmpleo. </p>
                                <?php //echo $content_a; ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- FIN BANNERS -->

    <?php endif; ?>
    <!-- FIN BANNERS -->
    
    <footer>
        <div class="container">
            <div class="row align-items-center logos">
                <?php
					$args          = array(
						'post_type'     => 'banners',
						'post_status'   => 'publish',
						'showposts'     => 20,
						'order'         => 'ASC'
					);
					$i             = 1;
					$products_loop = new WP_Query( $args );
					if ( $products_loop->have_posts() ) :
						while ( $products_loop->have_posts() ) : $products_loop->the_post();
							// Set variables
							$id 		 = get_the_ID();
							$title       = get_the_title();
							$description = get_the_content();
							$image       = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
                            $url         = get_field('url');
							
							?>
							
							<div class="col-6 col-md-3 text-center">
			                    <a href="<?php echo $url; ?>" target="_blank"><img src="<?php echo $image; ?>" class="img-fluid" alt="<?php echo $title; ?>"></a>
			                </div>
							<?php
							$i ++;
						endwhile;
					wp_reset_postdata();
					endif;
			    ?>
            </div>
            <div class="row links">
                <div class="col-6 col-md-3">
                    <?php
					if(is_active_sidebar('footer-sidebar-1')){
						dynamic_sidebar('footer-sidebar-1');
					}
					?>
                </div>
                <div class="col-6 col-md-3">
                	<?php
					if(is_active_sidebar('footer-sidebar-2')){
						dynamic_sidebar('footer-sidebar-2');
					}
					?>
                    
                </div>
                <div class="col-6 col-md-3">
                	<?php
					if(is_active_sidebar('footer-sidebar-3')){
						dynamic_sidebar('footer-sidebar-3');
					}
					?>
                    
                </div>
                <div class="col-6 col-md-3">
                	<?php
					if(is_active_sidebar('footer-sidebar-4')){
						dynamic_sidebar('footer-sidebar-4');
					}
					?>
                </div>
            </div>
            <?php
                $args_rss          = array(
                    'post_type'     => 'rrss',
                    'post_status'   => 'publish',
                    'showposts'     => 1,
                    'order'         => 'DESC'
                );
                
                $rs_rrss = new WP_Query( $args_rss );
                $facebook        = "";
                $twitter         = "";
                $youtube         = "";
                $instagram       = "";
                $linkedin        = "";
                if ( $rs_rrss->have_posts() ) :
                    while ( $rs_rrss->have_posts() ) : $rs_rrss->the_post();
                        $facebook        = get_field('facebook');
                        $twitter         = get_field('twitter');
                        $youtube         = get_field('youtube');
                        $instagram       = get_field('instagram');
                        $linkedin        = get_field('linkedin');

                    endwhile;
                wp_reset_postdata();
                endif;
            ?>
            <p class="social">
                <?php
                    if($facebook!=''){
                        echo '<a target="_blank" href="'.$facebook.'"><i class="fab fa-facebook-f"></i></a>';        
                    }
                    if($twitter!=''){
                        echo '<a target="_blank" href="'.$twitter.'"><i class="fab fa-twitter"></i></a>';        
                    }
                    if($youtube!=''){
                        echo '<a target="_blank" href="'.$youtube.'"><i class="fab fa-youtube"></i></a>';        
                    }
                    if($instagram!=''){
                        echo '<a target="_blank" href="'.$instagram.'"><i class="fab fa-instagram"></i></a>';        
                    }
                    if($linkedin!=''){
                        echo '<a target="_blank" href="'.$linkedin.'"><i class="fab fa-linkedin"></i></a>';        
                    }
                ?>
            </p>
        </div>
    </footer>
 <div class="modal" id="FiltroSector">
        <form>
            <div class="closeFiltroSector close"><i class="iconcl-aspa"></i></div>
            <h2>Elige un sector</h2>
             <?php 
                // change id's/code_sector ijensen
                    //$sql_sector = "select id_sector, code_sector ,name_sector from cl_sectors cs order by id_sector";

                $sql_sector = "
                    select 
                        wp_postmeta.post_id as get_the_id,
                        wp_posts.post_title,
                        wp_posts.post_content,
                        wp_posts.guid,
                        cl_sectors.id_sector,
                        cl_sectors.name_sector
                    from wp_posts  
                    inner join wp_postmeta  on (wp_posts.ID = wp_postmeta.post_id)
                    inner join cl_sectors on (cl_sectors.id_sector::int = wp_postmeta.meta_value::int)
                    where post_type = 'detalle_sector'
                    and wp_postmeta.meta_key = 'id'
                    order by cl_sectors.name_sector asc
                ";
                $rs_sector  = $wpdb->get_results($sql_sector);
            ?>
            <div class="form-group">
                <input type="text" class="form-control" id="buscar_sectores" name="buscar_sectores" placeholder="Buscar...">
            </div>
            <div class="accordion" id="accordionSector">
                <div class="list-group">
                <?php
                    if(is_array($rs_sector) && count($rs_sector)>0){
                        foreach ($rs_sector as $row) {

                            $id_sector      = isset($row->id_sector)      && $row->id_sector !=''    ? $row->id_sector : '';
                            $name_sector    = isset($row->name_sector)    && $row->name_sector !=''  ? $row->name_sector : '';
                            $get_the_id     = isset($row->get_the_id)           && $row->get_the_id !=''            ? $row->get_the_id : '';
                            $get_permalink  = get_permalink($get_the_id);
                            ?>
                                <!-- <a href="<?php echo get_site_url().'/sector-detalle/'.$id_sector; ?>" class="list-group-item list-group-item-action"><?php echo $name_sector; ?></a> -->
                                <a class="list-group-item collapsed" type="button" data-toggle="collapse" data-target="#collapse<?php echo $id_sector; ?>" aria-expanded="true" aria-controls="collapse<?php echo $id_sector; ?>"><?php echo $name_sector; ?></a>
                                <div id="collapse<?php echo $id_sector; ?>" class="list-group collapse" data-parent="#accordionSector">
                            <?php
                                $sql_code= "
                                    select cc.id_code, cc.name_code
                                        from cl_codes cc
                                            inner join cl_subclass sc on sc.id_subclass = cc.id_subclass
                                            inner join cl_class cl on cl.id_class = sc.id_class
                                            inner join cl_groups gr on cl.id_group = gr.id_group
                                            inner join cl_divisions dv on gr.id_division = dv.id_division
                                            inner join cl_sectors se on dv.id_sector = se.id_sector
                                        where se.id_sector =".$id_sector;
                                //echo $sql_code;
                                $rs_code  = $wpdb->get_results($sql_code);
                                if(is_array($rs_code) && count($rs_code)>0){
                                    foreach ($rs_code as $row_code) {
                                        $id_code      = isset($row_code->id_code)      && $row_code->id_code !=''    ? $row_code->id_code : '';
                                        $name_code    = isset($row_code->name_code)    && $row_code->name_code !=''  ? $row_code->name_code : '';
                                        
                                        ?>
                                            <!-- <a href="#" class="list-group-item list-group-item-action">Agentes de seguros</a> -->
                                            <a href="<?php echo $get_permalink.'?code_sector='.$id_code; ?>" class="list-group-item list-group-item-action"><?php echo $name_code; ?></a> 
                                        <?php
                                    }
                                }
                            ?>
                                </div>
                            <?php

                        }
                    } 
                ?>
                </div>
            </div>
        </form> 
    </div>

    <?php 
        $sql_region = "SELECT code_region, name_region, id_region from cl_regions where id_region > 0 order by cast(code_region as integer) asc";
        $rs_region  = $wpdb->get_results($sql_region);
    ?>
    <div class="modal" id="FiltroRegion">
        <form>
            <div class="closeFiltroRegion close"><i class="iconcl-aspa"></i></div>
            <h2>Elige una región</h2>
             <div class="form-group">
                <input type="text" class="form-control" id="buscar_regiones" name="buscar_regiones" placeholder="Buscar...">
            </div>
            <div class="list-group" id="divRegiones">
                <?php
                   $code_region = 0;
                    if(is_array($rs_region) && count($rs_region)>0){
                        foreach ($rs_region as $row) {
                           //var_dump($row);
                            $id_region      = isset($row->id_region)      && $row->id_region !=''    ? $row->id_region : '';

                            $name_region    = isset($row->name_region)    && $row->name_region !=''  ? $row->name_region : '';
                            ?>
                                <a href="<?php echo get_site_url().'/region-detalle/'.$id_region; ?>" class="list-group-item list-group-item-action"><?php echo $name_region; ?></a>
                            <?php
                        }
                    } 
                ?>
            </div>
        </form> 
    </div>
     <?php 
        

        /* BACKUP CHANGE 05-02-2020 - IJENSEN
            $sql_ocupacion = "select id_occupation, name_occupation from cl_occupations order by id_occupation";
            $rs_ocupacion  = $wpdb->get_results($sql_ocupacion);
        */
       $sql_job_ocupacion = "
            select
            wp_posts.ID as get_the_id,
            wp_posts.post_title,
            wp_posts.post_content,
            wp_posts.guid,
            cl_job_positions.id_occupation,
            cl_job_positions.code_job_position, 
            cl_job_positions.name_job_position
            from wp_posts  
            inner join wp_postmeta  on (wp_posts.ID= wp_postmeta.post_id)
            inner join cl_job_positions on (cl_job_positions.id_occupation::int = wp_postmeta.meta_value::int)
            where post_type = 'detalle_ocupacion'
            and wp_postmeta.meta_key = 'id'
            order by name_job_position asc
        ";
        $rs_job_ocupacion  = $wpdb->get_results($sql_job_ocupacion);


    ?>
    <div class="modal" id="FiltroOcupacion">
        <form>
            <div class="closeFiltroOcupacion close"><i class="iconcl-aspa"></i></div>
            <h2>Elige una ocupación</h2>
            <div class="form-group">
                <input type="text" class="form-control" id="buscar_ocupaciones" name="buscar_ocupaciones" placeholder="Buscar...">
            </div>
                       
            <div class="accordion" id="accordionOcupaciones">
                <div class="list-group">        
                    <?php

                        /* BACKUP CHANGE 05-02-2020 - IJENSEN
                            if(is_array($rs_ocupacion) && count($rs_ocupacion)>0){
                                foreach ($rs_ocupacion as $row) {
                                    //var_dump($row->id_region); die;
                                    $id_occupation      = isset($row->id_occupation)      && $row->id_occupation !=''    ? $row->id_occupation : '';
                                    $name_occupation    = isset($row->name_occupation)    && $row->name_occupation !=''  ? $row->name_occupation : '';
                                    ?>
                                        <!-- <a href="<?php echo get_site_url().'/ocupacion-detalle/'.$id_occupation; ?>" class="list-group-item list-group-item-action"><?php echo $name_occupation; ?></a> -->
                                        <a class="list-group-item collapsed" onclick="fn_buscar_ocupacion(<?php echo $id_occupation; ?>)" type="button" data-toggle="collapse" data-target="#collapse<?php echo $id_occupation; ?>" aria-expanded="true" aria-controls="collapse<?php echo $id_occupation; ?>"><?php echo $name_occupation; ?></a>
                                        <div id="collapse<?php echo $id_occupation; ?>" class="list-group collapse" data-parent="#accordionOcupaciones">
                                        
                                        </div>
                                    <?php
                                }
                            } 

                        */ 
                        if(is_array($rs_job_ocupacion) && count($rs_job_ocupacion)>0){
                            foreach ($rs_job_ocupacion as $row) {
        
                                $id_occupation      = isset($row->id_occupation)        && $row->id_occupation !=''         ? $row->id_occupation : '';
                                $code_job_position  = isset($row->code_job_position)    && $row->code_job_position !=''     ? $row->code_job_position : '';
                                $name_job_position  = isset($row->name_job_position)    && $row->name_job_position !=''     ? $row->name_job_position : '';
                                $get_the_id         = isset($row->get_the_id)           && $row->get_the_id !=''            ? $row->get_the_id : '';
                                $get_permalink      = get_permalink($get_the_id);
                                $uri_occupation     = $row->name_job_position !=''      && $row->code_job_position !=''     ? $get_permalink.'?code_job_position='.$code_job_position  : '';
        
                                ?>
                                <a href="<?php echo $uri_occupation; ?>" class="list-group-item list-group-item-action"><?php echo $name_job_position;?> </a>      
                                <?php
                            }
                        } 
                    ?>
                </div>
            </div>
        </form> 
    </div>
    <div class="modal-backdrop" id="backMenu" style="display:none"></div>
</body>


    <script type="text/javascript" src="https://webapp.orientador-services.fundaciontelefonica.com/webchat/fundacion-chatbot.js"></script> 


    <script type="text/javascript">    
        jQuery ( document ).ready ( function($) {
          
        var hash= window.location.hash

        if ( hash == '' || hash == '#' || hash == undefined ) return false;
              var target = $(hash);
              //headerHeight = 0;
              target = target.length ? target : $('[name=' + hash.slice(1) +']');
              if (target.length) {
                $('html,body').stop().animate({
                  scrollTop: target.offset().top //offsets for fixed header
                }, 7000);
              }
        } );
    </script>
</html>
