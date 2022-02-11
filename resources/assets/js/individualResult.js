// Create the script tag, set the appropriate attributes
var script = document.createElement('script');
script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBrN7yvM0u6Kfy9TudEBwm7ViP2ot6rrSs&callback=initMap&libraries=places&v=weekly';
script.async = true;
document.head.appendChild(script);

let map;

function initMap() {

	const lat = document.getElementById("lat").value;
	const long = document.getElementById("long").value;
	var mapLatLng = new google.maps.LatLng(lat, long);

	map = new google.maps.Map(document.getElementById("map"), {
		center: mapLatLng,
		zoom: 12,
	});

	const marker = new google.maps.Marker({
		map,
		anchorPoint: new google.maps.Point(0, -29)
	});
	marker.setPosition(mapLatLng);
	marker.setVisible(true);
}

slideIndex = 0; 

// Next/previous controls
function plusSlides(n) {
	showSlides(slideIndex += n);
	
}
// Thumbnail image controls
function currentSlide(n) {
	showSlides(slideIndex = n);
}

// Image gallery function (cycles through slides)
function showSlides(n) {
	var i;
	var slides = document.getElementsByClassName("mySlides");
	if (n > slides.length) {
		slideIndex = 1;
	}
	if (n < 1) {
		slideIndex = slides.length;
	}
	for (i = 0; i < slides.length; i++) {
		slides[i].style.display = "none";
	}
	slides[slideIndex - 1].style.display = "flex";
}
