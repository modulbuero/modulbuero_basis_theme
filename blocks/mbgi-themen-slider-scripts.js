 // Sliderfunktionsweise
  
 var currentSliderId = []; // jeweilige der aktuelle slide index für jeden slider
 var sliderDirection = []; // kann 1 und -1 sein. Bestimmt die automatische slide richtung
 var themenSlideCount = []; //anzahl der slides pro slider
 var blockWidth = 0;
 var slidesToShow = 3;
 var slideWidth = 3;
 
 /* Grundstruktur aufbauen */
 jQuery(document).ready(function($){
     var count = 0; //Hier mit Zählen wir die Anzahl an Slidern hoch, für die Arrays, die oben definiert sind
     $(".mbgi-block-themen-slider .block-themen-slider-wrap").each(function(){ // hier liegen die slides drin
         $(this).attr("id", "mbgi-themen-slider-block-"+count); // füge jedem slider eine einzigartige ID hinzu
         var slides = $(this).children().children(); // die slides
     
         // Erstellung der Pfeil-Navigation
         var pos = slides.length; // anzahl der Slides pro Slider
         
         var arrows = "<ul class='themen-slider-arrow-wrap'>";
         arrows += 		"<li class='arrow arrow-left'></div>";
         arrows += 		"<li class='arrow arrow-right'></div>";
         arrows += 	"</ul>";
         themenSlideCount[count] = pos; // anzahl der slides für den akutellen slider speichern
         $(this).parent().prepend(arrows); // navigation in html hinzufügen
 
         var arrowElem = $(this).parent().children(".themen-slider-arrow-wrap").children(); // Die Navigationspunkte, die wir gerade eingefügt haben
         currentSliderId[count] = 0; // Startindex jedes Sliders ist 0
         arrowElem.eq(0).addClass("disabled"); // Linken pfeil disablen, da die startposition ganz links ist
         if(pos <= slidesToShow){ // wenn alle slides bereits angezeigt werden
             arrowElem.eq(1).addClass("disabled"); // rechten pfeil disablen
         }
         arrowElem.click(function(){ // onClick für die pfeile
             var parent = $(this).parent().parent(); //parent container (.mbgi-block .mbgi-block-themen-slider)
             if($(this).hasClass("arrow-left") && !$(this).hasClass("disabled")){
                 mb_changeThemenSlide(parent, -1); // direction zurück
             }else if($(this).hasClass("arrow-right") && !$(this).hasClass("disabled")){
                 mb_changeThemenSlide(parent, 1); // direction vor
             }
         });
         $(this).find(".slideshow").css("width", pos*slideWidth); // slideshow breite auf die anzahl der slides anpassen
         count++; // sliderindex erhöhen
     });
 
     /*
     Variablen initialisieren nachdem die Slider initialisiert wurden.
      */
     slidesToShow = mb_updateSlidesToShow();
     slideWidth = mb_updateSlideWidth();
     mb_updateSliderSizes();
 });	
 
 // Änderung der current slide vom silder ID auf die slideposition POS
 function mb_changeThemenSlide(parent, direction){
     var arrows = parent.children(".themen-slider-arrow-wrap").children(); // pfeile
     var slideWrap = parent.children(".block-themen-slider-wrap"); // Slider-wrap
     var sliderId = slideWrap.attr("id").replace("mbgi-themen-slider-block-", ""); // Die Id wird benötigt für die arrays
     currentSliderId[sliderId] += direction; //die nächste Slide ist die nächste Id
     if (direction > 0){ // wenn es nach rechts geht
         if(currentSliderId[sliderId] >= slideWrap.children().children().length - slidesToShow){ // wenn die letzte slide die current slide ist => rechten pfeil disablen
             arrows.eq(1).addClass("disabled"); // arrows.eq(1) ist der rechte pfeil
         }
         arrows.eq(0).removeClass("disabled"); // arrows.eq(0) ist der linke pfeil. da wir nach rechts verschoben haben, können wir auf jeden fall wieder nach links schieben.
     }else if(direction < 0){ // wenn es nach links geht
         if(currentSliderId[sliderId] <= 0 ){ // wenn die letzte slide die current slide ist => rechten pfeil disablen
             arrows.eq(0).addClass("disabled"); // arrows.eq(1) ist der rechte pfeil
         }
         arrows.eq(1).removeClass("disabled"); // arrows.eq(0) ist der linke pfeil. da wir nach rechts verschoben haben, können wir auf jeden fall wieder nach links schieben.
     }
 
     // Translaten für den slide-effect
     var width = slideWrap.children().children().outerWidth();
     slideWrap.children().css("transform", "translateX("+(-(width*currentSliderId[sliderId]))+"px)");
 }
 
 function mb_updateSlideWidth(){
     // die breite der Slides anpassen
     var width = jQuery(".mbgi-block-themen-slider .block-themen-slider-wrap").width();
     width = width > 1440 ? 1440 : width;
     slideWidth = width / slidesToShow;
     return width / slidesToShow;
 }
 
 function mb_updateSlidesToShow(){
     // breakpoints für responsive
     if (blockWidth <= 481){
         slidesToShow = 1;
         return 1;
     }else if(blockWidth <= 961){
         slidesToShow = 2;
         return 2;
     }else{
         slidesToShow = 3;
         return 3;
     }
 }
 
 function mb_updateSliderSizes(){
	 if(jQuery(".mbgi-block-themen-slider").length){
	     jQuery(".mbgi-block-themen-slider .block-themen-slider-wrap").each(function(){
	         var slideshow = jQuery(this).children(); 
	         var slides = slideshow.children();
	         var numberSlides = slides.length;
	         var sliderId = 0;
	         slides.css("width", slideWidth);
	         slideshow.css("width", slideWidth*numberSlides);
	         setTimeout(()=>{
	            jQuery(this).css('height', slideshow.outerHeight());
	         }, 600);
	         /* Wir resetten den kompletten Slider damit die translation wieder stimmt. */
	         if(jQuery(this).attr("id") != undefined){
	         	sliderId = jQuery(this).attr("id").replace("mbgi-themen-slider-block-", ""); // Die Id wird benötigt für die arrays
	         }
	         currentSliderId[sliderId] = 0; // current slide postion resetten
	         slideshow.css("transform", "translateX(0px)"); // translation resetten
	         var arrows = jQuery(this).parent().children(".themen-slider-arrow-wrap").children(); // beide pfeile
	         arrows.eq(0).addClass("disabled"); // links disablen
	         if(numberSlides <= slidesToShow){ // wenn alle slides bereits angezeigt werden
	             arrows.eq(1).addClass("disabled"); // rechten pfeil disablen
	         }else{
	             arrows.eq(1).removeClass("disabled"); // Falls während des slidens die size geändert wird, wieder resetten
	         }
	     });
	}
 }
 
 setInterval(function(){
     if (blockWidth != jQuery('.mbgi-block-themen-slider .block-themen-slider-wrap').eq(0).width()){ // block width hat sich geändert, => öffnen der sidebar zb
         blockWidth = jQuery('.mbgi-block-themen-slider .block-themen-slider-wrap').eq(0).width();
         mb_updateSlidesToShow();
         mb_updateSlideWidth();
         mb_updateSliderSizes();
     }
 }, 100);