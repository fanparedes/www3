<?php 

//Sectores con mayor crecimiento en el nº de ocupados en todo el territorio nacional
add_shortcode('sector_crecimiento_nacional', 'fn_sector_crecimiento_nacional');

function fn_sector_crecimiento_nacional() {
	global $wpdb;

	$sql_sector = "select sec.id_sector, sec.name_sector, psec.participation, wp_postmeta.post_id
			from cl_sectors as sec 
			inner join cl_percentage_sectors as psec on (sec.id_sector = psec.id_sector)
			inner join wp_postmeta  on (sec.id_sector::int = wp_postmeta.meta_value::int)
			inner join wp_posts on (wp_posts.ID = wp_postmeta.post_id)
			where post_type = 'detalle_sector'
			and wp_postmeta.meta_key = 'id'
			order by psec.participation desc
			limit 3";
	$rs_sector  = $wpdb->get_results($sql_sector);

	//var_dump($rs_sector);


	$desktop 	= '<div class="row owl-desktop">';
	$carrousel 	= '<div class="owl-carousel owl-theme">';

	if(is_array($rs_sector) && count($rs_sector)>0){
		foreach ($rs_sector as $row) {
			$post_id     	= isset($row->post_id)        && $row->post_id !=''      ? $row->post_id : '';
            $get_permalink  = get_permalink($post_id);
			$desktop .= '
				<div class="col-4 owl-desktop">
		            <div class="bloque-indicador">
		                <div class="grafica-circulo">
		                    <span class="indicador-icon"><i class="iconcl-puesto1"></i></span>
		                    <a href="'.$get_permalink.'" class="icon-plus"><i class="fal fa-plus"></i></a>
		                    <a href="'.$get_permalink.'">
		                        <svg class="radial-progress" data-percentage="'.$row->participation.'" viewBox="0 0 80 80">
		                        <circle class="incomplete" cx="40" cy="40" r="35"></circle>
		                        <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
		                        <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">'.$row->participation.'%</text>
		                        </svg>
		                    </a>
		                </div>
		                <div class="text">
		                    <a href="'.$get_permalink.'" class="title">'.$row->name_sector.'</a>
		                </div>
		            </div>
		        </div>';

		    $carrousel .= '
			    <div class="col-12 col-md-6 item">
	                <div class="bloque-indicador">
	                    <div class="grafica-circulo">
	                        <span class="indicador-icon"><i class="iconcl-puesto1"></i></span>
	                        <a href="'.get_site_url().'/sector-detalle/'.$row->id_sector.'" class="icon-plus"><i class="fal fa-plus"></i></a>
	                        <a href="'.get_site_url().'/sector-detalle/'.$row->id_sector.'">
	                            <svg class="radial-progress" data-percentage="'.$row->participation.'" viewBox="0 0 80 80">
	                            <circle class="incomplete" cx="40" cy="40" r="35"></circle>
	                            <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
	                            <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">'.$row->participation.'%</text>
	                            </svg>
	                        </a>
	                    </div>
	                    <div class="text">
	                        <a href="'.get_site_url().'/sector-detalle/'.$row->id_sector.'" class="title">'.$row->name_sector.'</a>
	                    </div>
	                </div>
	            </div>
		    ';
		}
	}
	$desktop 	.= '</div>';
	$carrousel 	.= '</div>';

	return $carrousel.$desktop;
}

//Sectores con mayor porcentaje de mujeres en todo el territorio nacional
add_shortcode('sector_crecimiento_mujeres', 'fn_sector_crecimiento_mujeres');

