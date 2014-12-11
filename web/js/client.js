var aj;
$(document).ready(function () {
    if (localStorage.getItem('request') != null) {
        $('#name_search').val(localStorage.getItem('request'));
    }
    if (localStorage.getItem('lang_select')) {
        $('#lang_select').select(localStorage.getItem('lang_select'));
    }
    $('.table_header').children().each(function () {
        old = $(this).children().html();
        if (old) {
            val = '<span class="glyphicon glyphicon-chevron-up btn btn-sm btn-success btn-group table_sort" data-type="1" data-name="' + old.replace(/\s/g, '_').toLowerCase() + '"></span>' +
            '<span class="btn btn-sm btn-group disabled">' + old + '</span>' +
            '<span class="glyphicon glyphicon-chevron-down btn btn-sm btn-success table_sort"  data-type="0" data-name="' + old.replace(/\s/g, '_').toLowerCase() + '"></span>';
            $(this).html(val);
        }
    });
    $(document).on('click', '*', function () {
        if (localStorage.getItem('sort_option')) {
            if (localStorage.getItem('sort_method') == 1)
                $('#sort_by').html('Sort by: ' + localStorage.getItem('sort_option') + ' asc.');
            else
                $('#sort_by').html('Sort by: ' + localStorage.getItem('sort_option') + ' desc');
        } else {
            $('#sort_by').html('');
        }
    });
    pager = $('#table-result-search').children()[2];
    pag($(pager).html());
});
$(document).on('click', '#bsearch', function () {
    myAjax();
});
$(document).on('click', '#bclear', function () {
    localStorage.removeItem('search');
    localStorage.removeItem('sort_option');
    localStorage.removeItem('sort_method');
    localStorage.removeItem('open_page');
    localStorage.removeItem('lang_select');
    localStorage.removeItem('request');
});
$(document).on('click', '.table_sort', function () {
    localStorage.setItem('sort_option', $(this).data('name'));
    localStorage.setItem('sort_method', $(this).data('type'));
    myAjax();
});
$(document).on('keyup', '#name_search', function () {
    if ($('#name_search').val().length > 0) {
        localStorage.setItem('search', 'true');
    }
    else {
        localStorage.removeItem('request')
        localStorage.setItem('search', 'false');
    }
    localStorage.setItem('request', $('#name_search').val());
    myAjax();
});
$(document).on('click', '.page_open', function () {
    localStorage.setItem('open_page', $(this).data('page'));
    myAjax();
});
$(document).on('change', '#lang_select', function () {
    localStorage.setItem('lang_select', $(this).val());
    myAjax();
});
var myAjax = function () {
    valss = {};
    if (localStorage.getItem('search') && localStorage.getItem('search') != 0) {
        valss.name = localStorage.getItem('request');
    }
    if (localStorage.getItem('sort_option')) {
        if (localStorage.getItem('sort_method') == 1) {
            valss.sort = localStorage.getItem('sort_option');
        }
        if (localStorage.getItem('sort_method') == 0) {
            valss.sort = '-' + localStorage.getItem('sort_option');
        }
    }
    if (localStorage.getItem('open_page') && localStorage.getItem('open_page') != 0) {
        valss.page = localStorage.getItem('open_page');
    }
    if (localStorage.getItem('lang_select') && localStorage.getItem('lang_select') != 0) {
        valss.lang = localStorage.getItem('lang_select');
    }
    if (aj && aj.readyState != 4) {
        aj.abort();
    }
    aj = $.ajax({
        url: $('#name_search').data('url'),
        method: 'GET',
        data: valss,
        success: function (data) {
            v1 = $(data).children()[1];
            v2 = $(v1).children()[1];
            $('#table-result-search .table tbody').remove();
            $('#table-result-search table').append(v2);
            pager = $(data).children()[2];
            pag($(pager).html());
        }
    });
};
var pag = function (paginator) {
    if (paginator) {
        var res = '';
        $(paginator).each(function () {
            turl = $(this).children().attr('data-page');
            turl = parseInt(turl) + 1;
            ttext = $(this).children().html();
            if (turl || ttext) {
                res += '<li ';
                if ($(this).hasClass('active')) {
                    res += 'class="active">';
                } else {
                    if ($(this).hasClass('disabled')) {
                        res += 'class="disabled"';
                    }
                    res += ' style="cursor:pointer;">';
                }
                res += '<span data-page="' + ((turl) ? turl : 'false') + '" class="page_open">' + ttext + '</span>';
                res += '</li>';
            }
        });
        $('.pagination').html(res);
    } else {
        $('.pagination').html('');
    }
};


$(document).on('click','.rm-btn',function(){
    curl = $(this).data('rmu');
    cid = $(this).data('id');
    if(confirm($(this).data('message'))) {
        myObj = $(this);
        $.ajax({
            url:curl,
            method:'POST',
            data:{
                id:cid
            },
            success:function(data){
                $(myObj).parent().parent().fadeOut('slow');
                console.log(data);
            },
            error:function(data){
                $(myObj).parent().parent().parent().addClass('warning');
            }
        });
    }
});