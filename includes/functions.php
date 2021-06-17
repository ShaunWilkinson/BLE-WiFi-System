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

    # Function to calculate rough distance to beacon - https://developer.radiusnetworks.com/2014/12/04/fundamentals-of-beacon-ranging.html
    function calculateDistance($txPower, $rssi) {

        if ($rssi == 0) {
            return -1.0; // if we cannot determine distance, return -1.
        }
    
        $ratio = $rssi * 1.0 / $txPower;
    
        if ($ratio < 1.0) {
            return pow($ratio, 10);
        } else {
            $accuracy = (0.89976) * pow($ratio, 7.7095) + 0.111;
            return $accuracy;
        }
    }


    /**
     * Calculates the x,y coordinate of an object given 3 points and radius's
     * $point should be [x, y, radius]
     */
    function trilaterate($point1, $point2, $point3) {

        $A = (2*$point2[0]) - (2*$point1[0]);
        $B = (2*$point2[1]) - (2*$point1[1]);
        $C = pow($point1[2],2) - pow($point2[2],2) - pow($point1[0],2) + pow($point2[0],2) - pow($point1[1],2) + pow($point2[1],2);
        $D = (2*$point3[0]) - (2*$point2[0]);
        $E = (2*$point3[1]) - (2*$point2[1]);
        $F = pow($point2[2],2) - pow($point3[2],2) - pow($point2[0],2) + pow($point3[0],2) - pow($point2[1],2) + pow($point3[1],2);

        $x = (($C*$E) - ($F*$B)) / (($E*$A) - ($B*$D));
        $y = (($C*$D) - ($A*$F)) / (($B*$D - $A*$E));

        return [round($x, 2), round($y,2)];
    }
?>