function fn_sector_crecimiento_mujeres() {
	global $wpdb;

	$anio = (date('Y')-1); 

	$sql = "
		select
			cl_sectors.id_sector,
			cl_sectors.name_sector,
			cl_sex.gloss,
			((count(*)*100)/(select count(*) from cl_afc where ano = '".$anio."')) as porcentaje,
			wp_postmeta.post_id
		from cl_afc
		inner join cl_class on (cl_class.id_class = cl_afc.id_subclass)
		inner join cl_subclass on (cl_class.id_class = cl_subclass.id_class)
		inner join cl_groups on (cl_class.id_group = cl_groups.id_group)
		inner join cl_divisions on (cl_groups.id_division = cl_divisions.id_division)
		inner join cl_sectors on (cl_divisions.id_sector = cl_sectors.id_sector)
		inner join cl_sex on (cl_afc.id_sex = cl_sex.id_sex)
		inner join wp_postmeta  on (cl_sectors.id_sector::int = wp_postmeta.meta_value::int)
		inner join wp_posts on (wp_posts.ID = wp_postmeta.post_id)
		where post_type = 'detalle_sector'
		and wp_postmeta.meta_key = 'id'
		and cl_afc.ano = '".$anio."'
		and cl_sex.id_sex = 1
		group by cl_sectors.id_sector, cl_sectors.name_sector, cl_sex.gloss, wp_postmeta.post_id


		having ((count(*)*100)/(select count(*) from cl_afc where ano = '".$anio."')) > 0
		order by ((count(*)*100)/(select count(*) from cl_afc where ano = '".$anio."'))  desc
		limit 4
	";

	$rs_mujer  = $wpdb->get_results($sql);

	if(is_array($rs_mujer) && count($rs_mujer)>0){
		foreach ($rs_mujer as $row) {
			$post_id     	= isset($row->post_id)        && $row->post_id !=''      ? $row->post_id : '';
            $get_permalink  = get_permalink($post_id);
			?>
			<div class="bloque-progress">
                <p><?php echo $row->name_sector; ?></p>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $row->porcentaje; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $row->porcentaje; ?>%</div>
                </div>
                <a href="<?php echo $get_permalink; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
            </div>
			<?php
		}
	}
}

//Sectores con mayor porcentaje de migrantes en todo el territorio nacional
add_shortcode('sector_crecimiento_migrantes', 'fn_sector_crecimiento_migrantes');

function fn_sector_crecimiento_migrantes() {
	global $wpdb;

	$anio = (date('Y')-1); 

	$sql_sector = "
		select
			cl_sectors.id_sector,
			cl_sectors.name_sector,
			cl_nacionality.gloss,
			((count(*)*100)/(select count(*) from cl_afc where ano = '".$anio."')) as participation,
			wp_postmeta.post_id
		from cl_afc
		inner join cl_class on (cl_class.id_class = cl_afc.id_subclass)
		inner join cl_subclass on (cl_class.id_class = cl_subclass.id_class)
		inner join cl_groups on (cl_class.id_group = cl_groups.id_group)
		inner join cl_divisions on (cl_groups.id_division = cl_divisions.id_division)
		inner join cl_sectors on (cl_divisions.id_sector = cl_sectors.id_sector)
		inner join cl_nacionality on (cl_afc.id_nacionality = cl_nacionality.id_nacionality)
		inner join wp_postmeta  on (cl_sectors.id_sector::int = wp_postmeta.meta_value::int)
		inner join wp_posts on (wp_posts.ID = wp_postmeta.post_id)
		where post_type = 'detalle_sector'
		and wp_postmeta.meta_key = 'id'
		and cl_afc.ano = '".$anio."'
		and cl_nacionality.id_nacionality = 2
		group by cl_sectors.id_sector, cl_sectors.name_sector, cl_nacionality.gloss, wp_postmeta.post_id


		having ((count(*)*100)/(select count(*) from cl_afc where ano = '".$anio."')) > 0
		order by ((count(*)*100)/(select count(*) from cl_afc where ano = '".$anio."')) desc
		limit 4

		";
	$rs_sector  = $wpdb->get_results($sql_sector);

	
	$desktop 	= '<div class="col-12 col-xl-10 offset-xl-1"><div class="row owl-desktop justify-content-center">';
	$carrousel 	= '<div class="bloque-indicadores-distributiva"><div class="owl-carousel owl-theme">';

	if(is_array($rs_sector) && count($rs_sector)>0){
		foreach ($rs_sector as $row) {
			$post_id     	= isset($row->post_id)        && $row->post_id !=''      ? $row->post_id : '';
            $get_permalink  = get_permalink($post_id);
			$desktop .= '
				<div class="col-2 col-sm-6 col-lg-3 col-xl-3">
                    <div class="bloque-indicador">
                        <div class="grafica-circulo">
                            <a href="'.$get_permalink.'" class="icon-plus"><i class="fal fa-plus"></i></a>
                            <a href="'.$get_permalink.'">
                                <svg class="radial-progress" data-percentage="'.$row->participation.'" viewBox="0 0 80 80">
                                <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">'.$row->participation.'%</text>
                                </svg>
                            </a>
                        </div>
                        <div class="text">
                            <a href="'.$get_permalink.'" class="title">'.$row->name_sector.'</a>
                        </div>
                    </div>
                </div>';

		    $carrousel .= '
			    <div class="col-12 col-md-6 item">
                    <div class="bloque-indicador">
                        <div class="grafica-circulo">
                            <a href="'.$get_permalink.'" class="icon-plus"><i class="fal fa-plus"></i></a>
                            <a href="'.$get_permalink.'">
                                <svg class="radial-progress" data-percentage="'.$row->participation.'" viewBox="0 0 80 80">
                                <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">'.$row->participation.'%</text>
                                </svg>
                            </a>
                        </div>
                        <div class="text">
                            <a href="'.$get_permalink.'" class="title">'.$row->name_sector.'</a>
                        </div>
                    </div>
                </div>
		    ';
		}
	}
	$desktop 	.= '</div></div></div>';
	$carrousel 	.= '</div>';

	return $carrousel.$desktop;
}


