// Get Geolocation
function get_user_coordinates() {
    navigator.geolocation.getCurrentPosition(position => {
        document.getElementById("latitude").value = position.coords.latitude;
        document.getElementById("longitude").value = position.coords.longitude;
    }, () => {
        alert("Tenes que permitir la locacion para continuar");
    });
}

// Get Latitude and Longitude from Map
function get_map_coordinates() {
    try {
        container = document.getElementsByClassName("wm-attribution-control__latlng")[0];
        text = container.getElementsByTagName("span")[0].innerHTML;

        regex = /([-]?[0-9]*[.][0-9]*)/g;
        match = text.match(regex);

        coords = {
            latitude: match[0],
            longitude: match[1]
        };

        console.log(coords);
    } catch (error) {
        console.log("error");
    }
}