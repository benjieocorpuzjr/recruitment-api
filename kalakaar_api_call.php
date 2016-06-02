<?php

/**
 * Main API
 * 
 * Main API description
 * If a new api controller is needed you can extend the core_api. but take note that te endpoint url will differ.
 * 
 * @author: bcorpuzjr
 **/ 

require_once './core_api.php';
class kalakaar_api_call extends core_api {
	private $backend;
    private $for_cpa_api = array(3, 4, 5);
    private $for_am_api = array(1, 2);

	public function __construct() {
        parent::__construct();
        require_once './libraries/backend.php';
        $this->backend = new backend($this->db, $this->env);
    }

    /**
     * Call on Sample table
     *
     * @api {post} test_call Test call on sample table
     * @apiGroup Test
     *
     * @apiParam {String} samp_name write "samp" for multiple return, write "First Data" for single return.
     *
     * @apiSuccess {String} respmsg Success Response Message.
     * @apiSuccess {String} respcode  Response code 0000 for successful transaction.
     * @apiSuccess {String} result  JSON data response.
     *
     * @apiSuccessExample Success-Response:
     *     {"respmsg":"Sample user successfully retrieved","result":[{"id":1,"samp_name":"samp","samp":"query"},{"id":2,"samp_name":"samp","samp":"query"}],"respcode":"0000"}
     *
     * @apiError respmsg Error Response Message.
     * @apiError respcode respcode Response code.
     *
     * @apiErrorExample Error-Response:
     *     {
     *       "respmsg":"Invalid parameter values",
     *       "respcode":"004",
     *     }
     */
    protected function test_call() {
        if(!isset($_POST['samp_name']) || empty($_POST['samp_name'])) {
            return $this->failed("INVALID_PARAMETER_VALUE");
        }

        $result = $this->backend->test_select($_POST);
        if($result) {
            return $this->success('Sample user successfully retrieved', array('result' => $result));
        } else {
            return $this->failed("Sample user does not exist");
        }
    }

    /**
     * Boolean true response
     *
     * @api {post} test_true_resp Boolean success response
     * @apiGroup Test
     *
     *
     * @apiSuccess {String} respmsg Success Response Message.
     * @apiSuccess {String} respcode Response code 0000 for successful transaction.
     *
     * @apiSuccessExample Success-Response:
     *     {"respmsg":"Sample successful response","respcode":"0000"}
     *
     */
    protected function test_true_resp() {
        return $this->success("Sample successful response");
    }

    /**
     * Boolean false response
     *
     * @api {post} test_false_resp Boolean failed response
     * @apiGroup Test
     *
     *
     * @apiSuccess {String} respmsg Success Response Message.
     * @apiSuccess {String} respcode Response code 0000 for successful transaction.
     *
     * @apiErrorExample Error-Response:
     *     {"respmsg":"Sample failed response","respcode":"1000"}
     *
     */
    protected function test_false_resp() {
        return $this->failed("Sample failed response");
    }

    /**
     * Save multiple data
     *
     * @api {post} test_multi_data Save multiple data request
     * @apiGroup Test
     *
     * @apiParam {String} education array of education sub-parameters: institute, state, school_details.
     * @apiParam {String} multi_data_id this will serve as an ID will be the actor_id in our system.
     *
     * @apiSuccess {String} respmsg Success Response Message.
     * @apiSuccess {String} respcode  Response code 0000 for successful transaction.
     *
     * @apiSuccessExample Success-Response:
     *     {"respmsg":"Inserted all data successfully","respcode":"0000"}
     *
     * @apiError respmsg Error Response Message.
     * @apiError respcode respcode  Response code.
     *
     * @apiErrorExample Error-Response:
     *     {
     *       "respmsg":"Invalid parameter values",
     *       "respcode":"004",
     *     }
     */
    protected function test_multi_data() {
        if(!isset($_POST['education']) || count($_POST['education']) == 0 || !isset($_POST['multi_data_id']) || empty($_POST['multi_data_id'])) {
            return $this->failed("INVALID_PARAMETER_VALUE");
        }

        if($this->backend->test_multiple_insert($_POST, $_POST['multi_data_id'])) {
            return $this->success("Inserted all data successfully");
        } else {
            return $this->failed("Sample user does not exist");
        }
    }

    /**
     * GET Multiple data
     *
     * @api {post} test_get_multi_data GET Multiple data
     * @apiGroup Test
     *
     * @apiParam {String} multi_data_id to retrieve list of data inserted using the previous method.
     *
     * @apiSuccess {String} respmsg Success Response Message.
     * @apiSuccess {String} respcode  Response code 0000 for successful transaction.
     *
     * @apiSuccessExample Success-Response:
     *     {"respmsg":"Successfully get all data","results":[{"id":1,"d_actor_id":1,"state":"sample state","institute":"Sample institute","school_description":"School was blah blah blah"}],"respcode":"0000"}
     *
     * @apiError respmsg Error Response Message.
     * @apiError respcode respcode  Response code.
     *
     * @apiErrorExample Error-Response:
     *     {
     *       "respmsg":"Invalid parameter values",
     *       "respcode":"004",
     *     }
     */
    protected function test_get_multi_data() {
        if(!isset($_POST['multi_data_id']) || empty($_POST['multi_data_id'])) {
            return $this->failed("INVALID_PARAMETER_VALUE");
        }

        $results = $this->backend->test_get_data($_POST);
        if($results) {
            return $this->success("Successfully get all data", array("results" => $results));
        } else {
            return $this->failed("Sample user does not exist");
        }
    }

    /**
     * Save multiple images
     *
     * @api {post} test_multi_images Save multiple images
     * @apiGroup Test
     *
     * @apiParam {String} actor_image_id to retrieve list of data inserted using the previous method.
     * @apiParam {String} actor_image_* File of image, just continue adding number on actor_image_* and fileName_* if more images are needed to be uploaded..
     * @apiParam {String} fileName_* Filename of image, just continue adding number on actor_image_* and fileName_* if more images are needed to be uploaded..
     *
     * @apiSuccess {String} respmsg Success Response Message.
     * @apiSuccess {String} respcode  Response code 0000 for successful transaction.
     *
     * @apiSuccessExample Success-Response:
     *     {"respmsg":"Image successfully saved","respcode":"0000"}
     *
     * @apiError respmsg Error Response Message.
     * @apiError respcode respcode  Response code.
     *
     * @apiErrorExample Error-Response:
     *     {
     *       "respmsg":"Error saving image",
     *       "respcode":"1000",
     *     }
     */
    protected function test_multi_images() {
        if($_FILES && count($_FILES) > 0) {
            $actor_id = $_POST['actor_image_id'];
            $path = realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR;

            for($i=1;$i<=count($_FILES);$i++) {
                $pcs = explode('.', $_POST['fileName_'.$i]);
                $ext = strtolower(end($pcs));
                $file_name = "samples.".$i."-".date('Ymd-His').".".$ext;
                if(move_uploaded_file($_FILES['actor_image_'.$i]['tmp_name'], $path.$file_name)) {
                    $arr = array("d_actor_id" => $actor_id, "path_file" => $path.$file_name, "filename" => $file_name);
                    $this->db->insert("dummy_actor_images", 'iss', $arr);
                    $this->success('Image successfully saved');
                } else {
                    $this->failed('Error saving image');
                }
            }
        }
    }

    protected function send_multiple_image_test() {
        if(!isset($_POST['name'], $_POST['gender'], $_POST['uploader'], $_POST['location'])  
            || empty($_POST['name']) || empty($_POST['gender']) || empty($_POST['uploader']) || empty($_POST['location'])
            // || count($_FILES) == 0 
            ) {
            return $this->failed("INVALID_PARAMETER_VALUE");
        }
        
        if($this->backend->save_dummy_actor_other_info($_POST, $_FILES)) {
            return $this->success("Successfully signed up, you can now use the application");
        } else {
            return $this->failed("Error signing up");
        }

        // exit();
        if($_FILES) {
            $path = realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR;

            // $path = 'id_upload'.DIRECTORY_SEPARATOR;
            // if(!is_dir($path)) {
            //     mkdir($path);
            // }
            for($i=1;$i<=count($_FILES);$i++) {
                $pcs = explode('.', $_POST['fileName_'.$i]);
                $ext = strtolower(end($pcs));
                $file_name = "samples.".$i."-".date('Ymd-His').".".$ext;
                if(move_uploaded_file($_FILES['actor_image_'.$i]['tmp_name'], $path.$file_name)) {
                    $this->db->insert("");
                    $this->success('Image successfully saved');
                } else {
                    $this->failed('Error saving image');
                }
            }
        }
    }

