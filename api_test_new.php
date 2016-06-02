INITIAL SIGNUP
<form method="POST">
	Method Name: <input type="text" name="method_name" value="user_initial_signup" /><br />
	Email: <input type="text" name="email" value="" /><br />
	Phone: <input type="text" name="phone" value="" /><br />
	Password: <input type="text" name="password" value="" /><br />
	User Type: <input type="text" name="user_type" value="" /><br />
	<input type="submit" name="signup" value="Call" />
</form>

<?php

// $url = 'http://kalakaar.tipstatweb.com/kalakaar_api_call/';
// $method_used = "actor_basic_info";
// $url .= $method_used;
// $api_key = 'zyxvnTPpzNIJ/TfwuqOdJalMEPx2UAKwmvdM2rLTHi3B7WYjdzzum5RpXSAKQjC7';

// $arr['api_key'] = $api_key;
// $arr['json_data'] = json_encode(array(
// 	"name" => 'aaaasample_name',
// 	"gender" => 'agender',
// 	"age" => '112',
// 	"self_description" => 'asome more text',
// ));

// $object_json = json_encode($_POST);
// // print_r($arr);

// $req = curl_init($url);
// curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($req, CURLOPT_POST, true );
// curl_setopt($req, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($req, CURLOPT_POSTFIELDS, $arr);
// $respCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
// $resp = curl_exec($req);
// $http_status = curl_getinfo($req, CURLINFO_HTTP_CODE);
// curl_close($req);

// print_r($resp);
// exit();


// $url = 'http://kalakaar.tipstatweb.com/kalakaar_api_call/';
// $method_used = "actor_specification";
// $url .= $method_used;
// $api_key = 'zyxvnTPpzNIJ/TfwuqOdJalMEPx2UAKwmvdM2rLTHi3B7WYjdzzum5RpXSAKQjC7';

// $arr['api_key'] = $api_key;
// $arr['json_data'] = json_encode(array(
// 	"body_type" => 1,
// 	"ethnicity" => 2,
// 	"hair_color" => 3,
// 	"hair_length" => 4,
// 	"eye_color" => 5,
// 	"skin_tone" => 6,
// 	"facial_hair" => 7,
// 	"height" => 8,
// 	"weight" => 9,
// 	"shoe_size" => 10,
// 	"waist_size" => 11,
// 	"chest_size" => 12,
// ));

// // $object_json = json_encode($_POST);
// // print_r($arr);

// $req = curl_init($url);
// curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($req, CURLOPT_POST, true );
// curl_setopt($req, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($req, CURLOPT_POSTFIELDS, $arr);
// $respCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
// $resp = curl_exec($req);
// $http_status = curl_getinfo($req, CURLINFO_HTTP_CODE);
// curl_close($req);

// print_r($resp);
// exit();

// $url = 'http://kalakaar.tipstatweb.com/kalakaar_api_call/';
// $method_used = "actor_skills";
// $url .= $method_used;
// $api_key = 'zyxvnTPpzNIJ/TfwuqOdJalMEPx2UAKwmvdM2rLTHi3B7WYjdzzum5RpXSAKQjC7';

// $arr['api_key'] = $api_key;
// $arr['json_data'] = json_encode(array(
// 	"skills" => "1,4,56,21,3"
// ));

// // $object_json = json_encode($_POST);
// // print_r($arr);

// $req = curl_init($url);
// curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($req, CURLOPT_POST, true );
// curl_setopt($req, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($req, CURLOPT_POSTFIELDS, $arr);
// $respCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
// $resp = curl_exec($req);
// $http_status = curl_getinfo($req, CURLINFO_HTTP_CODE);
// curl_close($req);

// print_r($resp);
// exit();

// $url = 'http://kalakaar.tipstatweb.com/kalakaar_api_call/';
// $method_used = "actor_description";
// $url .= $method_used;
// $api_key = 'zyxvnTPpzNIJ/TfwuqOdJalMEPx2UAKwmvdM2rLTHi3B7WYjdzzum5RpXSAKQjC7';

// $arr['api_key'] = $api_key;
// $arr['json_data'] = json_encode(array(
// 	"self_description" => "Sample a"
// ));

// // $object_json = json_encode($_POST);
// // print_r($arr);

// $req = curl_init($url);
// curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($req, CURLOPT_POST, true );
// curl_setopt($req, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($req, CURLOPT_POSTFIELDS, $arr);
// $respCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
// $resp = curl_exec($req);
// $http_status = curl_getinfo($req, CURLINFO_HTTP_CODE);
// curl_close($req);

// print_r($resp);
// exit();


// $url = 'http://kalakaar.tipstatweb.com/kalakaar_api_call/';
// $method_used = "actor_education";
// $url .= $method_used;
// $api_key = 'l/J/X+cqGdlaPbSjW8wqbPxVSWUHQTb7cT8Rr8g4Rex4GswOBgnBhmh9UemIjgxd';

