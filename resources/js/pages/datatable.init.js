import $ from 'jquery'
window.jQuery = window.$ = $

import 'datatables.net/js/jquery.dataTables';
import 'datatables.net-bs5/js/dataTables.bootstrap5';
import 'datatables.net-buttons/js/dataTables.buttons';
import 'datatables.net-buttons/js/buttons.html5';
import 'datatables.net-buttons/js/buttons.print';
import 'datatables.net-buttons/js/buttons.colVis';
import 'datatables.net-buttons-bs5/js/buttons.bootstrap5';

$(document).ready(function () {

    $.extend(true, $.fn.dataTable.Buttons.defaults, {
        dom: {
            button: {
                className: 'btn btn-primary'
            }
        }
    });

    // Default Datatable
    $('#datatable').DataTable();

    //Buttons examples
    function initializeDataTableWithButtons(selector, orderColumnIndex = 0, orderDirection = 'asc') {
        $(selector).DataTable({
            lengthChange: false,
            order: [[orderColumnIndex, orderDirection]], // Default ordering
            buttons: [
                {
                    extend: 'copy',
                    text: 'Copy'
                },
                {
                    extend: 'csv',
                    text: 'CSV'
                },
                {
                    extend: 'print',
                    text: 'Print'
                },
                {
                    extend: 'colvis',
                    text: 'Column Visibility'
                }
            ]
        }).buttons().container().appendTo(`${selector}_wrapper .col-md-6:eq(0)`);
    }

    // Initialize tables with buttons
    initializeDataTableWithButtons('#users', 10, 'desc');
    initializeDataTableWithButtons('#option-categories', 3, 'desc');
    initializeDataTableWithButtons('#rooms', 6, 'desc');
    initializeDataTableWithButtons('#venues', 5, 'desc');
  
    // Key Tables
    $("#key-table").DataTable({ 
        keys: true 
    });

    // Responsive Datatable
    $("#responsive-datatable").DataTable();

    // Multi Selection Datatable
    $('#selection-datatable').DataTable({
        select: {
            style: 'multi'
        }
    });

    // Alternative Pagination Datatable
    $("#alternative-page-datatable").DataTable({ 
        "pagingType": "full_numbers", 
    });

    // Scroll Vertical Datatable
    $("#scroll-vertical-datatable").DataTable({ 
        responsive: true,
        // scrollCollapse: true, 
        // paging: false 
    });

    // Scroll Horizontal Datatable
    $('#scroll-horizontal-datatable').DataTable({ 
        // scrollX: true,
        responsive: true,
    });

    // Complex headers with column visibility Datatable
    $("#complex-header-datatable").DataTable({ 
        "columnDefs": [ {
            "visible": false,
            "targets": -1
        } ]
    });

    // Row created callback Datatable
    $("#row-callback-datatable").DataTable({ 
        "createdRow": function ( row, data, index ) {
            if ( data[5].replace(/[\$,]/g, '') * 1 > 150000 ) {
                $('td', row).eq(5).addClass('text-danger');
            }
        }
    }),

    // State Saving Datatable
    $("#state-saving-datatable").DataTable({ 
        stateSave: true
    });

    // Fixed Columns Datatable
    $("#fixed-columns-datatable").DataTable({ 
        // scrollY: 300, 
        // scrollX: true, 
        // scrollCollapse: true, 
        // paging: false, 
        responsive: true,
    });

    // Fixed Header Database
    $('#fixed-header-datatable').DataTable( {
        responsive: true,
    });

    // table.buttons().container()
    //     .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');

    $("#datatable_length select[name*='datatable_length']").addClass('form-select form-select-sm');
    $("#datatable_length select[name*='datatable_length']").removeClass('custom-select custom-select-sm');
    $(".dataTables_length label").addClass('form-label');
});


// $(document).ready(function() {
//     var table = $('#fixed-header-datatable').DataTable( {
//         responsive: true,
//     } );
 
//     new $.fn.dataTable.FixedHeader( table );
// } );