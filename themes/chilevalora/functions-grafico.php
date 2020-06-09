<?php 


//** Grafico Participación en distintos sectores  **//

function participacion_sector( $data ) {

    global $wpdb;
    $id_occupation = isset($data['id_occupation']) && $data['id_occupation']!='' ? $data['id_occupation'] : '';

    $sql_sector = "
        select 
            sec.id_sector,
            sec.name_sector,
            csp.participation
        from cl_casen_ocupation_sector_participation  as csp
        inner join cl_occupations as oc on (csp.code_ocupation = oc.id_occupation)
        inner join cl_sectors as sec on (csp.code_sector = sec.id_sector)
        where oc.id_occupation= ".$id_occupation."
        and csp.participation > 0
        group by sec.id_sector, sec.name_sector,csp.participation
        order by csp.participation desc
            
    ";
    $rs_sector  = $wpdb->get_results($sql_sector);

    
    $prov = array();
    $count = 0;
    $rs_participacion = array();
    

    if(is_array($rs_sector) && count($rs_sector)>0){
        foreach ($rs_sector as $row) {
            //var_dump($row->id_sector); die;
            $id_sector                          = isset($row->id_sector)        && $row->id_sector !=''      ? $row->id_sector : '';
            $name_sector    = isset($row->name_sector)      && $row->name_sector !=''    ? $row->name_sector : '';
            $participation   = isset($row->participation)    && $row->participation!=''   ? (float) number_format(($row->participation*100), 2) : '';

            $sql_oc = "
                select 
                    oc.name_occupation,
                    (csp.participation) as participation
                from cl_casen_ocupation_sector_participation  as csp
                inner join cl_occupations as oc on (csp.code_ocupation = oc.id_occupation)
                where csp.code_sector = ".$id_sector."
                and participation > 0
                
            ";
             $rs_ocupacion = array();
            
            $rs_ocupacion[$name_sector] =   array(
                                'value' => $participation
                        
                    );
            $rs_participacion[$name_sector] = $rs_ocupacion;

            $count++;
        }

        $rs_response = (object) $rs_participacion;
        return new WP_REST_Response($rs_response, 200);
    }else{
        return new WP_REST_Response(null, 200);
    }

}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/participacion_sector/(?P<id_occupation>\d+)', array(
        'methods' => 'GET',
        'callback' => 'participacion_sector',
        'args' => array(
            'id_occupation' => array(
                'validate_callback' => function($param, $request, $key) {
                    return  is_numeric($param);
                }
            ),
        ),
    ) );
} );


//** Grafico Tasa de crecimiento ocupados  **//

function crecimiento_ocupados( $data ) {

    global $wpdb;

    $id_occupation = isset($data['id_occupation']) && $data['id_occupation']!='' ? $data['id_occupation'] : '';

    if(is_numeric($id_occupation)){
        $sql = "
            select 
                oc.id_occupation,
                oc.name_occupation,
                cbc.number_occupied,
                cbc.ano
            from cl_busy_casen cbc
            inner join cl_occupations oc on(cbc.id_occupation = oc.id_occupation)
            where oc.id_occupation = ".$id_occupation."
            order by cbc.ano asc
        ";

        $rs = $wpdb->get_results($sql);

        $rs_response = (array) $rs;
        return new WP_REST_Response($rs_response, 200);
    }else{
        return new WP_REST_Response(null, 200);
    }
    

}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/crecimiento_ocupados/(?P<id_occupation>\d+)', array(
        'methods' => 'GET',
        'callback' => 'crecimiento_ocupados',
        'args' => array(
            'id_occupation' => array(
                'validate_callback' => function($param, $request, $key) {
                    return  is_numeric($param);
                }
            ),
        ),
        
    ) );
} );

//** Grafico variacion sector  **//

function crecimiento_sectores( $data ) {

    global $wpdb;

    $id_sector = isset($data['id_sector']) && $data['id_sector']!='' ? $data['id_sector'] : '';

    if(is_numeric($id_sector)){
        $sql = "
            select
                sec.id_sector,
                sec.name_sector,
                ca.ano,
                (ca.mes-1) as mes,
                sum(ca.number_workers) as number_workers
            from cl_afc ca
            inner join cl_class clss on (ca.id_subclass = clss.id_class)
            inner join cl_subclass sbca on (clss.id_class = sbca.id_class)
            inner join cl_groups grp on (clss.id_group = grp.id_group)
            inner join cl_divisions divs on (grp.id_division = divs.id_division)
            inner join cl_sectors sec on (divs.id_sector = sec.id_sector)
            where sec.id_sector = ".$id_sector."
            group by sec.id_sector, sec.name_sector,ca.ano,ca.mes
            order by ca.ano, ca.mes asc";
        //echo $sql;
        $rs = $wpdb->get_results($sql);
        $array_data = array();
        if(is_array($rs) && count($rs)>0){
            foreach ($rs as $row) {
                $name_sector    = isset($row->name_sector)      && $row->name_sector!=''        ? $row->name_sector : '';
                $number_workers = isset($row->number_workers)   && $row->number_workers!=''     ? (int) $row->number_workers : '';
                $ano            = isset($row->ano)              && $row->ano!=''                ? (int) $row->ano : '';
                $mes            = isset($row->mes)              && $row->mes!=''                ? (int) $row->mes : '';
                $fecha          = (int) (mktime(0, 0, 0, $mes, 1, $ano)*1000);

                array_push($array_data, array('name_sector' => $name_sector,'fecha' => $fecha, 'value' => $number_workers, 'ano' => $ano, 'mes' => $mes));
                //array_push($array_data, array('fecha' => $fecha, 'value' => $number_workers));
            }
        }

        $rs_response = (array) $array_data;
        return new WP_REST_Response($rs_response, 200);
    }else{
        return new WP_REST_Response(null, 200);
    }
    

}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/crecimiento_sectores/(?P<id_sector>\d+)', array(
        'methods' => 'GET',
        'callback' => 'crecimiento_sectores',
        'args' => array(
            'id_sector' => array(
                'validate_callback' => function($param, $request, $key) {
                    return  is_numeric($param);
                }
            ),
        ),
        
    ) );
} );



//** Grafico contratos indefinidos x sector  **//

function contratos_indefinidos_sectores( $data ) {

    global $wpdb;

    $id_sector = isset($data['id_sector']) && $data['id_sector']!='' ? $data['id_sector'] : '';

    if(is_numeric($id_sector)){
        $sql = "
            select
                sec.id_sector,
                sec.name_sector,
                ca.ano,
                cont.name_contract_type,
                sum(ca.number_workers) as number_workers
            from cl_afc ca
            inner join cl_class clss on (ca.id_subclass = clss.id_class)
            inner join cl_subclass sbca on (clss.id_class = sbca.id_class)
            inner join cl_groups grp on (clss.id_group = grp.id_group)
            inner join cl_divisions divs on (grp.id_division = divs.id_division)
            inner join cl_sectors sec on (divs.id_sector = sec.id_sector)
            inner join cl_contract_type cont on(ca.id_contract_type = cont.id_contract_type)
            where sec.id_sector = ".$id_sector."
            and cont.id_contract_type = 1
            group by sec.id_sector, sec.name_sector,ca.ano, cont.name_contract_type
            order by sec.name_sector asc, ca.ano asc,sum(ca.number_workers) desc
        ";

        $rs = $wpdb->get_results($sql);

        $cont               = 0;
        $i                  = 0;
        $name_sector      = '';
        $name_sector_old  = '';
        $data               = array();
        $data_old           = array();
        $rs_indefinidos_tmp = array();
        $rs_indefinidos     = array();
        $ejeX               = array();
        $datos_finles       = array();
        $valor_pasado       = 0;
        $valor_presente     = 0;
        $variacion          = 0;

        array_push($ejeX, 0);

        if(is_array($rs) && count($rs)>0){
            foreach ($rs as $row) {
                $name_sector    = isset($row->name_sector)      && $row->name_sector!=''        ?  $row->name_sector : '';
                $number_workers = isset($row->number_workers)   && $row->number_workers!=''     ?  (float) $row->number_workers : '';
                $ano            = isset($row->ano)              && $row->ano!=''                ?  (float) $row->ano : '';

                array_push($ejeX, $ano);
                if($i == 0){
                    $valor_pasado   = $number_workers;
                    array_push($data_old, 0);
                }else{
                    $valor_presente = $number_workers;
                    if($valor_presente>$valor_pasado){
                        $variacion = (float) number_format(((($valor_presente - $valor_pasado)/$valor_pasado)*100), 2);
                    }
                    if($valor_presente<$valor_pasado){
                        $variacion = (float) number_format(((($valor_pasado - $valor_presente)/$valor_presente)*100), 2);
                    }

                    array_push($data_old, $variacion);

                    //$i = -1;
                }

                $i++;
            }

            $rs_indefinidos = array(
                'name' => $name_sector,
                'data' => $data_old
            );
            $rs_response = (array) $rs_indefinidos;

            $datos_finles = array(
                'data_grafico'  => $rs_response,
                'ejeX'          => $ejeX
            );

            return new WP_REST_Response($datos_finles, 200);
        }else{
            return new WP_REST_Response(null, 200);
        }
        
    }else{
        return new WP_REST_Response(null, 200);
    }
}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/contratos_indefinidos_sectores/(?P<id_sector>\d+)', array(
        'methods' => 'GET',
        'callback' => 'contratos_indefinidos_sectores',
        'args' => array(
            'id_sector' => array(
                'validate_callback' => function($param, $request, $key) {
                    return  is_numeric($param);
                }
            ),
        ),
        
    ) );
} );

//** Grafico Series NAME indefinidos x sector  **//

