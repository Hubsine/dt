jQuery(function($){
    
    $('body').on('click', '#userPicturesForm .add-new', function(e){
        console.log(1);
        $('#dt_userbundle_userpicture_file').click();
    });
    
    $('body').on('change', '#dt_userbundle_userpicture_file', function(e){
        console.log(2);
        $('#userPicturesForm').submit().find('.messageContainer').html('');
    });
    
    $('body').on('submit', '#userPicturesForm', function(e){
        
        console.log(3);
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
        .done(function(data){
            console.log(data);
            form.find('.messageContainer').html(data.message);
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseJSON);
            form.find('.messageContainer').html(jqXHR.responseJSON.message);
    
        });
       
    });
});