    /**
     * User Signup
     *
     * @api {post} user_initial_signup 1. User Signup
     * @apiGroup User
     *
     * @apiParam {String} email Users email address.
     * @apiParam {Number} phone Users phone number.
     * @apiParam {String} password Users Password.
     * @apiParam {Number} user_type User type ID.
     *
     * @apiSuccess {String} respmsg Success Response Message.
     * @apiSuccess {String} respcode  Response code 0000 for successful transaction.
     * @apiSuccess {String} pass_key  Needed to access verify_otp method.
     *
     * @apiSuccessExample Success-Response:
     *     { "respmsg":"User successfully signed up", 
     *       "pass_key":"+4Xr3J1DXqYJZBpGg2\/Jr\/WL\/pIfzVDhSI2+6sBhdFtf5xIQHe6tHyZc\/xrE0nlG",
     *       "respcode":"0000",
     *       "status":"success"}
     *
     * @apiError respmsg Error Response Message.
     * @apiError respcode respcode  Response code.
     *
     * @apiErrorExample Error-Response:
     *     {
     *       "respmsg":"Invalid parameter values",
     *       "respcode":"004",
     *     }
     */

    protected function user_initial_signup() {
        if(!isset($_POST['email'], $_POST['phone'], $_POST['password'], $_POST['user_type']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['password']) || empty($_POST['user_type'])) {
            return $this->failed("INVALID_PARAMETER_VALUE");
        }

        if($this->backend->check_if_user_exist($_POST)) {
            return $this->failed("User already exist");
        }

        $initial_info = $this->backend->initial_signup($_POST);
        if($initial_info) {
            return $this->success("User successfully signed up", array("pass_key" => $initial_info['pass_key']));
        } else {
            return $this->failed("ERROR_SAVING");
        }
    }

    /**
     * RESEND OTP (SIGNUP)
     *
     * @api {post} signup_password_resend_otp 2. Resend OTP (Signup)
     * @apiGroup User
     *
     * @apiParam {String} pass_key Return from the method "User Signup".
     *
     * @apiSuccess {String} respmsg Success Response Message.
     * @apiSuccess {String} respcode  Response code 0000 for successful transaction.
     *
     * @apiSuccessExample Success-Response:
     *     { "respmsg":"Successfully resend OTP",
     *       "respcode":"0000"}
     *
     * @apiError respmsg Error Response Message.
     * @apiError respcode respcode  Response code.
     *
     * @apiErrorExample Error-Response:
     *     {
     *       "respmsg":"Invalid key",
     *       "respcode":"1000",
     *     }
     */

    protected function signup_password_resend_otp() {
        if(!isset($_POST['pass_key']) || empty($_POST['pass_key'])) {
            return $this->failed("INVALID_PARAMETER_VALUE");
        }

        $status = $this->backend->reset_resend_otp($_POST['pass_key']);
        if($status) {
            return $this->success("Successfully resend OTP");
        } else {
            return $this->failed("Invalid key");
        }
    }

    /**
     * VERIFY OTP FROM SIGNUP
     *
     * @api {post} verify_otp 3. Verify OTP (Signup)
     * @apiGroup User
     *
     * @apiParam {String} otp Users OTP.
     * @apiParam {String} pass_key Pass key sent from user_initial_signup method.
     *
     * @apiSuccess {String} respmsg Success Response Message.
     * @apiSuccess {String} respcode  Response code 0000 for successful transaction.
     * @apiSuccess {String} api_key  User's API key that will be used on all method calls.
     *
     * @apiSuccessExample Success-Response:
     *     { "respmsg":"OTP Successfully verified",
     *       "api_key":"Dbx3nsT8coE3QyUe6NBePoYTOxgF3AEn96bDcwg3y1eaeb238aJkOOGuZSHMrk9c",
     *       "respcode":"0000"}
     *
     * @apiError respmsg Error Response Message.
     * @apiError respcode respcode  Response code.
     *
     * @apiErrorExample Error-Response:
     *     {
     *       "respmsg":"Invalid Key",
     *       "respcode":"1000",
     *     }
     */

    protected function verify_otp() {
        if(!isset($_POST['otp'], $_POST['pass_key']) || empty($_POST['otp']) || empty($_POST['pass_key'])) {
            return $this->failed("INVALID_PARAMETER_VALUE");
        }

        $api_key = $this->backend->verify_otp($_POST);
        if($api_key) {
            return $this->success("OTP Successfully verified", array("api_key" => $api_key, "user_type" => $user_type));
        } else {
            return $this->failed("Invalid Key");
        }
    }