function contratos_indefinidos_subsectores_names( $data ) {

    global $wpdb;

    $id_sector = isset($data['id_sector']) && $data['id_sector']!='' ? $data['id_sector'] : '';


    if(is_numeric($id_sector)){

        $sql_name_sector = "select name_sector from cl_sectors where id_sector=".$id_sector;
        $rs_name_sector = $wpdb->get_results($sql_name_sector);


        $sql = "
            
            select  a.id_sector, a.sub_sector, a.name_subsector 
            from (select cs.id_sector, cc.id_class as sub_sector, cc.name_class as name_subsector
            from cl_afc ca, cl_sectors cs, cl_class cc, cl_divisions cd , cl_groups cg
            where ca.id_contract_type = 1
            and cc.id_class = ca.id_subclass and cg.id_group = cc.id_group
            and cd.id_division = cg.id_division and cs.id_sector = cd.id_sector
            group by cs.id_sector, sub_sector, ca.ano, ca.mes
            order by cs.id_sector) as a, 
            (select cs.id_sector,ca.id_subclass as sub_sector
            from cl_afc ca, cl_sectors cs, cl_class cc, cl_divisions cd , cl_groups cg
            where cc.id_class = ca.id_subclass and cg.id_group = cc.id_group
            and cd.id_division = cg.id_division and cs.id_sector = cd.id_sector 
            group by cs.id_sector, sub_sector
            order by ca.id_subclass) as b
            where a.id_sector = b.id_sector and a.sub_sector = b.sub_sector and a.id_sector = ".$id_sector."
            group by a.id_sector, a.sub_sector, a.name_subsector 
            order by sub_sector
            ";
        //echo $sql;
        $rs = $wpdb->get_results($sql);
        $array_data = array();
        $rs_name_subsector = '(';
        $cont = 0;
        $rs_id_cabecera =[];
        $rs_name_cabecera =[];
        if(is_array($rs) && count($rs)>0){
            foreach ($rs as $row) {
                $id_sector      = isset($row->id_sector)        && $row->id_sector!=''        ? $row->id_sector : '';
                $sub_sector     = isset($row->sub_sector)       && $row->sub_sector!=''       ? $row->sub_sector : '';
                $name_subsector = isset($row->name_subsector)   && $row->name_subsector!=''   ? $row->name_subsector : '';
                

                array_push($array_data, array('sub_sector' => $sub_sector,'name_subsector' => $name_subsector));

                $rs_id_cabecera[$sub_sector] = $cont;
                $rs_name_cabecera[$sub_sector] = $name_subsector;

                $cont++;

                if(count($rs) == $cont){
                    $rs_name_subsector .= (string) $sub_sector;
                }else{
                    $rs_name_subsector .= (string) $sub_sector.'|';
                }
            }
        }
        $rs_name_subsector .= ')';

        $rs_response = array('rs_cabecera' => $rs_id_cabecera, 'name_match' => $rs_name_subsector, 'data' => $array_data, 'rs_name_cabecera' => $rs_name_cabecera , 'rs_name_sector' => $rs_name_sector[0]->name_sector);
        return new WP_REST_Response($rs_response, 200);
    }else{
        return new WP_REST_Response(null, 200);
    }
    

}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/contratos_indefinidos_subsectores_names/(?P<id_sector>\d+)', array(
        'methods' => 'GET',
        'callback' => 'contratos_indefinidos_subsectores_names',
        'args' => array(
            'id_sector' => array(
                'validate_callback' => function($param, $request, $key) {
                    return  is_numeric($param);
                }
            ),
        ),
        
    ) );
} );

//** Grafico contratos indefinidos x sector  **//

function contratos_indefinidos_subsectores( $data ) {

    global $wpdb;

    $id_sector = isset($data['id_sector']) && $data['id_sector']!='' ? $data['id_sector'] : '';
    $sub_sector = isset($data['sub_sector']) && $data['sub_sector']!='' ? $data['sub_sector'] : '';

    if(is_numeric($id_sector)){
        // $sql = "
            
        //     select a.ano, a.mes, a.id_sector, a.name_sector, a.sub_sector, a.name_subsector, round(cast(((a.contratados::float*100)/b.total::float) as numeric), 1) as porcentaje
        //     from (select cs.id_sector, cs.name_sector, cc.id_class as sub_sector, cc.name_class as name_subsector, sum(ca.number_workers::float) as contratados, ca.ano, ca.mes
        //     from cl_afc ca, cl_sectors cs, cl_class cc, cl_divisions cd , cl_groups cg
        //     where ca.id_contract_type = 1
        //     and cc.id_class = ca.id_subclass and cg.id_group = cc.id_group
        //     and cd.id_division = cg.id_division and cs.id_sector = cd.id_sector
        //     group by cs.id_sector, sub_sector, ca.ano, ca.mes
        //     order by cs.id_sector) as a, 
        //     (select cs.id_sector, cs.name_sector, ca.id_subclass as sub_sector, sum(ca.number_workers::float) as total
        //     from cl_afc ca, cl_sectors cs, cl_class cc, cl_divisions cd , cl_groups cg
        //     where cc.id_class = ca.id_subclass and cg.id_group = cc.id_group
        //     and cd.id_division = cg.id_division and cs.id_sector = cd.id_sector 
        //     group by cs.id_sector, sub_sector
        //     order by cs.id_sector) as b
        //     where a.id_sector = b.id_sector and a.sub_sector = b.sub_sector and a.id_sector = ".$id_sector." 
        //     order by porcentaje desc
        // ";
        $sql = "
            
            select distinct a.ano, a.mes, a.id_sector, a.name_sector, a.sub_sector, a.name_subsector, a.contratados::float as porcentaje
            from (select cs.id_sector, cs.name_sector, cc.id_class as sub_sector, cc.name_class as name_subsector, sum(ca.number_workers::float) as contratados, ca.ano, ca.mes
            from cl_afc ca, cl_sectors cs, cl_class cc, cl_divisions cd , cl_groups cg
            where ca.id_contract_type = 1
            and cc.id_class = ca.id_subclass and cg.id_group = cc.id_group
            and cd.id_division = cg.id_division and cs.id_sector = cd.id_sector
            group by cs.id_sector, sub_sector, ca.ano, ca.mes
            order by cs.id_sector) as a, 
            (select cs.id_sector, cs.name_sector, ca.id_subclass as sub_sector, sum(ca.number_workers::float) as total
            from cl_afc ca, cl_sectors cs, cl_class cc, cl_divisions cd , cl_groups cg
            where cc.id_class = ca.id_subclass and cg.id_group = cc.id_group
            and cd.id_division = cg.id_division and cs.id_sector = cd.id_sector 
            group by cs.id_sector, sub_sector
            order by cs.id_sector) as b
            where a.id_sector = b.id_sector and a.sub_sector = ".$sub_sector." and a.id_sector = ".$id_sector." 
            order by a.ano asc, a.mes asc
        ";

        $rs = $wpdb->get_results($sql);

        $cont               = 0;
        $i                  = 0;
        $name_subsector      = '';
        $name_subsector_old  = '';
        $data               = array();
        $data_old           = array();
        $rs_indefinidos_tmp = array();
        $rs_indefinidos     = array();
        $ejeX               = array();
        $result             = array();
        //var_dump(count($rs)); die;
        $array_data = array();
        if(is_array($rs) && count($rs)>0){
            foreach ($rs as $row) {
                $name_subsector = isset($row->name_subsector)   && $row->name_subsector!=''     ? $row->name_subsector : '';
                $porcentaje     = isset($row->porcentaje)       && $row->porcentaje!=''         ? (int) $row->porcentaje : '';
                $ano            = isset($row->ano)              && $row->ano!=''                ? (int) $row->ano : '';
                $mes            = isset($row->mes)              && $row->mes!=''                ? (int) $row->mes : '';
                $fecha          = (int) (mktime(0, 0, 0, $mes, 1, $ano)*1000);

                //array_push($array_data, array('name_sector' => $name_subsector,'fecha' => $fecha, 'value' => $porcentaje, 'ano' => $ano, 'mes' => $mes));

                array_push($array_data, array($fecha, $porcentaje));
            }
            
            $rs_response = (array) $array_data;
            return new WP_REST_Response($rs_response, 200);

        }else{
            return new WP_REST_Response(null, 200);
        }

        
    }else{
        return new WP_REST_Response(null, 200);
    }
}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/contratos_indefinidos_subsectores/(?P<id_sector>\d+)/(?P<sub_sector>\d+)', array(
        'methods' => 'GET',
        'callback' => 'contratos_indefinidos_subsectores',
        'args' => array(
            'id_sector' => array(
                'validate_callback' => function($param, $request, $key) {
                    return  is_numeric($param);
                }
            ),
            'sub_sector' => array(
                'validate_callback' => function($param, $request, $key) {
                    return  is_numeric($param);
                }
            ),
        ),
        
    ) );
} );


//** Grafico Crecimiento Mujeres **//

