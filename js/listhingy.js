$(document).ready(function() {
    var table = $('#example').DataTable( {
        lengthChange: false,
        buttons: [
            {
                text: "View ", 
                className: 'btn btn-dark', 
                extend: 'colvis'}, 
            {
                text: 'Excel <i class="fas fa-file-excel"></i>',
                className: 'btn btn-outline-success btn-light', 
                extend: 'excelHtml5', exportOptions: { columns: ':visible'}
            }]
    } );
 
    table.buttons().container().appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );
