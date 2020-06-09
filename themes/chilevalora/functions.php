<?php
function my_function_admin_bar() {
    return true;
}
add_filter('show_admin_bar', 'my_function_admin_bar');
//activar imagen destacada
add_theme_support('post-thumbnails');
//Cast postgres t/f a 0 o 1
function postgresToBool( $string ){
	switch ($string) {
		case 't':
			return 1;
			break;
		case 'f':
			return 0;
			break;
		default:
			return 0;
			break;
	}
}
function chilevalora_template () {
	/**
	*@css 
	*/
	//Bootstrap CSS
	wp_enqueue_style('bootstrap-style', get_template_directory_uri() . '/css/bootstrap.min.css');
	//Font Google
	wp_enqueue_style('fonts-googleapis', 'https://fonts.googleapis.com/css?family=Montserrat:300,400,500|Roboto&display=swap');
	//All min CSS
	wp_enqueue_style('all-style', get_template_directory_uri() . '/css/all.min.css', '', '', 'all');
	//Font Chilevalora CSS
	wp_enqueue_style('font-chilevalora', get_template_directory_uri() . '/css/font-chilevalora.css', '', '', 'all');
	//OWL carousel CSS
	wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/css/owl.carousel.min.css', '', '', 'all');
	//Amsify Suggestags CSS
	wp_enqueue_style('amsify-suggestags', get_template_directory_uri() . '/css/amsify.suggestags.css', '', '', 'all');
	//Bootstrap Select CSS
	wp_enqueue_style('bootstrap-select', get_template_directory_uri() . '/css/bootstrap-select.min.css', '', '', 'all');
	// Theme stylesheet CSS
	wp_enqueue_style('chilevalora-style', get_template_directory_uri() . '/css/estilos.css', '', '', 'all');
	wp_enqueue_style('custom-style', get_template_directory_uri() . '/css/custom.css', '', '', 'all');
	//wp_enqueue_style('chilevalora-style', get_stylesheet_uri());
	wp_enqueue_style('datepicker-style', get_template_directory_uri() . '/css/bootstrap-datepicker3.min.css', '', '', 'all');
	/**
	*@JS
	*/
	//CORE JS
	//JS externos
	//Core
	wp_enqueue_script('core', 'https://www.amcharts.com/lib/4/core.js', array('jquery'), '3.3.4');
	//charts JS
	wp_enqueue_script('charts', 'https://www.amcharts.com/lib/4/charts.js', array('core'), '3.3.4');
	//Animated JS
	wp_enqueue_script('animated', 'https://www.amcharts.com/lib/4/themes/animated.js', array('charts'), '3.3.4');
	//JQuery JS
	wp_enqueue_script('jquery', get_template_directory_uri() . '/js/jquery.min.js', array('animated'), '3.3.4');
	//Functions JS
	wp_enqueue_script('functions', get_template_directory_uri() . '/js/functions.js?4', array('animated'), '3.3.4');
	//Popper JS
	wp_enqueue_script('popper', get_template_directory_uri() . '/js/popper.min.js', array('functions'), '3.3.4');
	//Bootstrap JS
	wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('popper'), '3.3.4');
	//Owl Carousel JS
	wp_enqueue_script('owl-carousel_js', get_template_directory_uri() . '/js/owl.carousel.js', array('bootstrap'), '3.3.4');
	//Jquery Amsify Suggestags JS
	wp_enqueue_script('jquery-amsify-suggestags', get_template_directory_uri() . '/js/jquery.amsify.suggestags.js', array('owl-carousel_js'), '3.3.4');
	//Bootstrap Select JS
	wp_enqueue_script('bootstrap-select_js', get_template_directory_uri() . '/js/bootstrap-select.min.js', array('jquery-amsify-suggestags'), '3.3.4');
	//CHARTS JS
	wp_enqueue_script('highstock_js', get_template_directory_uri() . '/js/stock/highstock.js', array('bootstrap-select_js'), '3.3.4');
	//wp_enqueue_script('highstock_highcharts', get_template_directory_uri() . '/js/stock/highstock_highcharts.js', array('highstock_js'), '3.3.4');
	wp_enqueue_script('highcharts-more', get_template_directory_uri() . '/js/stock/highcharts-more.js', array('highstock_js'), '3.3.4');
	
	//wp_enqueue_script('highcharts_js', get_template_directory_uri() . '/js/highcharts.js', array('highstock_highcharts'), '3.3.4');
	//
	wp_enqueue_script('highcharts_data', get_template_directory_uri() . '/js/modules/data.js', array('highcharts-more'), '3.3.4');
	//
	wp_enqueue_script('highcharts_drilldown', get_template_directory_uri() . '/js/modules/drilldown.js', array('highcharts_data'), '3.3.4');
	//
	wp_enqueue_script('highcharts_exporting', get_template_directory_uri() . '/js/modules/exporting.js', array('highcharts_drilldown'), '3.3.4');
	//
	wp_enqueue_script('highcharts_export_data', get_template_directory_uri() . '/js/modules/export-data.js', array('highcharts_exporting'), '3.3.4');
	//
	wp_enqueue_script('highcharts_accessibility', get_template_directory_uri() . '/js/modules/accessibility.js', array('highcharts_export_data'), '3.3.4');
	//
	wp_enqueue_script('highcharts_heatmap', get_template_directory_uri() . '/js/modules/heatmap.js', array('highcharts_accessibility'), '3.3.4');
	//
	wp_enqueue_script('highcharts_treemap', get_template_directory_uri() . '/js/modules/treemap.js', array('highcharts_heatmap'), '3.3.4');
	//
	wp_enqueue_script('highcharts_sankey', get_template_directory_uri() . '/js/modules/sankey.js', array('highcharts_treemap'), '3.3.4');
	//
	
	wp_enqueue_script('datepicker_js', get_template_directory_uri() . '/js/bootstrap-datepicker.min.js', array('highcharts_sankey'), '3.3.4');
	wp_enqueue_script('datepickeres_js', get_template_directory_uri() . '/js/bootstrap-datepicker.es.min.js', array('datepicker_js'), '3.3.4');
	//wp_enqueue_script('highstock_exporting', get_template_directory_uri() . '/js/stock/exporting.js', array('highstock_js'), '3.3.4');
	//wp_enqueue_script('highstock_data', get_template_directory_uri() . '/js/stock/data.js', array('highcharts_js'), '3.3.4');
	//wp_enqueue_script('highstock_export_data', get_template_directory_uri() . '/js/stock/export-data.js', array('highcharts_js'), '3.3.4');
	
	
	//Ajax JS
	wp_enqueue_script('dcms_miscript', get_template_directory_uri() . '/js/ajax.js', array('bootstrap-select_js'), '3.3.4');
	//Function Custom JS
	wp_enqueue_script('function_js', get_template_directory_uri() . '/js/function.js', array('dcms_miscript'), '3.3.4');
	//Autorizar Ajax 
	wp_localize_script('dcms_miscript', 'dcms_vars', array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'chilevalora_template');
