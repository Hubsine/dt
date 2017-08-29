

function initAjaxCancelBtn(){

    $('body').on('click', '.cancelFormToUpdateInAjax', function(e){
        
        var container = "#"+$(this).data('container');
        
        $(container + ' .viewContent').removeClass('hidden');
        $(container + ' .formContent').addClass('hidden').html("");
        
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
            container: "#"+$(this).data('container'),
            beforeSend: function(jqXHR, settings){
                
                var container = settings.container;
                
                startAjaxSpinner(container + ' .viewContent');
                
            }
        })
        .done(function (data) {
            
            var container = "#"+data.contentId;
    
            if (typeof data.form !== 'undefined') {
                
                stopAjaxSpinner(container + ' .viewContent');
                
                $(container + ' .viewContent').addClass('hidden');
                $(container + ' .formContent').html(data.form).removeClass('hidden');
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
            container: "#"+$(this).data('container'),
            beforeSend: function(jqXHR, settings){
                
                var container = "#"+$(this.form).data('container');
                
                startAjaxSpinner(container + ' .formContent');
                $(settings.form).find(":input", ":select", ":textarea", ":button").attr("disabled", "disabled");
                
            }
        })
        .done(function (data) {
            
            var container = "#"+$(this.form).data('container');
    
            $(this.form.context).find(":input", ":select", ":textarea", ":button").removeAttr("disabled");
    
            if(typeof data.newCompteUrl !== 'undefined' && data.newCompteUrl !== null){
                document.location = data.newCompteUrl;
            }
            
            if (typeof data.form !== 'undefined') {
                
                $(container + ' .viewContent').html(data.form).removeClass('hidden');
                $(container + ' .formContent').html('').addClass('hidden');
                
                stopAjaxSpinner(container + ' .formContent');
            }
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
    
            var container = "#"+$(this.form).data('container');
    
            $(this.form.context).find(":input", ":select", ":textarea", ":button").removeAttr("disabled");
    
            if (typeof jqXHR.responseJSON !== 'undefined') {
                if (jqXHR.responseJSON.hasOwnProperty('form')) {
                    $('#'+jqXHR.responseJSON.contentId + ' .formContent').html(jqXHR.responseJSON.form);
                    stopAjaxSpinner('#'+jqXHR.responseJSON.contentId + ' .formContent');
                }
 
            } else {
                
                stopAjaxSpinner(container + ' .formContent');
                
                console.log(errorThrown);
                
            }
 
        });
    });
}

initAjaxForm();
initAjaxUpdateBtn();
initAjaxCancelBtn();