    /**
     * SIGNUP OTHER INFO
     *
     * @aapi {paost} signup_other_info SIGNUP OTHER INFO
     * @apiGroaup User
     *
     * @apiPaaram {String} otp Users OTP.
     * @apiPaaram {String} pass_key Pass key sent from user_initial_signup method.
     *
     * @apiSucacess {String} respmsg Success Response Message.
     * @apiSuccaess {String} respcode  Response code 0000 for successful transaction.
     * @apiSucceass {String} api_key  User's API key that will be used on all method calls.
     *a
     * @apiSuccessExample Success-Response:
     *     { "respmsg":"OTP Successfully verified",
     *       "api_key":"Dbx3nsT8coE3QyUe6NBePoYTOxgF3AEn96bDcwg3y1eaeb238aJkOOGuZSHMrk9c",
     *       "respcode":"0000"}
     *
     * @apiError respmsg Error Response Message.
     * @apiError respcode respcode  Response code.
     *
     * @apiErrorExample Error-Response:
     *     {
     *       "respmsg":"Invalid Key",
     *       "respcode":"1000",
     *     }
     */

    protected function signup_other_info() {
        if(!isset($_POST['alt_contact'], $_POST['location'], $_POST['api_key']) || empty($_POST['alt_contact']) || empty($_POST['location']) || empty($_POST['api_key'])) {
            return $this->failed("INVALID_PARAMETER_VALUE");
        }

        $user_info = $this->backend->get_user_info_using_api_key($_POST['api_key'], TRUE);
        if(!$user_info) {
            return $this->failed("User does not exist");
        }

        $method = $user_info['function']."signup_other_info";
        $this->$method($user_info['id']);
        exit();
    }

    private function cpa_signup_other_info($user_id = 0) {
        if(!isset($_POST['name']) || count($_FILES) == 0 || $user_id == 0) {
            return $this->failed("INVALID_PARAMETER_VALUE");
        }

        if($this->backend->save_cpa_other_info($_POST, $user_id)) {
            return $this->success("Successfully signed up, you can now use the application");
        } else {
            return $this->failed("Error signing up");
        }
    }

    private function actor_signup_other_info($user_id = 0) {
        if(!isset($_POST['name'], $_POST['gender'], $_POST['age'], $_POST['self_description'], $_POST['body_type'], $_POST['ethnicity'], $_POST['hair_color'], $_POST['hair_length'],
            $_POST['eye_color'], $_POST['skin_tone'], $_POST['facial_hair'], $_POST['height'], $_POST['weight'], $_POST['shoe_size'], $_POST['waist_size'], $_POST['chest_size'])  
            || empty($_POST['name']) || empty($_POST['gender']) || empty($_POST['age']) || empty($_POST['self_description']) || empty($_POST['body_type']) || empty($_POST['ethnicity']) || empty($_POST['hair_color']) || empty($_POST['hair_length'])
            || empty($_POST['eye_color']) || empty($_POST['skin_tone']) || empty($_POST['facial_hair']) || empty($_POST['height']) || empty($_POST['weight']) || empty($_POST['shoe_size']) || empty($_POST['waist_size']) || empty($_POST['chest_size'])
            // || count($_FILES) == 0 
            || $user_id == 0) {
            return $this->failed("INVALID_PARAMETER_VALUE");
        }

        if($this->backend->save_actor_other_info($_POST, $_FILES, $user_id)) {
            return $this->success("Successfully signed up, you can now use the application");
        } else {
            return $this->failed("Error signing up");
        }
    }

    /**
     * USER LOGIN
     *
     * @api {post} user_login 1. USER LOGIN
     * @apiGroup Login
     *
     * @apiParam {String} username Username can either be an email or phone.
     * @apiParam {String} password Password.
     *
     * @apiSuccess {String} respmsg Success Response Message.
     * @apiSuccess {String} respcode  Response code 0000 for successful transaction.
     * @apiSuccess {String} api_key  User's API key that will be used on all method calls.
     *
     * @apiSuccessExample Success-Response:
     *     { "respmsg":"Successfully logged in",
     *       "api_key":"Dbx3nsT8coE3QyUe6NBePoYTOxgF3AEn96bDcwg3y1eaeb238aJkOOGuZSHMrk9c",
     *       "respcode":"0000"}
     *  
     * @apiError respmsg Error Response Message.
     * @apiError respcode respcode  Response code.
     *
     * @apiErrorExample Error-Response:
     *     {
     *       "respmsg":"Invalid login",
     *       "respcode":"1000",
     *     }
     */
    protected function user_login() {
        if(!isset($_POST['username'], $_POST['password']) || empty($_POST['username']) || empty($_POST['password'])) {
            return $this->failed("INVALID_PARAMETER_VALUE");
        }

        $column = $this->get_username_column($_POST['username']);
        $api_key = $this->backend->user_login($_POST, $column);
        if($api_key) {
            return $this->success("User Type Successfully retrieved", array("api_key" => $api_key, ));
        } else {
            return $this->failed("Invalid login");
        }
    }