function enqueue_ajaxjs() {
    global $post;
    //if ($post->post_type == 'regiones_detalle') {       
        wp_enqueue_script(  'ajaxjs', get_stylesheet_directory_uri().'/js/formulario.js', array('jquery'), '4' );

        wp_localize_script( 'ajaxjs', 'ajax_var', array(
            'url'    => admin_url( 'admin-ajax.php' ),
        ) );  
    //}
}
add_action( 'admin_enqueue_scripts', 'enqueue_ajaxjs' );
//add fucntions ckan
require 'functions_ckan.php';
/**
*
*ADD MENU
*
*/
add_action('init', 'register_my_menus');
function register_my_menus () {
	register_nav_menus(
		array('principal' => __('Principal'))
	);
}
function get_menu_parent_custom( $menu, $post_id = null ) {
    $post_id        = $post_id ? : get_the_ID();
    $menu_items     = wp_get_nav_menu_items( $menu );
    $parent_item_id = wp_filter_object_list( $menu_items, array( 'object_id' => $post_id ), 'and', 'menu_item_parent' );
    //var_dump($parent_item_id); die;
    var_dump($menu_items); die;
    if ( ! empty( $parent_item_id ) ) {
        $parent_item_id = array_shift( $parent_item_id );
        $parent_post_id = wp_filter_object_list( $menu_items, array( 'ID' => $parent_item_id ), 'and', 'object_id' );

        if ( ! empty( $parent_post_id ) ) {
            $parent_post_id = array_shift( $parent_post_id );

            return get_post( $parent_post_id );
        }
    }
    return false;
}
function my_menu_parent($theme_location) {
    $locations = get_nav_menu_locations();
    if ( isset( $locations[ $theme_location ] ) ) {
        $menu = wp_get_nav_menu_object( $locations[ $theme_location ] );
        $menu_items = wp_get_nav_menu_items($menu->term_id);
        _wp_menu_item_classes_by_context( $menu_items );
   	    $breadcrumbs = array();
        foreach ( $menu_items as $menu_item ) { 
            //$breadcrumbs[] = $menu_item->title;       
            //var_dump($menu_item->current_item_ancestor); 
            if ($menu_item->current_item_ancestor) {
                //var_dump($menu_item); die;
                $breadcrumbs['id'] = $menu_item->ID;
                $breadcrumbs['title'] = $menu_item->title;
            }
        }
        return $breadcrumbs;
     }
}
/**
*Miga de Pan
*/
function get_breadcrumb () {
	echo '<a href="' . home_url() . '" rel="nofollow">Inicio</a>';
	//$category = isset(the_category()) && the_category()!='' ? the_category() : '';
	$post = get_queried_object();
	$postType = get_post_type_object(get_post_type($post));
	$get_the_category = get_the_category(get_the_ID());
	$page_id = get_the_ID();
	$get_the_title = get_the_title($page_id);
	//print_r($get_the_category);
	if (is_category() || is_single()) {
		//if (is_category()) {
		if (is_array($get_the_category) && count($get_the_category) > 0) {
			echo "&nbsp;&nbsp;&nbsp;&#47;&nbsp;&nbsp;&nbsp;";
			the_category(' &bull; ');
		} else {
			//var_dump($postType->labels); die;
			echo "&nbsp;&nbsp;&nbsp;&#47;&nbsp;&nbsp;&nbsp;";
			echo '<a href="' . home_url() . '/' . strtolower(esc_html($postType->labels->singular_name)) . '/" rel="nofollow">' . esc_html($postType->labels->singular_name) . '</a>';
		}
		//}
		if (is_single()) {
			echo " &nbsp;&nbsp;&nbsp;&#47;&nbsp;&nbsp;&nbsp; ";
			the_title();
		}

	} elseif (is_page()) {
		echo "&nbsp;&nbsp;&nbsp;&#47;&nbsp;&nbsp;&nbsp;";
		echo '<a href="'.get_the_permalink().'" title="'.get_the_title().'" >'.get_the_title().'</a>';

	} elseif (is_search()) {
		echo "&nbsp;&nbsp;&nbsp;&#47;&nbsp;&nbsp;&nbsp;Búsqueda de resultado para... ";
		echo '"<em>';
		echo the_search_query();
		echo '</em>"';
	} elseif (is_archive()) {
		echo " &nbsp;&nbsp;&nbsp;&#47;&nbsp;&nbsp;&nbsp; ";
		$archive_title = explode(':', get_the_archive_title());
		echo trim($archive_title[1]);
	} else {
		echo " &nbsp;&nbsp;&nbsp;&#47;&nbsp;&nbsp;&nbsp; ";
		echo 'ERROR 404';
	}
}
//ADD Menu
require_once 'class-wp-bootstrap-navwalker.php';
//Widget Footer
register_sidebar( array(
'name' => 'Footer Sidebar 1',
'id' => 'footer-sidebar-1',
'description' => 'Appears in the footer area',
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => '</aside>',
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => 'Footer Sidebar 2',
'id' => 'footer-sidebar-2',
'description' => 'Appears in the footer area',
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => '</aside>',
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => 'Footer Sidebar 3',
'id' => 'footer-sidebar-3',
'description' => 'Appears in the footer area',
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => '</aside>',
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => 'Footer Sidebar 4',
'id' => 'footer-sidebar-4',
'description' => 'Appears in the footer area',
'before_widget' => '<aside id="%1$s" class="widget %2$s">',
'after_widget' => '</aside>',
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
register_sidebar( array(
'name' => 'Header',
'id' => 'header-sidebar',
'description' => 'Appears in the header area',
'before_widget' => '<div id="%1$s" class="widget %2$s">',
'after_widget' => '</div>',
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
//Login Form
function wpb_login_logo() { 
	$custom_logo_id = get_theme_mod( 'custom_logo' );
	$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
	?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo $image[0]; ?>);
	        height:100px;
	        width:300px;
	        background-size: 300px 100px;
	        background-repeat: no-repeat;
	        padding-bottom: 10px;
        }
    </style>
	<?php 
}
add_action( 'login_enqueue_scripts', 'wpb_login_logo' );
//Template Email
add_filter('retrieve_password_message', 'codecanal_forgot_mail_contnet', 10, 2);

function codecanal_forgot_mail_contnet($message, $key) {
	$user_data = '';
    // If no value is posted, return false
    if (!isset($_POST['user_login'])) {
        return '';
    }
    // Fetch user information from user_login
    if (strpos($_POST['user_login'], '@')) {
        $user_data = get_user_by('email', trim($_POST['user_login']));
    } else {
        $login = trim($_POST['user_login']);
        $user_data = get_user_by('login', $login);
    }
    if (!$user_data) {
        return '';
    }
    $user_login = $user_data->user_login;
    $user_email = $user_data->user_email;
    $site_url = get_site_url();
    $reset_url = network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login');

    // here $message it the mail content , which you can modify as per your requirment and $key is activation key
    // after modifying you must return $message
    return $message . "- <a href=' " . $reset_url . " '> Clic aquí o no</a>";
}
/* End Of Function for changing the Forgot password mail content */
/**ADD LOGO**/
add_action( 'after_setup_theme', 'galusso_custom_logo' );

function galusso_custom_logo() {
	add_theme_support( 'custom-logo' );
}
//** ADD Custom Column Regiones **/

function add_regiones_detalle_columns ( $columns ) {
   return array_merge ( $columns, array ( 
        'nombre_corto' 		=> __ ( '<span>Región</span>' ),
        'id' 				=> __ ( '<span>ID</span>' )
   ) );
 }
 add_filter ( 'manage_regiones_detalle_posts_columns', 'add_regiones_detalle_columns' );

function regiones_detalle_custom_column ( $column, $post_id ) {
	global $wpdb;
	if($column=='nombre_corto'){
		$nombre_corto =  get_post_meta ( $post_id, 'nombre_corto', true );
		//var_dump($nombre_corto); die;
		echo $nombre_corto;
	}elseif($column=='id'){
		$id =  get_post_meta ( $post_id, 'id', true );
		//var_dump($nombre_corto); die;
		echo $id;
	}
}
add_action ( 'manage_regiones_detalle_posts_custom_column', 'regiones_detalle_custom_column', 10, 3 );
add_filter( 'manage_edit-regiones_detalle_sortable_columns', 'my_regiones_detalle_sortable_columns' );

function my_regiones_detalle_sortable_columns( $columns ) {
	$columns['nombre_corto'] = 'nombre_corto';
	$columns['id'] = 'id';
	return $columns;
}

//** CHANGE TEMP 05-02-2020 - IJENSEN
add_action('wp_ajax_nopriv_dcms_ajax_buscar_job_ocupacion','dcms_enviar_buscar_job_ocupacion');
add_action('wp_ajax_dcms_ajax_buscar_job_ocupacion','dcms_enviar_buscar_job_ocupacion');

function dcms_enviar_buscar_job_ocupacion(){
	global $wpdb;

	$buscar_ocupaciones = isset($_POST['buscar_ocupaciones']) && $_POST['buscar_ocupaciones'] != '' ? strtolower($_POST['buscar_ocupaciones']) : '';

	$sql_ocupacion = "select id_occupation, code_job_position, name_job_position from cl_job_positions where LOWER(name_job_position) LIKE '%".$buscar_ocupaciones."%' order by id_occupation";

    $rs_ocupacion  = $wpdb->get_results($sql_ocupacion);
    
    $rs_ajax_job_ocupacion = array();

    $digital = $wpdb->get_results("SELECT id_region, code_region, name_region FROM cl_regions");

	if(is_array($rs_ocupacion) && count($rs_ocupacion)>0){	

		foreach ($rs_ocupacion as $row) {

            $id_occupation      = isset($row->id_occupation)      && $row->id_occupation !=''    ? $row->id_occupation : '';
            $code_job_position    = isset($row->code_job_position)    && $row->code_job_position !=''  ? $row->code_job_position : '';
            $name_job_position    = isset($row->name_job_position)    && $row->name_job_position !=''  ? $row->name_job_position : '';
            $uri_occupation     = $row->name_job_position !=''    && $row->code_job_position !=''    ? get_site_url().'/ocupacion-detalle/puesto-de-trabajo/?code_job_position='.$code_job_position.'&id_occupation='.$id_occupation : '';

			array_push($rs_ajax_job_ocupacion, array('id_occupation' => $id_occupation, 'code_job_position' => $code_job_position, 'name_job_position' => $name_job_position, 'uri_occupation' => $uri_occupation));
		}
	}
	wp_send_json($rs_ajax_job_ocupacion);
	wp_die();
}

//** AJX Buscador Ocupaciones**/
add_action('wp_ajax_nopriv_dcms_ajax_buscar_ocupacion','dcms_enviar_buscar_ocupacion');
add_action('wp_ajax_dcms_ajax_buscar_ocupacion','dcms_enviar_buscar_ocupacion');

function dcms_enviar_buscar_ocupacion(){
	global $wpdb;

	$buscar_ocupaciones = isset($_POST['buscar_ocupaciones']) && $_POST['buscar_ocupaciones'] != '' ? strtolower($_POST['buscar_ocupaciones']) : '';

	$sql_ocupacion = "select
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
            and wp_postmeta.meta_key = 'id' and LOWER(cl_job_positions.name_job_position) LIKE '%".$buscar_ocupaciones."%' order by cl_job_positions.id_occupation";

    $rs_ocupacion  = $wpdb->get_results($sql_ocupacion);

    $rs_ajax_ocupacion = array();

	if(is_array($rs_ocupacion) && count($rs_ocupacion)>0){	

		foreach ($rs_ocupacion as $row) {
		    $id_occupation      = isset($row->id_occupation)        && $row->id_occupation !=''         ? $row->id_occupation : '';
            $code_job_position  = isset($row->code_job_position)    && $row->code_job_position !=''     ? $row->code_job_position : '';
            $name_job_position  = isset($row->name_job_position)    && $row->name_job_position !=''     ? $row->name_job_position : '';
            $get_the_id         = isset($row->get_the_id)           && $row->get_the_id !=''            ? $row->get_the_id : '';
            $get_permalink      = get_permalink($get_the_id);

            $uri_occupation     = $row->name_job_position !=''    && $row->code_job_position !=''    ? $get_permalink.'?code_job_position='.$code_job_position  : '';

			array_push($rs_ajax_ocupacion, array('id_occupation' => $id_occupation, 'name_occupation' => $name_occupation, 'uri_occupation' => $uri_occupation));
		}
	}

	wp_send_json($rs_ajax_ocupacion);
	wp_die();
}

//** AJX Buscador SUBOcupaciones**/
add_action('wp_ajax_nopriv_dcms_ajax_buscar_subocupacion','dcms_enviar_buscar_subocupacion');
add_action('wp_ajax_dcms_ajax_buscar_subocupacion','dcms_enviar_buscar_subocupacion');

function dcms_enviar_buscar_subocupacion(){
	global $wpdb;
	
	$buscar_ocupaciones = isset($_POST['buscar_ocupaciones']) && $_POST['buscar_ocupaciones'] != '' ? strtolower($_POST['buscar_ocupaciones']) : '';

	$id_occupation = isset($_POST['id_occupation']) && $_POST['id_occupation'] != '' ? strtolower($_POST['id_occupation']) : '';

	$sql_ocupacion = "select id_occupation, code_job_position, name_job_position from cl_job_positions where id_occupation = ".$id_occupation." order by name_job_position";

    $rs_ocupacion  = $wpdb->get_results($sql_ocupacion);  

    $rs_ajax_ocupacion = array();

	if(is_array($rs_ocupacion) && count($rs_ocupacion)>0){
		foreach ($rs_ocupacion as $row) {
			$code_job_position  = isset($row->code_job_position)  && $row->code_job_position !=''    ? $row->code_job_position : '';
			$name_job_position  = isset($row->name_job_position)  && $row->name_job_position !=''  	 ? $row->name_job_position : '';
					$uri_occupation   	= $row->name_job_position !='' 	  && $row->code_job_position !=''    ? get_site_url().'/ocupacion-detalle/'.$id_occupation.'/?code_job_position='.$code_job_position : '';
			//$uri_occupation   	= $row->name_job_position !='' 	  && $row->code_job_position !=''    ? get_site_url().'/ocupacion-detalle/'.$id_occupation : '';
			//array_push($rs_ajax_ocupacion, array('code_job_position' => $code_job_position, 'name_job_position' => $name_job_position, 'uri_occupation' => $uri_occupation));
			array_push($rs_ajax_ocupacion, array('code_job_position' => $code_job_position, 'name_job_position' => $name_job_position, 'uri_occupation' => $uri_occupation));
		}
	}
	wp_send_json($rs_ajax_ocupacion);
	wp_die();
}

//** AJX Buscador Sector**/
add_action('wp_ajax_nopriv_dcms_ajax_buscar_sector','dcms_enviar_buscar_sector');
add_action('wp_ajax_dcms_ajax_buscar_sector','dcms_enviar_buscar_sector');

function dcms_enviar_buscar_sector(){
	global $wpdb;
	$buscar_sectores = isset($_POST['buscar_sectores']) && $_POST['buscar_sectores'] != '' ? strtolower($_POST['buscar_sectores']) : '';
	//$sql_sector = "select id_sector, code_sector ,name_sector from cl_sectors where LOWER(name_sector) LIKE '%".$buscar_sectores."%' order by id_sector";
	/*$sql_sector = "select cs.id_sector, cs.name_sector , cs.code_sector
					from cl_sectors as cs 
		            inner join cl_divisions dv on (cs.id_sector = dv.id_division)
		            inner join cl_groups as gp on (dv.id_division = gp.id_division)
		            inner join cl_class as cls on (gp.id_group = cls.id_group)
		            inner join cl_subclass as sbcl on (cls.id_class = sbcl.id_class)
		            inner join cl_codes as cod on (sbcl.id_subclass = cod.id_subclass)
		            where LOWER(concat(cs.name_sector, cod.name_code)) LIKE '%".$buscar_sectores."%'
		            group by cs.id_sector, cs.name_sector, cs.code_sector
		            order by cs.name_sector";*/
	$sql_sector = "
				select 
					cs.id_sector, cs.name_sector, wp_postmeta.post_id
				from cl_sectors as cs 
				inner join cl_divisions dv on (cs.id_sector = dv.id_division)
				inner join cl_groups as gp on (dv.id_division = gp.id_division)
				inner join cl_class as cls on (gp.id_group = cls.id_group)
				inner join cl_subclass as sbcl on (cls.id_class = sbcl.id_class)
				inner join cl_codes as cod on (sbcl.id_subclass = cod.id_subclass)
				inner join wp_postmeta  on (cs.id_sector::int = wp_postmeta.meta_value::int)
				inner join wp_posts on (wp_posts.ID = wp_postmeta.post_id)
				where post_type = 'detalle_sector'
				and wp_postmeta.meta_key = 'id'
				and LOWER(concat(cs.name_sector, cod.name_code)) LIKE '%".$buscar_sectores."%'
				group by cs.id_sector, cs.name_sector, wp_postmeta.post_id
				order by cs.name_sector";          
 	//echo $sql_sector;
    $rs_sector  = $wpdb->get_results($sql_sector);
    //var_dump($rs_sector);exit;

    $rs_ajax_sector = array();



	if(is_array($rs_sector) && count($rs_sector)>0){	
		foreach ($rs_sector as $row) {
			$id_sector      = isset($row->id_sector)      && $row->id_sector !=''    ? $row->id_sector : '';
			$code_sector    = isset($row->id_sector)    && $row->id_sector !=''  ? $row->id_sector : '';
			$name_sector    = isset($row->name_sector)    && $row->name_sector !=''  ? $row->name_sector : '';
			$uri_sector   	= $row->name_sector !='' 	  && $row->id_sector !=''    ? get_site_url().'/sector-detalle/'.$code_sector : '';
			//code sector
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
                   $id_code      	= isset($row_code->id_code)      && $row_code->id_code !=''    ? $row_code->id_code : '';
                    $name_code    	= isset($row_code->name_code)    && $row_code->name_code !=''  ? $row_code->name_code : '';
                    $post_id     	= isset($row->post_id)        && $row->post_id !=''      ? $row->post_id : '';
                    $get_permalink  = get_permalink($post_id);
                    $uri_code     	= $row_code->id_code !='' 	   	 && $row->id_sector !=''       ? $get_permalink.'?code_sector='.$id_code : '';

                    array_push($rs_ajax_code_sector, array( 'id_code' => $id_code, 'name_code' => $name_code, 'uri_code' => $uri_code));           
                }
            }
			array_push($rs_ajax_sector, array('code_sector' => $code_sector, 'name_sector' => $name_sector, 'uri_sector' => $uri_sector, 'code' => $rs_ajax_code_sector));
		}
	}
	wp_send_json($rs_ajax_sector);
	wp_die();
}

