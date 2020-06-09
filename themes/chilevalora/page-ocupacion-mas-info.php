<?php
	global $id_occupation;
	$rs_search 	= array('/', 'ocupacion-mas-info');
	$rs_replace = array('', '');
	$id_occupation 	= str_replace($rs_search, $rs_replace, $_SERVER['REQUEST_URI']);
	$id_occupation	= explode('?', $id_occupation);
	$id_occupation	= is_numeric($id_occupation[0]) ? $id_occupation[0] : '1';

	//var_dump($id_occupation); die;
	$title_ocupacion 	= '';
	$content_ocupacion = '';
    $mas_informacion_titulo = '';
    $mas_informacion_descripcion = '';

    $code_job_position = $_GET['code_job_position'];
    

    $job_position = array_shift($wpdb->get_results("
                                        SELECT digital 
                                        FROM cl_job_positions 
                                        WHERE code_job_position = '" . $code_job_position . "' "));

	if(is_numeric($id_occupation)){
		$sql_ocupacion = "select id_occupation, name_occupation from cl_occupations where id_occupation = ".$id_occupation;
        $rs_ocupacion  = $wpdb->get_results($sql_ocupacion);

        //var_dump($rs_ocupacion); die;
        if(is_array($rs_ocupacion) && count($rs_ocupacion)>0){

        	$args_ocupacion        = array(
				'post_type'     => 'detalle_ocupacion',
				'post_status'   => 'publish',
				'showposts'     => 1,
				'order'         => 'ASC',
				'meta_query' => array(
		          'relation'    => 'WHERE',
		          array(
		            'key'   => 'id',
		            'value'     => $rs_ocupacion[0]->id_occupation,
		            'compare'   => '=
		            ',
		          )
		        )
			);
			
			$wp_ocupacion = new WP_Query( $args_ocupacion );

			if ( $wp_ocupacion->have_posts() ) :
	        	while ( $wp_ocupacion->have_posts() ) : $wp_ocupacion->the_post();
	        		$title_ocupacion 				= get_the_title();
	        		$content_ocupacion 				= get_the_content();
	        		$mas_informacion_titulo 		= get_field('mas_informacion_titulo');
	        		$mas_informacion_descripcion 	= get_field('mas_informacion_descripcion');

	        	endwhile;
	    		wp_reset_postdata();
	    	endif;

	    	get_header(); 

    	?>
    			<div class="bloque-titular">
			        <div class="container">
			            <h1><?php echo $rs_ocupacion[0]->name_occupation; ?></h1>
			        </div>
			    </div>
    			<!-- BLOQUE TABS -->
			    <div class="bloque-tabs">
			        <div class="container">
			            <div class="d-none d-sm-block">
			                <ul class="nav nav-tabs">
			                    <li class="nav-item">
			                        <a class="nav-link" href="<?php echo get_site_url().'/ocupacion-detalle/'.$id_occupation.'?code_job_position='.$code_job_position; ?>">Resumen</a>
			                    </li>
			                    <li class="nav-item">
			                        <a class="nav-link active" href="<?php echo get_site_url().'/ocupacion-mas-info/'.$id_occupation.'?code_job_position='.$code_job_position; ?>">Más información</a>
			                    </li>
                                
                                <?php if( $job_position->digital == 't' ): ?>
			                    <li class="nav-item">
			                        <a class="nav-link" href="<?php echo get_site_url().'/ocupacion-habilidades/'.$id_occupation.'?code_job_position='.$code_job_position; ?>">Habilidades</a>
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
            <!-- BLOQUE TEXTO -->
            <div class="col-12">
                <div class="bloque-texto row">
                    <div class="col-12 col-lg-2">
	                    <h2><?php echo $mas_informacion_titulo; ?></h2>
	                </div>
	                <div class="col-12 col-lg-10">
	                    <?php echo $mas_informacion_descripcion; ?>
	                </div>                </div>
            </div>
            <!-- FIN BLOQUE TEXTO -->
            <!-- BLOQUE GRAFICA -->
            <!-- <div class="col-12">
                <div class="bloque-grafica">
                    <h2>Gráfica columnas</h2>
                    <div class="grafica">
                        <script>
                           document.addEventListener('DOMContentLoaded', function () {
                            Highcharts.setOptions({
                                lang: {
                                    drillUpText: '<< Volver',
                                    downloadCSV: "Descargar CSV",
                                    downloadJPEG: "Descargar JPG",
                                    downloadPDF: "Descargar PDF",
                                    downloadPNG: "Descargar PNG",
                                    downloadSVG: "Descargar SVG",
                                    downloadXLS: "Descargar XLS",
                                    viewData: "Ver tabla de datos",
                                    openInCloud: "Ver en Highcharts Cloud",
                                    viewFullscreen: "Ver en pantalla completa",
                                    printChart: "Imprimir"
                                }
                            });
                            var myChart = Highcharts.chart('chartdiv1', {
                                chart: {
                                    type: 'column'
                                },
                                title: {
                                    text: 'Ocupaciones más solicitadas en 2019'
                                },
                                subtitle: {
                                    text: 'Haga click en las columnas para ver más detalles'
                                },
                                accessibility: {
                                    announceNewData: {
                                        enabled: true
                                    }
                                },
                                xAxis: {
                                    type: 'category'
                                },
                                yAxis: {
                                    title: {
                                        text: 'Porcentaje'
                                    }

                                },
                                legend: {
                                    enabled: false
                                },
                                plotOptions: {
                                    series: {
                                        borderWidth: 0,
                                        dataLabels: {
                                            enabled: true,
                                            format: '{point.y:.1f}%'
                                        }
                                    }
                                },

                                tooltip: {
                                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                                },

                                series: [
                                    {
                                        name: "Ocupaciones",
                                        colorByPoint: true,
                                        data: [
                                            {
                                                name: "Android Software Development",
                                                y: 62.74,
                                                drilldown: "Android Software Development",
                                                color: '#7fbeda',
                                            },
                                            {
                                                name: "Swift",
                                                y: 10.57,
                                                drilldown: "Swift",
                                                color: '#7fbeda',
                                            },
                                            {
                                                name: "Java",
                                                y: 7.23,
                                                drilldown: "Java",
                                                color: '#7fbeda',
                                            },
                                            {
                                                name: "Cloud computing",
                                                y: 5.58,
                                                drilldown: "Cloud computing",
                                                color: '#7fbeda',
                                            },
                                            {
                                                name: "Model View Controller (MVC)",
                                                y: 4.02,
                                                drilldown: "Model View Controller (MVC)",
                                                color: '#7fbeda',
                                            },
                                            {
                                                name: "Programador PHP",
                                                y: 1.92,
                                                drilldown: "Programador PHP",
                                                color: '#7fbeda',
                                            },
                                            {
                                                name: "Javascript",
                                                y: 7.62,
                                                drilldown: "Javascript",
                                                color: '#7fbeda',
                                            }
                                        ]
                                    }
                                ],
                                drilldown: {
                                    series: [
                                        {
                                            name: "Android Software Development",
                                            id: "Android Software Development",
                                            data: [
                                                [
                                                    "1er trimestre",
                                                    42.1
                                                ],
                                                [
                                                    "2do trimestre",
                                                    52.3
                                                ],
                                                [
                                                    "3er trimestre",
                                                    40.02
                                                ]
                                            ]
                                        },
                                        {
                                            name: "Swift",
                                            id: "Swift",
                                            data: [
                                                [
                                                    "1er trimestre",
                                                    30.02
                                                ],
                                                [
                                                    "2do trimestre",
                                                    27.36
                                                ],
                                                [
                                                    "3er trimestre",
                                                    21.35
                                                ]
                                            ]
                                        },
                                        {
                                            name: "Java",
                                            id: "Java",
                                            data: [
                                                [
                                                    "1er trimestre",
                                                    20.2
                                                ],
                                                [
                                                    "2do trimestre",
                                                    11.29
                                                ],
                                                [
                                                    "3er trimestre",
                                                    15.27
                                                ]
                                            ]
                                        },
                                        {
                                            name: "Cloud computing",
                                            id: "Cloud computing",
                                            data: [
                                                [
                                                    "1er trimestre",
                                                    5.39
                                                ],
                                                [
                                                    "2do trimestre",
                                                    15.96
                                                ],
                                                [
                                                    "3er trimestre",
                                                    20.36
                                                ]
                                            ]
                                        },
                                        {
                                            name: "Model View Controller (MVC)",
                                            id: "Model View Controller (MVC)",
                                            data: [
                                                [
                                                    "1er trimestre",
                                                    20.6
                                                ],
                                                [
                                                    "2do trimestre",
                                                    15.92
                                                ],
                                                [
                                                    "3er trimestre",
                                                    4.4
                                                ]
                                            ]
                                        },
                                        {
                                            name: "Programador PHP",
                                            id: "Programador PHP",
                                            data: [
                                                [
                                                    "1er trimestre",
                                                    13.96
                                                ],
                                                [
                                                    "2do trimestre",
                                                    25.82
                                                ],
                                                [
                                                    "3er trimestre",
                                                    3.14
                                                ]
                                            ]
                                        },
                                        {
                                            name: "Javascript",
                                            id: "Javascript",
                                            data: [
                                                [
                                                    "1er trimestre",
                                                    12.56
                                                ],
                                                [
                                                    "2do trimestre",
                                                    13.23
                                                ],
                                                [
                                                    "3er trimestre",
                                                    17.22
                                                ]
                                            ]
                                        }
                                        
                                    ]
                                }
                            });
                        });
                        </script>
                        <div id="chartdiv1" class="chartdiv1"></div>
                    </div>
                </div>
            </div> -->
            <!-- FIN BLOQUE GRAFICA -->
            <!-- BLOQUE GRAFICA -->
            <?php
                $graphics_10 = file_get_contents(get_site_url().'/wp-json/wp/v2/show_state_grafico/10');
                
                if($graphics_10=='2'){
            ?>
                    <div class="col-12">
                        <div class="bloque-grafica">
                            <h2>Evolución del número de trabajadores</h2>
                            <div class="grafica">
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        
                                        Highcharts.getJSON('<?php echo get_site_url(); ?>/wp-json/wp/v2/crecimiento_ocupados/<?php echo $id_occupation; ?>', function (data) {
                                            //console.log(data.length);
                                            var data_ocupacion = [];
                                            var data_ejeX = [];
                                            //data_ejeX.push(parseInt(0));
                                            for (var i = 0; i < data.length; i++) {
                                                //console.log(data[i]);
                                                data_ocupacion.push(parseInt(data[i].number_occupied));
                                                data_ejeX.push(parseInt(data[i].ano));
                                            }

                                            //console.log(data_ejeX);

                                            var myChart2 = Highcharts.chart('chartdiv2', {
                                                title: {
                                                    text: 'Ocupados en  '+data[0].name_occupation
                                                },
                                                subtitle: {
                                                    text: 'DestinoEmpleo en base a Casen 2015 y 2017'
                                                },
                                               
                                                xAxis: {
                                                    categories: data_ejeX,
                                                    title: {
                                                        text: 'Años'
                                                    }
                                                },
                                                yAxis: {
                                                    type: 'logarithmic',
                                                    minorTickInterval: 0.1,
                                                    accessibility: {
                                                        rangeDescription: 'Range: 0.1 to 10000'
                                                    },
                                                    title: {
                                                        text: 'Número de Ocupados'
                                                    },
                                                    labels: {
                                                        formatter: function() {
                                                         // if ( this.value > 100000 ) return Highcharts.numberFormat( this.value/1000, 1) + "l";  // maybe only switch if > 1000
                                                          return Highcharts.numberFormat(this.value,0);
                                                        }                
                                                    }
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
                                                tooltip: {
                                                    headerFormat: '<b>{series.name}</b><br />',
                                                    //pointFormat: 'x = {point.x}, y = {point.y}'
                                                },
                                                plotOptions: {
                                                    series: {
                                                        label: {
                                                            connectorAllowed: false
                                                        },
                                                        pointStart: 0
                                                    }
                                                },
                                                series: [{
                                                    data: data_ocupacion,
                                                    color: '#7fbeda',
                                                    //pointStart: data_ejeX[0],
                                                    name: 'Número de trabajadores en la ocupación'
                                                }]
                                            });
                                        });
                                    });
                                </script>
                                <div id="chartdiv2" class="chartdiv"></div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            ?>
            <!-- FIN BLOQUE GRAFICA -->
            <!-- BLOQUE GRAFICA -->
            <!-- <div class="col-12">
                <div class="bloque-grafica">
                    <h2>Gráfica circular</h2>
                    <div class="grafica">
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                var myChart3 = Highcharts.chart('chartdiv3', {
                                chart: {
                                    plotBackgroundColor: null,
                                    plotBorderWidth: null,
                                    plotShadow: false,
                                    type: 'pie'
                                },
                                title: {
                                    text: 'Porcentaje de ocupaciones'
                                },
                                tooltip: {
                                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                },
                                accessibility: {
                                    point: {
                                        valueSuffix: '%'
                                    }
                                },
                                plotOptions: {
                                    pie: {
                                        allowPointSelect: true,
                                        cursor: 'pointer',
                                        dataLabels: {
                                            enabled: false
                                        },
                                        showInLegend: true
                                    }
                                },
                                series: [{
                                    name: 'Ocupación',
                                    colorByPoint: true,
                                    data: [{
                                        name: 'Android Software Development',
                                        y: 61.41,
                                        sliced: true,
                                        selected: true,
                                        color: '#7fbeda',
                                    }, {
                                        name: 'Swift',
                                        y: 11.84,
                                        color: "#646cd4",
                                    }, {
                                        name: 'Java',
                                        y: 10.85,
                                        color: "#9d64d4",
                                    }, {
                                        name: 'Cloud computing',
                                        y: 4.67,
                                        color: "#d364c7",
                                    }, {
                                        name: 'Model View Controller',
                                        y: 4.18,
                                        color: "#d46584",
                                    }, {
                                        name: 'Javascript',
                                        y: 7.05,
                                        color: "#d48664",
                                    }]
                                }]
                            });
                        });
                        </script>
                        <div id="chartdiv3" class="chartdiv"></div>
                    </div>
                </div>
            </div> -->
            <!-- FIN BLOQUE GRAFICA -->
            <!-- BLOQUE GRAFICA -->
            <!-- <div class="col-12">
                <div class="bloque-grafica">
                    <h2>Gráfica lineas horizontales</h2>
                    <div class="grafica">
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                var myChart4 = Highcharts.chart('chartdiv4', {
                                title: {
                                    text: 'Salario por ocupación'
                                },

                                subtitle: {
                                    text: 'Fuente: Gobierno de Chile'
                                },

                                yAxis: {
                                    title: {
                                        text: 'Salario'
                                    }
                                },

                                xAxis: {
                                    accessibility: {
                                        rangeDescription: 'Rango: 2015 to 2019'
                                    }
                                },

                                legend: {
                                    layout: 'vertical',
                                    align: 'right',
                                    verticalAlign: 'middle'
                                },

                                plotOptions: {
                                    series: {
                                        label: {
                                            connectorAllowed: false
                                        },
                                        pointStart: 2010
                                    }
                                },

                                series: [{
                                    name: 'Desarrollador de aplicaciones móviles',
                                    data: [43934, 52503, 57177, 69658, 97031, 119931, 137133, 154175],
                                    color: '#65b1d4'
                                }, {
                                    name: 'Swift',
                                    data: [24916, 24064, 29742, 29851, 32490, 30282, 38121, 40434],
                                    color: '#646cd4'
                                }, {
                                    name: 'Java',
                                    data: [11744, 17722, 16005, 19771, 20185, 24377, 32147, 39387],
                                    color: '#9d65d5'
                                }, {
                                    name: 'Cloud computing',
                                    data: [null, null, 7988, 12169, 15112, 22452, 34400, 34227],
                                    color: '#d465c8'
                                }, {
                                    name: 'Javascript',
                                    data: [12908, 5948, 8105, 11248, 8989, 11816, 18274, 18111],
                                    color: '#d36483'
                                }],

                                responsive: {
                                    rules: [{
                                        condition: {
                                            maxWidth: 500
                                        },
                                        chartOptions: {
                                            legend: {
                                                layout: 'horizontal',
                                                align: 'center',
                                                verticalAlign: 'bottom'
                                            }
                                        }
                                    }]
                                }

                            });
                        });
                        </script>
                        <div id="chartdiv4" class="chartdiv"></div>
                    </div>
                </div>
            </div> -->
            <!-- FIN BLOQUE GRAFICA -->
            <!-- BLOQUE GRAFICA -->
            <?php
                $fuente     =  $wpdb->get_results("SELECT MAX(ano) FROM cl_busy_casen");
                $fuente_max = isset($fuente[0]->max) && $fuente[0]->max!='' ? $fuente[0]->max : '';

                $graphics_9 = file_get_contents(get_site_url().'/wp-json/wp/v2/show_state_grafico/9');
                if($graphics_9=='2'){
            ?>
                    <div class="col-12">
                        <div class="bloque-grafica">
                            <h2>Presencia de la ocupación en los diferentes sectores productivos</h2>
                            <div class="grafica">
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                            Highcharts.setOptions({
                                                colors: ['#283E56', '#B8366B', '#F1C561', '#F16E4A', '#47617E', '#EE93B8', '#F8D37E', '#F78769', '#6283A7', '#8A4D66', '#E3C889', '#C85F43']
                                            });

                                            Highcharts.getJSON('<?php echo get_site_url(); ?>/wp-json/wp/v2/participacion_sector/<?php echo $id_occupation; ?>', function (data) {

                                            var points = [],
                                                regionP,
                                                regionVal,
                                                regionI = 0,
                                                countryP,
                                                countryI,
                                                causeP,
                                                causeI,
                                                region,
                                                country,
                                                cause,
                                                causeName = {
                                                    //'Communicable & other Group I': 'No ocupados',
                                                    //'Noncommunicable diseases': 'Ocupación',
                                                    //Injuries: 'Baja laboral'
                                                    'value' : 'Participación de la ocupación'
                                                };

                                            for (region in data) {
                                                if (data.hasOwnProperty(region)) {
                                                    regionVal = 0;
                                                    regionP = {
                                                        id: 'id_' + regionI,
                                                        name: region,
                                                        color: Highcharts.getOptions().colors[regionI]
                                                    };
                                                    countryI = 0;
                                                    for (country in data[region]) {
                                                        if (data[region].hasOwnProperty(country)) {
                                                            countryP = {
                                                                id: regionP.id + '_' + countryI,
                                                                name: country,
                                                                parent: regionP.id
                                                            };
                                                            points.push(countryP);
                                                            causeI = 0;
                                                            for (cause in data[region][country]) {
                                                                if (data[region][country].hasOwnProperty(cause)) {
                                                                    causeP = {
                                                                        id: countryP.id + '_' + causeI,
                                                                        name: causeName[cause],
                                                                        parent: countryP.id,
                                                                        value: (+data[region][country][cause])
                                                                        //value: Math.round(+data[region][country][cause])
                                                                    };
                                                                    regionVal += causeP.value;
                                                                    points.push(causeP);
                                                                    causeI = causeI + 1;
                                                                }
                                                            }
                                                            countryI = countryI + 1;
                                                        }
                                                    }
                                                    //regionP.value = Math.round(regionVal / countryI);
                                                    regionP.value = (regionVal / countryI);
                                                    points.push(regionP);
                                                    regionI = regionI + 1;
                                                }
                                            }
                                            
                                            //console.log(points);
                                            Highcharts.chart('chartdiv5', {
                                                series: [{
                                                    type: 'treemap',
                                                    drillUpButton: {
                                                        text: '<< Volver'
                                                      },
                                                    layoutAlgorithm: 'squarified',
                                                    allowDrillToNode: true,
                                                    animationLimit: 1000,
                                                    dataLabels: {
                                                        enabled: false
                                                    },
                                                    levelIsConstant: false,
                                                    levels: [{
                                                        level: 1,
                                                        dataLabels: {
                                                            enabled: true
                                                        },
                                                        borderWidth: 3
                                                    }],
                                                    colors: ['#283E56', '#B8366B', '#F1C561', '#F16E4A'],

                                                    name: '% de participación',
                                                    //turboThreshold: 0,
                                                    data: points
                                                }],
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
                                                                if (!key) {
                                                                    return 'Sectores'
                                                                }
                                                                
                                                                return false
                                                            }
                                                        }

                                                },
                                                yAxis: {
                                                    title: {
                                                        text: 'Sectores'
                                                    }
                                                },
                                                xAxis: {
                                                    title: {
                                                        text: 'Sectores'
                                                    }
                                                },
                                                zAxis: {
                                                    title: {
                                                        text: 'Sectores'
                                                    }
                                                },
                                                title: {
                                                    text: 'Distribución de la ocupación por sector productivo'
                                                },
                                                subtitle: {
                                                    text: 'DestinoEmpleo en base a Casen 2017'
                                                },
                                                tooltip: {
                                                    valueDecimals: 2,
                                                    valuePrefix: '',
                                                    valueSuffix: ' %'
                                                },
                                            });
                                        });
                                    });
                                </script>
                                 <div id="chartdiv5" class="chartdiv"></div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            ?>
            <!-- FIN BLOQUE GRAFICA -->
            <!-- BLOQUE GRAFICA -->
            <!-- <div class="col-12">
                <div class="bloque-grafica">
                    <h2>Gráfica horizontal múltiples datos</h2>
                    <div class="grafica">
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                var myChart6 = Highcharts.chart('chartdiv6', {
                                chart: {
                                    type: 'bar'
                                },
                                title: {
                                    text: 'Ocupaciones'
                                },
                                xAxis: {
                                    categories: ['Hombres', 'Mujeres', 'Migrantes']
                                },
                                yAxis: {
                                    min: 0,
                                    title: {
                                        text: '% de ocupación'
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
                                colors: ['#7fbeda', '#646cd4', '#9d64d4', '#d364c7', '#d46584', '#d48664'],
                                series: [{
                                    name: 'Desarrollador de aplicaciones móviles',
                                    data: [5, 3, 4]
                                }, {
                                    name: 'Desarrollador FullStack',
                                    data: [2, 2, 3]
                                }, {
                                    name: 'Desarrollador de Big Data',
                                    data: [3, 4, 4]
                                }]
                            });
                        });
                        </script>
                        <div id="chartdiv6" class="chartdiv"></div>
                    </div>
                </div>
            </div> -->
            <!-- FIN BLOQUE GRAFICA -->
            <!-- BLOQUE GRAFICA -->
            <!-- <div class="col-12">
                <div class="bloque-grafica">
                    <h2>Gráfica Sankey</h2>
                    <div class="grafica">
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                    var myChart7 = Highcharts.chart('chartdiv7', {
                                            title: {
                                                text: 'Diagrama Sankey'
                                            },
                                            accessibility: {
                                                point: {
                                                    descriptionFormatter: function (point) {
                                                        var index = point.index + 1,
                                                            from = point.from,
                                                            to = point.to,
                                                            weight = point.weight;
                                                        return index + '. ' + from + ' a ' + to + ', ' + weight + '.';
                                                    }
                                                }
                                            },
                                            colors: ['#7fbeda', '#646cd4', '#9d64d4', '#d364c7', '#d46584', '#d48664'],
                                            series: [{
                                                keys: ['from', 'to', 'weight'],
                                                data: [
                                                    ['Desarrollador web', 'Desarrollador de aplicaciones móviles', 1],
                                                    ['Desarrollador web', 'Desarrollador FullStack', 2],
                                                    ['Desarrollador web', 'Desarrollador de Big Data', 1],
                                                    ['Desarrollador web', 'Desarrollador móvil', 1],
                                                    ['Desarrollador web', 'Desarrollador backend', 2],
                                                    ['Desarrollador web', 'Desarrollador Java', 5],
                                                ],
                                                type: 'sankey',
                                                name: 'Ocupaciones'
                                            }]

                                        });

                            });
                        </script>
                        <div id="chartdiv7" class="chartdiv"></div>
                    </div>
                </div>
            </div> -->
            <!-- FIN BLOQUE GRAFICA -->
            <!-- BOTON SOLO MÓVIL -->
            <div class="col-12">
                <a href="#" class="btn btn-arrow btn-block d-block d-sm-none">Ver habilidades</a>
            </div>
            <!-- FIN BOTON SOLO MÓVIL -->
        </div>
    </div>
    <!-- BLOQUE AMARILLO -->
	<?php include 'related-occupations.php'?>
   <!-- FIN BLOQUE AMARILLO -->				
			<?php
			get_footer();

        }else{
        	header("HTTP/1.1 301 Moved Permanently");
			header("Location: ".home_url( '/404/' ));
			exit();
        }
	}else{
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: ".home_url( '/404/' ));
		exit();
	}
?>