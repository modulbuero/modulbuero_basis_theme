// Sliderfunktionsweise
  
var currentId = []; // jeweilige der aktuelle slide index für jeden slider
var direction = []; // kann 1 und -1 sein. Bestimmt die automatische slide richtung
var slideCount = []; //anzahl der slides pro slider
var slideInterval = []; // Wie schnell das interval sich ändern soll

jQuery(document).ready(function($){
	/**
	 * Wir bauen unseren eigenen Slider für jeden Slider auf der Seite.
	 */
	var count = 0;
	$(".mbgi-block-slider .block-slider-wrap").each(function(){ // hier liegen die slides drin
		$(this).attr("id", "mbgi-slider-block-"+count); // füge jedem slider eine einzigartige ID hinzu
		var slides = $(this).children(); // die slides
		if(slides.length <= 1){
			return;
		}
	

		// Erstellung der Punkt-Navigation
		var points = "<ul class='slider-nav-wrap'>";
		var pos = 0; //position des punktes
		slides.each(() => { // für jeden slide einen punkt
			points += "<li class='slider-point' onClick='mb_setSlide_SliderBlock("+count+","+pos+")'></li>";
			pos++;
		});
		points += "</ul>";
		slideCount[count] = pos; // pos wie length
		$(this).parent().append(points); // navigation in html hinzufügen

		var nav_points = $(this).parent().children(".slider-nav-wrap").children(); // Die Navigationspunkte, die wir gerade eingefügt haben
		slides.eq(0).addClass("active"); // erste slide aktivieren
		nav_points.eq(0).addClass("active"); // Ersten punkt auf active setzen
		currentId[count] = 0;
		slideInterval[count] = $(this).parent().attr("data-interval");
		count++;
		
		//Wenn der Text in irgendeinem der Slides angezeigt wird, verschiebe die Punkt-Navigation nach rechts
		var textEnabledAnywhere = false;
		$(this).children().each(function() {
			if ($(this).hasClass("title-on")) textEnabledAnywhere = true;
		});
		if (textEnabledAnywhere) $(".slider-nav-wrap").addClass("slider-nav-wrap-right");
	});
});	

// Änderung der current slide vom silder ID auf die slideposition POS
function mb_setSlide_SliderBlock(id, pos){
	var slideWrap = jQuery("#mbgi-slider-block-"+id); //slider container
	var navWrap = slideWrap.parent().children(".slider-nav-wrap"); // navpunkte container
	
	//active klassen entfernen
	slideWrap.children().removeClass("active");
	navWrap.children().removeClass("active");
	
	//an richtiger position active wieder hinzufügen
	slideWrap.children().eq(pos).addClass("active");
	navWrap.children().eq(pos).addClass("active");
	currentId[id] = pos; // current id für den jeweiligen Slider
	
	// Translaten für den slide-effect
	var width = slideWrap.width();
	slideWrap.children().css("transform", "translateX("+(-(width*pos))+"px)");
}

jQuery(document).ready(function(){
	for(var i = 0; i < currentId.length; i++){
		
		setInterval(function(i){		
				if(currentId[i] <= 0){
					// wenn man bei der ersten slide ist, die direction auf vorwärts (1) ändern
					direction[i] = 1; 
				}else if( currentId[i] >= slideCount[i]-1 ){ // slidecount ist wie eine length
					// Wenn man am letzten sliderpunkt ist, die direction auf rückwärts (-1) ändern
					direction[i] = -1;
				}
				mb_setSlide_SliderBlock(i, currentId[i] - (-direction[i]));
	
			}, slideInterval[i], i); // i muss der interval funktion übergeben werden da sie sonst undefined ist.
	}
});