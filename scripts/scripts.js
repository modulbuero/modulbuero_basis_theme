jQuery(document).ready(($)=>{
	console.log("scripts");
	/*Set paddingTop to MainContent*/
	var heightHeader = $('body #mb-container > header').height();
	$("body #mb-container > main").css("padding-top",heightHeader+"px");
	console.log(heightHeader);
	
	/*Menü-Mobile*/
	var hamburgerMenu = $('#mb-container > header .mb-col-mainmenu > div');
	
	$(document).on('click','.hamburger-menu', function(){
		$(this).addClass('close-menu').removeClass('hamburger-menu');
		hamburgerMenu.css({'transform': 'translateX(0)', 'top':heightHeader+'px'}).addClass('menu-open');

		$(document).on('click','.close-menu', function(){
			$(this).removeClass('close-menu').addClass('hamburger-menu');
			hamburgerMenu.css({'transform': 'translateX(100%)'}).removeClass('menu-open');
		});
	});
	
    
    /*Stoerer schliessen
	//Todo Classname prüfen wenn Block entwicklung abgeschlossen
	$(".stoerer-close-btn").click(function() {
		$(".mbgi-stoerer-wrap").hide();
		setCookie('mbgi-stroerer', 'remove-stoerer', 1);
	});
	*/	
     
    /*ScrollToTop*/
	$(".scroll-to-top-button-wrap").on("click", function() {
		window.scrollTo({top: 0, behavior: 'smooth'});
	});
	
	
	/*Letztes Element hat neues Element*/
	var elements = ['main p'];
	$.each( elements, function( valueOne, valueOne ){
		strippedClassIdTag = valueOne.replace('#', '').replace('.','');
		$( valueOne ).each(function( indexTwo, valueTwo ) {
			if ( !$( this ).next().is( strippedClassIdTag ) || !$( this ).next().is( strippedClassIdTag ) ) {
				$( this ).addClass('distanceBottom');
			}
		});
	});

	/*Sitemap (zusatzPlugin: WP Sitemap Page) Rename Fixes, Übersetzung*/
	if($(".wsp-container").length){
		$("h2.wsp-pages-title").html("Seiten");
		$("h2.wsp-posts-title").html("Beiträge");
		$(".wsp-category-title").each(function() {
			$(this).contents().first().replaceWith("Kategorie: ");
		});
	}

});

/** ******************************************
 *	befindet sich das Element im Viewport 
 */
function isInViewport ($, element) {
	let top_of_element 		= $(element).offset().top;
    let bottom_of_element 	= $(element).offset().top + $(element).outerHeight();
    let bottom_of_screen 	= $(window).scrollTop() + $(window).innerHeight();
    let top_of_screen 		= $(window).scrollTop();

    if ((bottom_of_screen > top_of_element) && (top_of_screen < bottom_of_element)){
        return true;
    } else {
        return false;
    }
}


/** ******************************************
 * Cookie Functions
 */
/*Set a Cookie*/
function setCookie(cName, cValue, expDays) {
	let date = new Date();
	date.setTime(date.getTime() + (expDays * 24 * 60 * 60 * 1000));
	const expires = "expires=" + date.toUTCString();
	document.cookie = cName + "=" + cValue + "; " + expires + "; path=/";
}
/*Get Cookie value*/
function getCookie(cName) {
	let name = cName + "=";
	let ca = document.cookie.split(';');
	console.log(ca.length);
	for(let i = 0; i < ca.length; i++) {
		let c = ca[i];
		while (c.charAt(0) == ' ') {
		c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
		return c.substring(name.length, c.length);
		}
	}
	return ''; //cookie doesn't exist
}
/*Check if Cookie exists*/
function checkCookieExists(cName) {
	if ( document.cookie.indexOf(cName) > -1 ) {
		return true;
	} else {
		return false;
	}
}


/** ******************************************
 * 	Whatsapp share
 */ 
function addWhatsappShare($){
	$(".whatsapp-share").click(function(){
		var url = $(this).attr("data-url");
		if($(this).hasClass("mobile")){
			window.open( "whatsapp://send?text=" + "Sieh dir diesen Beitrag von den Grünen an: " + url, '_blank');
		}else{
			window.open( "https://web.whatsapp.com/send?text=Sieh dir diesen Beitrag von den Grünen an: " + url, '_blank');
		}  
	});
}