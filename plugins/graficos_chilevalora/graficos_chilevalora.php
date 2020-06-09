<?php 
/*
Plugin Name: Grafico ChileValora
Plugin URI: http://ingeniaglobal.cl
Description: Este plugin permite activar o desactivar gráficos de Chile Valora
Author: Ingenia
Version: 1.0
Author URI: http://ingeniaglobal.cl
*/

function menuGrafico(){
	add_menu_page( 'grafico_load', 'Gráficos Chilevalora', 'read', 'grafico_load', 'grafico_load', 'dashicons-admin-users');
}

//registrar plugin en admin

add_action( 'admin_menu', 'menuGrafico');


function grafico_load(){
	if (count($_POST) == 0 && $_GET['action'] == '') {
		echo mainGraficoRuta();
	}elseif($_GET['action']=='add'){
		echo mainAddGraficoRuta();
	}elseif($_GET['action']=='save'){
		echo mainsaveGraficoRuta();
	}elseif($_GET['action']=='guarda'){
		echo guardaGrafico();
	}elseif($_GET['action']=='detalle'){
		echo detalleGrafico();
	}else{
		echo mainGraficoRuta();
	}
}

add_action( 'admin_enqueue_scripts', 'my_enqueue_script_admin' );

function my_enqueue_script_admin( $hook ) {
    

	//CHARTS JS
	wp_enqueue_script('highcharts_js', get_template_directory_uri() . '/js/highcharts.js', array(), '3.3.4');
	//
	wp_enqueue_script('highcharts_data', get_template_directory_uri() . '/js/modules/data.js', array('highcharts_js'), '3.3.4');
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
	wp_enqueue_script('graficos-ajax', plugin_dir_url(dirname(__FILE__)) . '/graficos_chilevalora/js/ajax.js', array('highcharts_sankey'), '3.3.4');
	
}

function mainGraficoRuta(){
	global $wpdb;

	$sql 	= "select id_graphics, name_graphics, state_graphics from cl_graphics order by id_graphics asc";
	$rs 	= $wpdb->get_results($sql);
	?>
	
	<h3 class="text-center">Listado de gráficos</h3>

	<table class="table table-striped" id="graficos_table">
        <thead>
            <tr role="row">
            	<th>Indicador</th>
            	<th width="20%">Estado</th>
            	<th width="20%"></th>
           	</tr>
        </thead>
        <tbody>
        	
        	<?php 
        		if(is_array($rs) && count($rs)>0){
        			foreach ($rs as $row) {
        				$state_graphics = isset($row->state_graphics) && $row->state_graphics!='' ? $row->state_graphics : '';
        				if($state_graphics==1){
        					$label = '<span class="badge badge-danger">Desactivado</span>';
        				}
        				if($state_graphics==2){
        					$label = '<span class="badge badge-success">Publicado</span>';
        				}
        				?>
        				<tr>
			                <td><?php echo $row->name_graphics; ?></td>
			                <td><?php echo $label; ?></td>
			                <td>
			                	<a href="<?php echo get_site_url(); ?>/wp-admin/admin.php?page=grafico_load&action=detalle&id_graphics=<?php echo $row->id_graphics; ?>" class="btn btn-chilevalora btn-block">Ver Gráfico</a>
			                </td>
			            </tr>
        				<?php
        			}
        		}
        	?>
        	
        </tbody>
   	</table>

	<?php
}

function detalleGrafico(){
	global $wpdb;

	$id_graphics = isset($_GET['id_graphics']) && $_GET['id_graphics']!='' ? $_GET['id_graphics'] : '';
	if(is_numeric($id_graphics)){
		switch ($id_graphics) {
			case 1 : echo graphics1($id_graphics);  break;
			case 2 : echo graphics2($id_graphics);  break;
			case 3 : echo graphics3($id_graphics);  break;
			case 4 : echo graphics4($id_graphics);  break;
			case 5 : echo graphics5($id_graphics);  break;
			case 6 : echo graphics6($id_graphics);  break;
			case 7 : echo graphics7($id_graphics);  break;
			case 8 : echo graphics8($id_graphics);  break;
			case 9 : echo graphics9($id_graphics);  break;
			case 10 : echo graphics10($id_graphics);  break;
			default : echo mainGraficoRuta(); break;
		}
	}else{
		 echo mainGraficoRuta();
	}

}

function btn_state_grafico($id_graphics){
	global $wpdb;

	$sql 	= "select state_graphics from cl_graphics where id_graphics=".$id_graphics;
	$rs 	= $wpdb->get_results($sql);
	$rs 	= (array) $rs;

	if(is_array($rs) && count($rs)>0){
		$state_graphics = isset($rs[0]->state_graphics) && $rs[0]->state_graphics!='' ? $rs[0]->state_graphics : '';
		if($state_graphics==2){
			?>
				<button type="button" onclick="update_state_grafico(<?php echo $id_graphics ?>, 1)" class="btn btn-danger btn_publish">Desactivar</button>
			<?php
		}
		if($state_graphics==1){
			?>
				<button type="button" onclick="update_state_grafico(<?php echo $id_graphics ?>, 2)" class="btn btn-success btn_publish">Publicar</button>
			<?php
		}
	}
}

function graphics1($id_graphics){
	?>
	<div class="col-12">
        <div class="bloque-grafica">
        	<div class="col-12 text-right">
        		<?php echo btn_state_grafico($id_graphics); ?>
        		<a href="<?php echo get_site_url(); ?>/wp-admin/admin.php?page=grafico_load" class="btn btn-chilevalora">&laquo; Volver</a>
        	</div>
            <h2>Número de ocupados en el tiempo</h2>
            <div class="grafica">
                <script>

                    document.addEventListener('DOMContentLoaded', function () {
                        Highcharts.getJSON('<?php echo get_site_url(); ?>/wp-json/wp/v2/crecimiento_sectores_dashboard_old/', function (data) {

                            if(data){
                                var myChart6 = Highcharts.chart('chartdiv6old', {
                                    chart: {
                                        type: 'bar',
                                        height : 800
                                    },
                                    title: {
                                        text: 'Número de trabajadores del sector'
                                    },
                                    subtitle: {
                                        text: 'DestinoEmpleo en base a los datos del Seguro de Cesantía'
                                    },
                                    lang : {
                                        downloadCSV : 'Descargar CSV',
                                        downloadJPEG: 'Descargar JPEG',
                                        downloadPDF : 'Descargar PDF',
                                        downloadPNG : 'Descargar PNG',
                                        downloadSVG : 'Descargar SVG',
                                        downloadXLS : 'Descargar Excel',
                                        printChart  : 'Imprimir Gráfico',
                                        viewData    : 'Ver Data'
                                    },
                                    exporting: {
                                        buttons: {
                                          contextButton: {
                                            menuItems: [
                                              'printChart',
                                              'separator',
                                              'downloadPNG',
                                              'downloadJPEG',
                                              'downloadPDF',
                                              'downloadSVG',
                                              'separator',
                                              'downloadCSV',
                                              'downloadXLS',
                                              'viewData'
                                            ]
                                          }
                                        }

                                    },
                                    xAxis: {
                                        categories: data.ejeX,
                                        title : {
                                            text: 'Sectores'
                                        }
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: 'Número de ocupados'
                                        },
                                        labels: {
                                            formatter: function() {
                                             // if ( this.value > 100000 ) return Highcharts.numberFormat( this.value/1000, 1) + "l";  // maybe only switch if > 1000
                                              return Highcharts.numberFormat(this.value,0);
                                            }                
                                        }
                                    },
                                    tooltip: {
                                        formatter:function(){
                                            //console.log(this);
                                            return ' N° ocupados = <b>' + this.y + '</b>';
                                        }
                                    },
                                    legend: {
                                        reversed: true
                                    },
                                    plotOptions: {
                                        series: {
                                            stacking: 'normal'
                                        }
                                    },
                                    //colors: ['#7fbeda', '#646cd4', '#9d64d4', '#d364c7', '#d46584', '#d48664'],
                                    series: [data.data_grafico]
                                });
                            }else{
                                jQuery('#chartdiv6old').html('<br><br><div class="alert alert-danger" role="alert">No existe información asociada a este gráfico!</div>')
                            }
                            
                            
                        });
                	});
                
                </script>
                <div id="chartdiv6old" class="chartdiv"></div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        Highcharts.getJSON('<?php echo get_site_url(); ?>/wp-json/wp/v2/crecimiento_sectores_dashboard/', function (data) {
                            //console.log(data.data_grafico);
                            if(data){
                                var myChart6 = Highcharts.chart('chartdiv6', {
                                    chart: {
                                        type: 'bar',
                                        height : 800
                                    },
                                    title: {
                                        text: 'Número de trabajadores del sector'
                                    },
                                    subtitle: {
                                        text: 'DestinoEmpleo en base a los datos del Seguro de Cesantía'
                                    },
                                    lang : {
                                        downloadCSV : 'Descargar CSV',
                                        downloadJPEG: 'Descargar JPEG',
                                        downloadPDF : 'Descargar PDF',
                                        downloadPNG : 'Descargar PNG',
                                        downloadSVG : 'Descargar SVG',
                                        downloadXLS : 'Descargar Excel',
                                        printChart  : 'Imprimir Gráfico',
                                        viewData    : 'Ver Data'
                                    },
                                    exporting: {
                                        buttons: {
                                          contextButton: {
                                            menuItems: [
                                              'printChart',
                                              'separator',
                                              'downloadPNG',
                                              'downloadJPEG',
                                              'downloadPDF',
                                              'downloadSVG',
                                              'separator',
                                              'downloadCSV',
                                              'downloadXLS',
                                              'viewData'
                                            ]
                                          }
                                        }

                                    },
                                    xAxis: {
                                        categories: data.ejeX,
                                        title : {
                                            text: 'Sectores'
                                        }
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: 'Número de ocupados'
                                        }
                                    },
                                    tooltip: {
                                        formatter:function(){
                                            //console.log(this);
                                            return ' N° ocupados = <b>' + this.y + '</b>';
                                        }
                                    },
                                    legend: {
                                        reversed: true
                                    },
                                    plotOptions: {
                                        series: {
                                            stacking: 'normal'
                                        }
                                    },
                                    //colors: ['#7fbeda', '#646cd4', '#9d64d4', '#d364c7', '#d46584', '#d48664'],
                                    series: [data.data_grafico]
                                });
                            }else{
                                jQuery('#chartdiv6old').html('<br><br><div class="alert alert-danger" role="alert">No existe información asociada a este gráfico!</div>')
                            }
                        });
                });
                </script>
                <div id="chartdiv6" class="chartdiv"></div>
            </div>
            <hr>
            <div class="col-12 text-right">
            	<?php echo btn_state_grafico($id_graphics); ?>
        		<a href="<?php echo get_site_url(); ?>/wp-admin/admin.php?page=grafico_load" class="btn btn-chilevalora">&laquo; Volver</a>
        	</div>
        </div>
    </div>

	<?php 
}

