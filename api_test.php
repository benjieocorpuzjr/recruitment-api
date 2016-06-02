INITIAL SIGNUP
<form method="POST">
	Method Name: <input type="text" name="method_name" value="user_initial_signup" /><br />
	Email: <input type="text" name="email" value="" /><br />
	Phone: <input type="text" name="phone" value="" /><br />
	Password: <input type="text" name="password" value="" /><br />
	User Type: <input type="text" name="user_type" value="" /><br />
	<input type="submit" name="signup" value="Call" />
</form>
<form method="POST">
	Method Name: <input type="text" name="method_name" value="test_call" /><br />
	Samp Data: <input type="text" name="samp_name" value="" /><br />
	Samp Data 2:<input type="text" name="samp" value="" /><br />
	<input type="submit" name="select" value="Call" />
</form>
<form method="POST">
	Method Name: <input type="text" name="method_name" value="test_call" /><br />
	Samp Data: <input type="text" name="samp_name" value="" /><br />
	Samp Data 2:<input type="text" name="samp" value="" /><br />
	<input type="submit" name="select" value="Call" />
</form>
<form method="POST">
	Method Name: <input type="text" name="method_name" value="test_call" /><br />
	Samp Data: <input type="text" name="samp_name" value="" /><br />
	Samp Data 2:<input type="text" name="samp" value="" /><br />
	<input type="submit" name="select" value="Call" />
</form>
<br />=============================================<br />

<form method="POST">
	Method Name: <input type="text" name="method_name" value="test_call" /><br />
	Samp Data: <input type="text" name="samp_name" value="" /><br />
	Samp Data 2:<input type="text" name="samp" value="" /><br />
	<input type="submit" name="select" value="Call" />
</form>
<br />=============================================<br />
Get User Type List
<form method="POST">
	Method Name: <input type="text" name="method_name" value="get_user_type_list" /><br />
	<input type="submit" name="get_user_type_list" value="Call" />
</form>

Get latest update
<form method="POST">
	Method Name: <input type="text" name="method_name" value="get_latest_option_update" /><br />
	<input type="submit" name="get_latest_option_update" value="Call" />
</form>

Get all options
<form method="POST">
	Method Name: <input type="text" name="method_name" value="get_all_options" /><br />
	<input type="submit" name="get_all_options" value="Call" />
</form>
<br />=============================================<br />
INITIAL SIGNUP
<form method="POST">
	Method Name: <input type="text" name="method_name" value="user_initial_signup" /><br />
	Email: <input type="text" name="email" value="" /><br />
	Phone: <input type="text" name="phone" value="" /><br />
	Password: <input type="text" name="password" value="" /><br />
	User Type: <input type="text" name="user_type" value="" /><br />
	<input type="submit" name="signup" value="Call" />
</form>

VERIFY SIGNUP
<form method="POST">
	Method Name: <input type="text" name="method_name" value="verify_otp" /><br />
	OTP: <input type="text" name="otp" value="" /><br />
	Pass key: <input type="text" name="pass_key" value="" /><br />
	<input type="submit" name="verify_otp" value="Call" />
</form>

User Login
<form method="POST" enctype="multipart/form-data">
	Method Name: <input type="text" name="method_name" value="user_login" /><br />
	Username: <input type="text" name="username" value="" /><br />
	Password: <input type="text" name="password" value="" /><br />
	<input type="submit" name="user_login" value="Call" />
</form>
<br />=============================================<br />
Reset password
<form method="POST" enctype="multipart/form-data">
	Method Name: <input type="text" name="method_name" value="reset_password_send_otp" /><br />
	Username: <input type="text" name="username" value="" /><br />
	<input type="submit" name="reset_password_send_otp" value="Call" />
</form>

Resend reset otp
<form method="POST" enctype="multipart/form-data">
	Method Name: <input type="text" name="method_name" value="reset_password_resend_otp" /><br />
	Reset key: <input type="text" name="reset_key" value="" /><br />
	<input type="submit" name="reset_password_resend_otp" value="Call" />
