<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Model_site extends CI_Model {
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
	

	public function all_est() {
		$lastpost = $this->db->select('id')->order_by('date DESC')->limit(10)->get('estates')->result_array();		
		$idarr = array();
		foreach ($lastpost as $key => $value) {
			$idarr[] = "'{$value['id']}'";
		}
		$ids = implode(',', $idarr);
		$sql = "select id,date,status from estates join est_meta on estates.id=est_meta.est_id where estates.id in($ids)
		AND estates.status in ('PUBLISH')";
		$allpost = $this->db->query($sql)->result_array();
		$posts = array();
		foreach ($allpost as $key => $value) {
			$postid =  $value['id'];
			$sql = "select * from est_meta where est_id=?";
			$sql = $this->db->query($sql, $postid);
			$row = $sql->result_array();
			foreach ($row as $key => $valuee) {
				$posts[$postid][$valuee['meta_slug']] = $valuee['meta_value'];
			}
			$posts[$postid]['id'] = $value['id'];
			$posts[$postid]['date'] = $value['date'];
			 	
		}
	return $posts;
	}


	public function all_country($id) {
		
			$sql = "select * from country where type=?";
			$sql = $this->db->query($sql,$id);
			return $sql->result_array(); 	
		
	}
}