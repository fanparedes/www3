
<ul class="nav nav-tabs">
	<li class="nav-item">
		<?php 
		//Cambiar URL si no el parámetro code_job_position no existe
		$resumenUrl = get_site_url() . '/ocupacion-detalle/' . $id_occupation; ?>
		
		<a class="nav-link active" href="
		<?php echo isset( $code_job_position ) ? $resumenUrl . '?code_job_position=' . $code_job_position : $resumenUrl; ?>">Resumen</a>
	</li>
	<li class="nav-item">
		<?php 
		//Cambiar URL si no el parámetro code_job_position no existe
		$masInformacionUrl =  get_site_url() . '/ocupacion-mas-info/'. $id_occupation; ?>
		<a class="nav-link" href="
		<?php echo isset($code_job_position) ? $masInformacionUrl . '?code_job_position='.$code_job_position : $masInformacionUrl; ?>">Más información</a>
	</li>

	<?php if( isset($code_job_position) && $job_position->digital == 't' ): ?>
	<li class="nav-item">
		<a class="nav-link" href="<?php echo get_site_url().'/ocupacion-conocimiento/'.$id_occupation.'?code_job_position='.$code_job_position; ?>">Conocimiento</a>
	</li>
	<?php endif; ?>
</ul>