function total_price(){
    var count = $('#qty').val();
    alert(count);
    return false;
}
$('#qty').val(2222);
$(document).on('keyup', '#qty', function (){
        return total_price();
    }
);
alert('ddddd');