function crecimiento_mujeres_setores( $data ) {

    global $wpdb;

    $id_sector = isset($data['id_sector']) && $data['id_sector']!='' ? $data['id_sector'] : '';

    if(is_numeric($id_sector)){
        $sql = "
            select a.ano, a.id_sector, a.name_sector, a.sub_sector, a.name_subsector, round(cast(((a.mujeres::float*100)/b.total::float) as numeric), 1) as porcentaje
            from (select cs.id_sector, cs.name_sector, cc.id_class as sub_sector, cc.name_class as name_subsector, sum(ca.number_workers::float) as mujeres, ca.ano
            from cl_afc ca, cl_sectors cs, cl_class cc, cl_divisions cd , cl_groups cg
            where ca.ano = (select MAX(ano) from cl_afc) and ca.mes= (select MAX(mes) from cl_afc where ano = (select MAX(ano) from cl_afc)) 
            and ca.id_sex = 1 and cc.id_class = ca.id_subclass  and cg.id_group = cc.id_group
            and cd.id_division = cg.id_division and cs.id_sector = cd.id_sector
            group by cs.id_sector, sub_sector, ca.ano
            order by cs.id_sector) as a, 
            (select cs.id_sector, cs.name_sector, ca.id_subclass as sub_sector, sum(ca.number_workers::float) as total
            from cl_afc ca, cl_sectors cs, cl_class cc, cl_divisions cd , cl_groups cg
            where ca.ano = (select MAX(ano) from cl_afc) and ca.mes= (select MAX(mes) from cl_afc where ano = (select MAX(ano) from cl_afc))
            and cc.id_class = ca.id_subclass and cg.id_group = cc.id_group
            and cd.id_division = cg.id_division and cs.id_sector = cd.id_sector
            group by cs.id_sector, sub_sector
            order by cs.id_sector) as b
            where a.id_sector = b.id_sector and a.sub_sector = b.sub_sector and a.id_sector = ".$id_sector."
            order by porcentaje desc, a.name_subsector asc
        ";

        $rs = $wpdb->get_results($sql);

        //echo $sql; die;

        $cont               = 0;
        $i                  = 0;
        $name_subsector      = '';
        $name_sector_old  = '';
        $data               = array();
        $data_old           = array();
        $data = array();
        $rs_indefinidos     = array();
        $ejeX               = array();
        $datos_finles       = array();
        //var_dump(count($rs)); die;

        if(is_array($rs) && count($rs)>0){
            foreach ($rs as $row) {
                $name_subsector  = isset($row->name_subsector)          && $row->name_subsector!=''      ?  $row->name_subsector : '';
                $porcentaje = isset($row->porcentaje)           && $row->porcentaje!=''     ?  (float) $row->porcentaje : '';
                $ano            = isset($row->ano)                      && $row->ano!=''                ?  (float) $row->ano : '';

                array_push($ejeX, $name_subsector);

                array_push($data, $porcentaje);
                $i++; 
            }
            $datos_finles = array(
                'data_grafico' => array(
                    'name'  => 'Porcentaje de mujeres',
                    'data'  => $data
                ),
                'ejeX'          => $ejeX,
                'name_sector' => $rs[0]->name_sector,
            );
            $datos_finles = (array) $datos_finles;

            return new WP_REST_Response($datos_finles, 200);
        }else{
            return new WP_REST_Response(null, 200);
        }

        
    }else{
        return new WP_REST_Response(null, 200);
    }
}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/crecimiento_mujeres_setores/(?P<id_sector>\d+)', array(
        'methods' => 'GET',
        'callback' => 'crecimiento_mujeres_setores',
        'args' => array(
            'id_sector' => array(
                'validate_callback' => function($param, $request, $key) {
                    return  is_numeric($param);
                }
            ),
        ),
        
    ) );
} );


//** Grafico Crecimiento Migrantes **//

function crecimiento_migrantes_setores( $data ) {


    global $wpdb;

    $id_sector = isset($data['id_sector']) && $data['id_sector']!='' ? $data['id_sector'] : '';

    if(is_numeric($id_sector)){
        $sql = "
        select a.ano, a.id_sector, a.name_sector, a.sub_sector, a.name_subsector, round(cast(((a.migrantes::float*100)/b.total::float) as numeric), 1) as porcentaje
        from (select cs.id_sector, cs.name_sector, cc.id_class as sub_sector, cc.name_class as name_subsector, sum(ca.number_workers::float) as migrantes, ca.ano
        from cl_afc ca, cl_sectors cs, cl_class cc, cl_divisions cd, cl_groups cg
        where ca.ano = (select MAX(ano) from cl_afc) and ca.mes= (select MAX(mes) from cl_afc where ano = (select MAX(ano) from cl_afc)) and ca.id_nacionality = 2
        and cc.id_class = ca.id_subclass and cg.id_group = cc.id_group
        and cd.id_division = cg.id_division and cs.id_sector = cd.id_sector
        group by cs.id_sector, sub_sector, ca.ano
        order by cs.id_sector) as a, 
        (select cs.id_sector, cs.name_sector, ca.id_subclass as sub_sector, sum(ca.number_workers::float) as total
        from cl_afc ca, cl_sectors cs, cl_class cc, cl_divisions cd , cl_groups cg
        where ca.ano = (select MAX(ano) from cl_afc) and ca.mes= (select MAX(mes) from cl_afc where ano = (select MAX(ano) from cl_afc))
        and cc.id_class = ca.id_subclass and cg.id_group = cc.id_group
        and cd.id_division = cg.id_division and cs.id_sector = cd.id_sector
        group by cs.id_sector, sub_sector
        order by cs.id_sector) as b
        where a.id_sector = b.id_sector and a.sub_sector = b.sub_sector and a.id_sector = ".$id_sector."
        order by porcentaje desc, a.name_subsector asc

        ";

        $rs = $wpdb->get_results($sql);

        echo $sql; die;

        $cont               = 0;
        $i                  = 0;
        $name_subsector      = '';
        $name_sector_old  = '';
        $data               = array();
        $data_old           = array();
        $data = array();
        $rs_indefinidos     = array();
        $ejeX               = array();
        $datos_finles       = array();
        //var_dump(count($rs)); die;

        if(is_array($rs) && count($rs)>0){
            foreach ($rs as $row) {
                $name_subsector  = isset($row->name_subsector)            && $row->name_subsector!=''      ?  $row->name_subsector : '';
                $porcentaje = isset($row->porcentaje)           && $row->porcentaje!=''     ?  (float) $row->porcentaje : '';
                $ano            = isset($row->ano)                      && $row->ano!=''                ?  (float) $row->ano : '';

                array_push($ejeX, $name_subsector);

                array_push($data, $porcentaje);
                $i++; 
            }

            $datos_finles = array(
                'data_grafico' => array(
                    'name'  => '% de migrantes por subsector',
                    'data'  => $data
                ),
                'ejeX'          => $ejeX
            );
            $datos_finles = (array) $datos_finles;

            return new WP_REST_Response($datos_finles, 200);
        }else{
            return new WP_REST_Response(null, 200);
        }

        
    }else{
        return new WP_REST_Response(null, 200);
    }

}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/crecimiento_migrantes_setores/(?P<id_sector>\d+)', array(
        'methods' => 'GET',
        'callback' => 'crecimiento_migrantes_setores',
        'args' => array(
            'id_sector' => array(
                'validate_callback' => function($param, $request, $key) {
                    return  is_numeric($param);
                }
            ),
        ),
        
    ) );
} );


//** Grafico Rotacion Sectores **//

function crecimiento_rotacion_setores( $data ) {


    global $wpdb;

    $id_sector = isset($data['id_sector']) && $data['id_sector']!='' ? $data['id_sector'] : '';

    if(is_numeric($id_sector)){
        $sql = "
            select 
                distinct
                cs_ou.id_sector_exit,
                cs1.name_sector as name_sector_exit,
                cs_ou.id_sector_input,
                cs2.name_sector as name_sector_input,
                (((cs_ou.number_people::float)*100)/(select Sum(number_people::float) from cl_sector_exit_inputs where id_sector_exit=".$id_sector.")) as porcentaje,
                cs_ou.ano
            from cl_sector_exit_inputs cs_ou 
            inner join cl_sectors cs1 on (cs_ou.id_sector_exit = cs1.id_sector)
            inner join cl_sectors cs2 on (cs_ou.id_sector_input = cs2.id_sector)
            where cs_ou.id_sector_exit = ".$id_sector."
            and cs_ou.ano in (select max(ano) from cl_sector_exit_inputs where id_sector_exit=".$id_sector.")
        ";

        $rs = $wpdb->get_results($sql);

        $data               = array();
        $data_old           = array();
        $data = array();
        $rs_indefinidos     = array();
        $ejeX               = array();
        $datos_finles       = array();
        //var_dump(count($rs)); die;

        if(is_array($rs) && count($rs)>0){
            foreach ($rs as $row) {
                $name_sector_exit  = isset($row->name_sector_exit)            && $row->name_sector_exit!=''      ?  $row->name_sector_exit : '';
                $name_sector_input = isset($row->name_sector_input)           && $row->name_sector_input!=''     ?  $row->name_sector_input : '';
                $porcentaje        = isset($row->porcentaje)                  && $row->porcentaje!=''            ?  (float) number_format($row->porcentaje, 2) : '';
                $ano                = isset($row->ano)                        && $row->ano!=''                   ?  (float) $row->ano : '';

                array_push($data, array('name' => $ano , 'from' => $name_sector_exit, 'to' => $name_sector_input, 'weight' => $porcentaje));
                //array_push($data, array($ano , $name_sector_exit, $name_sector_input, $porcentaje));
            }
            $datos_finles = (array) $data;

            return new WP_REST_Response($datos_finles, 200);
        }else{
            return new WP_REST_Response(null, 200);
        }

    }else{
        return new WP_REST_Response(null, 200);
    }

}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/crecimiento_rotacion_setores/(?P<id_sector>\d+)', array(
        'methods' => 'GET',
        'callback' => 'crecimiento_rotacion_setores',
        'args' => array(
            'id_sector' => array(
                'validate_callback' => function($param, $request, $key) {
                    return  is_numeric($param);
                }
            ),
        ),
        
    ) );
} );


//** Grafico Nuevos Trabajadores **//