//** AJX Buscador Region**/
add_action('wp_ajax_nopriv_dcms_ajax_buscar_region','dcms_enviar_buscar_region');
add_action('wp_ajax_dcms_ajax_buscar_region','dcms_enviar_buscar_region');

function dcms_enviar_buscar_region(){
	global $wpdb;

	$buscar_regiones = isset($_POST['buscar_regiones']) && $_POST['buscar_regiones'] != '' ? strtolower($_POST['buscar_regiones']) : '';

	$sql_region = "select id_region, code_region ,name_region from cl_regions where LOWER(name_region) LIKE '%".$buscar_regiones."%' order by id_region";

    $rs_region  = $wpdb->get_results($sql_region);

    $rs_ajax_region = array();
	if(is_array($rs_region) && count($rs_region)>0){	
		foreach ($rs_region as $row) {
			$id_region      = isset($row->id_region)      && $row->id_region !=''    ? $row->id_region : '';
			$name_region    = isset($row->name_region)    && $row->name_region !=''  ? $row->name_region : '';
			$uri_region   	= $row->name_region !='' 	  && $row->id_region !=''    ? get_site_url().'/region-detalle/'.$id_region : '';
			array_push($rs_ajax_region, array('id_region' => $id_region, 'name_region' => $name_region, 'uri_region' => $uri_region));
		}
	}
	wp_send_json($rs_ajax_region);
	wp_die();
}