function graphics2($id_graphics){
	?>
	<div class="col-12">
        <div class="bloque-grafica">
        	<div class="col-12 text-right">
        		<?php echo btn_state_grafico($id_graphics); ?>
        		<a href="<?php echo get_site_url(); ?>/wp-admin/admin.php?page=grafico_load" class="btn btn-chilevalora">&laquo; Volver</a>
        	</div>
            <h2>XX% de contratos indefinidos</h2>
            <div class="grafica">
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        Highcharts.getJSON('<?php echo get_site_url(); ?>/wp-json/wp/v2/contratos_indefinidos_sectores_dashboard_old/', function (data) {
                            //console.log(data.data_grafico);
                            if(data){
                                var myChart6 = Highcharts.chart('chartdiv6old', {
                                    chart: {
                                        type: 'bar',
                                        height : 800
                                    },
                                    title: {
                                        text: 'XX% de contratos indefinidos'
                                    },
                                    subtitle: {
                                       // text: 'Fuente: Gobierno de Chile'
                                    },
                                    lang : {
                                        downloadCSV : 'Descargar CSV',
                                        downloadJPEG: 'Descargar JPEG',
                                        downloadPDF : 'Descargar PDF',
                                        downloadPNG : 'Descargar PNG',
                                        downloadSVG : 'Descargar SVG',
                                        downloadXLS : 'Descargar Excel',
                                        printChart  : 'Imprimir Gráfico',
                                        viewData    : 'Ver Data'
                                    },
                                    exporting: {
                                        buttons: {
                                          contextButton: {
                                            menuItems: [
                                              'printChart',
                                              'separator',
                                              'downloadPNG',
                                              'downloadJPEG',
                                              'downloadPDF',
                                              'downloadSVG',
                                              'separator',
                                              'downloadCSV',
                                              'downloadXLS',
                                              'viewData'
                                            ]
                                          }
                                        }

                                    },
                                    xAxis: {
                                        categories: data.ejeX,
                                        title : {
                                            text: 'Sectores'
                                        }
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: 'XX% de contratos indefinidos'
                                        }
                                    },
                                    tooltip: {
                                        formatter:function(){
                                            //console.log(this);
                                            return this.key+' = <b>' + this.y + ' %</b>';
                                        }
                                    },
                                    legend: {
                                        reversed: true
                                    },
                                    plotOptions: {
                                        series: {
                                            stacking: 'normal'
                                        }
                                    },
                                    //colors: ['#7fbeda', '#646cd4', '#9d64d4', '#d364c7', '#d46584', '#d48664'],
                                    series: [data.data_grafico]
                                });
                            }else{
                                jQuery('#chartdiv6old').html('<br><br><div class="alert alert-danger" role="alert">No existe información asociada a este gráfico!</div>')
                            }
                        });
                });
                </script>
                <div id="chartdiv6old" class="chartdiv"></div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        Highcharts.getJSON('<?php echo get_site_url(); ?>/wp-json/wp/v2/contratos_indefinidos_sectores_dashboard/', function (data) {
                            //console.log(data.data_grafico);
                            if(data){
                                var myChart6 = Highcharts.chart('chartdiv6', {
                                    chart: {
                                        type: 'bar',
                                        height: 800
                                    },
                                    title: {
                                        text: 'XX% de contratos indefinidos'
                                    },
                                    subtitle: {
                                        //text: 'Fuente: Gobierno de Chile'
                                    },
                                    lang : {
                                        downloadCSV : 'Descargar CSV',
                                        downloadJPEG: 'Descargar JPEG',
                                        downloadPDF : 'Descargar PDF',
                                        downloadPNG : 'Descargar PNG',
                                        downloadSVG : 'Descargar SVG',
                                        downloadXLS : 'Descargar Excel',
                                        printChart  : 'Imprimir Gráfico',
                                        viewData    : 'Ver Data'
                                    },
                                    exporting: {
                                        buttons: {
                                          contextButton: {
                                            menuItems: [
                                              'printChart',
                                              'separator',
                                              'downloadPNG',
                                              'downloadJPEG',
                                              'downloadPDF',
                                              'downloadSVG',
                                              'separator',
                                              'downloadCSV',
                                              'downloadXLS',
                                              'viewData'
                                            ]
                                          }
                                        }

                                    },
                                    xAxis: {
                                        categories: data.ejeX,
                                        title : {
                                            text: 'Sectores'
                                        }
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: 'XX% de contratos indefinidos'
                                        }
                                    },
                                    tooltip: {
                                        formatter:function(){
                                           //console.log(this);
                                            return this.key+' = <b>' + this.y + ' %</b>';
                                        }
                                    },
                                    legend: {
                                        reversed: true
                                    },
                                    plotOptions: {
                                        series: {
                                            stacking: 'normal'
                                        }
                                    },
                                    //colors: ['#7fbeda', '#646cd4', '#9d64d4', '#d364c7', '#d46584', '#d48664'],
                                    series: [data.data_grafico]
                                });
                            }else{
                                jQuery('#chartdiv6old').html('<br><br><div class="alert alert-danger" role="alert">No existe información asociada a este gráfico!</div>')
                            }
                        });
                });
                </script>
                <div id="chartdiv6" class="chartdiv"></div>
            </div>
            <hr>
            <div class="col-12 text-right">
            	<?php echo btn_state_grafico($id_graphics); ?>
        		<a href="<?php echo get_site_url(); ?>/wp-admin/admin.php?page=grafico_load" class="btn btn-chilevalora">&laquo; Volver</a>
        	</div>
        </div>
    </div>	
	<?php 
}

function graphics3($id_graphics){
	?>
	<div class="col-12">
        <div class="bloque-grafica">
        	<div class="col-12 text-right">
        		<?php echo btn_state_grafico($id_graphics); ?>
        		<a href="<?php echo get_site_url(); ?>/wp-admin/admin.php?page=grafico_load" class="btn btn-chilevalora">&laquo; Volver</a>
        	</div>
            <h2>% de contratos indefinidos</h2>
            <div class="grafica">
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        Highcharts.getJSON('<?php echo get_site_url(); ?>/wp-json/wp/v2/contratos_indefinidos_sectores_variacion_dashboard_old/', function (data) {
                            //console.log(data.data_grafico);
                            if(data){
                                var myChart6 = Highcharts.chart('chartdiv6old', {
                                    chart: {
                                        type: 'bar',
                                        height: 800
                                    },
                                    title: {
                                        text: '% de contratos indefinidos'
                                    },
                                    subtitle: {
                                       // text: 'Fuente: Gobierno de Chile'
                                    },
                                    lang : {
                                        downloadCSV : 'Descargar CSV',
                                        downloadJPEG: 'Descargar JPEG',
                                        downloadPDF : 'Descargar PDF',
                                        downloadPNG : 'Descargar PNG',
                                        downloadSVG : 'Descargar SVG',
                                        downloadXLS : 'Descargar Excel',
                                        printChart  : 'Imprimir Gráfico',
                                        viewData    : 'Ver Data'
                                    },
                                    exporting: {
                                        buttons: {
                                          contextButton: {
                                            menuItems: [
                                              'printChart',
                                              'separator',
                                              'downloadPNG',
                                              'downloadJPEG',
                                              'downloadPDF',
                                              'downloadSVG',
                                              'separator',
                                              'downloadCSV',
                                              'downloadXLS',
                                              'viewData'
                                            ]
                                          }
                                        }

                                    },
                                    xAxis: {
                                        categories: data.ejeX,
                                        title : {
                                            text: 'Sectores'
                                        }
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: '% de contratos indefinidos'
                                        }
                                    },
                                    tooltip: {
                                        formatter:function(){
                                            //console.log(this);
                                            return this.key+' = <b>' + this.y + ' %</b>';
                                        }
                                    },
                                    legend: {
                                        reversed: true
                                    },
                                    plotOptions: {
                                        series: {
                                            stacking: 'normal'
                                        }
                                    },
                                    //colors: ['#7fbeda', '#646cd4', '#9d64d4', '#d364c7', '#d46584', '#d48664'],
                                    series: [data.data_grafico]
                                });
                            }else{
                                jQuery('#chartdiv6old').html('<br><br><div class="alert alert-danger" role="alert">No existe información asociada a este gráfico!</div>')
                            }
                        });
                });
                </script>
                <div id="chartdiv6old" class="chartdiv"></div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        Highcharts.getJSON('<?php echo get_site_url(); ?>/wp-json/wp/v2/contratos_indefinidos_sectores_variacion_dashboard/', function (data) {
                            //console.log(data.data_grafico);
                            if(data){
                                var myChart6 = Highcharts.chart('chartdiv6', {
                                    chart: {
                                        type: 'bar',
                                        height: 800
                                    },
                                    title: {
                                        text: '% de contratos indefinidos'
                                    },
                                    subtitle: {
                                        //text: 'Fuente: Gobierno de Chile'
                                    },
                                    lang : {
                                        downloadCSV : 'Descargar CSV',
                                        downloadJPEG: 'Descargar JPEG',
                                        downloadPDF : 'Descargar PDF',
                                        downloadPNG : 'Descargar PNG',
                                        downloadSVG : 'Descargar SVG',
                                        downloadXLS : 'Descargar Excel',
                                        printChart  : 'Imprimir Gráfico',
                                        viewData    : 'Ver Data'
                                    },
                                    exporting: {
                                        buttons: {
                                          contextButton: {
                                            menuItems: [
                                              'printChart',
                                              'separator',
                                              'downloadPNG',
                                              'downloadJPEG',
                                              'downloadPDF',
                                              'downloadSVG',
                                              'separator',
                                              'downloadCSV',
                                              'downloadXLS',
                                              'viewData'
                                            ]
                                          }
                                        }

                                    },
                                    xAxis: {
                                        categories: data.ejeX,
                                        title : {
                                            text: 'Sectores'
                                        }
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: '% de contratos indefinidos'
                                        }
                                    },
                                    tooltip: {
                                        formatter:function(){
                                           //console.log(this);
                                            return this.key+' = <b>' + this.y + ' %</b>';
                                        }
                                    },
                                    legend: {
                                        reversed: true
                                    },
                                    plotOptions: {
                                        series: {
                                            stacking: 'normal'
                                        }
                                    },
                                    //colors: ['#7fbeda', '#646cd4', '#9d64d4', '#d364c7', '#d46584', '#d48664'],
                                    series: [data.data_grafico]
                                });
                            }else{
                                jQuery('#chartdiv6').html('<br><br><div class="alert alert-danger" role="alert">No existe información asociada a este gráfico!</div>')
                            }
                        });
                });
                </script>
                <div id="chartdiv6" class="chartdiv"></div>
            </div>
            <hr>
            <div class="col-12 text-right">
            	<?php echo btn_state_grafico($id_graphics); ?>
        		<a href="<?php echo get_site_url(); ?>/wp-admin/admin.php?page=grafico_load" class="btn btn-chilevalora">&laquo; Volver</a>
        	</div>
        </div>
    </div>	
	<?php 
}

