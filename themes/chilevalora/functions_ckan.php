<?php
add_filter ( ' https_local_ssl_verify ' , ' __return_true ' );

add_action('http_api_curl', 'sar_custom_curl_timeout', 9999, 1);

// Setting a custom timeout value for cURL. Using a high value for priority to ensure the function runs after any other added to the same action hook.
function sar_custom_curl_timeout( $handle ){
    curl_setopt( $handle, CURLOPT_CONNECTTIMEOUT, 90 ); // 30 seconds. Too much for production, only for testing.
    curl_setopt( $handle, CURLOPT_TIMEOUT, 90 ); // 30 seconds. Too much for production, only for testing.
}

// Setting custom timeout for the HTTP request
add_filter( 'http_request_timeout', 'sar_custom_http_request_timeout', 9999 );
function sar_custom_http_request_timeout( $timeout_value ) {
    return 90; // 30 seconds. Too much for production, only for testing.
}
// Setting custom timeout in HTTP request args
add_filter('http_request_args', 'sar_custom_http_request_args', 9999, 1);
function sar_custom_http_request_args( $r ){
    $r['timeout'] = 90; // 30 seconds. Too much for production, only for testing.
    return $r;
}

//echo phpinfo();

//CODIGO PARA OBTENER SECTORES DE CKAN
//$response=wp_remote_post("http://chilevalora2.ckan.org/api/3/action/datastore_search_sql?sql=SELECT DISTINCT seccion, n_seccion from \"e305a02d-8aec-4997-828d-7fb8e35d86e7\" ORDER BY seccion");

//OBTENGO LA DATA QUE DESEO GUARDAR
//$data = json_decode($response["http_response"]->get_response_object()->body);
//var_dump($data);
//RECORRO DATA Y LLAMO FUNCION PARA GUARDAR
// foreach ($data->result->records as $key => $value) {
//     insert_sectors($value->seccion, $value->n_seccion);
// }

//SELECCIONO LA DATA DE LA TABLA
// $result = $wpdb->get_results('SELECT * FROM cl_sectors', OBJECT);
// var_dump($result);

//FUNCION QUE GUARDA LOS DATOS EN LA TABLA SELECCIONADA
// function insert_sectors($code, $name){
//     global $wpdb;
//     $wpdb->insert('cl_sectors',
//         array(
//             'code_sector' => $code,
//             'name_sector' => $name
//         )
//     );
// }


//CODIGO PARA OBTENER DIVISIONES DE CKAN
//$response=wp_remote_post("http://chilevalora2.ckan.org/api/3/action/datastore_search_sql?sql=SELECT DISTINCT division, seccion, n_division from \"e305a02d-8aec-4997-828d-7fb8e35d86e7\" ORDER BY division");

//OBTENGO LA DATA QUE DESEO GUARDAR
//$data = json_decode($response["http_response"]->get_response_object()->body);

//RECORRO DATA Y LLAMO FUNCION PARA GUARDAR
// foreach ($data->result->records as $key => $value) {
    
//     $numeros = str_split($value->division);
//     if(sizeof($numeros) == 1){
//         array_unshift($numeros, 0);
//     }

//     $value->division = implode("", $numeros);  
          
//     $result = $wpdb->get_results('SELECT id_sector FROM cl_sectors where code_sector = '.$value->seccion.'', OBJECT);
//     insert_divisions($value->division, $value->n_division, $result[0]->id_sector);
// }

//SELECCIONO LA DATA DE LA TABLA
// $result = $wpdb->get_results('SELECT * FROM cl_divisions', OBJECT);
// var_dump($result);

//FUNCION QUE GUARDA LOS DATOS EN LA TABLA SELECCIONADA
// function insert_divisions($code, $name, $seccion){
//     global $wpdb;
//     $wpdb->insert('cl_divisions',
//         array(
//             'id_sector' => $seccion,
//             'code_division' => $code,
//             'name_division' => $name
//         )
//     );
// }