//** AJX Buscador Cursos**/
add_action('wp_ajax_nopriv_dcms_ajax_buscar_curso','dcms_enviar_buscar_curso');
add_action('wp_ajax_dcms_ajax_buscar_curso','dcms_enviar_buscar_curso');



function dcms_enviar_buscar_curso(){
	global $wpdb;

	$buscar_curso 	= isset($_POST['buscar_curso']) 	&& $_POST['buscar_curso'] != '' 	? strtolower($_POST['buscar_curso']) : '';
	$nivel_curso  	= isset($_POST['nivel_curso'])  	&& $_POST['nivel_curso'] != ''  	? strtolower($_POST['nivel_curso']) : '';
	//$modalidad_curso= isset($_POST['modalidad_curso'])  && $_POST['modalidad_curso'] != ''  ? strtolower($_POST['modalidad_curso']) : '';
	$modalidad_curso= isset($_POST['modalidad_curso'])  && $_POST['modalidad_curso'] != ''  ? strtolower($_POST['modalidad_curso']) : '';
	$region_id		= isset($_POST['region_id'])  		&& $_POST['region_id'] != ''  		? strtolower($_POST['region_id']) : '';
	$ordenar_curso	= isset($_POST['ordenar_curso'])  	&& $_POST['ordenar_curso'] != ''  	? strtolower($_POST['ordenar_curso']) : '';

	$where = '';

	$where .= $where=='' && $buscar_curso!='' ? " where lower(concat( name, skills, modality, description, duration, overall_objective, status, price, url))  like '%".$buscar_curso."%'" : ''; 
	//$where .= $where=='' && $nivel_curso!='' ? " where lower(nivel)  like '%".$nivel_curso."%'" : ($where!='' && $nivel_curso!='' ? " and lower(nivel)  like '%".$nivel_curso."%'" : '');
	$where .= $where=='' && $modalidad_curso!='' ? " where modality  = ".$modalidad_curso : ($where!='' && $modalidad_curso!='' ? " and modality  = ".$modalidad_curso : '');
	$where .= $where=='' && $region_id!='' 		 ? " where id_region  = ".$region_id 	  : ($where!='' && $region_id!='' 		? " and id_region = ".$region_id : '');


	//Ordenar
	$order_by = '';
	switch ($ordenar_curso) {
		case 1: $order_by = ' order by price desc '; break;
		case 2: $order_by = ' order by price asc '; break;
		case 3: $order_by = ' order by duration desc '; break;
		case 4: $order_by = ' order by duration asc '; break;
	}
	//total rows

	$sql_curso_all = "
		SELECT 
			count(*) as total_rows
			FROM cl_courses_offered".$where;
	//echo $sql_curso; die;
    $rs_curso_all  	= $wpdb->get_results($sql_curso_all);

    //var_dump($rs_curso_all);


    $total_rows 	= isset($rs_curso_all[0]->total_rows) && $rs_curso_all[0]->total_rows>0 ? $rs_curso_all[0]->total_rows : '0';

    $cant_pagina	= '10';

    $position_pag	= isset($_POST['position_pag']) && $_POST['position_pag']!='' ? $_POST['position_pag'] : '0';

    $offset_pag		= ($cant_pagina*$position_pag); 

    //$key = isset($_GET['buscar_curso']) ? $_GET['buscar_curso'] : '';

	$sql_curso = "
		select id_course, id_region, co.overall_objective, course_name, name_relator,
		rut, quota, price, url, start_date as status, case when modality = 0 then 'Online'
		when modality = 1 then 'Semi-Presencial'
			when modality = 2 then 'Presencial'
			else '' end as modality,  skills, duration, offer_origin, description
		FROM cl_courses_offered co
		LEFT JOIN cl_courses_relators cr
		ON co.id_relator = cr.id_relator".$where.$order_by." limit ".$cant_pagina." offset ".$offset_pag;

	//echo $sql_curso; die;
    $rs_curso  = $wpdb->get_results($sql_curso);
   // var_dump($sql_curso); die;
    $rs_ajax_curso = array();
    $rs_ajax_head = array();
    $rs_ajax_body = array();

	if(is_array($rs_curso) && count($rs_curso)>0){

		$rs_ajax_head = array(
							'total_rows' 	=> $total_rows,
							'cant_pagina' 	=> $cant_pagina,
							'position_pag'	=> $position_pag,
							'buscar_curso'	=> $buscar_curso,
							'nivel_curso'	=> $nivel_curso,
							'region_id' 	=> $region_id,
							'modalidad_curso' => $modalidad_curso	
						);

		foreach ($rs_curso as $row) {
			$course_name      	= isset($row->course_name)      	&& $row->course_name !=''   	? $row->course_name : '';
			$modality      		= isset($row->modality)      		&& $row->modality !=''    		? $row->modality : '';
			$name_relator      	= isset($row->name_relator)      	&& $row->name_relator !=''    	? $row->name_relator : '';
			//$rut      			= isset($row->rut)      			&& $row->rut !=''    			? $row->rut : '';
			$duration      		= isset($row->duration)      		&& $row->duration !=''    		? $row->duration : '';
			$overall_objective  = isset($row->overall_objective)    && $row->overall_objective !='' ? $row->overall_objective : '';
			$status      		= isset($row->status)      			&& $row->status !=''    		? $row->status : '';
			//$name_program      	= isset($row->name_program)      	&& $row->name_program !=''    	? $row->name_program : '';
			//$nivel      		= isset($row->nivel)      			&& $row->nivel !=''    			? $row->nivel : '';
			$url      			= isset($row->url)      			&& $row->url !=''    			? $row->url : '';
			$start_date      	= isset($row->start_date)      		&& $row->start_date !=''    	? $row->start_date : '';
			$price				= isset($row->price)				&& $row->price!=''				? $row->price : '';

			array_push($rs_ajax_body, array(
											'course_name'		=> $course_name, 
											'name_relator'		=> $name_relator,
											//'rut'				=> $rut,
											'modality' 			=> $modality, 
											//'description' 		=> $description,
											'duration' 			=> $duration,
											'overall_objective'	=> $overall_objective,
											'status'			=> $status,
											'name_program'		=> $name_program,
											//'nivel'			=> $nivel,
											'url'				=> $url,
											'price'				=> $price
										));
		}
	}
	array_push($rs_ajax_curso, array('pagination' =>  $rs_ajax_head,'data' => $rs_ajax_body));

	wp_send_json($rs_ajax_curso);
	wp_die();
}

