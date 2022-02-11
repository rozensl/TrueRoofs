// Create the script tag, set the appropriate attributes
var script = document.createElement('script');
script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBrN7yvM0u6Kfy9TudEBwm7ViP2ot6rrSs&callback=initMap&libraries=places&v=weekly';
script.async = true;
document.head.appendChild(script);

let map;

function initMap() {

	console.log("hello!");
	const lat = document.getElementById("firstLat").value;
	const long = document.getElementById("firstLong").value;
	console.log(lat + " and " + long);
	var mapLatLng = new google.maps.LatLng(lat, long);

	map = new google.maps.Map(document.getElementById("map"), {
		center: mapLatLng,
		zoom: 12,
	});
	
	const listings = document.querySelectorAll(".content-grandchild");
	for (let i = 0; i < 4; i++){
		const marker = new google.maps.Marker({
			map,
			anchorPoint: new google.maps.Point(0, -29)
		});
		let lat = listings[i].querySelector(".lat").value;
		let long = listings[i].querySelector(".long").value;
		let markerLatLng = new google.maps.LatLng(lat, long);

		marker.setPosition(markerLatLng);
		marker.setVisible(true);
	}
}