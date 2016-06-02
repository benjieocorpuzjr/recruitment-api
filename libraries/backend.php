<?php

require 'libraries/core_backend.php';

/**
 * MAIN BACKEND
 * 
 * Global backend process will go here
 * The developer can extend this backend. to create a new model to separate logic of api process
 *
 * @author: bcorpuzjr
 **/

class backend extends core_backend {
	protected $response = array(
		"error" => "Unknown Error",
		"status" => "1000"
	);

	public function __construct(&$db) {
		parent::__construct($db);
	}

	public function test_select($params) {
		$result = $this->db->fetchAll("SELECT * FROM sample_table WHERE samp_name=?", "s", array($params['samp_name']));
		if($result) {
			return $result;
		} else {
			return FALSE;
		}
	}

	public function test_multiple_insert($params, $multi_data_id = "1900") {
		$error_insert = FALSE;
        $educ_info = $params['education'];
        foreach($educ_info as $educ) {
            $insert_educ = array(
                "d_actor_id" => $multi_data_id,
                "institute" => (isset($educ['institute']) ? $educ['institute'] : ""), 
                "state" => (isset($educ['state']) ? $educ['state'] : ""),
                "school_description" => (isset($educ['school_details']) ? $educ['school_details'] : ""),
            );

            if(!$this->db->insert("dummy_actor_education", "isss", $insert_educ)) {
            	$error_insert = TRUE;
            }
        }

        return $error_insert;
	}

	public function test_get_data($params) {
		$result = $this->db->fetchAll("SELECT * FROM dummy_actor_education WHERE id=?", "i", array($params['multi_data_id']));
		if($result) {
			return $result;
		} else {
			return FALSE;
		}
	}

	public function test_multiple_images($files, $actor_id, $post) {
		if($files && count($files) > 0) {
            $path = realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR;

            for($i=1;$i<=count($files);$i++) {
                $pcs = explode('.', $post['fileName_'.$i]);
                $ext = strtolower(end($pcs));
                $file_name = "samples.".$i."-".date('Ymd-His').".".$ext;
                if(move_uploaded_file($files['actor_image_'.$i]['tmp_name'], $path.$file_name)) {
                	$arr = array("d_actor_id" => $actor_id, "path_file" => $path.$file_name, "filename" => $file_name);
                    $this->db->insert("dummy_actor_images", 'iss', $arr);
                    $this->success('Image successfully saved');
                } else {
                    $this->failed('Error saving image');
                }
            }
        }
	}

	public function check_if_user_not_exist($params = NULL, $is_fb = FALSE) {
		$result = $this->db->fetchRow("SELECT * FROM user_information WHERE email = ? OR phone = ?", "ss", array($params['email'], $params['phone']));
		if($result) {
			if($is_fb) {
				return ($result['is_fb'] == 1 ? "fb" : FALSE);
			} else {
				return FALSE;
			}
		} else {
			return TRUE;
		}
	}

	public function check_if_user_exist($params = NULL) {
		$result = $this->db->fetchRow("SELECT * FROM user_information WHERE email = ? OR phone = ?", "ss", array($params['email'], $params['phone']));
		if($result) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function get_user_info_using_api_key($api_key, $return_info = FALSE) {
		$result = $this->db->fetchRow("SELECT u.* FROM user_information u LEFT JOIN user_type ut ON u.user_type = ut.id WHERE api_key = ?", "s", array($api_key));
		if($result) {
			if(!$return_info) {
				return TRUE;
			} else {
				return $result;
			}
		} else {
			$this->response['error'] = "api_key does not exist";
			return FALSE;
		}
	}

	public function update_pasword_fb($params) {
		if($this->db->update("UPDATE user_information SET password=?, phone=? WHERE email=?", "sss", array($params['password'], $params['phone'], $params['email']))) {
			 return TRUE;
        } else {
        	return FALSE;
        }
	}

	// public function initial_signup($params = NULL) {
	// 	$pass_key = $this->generate_key("user_information", "pass_key");
	// 	$otp = $this->generate_otp();

	// 	// if(is_null($params['password']) || empty($params['password'])) {
	// 	// 	$password  = $this->generate_otp(TRUE);
	// 	// 	$insert_arr = array(
	// 	// 		"email" => $params['email'], 
	// 	// 		"phone" => (!isset($params['phone']) ? "" : $params['phone']), 
	// 	// 		"password" => $this->encrypt($password), 
	// 	// 		"user_type" => (!isset($params['user_type']) ? "" : $params['user_type']), 
	// 	// 		"is_fb" => 1
	// 	// 	);
	// 	// 	$this->db->insert("user_information", "sssss", array("email" => $params['email'], "phone" => (!isset($params['phone']) ? "" : $params['phone']), "password" => $this->encrypt($password), "user_type" => (!isset($params['user_type']) ? "" : $params['user_type']), "is_fb" => 1), TRUE);
	// 	// 	$this->send_mail($params['email'], "Kalakaar password", "You passord for kalakaar: ".$password);
	// 	// 	return TRUE;
	// 	// }

	// 	if($this->db->insert("user_information", "ssssss", array("email" => $params['email'], "phone" => $params['phone'], "password" => $this->encrypt($params['password']), "pass_key" => $pass_key, "otp" => $otp, "user_type" => $params['user_type']), TRUE)) {
	// 		$return_keys = array(
	// 			"otp" => $otp,
	// 			"pass_key" => $pass_key,
	// 		);

	// 		$message = "Thank you! Your One time password: ".$otp;

	// 		if($this->send_sms($params['phone'], $message) && $this->send_mail($params['email'], "One Time Password", $message)) {
	// 			return $return_keys;
	// 		} else {
	// 			$this->response['error'] = "Information has been saved. failed to send sms or email";
	// 			return FALSE;
	// 		}
	// 	} else {
	// 		$this->response['error'] = "Failure to save information";
	// 		return FALSE;
	// 	}
	// }

	public function initial_signup($params = NULL) {
		$pass_key = $this->generate_key("user_information", "pass_key");
		$otp = $this->generate_otp();
		if($this->db->insert("user_information", "ssssss", array("email" => $params['email'], "phone" => $params['phone'], "password" => $this->encrypt($params['password']), "pass_key" => $pass_key, "otp" => $otp, "user_type" => $params['user_type']), TRUE)) {
			$return_keys = array(
				"otp" => $otp,
				"pass_key" => $pass_key,
			);

			$message = "Thank you! Your One time password: ".$otp;

			if($this->send_sms($params['phone'], $message) && $this->send_mail($params['email'], "One Time Password", $message)) {
				return $return_keys;
			} else {
				$this->response['error'] = "Information has been saved. failed to send sms or email";
				return FALSE;
			}
		} else {
			$this->response['error'] = "Failure to save information";
			return FALSE;
		}
	}

	public function verify_otp($params) {
		$result = $this->db->fetchRow("SELECT * FROM user_information WHERE pass_key = ? OR otp = ?", "ss", array($params['pass_key'], $params['otp']));
		if($result) {
			$api_key = $this->generate_key();
			if($this->db->update("UPDATE user_information SET api_key=?, is_verified=? WHERE id=?", "sis", array($api_key, 1, $result['id']))) {
				return array("api_key" => $api_key, "user_type" => $result['user_type']);
			} else {
				$this->response['error'] = "Failure to save api_key on database";
				return FALSE;
			}
		} else {
			$this->response['error'] = "Wrong OTP";
			return FALSE;
		}
	}

	public function get_user_type_list() {
		$result = $this->db->fetchAll("SELECT * FROM user_type");
		return $result;
	}

	public function save_actor_other_info($params, $files, $user_id) {
		$result = $this->db->fetchRow("SELECT * FROM actor_basic_information WHERE user_id = ?", "s", array($user_id));
		if(!$result) {
			$insert_basic_data = array(
				"user_id" => $user_id,
				"name" => $params['name'],
				"gender" => $params['gender'],
				"age" => $params['age'],
				"self_description" => $params['self_description'],
			);
			// INSER BASIC INFO
			$actor_id = $this->db->insert("actor_basic_information", "issss", $insert_basic_data, TRUE);
			if($actor_id) {
				// INSERT SPECIFICATIONS
				$insert_specs_data = array(
					"actor_id" => $actor_id,
					"body_type" => $params['body_type'],
					"ethnicity" => $params['ethnicity'],
					"hair_color" => $params['hair_color'],
					"hair_length" => $params['hair_length'],
					"eye_color" => $params['eye_color'],
					"skin_tone" => $params['skin_tone'],
					"facial_hair" => $params['facial_hair'],
					"height" => $params['height'],
					"weight" => $params['weight'],
					"shoe_size" => $params['shoe_size'],
					"waist_size" => $params['waist_size'],
					"chest_size" => $params['chest_size'],
				);
				$this->db->insert("actor_specification", "iiiiiiiiiiiii", $insert_specs_data);

				// INSERT SKILLS
				$skills_id = explode(',', $params['skills']);
				foreach($skills_id as $skill_id) {
					$this->db->insert("actor_skills", "ii", array("actor_id" => $actor_id, "skills" => $skill_id));
				}

				// INSERT EDUCATION
				$this->insert_education($params['education'], $actor_id);

				// INSERT IMAGES
				$this->insert_actor_images($files);

				// INSERT WORK EXPERIENCE (details, url and image)
				// $this->insert_work_experience($params['work_experience'], $actor_id);

				// INSERT IMAGE HERE
				return TRUE;
			} else {
				echo "Error saving information";
				return FALSE;
			}
		} else {
			echo "Already has a basic information. use update instead";
			return FALSE;
		}
	}

	private function insert_actor_images($files, $params) {
		$path = realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR;
        // $path = 'id_upload'.DIRECTORY_SEPARATOR;
        // if(!is_dir($path)) {
        //     mkdir($path);
        // }
        $pcs = explode('.', $_POST['fileName']);
        $ext = strtolower(end($pcs));
        $file_name = "samples.".$ext;
        if(move_uploaded_file($_FILES['file']['tmp_name'], $path.$file_name)) {
            $this->success('Image successfully saved');
        } else {
            $this->failed('Error saving image');
        }
	}

	private function insert_education($params, $actor_id) {
		foreach($params as $educ) {
			$insert_educ = array(
				"actor_id" => $actor_id,
				"education_level" => $educ['education_level'],
				"institute" => $educ['institute'],
				"state" => $educ['state'],
				"city" => $educ['city'],
				"year" => $educ['year'],
				"school_details" => $educ['school_details'],
			);

			$this->db->insert("actor_education", "issssss", $insert_educ);
		}
	}

	private function insert_work_experience($params, $actor_id) {
		print_r($params);
		foreach($params as $work) {
			$insert_educ = array(
				"actor_id" => $actor_id,
				"work_title" => $work['work_title'],
				"work_description" => $work['work_description'],
			);
			$work_id = $this->db->insert("actor_work_details", "iss", $insert_educ, TRUE);
			if(isset($work['work_url']) && count($work['work_url']) > 0) {
				foreach($work['work_url'] as $url) {
					$this->db->insert("actor_work_url", "iis", array("actor_id" => $actor_id, "work_id" => $work_id, "url" => $url));
				}
			}
			// insert work image here
		}
	}

	public function save_dummy_actor_other_info($params, $files) {
		$insert_basic_data = array(
			"gender" => $params['gender'],
			"location" => $params['location'],
			"name" => $params['name'],
			"uploader" => $params['uploader'],
		);

		// INSER BASIC INFO
		$actor_id = $this->db->insert("dummy_actor_basic_information", "ssss", $insert_basic_data, TRUE);
		if($actor_id) {
			// INSERT SKILLS
			$skills_id = explode(',', $params['skills']);
			foreach($skills_id as $skill_id) {
				$this->db->insert("dummy_actor_skills", "ii", array("d_actor_id" => $actor_id, "skills" => $skill_id));
			}

			// INSERT EDUCATION
			if(isset($params['education'])) {
				$educ_info = $params['education'];
				foreach($educ_info as $educ) {
					$insert_educ = array(
						"d_actor_id" => $actor_id,
						"institute" => $educ['institute'],
						"state" => $educ['state'],
						"school_description" => $educ['school_details'],
					);

					$this->db->insert("dummy_actor_education", "isss", $insert_educ);
				}
			}

			// INSERT IMAGES
			$this->insert_dummy_actor_images($files, $actor_id);

			// INSERT WORK EXPERIENCE (details, url and image)
			// $this->insert_work_experience($params['work_experience'], $actor_id);

			// INSERT IMAGE HERE
			return TRUE;
		} else {
			echo "Error saving information";
			return FALSE;
		}
	}

	private function insert_dummy_actor_images($files, $actor_id) {
		if($files && count($files) > 0) {
            $path = realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR;

            for($i=1;$i<=count($files);$i++) {
                $pcs = explode('.', $_POST['fileName_'.$i]);
                $ext = strtolower(end($pcs));
                $file_name = "samples.".$i."-".date('Ymd-His').".".$ext;
                if(move_uploaded_file($files['actor_image_'.$i]['tmp_name'], $path.$file_name)) {
                	$arr = array("d_actor_id" => $actor_id, "path_file" => $path.$file_name, "filename" => $file_name);
                    $this->db->insert("dummy_actor_images", 'iss', $arr);
                    $this->success('Image successfully saved');
                } else {
                    $this->failed('Error saving image');
                }
            }
        }
	}

	public function user_login($params, $column) {
		$login_info = $this->db->fetchRow("SELECT * FROM user_information WHERE $column = ? AND is_verified = 1", "s", array($params['username']));
		if($login_info) {
			if($this->decrypt($login_info['password']) === $params['password']) {
				return array("api_key" => $login_info['api_key'], "user_type" => $login_info['user_type']);
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	public function reset_send_otp($username, $column) {
		$login_info = $this->db->fetchRow("SELECT * FROM user_information WHERE $column = ?", "s", array($username));
		if($login_info) {
			$otp = $this->generate_otp();
			$reset_key = $this->generate_key("user_information", "pass_key");
			if($this->db->update("UPDATE user_information SET pass_key=?, otp=? WHERE id=?", "ssi", array($reset_key, $otp, $login_info['id']))) {
				$message = "Your Reset One time password: ".$otp;

				if($this->send_sms($login_info['phone'], $message) && $this->send_mail($login_info['email'], "Reset password", $message)) {
					return $reset_key;
				} else {
					$this->response['error'] = "Information has been saved. failed to send sms or email";
					return FALSE;
				}
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	public function reset_resend_otp($reset_key) {
		$login_info = $this->db->fetchRow("SELECT * FROM user_information WHERE pass_key=?", "s", array($reset_key));
		if($login_info) {
			$message = "Your Reset One time password: ".$login_info['otp'];
			if($this->send_sms($login_info['phone'], $message) && $this->send_mail($login_info['email'], "Reset password", $message)) {
				return $reset_key;
			} else {
				$this->response['error'] = "Information has been saved. failed to send sms or email";
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	public function reset_otp_validation($params) {
		$login_info = $this->db->fetchRow("SELECT * FROM user_information WHERE pass_key=? AND otp=?", "ss", array($params['reset_key'], $params['otp']));
		if($login_info) {
			$reset_pw_key = $this->generate_key("user_information", "reset_pw_key");
			$this->db->update("UPDATE user_information SET reset_pw_key=? WHERE id=?", "si", array($reset_pw_key, $login_info['id']));
			return $reset_pw_key;
		} else {
			return FALSE;
		}
	}

	public function reset_pw_update($params) {
		$login_info = $this->db->fetchRow("SELECT * FROM user_information WHERE reset_pw_key=?", "s", array($params['pass_reset_key']));
		if($login_info) {
			$password = $this->encrypt($params['password']);
			$this->db->update("UPDATE user_information SET password=? WHERE id=?", "si", array($password, $login_info['id']));
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function get_latest_option_update() {
		$result = $this->db->fetchRow("SELECT * FROM opt_date_updated ORDER BY id DESC");
		return $result;
	}

	public function get_all_options() {
		$opt_list = array();
		$results = $this->db->fetchAll("SELECT * FROM opt_list");
		foreach($results as $list) {
			if($list['opt_table'] != "opt_skills") {
				$opt_list[$list['opt_table']] = $this->db->fetchAll("SELECT * FROM ".$list['opt_table']);
			} else {
				$opt_list[$list['opt_table']] = $this->db->fetchAll("SELECT
																	  s.id,
																	  s.skill_name,
																	  c.skill_category,
																	  sc.sub_category
																	FROM opt_skills s
																	  LEFT JOIN opt_skills_category c
																	    ON s.category_id = c.id
																	  LEFT JOIN opt_skills_sub_category sc
																	    ON s.sub_category_id = sc.id");
			}

			
		}

		return $opt_list;
	}

	// Actor basic info
	public function insert_on_actor_basic_info($params, $user_id) {
		$result = $this->db->fetchRow("SELECT * FROM actor_basic_information WHERE user_id = ?", "s", array($user_id));
		if(!$result) {
			$insert_basic_data = array(
				"user_id" => $user_id,
				"name" => $params['name'],
				"gender" => $params['gender'],
				"age" => $params['age'],
			);
			// INSERT BASIC INFO
			$actor_id = $this->db->insert("actor_basic_information", "isss", $insert_basic_data, TRUE);
			return TRUE;
		} else {
			$type = "";
			$col_params = array();

			if(isset($params['name'])) {
				$update_basic_data['name'] = $params['name'];
				$type .= "s";
				$col_params[] = "name=?";
			}
			if(isset($params['gender'])) {
				$update_basic_data['gender'] = $params['gender'];
				$type .= "s";
				$col_params[] = "gender=?";
			}
			if(isset($params['age'])) {
				$update_basic_data['age'] = $params['age'];
				$type .= "i";
				$col_params[] = "age=?";
			}

			$cols = implode(',', $col_params);
			$type .= "i";
			$update_basic_data['actor_id'] = $result['id'];

			// UPDATE BASIC INFO
			if($this->db->update("UPDATE actor_basic_information SET ".$cols." WHERE id=?", $type, $update_basic_data)) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
	}

	// Actor basic info
	public function insert_on_actor_skills($params, $user_id) {
		$result = $this->db->fetchRow("SELECT * FROM actor_basic_information WHERE user_id = ?", "s", array($user_id));
		if($result) {
			$actor_id = $result['id'];
			// $s_result = $this->db->fetchRow("SELECT * FROM actor_skills WHERE user_id = ?", "s", array($user_id));
			// if($s_result) {
				// INSERT SPECIFICATIONS
				$skills_id = explode(',', $params['skills']);
				foreach($skills_id as $skill_id) {
					$this->db->insert("actor_skills", "ii", array("actor_id" => $actor_id, "skills" => $skill_id));
				}

				return TRUE;
			// } else {
			// 	// UPDATE HERE
			// }
		} else {
			return FALSE;
		}
	}

	// Actor basic info
	public function insert_on_actor_specification($params, $user_id) {
		$result = $this->db->fetchRow("SELECT * FROM actor_basic_information WHERE user_id = ?", "s", array($user_id));
		if($result) {
			$actor_id = $result['id'];
			// $s_result = $this->db->fetchRow("SELECT * FROM actor_specification WHERE user_id = ?", "s", array($user_id));
			// if($s_result) {
				// INSERT SPECIFICATIONS
				$insert_specs_data = array(
					"actor_id" => $actor_id,
					"body_type" => $params['body_type'],
					"ethnicity" => $params['ethnicity'],
					"hair_color" => $params['hair_color'],
					"hair_length" => $params['hair_length'],
					"eye_color" => $params['eye_color'],
					"skin_tone" => $params['skin_tone'],
					"facial_hair" => $params['facial_hair'],
					"height" => $params['height'],
					"weight" => $params['weight'],
					"shoe_size" => $params['shoe_size'],
					"waist_size" => $params['waist_size'],
					"chest_size" => $params['chest_size'],
				);

				$this->db->insert("actor_specification", "iiiiiiiiiiiii", $insert_specs_data);
				return TRUE;
			// } else {
				// UPDATE HERE
			// }
		} else {
			return FALSE;
		}
	}

	public function insert_on_actor_description($params, $user_id) {
		$result = $this->db->fetchRow("SELECT * FROM actor_basic_information WHERE user_id = ?", "s", array($user_id));
		if($result) {
			$actor_id = $result['id'];
			if($this->db->update("UPDATE actor_basic_information SET self_description=? WHERE id=?", "ss", array($params['self_description'], $actor_id))) {
				return TRUE;
			}
		} else {
			return FALSE;
		}
	}

	public function insert_on_actor_education($params, $user_id) {
		$result = $this->db->fetchRow("SELECT * FROM actor_basic_information WHERE user_id = ?", "s", array($user_id));
		if($result) {
			$actor_id = $result['id'];
			$this->insert_education($params['education'], $actor_id);
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function insert_on_actor_exp_level($params, $user_id) {
		$result = $this->db->fetchRow("SELECT * FROM actor_basic_information WHERE user_id = ?", "s", array($user_id));
		if($result) {
			$actor_id = $result['id'];
			if($this->db->update("UPDATE actor_basic_information SET experience_level=? WHERE id=?", "ss", array($params['experience_level'], $actor_id))) {
				return TRUE;
			}
		} else {
			return FALSE;
		}
	}

	public function insert_on_actor_work_details($params, $user_id) {
		$result = $this->db->fetchRow("SELECT * FROM actor_basic_information WHERE user_id = ?", "s", array($user_id));
		if($result) {
			$actor_id = $result['id'];
			$this->insert_work_experience($params['work_experience'], $actor_id);
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function insert_on_actor_extra_info($params, $user_id) {
		$result = $this->db->fetchRow("SELECT * FROM actor_basic_information WHERE user_id = ?", "s", array($user_id));
		if($result) {
			$actor_id = $result['id'];
			if($this->db->update("UPDATE actor_basic_information SET alt_contact=?, location=? WHERE id=?", "ssi", array($params['alt_contact'], $params['location'], $actor_id))) {
				return TRUE;
			}
		} else {
			return FALSE;
		}
	}

}