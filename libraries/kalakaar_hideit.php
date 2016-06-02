<?php
/**
 * Encryption Decryption
 *
 * open_ssl for encryption decryption of password
 * also used on generating api key
 * @author: bcorpuzjr
 */

class Kalakaar_hideit {
    private $method;
    private $salt;

    public function __construct($method = 'aes-128-cbc', $salt = '') {
        $this->method = $method;
        $this->salt = $salt;
    }

    public function encrypt($pass, $plain, $iv) {
        $encrypted = openssl_encrypt($plain, $this->method, $this->salt.$pass.$this->salt, false, substr(sha1($iv), 3, 16));
        return $encrypted;
    }

    public function decrypt($pass, $encrypted, $iv) {
        $decrypted = openssl_decrypt($encrypted, $this->method, $this->salt.$pass.$this->salt, false, substr(sha1($iv), 3, 16));
        return $decrypted;
    }
}