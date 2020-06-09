<?php


function digitales_json($data) {
    global $wpdb;

    $sql_region = "
    	select
			cl_telefonica_digitales.id_region
		from cl_telefonica_digitales 
		group by cl_telefonica_digitales.id_region
		order by cl_telefonica_digitales.id_region desc
    ";

    $rs_region = $wpdb->get_results($sql_region);

    $datos_finles = array();
    
    $datos_region = array();
    $datos_value  = array();


    if(is_array($rs_region) && count($rs_region)>0){
    	foreach ($rs_region as $row_region) {

    		$id_region = isset($row_region->id_region) && $row_region->id_region!='' ? (int) $row_region->id_region : '';

    		$sql = "
		    	select
					cl_telefonica_digitales.id,
					cl_telefonica_digitales.title,
					cl_telefonica_digitales.id_region,
					cl_telefonica_digitales.name,
					cl_telefonica_digitales.value,
					wp_postmeta.post_id
				from cl_telefonica_digitales 
				inner join cl_job_positions on (cl_telefonica_digitales.id_occupation = cl_job_positions.id_occupation) and (cl_telefonica_digitales.id_region = ".$row_region->id_region.")
				inner join wp_postmeta  on (wp_postmeta.meta_value::int = cl_job_positions.id_occupation::int)
				inner join wp_posts on (wp_posts.ID = wp_postmeta.post_id)
				where post_type = 'detalle_ocupacion' and wp_postmeta.meta_key = 'id' and cl_telefonica_digitales.id_region = ".$row_region->id_region."
				group by cl_telefonica_digitales.id,
				cl_telefonica_digitales.title,
				cl_telefonica_digitales.id_region,
				cl_telefonica_digitales.name,
				cl_telefonica_digitales.value,
				wp_postmeta.post_id
				order by cl_telefonica_digitales.id_region desc, cl_telefonica_digitales.value desc";
		    //echo $sql;
		    $rs = $wpdb->get_results($sql);
	   		//var_dump($sql);die;
		    
	   		
		    $i=0;
		    $datos_value  = array();
		    if(is_array($rs) && count($rs)>0){
		    	$id_cabecera 		= isset($rs[0]->id) 	&& $rs[0]->id!='' 		? $rs[0]->id : '';
		    	$title_cabecera 	= isset($rs[0]->title) 	&& $rs[0]->title!='' 	? $rs[0]->title : '';

		        foreach ($rs as $row) {
		            $post_id            = isset($row->post_id)            && $row->post_id!=''              ? $row->post_id : '';
		            $code_job_position  = isset($row->code_job_position)  && $row->code_job_position!=''    ? $row->code_job_position : '';
		            $name  				= isset($row->name) 			  && $row->name!=''    				? htmlentities($row->name) : '';
		            $value  			= isset($row->value)  			  && $row->value!=''    			? (int) $row->value : '';
		            $get_permalink      = get_permalink($post_id);
		            $uri_occupation     = $get_permalink;

		            if($i==0){
		            	$datos_value['id'] = $id_region;
		            	$datos_value[$name.'|'.$uri_occupation] = $value;

		            }else{

		            	$datos_value[$name.'|'.$uri_occupation] = $value;
		            }

		            $i++;
		        }
		        $datos_region[] =  $datos_value;

		    	//array_push($datos_region, $datos_value);
		    }else{
		    	$datos_value['id'] = $id_region;
		    	$datos_region[] =  $datos_value;
		    }
    	}
    }
    $datos_finles = array(
		'id' => $id_cabecera,
		'title' => $title_cabecera,
		'values' => $datos_region
	);


    return new WP_REST_Response($datos_finles, 200);
}


add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/digitales_json/', array(
        'methods' => 'GET',
        'callback' => 'digitales_json'
    ) );
} );