    /**
     * RESET PASSWORD SEND OTP
     *
     * @api {post} reset_password_send_otp 1. Initial Reset Process
     * @apiGroup Reset
     *
     * @apiParam {String} username User's email or phone.
     *
     * @apiSuccess {String} respmsg Success Response Message.
     * @apiSuccess {String} respcode  Response code 0000 for successful transaction.
     * @apiSuccess {String} reset_key  Reset key to be used on other reset method.
     *
     * @apiSuccessExample Success-Response:
     *     { "respmsg":"Successfully reset password",
     *       "reset_key":"i4uceKw2zCeGPojJwLRZK09nmVO/VoWfXeHy9kFl/rR4/jIMAZ1MJZAGUiQyN3uP",
     *       "respcode":"0000"}
     *
     * @apiError respmsg Error Response Message.
     * @apiError respcode respcode  Response code.
     *
     * @apiErrorExample Error-Response:
     *     {
     *       "respmsg":"Invalid username",
     *       "respcode":"1000",
     *     }
     */

    protected function reset_password_send_otp() {
        if(!isset($_POST['username']) || empty($_POST['username'])) {
            return $this->failed("INVALID_PARAMETER_VALUE");
        }

        $column = $this->get_username_column($_POST['username']);
        $reset_key = $this->backend->reset_send_otp($_POST['username'], $column);
        if($reset_key) {
            return $this->success("Successfully sent an OTP", array("reset_key" => $reset_key));
        } else {
            return $this->failed("Invalid username");
        }
    }

    /**
     * RESEND OTP
     *
     * @api {post} reset_password_resend_otp 2. Resend reset OTP (Reset)
     * @apiGroup Reset
     *
     * @apiParam {String} reset_key User's email or phone.
     *
     * @apiSuccess {String} respmsg Success Response Message.
     * @apiSuccess {String} respcode  Response code 0000 for successful transaction.
     * @apiSuccess {String} reset_key  Reset key to be used on other reset method.
     *
     * @apiSuccessExample Success-Response:
     *     { "respmsg":"Successfully resend OTP",
     *       "respcode":"0000"}
     *
     * @apiError respmsg Error Response Message.
     * @apiError respcode respcode  Response code.
     *
     * @apiErrorExample Error-Response:
     *     {
     *       "respmsg":"Invalid key",
     *       "respcode":"1000",
     *     }
     */

    protected function reset_password_resend_otp() {
        if(!isset($_POST['reset_key']) || empty($_POST['reset_key'])) {
            return $this->failed("INVALID_PARAMETER_VALUE");
        }

        $status = $this->backend->reset_resend_otp($_POST['reset_key']);
        if($status) {
            return $this->success("Successfully resend OTP");
        } else {
            return $this->failed("Invalid key");
        }
    }

    /**
     * OTP VALIDATION FOR RESET
     *
     * @api {post} reset_otp_validation 3. Validate Reset OTP (Reset)
     * @apiGroup Reset
     *
     * @apiParam {String} reset_key reset key of the specified user.
     * @apiParam {String} otp user input one time password.
     *
     * @apiSuccess {String} respmsg Success Response Message.
     * @apiSuccess {String} respcode  Response code 0000 for successful transaction.
     * @apiSuccess {String} reset_key  Reset key to be used on other reset method.
     *
     * @apiSuccessExample Success-Response:
     *     { "respmsg":"Successfully created pass_reset_key",
     *       "respcode":"0000"}
     *
     * @apiError respmsg Error Response Message.
     * @apiError respcode respcode  Response code.
     *
     * @apiErrorExample Error-Response:
     *     {
     *       "respmsg":"Invalid reset key or otp",
     *       "respcode":"1000",
     *     }
     */

