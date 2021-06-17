<?php
    include "./includes/functions.php";
    
    class gateway {}

    $db = DB::getInstance();
    $gateways = []; # Holds all the gateway data, Name + Location

    # Ensure that there is a connection to the database
    if(!$db) {
        echo $db -> lastErrorMsg();
    } else {

        # Return all gateway data
        $sqlQuery = "SELECT * FROM gateway_location";
        $data = $db -> query($sqlQuery);

        # For each row add the data to the gateways array
        while($row = $data -> fetchArray(SQLITE3_ASSOC)) {
            $coord = $row['x_coord'] . "," . $row['y_coord'];
            $gateways += [$row['gateway'] => $coord];
        }

        # Get the coordinate limits of the given map area
        $geographyLimits = [];
        $json = json_decode(file_get_contents("assets/indoor_map_tiles.json"), true);
        $geoData = $json['features'][0]['geometry']['coordinates'][0];

        $lowestX = $lowestY = 9999;
        $highestX = $highestY = -9999; # Instantiate the variables

        foreach($geoData as $coordinate) {
            if($coordinate[0] > $highestX)
                $highestX = $coordinate[0];

            if($coordinate[0] < $lowestX)
                $lowestX = $coordinate[0];

            if($coordinate[1] > $highestY) 
                $highestY = $coordinate[1];

            if($coordinate[1] < $lowestY)
                $lowestY = $coordinate[1];
        }

        # Get each gateway
        # get the last record for the selected tag for each gateway name

        # If there is a selected asset
        if(!empty($_POST['selectedAsset'])) {
            $points = [];

            # Loop through each gateway
            foreach($gateways as $name => $coord) {
                # Return the last result from each gateway for the selected asset
                $query = "SELECT * FROM tag_data WHERE gateway == '{$name}' AND tagMac == '{$_POST['selectedAsset']}' ORDER BY submitTime DESC LIMIT 1";
                $data = $db->query($query);

                # Get the last RSSI value from each gateway to the tag
                while ($row = $data->fetchArray()) {
                    # For each gateway, calculate the radius of the circle
                    $radius = calculateDistance(-60, $row['value']);

                    # Populate the points array with the x, y & radius of each point
                    $coords = explode(",", $coord);
                    array_push($points, [$coords[0], $coords[1], $radius]);

                    console_log($name . ", " . $row['value'] . ", " . calculateDistance(-60, $row['value']));
                    #Store the x, y and radius for each point
                    #Select the 3 points with lowest radius
                    #pass the 3 points to a function to calculate point
                }
            }

            # Sort the points array by the smallest radius to the largest
            usort($points, function($a, $b) {
                $a_val = (float) $a[2];
                $b_val = (float) $b[2];

                if ($a_val >= $b_val) return 1;
                else return -1;
            });


            if(sizeof($points) >= 3) {
                $estimatedCoordinate = trilaterate($points[0], $points[1], $points[2]);
                console_log("Estimated coordinate: " . implode(", ", $estimatedCoordinate));

            } else {
                console_log("Not enough points to accurately calculate");
            }
        }

    }
?>

<?php include("includes/a_config.php");?>
<!DOCTYPE html>
<html>
    <head>
        <?php include("includes/head-tag-contents.php");?>
    </head>
    <body>
        <?php include("includes/navbar.php");?>

        <div class="container d-flex flex-column" id="main-content">
            <h1>Inventory Map</h2>
            <p>This page shows the warehouse area used to demonstrate the tracking technology. In a real environment it would likely be best to have a more detailed grid with increased zoom levels to accurately show individual assets.</p>
            <hr style="width:75%">
            
            <?php if(!empty($estimatedCoordinate)) { ?>
                <p>The selected asset is currently located at coordinate <?php echo implode(", ", $estimatedCoordinate); ?></p>
            <?php } ?>

            <hr style="width:75%">
            <?php include("includes/inventory_map.php");?>
            <?php include("includes/inventory_map2.php");?>
            <?php include("includes/asset_list_dropdown.php");?>

            <?php if(!empty($_POST['selectedAsset'])) { ?>
                <p>You selected <?php echo $_POST['selectedAsset']; ?></p>
            <?php } ?>
        </div>

        <?php include("includes/footer.php");?>
    </body>
</html>