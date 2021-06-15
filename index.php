<?php
    include "./includes/functions.php";
    
    class gateway {}

    $db = DB::getInstance();
    $gateways = array(); # Holds all the gateway data, Name + Location

    # Ensure that there is a connection to the database
    if(!$db) {
        echo $db -> lastErrorMsg();
    } else {

        # Return all gateway data
        $sqlQuery = "SELECT * FROM gateway_location";
        $data = $db -> query($sqlQuery);

        # For each row add the data to the gateways array
        while($row = $data -> fetchArray(SQLITE3_ASSOC)) {
            $gateway = new gateway;
            $gateway -> name = $row['gateway'];
            $gateway -> x = $row['x_coord'];
            $gateway -> y = $row['y_coord'];

            array_push($gateways, $gateway);
        }

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

            <?php include("includes/inventory_map.php");?>
            <?php include("includes/asset_list_dropdown.php");?>

            <?php if($_POST['selectedAsset']) { ?>
                <p>You selected <?php echo $_POST['selectedAsset']; ?></p>
            <?php } ?>
        </div>

        <?php include("includes/footer.php");?>
    </body>
</html>