// $arr['api_key'] = $api_key;
// $arr['json_data'] = json_encode(array(
// 	"education" => array(array("education_level" => "Bachelor", "institute" => "Sample institute", "state" => "sample state", "city" => "sample city", "year" => "1990", "school_details" => "School was blah blah blah"), 
// 								 array("education_level" => "Master", "institute" => "Some institute", "state" => "some state", "city" => "some city", "year" => "2010", "school_details" => "Masters degree blah blah blah"))
// ));


// // $object_json = json_encode($_POST);
// // print_r($arr);
// // exit();

// $req = curl_init($url);
// curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($req, CURLOPT_POST, true );
// curl_setopt($req, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($req, CURLOPT_POSTFIELDS, $arr);
// $respCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
// $resp = curl_exec($req);
// $http_status = curl_getinfo($req, CURLINFO_HTTP_CODE);
// curl_close($req);

// print_r($resp);
// exit();

// $url = 'http://kalakaar.tipstatweb.com/kalakaar_api_call/';
// $method_used = "actor_experience_level";
// $url .= $method_used;
// $api_key = 'l/J/X+cqGdlaPbSjW8wqbPxVSWUHQTb7cT8Rr8g4Rex4GswOBgnBhmh9UemIjgxd';

// $arr['api_key'] = $api_key;
// $arr['json_data'] = json_encode(array(
// 	"experience_level" => "experienced",
// ));


// // $object_json = json_encode($_POST);
// // print_r($arr);
// // exit();

// $req = curl_init($url);
// curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($req, CURLOPT_POST, true );
// curl_setopt($req, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($req, CURLOPT_POSTFIELDS, $arr);
// $respCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
// $resp = curl_exec($req);
// $http_status = curl_getinfo($req, CURLINFO_HTTP_CODE);
// curl_close($req);

// print_r($resp);
// exit();

// $url = 'http://kalakaar.tipstatweb.com/kalakaar_api_call/';
// $method_used = "actor_work_details";
// $url .= $method_used;
// $api_key = 'l/J/X+cqGdlaPbSjW8wqbPxVSWUHQTb7cT8Rr8g4Rex4GswOBgnBhmh9UemIjgxd';

// $arr['api_key'] = $api_key;
// $arr['json_data'] = json_encode(array(
// 	"work_experience" => array(array("work_title" => "new work", "work_description" => "work description", "work_url" => array("newwork.com", "aaaa.com/aa")),
// 								array("work_title" => "some work", "work_description" => "some work description", "work_url" => array("work.com", "somework.com/method", "aa.com"))
// 								),
// ));


// // $object_json = json_encode($_POST);
// // print_r($arr);
// // exit();

// $req = curl_init($url);
// curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($req, CURLOPT_POST, true );
// curl_setopt($req, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($req, CURLOPT_POSTFIELDS, $arr);
// $respCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
// $resp = curl_exec($req);
// $http_status = curl_getinfo($req, CURLINFO_HTTP_CODE);
// curl_close($req);

// print_r($resp);
// exit();


// $url = 'http://kalakaar.tipstatweb.com/kalakaar_api_call/';
// $method_used = "actor_extra_info";
// $url .= $method_used;
// $api_key = 'l/J/X+cqGdlaPbSjW8wqbPxVSWUHQTb7cT8Rr8g4Rex4GswOBgnBhmh9UemIjgxd';

// $arr['api_key'] = $api_key;
// $arr['json_data'] = json_encode(array(
// 	"alt_contact" => '4532453454',
// 	"location" => 'somewhere',
// ));


// // $object_json = json_encode($_POST);
// // print_r($arr);
// // exit();

// $req = curl_init($url);
// curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($req, CURLOPT_POST, true );
// curl_setopt($req, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($req, CURLOPT_POSTFIELDS, $arr);
// $respCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
// $resp = curl_exec($req);
// $http_status = curl_getinfo($req, CURLINFO_HTTP_CODE);
// curl_close($req);

// print_r($resp);
// exit();


if($_POST) {
	$url = 'http://kalakaar.tipstatweb.com/kalakaar_api_call/';
	$method_used = $_POST['method_name'];
	$url .= $method_used;

	$arr['json_data'] = json_encode(array(
		'email' => $_POST['email'],
	 	'phone' => $_POST['phone'],
	 	'password' => $_POST['password'],
	 	'user_type' => $_POST['user_type'],
	));

	// $object_json = json_encode($_POST);
	print_r($arr);

	$req = curl_init($url);
	curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($req, CURLOPT_POST, true );
	curl_setopt($req, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($req, CURLOPT_POSTFIELDS, $arr);
	$respCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
	$resp = curl_exec($req);
	$http_status = curl_getinfo($req, CURLINFO_HTTP_CODE);
	curl_close($req);

	print_r($resp);
	exit();
}