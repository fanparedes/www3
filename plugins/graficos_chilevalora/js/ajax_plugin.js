jQuery.noConflict();

function update_state_grafico(id_graphics, state_graphics){
	var uri_new = ajax_var.url.replace('wp-admin/admin-ajax.php', '/wp-json/wp/v2/update_state_grafico/'+id_graphics+'/'+state_graphics);

	if(state_graphics==1){
		var r = confirm("¿Desea confirmar la desactivación de la publicación del gráfico?");	
	}
	if(state_graphics==2){
		var r = confirm("¿Desea confirmar activación de la publicación del gráfico?");	
	}
	
	if (r == true) {

		jQuery.getJSON( uri_new, function( data ) {
			
			if(state_graphics==1){
				jQuery(".btn_publish").removeClass('btn-danger').addClass('btn-success').text('Publicar');
			}
			if(state_graphics==2){
				jQuery(".btn_publish").removeClass('btn-success').addClass('btn-danger').text('Desactivar');
			}
		});
	}
}