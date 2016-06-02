<?php



class Settings {

	static $kalakaar_app;

    static $sms_api_key;

    static $sms_endpoint;

	public static function setEnv($environment) {

		if ($environment == 'PROD') {

            self::$sms_api_key = "58221A5WffIlH4D5305851a";

            self::$sms_endpoint = "https://control.msg91.com/api/sendhttp.php";

            self::$kalakaar_app = array(

                'host'  => 'localhost',

                'user'  => 'tipstatw_kalakaa',

                'pass'  => 'hLKJwTlXU{rS',

                'name'  => 'tipstatw_kalakaar',

            );

        } else {

            self::$sms_api_key = "";

            self::$sms_endpoint = "https://control.msg91.com/api/sendhttp.php";

            self::$kalakaar_app = array(

                'host'  => 'localhost',

                'user'  => 'root',

                'pass'  => '',

                'name'  => 'kalakaar',

            );

        }

	}	

}