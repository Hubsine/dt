function startAjaxSpinner(container){

    //var containerHeight = $(container).height();
    var spinner = '<div class="spinner text-center"><i style="position: absolute; top: 30%;" class="fa fa-spinner fa-spin fa-3x fa-fw" style=""></i></div>';
    $(container).addClass('hasSpinner').append(spinner);
    
}

function stopAjaxSpinner(container){
    $(container).removeClass('hasSpinner').children('.spinner').remove();
}

function initAjaxCancelBtn(){

    $('body').on('click', '.cancelFormToUpdateInAjax', function(e){
        
        var elmt = $(this).data('container');
        $("#"+elmt + ' .viewContent').removeClass('hidden');
        $("#"+elmt + ' .formContent').addClass('hidden').html("");
        
    });
    
}

/**
 * Sert seulement à récupérer une première fois le formulaire et à l'afficher.
 * 
 * @returns {undefined}
 */
function initAjaxUpdateBtn(){
    
    $('body').on('click', '.updateFormToUpdateInAjax', function(e){
        
        e.preventDefault();
        $.ajax({
            type: 'GET',
            url: $(this).data('action'),
            container: $(this).data('container'),
            beforeSend: function(jqXHR, settings){
                
                startAjaxSpinner('#'+settings.container + ' .viewContent');
                //$('#'+settings.container + ' .viewContent').addClass('hidden');
                //$('#'+settings.container + ' .formContent').removeClass('hidden');
            }
        })
        .done(function (data) {
            
            if (typeof data.form !== 'undefined') {
                
                stopAjaxSpinner('#'+data.contentId + ' .viewContent');
                
                $('#'+data.contentId + ' .viewContent').addClass('hidden');
                $('#'+data.contentId + ' .formContent').html(data.form).removeClass('hidden');
            }
        })
        ;
        
    });
}

/**
 * Soumet le formulaire à mettre à jour 
 * 
 * @returns {undefined}
 */
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
    
            if(typeof data.newCompteUrl !== 'undefined' && data.newCompteUrl !== null){
                document.location = data.newCompteUrl;
            }
            
            if (typeof data.form !== 'undefined') {
                $('#'+data.contentId + ' .viewContent').html(data.form).removeClass('hidden');
                $('#'+data.contentId + ' .formContent').html('').addClass('hidden');
            }
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            
            $(this.form.context).find(":input", ":select", ":textarea", ":button").removeAttr("disabled");
    
            if (typeof jqXHR.responseJSON !== 'undefined') {
                if (jqXHR.responseJSON.hasOwnProperty('form')) {
                    $('#'+jqXHR.responseJSON.contentId + ' .formContent').html(jqXHR.responseJSON.form);
                }
 
            } else {
                console.log(errorThrown);
            }
 
        });
    });
}

initAjaxForm();
initAjaxUpdateBtn();
initAjaxCancelBtn();