function graphics4($id_graphics){
	?>
	<div class="col-12">
        <div class="bloque-grafica">
        	<div class="col-12 text-right">
        		<?php echo btn_state_grafico($id_graphics); ?>
        		<a href="<?php echo get_site_url(); ?>/wp-admin/admin.php?page=grafico_load" class="btn btn-chilevalora">&laquo; Volver</a>
        	</div>
            <h2>Duración del desempleo</h2>
            
            <hr>
            <div class="col-12 text-right">
            	<?php echo btn_state_grafico($id_graphics); ?>
        		<a href="<?php echo get_site_url(); ?>/wp-admin/admin.php?page=grafico_load" class="btn btn-chilevalora">&laquo; Volver</a>
        	</div>
        </div>
    </div>
	<?php 
}

function graphics5($id_graphics){
	global $wpdb;

    $cbSectorList = isset($_GET['cbSectorList']) && is_numeric($_GET['cbSectorList']) ? $_GET['cbSectorList'] : '0';
    ?>
        <div class="col-12">
            <div class="bloque-grafica">
                <div class="col-12 text-right">
                    <?php echo btn_state_grafico($id_graphics); ?>
                    <a href="<?php echo get_site_url(); ?>/wp-admin/admin.php?page=grafico_load" class="btn btn-chilevalora">&laquo; Volver</a>
                </div>
                <h2>XX% de rotación</h2>
                <div class="grafica">
                    <div class="row">
                        <div class="col-12">

                            <label class="col-3">Sector</label>
                            <div class="col-9">
                                <select name="cbSector" id="cbSector">
                                    <option value="0">Seleccione el sector a consultar</option>
                                    <?php 
                                        $sql_sector = "
                                            select 
                                                cl_sectors.id_sector,
                                                cl_sectors.name_sector
                                            from cl_sectors 
                                            order by cl_sectors.name_sector asc";
                                        $rs_sector  = $wpdb->get_results($sql_sector);
                                        if(is_array($rs_sector) && count($rs_sector)>0){
                                            foreach ($rs_sector as $row) {
                                                $id_sector      = isset($row->id_sector)      && $row->id_sector !=''    ? $row->id_sector : '';
                                                $name_sector    = isset($row->name_sector)    && $row->name_sector !=''  ? $row->name_sector : '';
                                                    if($cbSectorList==$id_sector){
                                                        ?>
                                                            <option value="<?php echo $id_sector; ?>" selected="selected"><?php echo $name_sector; ?></option>
                                                        <?php
                                                    }else{
                                                        ?>
                                                            <option value="<?php echo $id_sector; ?>"><?php echo $name_sector; ?></option>
                                                        <?php
                                                    }
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <script>
                        jQuery(document).ready(function($) {
                            jQuery("#cbSector").change(function(event) {

                                var cbSector = jQuery(this).val();

                                var url      = window.location.href;

                                window.location = url+'&cbSectorList='+cbSector;
                            });
                        });


                        document.addEventListener('DOMContentLoaded', function () {
                            Highcharts.getJSON('<?php echo get_site_url(); ?>/wp-json/wp/v2/crecimiento_rotacion_setores_dashboard_old/<?php echo $cbSectorList; ?>', function (data) {
                                var myChart7 = Highcharts.chart('chartdiv7old', {
                                        chart: {
                                            height : 900
                                        },
                                        title: {
                                            text: 'XX% de rotación'
                                        },
                                        subtitle: {
                                            // text: 'Fuente: Gobierno de Chile'
                                        },
                                        lang : {
                                            downloadCSV : 'Descargar CSV',
                                            downloadJPEG: 'Descargar JPEG',
                                            downloadPDF : 'Descargar PDF',
                                            downloadPNG : 'Descargar PNG',
                                            downloadSVG : 'Descargar SVG',
                                            downloadXLS : 'Descargar Excel',
                                            printChart  : 'Imprimir Gráfico',
                                            viewData    : 'Ver Data'
                                        },
                                        exporting: {
                                            buttons: {
                                              contextButton: {
                                                menuItems: [
                                                  'printChart',
                                                  'separator',
                                                  'downloadPNG',
                                                  'downloadJPEG',
                                                  'downloadPDF',
                                                  'downloadSVG',
                                                  'separator',
                                                  'downloadCSV',
                                                  'downloadXLS',
                                                  'viewData'
                                                ]
                                              }
                                            },
                                            csv: {
                                                columnHeaderFormatter: function(item, key) {
                                                    //console.log(key);
                                                    if (key=='from') {
                                                        return 'Sector desde'
                                                    }
                                                    if (key=='to') {
                                                        return 'A sector'
                                                    }
                                                    if (key=='weight') {
                                                        return '% Rotación'
                                                    }
                                                    return false
                                                }
                                            }
                                        },                                            
                                        xAxis: {
                                            title: {
                                                text: 'Años'
                                            }
                                        },
                                        plotOptions: {
                                            sankey: {
                                                dataLabels: {
                                                    color: 'black',
                                                },
                                                //keys: ['desde', 'a', 'porcentaje'],
                                            },

                                        },
                                        series: [{
                                            keys: ['from', 'to', 'weight'],
                                            data: data.data,
                                            type: 'sankey',
                                            name: 'XX% de rotación de los sectores del año '+data.ano,
                                            nodePadding : 16,
                                        }],
                                        nodes: [{
                                            id : 'to',
                                            name: 'a'
                                        }]
                                        
                                    });
                            });
                        });
                    </script>
                    <div id="chartdiv7old" class="chartdiv"></div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            Highcharts.getJSON('<?php echo get_site_url(); ?>/wp-json/wp/v2/crecimiento_rotacion_setores_dashboard/<?php echo $cbSectorList; ?>', function (data) {
                                var myChart7 = Highcharts.chart('chartdiv7', {
                                        title: {
                                            text: 'XX% de rotación'
                                        },
                                        subtitle: {
                                            // text: 'Fuente: Gobierno de Chile'
                                        },
                                        lang : {
                                            downloadCSV : 'Descargar CSV',
                                            downloadJPEG: 'Descargar JPEG',
                                            downloadPDF : 'Descargar PDF',
                                            downloadPNG : 'Descargar PNG',
                                            downloadSVG : 'Descargar SVG',
                                            downloadXLS : 'Descargar Excel',
                                            printChart  : 'Imprimir Gráfico',
                                            viewData    : 'Ver Data'
                                        },
                                        exporting: {
                                            buttons: {
                                              contextButton: {
                                                menuItems: [
                                                  'printChart',
                                                  'separator',
                                                  'downloadPNG',
                                                  'downloadJPEG',
                                                  'downloadPDF',
                                                  'downloadSVG',
                                                  'separator',
                                                  'downloadCSV',
                                                  'downloadXLS',
                                                  'viewData'
                                                ]
                                              }
                                            },
                                            csv: {
                                                columnHeaderFormatter: function(item, key) {
                                                    //console.log(key);
                                                    if (key=='from') {
                                                        return 'Sector desde'
                                                    }
                                                    if (key=='to') {
                                                        return 'A sector'
                                                    }
                                                    if (key=='weight') {
                                                        return '% Rotación'
                                                    }
                                                    return false
                                                }
                                            }
                                        },                                            
                                        xAxis: {
                                            title: {
                                                text: 'Años'
                                            }
                                        },
                                        plotOptions: {
                                            sankey: {
                                                dataLabels: {
                                                    color: 'black',
                                                },
                                                //keys: ['desde', 'a', 'porcentaje'],
                                            },

                                        },
                                        series: [{
                                            keys: ['from', 'to', 'weight'],
                                            data: data.data,
                                            type: 'sankey',
                                            name: 'XX% de rotación de los sectores del año '+data.ano,
                                            nodePadding : 16,
                                        }],
                                        nodes: [{
                                            id : 'to',
                                            name: 'a'
                                        }]
                                        
                                    });
                            });
                        });
                    </script>
                    <div id="chartdiv7" class="chartdiv"></div>
                </div>
                <hr>
                <div class="col-12 text-right">
                    <?php echo btn_state_grafico($id_graphics); ?>
                    <a href="<?php echo get_site_url(); ?>/wp-admin/admin.php?page=grafico_load" class="btn btn-chilevalora">&laquo; Volver</a>
                </div>
            </div>
        </div>
    <?php 
}