//CODIGO PARA OBTENER GRUPOS DE CKAN
//$response=wp_remote_post("http://chilevalora2.ckan.org/api/3/action/datastore_search_sql?sql=SELECT DISTINCT grupo, n_grupo, division from \"e305a02d-8aec-4997-828d-7fb8e35d86e7\" ORDER BY grupo");

//OBTENGO LA DATA QUE DESEO GUARDAR
//$data = json_decode($response["http_response"]->get_response_object()->body);

//RECORRO DATA Y LLAMO FUNCION PARA GUARDAR
// foreach ($data->result->records as $key => $value) {
//     $numeros = str_split($value->grupo);
//     $num_div = str_split($value->division);

//     if(sizeof($numeros) == 2){
//         array_unshift($numeros, 0);
//     }elseif (sizeof($numeros) == 1) {
//         array_unshift($numeros, 0, 0);
//     }

//     $value->grupo = implode("", $numeros);
    
//     if(sizeof($num_div) == 1){
//         array_unshift($num_div, 0);
//     }

//     $value->division = implode("", $num_div);
    
//     $result = $wpdb->get_results("SELECT id_division FROM cl_divisions where code_division = '".$value->division."'", OBJECT);
    
//     //insert_groups($value->grupo, $value->n_grupo, $result[0]->id_division);
// }

//SELECCIONO LA DATA DE LA TABLA
//$result = $wpdb->get_results('SELECT * FROM cl_groups', OBJECT);
//var_dump($result);

//FUNCION QUE GUARDA LOS DATOS EN LA TABLA SELECCIONADA
// function insert_groups($code, $name, $division){
//     global $wpdb;
//     $wpdb->insert('cl_groups',
//         array(
//             'id_division' => $division,
//             'code_group' => $code,
//             'name_group' => $name
//         )
//     );
// }

//CODIGO PARA OBTENER CLASES DE CKAN
//$response=wp_remote_post("http://chilevalora2.ckan.org/api/3/action/datastore_search_sql?sql=SELECT DISTINCT clase, n_clase, grupo from \"e305a02d-8aec-4997-828d-7fb8e35d86e7\" ORDER BY clase");

//OBTENGO LA DATA QUE DESEO GUARDAR
//$data = json_decode($response["http_response"]->get_response_object()->body);

//RECORRO DATA Y LLAMO FUNCION PARA GUARDAR
// foreach ($data->result->records as $key => $value) {
//     $num_grupo = str_split($value->grupo);
//     $num_clase = str_split($value->clase);

//     if(sizeof($num_grupo) == 2){
//         array_unshift($num_grupo, 0);
//     }elseif (sizeof($num_grupo) == 1) {
//         array_unshift($num_grupo, 0, 0);
//     }

//     $value->grupo = implode("", $num_grupo);

//     if(sizeof($num_clase) == 3){
//         array_unshift($num_clase, 0);
//     }elseif (sizeof($num_clase) == 1) {
//         array_unshift($num_clase, 0, 0, 0);
//     }

//     $value->clase = implode("", $num_clase);
    
//     $result = $wpdb->get_results("SELECT id_group FROM cl_groups where code_group = '".$value->grupo."'", OBJECT);

//     //insert_class($value->clase, $value->n_clase, $result[0]->id_group);
// }

//SELECCIONO LA DATA DE LA TABLA
//$result = $wpdb->get_results('SELECT * FROM cl_groups', OBJECT);
//var_dump($result);

//FUNCION QUE GUARDA LOS DATOS EN LA TABLA SELECCIONADA
// function insert_class($code, $name, $grupo){
//     global $wpdb;
//     $wpdb->insert('cl_class',
//         array(
//             'id_group' => $grupo,
//             'code_class' => $code,
//             'name_class' => $name
//         )
//     );
// }

//CODIGO PARA OBTENER SUBCLASES DE CKAN
//$response=wp_remote_post("http://chilevalora2.ckan.org/api/3/action/datastore_search_sql?sql=SELECT DISTINCT subclase, n_subclase, clase from \"e305a02d-8aec-4997-828d-7fb8e35d86e7\" ORDER BY subclase");

