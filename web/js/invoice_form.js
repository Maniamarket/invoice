    function set_itog( is_add, count_items,income){
        if( !is_add ) is_add = 0;
        if( !count_items ) count_items = 0;
        if( !income ) income = 0;
        var count, price, discount, net,net_itog = 0, total, total_itog = 0;
        var vat = $('#vat :selected').text();
        for( var i=1; i<= count_items; i++){
            var to = (i-1).toString();
            count = $('#qty_'+ to).val();
            price = $('#price_'+to).val();
            discount = $('#discount_'+to).val();
            net = parseFloat(price*count);
            net_itog = net_itog + net;
            total = net*(1+(parseFloat(vat)+parseFloat(income)-parseFloat(discount))/100);
            total_itog = total_itog + total;
            $('#total_'+to).val(total.toFixed(2));
        }
 //  alert('count='+count+' price='+price+' disc='+discount+' net_it='+net_itog+' total='+total);
        if( is_add ){
            count = $('#qty_').val();
            price = $('#price_').val();
            discount = $('#discount_').val();
            net = parseFloat(price*count);
            net_itog = net_itog + net;
            total = net*(1+(parseFloat(vat)+parseFloat(income)-parseFloat(discount))/100);
            total_itog = total_itog + total;
            $('#total_').val(total.toFixed(2));
        }
        total_itog = total_itog.toFixed(2);
        net_itog = net_itog.toFixed(2);
        $('#net_itog').text(net_itog);
        $('#total_itog').text(total_itog);

 // alert('is_add='+is_add+' item='+count_items);
        return false;
    }

    function list_company_ajax(url, elem){
//        var input_word = $('#company_name').val();
        var input_word = $(elem).val();
//     alert('input_word='+input_word);
        $.ajax({
            url: url,
            method: 'POST',
            data: { input_word : input_word },
            success: function (data) {
                $(elem).prev().empty().html(data);
                var list_option = '';
                $(elem).prev().children('option').each(function(){
                    list_option = list_option +'<li data-val="'+$(this).val()+'">'+$(this).text()+'</li>';
                })
//                console.log(list_option);
                $(elem).next().empty().html('<ul>'+list_option+'</ul>');
                $(elem).next().children('.dropdown-ajax-result li').each(function() {
                    $(this).click(function() {
                        $(this).closest('.dropdown-ajax-result').prev().val($(this).text());
                        $(this).closest('.dropdown-ajax-result').prev().prev().val($(this).attr('data-val'));
                                                 alert($(this).attr('data-val'));
                        $(this).closest('.dropdown-ajax-result').hide();
                    });
                })
            }
        });
        return false;
    }

    $(document).ready(function () {
        $('.dropdown-ajax').parent().css('position: relative');
        $('.dropdown-ajax').each(function(){
            $(this).parent().append(
                '<input type="text" class="form-control dropdown-ajax-search" value="'+$(this).children('option:selected').text()+'" />'
            );
            var list_option = '';
            $(this).children('option').each(function(){
                list_option = list_option +'<li data-val="'+$(this).val()+'">'+$(this).text()+'</li>';
            })
            $(this).parent().append('<div class="dropdown-ajax-result"><ul>'+list_option+'</ul></div>');
        })
        $('.dropdown-ajax-search').each(function() {
            $(this).focus(function() {
                $(this).next().show();
            });
            $(this).blur(function() {
                if (!$(this).next().is(':hover')) {
                    $(this).next().hide();
                }
            });
            $(this).keyup(function() {
                list_company_ajax($(this).prev().attr('data-url'), this);
            });
        })
        $('.dropdown-ajax-result li').each(function() {
            $(this).click(function() {
                $(this).closest('.dropdown-ajax-result').prev().val($(this).text());
                $(this).closest('.dropdown-ajax-result').prev().prev().val($(this).attr('data-val'));
                //                         alert($(this).attr('data-val'));
                $(this).closest('.dropdown-ajax-result').hide();
            });
        })
    })