function crecimiento_nuevos_trabajadores( $data ) {


    global $wpdb;

    //$id_sector = isset($data['id_sector']) && $data['id_sector']!='' ? $data['id_sector'] : '';

    
        $sql = "
           select
            sec.id_sector,
            sec.name_sector,
            ca.ano,
            (((select sum(seci2.number_people::float) from cl_sector_initiators seci2 where sec.id_sector = seci2.id_sector and ca.ano::int = seci2.ano::int)*100)/(select sum(seci3.number_people::float) from cl_sector_initiators seci3)) as porcentaje
        from cl_afc ca
        inner join cl_class clss on (ca.id_subclass = clss.id_class)
        inner join cl_subclass sbca on (clss.id_class = sbca.id_class)

        inner join cl_groups grp on (clss.id_group = grp.id_group)
        inner join cl_divisions divs on (grp.id_division = divs.id_division)
        inner join cl_sectors sec on (divs.id_sector = sec.id_sector)
        inner join cl_sector_initiators seci on (sec.id_sector = seci.id_sector) and (ca.ano::int = seci.ano::int) 
        group by sec.id_sector, sec.name_sector, ca.ano
        order by porcentaje desc
        ";

        $rs = $wpdb->get_results($sql);

        $data               = array();
        $data_old           = array();
        $data = array();
        $rs_indefinidos     = array();
        $ejeX               = array();
        $datos_finles       = array();
        //var_dump(count($rs)); die;

        if(is_array($rs) && count($rs)>0){
            foreach ($rs as $row) {
                $name_sector  = isset($row->name_sector)          && $row->name_sector!=''    ?  $row->name_sector : '';
                $porcentaje   = isset($row->porcentaje)           && $row->porcentaje!=''     ?  (float) number_format($row->porcentaje, 2) : '';
                $ano          = isset($row->ano)                  && $row->ano!=''            ?  (int) $row->ano : '';

                array_push($ejeX, $name_sector);

                array_push($data, $porcentaje);
                $i++; 
            }
            $datos_finles = array(
                'data_grafico' => array(
                    'name'  => '% de nuevos trabajadores',
                    'data'  => $data
                ),
                'ejeX'          => $ejeX
            );
            $datos_finles = (array) $datos_finles;

            return new WP_REST_Response($datos_finles, 200);
        }else{
            return new WP_REST_Response(null, 200);
        }

        
    

}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/crecimiento_nuevos_trabajadores', array(
        'methods' => 'GET',
        'callback' => 'crecimiento_nuevos_trabajadores',
        
    ) );
} );

//**  Dashboard **//
//** Grafico variacion sector  **//

function crecimiento_sectores_dashboard(  ) {

    global $wpdb;

    $sql = "
        select
            sec.id_sector,
            sec.name_sector,
            ca.ano,
            sum(ca.number_workers) as number_workers
        from cl_afc ca
        inner join cl_class clss on (ca.id_subclass = clss.id_class)
        inner join cl_subclass sbca on (clss.id_class = sbca.id_class)
        inner join cl_groups grp on (clss.id_group = grp.id_group)
        inner join cl_divisions divs on (grp.id_division = divs.id_division)
        inner join cl_sectors sec on (divs.id_sector = sec.id_sector)
        where ca.ano::int in (select max(ano::int) from cl_afc)
        group by sec.id_sector, sec.name_sector,ca.ano
        order by sum(ca.number_workers) desc
    ";

    $rs = $wpdb->get_results($sql);
    
    $name_sector    = '';
    $number_workers = '';
    $data           = array();
    $ejeX           = array();
    $datos_finles   = array();

    if(is_array($rs) && count($rs)>0){
        foreach ($rs as $row) {
            $name_sector  = isset($row->name_sector)          && $row->name_sector!=''      ?  $row->name_sector : '';
            $number_workers = isset($row->number_workers)           && $row->number_workers!=''     ?  (float) $row->number_workers : '';
            $ano            = isset($row->ano)                      && $row->ano!=''                ?  (float) $row->ano : '';

            array_push($ejeX, $name_sector);

            array_push($data, $number_workers);
            $i++; 
        }
        $datos_finles = array(
            'data_grafico' => array(
                'name'  => 'N° de ocupados del año '.$ano,
                'data'  => $data
            ),
            'ejeX'          => $ejeX
        );
        $datos_finles = (array) $datos_finles;

        return new WP_REST_Response($datos_finles, 200);
    }else{
        return new WP_REST_Response(false, 200);
    }

    
    
    

}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/crecimiento_sectores_dashboard/', array(
        'methods' => 'GET',
        'callback' => 'crecimiento_sectores_dashboard'
        
    ) );
} );

//** Grafico variacion sector OLD YEAR **//

function crecimiento_sectores_dashboard_old(  ) {

    global $wpdb;

    $sql = "
        select
            sec.id_sector,
            sec.name_sector,
            ca.ano,
            sum(ca.number_workers) as number_workers
        from cl_afc ca
        inner join cl_class clss on (ca.id_subclass = clss.id_class)
        inner join cl_subclass sbca on (clss.id_class = sbca.id_class)
        inner join cl_groups grp on (clss.id_group = grp.id_group)
        inner join cl_divisions divs on (grp.id_division = divs.id_division)
        inner join cl_sectors sec on (divs.id_sector = sec.id_sector)
        where ca.ano::int in (select (max(ano::int)-1) from cl_afc)
        group by sec.id_sector, sec.name_sector,ca.ano
        order by sum(ca.number_workers) desc
    ";

    $rs = $wpdb->get_results($sql);
    
    $name_sector    = '';
    $number_workers = '';
    $data           = array();
    $ejeX           = array();
    $datos_finles   = array();

    if(is_array($rs) && count($rs)>0){
        foreach ($rs as $row) {
            $name_sector  = isset($row->name_sector)          && $row->name_sector!=''      ?  $row->name_sector : '';
            $number_workers = isset($row->number_workers)           && $row->number_workers!=''     ?  (float) $row->number_workers : '';
            $ano            = isset($row->ano)                      && $row->ano!=''                ?  (float) $row->ano : '';

            array_push($ejeX, $name_sector);

            array_push($data, $number_workers);
            $i++; 
        }
        $datos_finles = array(
            'data_grafico' => array(
                'name'  => 'N° de ocupados del año '.$ano,
                'data'  => $data
            ),
            'ejeX'          => $ejeX
        );
        $datos_finles = (array) $datos_finles;

        return new WP_REST_Response($datos_finles, 200);
    }else{
        return new WP_REST_Response(false, 200);
    }

    
    
    

}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/crecimiento_sectores_dashboard_old/', array(
        'methods' => 'GET',
        'callback' => 'crecimiento_sectores_dashboard_old'
        
    ) );
} );


/** Dashboard XX% de contratos indefinidos **/

function contratos_indefinidos_sectores_dashboard(  ) {

    global $wpdb;

    $sql = "
        select 
            a.ano, 
            a.id_sector, 
            a.name_sector, 
            round(cast(((a.contratados::float*100)/b.total::float) as numeric), 1) as porcentaje
        from (select cs.id_sector, cs.name_sector, sum(ca.number_workers::float) as contratados, ca.ano
        from cl_afc ca, cl_sectors cs, cl_class cc, cl_divisions cd , cl_groups cg
        where ca.id_contract_type = 1
        and ano::int in (select max(ano::int) from cl_afc)
        and cc.id_class = ca.id_subclass and cg.id_group = cc.id_group
        and cd.id_division = cg.id_division and cs.id_sector = cd.id_sector
        group by cs.id_sector, ca.ano
        order by cs.id_sector) as a, 
        (select cs.id_sector, cs.name_sector, sum(ca.number_workers::float) as total
        from cl_afc ca, cl_sectors cs, cl_class cc, cl_divisions cd , cl_groups cg
        where cc.id_class = ca.id_subclass and cg.id_group = cc.id_group
        and cd.id_division = cg.id_division and cs.id_sector = cd.id_sector 
        group by cs.id_sector, name_sector
        order by cs.id_sector) as b
        where a.id_sector = b.id_sector 
        order by porcentaje desc
    ";

    $rs = $wpdb->get_results($sql);
    
    $name_sector    = '';
    $porcentaje = '';
    $data           = array();
    $ejeX           = array();
    $datos_finles   = array();

    if(is_array($rs) && count($rs)>0){
        foreach ($rs as $row) {
            $name_sector  = isset($row->name_sector)          && $row->name_sector!=''      ?  $row->name_sector : '';
            $porcentaje = isset($row->porcentaje)           && $row->porcentaje!=''     ?  (float) $row->porcentaje : '';
            $ano            = isset($row->ano)                      && $row->ano!=''                ?  (float) $row->ano : '';

            array_push($ejeX, $name_sector);

            array_push($data, $porcentaje);
            $i++; 
        }
        $datos_finles = array(
            'data_grafico' => array(
                'name'  => 'XX% de contratos indefinidos del año '.$ano,
                'data'  => $data
            ),
            'ejeX'          => $ejeX
        );
        $datos_finles = (array) $datos_finles;

        return new WP_REST_Response($datos_finles, 200);

    }else{

        return new WP_REST_Response(false, 200);
    }

    
    
    

}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/contratos_indefinidos_sectores_dashboard/', array(
        'methods' => 'GET',
        'callback' => 'contratos_indefinidos_sectores_dashboard'
        
    ) );
} );


/** Dashboard XX% de contratos indefinidos OLD YEAR**/