//OBTENGO LA DATA QUE DESEO GUARDAR
//$data = json_decode($response["http_response"]->get_response_object()->body);

//RECORRO DATA Y LLAMO FUNCION PARA GUARDAR
// foreach ($data->result->records as $key => $value) {
//     $num_sub_clase = str_split($value->subclase);
//     $num_clase = str_split($value->clase);

//     if(sizeof($num_clase) == 3){
//         array_unshift($num_clase, 0);
//     }elseif (sizeof($num_clase) == 1) {
//         array_unshift($num_clase, 0, 0, 0);
//     }

//     $value->clase = implode("", $num_clase);

//     if(sizeof($num_sub_clase) == 4){
//         array_unshift($num_sub_clase, 0);
//     }elseif (sizeof($num_sub_clase) == 1) {
//         array_unshift($num_sub_clase, 0, 0, 0, 0);
//     }

//     $value->subclase = implode("", $num_sub_clase);
    
//     $result = $wpdb->get_results("SELECT id_class FROM cl_class where code_class = '".$value->clase."'", OBJECT);

//     //insert_subclass($value->subclase, $value->n_subclase, $result[0]->id_class);
// }

//SELECCIONO LA DATA DE LA TABLA
//$result = $wpdb->get_results('SELECT * FROM cl_groups', OBJECT);
//var_dump($result);

//FUNCION QUE GUARDA LOS DATOS EN LA TABLA SELECCIONADA
// function insert_subclass($code, $name, $class){
//     global $wpdb;
//     $wpdb->insert('cl_subclass',
//         array(
//             'id_class' => $class,
//             'code_subclass' => $code,
//             'name_subclass' => $name
//         )
//     );
// }

//CODIGO PARA OBTENER CODIGOS DE CKAN
//$response=wp_remote_post("http://chilevalora2.ckan.org/api/3/action/datastore_search_sql?sql=SELECT DISTINCT codigo, glosa, subclase from \"e305a02d-8aec-4997-828d-7fb8e35d86e7\" ORDER BY codigo");

//OBTENGO LA DATA QUE DESEO GUARDAR
//$data = json_decode($response["http_response"]->get_response_object()->body);

//RECORRO DATA Y LLAMO FUNCION PARA GUARDAR
// foreach ($data->result->records as $key => $value) {
//     $num_sub_clase = str_split($value->subclase);
//     $num_codigo = str_split($value->codigo);

//     if(sizeof($num_sub_clase) == 4){
//         array_unshift($num_sub_clase, 0);
//     }elseif (sizeof($num_sub_clase) == 1) {
//         array_unshift($num_sub_clase, 0, 0, 0, 0);
//     }

//     $value->subclase = implode("", $num_sub_clase);

//     if(sizeof($num_codigo) == 5){
//         array_unshift($num_codigo, 0);
//     }elseif (sizeof($num_codigo) == 1) {
//         array_unshift($num_codigo, 0, 0, 0, 0, 0);
//     }

//     $value->codigo = implode("", $num_codigo);
    
//     $result = $wpdb->get_results("SELECT id_subclass FROM cl_subclass where code_subclass = '".$value->subclase."'", OBJECT);

//     //insert_codigo($value->codigo, $value->glosa, $result[0]->id_subclass);
// }

//SELECCIONO LA DATA DE LA TABLA
//$result = $wpdb->get_results('SELECT * FROM cl_groups', OBJECT);
//var_dump($result);

//FUNCION QUE GUARDA LOS DATOS EN LA TABLA SELECCIONADA
// function insert_codigo($code, $name, $subclase){
//     global $wpdb;
//     $wpdb->insert('cl_codes',
//         array(
//             'id_subclass' => $subclase,
//             'code_code' => $code,
//             'name_code' => $name
//         )
//     );
// }


//CODIGO PARA OBTENER AFC DE CKAN
//$response = wp_remote_post("http://chilevalora2.ckan.org/api/3/action/datastore_search_sql?sql=SELECT * from \"ffb70cdb-c498-4c0e-8aec-30867527d210\" ORDER BY tipo_contrato LIMIT 1000");