//Sectores con mayor porcentaje de contratos indefinidos en todo el territorio nacional
add_shortcode('sector_crecimiento_contrato', 'fn_sector_crecimiento_contrato');

function fn_sector_crecimiento_contrato() {
	global $wpdb;

	$anio = (date('Y')-1); 

	$sql = "
		select
			cl_sectors.id_sector,
			cl_sectors.name_sector,
			cl_contract_type.name_contract_type,
			((count(*)*100)/(select count(*) from cl_afc where ano = '".$anio."')) as porcentaje,
			wp_postmeta.post_id
		from cl_afc
		inner join cl_class on (cl_class.id_class = cl_afc.id_subclass)
		inner join cl_subclass on (cl_class.id_class = cl_subclass.id_class)
		inner join cl_groups on (cl_class.id_group = cl_groups.id_group)
		inner join cl_divisions on (cl_groups.id_division = cl_divisions.id_division)
		inner join cl_sectors on (cl_divisions.id_sector = cl_sectors.id_sector)
		inner join cl_contract_type on (cl_afc.id_contract_type = cl_contract_type.id_contract_type )
		inner join wp_postmeta  on (cl_sectors.id_sector::int = wp_postmeta.meta_value::int)
		inner join wp_posts on (wp_posts.ID = wp_postmeta.post_id)
		where post_type = 'detalle_sector'
		and wp_postmeta.meta_key = 'id'
		and cl_afc.ano = '".$anio."'
		and cl_contract_type.id_contract_type = 1
		group by cl_sectors.id_sector, cl_sectors.name_sector, cl_contract_type.name_contract_type, wp_postmeta.post_id


		having ((count(*)*100)/(select count(*) from cl_afc where ano = '".$anio."')) > 0
		order by ((count(*)*100)/(select count(*) from cl_afc where ano = '".$anio."')) desc
		limit 4

	";

	$rs_mujer  = $wpdb->get_results($sql);

	if(is_array($rs_mujer) && count($rs_mujer)>0){
		foreach ($rs_mujer as $row) {
			$post_id     	= isset($row->post_id)        && $row->post_id !=''      ? $row->post_id : '';
            $get_permalink  = get_permalink($post_id);
			?>
			<div class="bloque-progress">
                <p><?php echo $row->name_sector; ?></p>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $row->porcentaje; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $row->porcentaje; ?>%</div>
                </div>
                <a href="<?php echo $get_permalink; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
            </div>
			<?php
		}
	}
}

//Sector con mayor incorporación de nuevos trabajadores
add_shortcode('sector_crecimiento_ingreso_trabajadores', 'fn_sector_crecimiento_ingreso_trabajadores');

function fn_sector_crecimiento_ingreso_trabajadores() {
	global $wpdb;

	$anio = (date('Y')-1); 

	$sql = "
		select
			cl_sectors.id_sector,
			cl_sectors.name_sector,
			cl_sector_exit_inputs.number_people
		from cl_sectors 
		inner join cl_sector_exit_inputs on (cl_sectors.id_sector = cl_sector_exit_inputs.id_sector_exit_input)
		order by number_people desc 
		limit 1
	";

	$rs_mujer  = $wpdb->get_results($sql);

	if(is_array($rs_mujer) && count($rs_mujer)>0){
		foreach ($rs_mujer as $row) {
			?>
				<div class="bloque-icono">
	                <div class="row">
	                    <div class="col-sm-12 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
	                        <div class="icono">
	                            <a href="<?php echo get_site_url().'/sector-detalle/'.$row->id_sector; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>                                
	                            <i class="iconcl-puesto1-xl"></i>
	                        </div>
	                        <div class="text">
	                            <a href="<?php echo get_site_url().'/sector-detalle/'.$row->id_sector; ?>" class="title"><?php echo $row->name_sector; ?></a>
	                            <p>Sector con mayor incorporación de nuevos trabajadores en <?php echo $anio; ?> <a href="#popover" data-container="body" data-toggle="popover" data-placement="top" data-content="<?php echo $row->name_sector; ?>"><i class="fas fa-question-circle"></i></a></p>
	                        </div>
	                    </div>
	                </div>
	            </div>
			<?php
		}
	}
}

