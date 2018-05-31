<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Uploadfile extends CI_Controller {

	public function __construct(){
        parent::__construct();
		$this->load->database();

    }
	
	public function index()
	{


		$code = "tG1121bsdfgkjslgjsdfohgsdfhgsdfjsdfgsjdfgdhgfsdagsudtgyws";
		$data = array(
			'name'   => $_GET['name'],
			'type'   => $_GET['type'],
			'size'   => $_GET['size']
			
		);
		if($_GET['code'] == $code)
			$this->db->insert('tg_uploads', $data);
	}

	
	public function delup() {
	$name = $_GET['name'];

   $this->db->where('name', $name);
   $code = "dghfdgjsdfghdfhjgjfgjghdTiu";
   if($_GET['code'] == $code)
   $this->db->delete('tg_uploads'); 

	}

}