/** Admin Combo Region */
function dcms_get_region(){
	global $wpdb;
    $sql_region = "select id_region, name_region from cl_regions order by cast(code_region as integer) asc";
    $rs_region  = $wpdb->get_results($sql_region); 
    $prov = array();
    $count = 0;
    if(is_array($rs_region) && count($rs_region)>0){
        foreach ($rs_region as $row) {
            //var_dump($row->id_region); die;
            $prov[$count]['id']		= isset($row->id_region)      && $row->id_region !=''    ? $row->id_region : '';
            $prov[$count]['name']	= isset($row->name_region)    && $row->name_region !=''  ? $row->name_region : '';
           	$count++;
        }
        wp_send_json($prov);
		wp_die();
    }else{
    	wp_send_json(null);
		wp_die();
    }
}
add_action('wp_ajax_nopriv_dcms_ajax_get_region', 'dcms_get_region');
add_action('wp_ajax_dcms_ajax_get_region', 'dcms_get_region');

/** Admin Combo Sector */
function dcms_get_sector(){
	global $wpdb;
    $sql_sector = "select id_sector, name_sector from cl_sectors order by id_sector";
    $rs_sector  = $wpdb->get_results($sql_sector);
    $prov = array();
    $count = 0;
    if(is_array($rs_sector) && count($rs_sector)>0){
        foreach ($rs_sector as $row) {
            //var_dump($row->id_sector); die;
            $prov[$count]['id']		= isset($row->id_sector)    && $row->id_sector !=''  ? $row->id_sector : '';
            $prov[$count]['name']	= isset($row->name_sector)    && $row->name_sector !=''  ? $row->name_sector : '';
           	$count++;
        }
        wp_send_json($prov);
		wp_die();
    }else{
    	wp_send_json(null);
		wp_die();
    }
}
add_action('wp_ajax_nopriv_dcms_ajax_get_sector', 'dcms_get_sector');
add_action('wp_ajax_dcms_ajax_get_sector', 'dcms_get_sector');

