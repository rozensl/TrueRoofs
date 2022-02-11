// gets the user's current location using HTML Geolocation API
function getLocation() {
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(updateCoordinates);
	}
	else {
		// if not supported to use the API
		alert("Geolocation is not supported by this browser.");
	}
}

// fill the current location for the coordinate fields
function updateCoordinates(position){
	// coordinate fields
	var longitude = document.getElementById("locationlo");
	var latitude = document.getElementById("locationl");
	// fill the coordinate fields
	longitude.value = position.coords.longitude;
	latitude.value = position.coords.latitude;
}

//when the listing is selected update the other fields 
function selectedList() {
	// variables to be updated
	var longitude = document.getElementById("locationlo");
	var latitude = document.getElementById("locationl");
	var address = document.getElementById("address");
	var locID = document.getElementById("locationID");
		
	// what did we select
	var selected = document.getElementById("list");
	var selectedValues = selected.value;

	const updates = selectedValues.split(';');
	
	// make the filling
	longitude.value = updates[2];
	latitude.value = updates[1];
	address.value = updates[3];
	locID.value = updates[0];
	
	//alert(selected.value);
	//return false;
}

// Extra validation for other fields
function validateSubmission(form) {
	var addr = form.address;
	var lat = form.locationl;
	var lon = form.locationlo;
	
	if (!(validateAddress(addr))) {
		alert("Incorrect address.");
		addr.focus();
		return false;
	}
	else if (!(validateLat(lat))) {
		alert("Incorrect lattitude coordinate. Must be to 4 decimal places and within -90.0000 and 90.0000.");
		lat.focus();
		return false;
	}
	else if (!(validateLong(lon))) {
		alert("Incorrect longitude coordinate. Must be to 4 decimal placess and within -180.0000 and 180.0000.");
		lon.focus();
		return false;
	}
	else {
		return true;
	}
}

function validateAddress(addr) {
	var reg = /^[A-Za-z0-9'\.\-\s\,]*$/;
	if (reg.test(addr.value)) {
		return true;
	}
	else {
		return false;
	}
}

function validateLat(lat) {
	var reg = /^(\+|-)?(?:90(?:(?:\.0{1,4})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,4})?))*$/;
	
	var latitude = parseFloat(lat.value);
	
    if (latitude < -90 || latitude > 90) {
        return false;
    }
	else if (!reg.test(lat.value)) {
		return false;
	}
	else {
		return true;
	}
}

function validateLong(lon) {
	var reg = /^(\+|-)?(?:180(?:(?:\.0{1,4})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,4})?))*$/;
	
	var longitude = parseFloat(lon.value);
	
    if (longitude < -180 || longitude > 180) {
        return false;
    }
	else if (!reg.test(lon.value)) {
		return false;
	}
	else {
		return true;
	}
}