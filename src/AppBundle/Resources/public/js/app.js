
/////
// Sidebar Menu
/////

jQuery(function($){
   
    $('#sidebarMenu .nav .nav > li').click('click', function(){

        //$(this).addClass('active');
        var parentUl = $(this).parent('ul');
        $(parentUl).children('.active').removeClass('active').children(this).addClass('active');
        console.log(parentUl);
        
        $(this).addClass('active');
    });
    
});