//OBTENGO LA DATA QUE DESEO GUARDAR
//$data = json_decode($response["http_response"]->get_response_object()->body);

//RECORRO DATA Y LLAMO FUNCION PARA GUARDAR
// foreach ($data->result->records as $key => $value) {

//     $num_sub_clase = str_split($value->subclase);
//     if(sizeof($num_sub_clase) == 4){
//         array_unshift($num_sub_clase, 0);
//     }elseif (sizeof($num_sub_clase) == 1) {
//         array_unshift($num_sub_clase, 0, 0, 0, 0);
//     }

//     $value->subclase = implode("", $num_sub_clase);
    
//     $subclass = $wpdb->get_results("SELECT id_subclass FROM cl_subclass where code_subclass = '".$value->subclase."'", OBJECT);
    
//     //insert_afc($value->tipo_contrato, $subclass[0]->id_subclass, $value->nacionalidad, $value->tramo_edad, $value->tamaño_empresa, $value->quintil_ingreso, $value->region_worker, $value->region_empresa, $value->region_empleo, $value->sexo, $value->num_trabajadores, $value->ano, $value->mes);
// }

//SELECCIONO LA DATA DE LA TABLA
//$result = $wpdb->get_results('SELECT * FROM cl_groups', OBJECT);
//var_dump($result);

//FUNCION QUE GUARDA LOS DATOS EN LA TABLA SELECCIONADA
// function insert_afc($contract_type, $subclass, $nacionality, $age_bracket, $company_size, $income_quintile, $working_region, $region_company, $region_employment, $sex, $number_workers, $ano, $mes){
//     global $wpdb;
//     $wpdb->insert('cl_afc',
//         array(
//             'id_contract_type' => $contract_type,
//             'id_subclass' => $subclass,
//             'id_nacionality' => $nacionality,
//             'id_age_bracket' => $age_bracket,
//             'id_company_size' => $company_size,
//             'id_income_quintile' => $income_quintile,
//             'id_working_region' => $working_region,
//             'id_region_company' => $region_company,
//             'id_region_employment' => $region_employment,
//             'id_sex' => $sex,
//             'number_workers' => $number_workers,
//             'ano' => $ano,
//             'mes' => $mes
//         )
//     );
// }

//CODIGO PARA INSERTAR TIPOS DE CONTRATOS
// $contract_type = array(
//     0 => 'Indefinido',
//     1 => 'Definido',
//     2 => 'A plazo',
//     3 => 'Honorarios'
// );

//RECORRO DATA Y LLAMO FUNCION PARA GUARDAR
// foreach ($contract_type as $key => $value) {
//     insert_contract_type($value);
// }

// //FUNCION QUE GUARDA LOS DATOS EN LA TABLA SELECCIONADA
// function insert_contract_type($contract_type){
//     global $wpdb;
//     $wpdb->insert('cl_contract_type',
//         array(
//             'name_contract_type' => $contract_type,
//         )
//     );
// }

//CODIGO PARA OBTENER REGIONES DE CKAN
//$response=wp_remote_post("http://chilevalora2.ckan.org/api/3/action/datastore_search_sql?sql=SELECT * from \"f624addc-fd31-430e-9bb5-3f9b2a83d923\" ");

//OBTENGO LA DATA QUE DESEO GUARDAR
//$data = json_decode($response["http_response"]->get_response_object()->body);

//RECORRO DATA Y LLAMO FUNCION PARA GUARDAR
// foreach ($data->result->records as $key => $value) {
//     insert_regions($value->code_region, $value->name_region);
// }

//SELECCIONO LA DATA DE LA TABLA
// $result = $wpdb->get_results('SELECT * FROM cl_sectors', OBJECT);
// var_dump($result);

//FUNCION QUE GUARDA LOS DATOS EN LA TABLA SELECCIONADA
// function insert_regions($code, $name){
//     global $wpdb;
//     $wpdb->insert('cl_regions',
//         array(
//             'code_region' => $code,
//             'name_region' => $name
//         )
//     );
// }


