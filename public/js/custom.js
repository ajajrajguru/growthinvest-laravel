$(document).ready(function(){

	// Setup - add a text input to each header cell
  if ($('#usersTable').length){
    $('#usersTable thead th.w-search').each( function () {
       var title = $(this).text();
       $(this).closest('table').find('tr.filters td').eq( $(this).index() ).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );
    });

  	var userstable = $('#usersTable').DataTable({
      "paging":   false,
      "info":     false
    });

    // Apply the search
    userstable.columns().eq( 0 ).each( function ( colIdx ) {
       $( 'input', $('.filters td')[colIdx] ).on( 'keyup change', function () {
           userstable
               .column( colIdx )
               .search( this.value )
               .draw();
       } );
    } );
  }
 
});