/** Admin Combo Region */
function dcms_get_ocupacion(){
	global $wpdb;
    $sql_ocupacion = "select id_occupation, name_occupation from cl_occupations order by name_occupation asc";
    $rs_ocupacion  = $wpdb->get_results($sql_ocupacion);
    $prov = array();
    $count = 0;
    if(is_array($rs_ocupacion) && count($rs_ocupacion)>0){
        foreach ($rs_ocupacion as $row) {
            //var_dump($row->id_ocupacion); die;
            $prov[$count]['id']		= isset($row->id_occupation)      && $row->id_occupation !=''    ? $row->id_occupation : '';
            $prov[$count]['name']	= isset($row->name_occupation)    && $row->name_occupation !=''  ? $row->name_occupation : '';
           	$count++;
        }
        wp_send_json($prov);
		wp_die();
    }else{
    	wp_send_json(null);
		wp_die();
    }
}

add_action('wp_ajax_nopriv_dcms_ajax_get_ocupacion', 'dcms_get_ocupacion');
add_action('wp_ajax_dcms_ajax_get_ocupacion', 'dcms_get_ocupacion');



function ajax_home_search(){

	global $wpdb;		
	$search = $_POST['search'];
	$type = $_POST['searchType']; // Sectores productivos o Ocupaciones

	if($type == 1){

		$columns = array(
			'table'			=> 'cl_sectors',
			'id'			=> 'id_sector',
			'name'			=> 'name_sector',
			'link_frag_u'	=> 'detalle_sector/'
		);

	}else{

		$columns = array(
			'table'			=> 'cl_occupations',
			'id'			=> 'id_occupation',
			'name'			=> 'name_occupation',
			'link_frag_u'	=> 'ocupacion-detalle/'
		);
	}
	
	$sql = "SELECT {$columns['id']}, {$columns['name']} , post_name
			FROM {$columns['table']}
			inner join wp_postmeta  on (wp_postmeta.meta_value = {$columns['id']}::text)
			inner join wp_posts on (wp_posts.ID = wp_postmeta.post_id)
			WHERE LOWER({$columns['name']}) LIKE '%".$search."%' 
			ORDER BY {$columns['name']} ASC 
			LIMIT 7";

    $results = $wpdb->get_results($sql, ARRAY_A);

    if( $results ){

    	$search_arr = array();

	    foreach( $results as $result ){

	        $search_arr[] = array(
	        	"id" => $result[$columns['id']], 
	           	"name_url" => $result['post_name'],
	           	"name" => $result[$columns['name']],
	        	"link_frag_u" => $columns['link_frag_u']
	        );
	    }

	    echo json_encode($search_arr); 

    }else{
    	echo json_encode($wpdb->show_errors);
    }

	wp_die();
 
}
add_action('wp_ajax_nopriv_ajax_home_search', 'ajax_home_search');
add_action('wp_ajax_ajax_home_search', 'ajax_home_search');

