<?php

/**
 * CORE BACKEND
 * 
 * Predefined backend process will go here
 * Do not change anything in here. We need to discuss before changing any process here
 * All backend should be written backend.php
 * 
 * @author: bcorpuzjr
 **/ 

class Core_backend {
	protected $db;
	protected $salt;
	protected $hideit;
	protected $response;

	protected function __construct(&$db) {
		$this->salt = "@Be8Zn30";
		$this->db = $db;

        require_once dirname(__DIR__) . '/libraries/kalakaar_hideit.php';
        $this->hideit = new kalakaar_hideIt();
	}

	protected function success($message, $additional_response = array()) {
        $this->response = array(
            'ResponseCode' => "0000",
            'ResponseMessage' => $message,
        );

        $this->response['additional_response'] = $additional_response;
        return TRUE;
    }

    protected function failed($message) {
        $this->response = array(
            'ResponseCode' => "0001",
            'ResponseMessage' => $message,
        );
        return FALSE;
    }
    
    public function get_response() {
        return $this->response;
    }

    public function encrypt($data) {
        $result = $this->hideit->encrypt($this->key(), $data, sha1(md5($this->salt)));
        return $result;
    }

    public function decrypt($data) {
        $result = $this->hideit->decrypt($this->key(), $data, sha1(md5($this->salt)));
        return $result;
    }

	public function generate_key($table = "user_information", $column = "api_key") {
        do {
            $api_key = md5(uniqid(time(), true));
            $api_key = $this->hideit->encrypt($this->key(), $api_key, sha1(md5($this->salt)));
            $check = $this->db->fetchRow("SELECT id from ".$table." where ".$column." = ?", "s", array($api_key));
        } while (isset($check['id']));

        return $api_key;
    }

    public function generate_otp($include = FALSE) {
        if(!$include)
            return rand(1000, 9999);
        else
            return rand(1000, 9999).substr(uniqid(), 1, 4);
    }

    public function send_mail($to, $subject, $message) { // can be switched to PHPmailer or SwiftMailer
        // return TRUE; // by pass email phone sending
        require "phpmailer/class.phpmailer.php"; // added here to only load when needed

        //PHPMailer Object
        $mail = new PHPMailer;

        //From email address and name
        $mail->From = "no-reply@tipstat.com";
        $mail->FromName = "Kalakaar no-reply";

        //To address and name
        $mail->addAddress($to);
        // $mail->addAddress("recepient1@example.com"); //Recipient name is optional

        //Send HTML or Plain Text email
        $mail->isHTML(true);

        $mail->Subject = $subject;
        $mail->Body = $message;
        // $mail->AltBody = "This is the plain text version of the email content";

        if(!$mail->send())  {
            // echo "Mailer Error: " . $mail->ErrorInfo;
            return FALSE;
        } else {
            // echo "Message has been sent successfully";
            return TRUE;
        }
    }

    public function send_sms($to, $message) {
        // return TRUE; // by pass email phone sending
        $authKey = settings::$sms_api_key;
        $mobileNumber = $to; // Multiple mobiles numbers separated by comma
        $senderId = "VERIFY"; // Sender ID, While using route4 sender id should be 6 characters long.
        $message = urlencode($message);
        $route = 4; // Define route 

        // Prepare you post parameters
        $postData = array(
            'authkey' => $authKey,
            'mobiles' => $mobileNumber,
            'message' => $message,
            'sender' => $senderId,
            'route' => $route
        );
        
        //API URL
        $url = settings::$sms_endpoint;

        // init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData
        ));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec($ch);
        
        if(curl_errno($ch)) {
            echo 'error:' . curl_error($ch);
            return FALSE;
        }

        $respCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $sms_logs = array(
            "output" => json_encode($output),
            "respCode" => json_encode($respCode),
            "http_status" => json_encode($http_status),
        );
        $this->db->insert("sms_logs", "sss", $sms_logs);

        curl_close($ch);

        return TRUE;
    }

    public function key() {
        // return empty for now. for added security we can add keys in here.
        return "";
    }
}