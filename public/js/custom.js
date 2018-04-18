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


  /** Function to format the amount */
  formatAmount =  function(amount,decimal,prefix,commafy){                
    if((typeof amount === 'undefined' ) || (amount==='') || (amount == null)  )
      return '';

      decimal = decimal==undefined?0:decimal;
      prefix = prefix==undefined?false:prefix;
      commafy = commafy==undefined?false:commafy;
      amount =   parseFloat(amount).toFixed(decimal);

      if(commafy){
        amount = commafyAmount(amount);
      }

      if(prefix){
        amount= " &pound; "+amount;

      }

      return amount;
  }


    /* Function to format commafy amounts    */
    commafyAmount = function ( num ) {

        var str = num.toString().split('.');

            str[0] = str[0].replace(/(\d)(?=(\d{3})+$)/g, '$1,');


        return str.join('.');
    }
 
});