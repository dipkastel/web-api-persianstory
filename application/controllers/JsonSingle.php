<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class JsonSingle extends CI_Controller {
	public function __construct(){
        parent::__construct();
		$this->load->model(array('model_json'));
		header('Content-Type: application/json');
    }


	public function index()
	{
		
		
	}

	public function pid()
	{
		$pid = $this->uri->segment(3);
		$data['post'] = $this->model_json->get_dataSingle('tg_dastan',$pid);
		$info = array();
		$data['rate'] = $this->model_json->calc_rate($pid);
		$info['post'] = $data['post'];
		$info['rate'] = round($data['rate'],1);
		$info['upload_url'] = $this->config->item('upload_url');
		echo json_encode($info,true);
	}
}
