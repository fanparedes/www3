<?php
	global $id_sector;
	$rs_search 	= array('/', 'sector-mas-info', 'sectores-productivos');
	$rs_replace = array('', '', '');
	$id_sector 	= str_replace($rs_search, $rs_replace, $_SERVER['REQUEST_URI']);
	$id_sector	= explode('?', $id_sector);
	//var_dump($id_sector); die;
	$id_sector	= is_numeric($id_sector[0]) ? $id_sector[0] : '1';

    $code_sector    = isset($_GET['code_sector']) && $_GET['code_sector']!='' ? $_GET['code_sector'] : '';

	//var_dump($id_sector); die;
	$title_sector 	= '';
	$content_sector = '';
    $mas_informacion_titulo = '';
    $mas_informacion_descripcion = '';



	if(is_numeric($id_sector)){
		$sql_sector = "select id_sector, name_sector from cl_sectors where id_sector = ".$id_sector;
        $rs_sector  = $wpdb->get_results($sql_sector);

        //var_dump($rs_sector); die;
        if(is_array($rs_sector) && count($rs_sector)>0){

        	$args_sector        = array(
				'post_type'     => 'detalle_sector',
				'post_status'   => 'publish',
				'showposts'     => 1,
				'order'         => 'ASC',
				'meta_query' => array(
		          'relation'    => 'WHERE',
		          array(
		            'key'   => 'id',
		            'value'     => $rs_sector[0]->id_sector,
		            'compare'   => '=
		            ',
		          )
		        )
			);
			
			$wp_sector = new WP_Query( $args_sector );

			if ( $wp_sector->have_posts() ) :
	        	while ( $wp_sector->have_posts() ) : $wp_sector->the_post();
	        		$title_sector 				= get_the_title();
	        		$content_sector 				= get_the_content();
	        		$mas_informacion_titulo 		= get_field('mas_informacion_titulo');
	        		$mas_informacion_descripcion 	= get_field('mas_informacion_descripcion');

	        	endwhile;
	    		wp_reset_postdata();
	    	endif;

	    	get_header(); 

    	?>
    			<div class="bloque-titular">
			        <div class="container">
			            <h1 class="col-9"><?php echo $rs_sector[0]->name_sector; ?></h1>
                        <div class="filtros-titular col-3">
                            <a href="#" class="openFiltroRegion">Elige una región <i class="fal fa-filter"></i></a>
                        </div>
			        </div>
			    </div>
    			<!-- BLOQUE TABS -->
			    <div class="bloque-tabs">
			        <div class="container">
			            <div class="d-none d-sm-block">
			                <ul class="nav nav-tabs">
			                    <li class="nav-item">
			                        <a class="nav-link" href="<?php echo get_site_url().'/sector-detalle/'.$id_sector.'?code_sector='.$code_sector; ?>">Resumen</a>
			                    </li>
			                    <li class="nav-item">
			                        <a class="nav-link active" href="<?php echo get_site_url().'/sector-mas-info/'.$id_sector.'?code_sector='.$code_sector; ?>">Más información</a>
			                    </li>
			                    <!--<li class="nav-item">
			                        <a class="nav-link" href="#">Ocupaciones</a>
			                    </li>-->
			                </ul>
			            </div>
			            <div class="dropdown d-block d-sm-none">
			                <a class="btn dropdown-toggle" href="#dropdown-toggle" role="button" id="dropdownMenuTabs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			                    Resumen
			                </a>
			                <div class="dropdown-menu" aria-labelledby="dropdownMenuTabs">
			                    <a class="dropdown-item" href="#">Más información</a>
			                    <a class="dropdown-item" href="#">Sectores</a>                    
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
                                    text: 'Sectores más solicitadas en 2019'
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
                                        name: "Sectores",
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
                $graphics_1 = file_get_contents(get_site_url().'/wp-json/wp/v2/show_state_grafico/1');
                
                //if($graphics_1=='2'){
            ?>
                    <div class="col-12">
                        <div class="bloque-grafica">
                            <h2 id="numero_ocupados" >Número de ocupados</h2>
                            <div class="grafica">
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        Highcharts.getJSON('<?php echo get_site_url(); ?>/wp-json/wp/v2/crecimiento_sectores/<?php echo $id_sector; ?>', function (data) {
                                            //console.log(data);
                                            var data_sector = [];
                                            var data_ejeX = [];
                                            data_ejeX.push(parseInt(0));
                                            for (var i = 0; i < data.length; i++) {
                                                //console.log(data[i]);
                                                data_sector.push(parseInt(data[i].number_workers));

                                                data_ejeX.push(parseInt(data[i].ano));
                                            }
                                            //console.log(data_ejeX);
                                            var myChart2 = Highcharts.chart('chartdiv22', {
                                                
                                                title: {
                                                    text: data[0].name_sector
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
                                                    categories: data_ejeX,
                                                    title: {
                                                        text: 'Años'
                                                    }
                                                },
                                                yAxis: {
                                                    type: 'logarithmic',
                                                    minorTickInterval: 0.1,
                                                    accessibility: {
                                                        rangeDescription: 'Range: 0.1 to 1000'
                                                    },
                                                    title: {
                                                        text: 'N° Ocupados'
                                                    }
                                                },
                                                tooltip:{
                                                    formatter:function(){
                                                        //console.log(this);
                                                        return 'X = ' + this.key + ', Y =' + this.y;
                                                    }
                                                },

                                                series: [{
                                                    data: data_sector,
                                                    color: '#7fbeda',
                                                    pointStart: 1,
                                                    name: 'Números de Ocupados'
                                                }]
                                            });
                                        });
                                    });
                                </script>
                                <div id="chartdiv22" class="chartdiv"></div>
                            </div>
                        </div>
                    </div>
            <?php
                //} 
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
                                    text: 'Porcentaje de sectores'
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
            <?php
                $graphics_2 = file_get_contents(get_site_url().'/wp-json/wp/v2/show_state_grafico/2');
                //if($graphics_2=='2'){
            ?>
                    <div class="col-12">
                        <div class="bloque-grafica">
                            <h2 id="contratos_indefinidos">XX% de contratos indefinidos</h2>
                            <div class="grafica">
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        Highcharts.getJSON('<?php echo get_site_url(); ?>/wp-json/wp/v2/contratos_indefinidos_subsectores/<?php echo $id_sector; ?>', function (data) {
                                            //console.log(data);
                                            var myChart4 = Highcharts.chart('chartdiv44', {
                                                
                                                title: {
                                                    text: 'XX% de contratos indefinidos'
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
                                                subtitle: {
                                                    text: 'Fuente: Gobierno de Chile'
                                                },

                                                yAxis: {
                                                    title: {
                                                        text: 'XX% de Contratos indefinidos'
                                                    }
                                                },

                                                xAxis: {
                                                     categories: data.ejeX,
                                                    title: {
                                                        text: 'Años'
                                                    }
                                                },

                                                legend: {
                                                    layout: 'vertical',
                                                    align: 'right',
                                                    verticalAlign: 'middle'
                                                },

                                                // plotOptions: {
                                                //     series: {
                                                //         label: {
                                                //             connectorAllowed: false
                                                //         },
                                                //         pointStart: data.ejeX[0]
                                                //     }
                                                // },

                                                series: data.data_grafico,
                                                

                                                responsive: {
                                                    rules: [{
                                                        condition: {
                                                            maxWidth: 50000
                                                        },
                                                        chartOptions: {
                                                            legend: {
                                                                layout: 'horizontal',
                                                                align: 'left',
                                                                verticalAlign: 'bottom'
                                                            }
                                                        }
                                                    }]
                                                }

                                            });
                                        });
                                });
                                </script>
                                <div id="chartdiv44" class="chartdiv"></div>
                            </div>
                        </div>
                    </div>
            <?php
                //}
            ?>
            <!-- FIN BLOQUE GRAFICA -->
            <!-- BLOQUE GRAFICA -->
            <?php
                $graphics_3 = file_get_contents(get_site_url().'/wp-json/wp/v2/show_state_grafico/3');
                //if($graphics_3=='2'){
            ?>
                    <div class="col-12">
                        <div class="bloque-grafica">
                            <h2 id="p_contratos_indefinidos">% de contratos indefinidos</h2>
                            <div class="grafica">
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        Highcharts.getJSON('<?php echo get_site_url(); ?>/wp-json/wp/v2/contratos_indefinidos_sectores/<?php echo $id_sector; ?>', function (data) {
                                            //console.log(data.data_grafico);
                                            
                                            var myChart4 = Highcharts.chart('chartdiv4', {
                                                
                                                title: {
                                                    text: '% de contratos indefinidos'
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
                                                    title: {
                                                        text: 'Años'
                                                    }
                                                },

                                                yAxis: {
                                                     title: {
                                                        text: '% Contratos indefinidos'
                                                    }
                                                },
                                                legend: {
                                                    layout: 'vertical',
                                                    align: 'right',
                                                    verticalAlign: 'middle'
                                                },
                                                tooltip: {
                                                    formatter:function(){
                                                        //console.log(this);
                                                        return 'X = ' + this.key + ', Y = ' + this.y + ' %';
                                                    }
                                                },
                                                plotOptions: {
                                                    series: {
                                                        label: {
                                                            connectorAllowed: false
                                                        },
                                                        pointStart: data.ejeX[0]
                                                    }
                                                },

                                                series: [{
                                                    data: data.data_grafico.data,
                                                    pointStart: 1,
                                                    //name: data.data_grafico.name
                                                    name : '% de contratos indefinidos'
                                                }],
                                                responsive: {
                                                    rules: [{
                                                        condition: {
                                                            maxWidth: 5000000
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
                                });
                                </script>
                                <div id="chartdiv4" class="chartdiv"></div>
                            </div>
                        </div>
                    </div>
            <?php
                //}
            ?>
            <!-- FIN BLOQUE GRAFICA -->
            <!-- BLOQUE GRAFICA -->
            <!-- <div class="col-12">
                <div class="bloque-grafica">
                    <h2>Participación en distintos sectores</h2>
                    <div class="grafica">
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                    Highcharts.getJSON('<?php echo get_site_url(); ?>/wp-json/wp/v2/participacion_sector', function (data) {

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
                                            'Noncommunicable diseases': 'Ocupación',
                                            //Injuries: 'Baja laboral'
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
                                                                value: Math.round(+data[region][country][cause])
                                                            };
                                                            regionVal += causeP.value;
                                                            points.push(causeP);
                                                            causeI = causeI + 1;
                                                        }
                                                    }
                                                    countryI = countryI + 1;
                                                }
                                            }
                                            regionP.value = Math.round(regionVal / countryI);
                                            points.push(regionP);
                                            regionI = regionI + 1;
                                        }
                                    }
                                    var myChart4 = Highcharts.chart('chartdiv5', {
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
                                            turboThreshold: 0,
                                            data: points
                                        }],
                                        subtitle: {
                                            text: 'Haga click para más información (Datos de ejemplo de Highcharts).'
                                        },
                                        title: {
                                            text: 'Población activa por ocupación'
                                        }
                                    });
                                });
                            });
                        </script>
                        <div id="chartdiv5" class="chartdiv"></div>
                    </div>
                </div>
            </div> -->
            <!-- BLOQUE GRAFICA -->
            <?php
                $graphics_5 = file_get_contents(get_site_url().'/wp-json/wp/v2/show_state_grafico/5');
               // if($graphics_5=='2'){
            ?>
                    <div class="col-12">
                        <div class="bloque-grafica">
                            <h2 id="rotacion">XX% de rotación</h2>
                            <div class="grafica">
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        Highcharts.getJSON('<?php echo get_site_url(); ?>/wp-json/wp/v2/crecimiento_rotacion_setores/<?php echo $id_sector; ?>', function (data) {
                                            var myChart7 = Highcharts.chart('chartdiv7', {
                                                    title: {
                                                        text: 'XX% de rotación'
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
                                                        data: data,
                                                        type: 'sankey',
                                                        name: 'XX% de rotación de los sectores',
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
                        </div>
                    </div>
            <?php
                //}
            ?>
            <!-- FIN BLOQUE GRAFICA -->
            <!-- BLOQUE GRAFICA -->
            <?php
                $graphics_6 = file_get_contents(get_site_url().'/wp-json/wp/v2/show_state_grafico/6');
               // if($graphics_6=='2'){
            ?>
                    <div class="col-12">
                        <div class="bloque-grafica">
                            <h2 id="nuevos_trabajadores">XX% de nuevos trabajadores</h2>
                            <div class="grafica">
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        Highcharts.getJSON('<?php echo get_site_url(); ?>/wp-json/wp/v2/crecimiento_nuevos_trabajadores', function (data) {
                                            //console.log(data.data_grafico);
                                            var myChart6 = Highcharts.chart('chartdiv96', {
                                                chart: {
                                                    type: 'bar',
                                                    height: 500
                                                },
                                                title: {
                                                    text: 'XX% de nuevos trabajadores'
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
                                                    title: {
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
                                                        return this.key+' = <b>' + this.y + '</b> %';
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
                                <div id="chartdiv96" class="chartdiv"></div>
                            </div>
                        </div>
                    </div>
            <?php
                //}
            ?>
            <!-- FIN BLOQUE GRAFICA -->
            <!-- BLOQUE GRAFICA -->
            <?php
                $graphics_8 = file_get_contents(get_site_url().'/wp-json/wp/v2/show_state_grafico/8');
                //if($graphics_8=='2'){
            ?>
                    <div class="col-12">
                        <div class="bloque-grafica">
                            <h2 id="mujeres">% de mujeres por subsector</h2>
                            <div class="grafica">
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        Highcharts.getJSON('<?php echo get_site_url(); ?>/wp-json/wp/v2/crecimiento_mujeres_setores/<?php echo $id_sector; ?>', function (data) {
                                            //console.log(data.data_grafico);
                                            var myChart6 = Highcharts.chart('chartdiv6', {
                                                chart: {
                                                    type: 'bar',
                                                    height: 500
                                                },
                                                title: {
                                                    text: '% de mujeres por subsector'
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
                                                        text: 'Subsector'
                                                    }
                                                },
                                                yAxis: {
                                                    min: 0,
                                                    title: {
                                                        text: '% de mujeres por subsector'
                                                    }
                                                },
                                                tooltip: {
                                                    formatter:function(){
                                                        //console.log(this);
                                                        return this.key+' = <b>' + this.y + '</b> %';
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
                        </div>
                    </div>
            <?php
                //}
            ?>
            <!-- FIN BLOQUE GRAFICA -->
            <!-- BLOQUE GRAFICA -->
            <?php
                $graphics_7 = file_get_contents(get_site_url().'/wp-json/wp/v2/show_state_grafico/7');
               // if($graphics_7=='2'){
            ?>
                    <div class="col-12">
                        <div class="bloque-grafica">
                            <h2 id="migrantes">XX% de migrantes</h2>
                            <div class="grafica">
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        Highcharts.getJSON('<?php echo get_site_url(); ?>/wp-json/wp/v2/crecimiento_migrantes_setores/<?php echo $id_sector; ?>', function (data) {
                                            var myChart6 = Highcharts.chart('chartdiv66', {
                                                chart: {
                                                    type: 'bar',
                                                    height: 500
                                                },
                                                title: {
                                                    text: '% de migrantes por subsector'
                                                },
                                                subtitle: {
                                                    text: 'Fuente: Gobierno de Chile'
                                                },
                                                xAxis: {
                                                    categories: data.ejeX,
                                                    title : {
                                                        text: 'Subsector'
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
                                                yAxis: {
                                                    min: 0,
                                                    title: {
                                                        text: '% de migrantes por subsector'
                                                    }
                                                },
                                                tooltip: {
                                                    formatter:function(){
                                                        //console.log(this);
                                                        return this.key+' = <b>' + this.y + '</b> %';
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
                                                series: [data.data_grafico]
                                            });
                                        });
                                });
                                </script>
                                <div id="chartdiv66" class="chartdiv"></div>
                            </div>
                        </div>
                    </div>
            <?php
               // }
            ?>
            <!-- FIN BLOQUE GRAFICA -->
            
            <!-- BOTON SOLO MÓVIL -->
            <div class="col-12">
                <a href="#" class="btn btn-arrow btn-block d-block d-sm-none">Ver habilidades</a>
            </div>
            <!-- FIN BOTON SOLO MÓVIL -->
        </div>
    </div>			
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

<script type="text/javascript">
    function format(input){
        var num = input.value.replace(/\./g,'');
        if(!isNaN(num)){
            num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            num = num.split('').reverse().join('').replace(/^[\.]/,'');
            //input.value = num;
            return num;
        }else{ 
            alert('Solo se permiten numeros');
            input.value = input.value.replace(/[^\d\.]*/g,'');
        }
    }
</script>