Sample table test call
<form method="POST">
	Method Name: <input type="text" name="method_name" value="test_call" /><br />
	Samp Data: <input type="text" name="samp_name" value="" /><br />
	<input type="submit" name="test_call" value="Call" />
</form>
<br />=============================================<br />
Test success
<form method="POST">
	Method Name: <input type="text" name="method_name" value="test_true_resp" /><br />
	<input type="submit" name="test_true_resp" value="Call" />
</form>

Test false
<form method="POST">
	Method Name: <input type="text" name="method_name" value="test_false_resp" /><br />
	<input type="submit" name="test_false_resp" value="Call" />
</form>

Multiple data
<form method="POST">
	Method Name: <input type="text" name="method_name" value="test_multi_data" /><br />
	<input type="submit" name="test_multi_data" value="Call" />
</form>

GET Multiple data
<form method="POST">
	Method Name: <input type="text" name="method_name" value="test_get_multi_data" /><br />
	<input type="submit" name="test_get_multi_data" value="Call" />
</form>

Multiple Image upload
<form method="POST" enctype="multipart/form-data">
	Method Name: <input type="text" name="method_name" value="test_multi_images" /><br />
	File 1: <input name="files_info" type="file" /><br />
	File 1: <input name="files_info1" type="file" /><br />
	<input type="submit" name="test_multi_images" value="Call" />
</form>

<?php
if($_POST) {
	$resp = "";
	$additional_array = array();
	// $url = 'http://kalakaar.tipstatweb.com/kalakaar_api_call.php';
	// $url = 'http://kalakaar.tipstatweb.com/live/kalakaar_api_call.php';
	$url = 'http://localhost/kalakaar/kalakaar_api_call/';
	// $url = 'http://kalakaar.tipstatweb.com/kalakaar_api_call/';
	// $url = 'http://localhost/kalakaar/kalakaar_admin_api.php';
	$method_used = $_POST['method_name'];
	$object_array = array('method' => $method_used);
	$url .= $method_used;

	if(isset($_POST['test_multi_images'])) {
        $filePath = $_FILES['files_info']['tmp_name'];
        $fileName = $_FILES['files_info']['name'];
        $additional_array = array(
        	'actor_image_id' => '23',
        	'actor_image_1' => "@$filePath",
        	'fileName_1' => $fileName,
        	'actor_image_2' => "@".$_FILES['files_info1']['tmp_name'],
        	'fileName_2' => $_FILES['files_info1']['name'],
        	// 'actor_image_3' => "@$filePath",
        	// 'fileName_3' => $fileName
        );

        if(count($additional_array) > 0)
			$object_array = array_merge($object_array, $additional_array);

        $req = curl_init($url);
		curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($req, CURLOPT_POST, true );
		curl_setopt($req, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($req, CURLOPT_POSTFIELDS, $object_array);
		$respCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
		$resp = curl_exec($req);
		$http_status = curl_getinfo($req, CURLINFO_HTTP_CODE);
		curl_close($req);

		print_r($resp);
		exit();
	} else if(isset($_POST['test_false_resp'])) {

	} else if(isset($_POST['test_true_resp'])) {

	} else if(isset($_POST['test_call'])) {
		$additional_array = array(
			"samp_name" => $_POST['samp_name'],
		);
	} else if(isset($_POST['test_multi_data'])) {
		$additional_array['multi_data_id'] = 90;
 		$additional_array["education"] = array(array("institute" => "Sample institute", "state" => "sample state", "school_details" => "School was blah blah blah"), 
						     				   array("institute" => "Some institute", "state" => "some state", "school_details" => "Masters degree blah blah blah")
						     				   );
	} else if(isset($_POST['test_get_multi_data'])) {
		$additional_array['multi_data_id'] = 1;
	}

	if(count($additional_array) > 0)
		$object_array = array_merge($object_array, $additional_array);

	$req = curl_init($url);
	curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($req, CURLOPT_POST, true );
	curl_setopt($req, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($req, CURLOPT_POSTFIELDS, http_build_query($object_array));
	$respCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
	$resp = curl_exec($req);
	$http_status = curl_getinfo($req, CURLINFO_HTTP_CODE);
	curl_close($req);

	print_r($resp);
	exit();


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

	$req = curl_init($url);
	curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($req, CURLOPT_POST, true );
	curl_setopt($req, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($req, CURLOPT_POSTFIELDS, http_build_query($object_array));
	$respCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
	$resp = curl_exec($req);
	$http_status = curl_getinfo($req, CURLINFO_HTTP_CODE);
	curl_close($req);

	print_r($resp);
	exit();
}