<?php
	get_header(); 
?>

<div class="bloque-titular">
        <div class="container">
            <h1>Ocupaciones</h1>
            <div class="filtros-titular">
                <a href="#modal" class="openFiltroOcupacion">Elige una ocupación <i class="fal fa-filter"></i></a>
            </div>
        </div>
    </div>
    <!-- BLOQUE TABS -->
    <div class="bloque-tabs">
        <div class="container">
            <div class="d-none d-sm-block">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo get_site_url().'/ocupaciones-no-digitales/'; ?>">No Digitales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo get_site_url().'/ocupaciones/'; ?>">Digitales</a>
                    </li>
                </ul>
            </div>
            <div class="dropdown d-block d-sm-none">
                <a class="btn dropdown-toggle" href="#dropdown-toggle" role="button" id="dropdownMenuTabs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Digitales
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuTabs">
                    <a class="dropdown-item" href="#">No digitales</a>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN BLOQUE TABS -->
    <div class="container">
        <div class="row">
            <!-- BLOQUE PODIO -->
            <div class="bloque-podio">
                <div class="intro">
                    <div class="icono"><i class="iconcl-podium-xl"></i></div>
                    <h2>Ocupaciones más demandadas</h2>
                    <p>Ocupaciones mas demandadas en las bolsas de empleo</p>
                </div>
                <!-- CARRUSEL PODIO -->
                <div class="owl-carousel owl-theme">
                    <div class="item">
                        <div class="bloque-indicador">
                            <div class="grafica-circulo">
                                <span class="indicador-icon"><i class="iconcl-puesto1"></i></span>
                                <a href="ocupacion-digital-desarrollador-informaticos.html" class="icon-plus"><i class="fal fa-plus"></i></a>
                                <a href="ocupacion-digital-desarrollador-informaticos.html">
                                    <svg class="radial-progress" data-percentage="67" viewBox="0 0 80 80">
                                    <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                    <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                    <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">67%</text>
                                    </svg>
                                </a>
                            </div>
                            <div class="text">
                                <a href="ocupacion-digital-desarrollador-informaticos.html" class="title">Desarrolladores informáticos</a>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="bloque-indicador">
                            <div class="grafica-circulo">
                                <span class="indicador-icon"><i class="iconcl-puesto2"></i></span>
                                <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                                <a href="#">
                                    <svg class="radial-progress" data-percentage="53" viewBox="0 0 80 80">
                                    <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                    <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                    <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">53%</text>
                                    </svg>
                                </a>
                            </div>
                            <div class="text">
                                <a href="#" class="title">Desarrollador FrontEnd</a>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="bloque-indicador">
                            <div class="grafica-circulo">
                                <span class="indicador-icon"><i class="iconcl-puesto3"></i></span>
                                <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                                <a href="#">
                                    <svg class="radial-progress" data-percentage="20" viewBox="0 0 80 80">
                                    <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                    <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                    <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">20%</text>
                                    </svg>
                                </a>
                            </div>
                            <div class="text">
                                <a href="#" class="title">Experto en Marketing Digital</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FIN CARRUSEL PODIO -->
                <div class="row owl-desktop">
                    <div class="col-4 owl-desktop">
                        <div class="bloque-indicador">
                            <div class="grafica-circulo">
                                <span class="indicador-icon"><i class="iconcl-puesto1"></i></span>
                                <a href="ocupacion-digital-desarrollador-informaticos.html" class="icon-plus"><i class="fal fa-plus"></i></a>
                                <a href="ocupacion-digital-desarrollador-informaticos.html">
                                    <svg class="radial-progress" data-percentage="67" viewBox="0 0 80 80">
                                    <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                    <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                    <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">67%</text>
                                    </svg>
                                </a>
                            </div>
                            <div class="text">
                                <a href="ocupacion-digital-desarrollador-informaticos.html" class="title">Desarrolladores informáticos</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 owl-desktop">
                        <div class="bloque-indicador">
                            <div class="grafica-circulo">
                                <span class="indicador-icon"><i class="iconcl-puesto2"></i></span>
                                <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                                <a href="#">
                                    <svg class="radial-progress" data-percentage="53" viewBox="0 0 80 80">
                                    <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                    <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                    <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">53%</text>
                                    </svg>
                                </a>
                            </div>
                            <div class="text">
                                <a href="#" class="title">Desarrollador FrontEnd</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 owl-desktop">
                        <div class="bloque-indicador">
                            <div class="grafica-circulo">
                                <span class="indicador-icon"><i class="iconcl-puesto3"></i></span>
                                <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                                <a href="#">
                                    <svg class="radial-progress" data-percentage="20" viewBox="0 0 80 80">
                                    <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                    <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 220px;"></circle>
                                    <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">20%</text>
                                    </svg>
                                </a>
                            </div>
                            <div class="text">
                                <a href="#" class="title">Experto en Marketing Digital</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- FIN BLOQUE PODIO -->
            <!-- BLOQUE TITULAR -->
            <div class="col-12">
                <div class="bloque-titular">
                    <h2>Demanda por regiones</h2>
                </div>
            </div>
            <!-- FIN BLOQUE TITULAR -->
            <!-- BLOQUE MAPA -->
            <div class="col-12">
                <img src="<?php echo get_template_directory_uri(); ?>/images/mapa-e-info-general.jpg" class="img-fluid d-none d-sm-block mx-auto" id="abrirpopup1">
                <img src="<?php echo get_template_directory_uri(); ?>/images/mapa.jpg" class="img-fluid d-block d-sm-none mx-auto" id="abrirpopup2">
            </div>
            <!-- FIN BLOQUE MAPA -->
            <!-- BLOQUE CABECERA -->
            <div class="col-12">
                <div class="bloque-cabecera">
                    <div class="linea"><i class="iconcl-ingresos"></i></div>
                    <h2>Ingresos</h2>
                    <p>Ocupaciones con mayores ingresos mensuales en 2018</p>
                </div>
            </div>
            <!-- FIN BLOQUE CABECERA -->
            <!-- BLOQUE INDICADORES DISTRIBUTIVA -->
                <div class="bloque-indicadores-distributiva">
                    <div class="owl-carousel owl-theme">
                        <div class="col-12 col-md-6 item">
                            <div class="bloque-indicador-dato">
                                <div class="grafica-circulo">
                                    <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                                    <a href="#">
                                        <svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
                                        <circle class="complete" cx="40" cy="40" r="35"></circle>
                                        <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">$3M</text>
                                        </svg>
                                    </a>
                                </div>
                                <div class="text">
                                    <a href="#" class="title">Digital Product Manager</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 item">
                            <div class="bloque-indicador-dato">
                                <div class="grafica-circulo">
                                    <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                                    <a href="#">
                                        <svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
                                        <circle class="complete" cx="40" cy="40" r="35"></circle>
                                        <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">$2,2M</text>
                                        </svg>
                                    </a>
                                </div>
                                <div class="text">
                                    <a href="#" class="title">Especialista en Ciberseguridad</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 item">
                            <div class="bloque-indicador-dato">
                                <div class="grafica-circulo">
                                    <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                                    <a href="#">
                                        <svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
                                        <circle class="complete" cx="40" cy="40" r="35"></circle>
                                        <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">$1,8M</text>
                                        </svg>
                                    </a>
                                </div>
                                <div class="text">
                                    <a href="#" class="title">Administrador de Sistemas</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row owl-desktop justify-content-center">
                        <div class="col-2 col-sm-6 col-md-4">
                            <div class="bloque-indicador-dato">
                                <div class="grafica-circulo">
                                    <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                                    <a href="#">
                                        <svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
                                        <circle class="complete" cx="40" cy="40" r="35"></circle>
                                        <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">$3M</text>
                                        </svg>
                                    </a>
                                </div>
                                <div class="text">
                                    <a href="#" class="title">Digital Product Manager</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 col-sm-6 col-md-4">
                            <div class="bloque-indicador-dato">
                                <div class="grafica-circulo">
                                    <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                                    <a href="#">
                                        <svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
                                        <circle class="complete" cx="40" cy="40" r="35"></circle>
                                        <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">$2,2M</text>
                                        </svg>
                                    </a>
                                </div>
                                <div class="text">
                                    <a href="#" class="title">Especialista en Ciberseguridad</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 col-sm-6 col-md-4">
                            <div class="bloque-indicador-dato">
                                <div class="grafica-circulo">
                                    <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                                    <a href="#">
                                        <svg class="radial-full" data-percentage="100" viewBox="0 0 80 80">
                                        <circle class="complete" cx="40" cy="40" r="35"></circle>
                                        <text class="percentage" x="50%" y="58.7%" transform="matrix(0, 1, -1, 0, 80, 0)">$1,8M</text>
                                        </svg>
                                    </a>
                                </div>
                                <div class="text">
                                    <a href="#" class="title">Administrador de Sistemas</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- FIN BLOQUE INDICADORES DISTRIBUTIVA -->
            <!-- BLOQUE CABECERA -->
            <div class="col-12">
                <div class="bloque-cabecera">
                    <div class="linea"><i class="iconcl-contratos"></i></div>
                    <h2>Contratos Indefinidos</h2>
                    <p>Ocupaciones con mayor porcentaje de contratos indefinidos a nivel nacional</p>
                </div>
            </div>
            <!-- FIN BLOQUE CABECERA -->
            <!-- BLOQUE BARRA DISTRIBUTIBA -->
            <div class="col-12 col-lg-8 offset-lg-2">
                <div class="bloque-barra">
                <div class="bloque-progress">
                    <p>Administrador de Sistemas</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="94" aria-valuemin="0" aria-valuemax="100">94%</div>
                    </div>
                    <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                </div>
                <div class="bloque-progress">
                    <p>Especialista en Ciberseguridad</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="76" aria-valuemin="0" aria-valuemax="100">76%</div>
                    </div>
                    <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                </div>
                <div class="bloque-progress">
                    <p>Digital Prouct Manager</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100">72%</div>
                    </div>
                    <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                </div>
                <div class="bloque-progress">
                    <p>Administrador de Sistemas</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="64" aria-valuemin="0" aria-valuemax="100">64%</div>
                    </div>
                    <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                </div>
                <div class="bloque-progress">
                    <p>Diseñador Gráfico</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">45%</div>
                    </div>
                    <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                </div>
                <div class="bloque-progress">
                    <p>Espeicalista UX</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="38" aria-valuemin="0" aria-valuemax="100">38%</div>
                    </div>
                    <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                </div>
                <div class="bloque-progress">
                    <p>Content Manager</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100">31%</div>
                    </div>
                    <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                </div>
                <div class="bloque-progress">
                    <p>Programador PHP</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="26" aria-valuemin="0" aria-valuemax="100">26%</div>
                    </div>
                    <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                </div>
                <div class="bloque-progress">
                    <p>Especialista e-commerce</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100">22%</div>
                    </div>
                    <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                </div>
                <div class="bloque-progress">
                    <p>Desarrollador web</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="16" aria-valuemin="0" aria-valuemax="100">16%</div>
                    </div>
                    <a href="ocupacion-digital-desarrollador-web-resumen.html" class="icon-plus"><i class="fal fa-plus"></i></a>
                </div>    
            </div>
                </div>
            <!-- FIN BLOQUE BARRA DISTRIBUTIBA -->
            <!-- BLOQUE CABECERA -->
            <div class="col-12">
                <div class="bloque-cabecera">
                    <div class="linea"><i class="iconcl-mujeres"></i></div>
                    <h2>Mujeres</h2>
                    <p>Ocupaciones con mayor porcentaje de mujeres en todo el territorio nacional</p>
                </div>
            </div>
            <!-- FIN BLOQUE CABECERA -->
            <!-- BLOQUE BARRA DISTRIBUTIBA -->
            <div class="col-12 col-lg-8 offset-lg-2">
                <div class="bloque-barra">
                    <div class="bloque-progress">
                        <p>Diseñador gráfico</p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100">57%</div>
                        </div>
                        <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                    </div>
                    <div class="bloque-progress">
                        <p>Especialista UX</p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="48" aria-valuemin="0" aria-valuemax="100">48%</div>
                        </div>
                        <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                    </div>
                    <div class="bloque-progress">
                        <p>Especialista e-commerce</p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100">31%</div>
                        </div>
                        <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <!-- FIN BLOQUE BARRA DISTRIBUTIBA -->
            <!-- BLOQUE ICONO -->
            <div class="col-12">
                <div class="bloque-icono green">
                    <div class="row">
                        <div class="col-sm-12 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
                            <div class="icono">
                                <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                                <i class="iconcl-crecimiento-xl"></i>
                            </div>
                            <div class="text">
                                <a href="#" class="title">Experto en Marketing Digital</a>
                                <p>Ocupación con mayor tasa de crecimiento de ocupados en los dos últimos años</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- FIN BLOQUE ICONO -->
            <!-- BLOQUE PODIO -->
            <div class="bloque-podio">
                <div class="intro">
                    <div class="icono"><i class="iconcl-podium-xl"></i></div>
                    <h2>Ocupaciones más difíciles de cubrir</h2>
                    <p>Ocupaciones más difíciles de cubrir vacantes a nivel nacional en el último periodo</p>
                </div>
                <!-- CARRUSEL PODIO -->
                <div class="owl-carousel owl-theme off">
                    <div class="item">
                        <div class="bloque-indicador">
                            <div class="grafica-circulo">
                                <span class="indicador-icon"><i class="iconcl-puesto1"></i></span>
                                <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                                <a href="#" class="circle-icon">
                                <i class="iconcl-ocupacion-xl"></i>
                            </a>
                            </div>
                            <div class="text">
                                <a href="#" class="title">Ocupación 1</a>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="bloque-indicador">
                            <div class="grafica-circulo">
                                <span class="indicador-icon"><i class="iconcl-puesto2"></i></span>
                                <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                                <a href="#" class="circle-icon">
                                <i class="iconcl-ocupacion-xl"></i>
                            </a>
                            </div>
                            <div class="text">
                                <a href="#" class="title">Ocupación 2</a>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="bloque-indicador">
                            <div class="grafica-circulo">
                                <span class="indicador-icon"><i class="iconcl-puesto3"></i></span>
                                <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                                <a href="#" class="circle-icon">
                                <i class="iconcl-ocupacion-xl"></i>
                            </a>
                            </div>
                            <div class="text">
                                <a href="#" class="title">Ocupación 3</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FIN CARRUSEL PODIO -->
                <div class="row owl-desktop">
                    <div class="col-4 owl-desktop">
                        <div class="bloque-indicador">
                            <div class="grafica-circulo">
                                <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                                <a href="#" class="circle-icon">
                                <i class="iconcl-ocupacion-xl"></i>
                            </a>
                            </div>
                            <div class="text">
                                <a href="#" class="title">Ocupación 1</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 owl-desktop">
                        <div class="bloque-indicador">
                            <div class="grafica-circulo">
                                <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                                <a href="#" class="circle-icon">
                                <i class="iconcl-ocupacion-xl"></i>
                            </a>
                            </div>
                            <div class="text">
                                <a href="#" class="title">Ocupación 2</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 owl-desktop">
                        <div class="bloque-indicador">
                            <div class="grafica-circulo">
                                <a href="#" class="icon-plus"><i class="fal fa-plus"></i></a>
                                <a href="#" class="circle-icon">
                                <i class="iconcl-ocupacion-xl"></i>
                            </a>
                            </div>
                            <div class="text">
                                <a href="#" class="title">Ocupación 3</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- FIN BLOQUE PODIO -->
        </div>
    </div>
<?php
	get_footer();
?>