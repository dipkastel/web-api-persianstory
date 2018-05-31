<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Sec_model extends CI_Model {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	public function check_login() {

		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			return true;
		} else {
			return false;
		}
	}
}