//Detalle Sector grupo de indicadores
add_shortcode('sector_crecimiento_detalle_carrousel', 'fn_sector_crecimiento_detalle_carrousel');

function fn_sector_crecimiento_detalle_carrousel() {
	global $wpdb;
	global $id_sector;
	$anio = (date('Y')-1); 

	$sql = "
		select
			cl_sectors.id_sector,
			cl_sectors.name_sector,
			cl_sex.gloss,
			((count(*)*100)/(select count(*) from cl_afc where ano = '".$anio."')) as porcentaje
		from cl_afc
		inner join cl_subclass on (cl_afc.id_subclass = cl_subclass.id_subclass)
		inner join cl_class on (cl_class.id_class = cl_subclass.id_class)
		inner join cl_groups on (cl_class.id_group = cl_groups.id_group)
		inner join cl_divisions on (cl_groups.id_division = cl_divisions.id_division)
		inner join cl_sectors on (cl_divisions.id_sector = cl_sectors.id_sector)
		inner join cl_sex on (cl_afc.id_sex = cl_sex.id_sex)
		where cl_afc.ano = '".$anio."'
		and cl_sectors.id_sector = ".$id_sector."
		and cl_sex.id_sex = 1
		group by cl_sectors.id_sector,
		cl_sectors.name_sector,
		cl_sex.gloss
	";



	$rs_mujer  = $wpdb->get_results($sql);

	if(is_array($rs_mujer) && count($rs_mujer)>0){
			?>
			
            <div class="col-12 col-md-6 item">
                <div class="bloque-indicador">
                    <div class="grafica-circulo red">
                        <span class="indicador-icon"><i class="iconcl-mujeres"></i></span>
                        <a href="<?php echo get_site_url().'/sector-detalle/'.$rs_mujer[0]->id_sector; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                        <a href="<?php echo get_site_url().'/sector-detalle/'.$rs_mujer[0]->id_sector; ?>">
                            <svg class="radial-progress" data-percentage="<?php echo $rs_mujer[0]->porcentaje; ?>" viewBox="0 0 80 80">
                            <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                            <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                            <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $rs_mujer[0]->porcentaje; ?>%</text>
                            </svg>
                        </a>
                    </div>
                    <div class="text">
                        <a href="<?php echo get_site_url().'/sector-detalle/'.$rs_mujer[0]->id_sector; ?>" class="title">Mujeres</a>
                        <p>Porcentaje de mujeres para este sector a nivel nacional en el último periodo</p>
                    </div>
                </div>
            </div>


			<?php
	}

	$sql_sector = "
		select
			cl_sectors.id_sector,
			cl_sectors.name_sector,
			cl_nacionality.gloss,
			((count(*)*100)/(select count(*) from cl_afc where ano = '".$anio."')) as participation
		from cl_afc
		inner join cl_subclass on (cl_afc.id_subclass = cl_subclass.id_subclass)
		inner join cl_class on (cl_class.id_class = cl_subclass.id_class)
		inner join cl_groups on (cl_class.id_group = cl_groups.id_group)
		inner join cl_divisions on (cl_groups.id_division = cl_divisions.id_division)
		inner join cl_sectors on (cl_divisions.id_sector = cl_sectors.id_sector)
		inner join cl_nacionality on (cl_afc.id_nacionality = cl_nacionality.id_nacionality)
		where cl_afc.ano = '".$anio."'
		and cl_nacionality.id_nacionality = 2
		and cl_sectors.id_sector = ".$id_sector."
		group by cl_sectors.id_sector,
		cl_sectors.name_sector,
		cl_nacionality.gloss";
	$rs_migrante  = $wpdb->get_results($sql_sector);

	if(is_array($rs_migrante) && count($rs_migrante)>0){
		
			?>
			<div class="col-12 col-md-6 item">
                <div class="bloque-indicador">
                    <div class="grafica-circulo">
                        <span class="indicador-icon"><i class="iconcl-migrante"></i></span>
                        <a href="<?php echo get_site_url().'/sector-detalle/'.$rs_migrante[0]->id_sector; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                        <a href="<?php echo get_site_url().'/sector-detalle/'.$rs_migrante[0]->id_sector; ?>">
                            <svg class="radial-progress" data-percentage="<?php echo $rs_migrante[0]->participation; ?>" viewBox="0 0 80 80">
                            <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                            <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                            <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $rs_migrante[0]->participation; ?>%</text>
                            </svg>
                        </a>
                    </div>
                    <div class="text">
                        <a href="<?php echo get_site_url().'/sector-detalle/'.$rs_migrante[0]->id_sector; ?>" class="title">Migrantes</a>
                        <p>Porcentaje de migrantes para este sector a nivel nacional en el último periodo</p>
                    </div>
                </div>
            </div>
			<?php
	
	}


	//CESANTIA PENDIENTE
	?>
		<div class="col-12 col-md-6 item">
            <div class="bloque-indicador-dato">
                <div class="grafica-circulo ">
                    <span class="indicador-icon"><i class="iconcl-cesantia"></i></span>
                    <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                    <a href="#">
                        <svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
                        <circle class="complete" cx="40" cy="40" r="35"></circle>
                        <text class="percentage" x="50%" y="50%" transform="matrix(0, 1, -1, 0, 80, 0)">1</text>
                        <text class="text-sub" x="50%" y="66%" transform="matrix(0, 1, -1, 0, 80, 0)">MES</text>
                        </svg>
                    </a>
                </div>
                <div class="text">
                    <a href="#" class="title">Cesantías</a>
                    <p>Promedio duración de censantía para este sector a nivel nacional en el último periodo</p>
                </div>
            </div>
        </div>
	<?php
}

