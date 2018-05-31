<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Model_webSetting extends CI_Model {
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
	
	

	
	public function get_data($table,$field) {
		
		$this->db->from($table);
		return $this->db->get()->row($field);
		
	}

	public function upload_url($val) {
		
		$upload_url = "http://localhost/upload/files/";
		return $upload_url.$val;
		
	}

	

	
}