<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NotFound extends CI_Controller {

	public function __construct(){
        parent::__construct();


		
    }


	public function index()
	{
		
		
		$this->load->view('404');
		if(isset($_GET['s'])) {
			redirect('search/'.$_GET['s']);
		}
	}

	
	
}