function graphics6($id_graphics){
	?>
	<div class="col-12">
        <div class="bloque-grafica">
        	<div class="col-12 text-right">
        		<?php echo btn_state_grafico($id_graphics); ?>
        		<a href="<?php echo get_site_url(); ?>/wp-admin/admin.php?page=grafico_load" class="btn btn-chilevalora">&laquo; Volver</a>
        	</div>
            <h2>XX% de nuevos trabajadores</h2>
            <div class="grafica">
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        Highcharts.getJSON('<?php echo get_site_url(); ?>/wp-json/wp/v2/crecimiento_nuevos_trabajadores_dashboard_old/', function (data) {
                            //console.log(data.data_grafico);
                            var myChart6 = Highcharts.chart('chartdiv6old', {
                                chart: {
                                    type: 'bar',
                                    height: 800
                                },
                                title: {
                                    text: 'XX% de nuevos trabajadores'
                                },
                                subtitle: {
                                   // text: 'Fuente: Gobierno de Chile'
                                },
                                lang : {
                                    downloadCSV : 'Descargar CSV',
                                    downloadJPEG: 'Descargar JPEG',
                                    downloadPDF : 'Descargar PDF',
                                    downloadPNG : 'Descargar PNG',
                                    downloadSVG : 'Descargar SVG',
                                    downloadXLS : 'Descargar Excel',
                                    printChart  : 'Imprimir Gráfico',
                                    viewData    : 'Ver Data'
                                },
                                exporting: {
                                    buttons: {
                                      contextButton: {
                                        menuItems: [
                                          'printChart',
                                          'separator',
                                          'downloadPNG',
                                          'downloadJPEG',
                                          'downloadPDF',
                                          'downloadSVG',
                                          'separator',
                                          'downloadCSV',
                                          'downloadXLS',
                                          'viewData'
                                        ]
                                      }
                                    }

                                },
                                xAxis: {
                                    categories: data.ejeX,
                                    title : {
                                        text: 'Sectores'
                                    }
                                },
                                yAxis: {
                                    min: 0,
                                    title: {
                                        text: 'XX% de nuevos trabajadores'
                                    }
                                },
                                tooltip: {
                                    formatter:function(){
                                        //console.log(this);
                                        return this.key+' = <b>' + this.y + ' %</b>';
                                    }
                                },
                                legend: {
                                    reversed: true
                                },
                                plotOptions: {
                                    series: {
                                        stacking: 'normal'
                                    }
                                },
                                //colors: ['#7fbeda', '#646cd4', '#9d64d4', '#d364c7', '#d46584', '#d48664'],
                                series: [data.data_grafico]
                            });
                        });
                });
                </script>
                <div id="chartdiv6old" class="chartdiv"></div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        Highcharts.getJSON('<?php echo get_site_url(); ?>/wp-json/wp/v2/crecimiento_nuevos_trabajadores_dashboard/', function (data) {
                            //console.log(data.data_grafico);
                            var myChart6 = Highcharts.chart('chartdiv6', {
                                chart: {
                                    type: 'bar',
                                    height: 800
                                },
                                title: {
                                    text: 'XX% de nuevos trabajadores'
                                },
                                subtitle: {
                                 //   text: 'Fuente: Gobierno de Chile'
                                },
                                lang : {
                                    downloadCSV : 'Descargar CSV',
                                    downloadJPEG: 'Descargar JPEG',
                                    downloadPDF : 'Descargar PDF',
                                    downloadPNG : 'Descargar PNG',
                                    downloadSVG : 'Descargar SVG',
                                    downloadXLS : 'Descargar Excel',
                                    printChart  : 'Imprimir Gráfico',
                                    viewData    : 'Ver Data'
                                },
                                exporting: {
                                    buttons: {
                                      contextButton: {
                                        menuItems: [
                                          'printChart',
                                          'separator',
                                          'downloadPNG',
                                          'downloadJPEG',
                                          'downloadPDF',
                                          'downloadSVG',
                                          'separator',
                                          'downloadCSV',
                                          'downloadXLS',
                                          'viewData'
                                        ]
                                      }
                                    }

                                },
                                xAxis: {
                                    categories: data.ejeX,
                                    title : {
                                        text: 'Sectores'
                                    }
                                },
                                yAxis: {
                                    min: 0,
                                    title: {
                                        text: 'XX% de nuevos trabajadores'
                                    }
                                },
                                tooltip: {
                                    formatter:function(){
                                       //console.log(this);
                                        return this.key+' = <b>' + this.y + ' %</b>';
                                    }
                                },
                                legend: {
                                    reversed: true
                                },
                                plotOptions: {
                                    series: {
                                        stacking: 'normal'
                                    }
                                },
                                //colors: ['#7fbeda', '#646cd4', '#9d64d4', '#d364c7', '#d46584', '#d48664'],
                                series: [data.data_grafico]
                            });
                        });
                });
                </script>
                <div id="chartdiv6" class="chartdiv"></div>
            </div>
            <hr>
            <div class="col-12 text-right">
            	<?php echo btn_state_grafico($id_graphics); ?>
        		<a href="<?php echo get_site_url(); ?>/wp-admin/admin.php?page=grafico_load" class="btn btn-chilevalora">&laquo; Volver</a>
        	</div>
        </div>
    </div>	
	<?php 
}

