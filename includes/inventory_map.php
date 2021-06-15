<!--
    Using LeafletJS to easily demonstrate a map with pins showing info - https://leafletjs.com/examples/quick-start/
-->

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>

 <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script src="../scripts/leaflet-indoor.js"></script>
<script src="../scripts/require.js"></script>

<div id="mapid"></div>


<script type="text/JavaScript">
    // Set the map coordinate
    var mymap = L.map('mapid').setView([40.703314,-74.064952], 19);

    // Set the tilemap to a custom dark style mapbox
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 22,
        minZoom: 18,
        id: 'seikoshadow/ckpn1mfen029e17nzk9ix7ekb',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'pk.eyJ1Ijoic2Vpa29zaGFkb3ciLCJhIjoiY2twbjFqdHV4MDd5ZTJ2bnV1a3I4dTJ1NSJ9.qP6H4wPGBl8VAu-MBfIkiw'
    }).addTo(mymap);


    $.getJSON("../assets/indoor_map_tiles.json", function(geoJSON) {
        var indoorLayer = new L.geoJSON(geoJSON).addTo(mymap);
    });

    <?php foreach($gateways as $gateway) {
        
    } ?>

</script>