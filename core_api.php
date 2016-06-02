<?php







/**

 * CORE API

 * 

 * Predefined important or common api process will go here

 * Do not change anything in here. We need to discuss before changing any process here

 * All new methods should be on the kalakaar_api_call.php.

 * 

 * @author: bcorpuzjr

 **/ 



class Core_api {

	protected $db_credentials = array();

	protected $responses = array();

	protected $env = "PROD"; // PROD || DEV

	protected $return_mode;

	protected $default_response_mode = "json";

    protected $api_log_id;
    protected $api_key = "";



	protected function __construct() {

		$this->instance = $this;

		$this->load_libraries();

		$this->initialize_values();



        if (!$this->db_check()) {

            return $this->failed("DATABASE_ERROR");

        }



        // added quickly to get logs from testing api

        $api_logs = array(

            "request" => json_encode($_POST),

            "file_request" => json_encode($_FILES),

        );



        $this->api_log_id = $this->db->insert("api_logs", 'ss', $api_logs, TRUE);

	}







	protected function initialize_values() {

		$this->return_mode = $this->default_response_mode;



        // Common error response

		$this->responses = array(

            "UNKNOWN_ERROR"             => array("1", "Unknown error"),

            "DATABASE_ERROR"            => array("2", "Unable to load database"),

            "INVALID_PARAMETER_COUNT"   => array("3", "Invalid parameter count"),

            "INVALID_PARAMETER_VALUE"   => array("4", "Invalid parameter values"),

            "INVALID_METHOD"            => array("5", "Invalid method name"),

            "ERROR_SAVING"              => array("6", "Error saving information"),

        );



        settings::setEnv($this->env);



		$this->db_credentials = array(

            "host"      => settings::$kalakaar_app['host'],

            "user"      => settings::$kalakaar_app['user'],

            "password"  => settings::$kalakaar_app['pass'],

            "db"        => settings::$kalakaar_app['name'],

        );

	}





	protected function success($responsemsg, $additional_response = array()) {

        $data = array();

        if (!is_null($responsemsg)) {

            $data['respmsg'] = $responsemsg;

        }



        if(count($additional_response) > 0)

            $data = array_merge($data, $additional_response);



        $data['respcode']  = "0000";

        // $data['status'] = "success";

        $this->json_generator($data);

        return TRUE;

    }







	protected function failed($error_code = 1) {

        if (is_array($error_code)) {

            $data = array(

                "respmsg"   => $error_code[1],

                "respcode"  => $error_code[0] == ""? "1000": $error_code[0],

            );

        } else {

            if (!isset($this->responses[$error_code])) {

                $data = array(

                    "respmsg"   => $error_code,

                    "respcode"  => "1000",

                );

            } else {

                $data = array(

                    "respmsg"   => $this->responses[$error_code][1],

                    "respcode"  => $this->responses[$error_code][0],

                );

            }

        }



        $data['respcode'] =  str_pad($data['respcode'], 3, '0', STR_PAD_LEFT);

        // $data['status'] = 'failed';

        $this->json_generator($data);

        return FALSE;

    }



	public function db_check() {

		if (isset($this->db_credentials) && is_array($this->db_credentials)) {

            $this->db = db::getInstance($this->db_credentials);

            if ($this->db->getStatus() == 0) {

                return FALSE;

            }

        } else {

            return FALSE;

        }



        return TRUE;

	}



    // CAN BE CHANGE TO SUPPORT OTHER RETURN TYPE

	protected function json_generator($array_data, $numerical_tag = 'Record') {

        if ($this->return_mode == "json") {

            $output = json_encode($array_data);

            header('Content-type: application/json');

        }



        // $this->logs['output_response'] = $output;

        $this->write_logs($output);

        echo $output;

    } 



    // WRITE all API LOGS.

	public function write_logs($output) {

        $log_data = array(

            $output,

            $this->api_log_id,

        );



        $this->db->update("UPDATE api_logs SET response=? WHERE id=?", "si", $log_data);

		return 1;

	}



	public function load_libraries() {

		define('BASEPATH', dirname(__FILE__));

        $lib_path = __DIR__."/libraries/";

        set_include_path(get_include_path() . PATH_SEPARATOR . "." . PATH_SEPARATOR . $lib_path);

        require_once 'db.php';

        require_once 'settings.php';

	}



    public function execute() {
        if(isset($_GET['method'])) {
            $method = strtolower($_GET['method']);
            if (method_exists($this->instance, $method)) {
                $this->method = $method;
                if($_POST['api_key'])
                    $this->api_key = $_POST['api_key'];

                if(isset($_POST['json_data']))
                    $_POST = json_decode($_POST['json_data'], TRUE);

                if($this->api_key != "")
                    $_POST['api_key'] = $this->api_key;

                $this->$method();
                return TRUE;
            }
            return $this->failed("INVALID_METHOD");
        } else {
            return $this->failed("GET METHOD REQUIRED");
        }
    }

}