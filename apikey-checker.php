<?php
$google_maps_api_key = $_GET['key'];
$googleapi_settings = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?key=" . trim($google_maps_api_key) . "&address=91409"));
$timezone_settings = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/timezone/json?key=" . trim($google_maps_api_key) . "&location=34.2011137,-118.475058&timestamp=" . time())); ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Google API Key Checker</title>
</head>
<body>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo trim($google_maps_api_key) ?>&callback=initMap"></script>

<?php
if (isset($google_maps_api_key) && $googleapi_settings->status == "REQUEST_DENIED") {
    echo "<p>Your Google Maps API key came back with the following error. " .$googleapi_settings->error_message. " Please make sure you have the \"Google Maps Geocoding API\" enabled and that the API key is entered properly and has no referer restrictions. You can check your key at the Google API console <a target=\"_blank\" href=\"https://console.cloud.google.com/apis/\">here</a></p>";
}

if (isset($google_maps_api_key) && $timezone_settings->status == "REQUEST_DENIED") {
    echo "<p>Your Google Maps API key came back with the following error. " .$timezone_settings->errorMessage. " Please make sure you have the \"Google Time Zone API\" enabled and that the API key is entered properly and has no referer restrictions. You can check your key at the Google API console <a target=\"_blank\" href=\"https://console.cloud.google.com/apis/\">here</a></p>";
}

else if ($timezone_settings->status == "OK" && $googleapi_settings->status == "OK") {
    echo "Your Google Key for Geocoding and Time Zone API seems to be working fine! :)";
}

else if (empty($google_maps_api_key)) {
    echo "Please enter your API Key as a query string, apikey-checker.php?key=API_KEY";
}
?>
<?php if (!empty($google_maps_api_key)) { ?>
<script>
    function initMap() {
        apiNoError = document.getElementById('statusBad');
        apiNoError.style.display = "none";
        apiGood = document.getElementById('statusGood');
        apiGood.style.display = "block";
        var map;
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 18,
            center: { lat: 34.2359494, lng: -118.563701 }
        });

        if (typeof console  != "undefined")
            if (typeof console.log != 'undefined')
                console.olog = console.log;
            else
                console.olog = function() {};
        console.log = function(message) {
            console.olog(message);
            document.getElementById('debugDiv').innerHTML += ('<p>' + message + '</p>');
        };
        console.error = console.debug = console.info =  console.log
    }
    function gm_authFailure() {
        var maper = document.getElementById('map');
        maper.style.display = "none";
        apiError = document.getElementById('statusBad');
        apiError.style.display = "block";
        apiGood = document.getElementById('statusGood');
        apiGood.style.display = "none";
    }
</script>
<div id="statusBad">Google Maps JavaScript API warning: Invalid Key or Javascript API Not Enabled.</div>
<div id="statusGood">Your Google Key for Javascript Maps API seems to be working fine! :)</div>
<div id="map" style="height: 300px; width: 400px;"></div>
<div id="debugDiv"></div>
<?php } ?>
</body>
</html>
