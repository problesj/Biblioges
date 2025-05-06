// Importar dependencias
import 'bootstrap';
import 'jquery';
import 'datatables.net';
import 'datatables.net-bs5';
import 'sweetalert2';
import 'select2';

// Configuración global de jQuery
window.$ = window.jQuery = require('jquery');

// Inicializar DataTables
$(document).ready(function() {
    $('.datatable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
        }
    });
});

// Inicializar Select2
$(document).ready(function() {
    $('.select2').select2();
});

// Configuración global de SweetAlert2
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true
}); 