function ajax_home_sub_search(){

	global $wpdb;		
	$search = $_POST['search'];
	$type = $_POST['searchType']; // Sectores productivos o Ocupaciones

	if($type == 1){

		$columns = array(
			'id' 			=> 'id_sector',
			'code'			=> 'id_class',
			'name'			=> 'name_class',
			'link_frag_u'	=> 'sector-detalle/',
			'link_frag_d'	=> '/?code_sector='
		);

		$sql = "SELECT cs.{$columns['id']}, cls.{$columns['code']}, cls.{$columns['name']}, wp.post_name from cl_class cls
				inner join cl_groups as gp on (cls.id_group = gp.id_group)
				inner join cl_divisions as dv on (gp.id_division = dv.id_division)
				inner join cl_sectors as cs on (dv.id_sector = cs.id_sector)
				inner join wp_posts as wp on (cs.name_sector = wp.post_title)
				where lower(cls.{$columns['name']}) like '%".$search."%' 
				ORDER BY {$columns['name']} ASC 
				LIMIT 7";
	}
	
    $results = $wpdb->get_results($sql, ARRAY_A);

    if( $results ){

    	$search_arr = array();

	    foreach( $results as $result ){

	        $search_arr[] = array(
	        	"id" 			=> $result[$columns['id']], 
	        	"name" 			=> $result[$columns['name']],
	        	"name_url" 		=> $result['post_name'],
	        	"code"			=> $result[$columns['code']],
	        	"link_frag_u" 	=> $columns['link_frag_u'],
	        	"link_frag_d" 	=> $columns['link_frag_d']
	        );
	    }

	    echo json_encode($search_arr); 

    }else{
    	echo json_encode($wpdb->show_errors);
    }

	wp_die();
 
}
add_action('wp_ajax_nopriv_ajax_home_sub_search', 'ajax_home_sub_search');
add_action('wp_ajax_ajax_home_sub_search', 'ajax_home_sub_search');

