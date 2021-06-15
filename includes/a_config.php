<?php
	switch ($_SERVER["SCRIPT_NAME"]) {
		case "/php-template/about.php":
			$CURRENT_PAGE = "About"; 
			$PAGE_TITLE = "About Us";
			break;
		default:
			$CURRENT_PAGE = "Index";
			$PAGE_TITLE = "Home";
			break;
	}
?>