$(document).ready(function(){
	if ( $('.wpDataTables').length ) {
		$('.wpDataTables').each(function() {
			$(this).wrap('<div class="dataTable-wrapper"><div class="l-module--medium">');
			$(this).parents('.dataTable-wrapper').prev('.wpdt-c').prependTo($(this).parent());
		});
	}
});