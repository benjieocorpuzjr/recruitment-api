<?php

/**
 * ADMIN API
 * 
 * ADMIN API description
 * 
 * @author: bcorpuzjr
 **/ 

require_once './core_api.php';

class kalakaar_admin_api extends core_api {
	private $backend;

	public function __construct() {
        parent::__construct();
        require_once './libraries/backend.php';
        $this->backend = new backend($this->db);

        // LOGS WILL SOON BE REMOVE IN HERE. IT SHOULD BE ON THE CORE I JUST ADDED THIS FOR TESTING PURPOSES - bcorpuzjr
        // $api_logs = array(
        //     "request" => json_encode($_POST),
        //     "file_request" => json_encode($_FILES),
        // );

        // $this->db->insert("api_logs", 'ss', $api_logs);
    }

}

$instance = new kalakaar_admin_api();
$instance->execute();