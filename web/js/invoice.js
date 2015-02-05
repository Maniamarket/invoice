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

$(document).on('blur', '#invoice-date', function () {
    var element_error = document.getElementById('error-date');
    element_error.innerHTML = '';

    var dateformat = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/;
    // Match the date format through regular expression
    var field = $('#invoice-date').val();
    if (field === ''){
        element_error.innerHTML = "date must d/m/Y";
        alert('aaa'+field+element_error.innerHTML);
        return false;
    }
    if( field.match(dateformat))
    {
         //Test which seperator is used '/' or '-'
        var opera1 = field.split('/');
        var opera2 = field.split('-');
        lopera1 = opera1.length;
        lopera2 = opera2.length;
        // Extract the string into month, date and year
        if (lopera1>1) { var pdate = field.split('/');  }
        else if (lopera2>1) { var pdate = field.split('-');  }
        var dd = parseInt(pdate[0]);
        var mm  = parseInt(pdate[1]);
        var yy = parseInt(pdate[2]);
        // Create list of days of a month [assume there is no leap year by default]
        var ListofDays = [31,28,31,30,31,30,31,31,30,31,30,31];
        if (mm==1 || mm>2)
        {
            if (dd>ListofDays[mm-1])
            {
                element_error.innerHTML = "date must d/m/Y";
                return false;
            }
        }
        if (mm==2)
        {
            var lyear = false;
            if ( (!(yy % 4) && yy % 100) || !(yy % 400))
            {
                lyear = true;
            }
            if ((lyear==false) && (dd>=29))
            {
                element_error.innerHTML = "date must d/m/Y";
                return false;
            }
            if ((lyear==true) && (dd>29))
            {
                element_error.innerHTML = "date must d/m/Y";
                return false;
            }
        }
    }
    else
    {
        element_error.innerHTML = "date must d/m/Y";
        return false;
    }
});