function contratos_indefinidos_sectores_dashboard_old(  ) {

    global $wpdb;

    $sql = "
        select 
            a.ano, 
            a.id_sector, 
            a.name_sector, 
            round(cast(((a.contratados::float*100)/b.total::float) as numeric), 1) as porcentaje
        from (select cs.id_sector, cs.name_sector, sum(ca.number_workers::float) as contratados, ca.ano
        from cl_afc ca, cl_sectors cs, cl_class cc, cl_divisions cd , cl_groups cg
        where ca.id_contract_type = 1
        and ano::int in (select (max(ano::int)-1) from cl_afc)
        and cc.id_class = ca.id_subclass and cg.id_group = cc.id_group
        and cd.id_division = cg.id_division and cs.id_sector = cd.id_sector
        group by cs.id_sector, ca.ano
        order by cs.id_sector) as a, 
        (select cs.id_sector, cs.name_sector, sum(ca.number_workers::float) as total
        from cl_afc ca, cl_sectors cs, cl_class cc, cl_divisions cd , cl_groups cg
        where cc.id_class = ca.id_subclass and cg.id_group = cc.id_group
        and cd.id_division = cg.id_division and cs.id_sector = cd.id_sector 
        group by cs.id_sector, name_sector
        order by cs.id_sector) as b
        where a.id_sector = b.id_sector 
        order by porcentaje desc
    ";

    $rs = $wpdb->get_results($sql);
    
    $name_sector    = '';
    $porcentaje = '';
    $data           = array();
    $ejeX           = array();
    $datos_finles   = array();

    if(is_array($rs) && count($rs)>0){
        foreach ($rs as $row) {
            $name_sector  = isset($row->name_sector)          && $row->name_sector!=''      ?  $row->name_sector : '';
            $porcentaje = isset($row->porcentaje)           && $row->porcentaje!=''     ?  (float) $row->porcentaje : '';
            $ano            = isset($row->ano)                      && $row->ano!=''                ?  (float) $row->ano : '';

            array_push($ejeX, $name_sector);

            array_push($data, $porcentaje);
            $i++; 
        }
        $datos_finles = array(
            'data_grafico' => array(
                'name'  => 'XX% de contratos indefinidos del año '.$ano,
                'data'  => $data
            ),
            'ejeX'          => $ejeX
        );
        $datos_finles = (array) $datos_finles;

        return new WP_REST_Response($datos_finles, 200);
    }else{
        return new WP_REST_Response(false, 200);
    }

    
    
    

}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/contratos_indefinidos_sectores_dashboard_old/', array(
        'methods' => 'GET',
        'callback' => 'contratos_indefinidos_sectores_dashboard_old'
        
    ) );
} );


/** Dashboard XX% de nuevos trabajadores **/

function crecimiento_nuevos_trabajadores_dashboard(  ) {

    global $wpdb;

    $sql = "
        select
            sec.id_sector,
            sec.name_sector,
            ca.ano,
            (((select sum(seci2.number_people::float) from cl_sector_initiators seci2 where sec.id_sector = seci2.id_sector and ca.ano::int = seci2.ano::int)*100)/(select sum(seci3.number_people::float) from cl_sector_initiators seci3)) as porcentaje
        from cl_afc ca
        inner join cl_class clss on (ca.id_subclass = clss.id_class)
        inner join cl_subclass sbca on (clss.id_class = sbca.id_class)
        inner join cl_groups grp on (clss.id_group = grp.id_group)
        inner join cl_divisions divs on (grp.id_division = divs.id_division)
        inner join cl_sectors sec on (divs.id_sector = sec.id_sector)
        inner join cl_sector_initiators seci on (sec.id_sector = seci.id_sector) and (ca.ano::int = seci.ano::int) 
        where ca.ano::int in (select max(ano::int) from cl_afc)
        group by sec.id_sector, sec.name_sector, ca.ano
        order by porcentaje desc
    ";

    $rs = $wpdb->get_results($sql);
    
    $name_sector    = '';
    $porcentaje = '';
    $data           = array();
    $ejeX           = array();
    $datos_finles   = array();

    if(is_array($rs) && count($rs)>0){
        foreach ($rs as $row) {
            $name_sector  = isset($row->name_sector)          && $row->name_sector!=''      ?  $row->name_sector : '';
            $porcentaje = isset($row->porcentaje)           && $row->porcentaje!=''     ?  (float) number_format($row->porcentaje, 2) : '';
            $ano            = isset($row->ano)                      && $row->ano!=''                ?  (float) $row->ano : '';

            array_push($ejeX, $name_sector);

            array_push($data, $porcentaje);
            $i++; 
        }
        $datos_finles = array(
            'data_grafico' => array(
                'name'  => '% nuevos trabajadores en sectores del año '.$ano,
                'data'  => $data
            ),
            'ejeX'          => $ejeX
        );
        $datos_finles = (array) $datos_finles;

        return new WP_REST_Response($datos_finles, 200);
    }else{
        return new WP_REST_Response(null, 200);
    }

}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/crecimiento_nuevos_trabajadores_dashboard/', array(
        'methods' => 'GET',
        'callback' => 'crecimiento_nuevos_trabajadores_dashboard'
        
    ) );
} );


/** Dashboard XX% de nuevos trabajadores OLD YEAR **/

function crecimiento_nuevos_trabajadores_dashboard_old(  ) {

    global $wpdb;

    $sql = "
        select
            sec.id_sector,
            sec.name_sector,
            ca.ano,
            (((select sum(seci2.number_people::float) from cl_sector_initiators seci2 where sec.id_sector = seci2.id_sector and ca.ano::int = seci2.ano::int)*100)/(select sum(seci3.number_people::float) from cl_sector_initiators seci3)) as porcentaje
        from cl_afc ca
        inner join cl_class clss on (ca.id_subclass = clss.id_class)
        inner join cl_subclass sbca on (clss.id_class = sbca.id_class)
        inner join cl_groups grp on (clss.id_group = grp.id_group)
        inner join cl_divisions divs on (grp.id_division = divs.id_division)
        inner join cl_sectors sec on (divs.id_sector = sec.id_sector)
        inner join cl_sector_initiators seci on (sec.id_sector = seci.id_sector) and (ca.ano::int = seci.ano::int) 
        where ca.ano::int in (select (max(ano::int)-1) from cl_afc)
        group by sec.id_sector, sec.name_sector, ca.ano
        order by porcentaje desc
    ";

    $rs = $wpdb->get_results($sql);
    
    $name_sector    = '';
    $porcentaje = '';
    $data           = array();
    $ejeX           = array();
    $datos_finles   = array();

    if(is_array($rs) && count($rs)>0){
        foreach ($rs as $row) {
            $name_sector  = isset($row->name_sector)          && $row->name_sector!=''      ?  $row->name_sector : '';
            $porcentaje = isset($row->porcentaje)           && $row->porcentaje!=''     ?  (float) number_format($row->porcentaje, 2) : '';
            $ano            = isset($row->ano)                      && $row->ano!=''                ?  (float) $row->ano : '';

            array_push($ejeX, $name_sector);

            array_push($data, $porcentaje);
            $i++; 
        }
        $datos_finles = array(
            'data_grafico' => array(
                'name'  => '% nuevos trabajadores en sectores del año '.$ano,
                'data'  => $data
            ),
            'ejeX'          => $ejeX
        );
        $datos_finles = (array) $datos_finles;

        return new WP_REST_Response($datos_finles, 200);
    }else{
        return new WP_REST_Response(null, 200);
    }

    
    
    

}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/crecimiento_nuevos_trabajadores_dashboard_old/', array(
        'methods' => 'GET',
        'callback' => 'crecimiento_nuevos_trabajadores_dashboard_old'
        
    ) );
} );


/** Dashboard % de mujeres por sector  **/

function crecimiento_mujeres_setores_dashboard(  ) {

    global $wpdb;

    $sql = "
        select a.ano, a.id_sector, a.name_sector, round(cast(((a.mujeres::float*100)/b.total::float) as numeric), 1) as porcentaje
        from (select cs.id_sector, cs.name_sector, sum(ca.number_workers::float) as mujeres, ca.ano
        from cl_afc ca, cl_sectors cs, cl_class cc, cl_divisions cd , cl_groups cg
        where ca.ano::int = (select MAX(ano::int) from cl_afc) and ca.mes= (select MAX(mes) from cl_afc where ano = (select MAX(ano) from cl_afc)) 
        and ca.id_sex = 1 and cc.id_class = ca.id_subclass  and cg.id_group = cc.id_group
        and cd.id_division = cg.id_division and cs.id_sector = cd.id_sector
        group by cs.id_sector, ca.ano
        order by cs.id_sector) as a, 
        (select cs.id_sector, cs.name_sector, sum(ca.number_workers::float) as total
        from cl_afc ca, cl_sectors cs, cl_class cc, cl_divisions cd , cl_groups cg
        where ca.ano::int = (select MAX(ano::int) from cl_afc) and ca.mes= (select MAX(mes) from cl_afc where ano = (select MAX(ano) from cl_afc))
        and cc.id_class = ca.id_subclass and cg.id_group = cc.id_group
        and cd.id_division = cg.id_division and cs.id_sector = cd.id_sector
        group by cs.id_sector, name_sector
        order by cs.id_sector) as b
        where a.id_sector = b.id_sector 
        order by porcentaje desc
    ";

    $rs = $wpdb->get_results($sql);
    
    $name_sector    = '';
    $porcentaje = '';
    $data           = array();
    $ejeX           = array();
    $datos_finles   = array();

    if(is_array($rs) && count($rs)>0){
        foreach ($rs as $row) {
            $name_sector  = isset($row->name_sector)          && $row->name_sector!=''      ?  $row->name_sector : '';
            $porcentaje = isset($row->porcentaje)           && $row->porcentaje!=''     ?  (float) number_format($row->porcentaje, 2) : '';
            $ano            = isset($row->ano)                      && $row->ano!=''                ?  (float) $row->ano : '';

            array_push($ejeX, $name_sector);

            array_push($data, $porcentaje);
            $i++; 
        }
        $datos_finles = array(
            'data_grafico' => array(
                'name'  => '% mujeres por sectores del año '.$ano,
                'data'  => $data
            ),
            'ejeX'          => $ejeX
        );
        $datos_finles = (array) $datos_finles;

        return new WP_REST_Response($datos_finles, 200);
    }else{
        return new WP_REST_Response(null, 200);
    }

}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/crecimiento_mujeres_setores_dashboard/', array(
        'methods' => 'GET',
        'callback' => 'crecimiento_mujeres_setores_dashboard'
        
    ) );
} );

