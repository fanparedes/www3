jQuery(document).ready(function($) {

	/**  Combo Region  **/
	var id_region  = '5e077c7c83f96';
	var id_select_region = jQuery('#acf-field_'+id_region).val();

	jQuery('#acf-field_'+id_region).html('<option value="">Cargando...</option>');
	//var search_id = jQuery(this).val();
	get_data('dcms_ajax_get_region', 'acf-field_'+id_region, 'Seleccione', id_select_region);

	//cmbx derecho
	display_select('acf-field-'+id_region, 'acf-field_'+id_region, 'acf-label', 'acf[field_'+id_region+']', '<b>Región</b> <span class="acf-required">*</span>', true, 'Seleccione...');

	/** Combo Sector **/

	var id_sector  = '5e07907d86937';
	var id_select_sector = jQuery('#acf-field_'+id_sector).val();

	//console.log(id_select);

	jQuery('#acf-field_'+id_sector).html('<option value="">Cargando...</option>');
	//var search_id = jQuery(this).val();
	get_data('dcms_ajax_get_sector', 'acf-field_'+id_sector, 'Seleccione', id_select_sector);

	//cmbx derecho
	display_select('acf-field-'+id_sector, 'acf-field_'+id_sector, 'acf-label', 'acf[field_'+id_sector+']', '<b>Sector</b> <span class="acf-required">*</span>', true, 'Seleccione...');

	/** Combo Ocupacion **/

	var id_ocupacion  = '5e201f01e7793';
	var id_select_ocupacion = jQuery('#acf-field_'+id_ocupacion).val();

	//console.log(id_select);

	jQuery('#acf-field_'+id_ocupacion).html('<option value="">Cargando...</option>');
	//var search_id = jQuery(this).val();
	get_data('dcms_ajax_get_ocupacion', 'acf-field_'+id_ocupacion, 'Seleccione', id_select_ocupacion);

	//cmbx derecho
	display_select('acf-field-'+id_ocupacion, 'acf-field_'+id_ocupacion, 'acf-label', 'acf[field_'+id_ocupacion+']', '<b>Ocupación</b> <span class="acf-required">*</span>', true, 'Seleccione...');


});

function display_select(id_content, id_select, clase_label, name_select, text_label, requerido = false, text_option){
	jQuery("."+id_content).html('<label class='+clase_label+'>'+text_label+'</label>'+
								'<select  style="width:100%;" name='+name_select+' required='+requerido+' id='+id_select+'>'+
								'<option value="">'+text_option+'</option></select>');
}


function get_data(action, select_id, text_option, select = null){
	jQuery.ajax({
		url : ajax_var.url,
		type: 'post',
		dataType: "json",
		data: {
			action : action
		},
		error: function(){
		},
		success: function(data){
			if(data){
				//jQuery('#'+select_id).attr('disabled', false).select2();
				
				jQuery.each(data, function(index, value){
					if(select == value.id){
						jQuery('#'+select_id).append('<option value='+value.id+' selected="selected">'+value.name+'</option>');	
					}else{
						jQuery('#'+select_id).append('<option value='+value.id+'>'+value.name+'</option>');
					}
					
				})
				//jQuery('#'+select_id).select2();

				return true;
			}else{
				jQuery('#'+select_id).empty().append('<option value="">'+text_option+'</option>');
				/*if(select == 'derecho'){
					jQuery("#cctmcomuna_grd").empty().append('<option value="">Seleccione comuna</option>');
				}*/

				return false;
			}
			
		}
	});
}