function graphics7($id_graphics){
	?>
	<div class="col-12">
        <div class="bloque-grafica">
        	<div class="col-12 text-right">
        		<?php echo btn_state_grafico($id_graphics); ?>
        		<a href="<?php echo get_site_url(); ?>/wp-admin/admin.php?page=grafico_load" class="btn btn-chilevalora">&laquo; Volver</a>
        	</div>
            <h2>XX% de migrantes</h2>
            <div class="grafica">
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        Highcharts.getJSON('<?php echo get_site_url(); ?>/wp-json/wp/v2/crecimiento_migrantes_setores_dashboard_old/', function (data) {

                            if(data){
                                //console.log(data.data_grafico);
                                var myChart6 = Highcharts.chart('chartdiv6old', {
                                    chart: {
                                        type: 'bar',
                                        height: 800
                                    },
                                    title: {
                                        text: '% de migrantes por sector'
                                    },
                                    subtitle: {
                                     //   text: 'Fuente: Gobierno de Chile'
                                    },
                                    lang : {
                                        downloadCSV : 'Descargar CSV',
                                        downloadJPEG: 'Descargar JPEG',
                                        downloadPDF : 'Descargar PDF',
                                        downloadPNG : 'Descargar PNG',
                                        downloadSVG : 'Descargar SVG',
                                        downloadXLS : 'Descargar Excel',
                                        printChart  : 'Imprimir Gráfico',
                                        viewData    : 'Ver Data'
                                    },
                                    exporting: {
                                        buttons: {
                                          contextButton: {
                                            menuItems: [
                                              'printChart',
                                              'separator',
                                              'downloadPNG',
                                              'downloadJPEG',
                                              'downloadPDF',
                                              'downloadSVG',
                                              'separator',
                                              'downloadCSV',
                                              'downloadXLS',
                                              'viewData'
                                            ]
                                          }
                                        }

                                    },
                                    xAxis: {
                                        categories: data.ejeX,
                                        title : {
                                            text: 'Sectores'
                                        }
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: '% de migrantes por sector'
                                        }
                                    },
                                    tooltip: {
                                        formatter:function(){
                                            //console.log(this);
                                            return this.key+' = <b>' + this.y + ' %</b>';
                                        }
                                    },
                                    legend: {
                                        reversed: true
                                    },
                                    plotOptions: {
                                        series: {
                                            stacking: 'normal'
                                        }
                                    },
                                    //colors: ['#7fbeda', '#646cd4', '#9d64d4', '#d364c7', '#d46584', '#d48664'],
                                    series: [data.data_grafico]
                                });
                            }else{
                                jQuery('#chartdiv6old').html('<br><br><div class="alert alert-danger" role="alert">No existe información asociada a este gráfico!</div>'),
                            }
                            
                        });
                });
                </script>
                <div id="chartdiv6old" class="chartdiv"></div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        Highcharts.getJSON('<?php echo get_site_url(); ?>/wp-json/wp/v2/crecimiento_migrantes_setores_dashboard/', function (data) {
                            //console.log(data.data_grafico);
                            if(data){
                                var myChart6 = Highcharts.chart('chartdiv6', {
                                    chart: {
                                        type: 'bar',
                                        height: 800
                                    },
                                    title: {
                                      // text: '% de migrantes por sector'
                                    },
                                    subtitle: {
                                        text: 'Fuente: Gobierno de Chile'
                                    },
                                    lang : {
                                        downloadCSV : 'Descargar CSV',
                                        downloadJPEG: 'Descargar JPEG',
                                        downloadPDF : 'Descargar PDF',
                                        downloadPNG : 'Descargar PNG',
                                        downloadSVG : 'Descargar SVG',
                                        downloadXLS : 'Descargar Excel',
                                        printChart  : 'Imprimir Gráfico',
                                        viewData    : 'Ver Data'
                                    },
                                    exporting: {
                                        buttons: {
                                          contextButton: {
                                            menuItems: [
                                              'printChart',
                                              'separator',
                                              'downloadPNG',
                                              'downloadJPEG',
                                              'downloadPDF',
                                              'downloadSVG',
                                              'separator',
                                              'downloadCSV',
                                              'downloadXLS',
                                              'viewData'
                                            ]
                                          }
                                        }

                                    },
                                    xAxis: {
                                        categories: data.ejeX,
                                        title : {
                                            text: 'Sectores'
                                        }
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: '% de migrantes por sector'
                                        }
                                    },
                                    tooltip: {
                                        formatter:function(){
                                           //console.log(this);
                                            return this.key+' = <b>' + this.y + ' %</b>';
                                        }
                                    },
                                    legend: {
                                        reversed: true
                                    },
                                    plotOptions: {
                                        series: {
                                            stacking: 'normal'
                                        }
                                    },
                                    //colors: ['#7fbeda', '#646cd4', '#9d64d4', '#d364c7', '#d46584', '#d48664'],
                                    series: [data.data_grafico]
                                });
                            }else{
                                jQuery('#chartdiv6').html('<br><br><div class="alert alert-danger" role="alert">No existe información asociada a este gráfico!</div>');
                            }
                        });
                });
                </script>
                <div id="chartdiv6" class="chartdiv"></div>
            </div>
            <hr>
            <div class="col-12 text-right">
            	<?php echo btn_state_grafico($id_graphics); ?>
        		<a href="<?php echo get_site_url(); ?>/wp-admin/admin.php?page=grafico_load" class="btn btn-chilevalora">&laquo; Volver</a>
        	</div>
        </div>
    </div>	
	<?php 
}