//Detalle Sector grupo de indicadores
add_shortcode('sector_crecimiento_detalle_desktop', 'fn_sector_crecimiento_detalle_desktop');
function fn_sector_crecimiento_detalle_desktop() {
	global $wpdb;
	global $id_sector;
	$anio = (date('Y')-1); 

	$sql = "
		select
			cl_sectors.id_sector,
			cl_sectors.name_sector,
			cl_sex.gloss,
			((count(*)*100)/(select count(*) from cl_afc where ano = '".$anio."')) as porcentaje
		from cl_afc
		inner join cl_subclass on (cl_afc.id_subclass = cl_subclass.id_subclass)
		inner join cl_class on (cl_class.id_class = cl_subclass.id_class)
		inner join cl_groups on (cl_class.id_group = cl_groups.id_group)
		inner join cl_divisions on (cl_groups.id_division = cl_divisions.id_division)
		inner join cl_sectors on (cl_divisions.id_sector = cl_sectors.id_sector)
		inner join cl_sex on (cl_afc.id_sex = cl_sex.id_sex)
		where cl_afc.ano = '".$anio."'
		and cl_sectors.id_sector = ".$id_sector."
		and cl_sex.id_sex = 1
		group by cl_sectors.id_sector,
		cl_sectors.name_sector,
		cl_sex.gloss
	";



	$rs_mujer  = $wpdb->get_results($sql);

	if(is_array($rs_mujer) && count($rs_mujer)>0){
			?>
			
           
            <div class="col-12 col-md-6 owl-desktop">
                <div class="bloque-indicador">
                    <div class="grafica-circulo">
                        <span class="indicador-icon"><i class="iconcl-mujeres"></i></span>
                        <a href="<?php echo get_site_url().'/sector-detalle/'.$rs_mujer[0]->id_sector; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                        <a href="<?php echo get_site_url().'/sector-detalle/'.$rs_mujer[0]->id_sector; ?>">
                            <svg class="radial-progress" data-percentage="<?php echo $rs_mujer[0]->porcentaje; ?>" viewBox="0 0 80 80">
                            <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                            <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                            <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $rs_mujer[0]->porcentaje; ?>%</text>
                            </svg>
                        </a>
                    </div>
                    <div class="text">
                        <a href="<?php echo get_site_url().'/sector-detalle/'.$rs_mujer[0]->id_sector; ?>" class="title">Mujeres</a>
                        <p>Porcentaje de mujeres para este sector a nivel nacional en el último periodo</p>
                    </div>
                </div>
            </div>


			<?php
	}

	$sql_sector = "
		select
			cl_sectors.id_sector,
			cl_sectors.name_sector,
			cl_nacionality.gloss,
			((count(*)*100)/(select count(*) from cl_afc where ano = '".$anio."')) as participation
		from cl_afc
		inner join cl_subclass on (cl_afc.id_subclass = cl_subclass.id_subclass)
		inner join cl_class on (cl_class.id_class = cl_subclass.id_class)
		inner join cl_groups on (cl_class.id_group = cl_groups.id_group)
		inner join cl_divisions on (cl_groups.id_division = cl_divisions.id_division)
		inner join cl_sectors on (cl_divisions.id_sector = cl_sectors.id_sector)
		inner join cl_nacionality on (cl_afc.id_nacionality = cl_nacionality.id_nacionality)
		where cl_afc.ano = '".$anio."'
		and cl_nacionality.id_nacionality = 2
		and cl_sectors.id_sector = ".$id_sector."
		group by cl_sectors.id_sector,
		cl_sectors.name_sector,
		cl_nacionality.gloss";
	$rs_migrante  = $wpdb->get_results($sql_sector);

	if(is_array($rs_migrante) && count($rs_migrante)>0){
		
			?>
			<div class="col-12 col-md-6 owl-desktop">
                <div class="bloque-indicador">
                    <div class="grafica-circulo">
                        <span class="indicador-icon"><i class="iconcl-migrante"></i></span>
                        <a href="<?php echo get_site_url().'/sector-detalle/'.$rs_migrante[0]->id_sector; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>
                        <a href="<?php echo get_site_url().'/sector-detalle/'.$rs_migrante[0]->id_sector; ?>">
                            <svg class="radial-progress" data-percentage="<?php echo $rs_migrante[0]->participation; ?>" viewBox="0 0 80 80">
                            <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                            <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                            <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)"><?php echo $rs_migrante[0]->participation; ?>%</text>
                            </svg>
                        </a>
                    </div>
                    <div class="text">
                        <a href="<?php echo get_site_url().'/sector-detalle/'.$rs_migrante[0]->id_sector; ?>" class="title">Migrantes</a>
                        <p>Porcentaje de migrantes para este sector a nivel nacional en el último periodo</p>
                    </div>
                </div>
            </div>
			<?php
	
	}


	//CESANTIA PENDIENTE
	?>
		<div class="col-12 col-md-6 owl-desktop">
            <div class="bloque-indicador-dato">
                <div class="grafica-circulo ">
                    <span class="indicador-icon"><i class="iconcl-cesantia"></i></span>
                    <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                    <a href="#">
                        <svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
                        <circle class="complete" cx="40" cy="40" r="35"></circle>
                        <text class="percentage" x="50%" y="50%" transform="matrix(0, 1, -1, 0, 80, 0)">1</text>
                        <text class="text-sub" x="50%" y="66%" transform="matrix(0, 1, -1, 0, 80, 0)">MES</text>
                        </svg>
                    </a>
                </div>
                <div class="text">
                    <a href="#" class="title">Cesantías</a>
                    <p>Promedio duración de censantía para este sector a nivel nacional en el último periodo</p>
                </div>
            </div>
        </div>
	<?php
}
//Sector con mayor incorporación de nuevos trabajadores
add_shortcode('sector_crecimiento_ingreso_trabajadores_home', 'fn_sector_crecimiento_ingreso_trabajadores_home');
//Sector con mayor incorporación de nuevos trabajadores
function fn_sector_crecimiento_ingreso_trabajadores_home() {
	global $wpdb;

	$anio = (date('Y')-1); 

	$sql = "
		select
			cl_sectors.id_sector,
			cl_sectors.name_sector,
			cl_sector_exit_inputs.number_people
		from cl_sectors 
		inner join cl_sector_exit_inputs on (cl_sectors.id_sector = cl_sector_exit_inputs.id_sector_exit_input)
		order by number_people desc 
		limit 1
	";

	$rs_mujer  = $wpdb->get_results($sql);

	if(is_array($rs_mujer) && count($rs_mujer)>0){
		foreach ($rs_mujer as $row) {
			?>
				
	            <div class="col-12 col-md-6">
                <div class="bloque-icono ">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="icono">
                                <a href="<?php echo get_site_url().'/sector-detalle/'.$row->id_sector; ?>" class="icon-plus"><i class="fal fa-plus"></i></a>    
                                <i class="iconcl-empleados-alza-xl"></i>
                            </div>
                            <div class="text">
                                <span class="title"><?php echo $row->name_sector; ?></span>
                                <p>Sector con mayor incremento en el número de empleados a nivel nacional en el último periodo</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<?php
		}
	}
}?>