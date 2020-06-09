<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package chilevalora
 */
error_reporting(E_ALL ^ E_NOTICE);
get_header();?>

<?php function total_results(){
	global $wp_query;
	$total_results = $wp_query->found_posts;
	return $total_results;
} 

?>
	<section id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php 
			global $wpdb;
			$search = get_search_query();	
			$val = count($search);
	
			if ( $val > 0 ) : 
 	
				$sql_ocupacion = "select id_occupation, code_job_position, name_job_position from cl_job_positions where LOWER(name_job_position) LIKE '%".$search."%' order by id_occupation";
			    $rs_ocupacion  = $wpdb->get_results($sql_ocupacion);
				
				$numero = count($rs_ocupacion);
				//var_dump($numero);

					?>
				<div class="bloque-titular">
		        			<div class="container">
								<?php $search = get_search_query();?>
		            				<h1>Resultados para "<?php echo $search?>"</h1>
		      		  		</div>
		    			</div>           
					
				<div class="container">
						<div class="cabecera-buscador">
							<p><?php 
							$cant = total_results() + $numero ;
							printf( esc_html__( 'Se han encontrado %s resultados para el termino %s en todos los apartados', 'chilevalora' ),
							 					'<strong>' .$cant .  '</strong>', '<strong>' . get_search_query() . '</strong>'  );?></p>
							</div>
			    <?php		

				$i=0;
				while ( $numero > $i)  :
					
					$titulo_busqueda = $rs_ocupacion[$i]->name_job_position;
				    $id_ocup = $rs_ocupacion[$i]->id_occupation;
					
					$sql_descrip = "SELECT id_occupation, name_occupation, description, post_name FROM cl_occupations 
					inner join wp_postmeta  on (wp_postmeta.meta_value = cl_occupations.id_occupation::text)
  					inner join wp_posts on (wp_posts.ID = wp_postmeta.post_id)
					WHERE id_occupation= ".$id_ocup." ORDER BY ID ASC";

				    $rs_descrip  = $wpdb->get_results($sql_descrip);

				 	$name_occupation = $rs_descrip[0]->description;
				 	$name_link = $rs_descrip[0]->post_name;
				
				 	//  var_dump($rs_ocupacion);
				   	// 	exit();
					$url = get_site_url();
					$link = $url.'/ocupaciones/';
					$link_job = $url.'/ocupacion-detalle/';
					$code_job = $rs_ocupacion[$i]->code_job_position;
			    

			     ?>
					<div class="resultados-busqueda">
			                <div class="resultado" >
			                    <p><a href="<?php  echo  $link_job.$name_link.'/?code_job_position='.$code_job;?>"><?php echo $titulo_busqueda; ?></a></p>
								<p><a href="<?php  echo $link_job.$name_link.'/?code_job_position='.$code_job ;?>" class="titular"><?php echo $titulo_busqueda;?></a></p>
			                   	<p style="text-align: justify;"><?php echo $name_occupation;?></p>
			                </div>
			            </div><hr/>		
	<?php 

			$i++;
			endwhile; ?>
	
	<?php


	  endif; ?>

			<?php if ( have_posts() ) : ?>

				
			<?php	
			/* Start the Loop */
			while ( have_posts() ) : ?>
				<?php 
					$name = get_the_title();
					$occu_id = $wpdb->get_results("SELECT id_occupation o_id, post_name  FROM cl_occupations
					inner join wp_postmeta  on (wp_postmeta.meta_value = cl_occupations.id_occupation::text)
  					inner join wp_posts on (wp_posts.ID = wp_postmeta.post_id)
					WHERE name_occupation = '".$name."'ORDER BY ID ASC");
					
					$region_id = $wpdb->get_results("SELECT id_region r_id FROM cl_regions
					WHERE name_region = '".$name."'");
						
					$sector_id = $wpdb->get_results("SELECT id_sector s_id FROM cl_sectors
					WHERE name_sector = '".$name."'");
					
					$post_type = get_post_type();	
					the_post();  
					$shortext =  get_the_excerpt();
					$url = get_site_url();

					$occu_link = $occu_id[0]->post_name;
					$reg_link = $region_id[0]->r_id;
					$sec_link = $sector_id[0]->s_id; 
				
					if ($post_type == 'detalle_ocupacion') {
						$the_title = 'Detalle Ocupacion';
						$link_title =	$url.'/detalle-ocupacion/'.$occu_link;
						$link = $url.'/ocupaciones/';
					
					}elseif ($post_type == 'regiones_detalle') {
						$the_title = 'Detalle Region';
						$link_title = $url.'/region-detalle/'.$reg_link;
						$link = $url.'/regiones/';  
							
					}elseif ($post_type == 'detalle_sector' ) {
						$the_title = 'Detalle Sector';
						$link_title = $url.'/sector-detalle/'.$sec_link;
						$link = $url.'/sectores-productivos/'; 
						
					}else{
						$link = $url;
					}?>		
			<div class="resultados-busqueda">
                <div class="resultado" >
                    <p><a href="<?php  echo $link;?>"><?php echo $the_title; ?></a></p>
					<p><a href="<?php  echo $link_title ;?>" class="titular"><?php the_title();?></a></p>
                   	<p style="text-align: justify;"><?php echo $shortext;?></p>
                </div>
            </div><hr/>		
		
	<?php endwhile; ?>
	<?php	else : get_template_part( 'template-parts/content', 'none' );?>
	
		

		<?php endif; ?>
		<ul class="pagination justify-content-center">
		<?php echo paginate_links(); ?>
		<ul>
			
			</div>
		</main><!-- #main -->
	</section><!-- #primary -->
<?php
get_sidebar();
get_footer();