function ajax_home_digital_search(){

	global $wpdb;		
	$search = $_POST['search'];
	$type = $_POST['searchType']; // Sectores productivos o Ocupaciones

	if($type != 1){

		$columns = array(		
			'id'			=> 'id_occupation',
			'code'			=> 'code_job_position',
			'name'			=> 'name_job_position'
		);

		$sql = "SELECT {$columns['id']}, {$columns['name']}, {$columns['code']} , post_name
				from cl_job_positions 
				inner join wp_postmeta  on (wp_postmeta.meta_value = {$columns['id']}::text)
				inner join wp_posts on (wp_posts.ID = wp_postmeta.post_id)
				WHERE lower({$columns['name']}) LIKE '%".$search."%' 
				ORDER BY {$columns['name']} ASC 
				LIMIT 7";
	}
	
    $results = $wpdb->get_results($sql, ARRAY_A);

    if( $results ){

    	$search_arr = array();

	    foreach( $results as $result ){

	        $search_arr[] = array(
	        	"id" 			=> $result[$columns['id']], 
	        	"name_url"		=> $result['post_name'],
	        	"name" 			=> $result[$columns['name']],
	        	"code"			=> $result[$columns['code']]
	        );
	    }

	    echo json_encode($search_arr); 

    }else{
    	echo json_encode($wpdb->show_errors);
    }

	wp_die();
 
}
add_action('wp_ajax_nopriv_ajax_home_digital_search', 'ajax_home_digital_search');
add_action('wp_ajax_ajax_home_digital_search', 'ajax_home_digital_search');


/* Remve logged in bar from header */
add_action('get_header', 'my_filter_head');

function my_filter_head() {
remove_action('wp_head', '_admin_bar_bump_cb');
}
//Declarar variables pasables por URL
add_filter( 'query_vars', 'addnew_query_vars', 10, 1 );

function addnew_query_vars($vars)
{     
    array_push($vars, "code_job_position", "id_occupation");
    return $vars;
}





//** ADD function Shortcode **/
require_once 'functions-shortcode.php';

//** ADD function Graficos **/
require_once 'functions-grafico.php';

//** ADD function Json Mapa **/
require_once 'functions-mapa.php';
?>
