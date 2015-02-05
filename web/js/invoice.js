$(document).on('keyup', '#name_search', function () {
    var name = $('#name_search').val();
    var count_search = $('#count_search').val();
    $.ajax({
        url:$(this).data('url'),
        method:'POST',
        data:{
            name : name,
            count_search : count_search
        },
        success: function(response) { $('#invoice_view').empty().html(response).focus(); }
    });
});
