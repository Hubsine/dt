

function initAjaxForm()
{
    $('body').on('submit', '.ajaxForm', function (e) {
 
        //$('.section-anchor-js .alert-success').addClass('hidden');
        e.preventDefault();
 
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            form: $(this),
            beforeSend: function(jqXHR, settings){
                $(settings.form).find(":input", ":select", ":textarea", ":button").attr("disabled", "disabled");
            }
        })
        .done(function (data) {
            
            $(this.form.context).find(":input", ":select", ":textarea", ":button").removeAttr("disabled");
    
            if (typeof data.form !== 'undefined') {
                $('#'+data.contentId).html(data.form);
            }
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            
            $(this.form.context).find(":input", ":select", ":textarea", ":button").removeAttr("disabled");
    
            if (typeof jqXHR.responseJSON !== 'undefined') {
                if (jqXHR.responseJSON.hasOwnProperty('form')) {
                    $('#'+jqXHR.responseJSON.contentId).html(jqXHR.responseJSON.form);
                }
 
            } else {
                console.log(errorThrown);
            }
 
        });
    });
}

initAjaxForm();