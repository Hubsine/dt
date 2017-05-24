

function initAjaxForm()
{
    $('body').on('submit', '.ajaxForm', function (e) {
 
        //$('.section-anchor-js .alert-success').addClass('hidden');
        e.preventDefault();
 
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize()
        })
        .done(function (data) {
            if (typeof data.form !== 'undefined') {
                $('#'+data.contentId).html(data.form);
                //alert(data.message);
            }
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            if (typeof jqXHR.responseJSON !== 'undefined') {
                if (jqXHR.responseJSON.hasOwnProperty('form')) {
                    $('#'+jqXHR.responseJSON.contentId).html(jqXHR.responseJSON.form);
                    
                }
 
                //$('.form_error').html(jqXHR.responseJSON.message);
 
            } else {
                alert(errorThrown);
            }
 
        });
    });
}

initAjaxForm();