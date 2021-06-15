<form id="asset_dropdown" name="asset_list" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    Selected Asset: 
    <select name='selectedAsset'>
        <option value="">--- Select ---</option>
        <?php
            if($db) {
                # Return all gateway data
                $assetSQLQuery = "SELECT DISTINCT tagMac FROM tag_data";
                $listData = $db -> query($assetSQLQuery);

                while($row = $listData -> fetchArray(SQLITE3_ASSOC)) { ?>
                    <option value="<?php echo $row['tagMac']; ?>">
                        <?php echo $row['tagMac'] ?>
                    </option> 
            <?php 
                }
            }
            ?>
    </select>
    <input type="submit" name="Submit" value="Select" />
</form>




