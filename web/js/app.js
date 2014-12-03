/**
 * Created by Alex on 03.12.2014.
 */

$(document).on('click','.remove-btn',function(){
    curl = $(this).data('rmu');
    cid = $(this).data('rmid');
    if(confirm($(this).data('message'))) {
    myObj = $(this);
        $.ajax({
            url:curl,
            method:'POST',
            data:{
                id:cid
            },
            success:function(data){
                $(myObj).parent().parent().parent().fadeOut('slow');
                console.log(data);
            },
            error:function(data){
                $(myObj).parent().parent().parent().addClass('warning');
            }
        });


    }
});