function getDateBD(date) {
    var aux = date.split('-');
    return aux[2]+'-'+aux[1]+'-'+aux[0];
}

function getDateToFormBD(date) {
	var aux = date.split('-');
	return aux[2]+'/'+aux[1]+'/'+aux[0];
}

function getMonthDate(date) {
    var aux = date.split('-');
    months = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
    
    var month = months[aux[1]-1];
    var year = aux[0];
    date = month + " de " + year;
    return date;
}

function getExt(file) {
    return file.split('.').pop().toLowerCase();
}

CKEDITOR.config.customConfig = '../../bower_components/ckeditor/config.js';

$.fn.clearForm = function () {
	return this.each(function () {
		var type = this.type, tag = this.tagName.toLowerCase();
		if (tag === 'form')
			return $(':input', this).clearForm();
		if (type === 'text' || type === 'password' || tag === 'textarea' || tag === 'email')
			this.value = '';
		else if (type === 'checkbox' || type === 'radio')
			this.checked = false;
		else if (tag === 'select')
			this.selectedIndex = -1;
	});
};

$.fn.datepicker.defaults.language = 'es';
$.fn.datepicker.defaults.orientation = 'bottom left';

$.extend($.fn.dataTable.defaults, {
	dom: "<'row'<'col-md-4'B><'col-md-4 text-center'l><'col-md-4'f>>" + "<'row'<'col-md-12't>>" + "<'row'<'col-md-6'i><'col-md-6'p>>",
	buttons: ['excel'],
	paging: true,
	lengthChange: true,
	searching: true,
	ordering: true,
	info: true,
	autoWidth: false,
	language: {'url': 'bower_components/datatables.net/Spanish.json'},
	order: [[0, 'desc']],
	lengthMenu: [[20, 50, 100, -1], [20, 50, 100, 'Todo']],
	pageLength: 20
});

$.fn.dataTable.moment = function ( format, locale ) {
	var types = $.fn.dataTable.ext.type;

	// Add type detection
	types.detect.unshift( function ( d ) {
		return moment( d, format, locale, true ).isValid() ?
			'moment-'+format :
			null;
	} );

	// Add sorting method - use an integer for the sorting
	types.order[ 'moment-'+format+'-pre' ] = function ( d ) {
		return moment( d, format, locale, true ).unix();
	};
};

$.fn.dataTable.moment( 'DD/MM/YYYY' );

Noty.overrideDefaults({
	layout: 'topCenter',
	theme: 'metroui',
	timeout: 3000,
	killer: true,
	closeWith: ['click']
});