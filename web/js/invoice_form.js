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

    function list_company_ajax(url){
        var input_word = $('#company_name').val();
//     alert('input_word='+input_word);
        $.ajax({
            url: url,
            method: 'POST',
            data: { input_word : input_word },
            success: function (data) {
                $('#list_company').empty().html(data);
            }
        });
        return false;
    }

