<?php 
/*
Plugin Name: Mapa Telefonica
Plugin URI: http://ingeniaglobal.cl
Description: Este plugin permite cargar masivamente los datos del mapa de Telefonica
Author: Ingenia
Version: 1.0
Author URI: http://ingeniaglobal.cl
*/

function menuMapa(){
	add_menu_page( 'mapa_load', 'Mapa Telefónica', 'read', 'mapa_load', 'mapa_load', 'dashicons-admin-site');
}

//registrar plugin en admin

add_action( 'admin_menu', 'menuMapa');


function mapa_load(){
	if (count($_POST) == 0 && !isset($_GET['action'])) {
		echo mainMapa($msg);
	}elseif($_GET['action']=='addDigitales'){
		echo addDigitales();
	}elseif($_GET['action']=='addNoDigitales'){
		echo addNoDigitales();
	}elseif($_GET['action']=='addHabilidades'){
		echo addHabilidades();
	}else{
		echo mainMapa('¡La opción seleccionada no se encuentra disponible, por favor seleccione una disponible!', 'alert-danger');
	}
}


function mainMapa($msg = null, $estado = null){
	
?>
	<h3 class="text-center">Carga masiva mapa Telefónica</h3>
	<hr>
		<?php
			if($msg!=''){
			?>
				<div class="alert <?php echo $estado; ?>" role="alert">
				  <?php echo $msg; ?>
				</div>
			<?php
			} 
		?>
		<div class="row">
			<div class="col-md-4 col-sm-12">
				<form method="POST" enctype="multipart/form-data" action="<?php echo get_site_url().'/wp-admin/admin.php?page=mapa_load&action=addDigitales'; ?>">
					<div class="form-group">
					   <label for="digitales">Digitales</label>
					   <input type="file" class="form-control-file" id="digitales" name="digitales" required>
					</div>
					<button type="submit" class="btn btn-primary" id="btnDigitales" name="btnDigitales">Cargar Digitales</button>
				</form>
			</div>
			<div class="col-md-4 col-sm-12">
				<form method="POST" enctype="multipart/form-data" action="<?php echo get_site_url().'/wp-admin/admin.php?page=mapa_load&action=addNoDigitales'; ?>">
					<div class="form-group">
						<label for="nodigitales">No Digitales</label>
						<input type="file" class="form-control-file" id="nodigitales" name="nodigitales">
					</div>
					<button type="submit" class="btn btn-primary" id="btnNoDigitales" name="btnNoDigitales">Cargar No-Digitales</button>
				</form>
			</div>		
			<div class="col-md-4 col-sm-12">
				<form method="POST" enctype="multipart/form-data" action="<?php echo get_site_url().'/wp-admin/admin.php?page=mapa_load&action=addHabilidades'; ?>">
					<div class="form-group">
						<label for="habilidades">Habilidades</label>
						<input type="file" class="form-control-file" id="habilidades" name="habilidades">
					</div>
					<button type="submit" class="btn btn-primary" id="btnHabilidades" name="btnHabilidades">Cargar Habilidades</button>
				</form>
			</div>		
		</div>
	  
<?php
}

