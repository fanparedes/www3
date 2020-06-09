<?php 
        global $wpdb;
        global $id_occupation;
        global $id_code;

            $results = $wpdb->get_results("SELECT cjp.code_job_position code, name_job_position j_name, description j_desc, number_offer::float * 100 /( select sum(number_offer) from cl_job_positions_offers ) as total 
				from cl_job_positions cjp
				left join cl_job_positions_offers cjpo
				on cjp.code_job_position = cjpo.code_job_position
				where id_occupation = '".$id_occupation."'
				group by cjp.code_job_position, cjp.name_job_position, cjp.description, cjpo.number_offer
				order by random()");

            $name =  $wpdb->get_results("SELECT name_occupation from cl_occupations where id_occupation = '".$id_occupation."' ");

            $suggest = $wpdb->get_results('SELECT  name_occupation titulo, description descripcion, id_occupation id FROM cl_occupations ORDER BY  random() LIMIT 3');

            $certs = $wpdb->get_results("SELECT  name_profile, link, code_ciuo_88 FROM cl_cert_chilevalora WHERE code_ciuo_88 = '".$id_occupation."'");
      
?>


     <div class="bloque-blanco">
        <div class="container">
            <div class="bloque-columnas">
                <h2>Ocupaciones relacionadas con <?php echo $name[0]->name_occupation; ?></h2>
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
      
                                <p class="font-italic">Sin informacion<p>
                            
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
    <div class="container">
        <hr>
    </div>
    <!-- BLOQUE BLANCO -->
    <div class="bloque-blanco">
        <div class="container">
            <!-- 3 COLUMNAS -->
            <div class="bloque-columnas">
                <h2>Perfiles de ChileValora asociados</h2>
                    <?php if ($certs == NULL): ?>
                <ul class="perfiles-asociados row">
                    <li class="col-sm-12"><p>No se encontraron Perfiles ChileValora asociados para esta ocupación</p></li>
                </ul>
                    <?php else :?>
                <ul class="perfiles-asociados row">
                <?php $i = 0; $limit = (count($certs)); while ($i < $limit) {?>
                
                    <li class="col-sm-4"><a target="_blank" href="<?php echo $certs[$i]->link; ?>"><?php echo $certs[$i]->name_profile;?></a></li>

                    <?php $i++;   } ?>
         
          </ul>
            <?php endif;?>
            </div>
        </div>
    </div>
    <!-- FIN BLOQUE BLANCO -->
    <!-- BOTON SOLO MÓVIL -->
    <div class="col-12 d-block d-sm-none">
        <div class="bloque-boton">
            <a href="<?php echo get_site_url().'/ocupaciones/'; ?>" class="btn btn-arrow btn-block">Ver más información</a>
        </div>
    </div>
    <!-- FIN BOTON SOLO MÓVIL -->
    <!-- BLOQUE AMARILLO -->
    <style type="text/css">
    		.text-limit{overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; text-align: justify;}
    </style>
    <div class="bloque-amarillo">
        <div class="container">
            <!-- 3 COLUMNAS -->
            <div class="bloque-columnas">
                <h2>También te puede interesar</h2>
                <div class="row">
                    <div style="padding-bottom: 20px;" class="col-12 col-md-4">
                        <h3><a href="<?php echo get_site_url().'/ocupacion-detalle/'.$suggest[0]->id; ?>"><?php echo $suggest[0]->titulo; ?></a></h3>
                        <p class="text-limit" ><?php echo $suggest[0]->descripcion; ?></p>
                    </div>
                    <div style="padding-bottom: 20px;"  class="col-12 col-md-4">
                        <h3><a href="<?php echo get_site_url().'/ocupacion-detalle/'.$suggest[1]->id; ?>"><?php echo $suggest[1]->titulo; ?></a></h3>
                        <p class="text-limit"><?php echo $suggest[1]->descripcion ?></p>
                    </div>
                    <div style="padding-bottom: 20px;"  class="col-12 col-md-4">
                        <h3><a href="<?php echo get_site_url().'/ocupacion-detalle/'.$suggest[2]->id; ?>"><?php  echo $suggest[2]->titulo; ?></a></h3>
                        <p class="text-limit"><?php echo $suggest[2]->descripcion; ?></p>
                    </div>
                </div>
            </div>
            <!-- FIN 3 COLUMNAS -->
                </div>
             </div>
        </div>
    </div>
</div>
        <!-- FIN BLOQUE AMARILLO -->