    protected function reset_otp_validation() {
        if(!isset($_POST['reset_key'], $_POST['otp']) || empty($_POST['reset_key']) || empty($_POST['otp'])) {
            return $this->failed("INVALID_PARAMETER_VALUE");
        }

        $reset_pw_key = $this->backend->reset_otp_validation($_POST);
        if($reset_pw_key) {
            return $this->success("Successfully created pass_reset_key", array("pass_reset_key" => $reset_pw_key));
        } else {
            return $this->failed("Invalid reset key or otp");
        }
    }

    /**
     * RESET PW UPDATE
     *
     * @api {post} reset_pw_update 4. Password update thru (Reset)
     * @apiGroup Reset
     *
     * @apiParam {String} pass_reset_key reset key of the specified user.
     * @apiParam {String} password user's new password.
     *
     * @apiSuccess {String} respmsg Success Response Message.
     * @apiSuccess {String} respcode  Response code 0000 for successful transaction.
     *
     * @apiSuccessExample Success-Response:
     *     { "respmsg":"Successfully changed password",
     *       "respcode":"0000"}
     *
     * @apiError respmsg Error Response Message.
     * @apiError respcode respcode  Response code.
     *
     * @apiErrorExample Error-Response:
     *     {
     *       "respmsg":"Invalid reset key or password is empty",
     *       "respcode":"1000",
     *     }
     */

    protected function reset_pw_update() {
        if(!isset($_POST['pass_reset_key'], $_POST['password']) || empty($_POST['pass_reset_key']) || empty($_POST['password'])) {
            return $this->failed("INVALID_PARAMETER_VALUE");
        }

        $status = $this->backend->reset_pw_update($_POST);
        if($status) {
            return $this->success("Successfully changed password");
        } else {
            return $this->failed("Invalid reset key or password is empty");
        }
    }

    /**
     * CREATE JOBS
     *
     * @aapi {post} jobs_create RESET PASSWORD UPDATE
     * @apaiGroup Login
     *
     * @apiPaaram {String} pass_reset_key reset key of the specified user.
     * @apiPaaram {String} password user's new password.
     *
     * @apiSuaccess {String} respmsg Success Response Message.
     * @apiSucacess {String} respcode  Response code 0000 for successful transaction.
     *a
     * a@apiSuccessExample Success-Response:
     *  a   { "respmsg":"Successfully changed password",
     *   a    "respcode":"0000"}
     *a
     * a@apiError respmsg Error Response Message.
     * @apiError respcode respcode  Response code.
     *a
     * a@apiErrorExample Error-Response:
     *  a   {
     *   a    "respmsg":"Invalid reset key or password is empty",
     *    a   "respcode":"1000",
     *     a}
     */

    protected function jobs_create() {
        if(!isset($_POST['alt_contact'], $_POST['location'], $_POST['api_key']) || empty($_POST['alt_contact']) || empty($_POST['location']) || empty($_POST['api_key'])) {
            return $this->failed("INVALID_PARAMETER_VALUE");
        }

        $user_info = $this->backend->checl($_POST['api_key'], TRUE);
        if(!$user_info) {
            return $this->failed("User does not exist");
        }

        $method = $user_info['function']."signup_other_info";
        $this->$method($user_info['id']);
        exit();
    }

    private function get_username_column($username) {
        $column = "phone";
        if(strpos($username, '@') !== FALSE) {
            $column = "email";
        }
        return $column;
    }

    /**
     * Get Usertype List
     * 
     * @api {post} get_user_type_list Get User Type List
     * @apiGroup Admin
     *
     *
     * @apiSuccess {String} respmsg Success Response Message.
     * @apiSuccess {String} respcode  Response code 0000 for successful transaction.
     *
     * @apiSuccessExample Success-Response:
     *     { "respmsg":"User Type Successfully retrieved",
     *       "user_type_list":[
     *              {"id":1,"user_type":"Actor","function":"actor_","description":null},
     *              {"id":2,"user_type":"Model","function":"actor_","description":null},
     *              {"id":3,"user_type":"Casting Director","function":"cpa_","description":null},
     *              {"id":4,"user_type":"Production House","function":"cpa_","description":null},
     *              {"id":5,"user_type":"Agency","function":"cpa_","description":null}
     *      ],
     *      "respcode":"0000",
     *      "status":"success"}
     */

    protected function get_user_type_list() {
        $result = $this->backend->get_user_type_list();
        if($result) {
            return $this->success("User Type Successfully retrieved", array("user_type_list" => $result));
        } else {
            return $this->failed("Invalid Key");
        }
    }

