
// dodaje tło naprzemienne do articles datatable
$(document).ready(function () {

//    $('tr:even').css('background', '#cccccc');
//    $('tr:odd').css('background', 'whitesmoke');
//    $('thead tr').css('background', '#ffcc99');



    // zaznacza i odznacza checkboxy w datatable - usuń wiele
    $('#select-all').click(function () {

        if (!$('#select-all').attr('checked')) {

            $('input:checkbox').each(function () {
                $('input:checkbox').attr('checked', 'checked');
            });

        } else {

            $('input:checkbox').each(function () {
                $('input:checkbox').attr('checked', false);
                window.location.reload();
            });

        }


    });
    
    
    
    
    

    

});