/** Dashboard % de mujeres por sector OLD YEAR **/
function crecimiento_mujeres_setores_dashboard_old(  ) {

    global $wpdb;

    $sql = "
        select a.ano, a.id_sector, a.name_sector, round(cast(((a.mujeres::float*100)/b.total::float) as numeric), 1) as porcentaje
        from (select cs.id_sector, cs.name_sector, sum(ca.number_workers::float) as mujeres, ca.ano
        from cl_afc ca, cl_sectors cs, cl_class cc, cl_divisions cd , cl_groups cg
        where ca.ano::int = (select MAX(ano::int)-1 from cl_afc) and ca.mes= (select MAX(mes) from cl_afc where ano = (select MAX(ano) from cl_afc)) 
        and ca.id_sex = 1 and cc.id_class = ca.id_subclass  and cg.id_group = cc.id_group
        and cd.id_division = cg.id_division and cs.id_sector = cd.id_sector
        group by cs.id_sector, ca.ano
        order by cs.id_sector) as a, 
        (select cs.id_sector, cs.name_sector, sum(ca.number_workers::float) as total
        from cl_afc ca, cl_sectors cs, cl_class cc, cl_divisions cd , cl_groups cg
        where ca.ano::int = (select MAX(ano::int)-1 from cl_afc) and ca.mes= (select MAX(mes) from cl_afc where ano = (select MAX(ano) from cl_afc))
        and cc.id_class = ca.id_subclass and cg.id_group = cc.id_group
        and cd.id_division = cg.id_division and cs.id_sector = cd.id_sector
        group by cs.id_sector, name_sector
        order by cs.id_sector) as b
        where a.id_sector = b.id_sector 
        order by porcentaje desc
    ";

    $rs = $wpdb->get_results($sql);
    
    $name_sector    = '';
    $porcentaje = '';
    $data           = array();
    $ejeX           = array();
    $datos_finles   = array();

    if(is_array($rs) && count($rs)>0){
        foreach ($rs as $row) {
            $name_sector  = isset($row->name_sector)          && $row->name_sector!=''      ?  $row->name_sector : '';
            $porcentaje = isset($row->porcentaje)           && $row->porcentaje!=''     ?  (float) number_format($row->porcentaje, 2) : '';
            $ano            = isset($row->ano)                      && $row->ano!=''                ?  (float) $row->ano : '';

            array_push($ejeX, $name_sector);

            array_push($data, $porcentaje);
            $i++; 
        }
        $datos_finles = array(
            'data_grafico' => array(
                'name'  => '% mujeres por sectores del año '.$ano,
                'data'  => $data
            ),
            'ejeX'          => $ejeX
        );
        $datos_finles = (array) $datos_finles;

        return new WP_REST_Response($datos_finles, 200);
    }else{
        return new WP_REST_Response(null, 200);
    }

}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/crecimiento_mujeres_setores_dashboard_old/', array(
        'methods' => 'GET',
        'callback' => 'crecimiento_mujeres_setores_dashboard_old'
        
    ) );
} );

/** Dashboard XX% de migrantes por sector  **/

function crecimiento_migrantes_setores_dashboard(  ) {

    global $wpdb;

    $sql = "
        select a.ano, a.id_sector, a.name_sector, round(cast(((a.migrantes::float*100)/b.total::float) as numeric), 1) as porcentaje
        from (select cs.id_sector, cs.name_sector, sum(ca.number_workers::float) as migrantes, ca.ano
        from cl_afc ca, cl_sectors cs, cl_class cc, cl_divisions cd, cl_groups cg
        where ca.ano::int = (select MAX(ano::int) from cl_afc) and ca.mes= (select MAX(mes) from cl_afc where ano = (select MAX(ano) from cl_afc)) and ca.id_nacionality = 2
        and cc.id_class = ca.id_subclass and cg.id_group = cc.id_group
        and cd.id_division = cg.id_division and cs.id_sector = cd.id_sector
        group by cs.id_sector, ca.ano
        order by cs.id_sector) as a, 
        (select cs.id_sector, cs.name_sector, sum(ca.number_workers::float) as total
        from cl_afc ca, cl_sectors cs, cl_class cc, cl_divisions cd , cl_groups cg
        where ca.ano::int = (select MAX(ano::int) from cl_afc) and ca.mes= (select MAX(mes) from cl_afc where ano = (select MAX(ano) from cl_afc))
        and cc.id_class = ca.id_subclass and cg.id_group = cc.id_group
        and cd.id_division = cg.id_division and cs.id_sector = cd.id_sector
        group by cs.id_sector, name_sector
        order by cs.id_sector) as b
        where a.id_sector = b.id_sector
        order by porcentaje desc, a.name_sector asc
    ";

    $rs = $wpdb->get_results($sql);
    
    $name_sector    = '';
    $porcentaje = '';
    $data           = array();
    $ejeX           = array();
    $datos_finles   = array();

    if(is_array($rs) && count($rs)>0){
        foreach ($rs as $row) {
            $name_sector  = isset($row->name_sector)          && $row->name_sector!=''      ?  $row->name_sector : '';
            $porcentaje = isset($row->porcentaje)           && $row->porcentaje!=''     ?  (float) number_format($row->porcentaje, 2) : '';
            $ano            = isset($row->ano)                      && $row->ano!=''                ?  (float) $row->ano : '';

            array_push($ejeX, $name_sector);

            array_push($data, $porcentaje);
            $i++; 
        }
        $datos_finles = array(
            'data_grafico' => array(
                'name'  => '% migrantes por sectores del año '.$ano,
                'data'  => $data
            ),
            'ejeX'          => $ejeX
        );
        $datos_finles = (array) $datos_finles;

        return new WP_REST_Response($datos_finles, 200);
    }else{
        return new WP_REST_Response(false, 200);
    }

}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/crecimiento_migrantes_setores_dashboard/', array(
        'methods' => 'GET',
        'callback' => 'crecimiento_migrantes_setores_dashboard'
        
    ) );
} );

/** Dashboard XX% de migrantes por sector OLD YEAR  **/

function crecimiento_migrantes_setores_dashboard_old(  ) {

    global $wpdb;

    $sql = "
        select a.ano, a.id_sector, a.name_sector, round(cast(((a.migrantes::float*100)/b.total::float) as numeric), 1) as porcentaje
        from (select cs.id_sector, cs.name_sector, sum(ca.number_workers::float) as migrantes, ca.ano
        from cl_afc ca, cl_sectors cs, cl_class cc, cl_divisions cd, cl_groups cg
        where ca.ano::int = (select MAX(ano::int)-1 from cl_afc) and ca.mes= (select MAX(mes) from cl_afc where ano = (select MAX(ano) from cl_afc)) and ca.id_nacionality = 2
        and cc.id_class = ca.id_subclass and cg.id_group = cc.id_group
        and cd.id_division = cg.id_division and cs.id_sector = cd.id_sector
        group by cs.id_sector, ca.ano
        order by cs.id_sector) as a, 
        (select cs.id_sector, cs.name_sector, sum(ca.number_workers::float) as total
        from cl_afc ca, cl_sectors cs, cl_class cc, cl_divisions cd , cl_groups cg
        where ca.ano::int = (select MAX(ano::int)-1 from cl_afc) and ca.mes= (select MAX(mes) from cl_afc where ano = (select MAX(ano) from cl_afc))
        and cc.id_class = ca.id_subclass and cg.id_group = cc.id_group
        and cd.id_division = cg.id_division and cs.id_sector = cd.id_sector
        group by cs.id_sector, name_sector
        order by cs.id_sector) as b
        where a.id_sector = b.id_sector
        order by porcentaje desc, a.name_sector asc
    ";

    $rs = $wpdb->get_results($sql);
    
    $name_sector    = '';
    $porcentaje = '';
    $data           = array();
    $ejeX           = array();
    $datos_finles   = array();

    if(is_array($rs) && count($rs)>0){
        foreach ($rs as $row) {
            $name_sector  = isset($row->name_sector)          && $row->name_sector!=''      ?  $row->name_sector : '';
            $porcentaje = isset($row->porcentaje)           && $row->porcentaje!=''     ?  (float) number_format($row->porcentaje, 2) : '';
            $ano            = isset($row->ano)                      && $row->ano!=''                ?  (float) $row->ano : '';

            array_push($ejeX, $name_sector);

            array_push($data, $porcentaje);
            $i++; 
        }
        $datos_finles = array(
            'data_grafico' => array(
                'name'  => '% migrantes por sectores del año '.$ano,
                'data'  => $data
            ),
            'ejeX'          => $ejeX
        );
        $datos_finles = (array) $datos_finles;

        return new WP_REST_Response($datos_finles, 200);
    }else{
        return new WP_REST_Response(false, 200);
    }

}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/crecimiento_migrantes_setores_dashboard_old/', array(
        'methods' => 'GET',
        'callback' => 'crecimiento_migrantes_setores_dashboard_old'
        
    ) );
} );


//** Dashboard  Rotacion Sectores **//

