
/////
// Sidebar Menu
/////

jQuery(function($){
   
   /// Sidebar menu affix
   $('#sidebarMenu').affix('checkPosition');
   
   /// Menu design and smool scroll
    $('#sidebarMenu .nav .nav > li').click('click', function(){

        var parentUl = $(this).parent('ul');
        
        $(parentUl).children('li').removeClass('active');
        $(this).addClass('active');
        
        var the_id = $(this).children('a').attr("href");

	$('html, body').animate({
		scrollTop:$(the_id).offset().top
	}, 'slow');
        
	return false;
        
    });

    /// Anchor Js
    var sidebarAnchors = new AnchorJS();
    sidebarAnchors.options = { 
        visible: 'always'
    };
    sidebarAnchors.add('.section-anchor-js > h3');
    
});