</form>

Reset OTP Validation
<form method="POST" enctype="multipart/form-data">
	Method Name: <input type="text" name="method_name" value="reset_otp_validation" /><br />
	Reset key: <input type="text" name="reset_key" value="" /><br />
	OTP: <input type="text" name="otp" value="" /><br />
	<input type="submit" name="reset_otp_validation" value="Call" />
</form>

Reset Password Change
<form method="POST" enctype="multipart/form-data">
	Method Name: <input type="text" name="method_name" value="reset_pw_update" /><br />
	Password Reset key: <input type="text" name="pass_reset_key" value="" /><br />
	Password: <input type="text" name="password" value="" /><br />
	<input type="submit" name="reset_pw_update" value="Call" />
</form>
<br />=============================================<br />
Save actor other information
<form method="POST">
	Method Name: <input type="text" name="method_name" value="send_image_test" /><br />
	<input type="submit" name="actor_signup_other_info" value="Call" />
</form>

Run image upload
<form method="POST" enctype="multipart/form-data">
	Method Name: <input type="text" name="method_name" value="send_multiple_image_test" /><br />
	<input name="files_info" type="file" />
	<input name="files_info1" type="file" />
	<input type="submit" name="aaaactor_signup_other_info" value="Call" />
</form>

<?php
if($_POST) {
	if(isset($_POST['aaaactor_signup_other_info'])) {
		$url = 'http://localhost/kalakaar/kalakaar_api_call.php';
        $filePath = $_FILES['files_info']['tmp_name'];
        $fileName = $_FILES['files_info']['name'];
        $method = $_POST['method_name'];
        $data = array(
        	'method' => $method,
        	"name" => "Some name",
        	"gender" => "male",
        	"uploader" => "bcorpuzjr",
        	"location" => "123,34230",
        	"skills" => "3,5,10,4,30",
			// "education" => array(array("institute" => "Sample institute", "state" => "sample state", "school_details" => "School was blah blah blah"), 
			// 					 array("institute" => "Some institute", "state" => "some state", "school_details" => "Masters degree blah blah blah")),
        	'actor_image_1' => "@$filePath",
        	'fileName_1' => $fileName,
        	'actor_image_2' => "@".$_FILES['files_info1']['tmp_name'],
        	'fileName_2' => $_FILES['files_info1']['name'],
        	'actor_image_3' => "@$filePath",
        	'fileName_3' => $fileName
        );

        // curl_setopt($ch, CURLOPT_URL, 'http://localhost/kalakaar/kalakaar_api_call.php');
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        // curl_exec($ch);
        // curl_close($ch);

        $req = curl_init($url);
		curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($req, CURLOPT_POST, true );
		curl_setopt($req, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($req, CURLOPT_POSTFIELDS, $data);
		$respCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
		$resp = curl_exec($req);
		$http_status = curl_getinfo($req, CURLINFO_HTTP_CODE);
		curl_close($req);

		print_r($resp);
		exit();
	}

	$resp = "";
	$additional_array = array();
	// $url = 'http://kalakaar.tipstatweb.com/kalakaar_api_call.php';
	// $url = 'http://kalakaar.tipstatweb.com/live/kalakaar_api_call.php';


	$url = 'http://localhost/kalakaar/kalakaar_api_call/';
	// $url = 'http://localhost/kalakaar/kalakaar_admin_api.php';
	$method_used = $_POST['method_name'];
	$object_array = array('method' => $method_used);
	$url .= $method_used;

	if(isset($_POST['select'])) {
		 $additional_array = array(
		 	'samp_name' => $_POST['samp_name'],
		 	'samp' => $_POST['samp'],
		 );
	} else if(isset($_POST['signup'])) {
		// SAMPLE RESPONSE: {"respmsg":"User successfully signed up","otp":"6361461f","pass_key":"+4Xr3J1DXqYJZBpGg2\/Jr\/WL\/pIfzVDhSI2+6sBhdFtf5xIQHe6tHyZc\/xrE0nlG","respcode":"0000","status":"success"}
		 $additional_array = array(
		 	'email' => $_POST['email'],
		 	'phone' => $_POST['phone'],
		 	'password' => $_POST['password'],
		 	'user_type' => $_POST['user_type'],
		 );
	} else if(isset($_POST['verify_otp'])) {
		$additional_array = array(
		 	'otp' => $_POST['otp'],
		 	'pass_key' => $_POST['pass_key'],
		);
	} else if(isset($_POST['user_login'])) {
		$additional_array = array(
		 	'username' => $_POST['username'],
		 	'password' => $_POST['password'],
		);
	} else if(isset($_POST['reset_password_send_otp'])) {
		$additional_array = array(
		 	'username' => $_POST['username'],
		);
	} else if(isset($_POST['reset_password_resend_otp'])) {
		$additional_array = array(
		 	'reset_key' => $_POST['reset_key'],
		);
	} else if(isset($_POST['reset_otp_validation'])) {
		$additional_array = array(
		 	'reset_key' => $_POST['reset_key'],
		 	'otp' => $_POST['otp'],
		);
	} else if(isset($_POST['reset_pw_update'])) {
		$additional_array = array(
		 	'pass_reset_key' => $_POST['pass_reset_key'],
		 	'password' => $_POST['password'],
		);
	}

	if(isset($_POST['actor_signup_other_info'])) {
		$api_key = "Dbx3nsT8coE3QyUe6NBePoYTOxgF3AEn96bDcwg3y1eaeb238aJkOOGuZSHMrk9c";

		$additional_array = array(
			"api_key" => $api_key,
			"name" => "Sample actor",
			"alt_contact" => "23543534",
			"location" => "23003, 10292",
			"gender" => "Male",
			"age" => "20",
			"self_description" => "A lorem ipsum actor blah blah blah",
			"body_type" => 1,
			"ethnicity" => 1,
			"hair_color" => 2,
			"hair_length" => 2,
			"eye_color" => 3,
			"skin_tone" => 3,
			"facial_hair" => 1,
			"height" => 2,
			"weight" => 3,
			"shoe_size" => 4,
			"waist_size" => 5,
			"chest_size" => 6,
			"skills" => "3,5,10,4,30",

			"education" => array(array("education_level" => "Bachelor", "institute" => "Sample institute", "state" => "sample state", "city" => "sample city", "year" => "1990", "school_details" => "School was blah blah blah"), 
								 array("education_level" => "Master", "institute" => "Some institute", "state" => "some state", "city" => "some city", "year" => "2010", "school_details" => "Masters degree blah blah blah")),
			"work_experience" => array(
									array("work_title" => "new work", "work_description" => "work description", "work_url" => array("newwork.com", "aaaa.com/aa")),
									array("work_title" => "some work", "work_description" => "some work description", "work_url" => array("work.com", "somework.com/method", "aa.com"))
									),

			'actor_images' => array('@'.$_FILES['files_info']['tmp_name'].';filename='.basename($_FILES['files_info']['name']), '@'.$_FILES['files_info']['tmp_name'].';filename='.basename($_FILES['files_info']['name'])),
		);

		// $tmpfile = $_FILES['userfile']['tmp_name'];
	 	//    $filename = basename($_FILES['userfile']['name']);

	    // $data = array(
	    //     'files_info' => '@'.$_FILES['userfile']['tmp_name'].';filename='.basename($_FILES['imauserfilege_upload']['name']),
	    // );
	}

	if(count($additional_array) > 0)
		$object_array = array_merge($object_array, $additional_array);

	$object_json = json_encode($object_array);
	print_r($object_json);

	$req = curl_init($url);
	curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($req, CURLOPT_POST, true );
	curl_setopt($req, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($req, CURLOPT_POSTFIELDS, $object_json);
	$respCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
	$resp = curl_exec($req);
	$http_status = curl_getinfo($req, CURLINFO_HTTP_CODE);
	curl_close($req);

	print_r($resp);
	exit();
}