    /**
     * GET LATEST OPTION UPDATE
     *
     * @api {post} get_latest_option_update Get latest option update
     * @apiGroup Admin
     *
     * @apiParam {String} kalakaar_key Method to access the Admin API.
     *
     * @apiSuccess {String} respmsg Success Response Message.
     * @apiSuccess {String} respcode  Response code 0000 for successful transaction.
     *
     * @apiSuccessExample Success-Response:
     *     { "respmsg":"Successfully changed password",
     *       "update_notes":"Initial Update",
     *       "latest_date_update":"2016-04-28 15:13:16",
     *       "respcode":"0000"}
     *
     * @apiError respmsg Error Response Message.
     * @apiError respcode respcode  Response code.
     *
     * @apiErrorExample Error-Response:
     *     {
     *       "respmsg":"Unable to get latest update",
     *       "respcode":"1000",
     *     }
     */
    protected function get_latest_option_update() {
        $result = $this->backend->get_latest_option_update();
        if($result) {
            return $this->success("Latest date update Successfully retrieved", array("update_notes" => $result['update_notes'], "latest_date_update" => $result['latest_date_update']));
        } else {
            return $this->failed("Unable to get latest update");
        }
    }

    /**
     * GET ALL OPTIONS
     *
     * @api {post} kalakaar_admin_api Get all option list
     * @apiGroup Admin
     *
     * @apiParam {String} kalakaar_key Method to access the Admin API.
     *
     * @apiSuccess {String} respmsg Success Response Message.
     * @apiSuccess {String} respcode  Response code 0000 for successful transaction.
     *
     * @apiSuccessExample Success-Response:
     *     { "respmsg":"Get all options",
     *       "respcode":"0000"
     *       "opt_list":{
     *        "opt_body_type":[{"id":1,"body_type":"Thin","description":null},
     *        {"id":2,"body_type":"Athletic","description":null},
     *        {"id":3,"body_type":"Fat","description":null}],
     *        "opt_chest_size":false,"opt_ethnicity":false,
     *        "opt_eye_color":[{"id":1,"eye_color":"Brown"........}
     *
     * @apiError respmsg Error Response Message.
     * @apiError respcode respcode  Response code.
     *
     * @apiErrorExample Error-Response:
     *     {
     *       "respmsg":"Unable to get all options",
     *       "respcode":"1000",
     *     }
     */
    protected function get_all_options() {
        $result = $this->backend->get_all_options();
        if($result) {
            return $this->success("Get all options", array("opt_list" => $result));
        } else {
            return $this->failed("Unable to get all options");
        }
    }

    /**
     * GET ALL OPTIONS
     *
     * @api {post} actor_basic_info Actor basic info
     * @apiGroup Admin
     *
     * @apiParam {String} api_key Method to access the Admin API.
     * @apiParam {String} json_data array with parameters: user_id, age, gender
     *
     * @apiSuccess {String} respmsg Success Response Message.
     * @apiSuccess {String} respcode  Response code 0000 for successful transaction.
     *
     * @apiSuccessExample Success-Response:
     *     { "respmsg":"Successfully",
     *       "respcode":"0000"
     *       "}
     *
     * @apiError respmsg Error Response Message.
     * @apiError respcode respcode  Response code.
     *
     * @apiErrorExample Error-Response:
     *     {
     *       "respmsg":"Unable to get all options",
     *       "respcode":"1000",
     *     }
     */
    protected function actor_basic_info() {
        // if(!isset($_POST['email'], $_POST['phone'], $_POST['password'], $_POST['user_type']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['password']) || empty($_POST['user_type'])) {
        //  return $this->failed("INVALID_PARAMETER_VALUE");
        // }

        $user_info = $this->backend->get_user_info_using_api_key($_POST['api_key'], TRUE);
        if(!$user_info) {
            return $this->failed("User does not exist");
        }

        $initial_info = $this->backend->insert_on_actor_basic_info($_POST, $user_info['id']);
        if($initial_info) {
            return $this->success("Successfully saved");
        } else {
            return $this->failed("ERROR_SAVING");
        }
    }

