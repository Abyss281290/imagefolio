  $(document).ready(function() {
    
    Cufon.replace('h1,h2,h3,h4,h5,h6,#myslidemenu a,.leftpost,.postcomment', {hover: 'true'});
    
    /* initialize prettyphoto */
    /*$("a[rel^='prettyPhoto']").prettyPhoto({
  		theme: 'light_square'
    });*/
    
    /* Slideshow Cycle*/
    imageLoader();
            
    /* Animate Portfolio Items */
    if ($.browser.msie && $.browser.version < 7) return;
    $(".imgportfolio").fadeTo(1, 1);
    $(".imgportfolio").hover(
      function () {
        $(this).stop().fadeTo("fast", 0.66)
      },
      function () {
        $(this).stop().fadeTo("slow", 1);
      }
    );
    
    
	});	
	
// Image loader
function imageLoader() {
	
    $('.loader').each(function () {
					  
        var loader = $(this);
        var pathToImage = loader.attr('title');
        var img = new Image();
	  
        $(img).css("opacity", "0.0").load(function () {
								    
            loader.append(this).removeAttr('title');
		
            $(this).css("margin", "0px").css("opacity", "0.0").animate({
											     
                opacity: 1.0
		    
            },400, function () {
			
                loader.css({ "background-image": "none", "background-color": "transparent" });
		    
            });
		
        }).attr('src', pathToImage);
	  
    });
    
}	
	