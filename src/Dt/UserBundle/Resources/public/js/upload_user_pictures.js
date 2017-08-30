jQuery(function($){
    
    ////
    // Add user picture
    ////
    
    $('body').on('click', '#userPicturesForm .add-new', function(e){
        $('#dt_userbundle_userpicture_file').click();
    });
    
    $('body').on('change', '#dt_userbundle_userpicture_file', function(e){
        $('#userPicturesForm').submit().find('.messageContainer').html('');
    });
    
    $('body').on('submit', '#userPicturesForm', function(e){
        
        e.preventDefault(); 
        
        var form = $(this);
        
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: new FormData(form[0]),
            contentType: false,
            processData: false,
            form: form,
            cache: false
        })
        .done(function(data, textStatus, jqXHR){
            form.find('.messageContainer').html(data.message);
            $('.userPictureContainer').append(data.item);
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseJSON);
            form.find('.messageContainer').html(jqXHR.responseJSON.message);
    
        });
       
    });
    
    ////
    // Update and delete user picture
    ////
    
    $('body').on('click', '.userPictureActions .callAction', function(e){
        
        var elmt = $(this);
        var container = $('#userPicturesContent');
        var msgContainer = $('#userPicturesContent').find('.messageContainer');
        
        var routeName = elmt.data('action-url');
        var routeParameters = elmt.data('action-parameters');
        var method = elmt.data('action-method');
        
        $.ajax({
            url: Routing.generate(routeName, routeParameters),
            type: method,
            data: routeParameters,
            beforeSend: function(jqXHR, settings)
            {
                startAjaxSpinner(container);
                resetElmt(msgContainer);
            },
            complete: function(jqXHR, textStatus)
            {
                stopAjaxSpinner(container);
            }
        })
        .done(function(data, textStatus, jqXHR){
            
            if( method === 'GET' )
            {
                $('.userPictureActions .callAction.btn-success').removeClass('btn-success');
                elmt.addClass('btn-success');
            }
            
            if( method === 'DELETE')
            {
                elmt.closest('div.userPictureItem').remove();
            }
            
            msgContainer.html(data.message);
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            msgContainer.html(jqXHR.responseJSON.message);
    
        });
        
    });
    
});