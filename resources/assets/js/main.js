// Create the script tag, set the appropriate attributes
var script = document.createElement('script');
script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBrN7yvM0u6Kfy9TudEBwm7ViP2ot6rrSs&callback=initMap&libraries=places&v=weekly';
script.async = true;
document.head.appendChild(script);

let map, infoWindow;

window.initMap = function() {
	  map = new google.maps.Map(document.getElementById("mapholder"), {
	center: { lat: 43.6, lng: -79 },
	zoom: 10,
  });
  console.log("Map is done");
  infoWindow = new google.maps.InfoWindow();

  const input = document.getElementById("searchBar_input");
  const options = {
    fields: ["geometry.location"],
    strictBounds: false,
    types: ["geocode"],
  };
  
  const autocomplete = new google.maps.places.Autocomplete(input, options);

  const marker = new google.maps.Marker({
    map,
    anchorPoint: new google.maps.Point(0, -29),
  });

  autocomplete.addListener("place_changed", () => {
    marker.setVisible(false);

    const place = autocomplete.getPlace();

    if (!place.geometry || !place.geometry.location) {
      // User entered the name of a Place that was not suggested and
      // pressed the Enter key, or the Place Details request failed.
      window.alert("No details available for input: '" + place.name + "'");
      return;
    }

    // If the place has a geometry, then present it on a map.
    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(17);
    }
	
	document.getElementById("searchBar_lat").value = place.geometry.location.lat().toString();
	document.getElementById("searchBar_long").value = place.geometry.location.lng().toString();
	document.getElementById("submit_btn").value = "1";
    marker.setPosition(place.geometry.location);
    marker.setVisible(true);
    infoWindow.setContent = "Hi! " + place.geometry.location;
    infoWindow.open(map, marker);
  });

  const locationButton = document.getElementById("map_button");
  locationButton.addEventListener("click", () => {
    // Try HTML5 geolocation.
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          const pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude,
          };

		  const contentString =
			'<form id ="getLocation" method="POST" action="4WW3_project/assets/php/retrieveResults.php">' +
			'<button type="submit" name="submitSearch" value="1" aria-label="submit address search"' +
			'style="background-color: rgb(0, 214, 170);color: white;padding: 5px;">You are here! Click to search!</i></button>' +
			'<input type="hidden" name="lat" value="' + pos.lat + '"></input> <input type="hidden" name="long" value="' + pos.lng + '"></input>';
          infoWindow.setPosition(pos);
		  infoWindow.setCenter;
		  infoWindow.setContent(contentString);
          infoWindow.open(map);
          map.setCenter(pos);
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

// Wrap every letter in a span
var textWrapper = document.querySelector('.logo');
textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

anime.timeline({ loop: true })
	.add({
		targets: '.logo .letter',
		opacity: [0, 1],
		easing: "easeInOutQuad",
		duration: 2250,
		delay: (el, i) => 150 * (i + 1)
	}).add({
		targets: '.logo',
		opacity: 0,
		duration: 1000,
		easing: "easeOutExpo",
		delay: 2000
	});

// Append the 'script' element to 'head'