let map, infoWindow, geocoder, response;

function initMap() {
  map = new google.maps.Map(document.getElementById("mapholder"), {
    center: { lat: 43.2609, lng: -79.9192 },
    zoom: 6,
  });
  infoWindow = new google.maps.InfoWindow();
  geocoder = new google.maps.Geocoder();
  const locationButton = document.createElement("button");

  locationButton.textContent = "Search by current Location";
  locationButton.style.backgroundColor = "rgb(0,214,170)";
  locationButton.style.color = "white";
  locationButton.style.padding = "12px";
  locationButton.classList.add("custom-map-control-button");
  map.controls[google.maps.ControlPosition.TOP_CENTER].push(locationButton);
  document.getElementById("submit").addEventListener("click", () =>
    codeAddress()
  );

  locationButton.addEventListener("click", () => {
    // Try HTML5 geolocation.
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          const pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude,
          };

          infoWindow.setPosition(pos);
          infoWindow.setContent("Your location!");
          infoWindow.open(map);
          map.setCenter(pos);
		  map.setZoom(12);
        },
        () => {
          handleLocationError(true, infoWindow, map.getCenter());
        }
      );
    } else {
      // Browser doesn't support Geolocation
      handleLocationError(false, infoWindow, map.getCenter());
    }
  });

  
function codeAddress() {
	var form = document.forms['search-bar'];
	var address = form.elements['search'].value;
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == 'OK') {
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
        });
      } else {
        alert('Geocode was not successful for the following reason: ' + status);
      }
    });
  }
  
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
	infoWindow.setPosition(pos);
	infoWindow.setContent(
	  browserHasGeolocation
		? "Error: The Geolocation service failed."
		: "Error: Your browser doesn't support geolocation."
	);
	infoWindow.open(map);
}