function crecimiento_rotacion_setores_dashboard( $data ) {


    global $wpdb;

    
    $id_sector = isset($data['id_sector']) && $data['id_sector']!='' ? $data['id_sector'] : '';

    if(is_numeric($id_sector)){
        /*$sql = "
        select 
                distinct
                cs_ou.id_sector_exit,
                cs1.name_sector as name_sector_exit,
                cs_ou.id_sector_input,
                cs2.name_sector as name_sector_input,
                (((cs_ou.number_people::float)*100)/(select Sum(number_people::float) from cl_sector_exit_inputs )) as porcentaje,
                cs_ou.ano
            from cl_sector_exit_inputs cs_ou 
            inner join cl_sectors cs1 on (cs_ou.id_sector_exit = cs1.id_sector)
            inner join cl_sectors cs2 on (cs_ou.id_sector_input = cs2.id_sector)
            where  cs_ou.id_sector_exit = ".$id_sector." and cs_ou.ano::int in (select max(ano::int) from cl_sector_exit_inputs )
        ";*/

        $sql = "
            select 
                distinct
                cs_ou.id_sector_exit,
                cs1.name_sector as name_sector_exit,
                cs_ou.id_sector_input,
                cs2.name_sector as name_sector_input,
                (((cs_ou.number_people::float)*100)/(select Sum(number_people::float) from cl_sector_exit_inputs where id_sector_exit=".$id_sector.")) as porcentaje,
                cs_ou.ano
            from cl_sector_exit_inputs cs_ou 
            inner join cl_sectors cs1 on (cs_ou.id_sector_exit = cs1.id_sector)
            inner join cl_sectors cs2 on (cs_ou.id_sector_input = cs2.id_sector)
            where cs_ou.id_sector_exit = ".$id_sector."
            and cs_ou.ano in (select max(ano) from cl_sector_exit_inputs where id_sector_exit=".$id_sector.")

        ";

        $rs = $wpdb->get_results($sql);

        $data               = array();
        $data_old           = array();
        $data = array();
        $rs_indefinidos     = array();
        $ejeX               = array();
        $datos_finles       = array();
        //var_dump(count($rs)); die;

        if(is_array($rs) && count($rs)>0){
            foreach ($rs as $row) {
                $name_sector_exit  = isset($row->name_sector_exit)            && $row->name_sector_exit!=''      ?  $row->name_sector_exit : '';
                $name_sector_input = isset($row->name_sector_input)           && $row->name_sector_input!=''     ?  $row->name_sector_input : '';
                $porcentaje        = isset($row->porcentaje)                  && $row->porcentaje!=''            ?  (float) number_format($row->porcentaje, 2) : '';
                $ano                = isset($row->ano)                        && $row->ano!=''                   ?  (float) $row->ano : '';

                array_push($data, array('name' => $ano , 'from' => $name_sector_exit, 'to' => $name_sector_input, 'weight' => $porcentaje));
                //array_push($data, array($ano , $name_sector_exit, $name_sector_input, $porcentaje));
            }
            $datos_finles = (array) array('ano' => $ano, 'data' => $data);

            return new WP_REST_Response($datos_finles, 200);
        }else{
            return new WP_REST_Response(null, 200);
        }
    }else{
        return new WP_REST_Response(null, 200);
    }
    
    

}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/crecimiento_rotacion_setores_dashboard/(?P<id_sector>\d+)', array(
        'methods' => 'GET',
        'callback' => 'crecimiento_rotacion_setores_dashboard',
        'args' => array(
            'id_sector' => array(
                'validate_callback' => function($param, $request, $key) {
                    return  is_numeric($param);
                }
            ),
        ),
        
    ) );
} );

//** Dashboard  Rotacion Sectores OLD YEAR**//

function crecimiento_rotacion_setores_dashboard_old( $data ) {


    global $wpdb;

    $id_sector = isset($data['id_sector']) && $data['id_sector']!='' ? $data['id_sector'] : '';

    if(is_numeric($id_sector)){
        $sql = "
            
            select 
                distinct
                cs_ou.id_sector_exit,
                cs1.name_sector as name_sector_exit,
                cs_ou.id_sector_input,
                cs2.name_sector as name_sector_input,
                (((cs_ou.number_people::float)*100)/(select Sum(number_people::float) from cl_sector_exit_inputs where id_sector_exit=".$id_sector.")) as porcentaje,
                cs_ou.ano
            from cl_sector_exit_inputs cs_ou 
            inner join cl_sectors cs1 on (cs_ou.id_sector_exit = cs1.id_sector)
            inner join cl_sectors cs2 on (cs_ou.id_sector_input = cs2.id_sector)
            where cs_ou.id_sector_exit = ".$id_sector."
            and cs_ou.ano in (select max(ano::int)-1 from cl_sector_exit_inputs where id_sector_exit=".$id_sector.")
        ";
        //echo $sql; die;
        $rs = $wpdb->get_results($sql);

        $data               = array();
        $data_old           = array();
        $data = array();
        $rs_indefinidos     = array();
        $ejeX               = array();
        $datos_finles       = array();
        //var_dump(count($rs)); die;

        if(is_array($rs) && count($rs)>0){
            foreach ($rs as $row) {
                $name_sector_exit  = isset($row->name_sector_exit)            && $row->name_sector_exit!=''      ?  $row->name_sector_exit : '';
                $name_sector_input = isset($row->name_sector_input)           && $row->name_sector_input!=''     ?  $row->name_sector_input : '';
                $porcentaje        = isset($row->porcentaje)                  && $row->porcentaje!=''            ?  (float) number_format($row->porcentaje, 2) : '';
                $ano                = isset($row->ano)                        && $row->ano!=''                   ?  (float) $row->ano : '';

                array_push($data, array('name' => $ano , 'from' => $name_sector_exit, 'to' => $name_sector_input, 'weight' => $porcentaje));
                //array_push($data, array($ano , $name_sector_exit, $name_sector_input, $porcentaje));
            }
            $datos_finles = (array) array('ano' => $ano, 'data' => $data);

            return new WP_REST_Response($datos_finles, 200);
        }else{
            return new WP_REST_Response(null, 200);
        }
    }else{
        return new WP_REST_Response(null, 200);
    }
    

}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/crecimiento_rotacion_setores_dashboard_old/(?P<id_sector>\d+)', array(
        'methods' => 'GET',
        'callback' => 'crecimiento_rotacion_setores_dashboard_old',
        'args' => array(
            'id_sector' => array(
                'validate_callback' => function($param, $request, $key) {
                    return  is_numeric($param);
                }
            ),
        ),
        
    ) );
} );


/** Dashboard Tasa de crecimiento de ocupados  **/

function crecimiento_ocupados_dashboard(  ) {

    global $wpdb;

    $sql = "
        select 
            oc.id_occupation,
            oc.name_occupation,
            cbc.number_occupied,
            cbc.ano
        from cl_busy_casen cbc
        inner join cl_occupations oc on(cbc.id_occupation = oc.id_occupation)
        where cbc.ano::int in (select max(ano::int) from cl_busy_casen)
        order by cbc.number_occupied desc, oc.name_occupation asc
    ";

    $rs = $wpdb->get_results($sql);
    
    $name_occupation    = '';
    $number_occupied = '';
    $data           = array();
    $ejeX           = array();
    $datos_finles   = array();

    if(is_array($rs) && count($rs)>0){
        foreach ($rs as $row) {
            $name_occupation  = isset($row->name_occupation)          && $row->name_occupation!=''      ?  $row->name_occupation : '';
            $number_occupied = isset($row->number_occupied)           && $row->number_occupied!=''     ?  (int) $row->number_occupied : '';
            $ano            = isset($row->ano)                      && $row->ano!=''                ?  (float) $row->ano : '';

            array_push($ejeX, $name_occupation);

            array_push($data, $number_occupied);
            $i++; 
        }
        $datos_finles = array(
            'data_grafico' => array(
                'name'  => 'Tasa de crecimiento de ocupados del año '.$ano,
                'data'  => $data
            ),
            'ejeX'          => $ejeX
        );
        $datos_finles = (array) $datos_finles;

        return new WP_REST_Response($datos_finles, 200);
    }else{
        return new WP_REST_Response(null, 200);
    }

}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/crecimiento_ocupados_dashboard/', array(
        'methods' => 'GET',
        'callback' => 'crecimiento_ocupados_dashboard'
        
    ) );
} );

/** Dashboard Tasa de crecimiento de ocupados OLD YEAR  **/

function crecimiento_ocupados_dashboard_old(  ) {

    global $wpdb;

    $sql = "
        select 
            oc.id_occupation,
            oc.name_occupation,
            cbc.number_occupied,
            cbc.ano
        from cl_busy_casen cbc
        inner join cl_occupations oc on(cbc.id_occupation = oc.id_occupation)
        where cbc.ano::int in (select max(ano::int)-2 from cl_busy_casen)
        order by cbc.number_occupied desc, oc.name_occupation asc
    ";

    $rs = $wpdb->get_results($sql);
    
    $name_occupation    = '';
    $number_occupied = '';
    $data           = array();
    $ejeX           = array();
    $datos_finles   = array();

    if(is_array($rs) && count($rs)>0){
        foreach ($rs as $row) {
            $name_occupation  = isset($row->name_occupation)          && $row->name_occupation!=''      ?  $row->name_occupation : '';
            $number_occupied = isset($row->number_occupied)           && $row->number_occupied!=''     ?  (int) $row->number_occupied : '';
            $ano            = isset($row->ano)                      && $row->ano!=''                ?  (float) $row->ano : '';

            array_push($ejeX, $name_occupation);

            array_push($data, $number_occupied);
            $i++; 
        }
        $datos_finles = array(
            'data_grafico' => array(
                'name'  => 'Tasa de crecimiento de ocupados del año '.$ano,
                'data'  => $data
            ),
            'ejeX'          => $ejeX
        );
        $datos_finles = (array) $datos_finles;

        return new WP_REST_Response($datos_finles, 200);
    }else{
        return new WP_REST_Response(null, 200);
    }

}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/crecimiento_ocupados_dashboard_old/', array(
        'methods' => 'GET',
        'callback' => 'crecimiento_ocupados_dashboard_old'
        
    ) );
} );


/** Dashboard Participación en distintos sectores  **/