function nodigitales_json($data) {
    global $wpdb;

    $sql_region = "
    	select
			cl_telefonica_nodigitales.id_region
		from cl_telefonica_nodigitales 
		group by cl_telefonica_nodigitales.id_region
		order by cl_telefonica_nodigitales.id_region desc
    ";

    $rs_region = $wpdb->get_results($sql_region);

    $datos_finles = array();
    
    $datos_region = array();
    $datos_value  = array();

    if(is_array($rs_region) && count($rs_region)>0){
    	foreach ($rs_region as $row_region) {

    		$id_region = isset($row_region->id_region) && $row_region->id_region!='' ? (int) $row_region->id_region : '';

    		$sql = "
		    	select
					cl_telefonica_nodigitales.id,
					cl_telefonica_nodigitales.title,
					cl_telefonica_nodigitales.id_region,
					cl_telefonica_nodigitales.name,
					cl_telefonica_nodigitales.value
				from cl_telefonica_nodigitales 
				where cl_telefonica_nodigitales.id_region = ".$row_region->id_region."
				group by cl_telefonica_nodigitales.id,
				cl_telefonica_nodigitales.title,
				cl_telefonica_nodigitales.id_region,
				cl_telefonica_nodigitales.name,
				cl_telefonica_nodigitales.value
				order by cl_telefonica_nodigitales.id_region desc, cl_telefonica_nodigitales.value desc";

		    
		    $rs = $wpdb->get_results($sql);

		   // var_dump($rs); die;
		    
		    $i=0;
		    $datos_value  = array();
		    if(is_array($rs) && count($rs)>0){
		    	$id_cabecera 		= isset($rs[0]->id) 	&& $rs[0]->id!='' 		? $rs[0]->id : '';
		    	$title_cabecera 	= isset($rs[0]->title) 	&& $rs[0]->title!='' 	? $rs[0]->title : '';

		        foreach ($rs as $row) {
		            $post_id            = isset($row->post_id)            && $row->post_id!=''              ? $row->post_id : '';
		            $code_job_position  = isset($row->code_job_position)  && $row->code_job_position!=''    ? $row->code_job_position : '';
		            $name  				= isset($row->name) 			  && $row->name!=''    				? $row->name : '';
		            $value  			= isset($row->value)  			  && $row->value!=''    			? (int) $row->value : '';
		            $get_permalink      = get_permalink($post_id);
		            $uri_occupation     = $get_permalink;

		            //array_push($datos_value, array('id' => $id_region, $name.'|'.$uri_occupation => $value));
		            //echo  $post_id.' '.$name;
		            if($i==0){
		            	$datos_value['id'] = $id_region;
		            	$datos_value[$name.'|'.$uri_occupation] = $value;

		            }else{

		            	$datos_value[$name.'|'.$uri_occupation] = $value;
		            }

		            $i++;
		        }
		        $datos_region[] =  $datos_value;

		    }else{
		    	//echo 'hola'; die;
		    	$datos_value['id'] = $id_region;
		    	$datos_region[] =  $datos_value;
		    }
    	}
    }

    $datos_finles = array(
		'id' => $id_cabecera,
		'title' => $title_cabecera,
		'values' => $datos_region
	);


    return new WP_REST_Response($datos_finles, 200);
}


add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/nodigitales_json/', array(
        'methods' => 'GET',
        'callback' => 'nodigitales_json'
    ) );
} );


function habilidades_json($data) {
    global $wpdb;

    $sql_region = "
    	select
			cl_telefonica_nodigitales.id_region
		from cl_telefonica_nodigitales 
		group by cl_telefonica_nodigitales.id_region
		order by cl_telefonica_nodigitales.id_region desc
    ";

    $rs_region = $wpdb->get_results($sql_region);

    $datos_finles = array();
    
    $datos_region = array();
    $datos_value  = array();


    if(is_array($rs_region) && count($rs_region)>0){
    	foreach ($rs_region as $row_region) {

    		$id_region = isset($row_region->id_region) && $row_region->id_region!='' ? (int) $row_region->id_region : '';

    		$sql = "
    			select
					cl_telefonica_habilidades.id,
					cl_telefonica_habilidades.title,
					cl_telefonica_habilidades.id_region,
					cl_telefonica_habilidades.name,
					cl_telefonica_habilidades.value					
				from cl_telefonica_habilidades  
				where cl_telefonica_habilidades.id_region = ".$row_region->id_region."
				group by cl_telefonica_habilidades.id,
				cl_telefonica_habilidades.title,
				cl_telefonica_habilidades.id_region,
				cl_telefonica_habilidades.name,
				cl_telefonica_habilidades.value
				order by cl_telefonica_habilidades.id_region desc, cl_telefonica_habilidades.value desc";


			//var_dump($sql);	 

		    
		    $rs = $wpdb->get_results($sql);

		    $i=0;
		    $datos_value  = array();
		    if(is_array($rs) && count($rs)>0){
		    	$id_cabecera 		= isset($rs[0]->id) 	&& $rs[0]->id!='' 		? $rs[0]->id : '';
		    	$title_cabecera 	= isset($rs[0]->title) 	&& $rs[0]->title!='' 	? $rs[0]->title : '';

		        foreach ($rs as $row) {
		            $post_id            = isset($row->post_id)            && $row->post_id!=''              ? $row->post_id : '';
		            //$code_job_position  = isset($row->code_job_position)  && $row->code_job_position!=''    ? $row->code_job_position : '';
		            $name  				= isset($row->name) 			  && $row->name!=''    				? $row->name : '';
		            $value  			= isset($row->value)  			  && $row->value!=''    			? (int) $row->value : '';
		            $get_permalink      = get_permalink($post_id);
		            $uri_occupation     = $get_permalink;

		            //array_push($datos_value, array('id' => $id_region, $name.'|'.$uri_occupation => $value));

		            if($i==0){
		            	$datos_value['id'] = $id_region;	
		            	$datos_value[$name.'|'.$uri_occupation] = $value;

		            }else{

		            	$datos_value[$name.'|'.$uri_occupation] = $value;
		            }

		            $i++;
		        }
		        $datos_region[] =  $datos_value;
		    }
    	}
    }

    $datos_finles = array(
		'id' => $id_cabecera,
		'title' => $title_cabecera,
		'values' => $datos_region
	);

    return new WP_REST_Response($datos_finles, 200);
}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/habilidades_json/', array(
        'methods' => 'GET',
        'callback' => 'habilidades_json'
    ) );
} );


?>