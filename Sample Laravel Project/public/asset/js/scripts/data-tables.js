/*
 * DataTables - Tables
 */


$(function () {

  // Simple Data Table

  $('#data-table-simple').DataTable({
    "responsive": true,
  });

  // Row Grouping Table

  var table = $('#data-table-row-grouping').DataTable({
    "responsive": true,
    "columnDefs": [{
      "visible": false,
      "targets": 2
    }],
    "order": [
      [2, 'asc']
    ],
    "displayLength": 25,
    "drawCallback": function (settings) {
      var api = this.api();
      var rows = api.rows({
        page: 'current'
      }).nodes();
      var last = null;

      api.column(2, {
        page: 'current'
      }).data().each(function (group, i) {
        if (last !== group) {
          $(rows).eq(i).before(
            '<tr class="group"><td colspan="5">' + group + '</td></tr>'
          );

          last = group;
        }
      });
    }
  });

  // Page Length Option Table

  $('#page-length-option').DataTable({
    "responsive": true,
    "lengthMenu": [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "All"]
    ]
  }); 

  // Dynmaic Scroll table

  $('#scroll-dynamic').DataTable({
    "responsive": true,
    scrollY: '50vh',
    scrollCollapse: true,
    paging: false
  })

  // Horizontal And Vertical Scroll Table

  $('#scroll-vert-hor').DataTable({
    "scrollY": 200,
    "scrollX": true
  })

  // Multi Select Table

  $('#multi-select').DataTable({
   // responsive: true,
    "paging": true,
    //"scrollY": 200,
    "scrollX": true,
	"responsive": true,
    //"ordering": false,
    //"info": false,
	"displayLength":100,
    "order": [],
    "columnDefs": [{
      //"visible": false,
      "targets": 'no-sort',
      "orderable": false,
    }],
    "dom": 'lBfrtip',
   "buttons": [
              'csv'
               ]
  });
  
  $('#multi-select-1000').DataTable({
    "paging": true,
    "scrollX": true,
	"displayLength":1000,
	"responsive": true,
    "order": [],
    "columnDefs": [{
      "targets": 'no-sort',
      "orderable": false,
    }],
    "dom": 'lBfrtip',
   "buttons": [
              'csv'
               ]
  });
  
  $('#multi-select-500').DataTable({  
    "paging": true,
    "scrollX": true,
	"displayLength":500,
	"responsive": true,
    "order": [],
    "columnDefs": [{
      "targets": 'no-sort',
      "orderable": false,
    }],
    "dom": 'lBfrtip',
   "buttons": [
              'csv'
               ]
  });
  
	$('#multi-select-alldis').DataTable({
		"responsive": true,
		"paging": false,
		"dom": 'lBfrtip',
		"buttons": ['csv']
    });

});



// Datatable click on select issue fix
$(window).on('load', function () {
  $(".dropdown-content.select-dropdown li").on("click", function () {
    var that = this;
    setTimeout(function () {
      if ($(that).parent().parent().find('.select-dropdown').hasClass('active')) {
        // $(that).parent().removeClass('active');
        $(that).parent().parent().find('.select-dropdown').removeClass('active');
        $(that).parent().hide();
      }
    }, 100);
  });
});

var checkbox = $('#multi-select tbody tr th input')
var selectAll = $('#multi-select .select-all')

// Select A Row Function

$(document).ready(function () {
  checkbox.on('click', function () {
    $(this).parent().parent().parent().toggleClass('selected');
  })

  checkbox.on('click', function () {
    if ($(this).attr("checked")) {
      $(this).attr('checked', false);
    } else {
      $(this).attr('checked', true);
    }
  })


  // Select Every Row 

  selectAll.on('click', function () {
    $(this).toggleClass('clicked');
    if (selectAll.hasClass('clicked')) {
      $('#multi-select tbody tr').addClass('selected');
    } else {
      $('#multi-select tbody tr').removeClass('selected');
    }

    if ($('#multi-select tbody tr').hasClass('selected')) {
      checkbox.prop('checked', true);

    } else {
      checkbox.prop('checked', false);

    }
  })
})