<?php
    // singleton that returns a DB connection
    class DB extends SQLite3 {
        private static $instance = null;

        private function __construct() {
            $this -> open('/home/pi/Python/location_data.db');
        }

        public static function getInstance() {
            if (self::$instance == null) {
                self::$instance = new DB();
            }

            return self::$instance;
        }
    }

    function console_log($output, $with_script_tags = true) {
        $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
        if ($with_script_tags) {
            $js_code = '<script>' . $js_code . '</script>';
        }
        echo $js_code;
    }
?>