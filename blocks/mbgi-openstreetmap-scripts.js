jQuery(document).ready(function() {
	jQuery('#mbgi-openstreetmap-button').on('click', updateOSM); //führe updateOSM() bei Klick auf Button aus.
	
	if (checkCookie("KartenSofortLaden", "ja")) updateOSM();
	
	function updateOSM() {
		const button = jQuery('#mbgi-openstreetmap-button');
		
		/* Hole Adressdaten aus custom data-attributes des Buttons */
		const street = button.data("street");
		const postalcode = button.data("postalcode");
		const city = button.data("city");
		const country = button.data("country");
		
		var url = encodeURI("https://nominatim.openstreetmap.org/search?street="+street+"&postalcode="+postalcode+"&city="+city+"&country="+country+"&format=json&limit=1");
		
		jQuery.get(url, function(data){ //Sende Anfrage an nominatim
			if (data.length !== 0) { //Ergebnis gefunden
				var lat = data['0']['lat']; //Breitengrad aus json-Antwort holen
				var lon = data['0']['lon']; //Längengrad aus json-Antwort holen
				//console.log("Lat: " + lat + " and Lon: " + lon);
				
				/* Erzeuge OSM Karte mit Leaflet */
				var karte = L.map('mbgi-openstreetmap-wrap').setView([lat, lon], 17);
				L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
					'attribution':  'Kartendaten &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> Mitwirkende',
					'useCache': true
				}).addTo(karte);
				var marker = L.marker([lat, lon]).addTo(karte);
				marker.bindPopup(street + "<br>" + postalcode + " " + city).openPopup();
				
			} else { //Kein Ergebnis gefunden
				alert("Kein Suchergebnis!");
			}
		});
		
		if (jQuery("#mbgi-openstreetmap-checkbox").checked) setCookie("KartenSofortLaden", "ja", 365);
		
		jQuery("#mbgi-openstreetmap-overlay").remove();
		
	}
	
	function setCookie(cname, cvalue, exdays) { //cname=name, cvalue=wert, exdays=gültigkeitsdauer in tagen
	  var d = new Date();
	  d.setTime(d.getTime() + (exdays*24*60*60*1000));
	  var expires = "expires="+ d.toUTCString();
	  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	}
	
	function getCookie(cname) { //suche nach cookie mit namen cname
	  var name = cname + "=";
	  var decodedCookie = decodeURIComponent(document.cookie);
	  var ca = decodedCookie.split(';');
	  for(var i = 0; i <ca.length; i++) {
	    var c = ca[i];
	    while (c.charAt(0) == ' ') {
	      c = c.substring(1);
	    }
	    if (c.indexOf(name) == 0) {
	      return c.substring(name.length, c.length);
	    }
	  }
	  return "";
	}
	
	function checkCookie(cname, cvalue) { //prüfe ob cookie mit namen cname den wert cvalue besitzt
		var kartenCookie = getCookie(cname)
		if (kartenCookie === cvalue) {
			return true;
		} else {
			return false;
		}
	}
});