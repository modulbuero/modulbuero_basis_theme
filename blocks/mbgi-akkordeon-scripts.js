jQuery(document).ready(function($){
    $('.mbgi-block.mbgi-block-akkordeon .akkordeon-wrap h2').click(function(){
	    if($(this).hasClass("active")){ 		// falls schon aufgeklappt wieder zuklappen
            $(this).removeClass("active");
            $(this).next().slideUp();
        }
        else{ 									// sonst aufklappen
            $(this).addClass("active");
            $(this).next().slideDown();
        }
    });
});