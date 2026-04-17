<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'third_party/JWT/src/JWTExceptionWithPayloadInterface.php';
require_once APPPATH . 'third_party/JWT/src/JWT.php';
require_once APPPATH . 'third_party/JWT/src/Key.php';
require_once APPPATH . 'third_party/JWT/src/BeforeValidException.php';
require_once APPPATH . 'third_party/JWT/src/ExpiredException.php';
require_once APPPATH . 'third_party/JWT/src/SignatureInvalidException.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Jwt_lib {
    protected $CI;
    protected $secret;
    protected $alg = 'HS256';
    protected $leeway = 60; // 1 min clock skew

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->config->load('config', TRUE);
        $this->secret = $this->CI->config->item('jwt_secret', 'config');
        if (empty($this->secret)) {
            log_message('error', 'JWT: No secret configured in config.php');
        }
        JWT::$leeway = $this->leeway;
    }

    /**
     * Generate JWT token
     */
    public function encode($payload) {
        if (empty($this->secret)) {
            return false;
        }
        $payload['iat'] = time();
        $payload['exp'] = time() + (60 * 60); // 1 hour
        try {
            return JWT::encode($payload, $this->secret, $this->alg);
        } catch (Exception $e) {
            log_message('error', 'JWT Encode Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Decode and verify JWT token
     */
    public function decode($token) {
        if (empty($this->secret)) {
            return false;
        }
        try {
            $decoded = JWT::decode($token, new Key($this->secret, $this->alg));
            return $decoded;
        } catch (Exception $e) {
            log_message('error', 'JWT Decode Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get user_id from verified token
     */
    public function get_user_id($token) {
        $decoded = $this->decode($token);
        return $decoded ? ($decoded->user_id ?? false) : false;
    }
}
?>