function addDigitales(){
	global $wpdb;

	$target_dir 	= get_template_directory();
	$target_site 	= get_template_directory_uri();
	$target_fix 	= date('dmYHis');
	$target_uri 	= '/data/'. $target_fix.'/'.basename($_FILES["digitales"]["name"]);
	$target_file 	= $target_dir . $target_uri;
	$target_mdkir	= $target_dir.'/data/'. $target_fix;

	mkdir($target_mdkir, 0755);
	//var_dump($target_file); die;
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// Check if image file is a actual image or fake image
	//var_dump($_POST);
	if(isset($_POST["btnDigitales"])) {
	   if (move_uploaded_file($_FILES["digitales"]["tmp_name"], $target_file)) {
            //$msg = "The file " . basename($_FILES["digitales"]["name"]) . " has been uploaded.";
            $uri_curl = $target_site.$target_uri;
            $fc = curl_init();
		    curl_setopt($fc, CURLOPT_URL,$uri_curl);
		    curl_setopt($fc, CURLOPT_RETURNTRANSFER,1);
		    curl_setopt($fc, CURLOPT_HEADER,0);
		    curl_setopt($fc, CURLOPT_VERBOSE,0);
		    curl_setopt($fc, CURLOPT_SSL_VERIFYPEER,FALSE);
		    curl_setopt($fc, CURLOPT_TIMEOUT,30);
		    $res = curl_exec($fc);
		    $result = json_decode($res, true);
		    curl_close($fc);

		    if(is_array($result)){

		    	$id 	= isset($result['id']) 		&& $result['id']!='' 		? $result['id'] : '';
		    	$title 	= isset($result['title']) 	&& $result['title']!='' 	? $result['title'] : '';

		    	if($id=='jobs' && $title!=''){
		    		foreach ($result['values'] as $value) {
			    		$id_region 		= isset($value['id']) 	&& $value['id']!='' 	? $value['id'] 	: '';
			    		
			    		foreach ($value as $key => $row) {
			    			$id_name 		= explode('|', $key);
			    			$id_telefonica	= isset($id_name[0]) 	&& $id_name[0]!='' 		? $id_name[0] 	: '';
			    			$name			= isset($id_name[1]) 	&& $id_name[1]!='' 		? $id_name[1] 	: '';
			    			$value 			= isset($row) 			&& $row!='' 			? $row 			: '';

			    			if($id_telefonica!='' && $id_region!='' && $id!='' && $title!='' && $name!='' && $value!=''){
			    				$sql_validate = "select * from cl_telefonica_digitales where id_telefonica = ".$id_telefonica." and id_region=".$id_region;
			    				$rs_validate  = $wpdb->get_results($sql_validate);

			    				if(is_array($rs_validate) && count($rs_validate)>0){
			    					$sql = "UPDATE cl_telefonica_digitales SET id = '".$id."', title = '".$title."', name = '".$name."', value = ".$value." WHERE id_telefonica = ".$id_telefonica." and id_region=".$id_region;

			    					$wpdb->get_results($sql);
			    				}else{
			    					$sql = "INSERT INTO cl_telefonica_digitales (id_telefonica, id_region, id, title, name, value) VALUES ($id_telefonica, $id_region, '".$id."', '".$title."', '".$name."', ".$value." );";
			    					$wpdb->get_results($sql);
			    				}
			    				
			    			}
			    		}
			    	}
			    	echo mainMapa('¡Se cargaron con éxito las Profesiones Digitales!', 'alert-success');
		    	}else{
		    		echo mainMapa('¡Por favor intente cargar nuevamente las Profesiones Digitales!', 'alert-danger');
		    	}

		    }else{
		    	echo mainMapa('¡Por favor intente cargar nuevamente las Profesiones Digitales!', 'alert-danger');
		    }
		    
        }
	}
}

function addNoDigitales(){
	global $wpdb;

	if(isset($_FILES["nodigitales"]["name"])){
		$target_dir 	= get_template_directory();
		$target_site 	= get_template_directory_uri();
		$target_fix 	= date('dmYHis');
		$target_uri 	= '/data/'. $target_fix.'/'.basename($_FILES["nodigitales"]["name"]);
		$target_file 	= $target_dir . $target_uri;
		$target_mdkir	= $target_dir.'/data/'. $target_fix;

		mkdir($target_mdkir, 0755);
		//var_dump($target_file); die;
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// Check if image file is a actual image or fake image
		//var_dump($_POST);
		if(isset($_POST["btnNoDigitales"])) {
		   if (move_uploaded_file($_FILES["nodigitales"]["tmp_name"], $target_file)) {
	            //$msg = "The file " . basename($_FILES["digitales"]["name"]) . " has been uploaded.";
	            $uri_curl = $target_site.$target_uri;
	            $fc = curl_init();
			    curl_setopt($fc, CURLOPT_URL,$uri_curl);
			    curl_setopt($fc, CURLOPT_RETURNTRANSFER,1);
			    curl_setopt($fc, CURLOPT_HEADER,0);
			    curl_setopt($fc, CURLOPT_VERBOSE,0);
			    curl_setopt($fc, CURLOPT_SSL_VERIFYPEER,FALSE);
			    curl_setopt($fc, CURLOPT_TIMEOUT,30);
			    $res = curl_exec($fc);
			    $result = json_decode($res, true);
			    curl_close($fc);

			    if(is_array($result)){

			    	$id 	= isset($result['id']) 		&& $result['id']!='' 		? $result['id'] : '';
			    	$title 	= isset($result['title']) 	&& $result['title']!='' 	? $result['title'] : '';
			    	if($id=='nodigital' && $title!=''){
			    		foreach ($result['values'] as $value) {
				    		$id_region 		= isset($value['id']) 	&& $value['id']!='' 	? $value['id'] 	: '';

				    		foreach ($value as $key => $row) {
				    			$id_name 		= explode('|', $key);
				    			$id_telefonica	= isset($id_name[0]) 	&& $id_name[0]!='' 		? $id_name[0] 	: '';
				    			$name			= isset($id_name[1]) 	&& $id_name[1]!='' 		? $id_name[1] 	: '';
				    			$value 			= isset($row) 			&& $row!='' 			? $row 			: '';

				    			if($id_telefonica!='' && $id_region!='' && $id!='' && $title!='' && $name!='' && $value!=''){
				    				$sql_validate = "select * from cl_telefonica_nodigitales where id_telefonica = ".$id_telefonica." and id_region=".$id_region;
					    			$rs_validate  = $wpdb->get_results($sql_validate);

					    			if(is_array($rs_validate) && count($rs_validate)>0){
				    					$sql = "UPDATE cl_telefonica_nodigitales SET id = '".$id."', title = '".$title."', name = '".$name."', value = ".$value." WHERE id_telefonica = ".$id_telefonica." and id_region=".$id_region;
				    					$wpdb->get_results($sql);
				    				}else{
				    					$sql = "INSERT INTO cl_telefonica_nodigitales (id_telefonica, id_region, id, title, name, value) VALUES ($id_telefonica, $id_region, '".$id."', '".$title."', '".$name."', ".$value." );";
					    				$wpdb->get_results($sql);
				    				}
				    			}

				    			
				    		}
				    	}
				    	echo mainMapa('¡Se cargaron con éxito las Profesiones No Digitales!', 'alert-success');
			    	}else{
			    		echo mainMapa('¡Por favor intente cargar nuevamente las Profesiones No Digitales!', 'alert-danger');
			    	}

			    }else{
			    	echo mainMapa('¡Por favor intente cargar nuevamente las Profesiones No Digitales!', 'alert-danger');
			    }
			    
	        }
		}
	}else{
		echo mainMapa('¡Por favor intente cargar nuevamente las Profesiones Digitales!', 'alert-danger');
	}
}