//CODIGO PARA OBTENER OCUPACIONES DE CKAN
//$response=wp_remote_post("http://chilevalora2.ckan.org/api/3/action/datastore_search_sql?sql=SELECT codigo_ocupaciones, ocupaciones_4_digitos from \"94700f2c-454c-454c-8bb9-d296e17a562f\" ORDER BY codigo_ocupaciones");

//$data = json_decode($response["http_response"]->get_response_object()->body);

//RECORRO DATA Y LLAMO FUNCION PARA GUARDAR
// foreach ($data->result->records as $key => $value) { 
//     //insert_ocupaciones($value->codigo_ocupaciones, $value->ocupaciones_4_digitos);
// }

//SELECCIONO LA DATA DE LA TABLA
// $result = $wpdb->get_results('SELECT * FROM cl_sectors', OBJECT);
// var_dump($result);

//FUNCION QUE GUARDA LOS DATOS EN LA TABLA SELECCIONADA
// function insert_ocupaciones($code, $name){
//     global $wpdb;
//     $wpdb->insert('cl_occupations',
//         array(
//             'code_occupation' => $code,
//             'name_occupation' => $name
//         )
//     );
// }

//CODIGO PARA OBTENER PERFILES DE CKAN
//$response=wp_remote_post("http://chilevalora2.ckan.org/api/3/action/datastore_search_sql?sql=SELECT * from \"7f758765-5b4a-474b-b8a3-53cf137d517c\" ");

//OBTENGO LA DATA QUE DESEO GUARDAR
//$data = json_decode($response["http_response"]->get_response_object()->body);

//RECORRO DATA Y LLAMO FUNCION PARA GUARDAR
// foreach ($data->result->records as $key => $value) {
//     //insert_perfiles($value->codigo_perfil, $value->nombre_perfil, $value->cod_ciuo_88, $value->cod_ciuo_08, $value->link);
// }

//SELECCIONO LA DATA DE LA TABLA
// $result = $wpdb->get_results('SELECT * FROM cl_sectors', OBJECT);
// var_dump($result);

//FUNCION QUE GUARDA LOS DATOS EN LA TABLA SELECCIONADA
// function insert_perfiles($code_profile, $name_profile, $code_ciuo_88, $code_ciuo_08, $link){
//     global $wpdb;
//     $wpdb->insert('cl_cert_chilevalora',
//         array(
//             'code_profile' => $code_profile,
//             'name_profile' => $name_profile,
//             'code_ciuo_88' => $code_ciuo_88,
//             'code_ciuo_08' => $code_ciuo_08,
//             'link' => $link
//         )
//     );
// }

//ESTRUCTURA DE TABLA JOB_POSITIONS
// create table job_positions(
//     id_job_position SERIAL primary key,
//     code_occupation int not null,
//     code_job_positions int not null,
//     name_job_positions varchar not null,
//     description varchar null,
//     digital bool not null
// );

function get_indicator_func( $data ) {
    global $wpdb;

    $result = $wpdb->get_results('SELECT * FROM cl_indicator where id_indicator = '.$data['id_ind'].' and page_asoc = '.$data['page_asoc'].'', OBJECT);

    if(!empty($result[0])){
        return new WP_REST_Response($result[0], 200);
    }else{
        return new WP_REST_Response(array('status' => 'error, not found'), 404);
    }
    
}

add_action( 'rest_api_init', function () {
    register_rest_route( 'get_indicator/v1', '/(?P<id_ind>\d+)/(?P<page_asoc>\d+)', 
        array(
            'methods' => 'GET',
            'callback' => 'get_indicator_func',
            'args' => array(
                'id_ind' => array(
                    'validate_callback' => function($param, $request, $key) {
                        return is_numeric( $param );
                    }
                ),
                'page_asoc' => array(
                    'validate_callback' => function($param, $request, $key) {
                        return is_numeric( $param );
                    }
                ),
            ),
        )
    );
});