function participacion_sector_dashboard(  ) {

    global $wpdb;

    $sql = "
        select 
            sec.id_sector,
            sec.name_sector,
            (sum(csp.participation)) as porcentaje
        from cl_casen_ocupation_sector_participation  as csp
        inner join cl_occupations as oc on (csp.code_ocupation = oc.id_occupation)
        inner join cl_sectors as sec on (csp.code_sector = sec.id_sector)
        group by sec.id_sector, sec.name_sector
        order by porcentaje desc
    ";

    $rs = $wpdb->get_results($sql);
    
    $name_sector    = '';
    $porcentaje = '';
    $data           = array();
    $ejeX           = array();
    $datos_finles   = array();

    if(is_array($rs) && count($rs)>0){
        foreach ($rs as $row) {
            $name_sector  = isset($row->name_sector)          && $row->name_sector!=''      ?  $row->name_sector : '';
            $porcentaje = isset($row->porcentaje)           && $row->porcentaje!=''     ?  (float) number_format($row->porcentaje, 2) : '';
            //$ano            = isset($row->ano)                      && $row->ano!=''                ?  (float) $row->ano : '';

            array_push($ejeX, $name_sector);

            array_push($data, $porcentaje);
            $i++; 
        }
        $datos_finles = array(
            'data_grafico' => array(
                'name'  => 'Participación en distintos sectores',
                'data'  => $data
            ),
            'ejeX'          => $ejeX
        );
        $datos_finles = (array) $datos_finles;

        return new WP_REST_Response($datos_finles, 200);
    }else{
        return new WP_REST_Response(null, 200);
    }

}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/participacion_sector_dashboard/', array(
        'methods' => 'GET',
        'callback' => 'participacion_sector_dashboard'
        
    ) );
} );

//** actualizar estado de publicación del gráfico **/
function update_state_grafico( $data ) {

    global $wpdb;
    $id_graphics    = isset($data['id_graphics'])       && $data['id_graphics']!=''     ? $data['id_graphics'] : '';
    $state_graphics = isset($data['state_graphics'])    && $data['state_graphics']!=''  ? $data['state_graphics'] : '';

    $sql_sector = "UPDATE cl_graphics SET state_graphics=".$state_graphics." WHERE id_graphics=".$id_graphics;

    if($wpdb->get_results($sql_sector)){

        return new WP_REST_Response(array('state' => true), 200);
    }else{
        return new WP_REST_Response(array('state' => false), 200);
    }
}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/update_state_grafico/(?P<id_graphics>\d+)/(?P<state_graphics>\d+)', array(
        'methods' => 'GET',
        'callback' => 'update_state_grafico',
        'args' => array(
            'id_graphics' => array(
                'validate_callback' => function($param, $request, $key) {
                    return  is_numeric($param);
                }
            ),
            'state_graphics' => array(
                'validate_callback' => function($param, $request, $key) {
                    return  is_numeric($param);
                }
            ),
        ),
    ) );
} );


//** mostar estado de publicación del gráfico **/
function show_state_grafico( $data ) {

    global $wpdb;
    $id_graphics    = isset($data['id_graphics'])       && $data['id_graphics']!=''     ? $data['id_graphics'] : '';

    $sql = "select state_graphics from cl_graphics WHERE id_graphics=".$id_graphics;
    $rs  = $wpdb->get_results($sql);
    $rs = (array) $rs;

    if(is_array($rs) && count($rs)>0){
        $state_graphics = isset($rs[0]->state_graphics) && $rs[0]->state_graphics=='1' ? 1 : 2;

        return new WP_REST_Response($state_graphics, 200);
    }else{
        return new WP_REST_Response(array('state' => false), 200);
    }
}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/show_state_grafico/(?P<id_graphics>\d+)/', array(
        'methods' => 'GET',
        'callback' => 'show_state_grafico',
        'args' => array(
            'id_graphics' => array(
                'validate_callback' => function($param, $request, $key) {
                    return  is_numeric($param);
                }
            )
        ),
    ) );
} );

/** Dashboard % de contratos indefinidos por sector  **/

function contratos_indefinidos_sectores_variacion_dashboard(  ) {

    global $wpdb;

    $sql = "
       select
            sec.id_sector,
            sec.name_sector,
            ca.ano,
            cont.name_contract_type,
            sum(ca.number_workers) as number_workers
        from cl_afc ca
        inner join cl_class clss on (ca.id_subclass = clss.id_class)
        inner join cl_subclass sbca on (clss.id_class = sbca.id_class)
        inner join cl_groups grp on (clss.id_group = grp.id_group)
        inner join cl_divisions divs on (grp.id_division = divs.id_division)
        inner join cl_sectors sec on (divs.id_sector = sec.id_sector)
        inner join cl_contract_type cont on(ca.id_contract_type = cont.id_contract_type) and (cont.id_contract_type = 1)
        where ca.ano::int in (select ano::int from cl_afc group by ano order by ano desc limit 2) 
        group by sec.id_sector, sec.name_sector,ca.ano, cont.name_contract_type
        order by sec.name_sector asc, ca.ano asc,sum(ca.number_workers) desc
    ";

    $rs = $wpdb->get_results($sql);

    $cont               = 0;
    $i                  = 0;
    $name_sector      = '';
    $name_sector_old  = '';
    $data               = array();
    $data_old           = array();
    $rs_indefinidos_tmp = array();
    $rs_indefinidos     = array();
    $ejeX               = array();
    $datos_finles       = array();
    $valor_pasado       = 0;
    $valor_presente     = 0;
    $variacion          = 0;

    array_push($ejeX, 0);

    if(is_array($rs) && count($rs)>0){
        foreach ($rs as $row) {
            $name_sector    = isset($row->name_sector)      && $row->name_sector!=''        ?  $row->name_sector : '';
            $number_workers = isset($row->number_workers)   && $row->number_workers!=''     ?  (float) $row->number_workers : '';
            $ano            = isset($row->ano)              && $row->ano!=''                ?  (float) $row->ano : '';

            array_push($ejeX, $name_sector);
            if($i == 0){
                $valor_pasado   = $number_workers;
                array_push($data_old, 0);
            }else{
                $valor_presente = $number_workers;
                if($valor_presente>$valor_pasado){
                    $variacion = (float) number_format(((($valor_presente - $valor_pasado)/$valor_pasado)*100), 2);
                }
                if($valor_presente<$valor_pasado){
                    $variacion = (float) number_format(((($valor_pasado - $valor_presente)/$valor_presente)*100), 2);
                }

                array_push($data_old, $variacion);

                //$i = -1;
            }

            $i++;
        }

        $rs_indefinidos = array(
            'name' => $name_sector,
            'data' => $data_old
        );
        $rs_response = (array) $rs_indefinidos;

        $datos_finles = array(
            'data_grafico'  => $rs_response,
            'ejeX'          => $ejeX
        );

        return new WP_REST_Response($datos_finles, 200);
    }else{
        return new WP_REST_Response(false, 200);
    }

}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/contratos_indefinidos_sectores_variacion_dashboard/', array(
        'methods' => 'GET',
        'callback' => 'contratos_indefinidos_sectores_variacion_dashboard'
        
    ) );
} );


function contratos_indefinidos_sectores_variacion_dashboard_old(  ) {

    global $wpdb;

    $sql = "
        select
            sec2.id_sector,
            sec2.name_sector,   
            (select max(ano::int)-1 from cl_afc) as ano,
            (select variacion_sector(sec2.id_sector, (select max(ano::int)-1 from cl_afc))) as presente,
            (select variacion_sector(sec2.id_sector, (select max(ano::int)-2 from cl_afc))) as pasado
        from cl_class clss 
        inner join cl_subclass sbca on (clss.id_class = sbca.id_class)
        inner join cl_groups grp on (clss.id_group = grp.id_group)
        inner join cl_divisions divs on (grp.id_division = divs.id_division)
        inner join cl_sectors sec2 on (divs.id_sector = sec2.id_sector)
        group by sec2.id_sector, sec2.name_sector
        order by pasado desc
    ";

    $rs = $wpdb->get_results($sql);
    
    $name_sector    = '';
    $porcentaje = '';
    $data           = array();
    $ejeX           = array();
    $datos_finles   = array();

    if(is_array($rs) && count($rs)>0){
        foreach ($rs as $row) {
            $id_sector  = isset($row->id_sector)    && $row->id_sector!=''      ?  $row->id_sector : '';
            $name_sector= isset($row->name_sector)  && $row->name_sector!=''    ?  $row->name_sector : '';
            $presente   = isset($row->presente)     && $row->presente!=''       ? $row->presente : '0';
            $pasado     = isset($row->pasado)       && $row->pasado!=''         ? $row->pasado : '0';
            $ano        = isset($row->ano)          && $row->ano!=''            ? $row->ano : '';

            array_push($ejeX, $name_sector);

            if($presente>$pasado){
                $variacion = (float) number_format(((($presente - $pasado)/$pasado)*100), 2);
            }
            if($presente<$pasado){
                $variacion = (float) number_format(((($pasado - $presente)/$presente)*100), 2);
            }
            if($presente>0 && $pasado>0){
                array_push($data, $variacion);
            }
        }
        if(is_array($data) && count($data)>0){
            $datos_finles = array(
                'data_grafico' => array(
                    'name'  => '% migrantes por sectores del año '.$ano,
                    'data'  => $data
                ),
                'ejeX'          => $ejeX
            );
            $datos_finles = (array) $datos_finles;
            return new WP_REST_Response($datos_finles, 200);
        }else{
            return new WP_REST_Response(false, 200);
        }
        
    }else{
        return new WP_REST_Response(false, 200);
    }

}

add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/contratos_indefinidos_sectores_variacion_dashboard_old/', array(
        'methods' => 'GET',
        'callback' => 'contratos_indefinidos_sectores_variacion_dashboard_old'
        
    ) );
} );




?>