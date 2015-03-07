$(document).ready(function () {
    cost = $("#cost_id").val();
    payment = $("#payment_credits").val();
    if( payment == 2 ){
        final_cost = Math.ceil(cost*(1+paypal_percent)*100)/100;
        $("#final_id").val(final_cost);
    }
    $("#cost_id").blur(function() {
        cost = $("#cost_id").val();
        $("#credit_id").val(cost);
        if( payment == 2 ){
            final_cost = Math.ceil(cost*(1+paypal_percent)*100)/100;
//            final_cost = final_cost.toFixed(2);
            $("#final_id").val(final_cost);
        }
    });

    // показ списка
    $('.dropdown-ajax').parent().css('position: relative');
    $('.dropdown-ajax').each(function(){
        $(this).parent().append(
            '<input type="text" class="form-control dropdown-ajax-search" value="'+$(this).children('option:selected').text()+'" />'
        );
        var list_option = '';
        $(this).children('option').each(function(){
            list_option = list_option +'<li data-val="'+$(this).val()+'">'+$(this).text()+'</li>';
        })
        $(this).parent().append('<div class="dropdown-ajax-result"><ul>'+list_option+'</ul></div><div class="triangl"></div>');
    })
    $('.dropdown-ajax-search').each(function() {
        $(this).focus(function() {
            $(this).next().show();
            $(this).next().next().show();
        });
        $(this).blur(function() {
            if (!$(this).next().is(':hover')) {
                $(this).next().hide();
                $(this).next().next().hide();
            }
        });
    })
    $('.dropdown-ajax-result li').each(function() {
        $(this).click(function() {
            $(this).closest('.dropdown-ajax-result').prev().val($(this).text());
            var payment_id = $(this).attr('data-val');
            $(this).closest('.dropdown-ajax-result').prev().prev().val(payment_id);
            $(this).closest('.dropdown-ajax-result').hide();
            $(this).closest('.dropdown-ajax-result').next().hide();
            if ((payment_id==1) && (payment_id!=active_payment)) {
                window.location.href = url_card+'&cost='+$("#cost_id").val();
            }
            else if ((payment_id==2) && (payment_id!=active_payment)) {
                window.location.href = url_paypal+'&cost='+$("#cost_id").val();
            }
             else if ((payment_id==3) && (payment_id!=active_payment)) {
                window.location.href = url_bank+'&cost='+$("#cost_id").val();
            }
        });
    })
})