function addHabilidades(){
	global $wpdb;

	if(isset($_FILES["habilidades"]["name"])){
		$target_dir 	= get_template_directory();
		$target_site 	= get_template_directory_uri();
		$target_fix 	= date('dmYHis');
		$target_uri 	= '/data/'. $target_fix.'/'.basename($_FILES["habilidades"]["name"]);
		$target_file 	= $target_dir . $target_uri;
		$target_mdkir	= $target_dir.'/data/'. $target_fix;

		mkdir($target_mdkir, 0755);
		//var_dump($target_file); die;
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// Check if image file is a actual image or fake image
		//var_dump($_POST);
		if(isset($_POST["btnHabilidades"])) {
		   if (move_uploaded_file($_FILES["habilidades"]["tmp_name"], $target_file)) {
	            //$msg = "The file " . basename($_FILES["digitales"]["name"]) . " has been uploaded.";
	            $uri_curl = $target_site.$target_uri;
	            $fc = curl_init();
			    curl_setopt($fc, CURLOPT_URL,$uri_curl);
			    curl_setopt($fc, CURLOPT_RETURNTRANSFER,1);
			    curl_setopt($fc, CURLOPT_HEADER,0);
			    curl_setopt($fc, CURLOPT_VERBOSE,0);
			    curl_setopt($fc, CURLOPT_SSL_VERIFYPEER,FALSE);
			    curl_setopt($fc, CURLOPT_TIMEOUT,30);
			    $res = curl_exec($fc);
			    $result = json_decode($res, true);
			    curl_close($fc);

			    if(is_array($result)){

			    	$id 	= isset($result['id']) 		&& $result['id']!='' 		? $result['id'] : '';
			    	$title 	= isset($result['title']) 	&& $result['title']!='' 	? $result['title'] : '';
			    	if($id=='skills' && $title!=''){
			    		foreach ($result['values'] as $value) {
				    		$id_region 		= isset($value['id']) 	&& $value['id']!='' 	? $value['id'] 	: '';

				    		foreach ($value as $key => $row) {
				    			$id_name 		= explode('|', $key);
				    			$id_telefonica	= isset($id_name[0]) 	&& $id_name[0]!='' 		? $id_name[0] 	: '';
				    			$name			= isset($id_name[1]) 	&& $id_name[1]!='' 		? $id_name[1] 	: '';
				    			$value 			= isset($row) 			&& $row!='' 			? $row 			: '';

				    			if($id_telefonica!='' && $id_region!='' && $id!='' && $title!='' && $name!='' && $value!=''){
				    				$sql_validate = "select * from cl_telefonica_habilidades where id_telefonica = ".$id_telefonica." and id_region=".$id_region;
					    			$rs_validate  = $wpdb->get_results($sql_validate);

					    			if(is_array($rs_validate) && count($rs_validate)>0){
				    					$sql = "UPDATE cl_telefonica_habilidades SET id = '".$id."', title = '".$title."', name = '".$name."', value = ".$value." WHERE id_telefonica = ".$id_telefonica." and id_region=".$id_region;
				    					$wpdb->get_results($sql);
				    				}else{
				    					$sql = "INSERT INTO cl_telefonica_habilidades (id_telefonica, id_region, id, title, name, value) VALUES ($id_telefonica, $id_region, '".$id."', '".$title."', '".$name."', ".$value." );";
					    				$wpdb->get_results($sql);
				    				}
				    			}

				    			
				    		}
				    	}
				    	echo mainMapa('¡Se cargaron con éxito las Habilidades!', 'alert-success');
			    	}else{
			    		echo mainMapa('¡Por favor intente cargar nuevamente las Habilidades!', 'alert-danger');
			    	}

			    }else{
			    	echo mainMapa('¡Por favor intente cargar nuevamente las Habilidades!', 'alert-danger');
			    }
			    
	        }
		}
	}else{
		echo mainMapa('¡Por favor intente cargar nuevamente las Habilidades!', 'alert-danger');
	}

	
}



?>