    protected function actor_specification() {
        // if(!isset($_POST['email'], $_POST['phone'], $_POST['password'], $_POST['user_type']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['password']) || empty($_POST['user_type'])) {
        //  return $this->failed("INVALID_PARAMETER_VALUE");
        // }

        $user_info = $this->backend->get_user_info_using_api_key($_POST['api_key'], TRUE);
        if(!$user_info) {
            return $this->failed("User does not exist");
        }

        $initial_info = $this->backend->insert_on_actor_specification($_POST, $user_info['id']);
        if($initial_info) {
            return $this->success("Successfully saved");
        } else {
            return $this->failed("ERROR_SAVING");
        }
    }

    protected function actor_skills() {
        // if(!isset($_POST['email'], $_POST['phone'], $_POST['password'], $_POST['user_type']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['password']) || empty($_POST['user_type'])) {
        //  return $this->failed("INVALID_PARAMETER_VALUE");
        // }

        $user_info = $this->backend->get_user_info_using_api_key($_POST['api_key'], TRUE);
        if(!$user_info) {
            return $this->failed("User does not exist");
        }

        $initial_info = $this->backend->insert_on_actor_skills($_POST, $user_info['id']);
        if($initial_info) {
            return $this->success("Successfully saved");
        } else {
            return $this->failed("ERROR_SAVING");
        }
    }

    protected function actor_description() {
        // if(!isset($_POST['email'], $_POST['phone'], $_POST['password'], $_POST['user_type']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['password']) || empty($_POST['user_type'])) {
        //  return $this->failed("INVALID_PARAMETER_VALUE");
        // }

        $user_info = $this->backend->get_user_info_using_api_key($_POST['api_key'], TRUE);
        if(!$user_info) {
            return $this->failed("User does not exist");
        }

        $initial_info = $this->backend->insert_on_actor_description($_POST, $user_info['id']);
        if($initial_info) {
            return $this->success("Successfully saved");
        } else {
            return $this->failed("ERROR_SAVING");
        }
    }

    protected function actor_education() {
        // if(!isset($_POST['email'], $_POST['phone'], $_POST['password'], $_POST['user_type']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['password']) || empty($_POST['user_type'])) {
        //  return $this->failed("INVALID_PARAMETER_VALUE");
        // }

        $user_info = $this->backend->get_user_info_using_api_key($_POST['api_key'], TRUE);
        if(!$user_info) {
            return $this->failed("User does not exist");
        }

        $initial_info = $this->backend->insert_on_actor_education($_POST, $user_info['id']);
        if($initial_info) {
            return $this->success("Successfully saved");
        } else {
            return $this->failed("ERROR_SAVING");
        }
    }

    protected function actor_experience_level() {
        // if(!isset($_POST['email'], $_POST['phone'], $_POST['password'], $_POST['user_type']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['password']) || empty($_POST['user_type'])) {
        //  return $this->failed("INVALID_PARAMETER_VALUE");
        // }

        $user_info = $this->backend->get_user_info_using_api_key($_POST['api_key'], TRUE);
        if(!$user_info) {
            return $this->failed("User does not exist");
        }

        $initial_info = $this->backend->insert_on_actor_exp_level($_POST, $user_info['id']);
        if($initial_info) {
            return $this->success("Successfully saved");
        } else {
            return $this->failed("ERROR_SAVING");
        }
    }

    protected function actor_work_details() {
        // if(!isset($_POST['email'], $_POST['phone'], $_POST['password'], $_POST['user_type']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['password']) || empty($_POST['user_type'])) {
        //  return $this->failed("INVALID_PARAMETER_VALUE");
        // }

        $user_info = $this->backend->get_user_info_using_api_key($_POST['api_key'], TRUE);
        if(!$user_info) {
            return $this->failed("User does not exist");
        }

        $initial_info = $this->backend->insert_on_actor_work_details($_POST, $user_info['id']);
        if($initial_info) {
            return $this->success("Successfully saved");
        } else {
            return $this->failed("ERROR_SAVING");
        }
    }

    protected function actor_extra_info() {
        // if(!isset($_POST['email'], $_POST['phone'], $_POST['password'], $_POST['user_type']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['password']) || empty($_POST['user_type'])) {
        //  return $this->failed("INVALID_PARAMETER_VALUE");
        // }

        $user_info = $this->backend->get_user_info_using_api_key($_POST['api_key'], TRUE);
        if(!$user_info) {
            return $this->failed("User does not exist");
        }

        $initial_info = $this->backend->insert_on_actor_extra_info($_POST, $user_info['id']);
        if($initial_info) {
            return $this->success("Successfully saved");
        } else {
            return $this->failed("ERROR_SAVING");
        }
    }
}

$instance = new kalakaar_api_call();
$instance->execute();