function graphics8($id_graphics){
	?>
	<div class="col-12">
        <div class="bloque-grafica">
        	<div class="col-12 text-right">
        		<?php echo btn_state_grafico($id_graphics); ?>
        		<a href="<?php echo get_site_url(); ?>/wp-admin/admin.php?page=grafico_load" class="btn btn-chilevalora">&laquo; Volver</a>
        	</div>
            <h2>Participación de mujeres en el tiempo</h2>
            <div class="grafica">
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        Highcharts.getJSON('<?php echo get_site_url(); ?>/wp-json/wp/v2/crecimiento_mujeres_setores_dashboard_old/', function (data) {
                            //console.log(data.data_grafico);
                            var myChart6 = Highcharts.chart('chartdiv6old', {
                                chart: {
                                    type: 'bar',
                                    height: 800
                                },
                                title: {
                                    text: 'Porcentaje de mujeres que trabajan en los sectores'
                                },
                                subtitle: {
                                    text: 'DestinoEmpleo en base a los datos del Seguro de Cesantía'
                                },
                                lang : {
                                    downloadCSV : 'Descargar CSV',
                                    downloadJPEG: 'Descargar JPEG',
                                    downloadPDF : 'Descargar PDF',
                                    downloadPNG : 'Descargar PNG',
                                    downloadSVG : 'Descargar SVG',
                                    downloadXLS : 'Descargar Excel',
                                    printChart  : 'Imprimir Gráfico',
                                    viewData    : 'Ver Data'
                                },
                                exporting: {
                                    buttons: {
                                      contextButton: {
                                        menuItems: [
                                          'printChart',
                                          'separator',
                                          'downloadPNG',
                                          'downloadJPEG',
                                          'downloadPDF',
                                          'downloadSVG',
                                          'separator',
                                          'downloadCSV',
                                          'downloadXLS',
                                          'viewData'
                                        ]
                                      }
                                    }

                                },
                                xAxis: {
                                    categories: data.ejeX,
                                    title : {
                                        text: 'Sectores'
                                    }
                                },
                                yAxis: {
                                    min: 0,
                                    title: {
                                        text: 'Porcentaje de mujeres'
                                    }
                                },
                                tooltip: {
                                    formatter:function(){
                                        //console.log(this);
                                        return this.key+' = <b>' + this.y + ' %</b>';
                                    }
                                },
                                legend: {
                                    reversed: true
                                },
                                plotOptions: {
                                    series: {
                                        stacking: 'normal'
                                    }
                                },
                                //colors: ['#7fbeda', '#646cd4', '#9d64d4', '#d364c7', '#d46584', '#d48664'],
                                series: [data.data_grafico]
                            });
                        });
                });
                </script>
                <hr>
                <div id="chartdiv6old" class="chartdiv"></div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        Highcharts.getJSON('<?php echo get_site_url(); ?>/wp-json/wp/v2/crecimiento_mujeres_setores_dashboard/', function (data) {
                            //console.log(data.data_grafico);
                            var myChart6 = Highcharts.chart('chartdiv6', {
                                chart: {
                                    type: 'bar',
                                    height: 800
                                },
                                title: {
                                    text: 'Porcentaje de mujeres que trabajan en los sectores'
                                },
                                subtitle: {
                                    text: 'DestinoEmpleo en base a los datos del Seguro de Cesantía'
                                },
                                lang : {
                                    downloadCSV : 'Descargar CSV',
                                    downloadJPEG: 'Descargar JPEG',
                                    downloadPDF : 'Descargar PDF',
                                    downloadPNG : 'Descargar PNG',
                                    downloadSVG : 'Descargar SVG',
                                    downloadXLS : 'Descargar Excel',
                                    printChart  : 'Imprimir Gráfico',
                                    viewData    : 'Ver Data'
                                },
                                exporting: {
                                    buttons: {
                                      contextButton: {
                                        menuItems: [
                                          'printChart',
                                          'separator',
                                          'downloadPNG',
                                          'downloadJPEG',
                                          'downloadPDF',
                                          'downloadSVG',
                                          'separator',
                                          'downloadCSV',
                                          'downloadXLS',
                                          'viewData'
                                        ]
                                      }
                                    }

                                },
                                xAxis: {
                                    categories: data.ejeX,
                                    title : {
                                        text: 'Sectores'
                                    }
                                },
                                yAxis: {
                                    min: 0,
                                    title: {
                                        text: 'Porcentaje de mujeres'
                                    }
                                },
                                tooltip: {
                                    formatter:function(){
                                       //console.log(this);
                                        return this.key+' = <b>' + this.y + ' %</b>';
                                    }
                                },
                                legend: {
                                    reversed: true
                                },
                                plotOptions: {
                                    series: {
                                        stacking: 'normal'
                                    }
                                },
                                //colors: ['#7fbeda', '#646cd4', '#9d64d4', '#d364c7', '#d46584', '#d48664'],
                                series: [data.data_grafico]
                            });
                        });
                });
                </script>
                <div id="chartdiv6" class="chartdiv"></div>
            </div>
            <hr>
            <div class="col-12 text-right">
            	<?php echo btn_state_grafico($id_graphics); ?>
        		<a href="<?php echo get_site_url(); ?>/wp-admin/admin.php?page=grafico_load" class="btn btn-chilevalora">&laquo; Volver</a>
        	</div>
        </div>
    </div>	
	<?php 
}

