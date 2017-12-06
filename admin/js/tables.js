$(document).ready(function() {
    $('#dataTable').DataTable( {
    	"order": [[ 0, "desc" ]],
        "oLanguage": {
            "sUrl": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Polish.json"
        }
    } );
} );