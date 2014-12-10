$(document).ready (function(){
    $('#name_search').keyup(function() {
        curl = $(this).data('url');
        console.log(curl);
        $.ajax({
            url:curl,
            method:'GET',
            data:{
                name:$(this).val()
            },
            success:function(data){
                $('#table-result-search tbody').empty().html(data);
            }
        });
    });
})