function graphics9($id_graphics){
	?>
	<div class="col-12">
        <div class="bloque-grafica">
        	<div class="col-12 text-right">
        		<?php echo btn_state_grafico($id_graphics); ?>
        		<a href="<?php echo get_site_url(); ?>/wp-admin/admin.php?page=grafico_load" class="btn btn-chilevalora">&laquo; Volver</a>
        	</div>
            <h2>Presencia de la ocupación en los diferentes sectores productivos</h2>
            <div class="grafica">
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        Highcharts.getJSON('<?php echo get_site_url(); ?>/wp-json/wp/v2/participacion_sector_dashboard/', function (data) {
                            //console.log(data.data_grafico);
                            var myChart6 = Highcharts.chart('chartdiv6old', {
                                chart: {
                                    type: 'bar',
                                    height: 800
                                },
                                title: {
                                    text: 'Distribución de la ocupación por sector productivo'
                                },
                                subtitle: {
                                    text: 'DestinoEmpleo en base a Casen 2017'
                                },
                                lang : {
                                    downloadCSV : 'Descargar CSV',
                                    downloadJPEG: 'Descargar JPEG',
                                    downloadPDF : 'Descargar PDF',
                                    downloadPNG : 'Descargar PNG',
                                    downloadSVG : 'Descargar SVG',
                                    downloadXLS : 'Descargar Excel',
                                    printChart  : 'Imprimir Gráfico',
                                    viewData    : 'Ver Data'
                                },
                                exporting: {
                                    buttons: {
                                      contextButton: {
                                        menuItems: [
                                          'printChart',
                                          'separator',
                                          'downloadPNG',
                                          'downloadJPEG',
                                          'downloadPDF',
                                          'downloadSVG',
                                          'separator',
                                          'downloadCSV',
                                          'downloadXLS',
                                          'viewData'
                                        ]
                                      }
                                    }

                                },
                                xAxis: {
                                    categories: data.ejeX,
                                    title : {
                                        text: 'Sectores'
                                    }
                                },
                                yAxis: {
                                    min: 0,
                                    title: {
                                        //text: 'Participación en distintos sectores'
                                    }
                                },
                                tooltip: {
                                    formatter:function(){
                                        //console.log(this);
                                        return this.key+' = <b>' + this.y + ' %</b>';
                                    }
                                },
                                legend: {
                                    reversed: true
                                },
                                plotOptions: {
                                    series: {
                                        stacking: 'normal'
                                    }
                                },
                                //colors: ['#7fbeda', '#646cd4', '#9d64d4', '#d364c7', '#d46584', '#d48664'],
                                series: [data.data_grafico],
                                nodePadding : 30,
                            });
                        });
                });
                </script>
                <div id="chartdiv6old" class="chartdiv"></div>

            </div>
            <div class="col-12 text-right">
            	<?php echo btn_state_grafico($id_graphics); ?>
        		<a href="<?php echo get_site_url(); ?>/wp-admin/admin.php?page=grafico_load" class="btn btn-chilevalora">&laquo; Volver</a>
        	</div>
        </div>
    </div>
	<?php 
}

function graphics10($id_graphics){
	?>
	<div class="col-12">
        <div class="bloque-grafica">
        	<div class="col-12 text-right">
        		<?php echo btn_state_grafico($id_graphics); ?>
        		<a href="<?php echo get_site_url(); ?>/wp-admin/admin.php?page=grafico_load" class="btn btn-chilevalora">&laquo; Volver</a>
        	</div>
            <h2>Evolución del número de trabajadores</h2>
            <div class="grafica">
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        Highcharts.getJSON('<?php echo get_site_url(); ?>/wp-json/wp/v2/crecimiento_ocupados_dashboard_old/', function (data) {
                            //console.log(data.data_grafico);
                            var myChart6 = Highcharts.chart('chartdiv6old', {
                                chart: {
                                    type: 'bar',
                                    height: 1150
                                },
                                title: {
                                    text: 'Ocupados'
                                },
                                subtitle: {
                                    text: 'DestinoEmpleo en base a Casen 2015 y 2017'
                                },
                                lang : {
                                    downloadCSV : 'Descargar CSV',
                                    downloadJPEG: 'Descargar JPEG',
                                    downloadPDF : 'Descargar PDF',
                                    downloadPNG : 'Descargar PNG',
                                    downloadSVG : 'Descargar SVG',
                                    downloadXLS : 'Descargar Excel',
                                    printChart  : 'Imprimir Gráfico',
                                    viewData    : 'Ver Data'
                                },
                                exporting: {
                                    buttons: {
                                      contextButton: {
                                        menuItems: [
                                          'printChart',
                                          'separator',
                                          'downloadPNG',
                                          'downloadJPEG',
                                          'downloadPDF',
                                          'downloadSVG',
                                          'separator',
                                          'downloadCSV',
                                          'downloadXLS',
                                          'viewData'
                                        ]
                                      }
                                    }

                                },
                                xAxis: {
                                    categories: data.ejeX,
                                    title : {
                                        text: 'Ocupados'
                                    }
                                },
                                yAxis: {
                                    min: 0,
                                    title: {
                                        text: 'Número de trabajadores en la ocupación'
                                    }
                                },
                                tooltip: {
                                    formatter:function(){
                                        //console.log(this);
                                        return this.key+' = <b>' + this.y + ' %</b>';
                                    }
                                },
                                legend: {
                                    reversed: true
                                },
                                plotOptions: {
                                    series: {
                                        stacking: 'normal'
                                    }
                                },
                                //colors: ['#7fbeda', '#646cd4', '#9d64d4', '#d364c7', '#d46584', '#d48664'],
                                series: [data.data_grafico]
                            });
                        });
                });
                </script>
                <div id="chartdiv6old" class="chartdiv"></div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        Highcharts.getJSON('<?php echo get_site_url(); ?>/wp-json/wp/v2/crecimiento_ocupados_dashboard/', function (data) {
                            //console.log(data.data_grafico);
                            var myChart6 = Highcharts.chart('chartdiv6', {
                                chart: {
                                    type: 'bar',
                                    height: 800
                                },
                                title: {
                                    text: 'Ocupados'
                                },
                                subtitle: {
                                    text: 'DestinoEmpleo en base a Casen 2015 y 2017'
                                },
                                lang : {
                                    downloadCSV : 'Descargar CSV',
                                    downloadJPEG: 'Descargar JPEG',
                                    downloadPDF : 'Descargar PDF',
                                    downloadPNG : 'Descargar PNG',
                                    downloadSVG : 'Descargar SVG',
                                    downloadXLS : 'Descargar Excel',
                                    printChart  : 'Imprimir Gráfico',
                                    viewData    : 'Ver Data'
                                },
                                exporting: {
                                    buttons: {
                                      contextButton: {
                                        menuItems: [
                                          'printChart',
                                          'separator',
                                          'downloadPNG',
                                          'downloadJPEG',
                                          'downloadPDF',
                                          'downloadSVG',
                                          'separator',
                                          'downloadCSV',
                                          'downloadXLS',
                                          'viewData'
                                        ]
                                      }
                                    }

                                },
                                xAxis: {
                                    categories: data.ejeX,
                                    title : {
                                        text: 'Ocupados'
                                    }
                                },
                                yAxis: {
                                    min: 0,
                                    title: {
                                        text: 'Número de trabajadores en la ocupación'
                                    }
                                },
                                tooltip: {
                                    formatter:function(){
                                       //console.log(this);
                                        return this.key+' = <b>' + this.y + ' %</b>';
                                    }
                                },
                                legend: {
                                    reversed: true
                                },
                                plotOptions: {
                                    series: {
                                        stacking: 'normal'
                                    }
                                },
                                //colors: ['#7fbeda', '#646cd4', '#9d64d4', '#d364c7', '#d46584', '#d48664'],
                                series: [data.data_grafico]
                            });
                        });
                });
                </script>
                <div id="chartdiv6" class="chartdiv"></div>
            </div>
            <div class="col-12 text-right">
            	<?php echo btn_state_grafico($id_graphics); ?>
        		<a href="<?php echo get_site_url(); ?>/wp-admin/admin.php?page=grafico_load" class="btn btn-chilevalora">&laquo; Volver</a>
        	</div>
        </div>
    </div>
	<?php 
}

?>