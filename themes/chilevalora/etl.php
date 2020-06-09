<?php



# Ruta Kettle
// $path = "/data-integration/pan.sh";
// echo $path ;
// echo "<br>";

// # Archivo Kettle
// $file = '"/var/www/html/wordpress/KTRFiles/ETL_PruebaServer.ktr"';
// echo $file ;
// echo "<br>";
// # Seteo la ruta del bat y el archivo ktr

// $exec = $path." -file=".$file." -level=Basic";

// echo $exec ;
// echo exec("/data-integration/pan.sh -file:'/var/www/html/wordpress/KTRFiles/ETL_PruebaServer.ktr'");
    // $salida = shell_exec("/data-integration/pan.sh -file:'/var/www/html/wordpress/KTRFiles/ETL_PruebaServer.ktr'");
    // echo "<pre>$salida</pre>";
    
    //$output = shell_exec("/data-integration/pan.sh -file='/var/www/html/wordpress/KTRFiles/ETL_PruebaServer.ktr'"); 
  
    // Display the list of all file 
    // and directory 
    //echo "<pre>$output</pre>"; 



echo '<pre>';

// Muestra el resultado completo del comando "ls", y devuelve la
// ultima linea de la salida en $ultima_linea. Almacena el valor de
// retorno del comando en $retval.
	# Ruta Kettle
	$path = "/data-integration/pan.sh";
	
	# Archivo Kettle
$file = "/var/www/html/wordpress/wp-admin/KTRFiles/ETL_PruebaServer.ktr";
$file2 = "/var/www/html/wordpress/wp-content/themes/chilevalora/KTRFiles/ETL_PruebaServer.ktr";
$path2="/var/www/html/wordpress/wp-content/themes/chilevalora/data-integration/pan.sh";
$exec = $path2." /file:".$file2." /level:Basic";
$ultima_linea = system($exec, $retval);

// Imprimir informacion adicional
echo '
</pre>
<hr />Ultima linea de la salida: ' . $ultima_linea . '
<hr />Valor de retorno: ' . $retval;
?>