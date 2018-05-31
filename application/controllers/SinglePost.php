<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SinglePost extends CI_Controller {

	public function __construct(){
        parent::__construct();

		//$this->load->helper('form');
		
		$this->load->model(array('model_home'));
		

		
    }


	public function index()
	{
		
		
		$dataHead['title'] = '';
		
		
		
	}

	public function showPost() {
		$id = $this->uri->segment(2); 

		$data['postinfo'] = $this->model_home->get_dataSingle('tg_dastan',$id);
		$data['votes'] = $this->model_home->get_count_votes($id);
		$data['rating'] = $this->model_home->get_rating($id);
		$dataHead['title'] = "";
		
		if($data['postinfo']) {
			foreach ($data['postinfo'] as $item) {
			$dataHead['title'] = $item['name'];
			$view =  $item['views'];
		}
		$this->load->view('sitePage-head',$dataHead);
		$this->load->view('single',$data);
		$this->load->view('page-footer');
		$this->model_home->update_view($id,$view);
	}else {
	$this->load->view('404');	
	}
	}


	public function add_rate() {
		$ipaddress = $_SERVER['REMOTE_ADDR'];
		$pid = $this->uri->segment(2); ;
		$rate = $_POST["rate"];

		$this->model_home->update_rate($pid,$rate,$ipaddress);
			
	}

public function add_rate_mob() {
		$ipaddress = $_SERVER['REMOTE_ADDR'];
		$pid = $_GET["pid"];
		$rate = $_GET["rate"];
$info['status'] = "ok";
		if($this->model_home->update_rate_mob($pid,$rate,$ipaddress)) echo json_encode($info,true);
			
	}
}
