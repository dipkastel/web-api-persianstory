<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class JsonArchive extends CI_Controller {
	public function __construct(){
        parent::__construct();
		$this->load->model(array('model_json'));
		header('Content-Type: application/json');
		$this->load->library('pagination');	
    }


	public function index()
	{
		
		
	}

	public function page()
	{
		$config = array();
		$config['base_url'] = base_url() . '/JsonArchive/page/';
		$config['total_rows'] = $this->model_json->get_countPage('tg_dastan');
		$config["per_page"] = 10;
		$config['use_page_numbers'] = TRUE;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		if($page >= 1) $page = ( $page * $config["per_page"] ) - $config["per_page"];
		$data['posts'] = $this->model_json->get_archive('tg_dastan',$config["per_page"],$page);
		$info = array();
		$info['posts'] = $data['posts'];



		$info['upload_url'] = $this->config->item('upload_url');
		echo json_encode($info,true);
	}
}
