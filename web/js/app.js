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


$(document).on('click','#bet',function(){
    url = $('#turl').val();
    from = $('#i_trans').val();
    ires = $('#i_res');

    $.ajax({
        url:url,
        method:'POST',
        data:{
            word:from
        },
        success:function(data){
            $(ires).val(data);
            console.log(data);
        },
        error:function(data){
            console.log(data);
        }
    });
});

$(document).on('click','#alp',function(){
    urls = $('#turl').val();
    from = $('#i_trans').val();
    ires = $('#i_res');
    $.ajax({
        url:urls,
        method:'POST',
        data:{
            word:from,
            from_lang:1,
            to_lang:2
        },
        success:function(data){
            $(ires).val(data);
            console.log(data);
        },
        error:function(data){
            console.log('error:');
            console.log(data);
        }
    });
});