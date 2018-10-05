<?php
$google_maps_api_key = $_GET['key'];
$googleapi_setttings = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?key=" . trim($google_maps_api_key) . "&address=91409"));
$timezone_settings = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/timezone/json?key=" . trim($google_maps_api_key) . "&location=34.2011137,-118.475058&timestamp=" . time()));

if (isset($google_maps_api_key) && $googleapi_setttings->status == "REQUEST_DENIED") {
    echo "<p>Your Google Maps API key came back with the following error. " .$googleapi_setttings->error_message. " Please make sure you have the \"Google Maps Geocoding API\" enabled and that the API key is entered properly and has no referer restrictions. You can check your key at the Google API console <a target=\"_blank\" href=\"https://console.cloud.google.com/apis/\">here</a></p>";
}
if (isset($google_maps_api_key) && $timezone_settings->status == "REQUEST_DENIED") {
    echo "<p>Your Google Maps API key came back with the following error. " .$timezone_setttings->error_message. " Please make sure you have the \"Google Time Zone API\" enabled and that the API key is entered properly and has no referer restrictions. You can check your key at the Google API console <a target=\"_blank\" href=\"https://console.cloud.google.com/apis/\">here</a></p>";
}

else if ($timezone_settings->status == "OK" && $googleapi_setttings->status == "OK") {
    echo "Your Google API key seems to be working fine! :)";
}
else {
    echo "Please enter your API Key as a query string, apikey-checker.php?key=API_KEY";
}

